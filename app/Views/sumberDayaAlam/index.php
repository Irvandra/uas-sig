<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="<?= site_url('SumberDayaAlam/import') ?>" class="btn btn-primary">Tambah Data</a>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Master Data</th>
                                <th>Nama Wilayah</th>
                                <th>Jenis Sumber Daya</th>
                                <th>Kondisi</th>
                                <th>Ketersediaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data->getResult() as $key => $value) : ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= $value->nama ?></td>
                                    <td><?= $value->nama_wilayah ?></td>
                                    <td><?= $value->jenis_sumber_daya ?></td>
                                    <td><?= $value->kondisi ?></td>
                                    <td><?= $value->ketersediaan ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>