<?php
$csv = [
    'name' => 'csv',
    'id' => 'csv'
];

$nama = [
    'name' => 'nama',
    'id' => 'nama',
    'class' => 'form-control',
    'value' => null,
];

$submit = [
    'name' => 'submit',
    'id' => 'submit',
    'value' => 'Submit',
    'class' => 'btn btn-primary',
    'type' => 'submit'
];
?>
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?= form_open_multipart('KondisiLingkungan/import') ?>
                <div class="form-group">
                    <?= form_label("Nama", "nama") ?>
                    <?= form_input($nama) ?>
                </div>
                <?= form_upload($csv) ?>
                <?= form_submit($submit) ?>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>