<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,200i,400" rel="stylesheet">

    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/stylearyo.css"> -->
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css">

    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <style>
        label {
            width: 220px;
            display: inline-block;
            margin-top: 5px;

        }

        label.error {
            color: red;
            margin-left: 5px;
            font-size: 12px;

        }

        input.error {
            border: 1px solid red;
            font-weight: 300;
            color: red;
        }

        [type="submit"] {
            border-radius: 0;
            background: #1999CC;
            color: white;
            border: none;
            font-weight: 300;
            padding: 10px 0;

        }
    </style>

</head>

<body>
    <div class="wrapper">
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- Input addon -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h5>
                                    <i class="fa fa-database"></i> Pendaftaran Wajib Pajak
                                </h5>
                            </div>
                            <div style="text-align:right"><a href="<?= base_url('/') ?>"><i class="fas fa-angle-double-left"></i>
                                    Kembali ke Form Login</a> &nbsp;</div>

                        </div>

                        <!-- /.card -->
                        <form class="form-horizontal" name="sptpdForm" id="form" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">No. Registrasi Pendaftaran <font color="red">*</font></label>
                                            <div class="col-md-6">
                                                <div class="input">
                                                    <input class="form-control" name="no_register" id="no_register" value="<?= $no_register ?>" style="background-color:bisque;" required />
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <span style="vertical-align:middle; "><img src="<?= base_url('assets/images/reload.png') ?>" title="refresh spt" style="cursor:pointer; " id="btnRefresh"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3"><b>Jenis Pajak</b></label>
                                            <div class="col-md-9">
                                                <div class="input state-disabled">
                                                    <select name="input-jns_pajak" id="input-jns_pajak" class="form-control" onChange="getkegus(this.value);" required>
                                                        <option value="" selected></option>
                                                        <option value="1"> Hotel </option>
                                                        <option value="2"> Restoran </option>
                                                        <option value="3"> Hiburan </option>
                                                        <option value="4"> Reklame </option>
                                                        <option value="5"> Penerangan Jalan Non PLN</option>
                                                        <option value="6"> Penerangan Jalan PLN </option>
                                                        <option value="7"> Parkir </option>
                                                        <option value="8"> Air Tanah </option>
                                                        <!-- <option value="9"> Sarang Burung Walet </option> -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3"><b>Kegiatan Usaha</b></label>
                                            <div class="col-md-9">
                                                <div class="input state-disabled">
                                                    <select name="input-kegus" id="input-kegus" class="form-control">
                                                        <option value="" selected></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Nama <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <div class="input">
                                                    <input class="form-control" name="input-nama" id="input-nama" value="" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Alamat <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <div class="input">
                                                    <textarea class="form-control" name="input-alamat" id="input-alamat" rows="2" required></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Kecamatan <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <div class="input state-disabled">
                                                    <select name="input-kecamatan" id="input-kecamatan" class="form-control" onchange="getkelurahan(this.value)" required>
                                                        <option value="" selected></option>
                                                        <?php foreach ($list_kecamatan as $row) : ?>
                                                            <option value="<?= $row->camat_id . '|' . $row->camat_kode ?>"> <?= $row->camat_kode . ' | ' . $row->camat_nama ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Kelurahan <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <div class="input state-disabled">
                                                    <select class="form-control" name="input-kelurahan" id="input-kelurahan" required>
                                                        <option value="" selected>- Silahkan pilih Kecamatan lebih dulu -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Kota</label>
                                            <div class="col-md-9">
                                                <div class="input">
                                                    <input class="form-control" name="input-kota" id="input-kota" value="Bekasi" readonly style="background-color:bisque;" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Kode Pos <font color="red">*</font></label>
                                            <div class="col-md-4">
                                                <div class="input">
                                                    <input class="form-control" name="input-kode_pos" id="input-kode_pos" size='5' maxlength='5' value="" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">No. Telepon <font color="red">*</font></label>
                                            <div class="col-md-4">
                                                <div class="input">
                                                    <input class="form-control" name="input-no_telepon" id="input-no_telepon" value="" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3"><b>Jenis Wajib Pajak</b></label>
                                            <div class="col-md-9">
                                                <div class="input state-disabled">
                                                    <select name="input-jns_wajib_pajak" id="input-jns_wajib_pajak" class="form-control">
                                                        <option value="2" selected> Badan Usaha</option>
                                                        <option value="1"> Pribadi </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="card-body">

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Nama Pemilik <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <div class="input">
                                                    <input class="form-control" name="input-nama_pemilik" id="input-nama_pemilik" value="" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Nomor KTP / NIK <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <div class="input">
                                                    <input class="form-control" name="input-nik_pemilik" id="input-nik_pemilik" value="" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Alamat email <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <div class="input">
                                                    <input type="email" class="form-control" name="input-email_pemilik" id="input-email_pemilik" value="" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">No. HP <font color="red">*</font></label>
                                            <div class="col-md-4">
                                                <div class="input">
                                                    <input class="form-control" name="input-no_hp" id="input-no_hp" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Alamat Pemilik</label>
                                            <div class="col-md-9">
                                                <div class="input">
                                                    <textarea class="form-control" name="input-alamat_pemilik" id="input-alamat_pemilik" rows="2" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Kecamatan Pemilik </label>
                                            <div class="col-md-9">
                                                <div class="input">
                                                    <input class="form-control" name="input-kecamatan_pemilik" id="input-kecamatan_pemilik" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Kelurahan Pemilik </label>
                                            <div class="col-md-9">
                                                <div class="input">
                                                    <input class="form-control" name="input-kelurahan_pemilik" id="input-kelurahan_pemilik" value="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Kota Pemilik</label>
                                            <div class="col-md-9">
                                                <div class="input">
                                                    <input class="form-control" name="input-kota_pemilik" id="input-kota_pemilik" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <label class="control-label col-md-3">Kode Pos Pemilik</label>
                                            <div class="col-md-4">
                                                <div class="input">
                                                    <input class="form-control" name="input-kode_pos_pemilik" id="input-kode_pos_pemilik" size='5' maxlength='5' value="" />
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Tgl. Terima Form <font color="red">*</font></label>
                                            <div class="col-md-4">
                                                <div class="input">
                                                    <input class="form-control datepicker" name="input-tgl_terima_form-date" id="input-tgl_terima_form" value="" required />
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Tgl. Terima <font color="red">*</font></label>
                                            <div class="input-group date col-md-4" id="tgl_form_kembali" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input input-tgl_form_kembali" name="input-tgl_form_kembali" id="input-tgl_form_kembali" maxlength="12" placeholder="yyyy-mm-dd" style="background-color:bisque;" data-target="#tgl_form_kembali" />
                                                <div class="input-group-append" data-target="#tgl_form_kembali" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Tgl. Batas Kirim <font color="red">*</font></label>
                                            <div class="input-group date col-md-4" id="tgl_bts_kirim" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input input-tgl_bts_kirim" name="input-tgl_bts_kirim" id="input-tgl_bts_kirim" maxlength="12" placeholder="yyyy-mm-dd" style="background-color:bisque;" data-target="#tgl_bts_kirim" />
                                                <div class="input-group-append" data-target="#tgl_bts_kirim" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Tgl. Pendaftaran <font color="red">*</font></label>
                                            <div class="input-group date col-md-4" id="tgl_daftar" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input input-tgl_daftar" name="input-tgl_daftar" id="input-tgl_daftar" maxlength="12" placeholder="yyyy-mm-dd" style="background-color:bisque;" data-target="#tgl_daftar" />
                                                <div class="input-group-append" data-target="#tgl_daftar" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- Input Detil Hotel  -->
                            <div class="row detil-hotel" id='detil-hotel'>
                                <div class="col-md-12" style="text-align: center;">
                                    <h5 style="text-align:left"> <b>Detil Objek Pajak Hotel</b></h5>
                                    </hr>
                                    <div class='row'>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-borderless" id="invoiceItem">
                                                    <thead>
                                                        <tr>
                                                            <th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
                                                            <th style="text-align:center">
                                                                Jenis Kamar
                                                            </th>
                                                            <th style="text-align:center">
                                                                Jumlah Kamar
                                                            </th>
                                                            <th style="text-align:center">
                                                                Tarif (Rp)
                                                            </th>
                                                            <th style="text-align:center">
                                                                Jumlah
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input class="itemRow" type="checkbox"></td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <select class="form-control form-control-sm" name="golongan_kamar[]" id="golongan_kamar_1">
                                                                            <option value="" disabled selected>-Pilih Jenis Kamar-</option>
                                                                            <?php
                                                                            foreach ($jenis_kamar as $jenis_kamar) :
                                                                            ?>
                                                                                <option id="kamar"><?= $jenis_kamar->jenis_martel ?></option>
                                                                            <?php endforeach ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" class="form-control form-control-sm" id="jumlah_kamar_1" name="jumlah_kamar[]" style="text-align:right" required>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" class="form-control form-control-sm" id="tarif_kamar_1" name="tarif_kamar[]" style="text-align:right" required>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" class="form-control form-control-sm" id="jumlah_1" name="jumlah[]" style="text-align:right" readonly>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <div class="text-right">
                                                            <button class="btn btn-sm btn-danger delete" id="removeRows" type="button">Hapus</button>
                                                            <button class="btn btn-sm btn-success" id="addRows" type="button">Tambah</button>
                                                        </div>
                                                    </tbody>
                                                </table>
                                                <hr class="divider">
                                                <table class="table table-sm table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:center"></th>
                                                            <th style="text-align:center"></th>
                                                            <th style="text-align:center"></th>
                                                            <th style="text-align:center"></th>
                                                            <th style="text-align:center"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <label for="totaljumlahkamar" class="col-sm col-form-label" style="text-align:right">Jumlah Kamar</label>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" class="form-control form-control-sm" id="totaljumlahkamar" name="totaljumlahkamar" style="text-align:right" onkeyup="calculateTotal()" readonly>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="input-golongan_hotel" class="col-sm col-form-label" style="text-align:right"> Golongan Hotel <font color='red'>*</font></label>
                                                            </td>
                                                            <td>
                                                                <div class='form-group'>
                                                                    <div class='col-md-12'>
                                                                        <div class='input state-disabled'>
                                                                            <select name='input-golongan_hotel' id='input-golongan_hotel' class='form-control' required>
                                                                                <option value='' selected></option>
                                                                                <?php
                                                                                foreach ($golongan_hotel as $golongan_hotel) :
                                                                                ?>
                                                                                    <option id="kamar" value="<?= $golongan_hotel->ref_kode ?>"><?= $golongan_hotel->ref_nama ?></option>
                                                                                <?php endforeach ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Input Detil Resto  -->
                            <div class="row detil-resto" id='detil-resto'>
                                <div class="col-md-12" style="text-align: center;">
                                    <h5 style="text-align:left"> <b>Detil Objek Pajak Restoran </b></h5>
                                    </hr>
                                    <div class='row'>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:center">
                                                                Jumlah Meja
                                                            </th>
                                                            <th style="text-align:center">
                                                                Jumlah Kursi
                                                            </th>
                                                            <th style="text-align:center">
                                                                Kapasitas pengunjung
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" class="form-control form-control-sm" id="jml_meja" name="jml_meja" style="text-align:right" autofocus required>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" class="form-control form-control-sm" id="jml_kursi" name="jml_kursi" style="text-align:right" required>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" class="form-control form-control-sm" id="kapasitas_pengunjung" name="kapasitas_pengunjung" style="text-align:right" required>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <hr class="divider">
                                                <table class="table table-sm table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:center"></th>
                                                            <th style="text-align:center"></th>
                                                            <th style="text-align:center"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <label for="jml_karyawan" class="col-sm col-form-label" style="text-align:right">Jumlah Karyawan</label>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" class="form-control form-control-sm" id="jml_karyawan" name="jml_karyawan" style="text-align:right">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="input-jns_restoran" class="col-sm col-form-label" style="text-align:right"> Jenis Restoran <font color='red'>*</font></label>
                                                            </td>
                                                            <td>
                                                                <div class='form-group'>
                                                                    <div class='col-md-12'>
                                                                        <div class='input state-disabled'>

                                                                            <select name="input-jns_restoran" id="input-jns_wajib_pajak" class="form-control">
                                                                                <option value="0" selected> Rumah Makan & Catering</option>
                                                                                <option value="1"> Rumah Makan </option>
                                                                                <option value="2"> Catering </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="divider">

                            <div class="row detil-lampiran" id='detil-lampiran'>
                                <div class="col-md-12" style="text-align: center;">
                                    <h5 style="text-align:left"> <b>Upload Lampiran </b>(* Format pdf)</h5>
                                    </hr>
                                    <div class="icheck-primary d-inline">
                                        <i class="fas fa-info-circle" style="margin-left:20px; cursor:pointer; " alt="info Lampiran" title="info Lampiran" id="opener"></i>
                                        Information
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td colspan="3">
                                                    <div class="custom-file">
                                                        <input type="file" id="image" name="imagefile" id="imagefile" class="form-control form-control-md" accept="application/pdf">
                                                        <div class="invalid-feedback errorUpload" style="display: none;">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- </div>
    </div>
    </div>
    </div> -->
                    <!--/.col (left) -->
                    <div class=" col-md-12">
                        <div class="card-footer">
                            <!-- <button type="reset" class="btn btn-secondary back">Batal</button> -->
                            <input type="submit" name="submit" class="btn btn-info  btn-block" id="btnSave" value="Simpan"></input>
                        </div>
                        </form>
                    </div>
                    <!-- /.row -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>
    <span id="output"></span>

    <div id="dialog" title="Info Lampiran">
        <p>Info DOkumen yang harus dilampirkan :
        <ul style="margin-left:-28px;">
            <li type="circle"><b>1. </b> Legalitas Perusahaan apabila Badan</li>
            <li type="circle"><b>2. </b> KTP dan NPWP Pemilik</li>
        </ul>
        </p>
    </div>

