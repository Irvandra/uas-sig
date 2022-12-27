<?php

namespace App\Controllers;

class SumberDayaAlam extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function index()
    {
        $sumberDayaAlamModel = new \App\Models\SumberDayaAlamModel();

        $data = $sumberDayaAlamModel->select('*')
            ->join('master_data', 'sumber_daya_alam.id_master_data=master_data.id')
            ->join('kode_wilayah', 'sumber_daya_alam.kode_wilayah=kode_wilayah.kode_wilayah')
            ->orderBy('sumber_daya_alam.id_master_data', 'asc')
            ->get();

        return view('sumberDayaAlam/index', [
            'title' => 'Sumber Daya Alam',
            'category' => 'Menu Sumber Daya Alam',
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
                $idMasterData = $modelMasterData->insertID();

                $modelSumberDayaAlam = new \App\Models\SumberDayaAlamModel();

                $builder = $modelSumberDayaAlam->builder();

                $data = array();

                while (!feof($file)) {
                    $column = fgetcsv($file, 1000, ";");

                    if (empty($column)) {
                        $column = null;
                    }else {
                        $kode_wilayah = $column[0];
                        $jenis_sumber_daya = $column[1];
                        $kondisi = $column[2];
                        $ketersediaan = $column[3];
                    }

                    $row = [
                        'id_master_data' => $idMasterData,
                        'kode_wilayah' => $kode_wilayah,
                        'jenis_sumber_daya' => $jenis_sumber_daya,
                        'kondisi' => $kondisi,
                        'ketersediaan' => $ketersediaan,
                    ];

                    array_push($data, $row);
                }

                $builder->insertBatch($data);
                fclose($file);
            }

            return redirect()->to(site_url('SumberDayaAlam/index'));
        }
        return view('sumberDayaAlam/import', [
            'title' => 'Tambah Sumber Daya Alam',
            'category' => 'Menu Tambah Sumber Daya Alam',
        ]);
    }
}
