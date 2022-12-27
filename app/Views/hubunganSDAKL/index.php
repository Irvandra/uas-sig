<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- <div class="card-header card-header-primary">
                <h4 class="card-title">Data2</h4>
                <p class="card-category">Menu Data2</p>
            </div> -->
            <div class="card-body">
                <a href="<?= site_url('HubunganSDAKL/import') ?>" class="btn btn-primary">Tambah Data</a>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Master Data</th>
                                <th>Nama Wilayah</th>
                                <th>Dampak SDA-Lingkungan</th>
                                <th>Pengelolaan SDA-Lingkungan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data->getResult() as $key => $value) : ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= $value->nama ?></td>
                                    <td><?= $value->nama_wilayah ?></td>
                                    <td><?= $value->dampak_SDAKL ?></td>
                                    <td><?= $value->pengelolaan_SDAKL ?></td>
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