<?php

namespace App\Controllers;

class Maps extends BaseController
{
    public function index()
    {
        $sumberDayaAlamModel = new \App\Models\SumberDayaAlamModel();

        $fileName = base_url('maps/map.geojson');
        $file = file_get_contents($fileName);
        $file = json_decode($file);

        $features = $file->features;

        foreach($features as $index=>$feature)
        {
            $kode_wilayah = $feature->properties->kode;
            $sumberDayaAlam = $sumberDayaAlamModel->where('id_master_data', 1)
                    ->where('kode_wilayah', $kode_wilayah)
                    ->first();

            if ($sumberDayaAlam) {
                $features[$index]->properties->jenis_sumber_daya = $sumberDayaAlam->jenis_sumber_daya;
                $features[$index]->properties->kondisi = $sumberDayaAlam->kondisi;
                $features[$index]->properties->nilai = $sumberDayaAlam->ketersediaan;
                $nilaiMax = $sumberDayaAlamModel->select('MAX(ketersediaan) AS ketersediaan')->where('id_master_data', 1)->first()->ketersediaan;
            }
        }

        return view('maps/index', [
            'title' => 'Halaman Peta',
            'category' => 'Menu Halaman Peta',
            'features' => $features,
            'nilaiMax' => $nilaiMax
        ]);
    }
}
