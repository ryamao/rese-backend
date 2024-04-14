<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditStoredShop
{
    public function edit(Request $request, User $owner, Shop $shop): void
    {
        /** @var string $name */
        $name = $request->input('name');
        $areaName = $request->input('area');
        $genreName = $request->input('genre');
        /** @var string $detail */
        $detail = $request->input('detail');

        $area = Area::firstOrCreate(['name' => $areaName]);
        $genre = Genre::firstOrCreate(['name' => $genreName]);

        $shop->name = $name;
        $shop->area_id = $area->id;
        $shop->genre_id = $genre->id;
        $shop->detail = $detail;

        if ($request->hasFile('image')) {
            /** @var \Illuminate\Http\UploadedFile $image */
            $image = $request->file('image');
            $imageName = $shop->id.'.'.$image->extension();
            $imagePath = $image->storeAs('shop_images', $imageName);
            if ($imagePath) {
                $shop->image_url = Storage::url($imagePath);
            } else {
                abort(500);
            }
        }

        $shop->save();
    }
}
