<?php error_reporting(error_reporting() & ~E_NOTICE) ?>
<script language="javascript" src="<?= base_url('assets/js/main.js') ?>"></script>
<script language="javascript" src="<?= base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>

<section class="content">
    <div class="container-fluid">

        <div class="row">
            <!-- left column -->
            <div class="col-md-9">
                <!-- Input addon -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="nav-icon fas fa-hotel"></i>
                            Input Laporan Wajib Pajak
                        </h3>
                    </div>

                    <!-- Form Input -->
                    <form name="sptpdForm" id="form" method="post" enctype="multipart/form-data">
                        <table class="table">
                            <input type="hidden" name="wp_id" id="wp_id" class="form-control-sm" value="<?= $wp_id ?>" size="10" readonly="true" style="background-color:azure;" />
                            <input type="hidden" name="wp_id_detil" id="wp_id_detil" class="form-control-sm" value="<?= $wp_id_detil ?>" size="10" readonly="true" style="background-color:azure;" />
                            <input type="hidden" name="spt_jenis" id="spt_jenis" class="form-control-sm" value="1" size="3" readonly="true" style="background-color:azure;" />
                            <tr>
                                <td>
                                    <label for="password">NPWPD</label>
                                </td>
                                <td>
                                    <input type="text" name="npwpd" id="npwpd" class="form-control-sm" value="<?= $npwprd ?>" readonly="true" style="background-color:azure;" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="nama_wp">Nama WP</label>
                                </td>
                                <td>
                                    <input type="text" name="nama_lengkap_wp" id="nama_lengkap_wp" class="form-control-sm" size="40" readonly="true" value="<?= $nama ?>" style="background-color:azure;text-transform: uppercase;" />
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label for="nama_wp">Kegiatan Usaha</label>
                                </td>
                                <td>
                                    <input type="text" name="nama_kegus" id="nama_kegus" class="form-control-sm" size="40" readonly="true" value="<?= $nama_kegus ?>" style="background-color:azure;text-transform: uppercase;" />
                                    <input type="hidden" name="kegus_id" id="kegus_id" class="form-control-sm" size="40" readonly="true" value="<?= $kegus_id ?>" style="background-color:azure;text-transform: uppercase;" />
                                    <input type="hidden" name="jenput_id" id="jenput_id" class="form-control-sm" size="40" readonly="true" value="<?= $jenput_id ?>" style="background-color:azure;text-transform: uppercase;" />
                                </td>

                            </tr>
                            <tr>
                                <td valign="top">
                                    <label for="alamat_wp">Alamat</label>
                                </td>
                                <td>
                                    <textarea cols="34" rows="3" name="alamat_lengkap_usaha" id="alamat_lengkap_usaha" class="form-control-sm" readonly="true" style="background-color:azure;text-transform: uppercase;"><?= $alamat ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="password">Periode SPT</label>
                                </td>
                                <td>
                                    <input type="text" name="spt_periode" id="spt_periode" size="11" value="<?= date('Y') ?>" class="form-control-sm" style="background-color:bisque;" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <label for="gid">Masa Pajak</label>

                                </td>
                                <td>
                                    <select class="form-control-sm" name="masa_pajak" id="masa_pajak" required>
                                        <option value="" disabled>Pilih Masa Pajak</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="data_pembayaran">

                            </tr>
                            <tr>
                                <td><label for="pajak Terutang">Total Pembayaran </label></td>
                                <td>
                                    <input type="text" name="spt_pajak" id="spt_pajak" class="form-control-sm is-valid" size="20" readonly="true" required />
                                </td>
                            </tr>
                        </table>
                        <!-- akhir inputan -->
                        <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <!--/.col (left) -->
            <div class="col-md-12">
                <div class="card-footer">
                    <button type="reset" class="btn btn-secondary back">Batal</button>
                    <input type="button" name="submit" class="btn btn-info float-right" id="btnSave" onclick="save()" value="Simpan"></input>
                </div>
                </form>
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

    $('#searchStartDate, #searchEndDate').datetimepicker({
        timepicker: false,
        format: 'YYYY-MM-DD'
    });

    // Saat masa_pajak berubah
    $('#masa_pajak').on('change', function() {
        let bulan = $(this).val();
        let tahun = $('#spt_periode').val();
        let wp_id_detil = $('#wp_id_detil').val();

        if (bulan && tahun) {
            // Jalankan AJAX
            $.ajax({
                url: '<?= base_url("lapor_pajak/get_total_bulanan") ?>', // Ganti dengan URL controller kamu
                type: 'POST',
                dataType: 'json',
                data: {
                    bulan: bulan,
                    tahun: tahun,
                    wp_id_detil: wp_id_detil
                },
                beforeSend: function() {
                    $('#data_pembayaran').html('<td colspan="2">Memuat data...</td>');
                },
                success: function(response) {
                    if (response.status) {
                        let html = `
                        <td colspan="2">
                            <div class="alert alert-info">
                                Total Pajak Bulan <b>${bulan}</b> Tahun <b>${tahun}</b>: 
                                <b>Rp ${parseInt(response.total_pajak).toLocaleString('id-ID')}</b>
                            </div>
                            <table class="table table-bordered table-sm mt-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Masa Pajak</th>
                                        <th>Kode Billing</th>
                                        <th>Nilai Pajak</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                        if (response.data.length > 0) {
                            $.each(response.data, function(i, item) {
                                html += `
                                <tr>
                                    <td>${i + 1}</td>
                                    <td>${item.masa_pajak1 ?? '-'} - ${item.masa_pajak2 ?? '-'}</td>
                                    <td>${item.kode_billing ?? '-'}</td>
                                    <td align="right">Rp ${parseInt(item.pajak).toLocaleString('id-ID')}</td>
                                </tr>
                            `;
                            });
                        } else {
                            html += `
                            <tr>
                                <td colspan="4" class="text-center text-muted">Tidak ada data untuk bulan ini</td>
                            </tr>
                        `;
                        }

                        html += `
                                </tbody>
                            </table>
                        </td>
                    `;

                        $('#data_pembayaran').html(html);
                    } else {
                        $('#data_pembayaran').html(`
                        <td colspan="2">
                            <div class="alert alert-warning">Tidak ada data untuk bulan ${bulan}</div>
                        </td>
                    `);


                    }
                    let total = parseInt(response.total_pajak || 0);
                    let formatted = total.toLocaleString('id-ID'); // hasil: 12.345

                    //set total pajak
                    $('#spt_pajak').val(formatted);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    $('#data_pembayaran').html('<td colspan="2">Terjadi kesalahan mengambil data.</td>');
                }
            });
        } else {
            $('#data_pembayaran').html('');
        }
    });


    $("#StartDate").blur(function() {
        let date = $("#StartDate").val();
        var y = date.substring(0, 4);
        var m = date.substring(5, 7);
        var d2 = y + '-' + m + '-' + lastday(y, m);

        $("#EndDate").val(d2);
        // alert("This input field has lost its focus." + d2);
    });

    var lastday = function(y, m) {
        return new Date(y, m + 1, 0).getDate();
    }

    function save() {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url = "<?php echo site_url('lapor_pajak/insert') ?>";

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
                        text: 'Your File has been saved.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        window.location.assign("<?php echo site_url('lapor_pajak') ?>");
                    });

                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable
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

    // $("#imagefile").change(function() {
    //     var fileExtension = ['pdf', 'png', 'jpg', 'jpeg'];
    //     if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
    //         alert("Format File Harus  : " + fileExtension.join(', '));
    //         $("#imagefile").val('');
    //     } else {
    //         bsCustomFileInput.init();
    //     }
    // });

    $(function() {
        var d = new Date(),
            n = d.getMonth() + 1;
        var masa_pajak = $('#StartDate').val();
        var periode = $('#spt_periode').val()
        masa_pajak = masa_pajak.substring(5, 7)

        $('input[type="submit"]').prop('disabled', false);

        if (masa_pajak == n && peirode == d.getFullYear()) {
            $('input[type="submit"]').prop('disabled', true);
        } else {
            $('input[type="submit"]').prop('disabled', false);
        }

    });
</script>
<script language="javascript" src="<?= base_url('assets/js/pajak_hotel.js') ?>">