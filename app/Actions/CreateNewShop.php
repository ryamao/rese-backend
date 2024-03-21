<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CreateNewShop
{
    public function create(Request $request, User $owner): Shop
    {
        $name = $request->input('name');
        $areaName = $request->input('area');
        $genreName = $request->input('genre');
        $detail = $request->input('detail');
        $image = $request->file('image');

        assert($image instanceof UploadedFile);

        $area = Area::firstOrCreate(['name' => $areaName]);
        $genre = Genre::firstOrCreate(['name' => $genreName]);

        $shop = $owner->ownedShops()->create([
            'name' => $name,
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'detail' => $detail,
            'image_url' => '',
        ]);

        $imageName = $shop->id.'.'.$image->extension();
        $imagePath = $image->storeAs('shop_images', $imageName, 'public');

        if ($imagePath) {
            $shop->update(['image_url' => env('APP_URL').Storage::url($imagePath)]);

            return $shop;
        } elseif (! $imagePath) {
            $shop->delete();
            abort(500);
        }
    }
}
