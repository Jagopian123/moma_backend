<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
    public function active()
    {
        $banner = Banner::active()->latest()->first();

        if (!$banner) {
            return response()->json(['data' => null]);
        }

        return response()->json([
            'data' => [
                'id'                => $banner->id,
                'image_url'         => $banner->image_url,
                'link_url'          => $banner->link_url,
                'display_frequency' => $banner->display_frequency,
            ],
        ]);
    }
}
