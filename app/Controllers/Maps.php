<?php

namespace App\Controllers;

class Maps extends BaseController
{
    public function index()
    {
        return view('maps/index', [
            'title' => 'Halaman Peta',
            'category' => 'Menu Halaman Peta',
        ]);
    }
}
