<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <!-- left column -->
            <div class="col-md-9">
                <!-- Input addon -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="nav-icon fas fa-plus"></i>
                            Upload Bukti Bayar
                        </h3>
                    </div>

                    <!-- Form Input -->
                    <form name="sptpdForm" id="form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="spt_id" id="spt_id" class="form-control-sm" value="<?= $spt_id ?>" size="3" readonly="true" style="background-color:azure;" />
                        <input type="hidden" name="kode_billing" id="kode_billing" class="form-control-sm" value="<?= $data_billing->kode_billing ?>" size="3" readonly="true" style="background-color:azure;" />
                        <table class="table">
                            <tr>
                                <td>
                                    <label for="name">NPWPD </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control-sm" value="<?= $data_billing->npwpd ?>" size="30" readonly="true" style="background-color:azure;" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="name">Nama WP </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control-sm" value="<?= $data_billing->nama_wp ?>" size="30" readonly="true" style="background-color:azure;" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="name">Jenis Pajak </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control-sm" value="<?= $data_billing->nama_pajak ?>" size="30" readonly="true" style="background-color:azure;" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="name">Kelurahan </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control-sm" value="<?= $data_billing->kelurahan ?>" size="30" readonly="true" style="background-color:azure;" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="name">Kecamatan </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control-sm" value="<?= $data_billing->kecamatan ?>" size="30" readonly="true" style="background-color:azure;" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="name">Kabupaten </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control-sm" value="<?= $data_billing->kabupaten ?>" size="30" readonly="true" style="background-color:azure;" />
                                </td>
                            </tr>
                            <tr>
                                <td><label for="dasar pengenaan">Dasar Pengenaan </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control-sm" value="<?= number_format($data_billing->nilai_terkena_pajak) ?>" size="30" readonly="true" style="background-color:azure;" />
                                    <label for="dasar pengenaan"> Tarif (%) : </label> <input type="text" name="korek_persen_tarif" id="korek_persen_tarif" class="inputbox" size="5" readonly="true" value="<?= $data_billing->persen_tarif ?>" style="font-weight:bold;background-color:azure;text-align:right;" />
                                </td>
                            </tr>
                            <tr>
                                <td><label for="pajak Terutang">Pajak Terhutang </label></td>
                                <td>
                                    <input type="text" class="form-control-sm" value="<?= number_format($data_billing->pajak) ?>" size="30" readonly="true" style="background-color:azure;" />
                                </td>
                            </tr>
                            <tr>
                                <td><label for="pajak Terutang">Pernyataan</label></td>
                                <td>
                                    <div class="row">
                                        <div> <input type="checkbox" name="disclamer" id="disclamer" class="form-control-sm is-valid" style="font-weight:bold;font-size:25px;color:#18F518;background-color:gray;text-align:right;" required /></div>
                                        <div class="disclamer_id"> Dengan ini menyatakan bahwasannya input data dan lampiran yang diupload adalah benar apa adanya,<br> apabila terbukti tidak benar maka dengan ini kami siap untuk dilakukan proses sesuai ketentuan yang berlaku!
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <!-- akhir inputan -->
                        <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->

            <!-- right column -->
            <div class="col-md-3">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="callout callout-warning">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            <p>- Masukkan Lampiran Bukti Bayar:</p>
                            <p>- Omzet dan Bukti Setor berformat .pdf</p>
                            <p>- Ukuran lampiran maksimal 1 MB</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="callout callout-danger">
                            <h5><i class="fas fa-file-upload"></i> Upload Lampiran :Ukuran lampiran maksimal 1 MB</h5>
                            <div class="custom-file">
                                <label class="custom-file-label" for="imagefile" style="color:red;" required> * Upload file Pdf bukti bayar</label>
                                <input type="file" class="custom-file-input" name="imagefile" id="imagefile" accept=".pdf" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="msg-tmp col-sm-12"></div>
            </div>
            <!--/.col (right) -->

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

    function save() {
        let btn = $(this);
        btn.html(`
                <div class="spinner-border text-primary" role="status">
                     <span class="sr-only">Loading...</span>
                </div>`)

        if ($('#disclamer').is(":checked")) {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 
            var url = "<?php echo site_url('esptpd/insert_upload_lampiran') ?>";

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
                    btn.html(`
                        <input type="button" name="submit" class="btn btn-info float-right" id="btnSave" onclick="save()" value="Simpan"></input>`)
                    if (data.status == true) //if success close modal and reload ajax table
                    {
                        Swal.fire({
                            title: 'Save!',
                            text: 'Your File has bees save.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });

                        $('#btnSave').text('save'); //change button text
                        $('#btnSave').attr('disabled', false); //set button enable 
                        window.location.assign("<?php echo site_url('esptpd') ?>");
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
        } else {
            Swal.fire({
                title: 'Informasi!',
                text: 'Silakan klik checkboxes pernyataan untuk melanjutkan!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        }
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