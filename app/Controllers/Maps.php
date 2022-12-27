<?php

namespace App\Controllers;

class Maps extends BaseController
{
    public function index()
    {
        $fileName = base_url('maps/map.geojson');
        $file = file_get_contents($fileName);
        $file = json_decode($file);

        $features = $file->features;

        return view('maps/index', [
            'title' => 'Halaman Peta',
            'category' => 'Menu Halaman Peta',
            'features' => $features
        ]);
    }
}
