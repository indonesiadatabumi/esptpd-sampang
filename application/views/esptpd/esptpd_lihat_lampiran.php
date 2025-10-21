<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card-header bg-light">
                    <h3 class="card-title"><i class="fa fa-list text-blue"></i> Lampiran ESPTPD</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <?php

                    if ($lampiran == '') {
                        $lampiran = 'default.pdf';
                    } else {
                        $lampiran = $lampiran;
                    }
                    ?>
                    <div class="modal-body">

                        <!-- mulai form-->
                        <form id='form' name='form' class='form-horizontal form-label-left' method='POST'>
                            <input type='hidden' class='form-control readonly-bg' name='act' id='no_pelayanan' value='<?= $act ?>' readonly />
                            <div class="row">
                                <div class="col-6">
                                    <!-- <div class="form-group">
                                        <label class='col-md-4 control-label'>Nomor SPT </label>
                                        <div class='col-md-8'>
                                            <input type='text' class='form-control readonly-bg' name='no_pelayanan' id='no_pelayanan' value='<?= $spt_id ?>' readonly />
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label class='col-md-4 control-label'>ID BILLING</label>
                                        <div class='col-md-8'>
                                            <input type='hidden' class='form-control readonly-bg' name='no_pelayanan' id='no_pelayanan' value='<?= $spt_id ?>' readonly />
                                            <input type='text' class='form-control readonly-bg' name='id_billing' id='id_billing' value='<?= $billing_id ?>' readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class='col-md-4 control-label'>Nama Wajib Pajak </label>
                                        <div class='col-md-8'>
                                            <input type='text' class='form-control readonly-bg' name='nm_wp' id='nm_wp' value='<?= $wp_wr_nama ?>' readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class='col-md-4 control-label'>Alamat Wajib Pajak </label>
                                        <div class='col-md-8'>
                                            <input type='text' class='form-control readonly-bg' name='alamat_op' id='alamat_op' value='<?= $wp_wr_almt ?>' readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class='col-md-5'>
                                                <label class='col-md-6 control-label'>Masa Awal </label>
                                                <div class='col-md-6'>
                                                    <input type='text' class='form-control' name='masa_awal' id='masa_awal' value='<?= $spt_periode_jual1 ?>' readonly required />
                                                </div>
                                            </div>
                                            <div class='col-md-6 text-left'>
                                                <label class='col-md-6 control-label'>Masa Akhir </label>
                                                <div class='col-md-6'>
                                                    <input type='text' class='form-control' name='masa_akhir' id='masa_akhir' value='<?= $spt_periode_jual2 ?>' readonly required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class='col-md-4 control-label'>Periode Pajak</label>
                                        <div class='col-md-8'>
                                            <input type='text' class='form-control' name='spt_periode' id='spt_periode' value='<?= $spt_periode ?>' style="text-align: left;" readonly required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class='col-md-4 control-label'>SPT PAJAK</label>
                                        <div class='col-md-8'>
                                            <input type='text' class='form-control' name='spt_pajak' id='spt_pajak' value='<?= number_format($spt_pajak) ?>' style="text-align: right;" readonly required />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <h5 align="center"><i class='fa fa-files-o'></i> Lampiran Dokumen</h3>
                                        <div class="form-group">
                                            <button type='button' title='Lampiran' class='btn btn-xs btn-default' onclick="window.open('<?= base_url('esptpd/lampiran/') . $billing_id ?>',' register','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=1,width=700,height=700');" target="_blank">
                                                <embed src='<?= base_url('assets/foto/lampiran/') . $lampiran ?>' width='600px' height='500px'></embed><br>
                                                <i class='fa fa-search-plus'> Klik Untuk Memperbesar </i>
                                            </button>
                                        </div>
                                </div>

                            </div>
                    </div>
                </div>
                <div class='ln_solid'></div>
                <div class="modal-footer justify-content-between">
                    <button type='reset' class='btn btn-danger _btnbatal' onclick="history.back()" id='close-modal-form' data-dismiss='modal'><i class="fas fa-angle-double-left"></i> Kembali</button>
                    <!-- <div class="modal-footer">
                        <button type='submit' class='btn btn-success _btnsimpan  pull-right' id="btnSave" onclick="save()">Simpan</button>
                    </div> -->
                </div>
            </div>
            </form>
        </div>
    </div>
</section>

<script type="text/javascript">
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });


    function save() {
        // e.preventDefault();

        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url = "<?php echo site_url('esptpd/register_save') ?>";

        var formdata = new FormData($('#form')[0]);

        // console.log(formdata);

        $.ajax({
            url: url,
            type: "POST",
            data: formdata,
            dataType: "text",
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status == true) {
                    Swal.fire(
                        'Save!',
                        'Your file has been save.',
                        'success'
                    );
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                        $('[name="' + data.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass('invalid-feedback');
                    }
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
                // window.location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // console.log(jqXHR);
                // alert(jqXHR);
                // Toast.fire({
                //     icon: 'error',
                //     title: 'Error!!.'
                // });
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