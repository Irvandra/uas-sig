<?php

namespace App\Controllers;

class Maps extends BaseController
{
    public function index()
    {
        helper('form');

        $kondisiLingkunganmodel = new \App\Models\KondisiLingkunganModel();
        $aktivitasManusiamodel = new \App\Models\AktivitasManusiaModel();
        $sumberDayaAlamModel = new \App\Models\SumberDayaAlamModel();

        $fileName = base_url('maps/map.geojson');
        $file = file_get_contents($fileName);
        $file = json_decode($file);

        $features = $file->features;

        $idMasterData = 1;
        if($this->request->getPost())
        {
            $idMasterData = $this->request->getPost('master');
        }

        foreach($features as $index=>$feature)
        {
            $kode_wilayah = $feature->properties->kode;
            $sumberDayaAlam = $sumberDayaAlamModel->where('id_master_data', $idMasterData)
                    ->where('kode_wilayah', $kode_wilayah)
                    ->first();
            $kondisiLingkungan = $kondisiLingkunganmodel->where('id_master_data', $idMasterData)
                    ->where('kode_wilayah', $kode_wilayah)
                    ->first();
            $aktivitasManusia = $aktivitasManusiamodel->where('id_master_data', $idMasterData)
                    ->where('kode_wilayah', $kode_wilayah)
                    ->first();

            $nilaiMax = 0;
            if ($sumberDayaAlam) {
                $features[$index]->properties->jenis_sumber_daya = $sumberDayaAlam->jenis_sumber_daya;
                $features[$index]->properties->kondisi = $sumberDayaAlam->kondisi;
                $features[$index]->properties->nilai = $sumberDayaAlam->ketersediaan;
                $nilaiMax = $sumberDayaAlamModel->select('MAX(ketersediaan) AS ketersediaan')->where('id_master_data', $idMasterData)->first()->ketersediaan;
            } else if ($kondisiLingkungan) {
                $features[$index]->properties->kualitas_air = $kondisiLingkungan->kualitas_air;
                $features[$index]->properties->kualitas_udara = $kondisiLingkungan->kualitas_udara;
                $features[$index]->properties->keanekaragaman_hayati = $kondisiLingkungan->keanekaragaman_hayati;
                
            } else if ($aktivitasManusia) {
                $features[$index]->properties->jenis_aktivitas = $aktivitasManusia->jenis_aktivitas;
                $features[$index]->properties->nilai = $aktivitasManusia->intensitas;
                $features[$index]->properties->dampak_potensial = $aktivitasManusia->dampak_potensial;
                $nilaiMax = $aktivitasManusiamodel->select('MAX(intensitas) AS intensitas')->where('id_master_data', $idMasterData)->first()->intensitas;
            }
        }

        $masterDataModel = new \App\Models\MasterDataModel();
        $masterData = $masterDataModel->find($idMasterData);

        $allMasterData = $masterDataModel->findAll();
        
        $masterDataMenu = [];

        foreach($allMasterData as $md)
        {
            $masterDataMenu[$md->id] = $md->nama;
        }

        return view('maps/index', [
            'title' => 'Halaman Peta',
            'category' => 'Menu Halaman Peta',
            'sumberDayaAlam' => $sumberDayaAlam,
            'kondisiLingkungan' => $kondisiLingkungan,
            'aktivitasManusia' => $aktivitasManusia,
            'features' => $features,
            'nilaiMax' => $nilaiMax,
            'masterData' => $masterData,
            'masterDataMenu' => $masterDataMenu
        ]);
    }
}
