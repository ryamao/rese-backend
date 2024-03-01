<?php

namespace App\Console\Commands;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImportShopData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-shop-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import shop data from external source.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Importing shop data...');

        $csvPath = resource_path('data/shops.csv');
        $csvRows = $this->readCsv($csvPath);

        if (! file_exists($this->storagePath())) {
            mkdir($this->storagePath(), 0755, true);
        }

        Artisan::call('migrate:fresh');

        $this->createAreas($csvRows);
        $this->createGenres($csvRows);

        foreach ($csvRows as $row) {
            $externalImagePath = $row[4];
            $storageImagePath = $this->storeImage($externalImagePath);
            if ($storageImagePath) {
                Shop::create([
                    'name' => $row[0],
                    'area_id' => Area::where('name', $row[1])->firstOrFail()->id,
                    'genre_id' => Genre::where('name', $row[2])->firstOrFail()->id,
                    'detail' => $row[3],
                    'image_url' => $storageImagePath,
                ]);
            }
        }
    }

    /**
     * @return \Illuminate\Support\Collection<int, list<string>>
     */
    private function readCsv(string $csvPath): Collection
    {
        $fileObject = new \SplFileObject($csvPath);
        $fileObject->setFlags(\SplFileObject::READ_CSV);

        /** @var \Illuminate\Support\Collection<int, list<string>> $csvRows */
        $csvRows = collect($fileObject)->skip(1);

        return $csvRows;
    }

    /**
     * @param  \Illuminate\Support\Collection<int, list<string>>  $csvRows
     */
    private function createAreas(Collection $csvRows): void
    {
        $areaNames = $csvRows->pluck(1)->unique();
        $areaNames->each(function ($areaName) {
            Area::create(['name' => $areaName]);
        });
    }

    /**
     * @param  \Illuminate\Support\Collection<int, list<string>>  $csvRows
     */
    private function createGenres(Collection $csvRows): void
    {
        $genreNames = $csvRows->pluck(2)->unique();
        $genreNames->each(function ($genreName) {
            Genre::create(['name' => $genreName]);
        });
    }

    private function storeImage(string $externalImagePath): ?string
    {
        $storageImagePath = $this->storagePath(basename($externalImagePath));
        if (file_exists($storageImagePath)) {
            return $this->imageUrl(basename($externalImagePath));
        }

        $this->info('Downloading image from: '.$externalImagePath);
        sleep(3);

        $response = Http::get($externalImagePath);
        if ($response->failed()) {
            return null;
        }

        file_put_contents($storageImagePath, $response);

        return $this->imageUrl(basename($externalImagePath));
    }

    private function storagePath(string $path = ''): string
    {
        return storage_path('app/public/shop_images/').$path;
    }

    private function imageUrl(string $path): string
    {
        return env('APP_URL').Storage::url('shop_images/'.$path);
    }
}
