<?php

namespace App\Controllers;

class KondisiLingkungan extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function index()
    {
        $dataModel = new \App\Models\KondisiLingkunganModel();

        $data = $dataModel->select('*')
            ->join('master_data', 'kondisi_lingkungan.id_master_data=master_data.id')
            ->join('kode_wilayah', 'kondisi_lingkungan.kode_wilayah=kode_wilayah.kode_wilayah')
            ->orderBy('kondisi_lingkungan.id_master_data', 'asc')
            ->get();

        return view('kondisiLingkungan/index', [
            'title' => 'Kondisi Lingkungan',
            'category' => 'Menu Kondisi Lingkungan',
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

                $modelData = new \App\Models\KondisiLingkunganModel();

                $builder = $modelData->builder();

                $data = array();

                while (!feof($file)) {
                    $column = fgetcsv($file, 1000, ";");

                    if (empty($column)) {
                        $column = null;
                    } else {
                        $kode_wilayah = $column[0];
                        $kualitas_air = $column[1];
                        $kualitas_udara = $column[2];
                        $keanekaragaman_hayati = $column[3];
                    }
                    
                    $row = [
                        'id_master_data' => $id_masterData,
                        'kode_wilayah' => $kode_wilayah,
                        'kualitas_air' => $kualitas_air,
                        'kualitas_udara' => $kualitas_udara,
                        'keanekaragaman_hayati' => $keanekaragaman_hayati,
                    ];

                    array_push($data, $row);
                }

                $builder->insertBatch($data);
                fclose($file);
            }

            return redirect()->to(site_url('KondisiLingkungan/index'));
        }
        return view('kondisiLingkungan/import', [
            'title' => 'Tambah Data Kondisi Lingkungan',
            'category' => 'Menu Tambah Data Kondisi Lingkungan',
        ]);
    }
}