</body>


<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/autoNumeric.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>

<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- AdminLTE App -->
<!-- <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script> -->
<!-- sweat alert -->
<script src="<?php echo base_url(); ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>

<script language="javascript" src="<?= base_url('assets/js/main.js') ?>"></script>
<script language="javascript" src="<?= base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>





<script type="text/javascript">
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });


    $("#detil-hotel").hide();
    $("#detil-resto").hide();

    var date = new Date();
    var day = date.getDate();

    $('#tgl_daftar, #tgl_bts_kirim, #tgl_form_kembali ').datetimepicker({
        timepicker: false,
        format: 'YYYY-MM-DD'
    });
    $('#input-tgl_daftar, #input-tgl_form_kembali').val("<?= date('Y-m-d') ?>");
    $('#input-tgl_bts_kirim').val("<?php echo date("Y-m-d", strtotime(date('Y-m-d') . "+7 day")) ?>");

    $("#dialog").dialog({
        autoOpen: false,
        show: {
            effect: "blind",
            duration: 1000
        },
        hide: {
            effect: "explode",
            duration: 1000
        }
    });

    $("#opener").on("click", function() {
        $("#dialog").dialog("open");
    });

    function getkegus(val) {
        if (val == '1') {
            $("#detil-hotel").show();
            $("#detil-resto").hide();
        } else if (val == '2') {
            $("#detil-resto").show();
            $("#detil-hotel").hide();
        } else {
            $("#detil-hotel").hide();
            $("#detil-resto").hide();
        }

        $.ajax({
            type: "POST",
            url: "<?= site_url('pendaftaranwp/get_kegus') ?>",
            data: {
                "pajakid": val
            },
            success: function(response) {
                $('#input-kegus').html(response);
            }
        });
    }

    function getkelurahan(val) {
        $.ajax({
            type: "POST",
            url: "<?= site_url('pendaftaranwp/get_kelurahan') ?>",
            data: {
                "kdkec": val
            },
            success: function(response) {
                $('#input-kelurahan').html(response);
            }
        });
    }


    $(document).ready(function() {
        $(document).on("click", "#checkAll", function() {
            $(".itemRow").prop("checked", this.checked);
        });
        $(document).on("click", ".itemRow", function() {
            if ($(".itemRow:checked").length == $(".itemRow").length) {
                $("#checkAll").prop("checked", true);
            } else {
                $("#checkAll").prop("checked", false);
            }
        });
        var count = $(".itemRow").length;
        const kamar = document.getElementById('golongan_kamar_1').innerHTML;

        $(document).on("click", "#addRows", function() {

            count++;
            var htmlRows = "";
            htmlRows += "<tr>";
            htmlRows += '<td><input class="itemRow" type="checkbox"></td>';
            htmlRows +=
                '<td><div class="form-group"><div class="col-sm-12"> <select class="form-control form-control-sm" name="golongan_kamar[]" id="golongan_kamar_' + count + '"><option value="" disabled selected>' + kamar + '</option></select></div></div></td>';
            htmlRows +=
                '<td><div class="form-group"><div class="col-sm-12"><input type="text" class="form-control form-control-sm" id="jumlah_kamar_' + count + '" name="jumlah_kamar[]" style="text-align:right" required></div></div></td>';
            htmlRows +=
                '<td><div class="form-group"><div class="col-sm-12"><input type="text" class="form-control form-control-sm" id="tarif_kamar_' + count + '" name="tarif_kamar[]" style="text-align:right" required></div></div></td>';
            htmlRows +=
                '<td><div class="form-group"><div class="col-sm-12"><input type="text" class="form-control form-control-sm" id="jumlah_' + count + '" name="jumlah[]" style="text-align:right" readonly></div></div></td>';
            htmlRows += "</tr>";
            $("#invoiceItem").append(htmlRows);
        });
        $(document).on("click", "#removeRows", function() {
            $(".itemRow:checked").each(function() {
                $(this).closest("tr").remove();
            });
            $("#checkAll").prop("checked", false);
            calculateTotal();
        });
        $(document).on("keyup", "[id^=jumlah_kamar_]", function() {
            calculateTotal();
        });
        $(document).on("keyup", "[id^=tarif_kamar_]", function() {
            calculateTotal();
        });

        // button refresh
        $("#btnRefresh").click(function() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('pendaftaranwp/get_next_number_wp') ?>",
                dataType: "JSON",
                cache: false,
                success: function(data) {
                    console.log(data);
                    $('#no_register').val(data);
                }
            });
        });
    });

    $(document).on('submit', '#form', function(e) {

        alert('clicked');
        e.preventDefault();
    });

    // save data 
    // $(document).on('submit', '#form', function(e) {
    //     e.preventDefault();

    //     alert('xx');
    //     $('#btnSave').text('saving...'); //change button text
    //     $('#btnSave').attr('disabled', true); //set button disable 
    //     var url = "<?php echo site_url('pendaftaranwp/insert_data') ?>";

    //     var formdata = new FormData($('#form')[0]);
    //     $.ajax({
    //         url: url,
    //         type: "POST",
    //         data: formdata,
    //         dataType: "JSON",
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         success: function(data) {
    //             if (data.status == true) //if success close modal and reload ajax table
    //             {
    //                 Swal.fire({
    //                     title: 'Save!',
    //                     text: 'Pendaftaran Wajib Pajak Berhasil',
    //                     icon: 'success',
    //                     confirmButtonText: 'OK',
    //                     showConfirmButton: true
    //                 }).then((result) => {
    //                     /* Read more about isConfirmed, isDenied below */
    //                     window.location.assign("<?php echo site_url('pendaftaranwp') ?>");
    //                 })
    //             } else if (data.error == true) {
    //                 Swal.fire({
    //                     title: 'Error!',
    //                     text: data.msg,
    //                     icon: 'error',
    //                     confirmButtonText: 'OK',
    //                     showConfirmButton: false,
    //                     timer: 1500
    //                 });
    //                 $('#btnSave').attr('disabled', false); //set button disable 
    //             } else {
    //                 for (var i = 0; i < data.inputerror.length; i++) {
    //                     $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
    //                     $('[name="' + data.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
    //                     $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass('invalid-feedback');
    //                 }
    //                 $('#btnSave').attr('disabled', false); //set button disable 
    //             }
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             $("#output").text(e.responseText);
    //             console.log("ERROR : ", e);
    //             $('#btnSave').attr('disabled', false); //set button enable 
    //             return false;
    //         }
    //     });
    // });

    $("#imagefile").change(function() {
        var fileExtension = ['pdf'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Format File Harus  : " + fileExtension.join(', '));
            $("#imagefile").val('');
        } else {
            bsCustomFileInput.init();
        }
    });

    function calculateTotal() {
        var totalAmount = 0;
        var totalkamar = 0;
        $("[id^='tarif_kamar_']").each(function() {
            var id = $(this).attr("id");
            id = id.replace("tarif_kamar_", "");
            var tarif_kamar = $("#tarif_kamar_" + id).val();
            var jumlah_kamar = $("#jumlah_kamar_" + id).val();
            if (!jumlah_kamar) {
                jumlah_kamar = 1;
            }
            var total = tarif_kamar * jumlah_kamar;
            $("#jumlah_" + id).val(parseInt(total));
            totalAmount += total;
            totalkamar += parseInt(jumlah_kamar);
        });
        $('#totaljumlahkamar').val(parseInt(totalkamar));
    }
</script>