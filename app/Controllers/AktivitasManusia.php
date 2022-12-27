<?php

namespace App\Controllers;

class AktivitasManusia extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function index()
    {
        $dataModel = new \App\Models\AktivitasManusiaModel();

        $data = $dataModel->select('*')
            ->join('master_data', 'aktivitas_manusia.id_master_data=master_data.id')
            ->join('kode_wilayah', 'aktivitas_manusia.kode_wilayah=kode_wilayah.kode_wilayah')
            ->orderBy('aktivitas_manusia.id_master_data', 'asc')
            ->get();

        return view('aktivitasManusia/index', [
            'title' => 'AktivitasManusia',
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

                $modelData = new \App\Models\AktivitasManusiaModel();

                $builder = $modelData->builder();

                $data = array();

                while (!feof($file)) {
                    $column = fgetcsv($file, 1000, ";");

                    if (empty($column)) {
                        $column = null;
                    } else {
                        $kode_wilayah = $column[0];
                        $jenis_aktivitas = $column[1];
                        $intensitas = $column[2];
                        $dampak_potensial = $column[3];
                    }

                    $row = [
                        'id_master_data' => $id_masterData,
                        'kode_wilayah' => $kode_wilayah,
                        'jenis_aktivitas' => $jenis_aktivitas,
                        'intensitas' => $intensitas,
                        'dampak_potensial' => $dampak_potensial
                    ];

                    array_push($data, $row);
                }

                $builder->insertBatch($data);
                fclose($file);
            }

            return redirect()->to(site_url('AktivitasManusia/index'));
        }
        return view('aktivitasManusia/import', [
            'title' => 'Tambah Data Aktivitas Manusia',
            'category' => 'Menu Tambah Data Aktivitas Manusia',
        ]);
    }

}
