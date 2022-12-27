<?php

namespace App\Controllers;

class HubunganSDAKL extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function index()
    {
        $dataModel = new \App\Models\HubunganSDAKLModel();

        $data = $dataModel->select('*')
            ->join('master_data', 'hubungan_sdakl.id_master_data=master_data.id')
            ->join('kode_wilayah', 'hubungan_sdakl.kode_wilayah=kode_wilayah.kode_wilayah')
            ->orderBy('hubungan_sdakl.id_master_data', 'asc')
            ->get();

        return view('hubunganSDAKL/index', [
            'title' => 'Hubungan Sumber Daya Alam - Kondisi Lingkungan',
            'category' => 'Menu Hubungan Sumber Daya Alam - Kondisi Lingkungan',
            'data' => $data,
        ]);
    }

    public function import()
    {
        if ($this->request->getPost()) {
            $fileName = $_FILES["csv"]["tmp_name"];

            if ($_FILES['csv']['size'] > 0) {
                $file = fopen($fileName, "r");

                $modelMasterData = new \App\Models\MasterDataModel();
                $dataMaster = [
                    'nama' => $this->request->getPost('nama'),
                ];

                $modelMasterData->save($dataMaster);
                $id_masterData = $modelMasterData->insertID();

                $modelData = new \App\Models\HubunganSDAKLModel();

                $builder = $modelData->builder();

                $data = array();

                while (!feof($file)) {
                    $column = fgetcsv($file, 1000, ";");

                    if (empty($column)) {
                        $column = null;
                    } else {
                        $kode_wilayah = $column[0];
                        $dampak_SDAKL = $column[1];
                        $pengelolaan_SDAKL = $column[2];
                    }

                    $row = [
                        'id_master_data' => $id_masterData,
                        'kode_wilayah' => $kode_wilayah,
                        'dampak_SDAKL' => $dampak_SDAKL,
                        'pengelolaan_SDAKL' => $pengelolaan_SDAKL
                    ];

                    array_push($data, $row);
                }

                $builder->insertBatch($data);
                fclose($file);
            }

            return redirect()->to(site_url('HubunganSDAKL/index'));
        }
        return view('hubunganSDAKL/import', [
            'title' => 'Hubungan Sumber Daya Alam - Kondisi Lingkungan',
            'category' => 'Menu Hubungan Sumber Daya Alam - Kondisi Lingkungan',
        ]);
    }

}
