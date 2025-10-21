<?php
require_once '../init.php';
$data = [
    'title' => 'Buat Billing'
];

$data = [
    'title' => 'ESPTPD',
    'page' => 'ESPTPD MAKAN & MINUM',
    'menu' => 'ESPTPD',
    'active' => 'Makan dan Minum'
];

get_header($data);
get_sidenav();
get_breadcrumb($data);

$subjek_id = $_GET['data-id'];
$getnpwpd  = $_GET['npwpd'];

$kd_jns_pajak = '002'; //002 KODE JENIS RESTO / MAMIN
$table_name   = 'RESTORAN';

$no_urut = $Getdata->_getNoUrut($kd_jns_pajak);
$no_urut = (int) $no_urut['NO_URUT_ESPT'];
if ($no_urut == '') {
    $no_urut = sprintf("%05s", '1');
} else {
    $no_urut = sprintf("%05s", $no_urut + 1);
}

$no_sptpd = 'E/' . $no_urut . '/R/' . date('Y');

$nm_bulan = array(
    '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni',
    '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'Nopember', '12' => 'Desember'
);

$refNPWPD = $Getdata->_getRefNPWPD($table_name);
$row = $Getdata->_getNPWPD($table_name, $getnpwpd);

$data = array(
    "nm_badan" => $row['NAMA_LENGKAP_WP'],
    "nm_badan_usaha" => $row['NAMA_BADAN_USAHA'],
    "npwpd" => $row['N'] . $row['P'] . $row['NPWPD'] . $row['P1'] . $row['D'],
    "jenis_pajak" => $row['JENIS_PAJAK'],
    "about" => $row['JENIS_PAJAK'],
    'kd_rekening_utama' => $row['KODE_REK_UTAMA'],
    'tarif' => $row['TARIF'],
    'kd_rekening' => $row['KODE_REK'],
    "alamat" => $row['ALAMAT_LENGKAP_USAHA'],
    "no_telp" => $row['NO_TELP_TEMPAT_USAHA'],
    "uraian_pajak" => $row['URAIAN_JENIS_PAJAK']
);


