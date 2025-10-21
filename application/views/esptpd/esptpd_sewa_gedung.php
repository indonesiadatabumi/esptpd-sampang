<?php error_reporting(error_reporting() & ~E_NOTICE) ?>
<script language="javascript" src="<?= base_url('assets/js/main.js') ?>"></script>
<script language="javascript" src="<?= base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>

<section class="content">
    <div class="container-fluid">

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- Input addon -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-building"></i>
                            Input Data Sewa Gedung
                        </h3>
                    </div>

                    <div class="card-body">
                        <form name="sptpdForm" id="form" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <input type="hidden" name="wp_id" id="wp_id" class="form-control-sm wp_id" />
                            <input type="hidden" name="spt_jenis" id="spt_jenis" class="form-control-sm spt_jenis" />
                            <input type="hidden" name="wp_id_detil" id="wp_id_detil" class="form-control-sm wp_detil_id" />
                            <input type="hidden" name="kegus_id" id="kegus_id" class="form-control-sm kegus_id" />
                            <input type="hidden" name="jenput_id" id="jenput_id" class="form-control-sm jenput_id" />
                            <div class="col-12">
                                <h4>
                                    <small class="float-right">Date: <?php echo date('d/m/Y'); ?></small>
                                </h4>
                            </div>
                            <!-- /.col -->
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label label for="npwpd" class="col-sm-3">Pengusaha Kena Pajak </label>
                                <div class="col-sm-9">
                                    <select name="npwpd" id="npwpd" class="form-control input-sm" onchange="get_data()" style="width: 100%;">
                                        <option value=""> -- Pilih Daftar Wajib Pajak -- </option>
                                        <?php
                                        foreach ($list_wp as $row) {
                                            echo '<option value="' . $row->npwprd . '">' . $row->nama . '</option>';
                                        }
                                        ?>
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
                                            <h2 class="lead"><b> <span class="nm_badan"></span></b></h2>
                                            <p class="text-muted text-sm"><b>Kegiatan Usaha : </b><span class="about"> </span> </p>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="large"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Alamat : <span class="alamat"></span></li>
                                                <li class="large"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone : <span class="no_telp"> </span></span></li>
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
                                            <td>Tanggal</td>
                                            <td>Periode</td>
                                            <td>Golongan</td>
                                        </tr>
                                        <tr align="center">
                                            <td>
                                                <div class="row">
                                                    <div class="col-xs-3 col-sm-5">
                                                        <div class="form-group">

                                                            <div class="input-group date" id="searchStartDate" data-target-input="nearest">
                                                                <input type="date" class="form-control" name="spt_periode_jual1" id="spt_periode_jual1" />

                                                            </div>
                                                        </div>
                                                    </div>s/d
                                                    <div class="col-xs-3 col-sm-5">
                                                        <div class="form-group">

                                                            <div class="input-group date" id="searchEndDate" data-target-input="nearest">

                                                                <input type="date" class="form-control" name="spt_periode_jual2" id="spt_periode_jual2" />

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="spt_periode" id="spt_periode" style="text-align:center;" size="11" value="<?= date('Y') ?>" class="form-control" />
                                            </td>
                                            <td>
                                                <input type="text" name="jenis_pajak" id="jenis_pajak" style="text-align:center;" class="form-control jenis_pajak" readonly="true" />
                                            </td>
                                        </tr>

                                        <tr align="center">
                                            <td>Dasar Pengenaan (Rp.)</td>
                                            <td>Tarif (%)</td>
                                            <td>Pajak Terhutang (Rp.)</td>
                                        </tr>
                                        <tr align="center">
                                            <td>
                                                <input type="text" name="spt_nilai" id="spt_nilai" class="form-control" style="text-align:right;" onfocus="this.value=unformatCurrency(this.value);" onkeyup="getPajak('spt_pajak','spt_nilai','korek_persen_tarif');" onblur="getPajak('spt_pajak','spt_nilai','korek_persen_tarif');this.value=formatCurrency(this.value);" placeholder="Rp." required />

                                            </td>
                                            <td>
                                                <input type="text" name="korek_persen_tarif" id="korek_persen_tarif" style="text-align:right;" class="form-control persen_tarif" readonly="true" placeholder="%">
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
                            <div class="form-group row">
                                <label class="col-sm-3">Lampiran File : </label>
                                <div class="col-sm-9">
                                    <div class='alert alert-warning' role='alert'>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="imagefile" id="imagefile">
                                            <label class="custom-file-label" for="imagefile" accept=".pdf" style="color:red;" required> *Upload file .pdf</label>
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
                                            <label class="col-sm-3 text-center">Informasi Tagihan Pajak </label>

                                            <h2 class="lead  text-muted text-right">Dasar Pengenaan: <b><span class="spt_nilai_text"></span></b></h2>
                                            <h2 class="lead  text-muted text-right">Tarif Pajak: <b><span class="persen_tarif_text"></span></Tarif>
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
                        <button type="button" class="btn btn-success float-right" onclick="save()"><i class="fab fa-creative-commons-share"></i> Generate Billing
                        </button>
                    </div>
                    </form>
                </div>







            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->

    </div><!-- /.container-fluid -->
