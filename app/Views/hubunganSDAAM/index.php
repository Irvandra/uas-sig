<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="<?= site_url('HubunganSDAAM/import') ?>" class="btn btn-primary">Tambah Data</a>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Master Data</th>
                                <th>Nama Wilayah</th>
                                <th>Dampak SDA-AM</th>
                                <th>Pengelolaan SDA-AM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data->getResult() as $key => $value) : ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= $value->nama ?></td>
                                    <td><?= $value->nama_wilayah ?></td>
                                    <td><?= $value->dampak_SDAAM ?></td>
                                    <td><?= $value->pengelolaan_SDAAM ?></td>
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