?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- Input addon -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas  fa-pizza-slice"></i>
                            Input Data Makan dan Minum
                        </h3>
                    </div>

                    <div class="card-body">
                        <form name="sptpdForm" id="form" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i>
                                        No. SPTPD : <span> <?php echo $no_sptpd; ?> </span>
                                        <small class="float-right">Date: <?php echo date('d/m/Y'); ?></small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label label for="select2" class="col-sm-3">Pengusaha Kena Pajak </label>
                                        <div class="col-sm-9">
                                            <select name="npwpd" id="select2" class="form-control select2 input-sm _npwpd" style="width: 100%;">
                                                <option value=""> -- Pilih Daftar Wajib Pajak -- </option>
                                                <?php
                                                foreach ($refNPWPD as $row) {
                                                    $selected = ($getnpwpd == $row['NPWPD']) ? "selected" : "";
                                                    echo '<option value="' . $row['NPWPD'] . '" ' . $selected . '>' . $row['NAMA_BADAN_USAHA'] . '</option>';
                                                }
                                                ?>
                                                <!-- <?php if ($inquiry_access == 'Pelayanan') { ?>
                                                    <?php
                                                            foreach ($refNPWPD as $row) {
                                                                $selected = ($getnpwpd == $row['NPWPD']) ? "selected" : "";
                                                                echo '<option value="' . $row['NPWPD'] . '" ' . $selected . '>' . $row['NAMA_BADAN_USAHA'] . '</option>';
                                                            }
                                                    ?>
                                                <?php } else { ?>
                                                    <option value="11" <span class="nm_badan"><?php echo $data['nm_badan'] ?></span></option>
                                                <?php } ?> -->
                                            </select>
                                        </div>
                                    </div>

                                    <div class="card bg-light">
                                        <div class="card-header text-muted border-bottom-0">
                                            Informasi WP
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h2 class="lead"><b> <span class="nm_badan"><?php echo $data['nm_badan'] ?></span></b></h2>
                                                    <p class="text-muted text-sm"><b>Jenis Pajak : </b><span class="about"> <?php echo $data['about'] ?></span> </p>
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                        <li class="large"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Alamat : <span class="alamat"><?php echo $data['alamat'] ?></span></li>
                                                        <li class="large"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone : <span class="no_telp"> <?php echo $data['no_telp'] ?></span></span></li>
                                                    </ul>
                                                </div>
                                                <div class="col-5 text-center">
                                                    <img src="../../dist/img/user1-128x128.jpg" alt="" class="img-circle img-fluid">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div><!-- KOLOM KIRI-->

                                <div class="col-md-6">
                                    <!--kolom sebelah kanan-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <!-- baris baru -->
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered" width="100%">

                                            <tbody>
                                                <tr align="center">
                                                    <!-- <td>Pengguna jasa</td> -->
                                                    <td>Periode Tanggal</td>
                                                    <td>Periode SPT</td>
                                                    <td>Kode Rekening Utama</td>
                                                    <td>Kode Rekening</td>
                                                    <td>Golongan</td>
                                                </tr>
                                                <tr align="center">
                                                    <!-- <td>
                                    <input  type="text" id="Total">                               
                                </td> -->
                                                    <td>
                                                        <input type="text" name="periode_tanggal" id="periode_tanggal" style="text-align:center;" class="form-control-sm" placeholder="etc: 01 - 02">
                                                        <select name="periode_bulan" id="periode_bulan" class="form-control-sm text-center periode_bulan">
                                                            <?php

                                                            foreach ($nm_bulan as $key => $val) {
                                                                echo "<option  value='" . $key . "' echo $selected>" . $val . "</option>";
                                                            } ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="periode_tahun" id="periode_tahun" class="form-control text-center periode_tahun">
                                                            <?php

                                                            for ($i = 0; $i <= 10; $i++) {
                                                                // $selected = ($periode_tahun==(date('Y')-$i))? "selected" : "";
                                                                echo "<option  value='" . (date('Y') - $i) . "' echo $selected>" . (date('Y') - $i) . "</option>";
                                                            } ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="kd_rekening_utama" id="kd_rekening_utama" style="text-align:center;" value="<?= $data['kd_rekening_utama'] ?>" class="form-control  kd_rekening_utama" readonly="true">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="kd_rekening" id="kd_rekening" style="text-align:center;" value="<?= $data['kd_rekening'] ?>" class="form-control kd_rekening" readonly="true">
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="kd_jns_pajak" id="kd_jns_pajak" class="form-control kd_jns_pajak" value="<?= $kd_jns_pajak ?>" readonly="true" />
                                                        <input type="text" name="jenis_pajak" id="jenis_pajak" style="text-align:center;" class="form-control jenis_pajak" value="<?= $data['jenis_pajak'] ?>" readonly="true" />
                                                    </td>
                                                </tr>

                                                <tr align="center">
                                                    <td>Harga Transaksi (Rp.)</td>
                                                    <td>DPP</td>
                                                    <td>Dasar Pengenaan (Rp.)</td>
                                                    <td>Tarif (%)</td>
                                                    <td>Pajak Terhutang (Rp.)</td>
                                                </tr>
                                                <tr align="center">
                                                    <td>
                                                        <input type="text" id="omset" class="form-control omset" style="text-align:right;" onblur="check_pajak(document.sptpdForm,this.id);" onkeyup="thousand_format(this);check_pajak(document.sptpdForm,this.id);" onkeypress="return only_number(event,this);" placeholder="Rp.">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="dpp" id="dpp" class="form-control-sm common_selector" />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="dasar_pengenaan" id="dasar_pengenaan" class="form-control" style="text-align:right;" readonly="true" onkeyup="thousand_format(this);" onkeypress="return only_number(event,this);" placeholder="Rp." required />

                                                    </td>
                                                    <td>
                                                        <input type="text" name="persen_tarif" id="persen_tarif" style="text-align:right;" class="form-control persen_tarif" value="<?= $data['tarif'] ?>" readonly="true" placeholder="%">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="spt_pajak" id="spt_pajak" class="form-control" readonly="true" style="text-align:right;" onkeyup="thousand_format(this);" onkeypress="return only_number(event,this);" placeholder="Rp.">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--ahir-->

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="table_name" id="table_name" class="inputbox" value="<?= $table_name; ?>" />
                                    <!-- <div class="form-group row">
                            <label   class="col-sm-3">Untuk SOPD : </label>
                            <div class="col-sm-9">
                                <input type="hidden" name="no_sptpd" id="no_sptpd" class="form-control no_sptpd" value="<?= $no_sptpd; ?>" readonly="true" />
                                <input type="hidden" name="npwpd_hidden" id="npwpd_hidden" class="form-control npwpd_hidden"  value="<? echo $data['npwpd'] ?>" readonly="true" />
                                <input type="hidden" name="nama_lengkap_wp" id="nama_lengkap_wp" class="form-control nama_lengkap_wp" value="<? echo $data['nm_badan'] ?>" readonly="true" />
                                <input type="hidden" name="nama_badan_usaha" id="nama_badan_usaha" class="form-control nama_badan_usaha" value="<? echo $data['nm_badan_usaha'] ?>"  readonly="true" />
                                <input type="hidden" name="alamat_lengkap_usaha" id="alamat_lengkap_usaha" class="form-control alamat_lengkap_usaha" <? echo $data['alamat'] ?> readonly="true" />
                                <input type="hidden" name="no_telp_tempat_usaha" id="no_telp_tempat_usaha" class="form-control no_telp_tempat_usaha" <? echo $data['no_telp'] ?> readonly="true" />
                                <input type="hidden" name="no_berkas" id="no_berkas" class="form-control" value="mamin"   readonly="true" />
                                <textarea class="form-control no_bill" name="no_bill" id="no_bill" rows="1" placeholder="Enter ..."></textarea>
                            </div>
                        </div>   -->
                                    <div class="form-group row">
                                        <label class="col-sm-3">Uraian Pajak</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control uraian_pajak" name="uraian_pajak" rows="1" id="uraian_pajak"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3">Lampiran File : </label>
                                        <div class="col-sm-9">
                                            <div class='alert alert-warning' role='alert'>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="upFile">
                                                    <label class="custom-file-label" for="upFile" accept=".pdf,.jpg,.jpeg" style="color:red;" required> *Upload file .pdf</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- KOLOM KIRI-->



                                <div class="col-md-6">
                                    <!--kolom sebelah kanan-->
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- <h2 class="lead text-right"><b>Pengguna Jasa : </b> <?php echo $_SESSION['username']; ?></h2> -->
                                                    <label class="col-sm-3 text-center">Informasi Tagihan Pajak </label>

                                                    <h2 class="lead text-muted text-right"> Nilai Transaksi :<b> <span class="omset_text"></span></b> </h2>
                                                    <h2 class="lead  text-muted text-right">Dasar Pengenaan: <b><span class="dasar_pengenaan_text"></span></b></h2>
                                                    <h2 class="lead  text-muted text-right">Tarif Pajak: <b><span class="persen_tarif_text"></span><?= $data['tarif'] . ' %' ?></Tarif>
                                                    </h2>
                                                    <h2 class="lead  text-muted text-right"> Pajak Terutang: <b><span class="spt_pajak_text"></span></b></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                            <div class="msg-tmp"></div>

                            <div class="card-footer">
                                <button type="reset" class="btn btn-secondary  back">Batal</button>
                                <button type="button" class="btn btn-success _SSPD-Mamin float-right"><i class="fab fa-creative-commons-share"></i> Generate Billing
                                </button>
                            </div>
                        </form>
                    </div>







                </div>
                <!-- /.card -->
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<?php get_footer(); ?>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        // $('.select2bs4').select2({
        //   theme: 'bootstrap4'
        // })
    })


    $(document).ready(function() {
        bsCustomFileInput.init();
    });

    $("#upFile").change(function() {
        var fileExtension = ['pdf', 'jpg', 'jpeg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Format File Harus : " + fileExtension.join(', '));
        }
    });
</script>