<script language="javascript" src="<?= base_url('assets/js/main.js') ?>"></script>
<script language="javascript" src="<?= base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
<!-- <script language="javascript" src="<?= base_url('assets/js/add_pajak_hiburan.js') ?>"></script> -->

<script>
    $(document).ready(function() {
        $("select[name=nama_rekening]").change(function() {
            var rek_id = '9';
            $.ajax({
                type: "POST",
                url: "<?= site_url('esptpd/get_tarif') ?>",
                dataType: "JSON",
                data: {
                    rek_id: rek_id
                },
                cache: false,
                success: function(data) {
                    // console.log(data);
                    $("#korek_persen_tarif").val(data['nilai']);
                }
            });
            $("#kode_rekening_id").val(rek_id);
        });
    });


    var insertOptionRekening = function(idSelect) {
        var korek = {
            korek: "41103"
        };
        $.getJSON("<?= site_url('esptpd/get_korek') ?>", korek, function(data) {
            var option = "";
            option += "<option value=''>--</option>";
            if (data.total != undefined && data.total > 0) {
                $.each(data.list, function(id, obj) {
                    option += "<option value='" + obj.key + "'>" + obj.value + "</option>";
                });
            }
            $("#" + idSelect).append(option);
        });
    };

    /**
     * check kode rekening is exist
     * @param n
     * @returns
     */
    var checkKorek = function(id) {
        var i = $('#detailTable tr').length - 3;
        for (k = 1; k <= i; k++) {
            try {
                if (document.getElementById('spt_dt_korek' + k).value == document.getElementById('spt_dt_korek' + id).value && k != id) {
                    showWarning('Kode Rekening yang sama sudah terpilih. Mohon pilih kode rekening lainnya!');
                    $('#spt_dt_korek' + id).val('');
                    $('#spt_dt_korek' + id).focus();
                    return false;
                }
            } catch (ex) {}
        }
    };

    /**
     * parsing string by comma
     * @param arr
     * @returns
     */
    var parseComma = function(arr) {
        if (arr == "") arr = ',';
        var myString = new String(arr);
        var myStringList = myString.split(','); // split on commas
        return myStringList;
    };

    /**
     * get tarif by rekening
     * @returns
     */
    var getTarif = function(objPersen, obTarifDasar, val) {
        $('#' + objPersen).val(parseComma(val)[1]);
    };

    /**
     * getPajak
     * @returns
     */
    var getPajak = function(objSptPajak, objPersen, objDasarPengenaan, objTarifDasar, objJumlahPajak) {
        if ($('#' + objJumlahPajak).val() != "" && $('#' + objTarifDasar).val() != "" && $('#' + objPersen).val() != "" && $('#' + objDasarPengenaan).val() != "") {
            tarifDasar = unformatCurrency($("#" + objTarifDasar).val());
            persenTarif = unformatCurrency($('#' + objPersen).val());
            var pajak = Math.round(tarifDasar * persenTarif / 100);
            $('#' + objTarifDasar).val(formatCurrency($('#' + objTarifDasar).val()));
            $('#' + objSptPajak).val(formatCurrency(pajak));
        }
    };

    /**
     * to calculate
     * @returns
     */
    var calc1 = function() {
        var nilai = "";
        var i = 1;
        $('#spt_pajak').val("");
        var rowCount = $('#detailTable tr').length;
        while (i <= rowCount) {
            try {
                var pajak = ($('#spt_pajak').val().toString().replace(/\$|\,00/g, '').replace(/\$|\./g, '') * 1) + ($("#spt_dt_pajak" + i + "").val().toString().replace(/\$|\,00/g, '').replace(/\$|\./g, '') * 1);
                $('#spt_pajak').val(pajak);
            } catch (ex) {}
            i++;
            $('#spt_pajak').val(formatCurrency($('#spt_pajak').val()));
        }
    };

    /**
     * addForm field
     * @returns
     */
    var addFormField = function() {
        var rowCount = $('#detailTable tr').length;
        var id = rowCount - 2;
        counter = 0;
        while (counter < 40) {
            if ($('#row_detail' + id).length == 0) {
                break;
            } else {
                id++;
            }
            counter++;
        }
        rowField = appendRowField(id);

        insertOptionRekening('spt_dt_korek' + id);
        $("#detailTable").append(rowField);
    };

    var addFormField_specs = function() {
        var rowCount = $('#detailTable_s tr').length;
        var id = rowCount - 2;
        counter = 0;
        while (counter < 40) {
            if ($('#row_detail_s' + id).length == 0) {
                break;
            } else {
                id++;
            }
            counter++;
        }
        rowField = appendRowField_s(id);

        //insertOptionRekening('spt_dt_korek'+id);
        $("#detailTable_s").append(rowField);
    };

    var appendRowField = function(id) {
        var rowField =
            '<tr class="row0" id="row_detail' + id + '" >' +
            '<td>' +
            '<select name="spt_dt_korek[]" id="spt_dt_korek' + id + '" style="width: 300px" class="inputbox" ' +
            'onchange=" checkKorek(' + id + '); getTarif (\'spt_dt_persen_tarif' + id + '\',\'spt_dt_tarif_dasar' + id + '\',this.value); ' +
            'getPajak(\'spt_dt_pajak' + id + '\',\'spt_dt_persen_tarif' + id + '\',\'spt_dt_dasar_pengenaan' + id + '\',\'spt_dt_tarif_dasar' + id + '\',\'spt_dt_jumlah' + id + '\');' +
            'calc1();">' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<input type="text" name="spt_dt_dasar_pengenaan[]" id="spt_dt_dasar_pengenaan' + id + '" class="inputbox" size="16" value="" onchange="getPajak(\'spt_dt_pajak' + id + '\',\'spt_dt_persen_tarif' + id + '\',\'spt_dt_dasar_pengenaan' + id + '\',\'spt_dt_dasar_pengenaan' + id + '\',\'spt_dt_jumlah' + id + '\');calc1();" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" style="text-align:right;" autocomplete="off"/>' +
            '</td>' +
            '<td align="right">' +
            '<input type="text" name="spt_dt_persen_tarif[]" id="spt_dt_persen_tarif' + id + '" class="inputbox" size="2" value=""  readonly="true" style="text-align:right;"/>' +
            '</td>' +
            '<td align="right">' +
            '<input type="text" name="spt_dt_pajak[]" id="spt_dt_pajak' + id + '" class="inputbox" size="16" value="" readonly="true" style="text-align:right;"/></td>' +
            '<td><a href="#" onClick="removeFormField(\'#row_detail' + id + '\');calc1();return false;">Hapus</a></td>' +
            '</tr>';

        return rowField;
    };

    var appendRowField_s = function(id) {
        var rowField =
            '<tr class="row0" id="row_detail_s' + id + '" >' +
            '<td>' +
            '<input type="text" name="nama_x[]" id="nama_x' + id + '" class="inputbox" size="50" value=""  autocomplete="off"/>' +
            '</td>' +
            '<td align="right">' +
            '<input type="text" name="specs_xx[]" id="specs_xx' + id + '" class="inputbox" size="20" value=""  style="text-align:right;"/>' +
            '</td>' +
            '<td align="right">' +
            '<input type="text" name="specs_xxx[]" id="specs_xxx' + id + '" class="inputbox" size="20" value="" style="text-align:right;"/></td>' +
            '<td><a href="#" onClick="removeFormField_s(\'#row_detail_s' + id + '\');calc1();return false;">Hapus</a></td>' +
            '</tr>';

        return rowField;
    };

    var getKorekId = function(korek_id) {
        var korekID = parseComma(korek_id)[0];
        //if(korekID==13){
        $.ajax({
            type: "POST",
            url: "hiburan_specs_frm.php",
            data: "korek_id=" + korekID,
            cache: false,
            success: function(frm) {
                $("#specs_hiburan").html(frm);
            }
        });

        //completePage_s();
        //}
    }
    /**
     * removeFormField tr
     * @returns
     */
    var removeFormField = function(id) {
        var x = window.confirm('Anda yakin akan menghapus detail tersebut?');
        if (x)
            return $(id).remove();
        else
            return;
    };

    var removeFormField_s = function(id) {
        return $(id).remove();
    };

    /**
     * onCompletePage
     * @returns
     */
    var completePage = function() {
        $('#btn_add_detail').click(function() {

            addFormField();
        });
        $(function() {
            $("#spt_tgl_proses, #spt_tgl_entry").datepicker({
                dateFormat: "dd/mm/yy",
                showOn: "button",
                buttonImage: "images/calendar.gif",
                buttonImageOnly: true,
                duration: "fast",
                maxDate: "D",
                buttonText: "Select date"
            });
            $('#spt_tgl_proses, #spt_tgl_entry').datepicker('setDate', 'c');

            $("#fDate, #tDate").datepicker({
                dateFormat: "dd/mm/yy",
                showOn: "button",
                buttonImage: "images/calendar.gif",
                buttonImageOnly: true,
                buttonText: "Select date",
                onSelect: function(selectedDate) {
                    if (this.id == "fDate") {
                        ldmonth(this);
                    }
                }
            });

            $("#spt_tgl_proses, #spt_tgl_entry, #fDate, #tDate").change(function() {
                isValidDate(this.id, "dd-mm-yy");
            });

        });
    };

    var completePage_s = function() {
        $('#btn_add_detail_s').click(function() {
            addFormField_specs();
        });

    };

    var ldmonth = function(obj) {
        var T = obj.value;
        var D = new Date();
        var dt = T.split("/");
        D.setFullYear(dt[2]); //alert("__1_>"+D.toString());  
        D.setMonth(dt[1] - 1); // alert("__2_>"+D.toString());  
        D.setDate("32");
        var ldx = 32 - D.getDate();
        var m = D.getMonth();
        if (m == "0") m = "12";
        if (m < 10) m = "0" + m;
        var ldo = ldx + "/" + m + "/" + dt[2]; //D.getFullYear();
        if (ldo != "NaN-NaN-undefined") {
            $('input[name=spt_periode_jual2]').val(ldo);
        } else {
            $('input[name=spt_periode_jual2]').val('');
        }
    };

    $(document).ready(function() {
        completePage();
    });