</section>
<script type="text/javascript">
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    function get_data() {
        let npwprd = $('#npwpd').val()
        let url = "<?php echo site_url('esptpd/get_data_wp') ?>"
        $.ajax({
            url: url,
            type: "GET",
            data: {
                npwprd: npwprd
            },
            dataType: "JSON",
            success: function(response) {
                $('.wp_id').val(response.wp_wr_id);
                $('.wp_detil_id').val(response.wp_wr_detil_id);
                $('.spt_jenis').val(response.pajak_id);
                $('.kegus_id').val(response.kegus_id);
                $('.jenput_id').val(response.jenis_pemungutan);
                $('.nm_badan').text(response.nama);
                $('.jenis_pajak').val(response.nama_paret);
                $('.persen_tarif').val(response.persen_tarif);
                $('.persen_tarif_text').text(response.persen_tarif + '%');
                $('.alamat').text(response.alamat);
                $('.about').text(response.nama_kegus);
                $('.no_telp').text(response.no_telepon);
            }
        });
    }

    $(document).on('change', "#spt_nilai", function() {
        var spt_nilai = $('#spt_nilai').val();
        var spt_pajak = $('#spt_pajak').val();
        var spt_pajak = spt_pajak.substr(0, spt_pajak.length - 3);
        $(".spt_nilai_text").text('Rp. ' + addCommas(spt_nilai));
        $(".spt_pajak_text").text('Rp. ' + addCommas(spt_pajak));
    });

    function addCommas(nStr) {
        nStr += '';
        var comma = /,/g;
        nStr = nStr.replace(comma, '');
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }

    $('input[type="checkbox"]').click(function() {

        if ($(this).prop("checked") == true) {
            check_pajak();
        } else if ($(this).prop("checked") == false) {
            check_pajak();
        }

    });

    function save() {
        var url = "<?php echo site_url('esptpd/insert') ?>";

        var formdata = new FormData($('#form')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formdata,
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status == true) //if success close modal and reload ajax table
                {
                    Swal.fire({
                        title: 'Save!',
                        text: 'Your File has bees save.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    window.location.reload();
                } else if (data.error == true) {
                    Swal.fire({
                        title: 'Error!',
                        text: data.msg,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $('#btnSave').attr('disabled', false); //set button disable 
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                        $('[name="' + data.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass('invalid-feedback');
                    }
                    $('#btnSave').attr('disabled', false); //set button disable 
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // console.log(jqXHR);
                // alert(jqXHR);
                Toast.fire({
                    icon: 'error',
                    title: 'Error!!.'
                });
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }

    $("#imagefile").change(function() {
        var fileExtension = ['pdf'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Format File Harus  : " + fileExtension.join(', '));
            $("#imagefile").val('');
        } else {
            bsCustomFileInput.init();
        }
    });
</script>
<script language="javascript" src="<?= base_url('assets/js/pajak_hotel.js') ?>">