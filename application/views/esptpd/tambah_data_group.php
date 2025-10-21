<script language="javascript" src="<?= base_url('assets/js/jquery.autotab.js') ?>"></script>
<script>
    $(function() {
        $.autotab({
            tabOnSelect: true
        });
        $('.npwpd').autotab('filter', 'npwpd');
    });

    function get_nama_wp() {
        //$('#wp_wr_nama').focus(function(){
        var kodepajak = $('#wp_wr_kode_pajak').val();
        var gol = $('#wp_wr_golongan').val();
        var jenispajak = $('#wp_wr_jenis_pajak').val();
        var noreg = $('#wp_wr_no_registrasi').val();
        var kdcamat = $('#wp_wr_kode_camat').val();
        var kdlurah = $('#wp_wr_kode_lurah').val();

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('esptpd/get_nama_wp') ?>",
            data: "kodepajak=" + kodepajak + "&gol=" + gol + "&jenispajak=" + jenispajak + "&noreg=" + noreg + "&kdcamat=" + kdcamat + "&kdlurah=" + kdlurah,
            dataType: "JSON",
            cache: false,
            success: function(data) {
                $('#wp_wr_nama').val(data['nama']);
            }
        });
        //});
    }

    $(document).ready(function() {
        $("#btnSave").click(function() {
            var kdpajak = $("#wp_wr_kode_pajak").val();
            var gol = $("#wp_wr_golongan").val();
            var jenispajak = $("#wp_wr_jenis_pajak").val();
            var noreg = $("#wp_wr_no_registrasi").val();
            var camat = $("#wp_wr_kode_camat").val();
            var lurah = $("#wp_wr_kode_lurah").val();
            var npwpd = kdpajak + "." + gol + "." + jenispajak + "." + noreg + "." + camat + "." + lurah;
            var userid = $("#userid").val();

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('esptpd/save_data_group') ?>",
                data: "npwpd=" + npwpd + "&userid=" + userid + "&noreg=" + noreg,
                dataType: "JSON",
                cache: false,
                success: function(data) {
                    if (data.status == true) //if success close modal and reload ajax table
                    {
                        Swal.fire({
                            title: 'Save!',
                            text: 'Your File has bees save.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });

                        $("#wp_wr_golongan").val('');
                        $("#wp_wr_jenis_pajak").val('');
                        $('#wp_wr_no_registrasi').val('');
                        $('#wp_wr_kode_camat').val('');
                        $("#wp_wr_kode_lurah").val('');
                        $("#wp_wr_nama").val('');
                        window.location.assign("<?php echo site_url('esptpd/tambah_data_group') ?>");
                    } else if (data.error == true) {
                        Swal.fire({
                            title: 'Error!',
                            text: data.msg,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }); //set button disable 
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error!!.'
                    });

                }
            });

        });
    });
</script>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Tambah Data group
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table border="0" cellpadding="2" cellspacing="0">
                            <tr>
                                <td width="180">NPWPD </td>
                                <td>:
                                    <input type="text" name="wp_wr_kode_pajak" id="wp_wr_kode_pajak" class="inputbox mandatory" size="1" maxlength="1" value="P" readonly="true" />
                                    <input type="text" name="wp_wr_golongan" id="wp_wr_golongan" class="inputbox npwpd mandatory" size="1" maxlength="1" autocomplete="off" />
                                    <input type="text" name="wp_wr_jenis_pajak" id="wp_wr_jenis_pajak" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
                                    <input type="text" name="wp_wr_no_registrasi" id="wp_wr_no_registrasi" class="inputbox npwpd mandatory" size="7" maxlength="7" autocomplete="off" />
                                    <input type="text" name="wp_wr_kode_camat" id="wp_wr_kode_camat" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
                                    <input type="text" name="wp_wr_kode_lurah" id="wp_wr_kode_lurah" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" onBlur="get_nama_wp();" />
                                </td>
                            </tr>
                            <tr>
                                <td>Nama Wajib Pajak</td>
                                <td>: <input type="text" name="wp_wr_nama" id="wp_wr_nama" class="inputbox" size="80" style="text-transform: uppercase; font-size:12px; background-color:azure;" readonly autocomplete="off" /></td>
                            </tr>
                            <tr>
                                <td colspan="2" height="10"></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="hidden" name="userid" id="userid" value="<?= $this->session->userdata('id_user') ?>">
                                    <input type="submit" name="submit" class="btn btn-info" id="btnSave" onclick="save()" value="Simpan"></input>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>