</script>

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
                            <i class="nav-icon fas fa-music"></i>
                            EDIT SPTPD Hiburan
                        </h3>
                    </div>

                    <!-- Form Input -->
                    <form name="sptpdForm" id="form" method="post" enctype="multipart/form-data">
                        <table class="table">
                            <tr>
                                <td><label for="no_sptpd">No. SPTPD</label></td>
                                <td><input type="hidden" name="kode_billing" id="kode_billing" class="form-control-sm" value="<?= $kode_billing ?>" size="3" readonly="true" style="background-color:azure;" />
                                    <input type="hidden" name="spt_id" id="spt_id" class="form-control-sm" value="<?= $spt_id ?>" size="3" readonly="true" style="background-color:azure;" />
                                    <input type="hidden" name="spt_dt_id" id="spt_dt_id" class="form-control-sm" value="<?= $spt_dt_id ?>" size="3" readonly="true" style="background-color:azure;" />
                                    <input type="hidden" name="wp_id" id="wp_id" class="form-control-sm" value="<?= $wp_id ?>" size="3" readonly="true" style="background-color:azure;" />
                                    <input type="hidden" name="spt_jenis" id="spt_jenis" class="form-control-sm" value="3" size="3" readonly="true" style="background-color:azure;" />
                                    <input type="hidden" name="spt_status" id="spt_status" class="form-control-sm" value="8" size="3" readonly="true" style="background-color:azure;" />
                                    <input type="hidden" name="kd_rekening" id="kd_rekening" class="form-control-sm" value="41103" size="30" readonly="true" style="background-color:azure;" />
                                    <input type="text" name="kd_spt" id="kd_spt" class="form-control-sm" value="<?= $kode_spt ?>" size="3" readonly="true" style="background-color:azure;" />
                                    <input type="text" name="no_sptpd" id="no_sptpd" class="form-control-sm mandatory" size="15" value="<?= $no_register ?>" maxlength="5" readonly="true" style="background-color:azure;" />
                                    <!-- <span style="vertical-align:middle; "><img src="<?= base_url('assets/images/reload.png') ?>" title="refresh spt" style="cursor:pointer; " id="btnRefresh"></span> -->
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="password">NPWPD</label>
                                </td>
                                <td>
                                    <input type="text" name="npwpd" id="npwpd" class="form-control-sm" value="<?= $npwprd ?>" readonly="true" style="background-color:azure;" />
                            </tr>
                            <tr>
                                <td>
                                    <label for="nama_wp">Nama WP</label>
                                </td>
                                <td>
                                    <input type="text" name="nama_lengkap_wp" id="nama_lengkap_wp" class="form-control-sm" size="40" readonly="true" value="<?= $nama ?>" style="background-color:azure;text-transform: uppercase;" />
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
                                    <label for="nama_wp">Kelurahan</label>
                                </td>
                                <td>
                                    <input type="text" name="kelurahan" id="kelurahan" class="form-control-sm" size="40" readonly="true" value="<?= $kelurahan ?>" style="background-color:azure;text-transform: uppercase;" />
                            </tr>
                            <tr>
                                <td>
                                    <label for="nama_wp">Kecamatan</label>
                                </td>
                                <td>
                                    <input type="text" name="kecamatan" id="kecamatan" class="form-control-sm" size="40" readonly="true" value="<?= $kecamatan ?>" style="background-color:azure;text-transform: uppercase;" />
                            </tr>
                            <tr>
                                <td>
                                    <label for="nama_wp">Kota</label>
                                </td>
                                <td>
                                    <input type="text" name="kota" id="kota" class="form-control-sm" size="40" readonly="true" value="<?= $kota ?>" style="background-color:azure;text-transform: uppercase;" />
                            </tr>
                            <tr>
                                <td valign="top">
                                    <label for="gid">Masa Pajak</label>

                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-3">
                                            <div class="form-group">

                                                <div class="input-group date" id="searchStartDate" data-target-input="nearest">
                                                    <!-- onchange="changeDate(this);" -->
                                                    <input type="text" class="form-control datetimepicker-input StartDate" name="spt_periode_jual1" id="StartDate" value="<?= $masa_awal ?>" maxlength="12" placeholder="yyyy-mm-dd" style="background-color:bisque;" data-target="#searchStartDate" />
                                                    <div class="input-group-append" data-target="#searchStartDate" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>s/d
                                        <div class="col-xs-3 col-sm-3">
                                            <div class="form-group">
                                                <div class="input-group date" id="searchEndDate" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input EndDate" name="spt_periode_jual2" id="EndDate" value="<?= $masa_akhir ?>" maxlength="12" placeholder="yyyy-mm-dd" style="background-color:bisque;" data-target="#searchEndDate" />
                                                    <div class="input-group-append" data-target="#searchEndDate" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="password">Periode Lapor SPT</label>
                                </td>
                                <td>
                                    <input type="text" name="spt_periode" id="spt_periode" size="11" value="<?= date('Y') ?>" class="form-control-sm" style="background-color:bisque;" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <fieldset class="adminform">
                                        <legend>DETAIL HIBURAN</legend>
                                        <table class="admintable" border=0 cellspacing="1" width="100%">
                                            <tr>
                                                <td>
                                                    <div id="detailSelf">
                                                        <table class="adminlist" cellspacing="1" id="detailTable" border="0" width="100%">
                                                            <thead style="background-color:azure;">
                                                                <tr>
                                                                    <th class=" title" rowspan="2" style="width:100px; vertical-align:middle; text-align:center;">Kode Rekening</th>
                                                                    <th class="title">Dasar Pengenaan</th>
                                                                    <th class="title">Persen Tarif</th>
                                                                    <th class="title">Pajak</th>
                                                                    <th class="title" rowspan="2" width="40" style="width:100px; vertical-align:middle; text-align:center;">-</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="title" width="80px">(a)</th>
                                                                    <th class="title" width="50px">(b)</th>
                                                                    <th class="title" width="250px">(a x b)</th>
                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="5">
                                                                    </td>
                                                                </tr>
                                                            </tfoot>

                                                            <tbody id="tbody_detail">
                                                                <?php
                                                                $counter = 1;
                                                                foreach ($espt_detil as $detail) {
                                                                ?>
                                                                    <tr class="row0" id="row_detail<?= $counter ?>">
                                                                        <td>
                                                                            <input type="hidden" name="spt_dt_id[]" value="<?= $detail->spt_dt_id; ?>">
                                                                            <select name="spt_dt_korek[]" id="spt_dt_korek<?= $counter ?>" class="inputbox" onchange="checkKorek(<?= $counter ?>);
                                                                                getTarif('spt_dt_persen_tarif<?= $counter ?>','spt_dt_tarif_dasar<?= $counter ?>',this.value);
                                                                                getPajak('spt_dt_pajak<?= $counter ?>','spt_dt_persen_tarif<?= $counter ?>','spt_dt_dasar_pengenaan<?= $counter; ?>','spt_dt_dasar_pengenaan<?= $counter; ?>','spt_dt_jumlah<?= $counter ?>');
                                                                                calc1();" style="width:300px; ">
                                                                                <option value="">--</option>
                                                                                <?php
                                                                                foreach ($v_rekening as $rekening) {
                                                                                    if ($detail->spt_dt_korek == $rekening->korek_id)
                                                                                        $selected = "selected";
                                                                                    else
                                                                                        $selected = "";
                                                                                ?>
                                                                                    <option value="<?= $rekening->korek_id ?>" <?= $selected; ?>><?= $rekening->korek_nama; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="spt_dt_dasar_pengenaan[]" id="spt_dt_dasar_pengenaan<?= $counter ?>" value="<?= number_format($detail->spt_dt_jumlah, 2, ",", ".") ?>" class="inputbox" size="16" onchange="getPajak('spt_dt_pajak<?= $counter ?>','spt_dt_persen_tarif<?= $counter ?>','spt_dt_dasar_pengenaan<?= $counter; ?>','spt_dt_dasar_pengenaan<?= $counter; ?>','spt_dt_jumlah<?= $counter ?>');calc1();" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" style="text-align:right;" autocomplete="off" />
                                                                        </td>
                                                                        <td align="right">
                                                                            <input type="text" name="spt_dt_persen_tarif[]" id="spt_dt_persen_tarif<?= $counter ?>" class="inputbox" value="<?= $detail->spt_dt_persen_tarif ?>" readonly="true" style="text-align:right;width:60%; background-color:azure;" />
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="spt_dt_pajak[]" id="spt_dt_pajak<?= $counter ?>" class="numeric" value="<?= number_format($detail->spt_dt_pajak, 2, ",", ".") ?>" readonly="true" style="text-align:right;width:100%; background-color:azure;" />
                                                                        </td>
                                                                        <td>
                                                                            <a href="#" class="btn btn-xs btn-outline-danger" onClick="removeFormField('#row_detail<?= $counter ?>');calc1();return false;"><i class="fa fa-trash-alt"></i> Hapus</a>
                                                                        </td>
                                                                    </tr>


                                                                <?php $counter++;
                                                                } ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input type="BUTTON" value="TAMBAH DETAIL" id="btn_add_detail">
                                                    &nbsp;&nbsp;&nbsp; TOTAL &nbsp;&nbsp;&nbsp;
                                                    <input type="text" name="spt_pajak" id="spt_pajak" class="inputbox" size="20" value="<?= number_format($spt_pajak, 2, ",", "."); ?>" readonly="true" style="font-weight:bold;font-size:25px;color:#18F518;background-color:black;text-align:right;" />
                                                </td>
                                            </tr>
                                        </table>
                                    </fieldset>
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
                            <p>- Masukkan Data - data Laporan:</p>
                            <p>- Masa Pajak, Periode, Omzet dan Lampiran Laporan berformat .pdf</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="callout callout-danger">
                            <h5><i class="fas fa-file-upload"></i> Upload Lampiran :</h5>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="imagefile" id="imagefile">
                                <label class="custom-file-label" for="imagefile" accept=".pdf" style="color:red;" required> * Upload file Pdf</label>
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
                    <input type="submit" name="submit" class="btn btn-info float-right" id="btnSave" onclick="save()" value="Simpan"></input>
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
        if ($('#disclamer').is(":checked")) {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 
            var url = "<?php echo site_url('esptpd/insert_hp') ?>";

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

                        $('#btnSave').text('save'); //change button text
                        $('#btnSave').attr('disabled', false); //set button enable 
                        window.location.assign("<?php echo site_url('esptpd/billing') ?>");
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
    $(function() {
        var d = new Date(),
            n = d.getMonth() + 1;
        var masa_pajak = $('#StartDate').val();
        masa_pajak = masa_pajak.substring(5, 7)

        $('input[type="submit"]').prop('disabled', false);

        if (masa_pajak == n) {
            $('input[type="submit"]').prop('disabled', true);
        } else {
            $('input[type="submit"]').prop('disabled', false);
        }

    });
</script>