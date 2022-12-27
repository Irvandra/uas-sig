<?php

namespace App\Controllers;

class HubunganSDAAM extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function index()
    {
        $hubunganSDAAMModel = new \App\Models\HubunganSDAAMModel();

        $data = $hubunganSDAAMModel->select('*')
            ->join('master_data', 'hubungan_sdaam.id_master_data=master_data.id')
            ->join('kode_wilayah', 'hubungan_sdaam.kode_wilayah=kode_wilayah.kode_wilayah')
            ->orderBy('hubungan_sdaam.id_master_data', 'asc')
            ->get();

        return view('hubunganSDAAM/index', [
            'title' => 'Aktivitas Manusia',
            'category' => 'Menu Aktivitas Manusia',
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

                $modelData = new \App\Models\HubunganSDAAMModel();

                $builder = $modelData->builder();

                $data = array();

                while (!feof($file)) {
                    $column = fgetcsv($file, 1000, ";");
                    
                    if (empty($column)) {
                        $column = null;
                    }else {
                        $kode_wilayah = $column[0];
                        $dampak_SDAAM = $column[1];
                        $pengelolaan_SDAAM = $column[2];
                    }
                    

                    $row = [
                        'id_master_data' => $id_masterData,
                        'kode_wilayah' => $kode_wilayah,
                        'dampak_SDAAM' => $dampak_SDAAM,
                        'pengelolaan_SDAAM' => $pengelolaan_SDAAM,
                    ];

                    array_push($data, $row);
                }

                $builder->insertBatch($data);
                fclose($file);
            }

            return redirect()->to(site_url('HubunganSDAAM/index'));
        }
        return view('hubunganSDAAM/import', [
            'title' => 'Tambah Aktivitas Manusia',
            'category' => 'Menu Tambah Aktivitas Manusia',
        ]);
    }
}
