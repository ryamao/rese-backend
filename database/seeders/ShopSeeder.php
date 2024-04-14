<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ShopSeeder extends Seeder
{
    use WithoutModelEvents;

    const DIRECTORY_NAME = 'dummy_shop_images';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = resource_path('data/shops.csv');
        $csvRows = $this->readCsv($csvPath);

        Storage::makeDirectory(self::DIRECTORY_NAME);

        $this->createAreas($csvRows);
        $this->createGenres($csvRows);

        foreach ($csvRows as $row) {
            $externalImagePath = $row[4];
            $storageImagePath = $this->storeImage($externalImagePath);
            if ($storageImagePath) {
                $owner = User::factory()->create();
                $owner->assignRole('owner');

                Shop::create([
                    'name' => $row[0],
                    'owner_id' => $owner->id,
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
        $imageName = basename($externalImagePath);
        $storageImagePath = self::DIRECTORY_NAME.'/'.$imageName;

        if (Storage::exists($storageImagePath)) {
            return Storage::url(self::DIRECTORY_NAME.'/'.$imageName);
        }

        $dataImagePath = resource_path('data/'.$imageName);
        Storage::putFileAs(self::DIRECTORY_NAME, new File($dataImagePath), $imageName);

        return Storage::url(self::DIRECTORY_NAME.'/'.$imageName);
    }
}
