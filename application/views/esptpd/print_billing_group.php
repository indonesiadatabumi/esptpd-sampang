<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Cetak Kode Billing Data group
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="<?php echo base_url('esptpd/espt_group_prt'); ?>" method="post">
                            <div class="row">
                                <div class="col-xs-3 col-sm-3">

                                    <label for="tanggal" class="col-sm-6 col-form-label">Periode : </label>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="periode" maxlength="5" value="<?= date('Y') ?>" />
                                    </div>

                                </div>

                            </div>
                            <div class="col-xs-3 col-sm-3">

                                <label for="tanggal" class="col-sm-6 col-form-label">Masa Pajak : </label>

                                <div class="form-group">

                                    <div class="input-group date" id="searchStartDate" data-target-input="nearest">

                                        <input type="text" class="form-control datetimepicker-input StartDate" name="spt_periode_jual1" id="StartDate" maxlength="10" placeholder="yyyy-mm-dd" data-target="#searchStartDate" />

                                        <div class="input-group-append" data-target="#searchStartDate" data-toggle="datetimepicker">

                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xs-3 col-sm-3">

                                <label for="tanggal" class="col-sm-6 col-form-label">s/d : </label>

                                <div class="form-group">

                                    <div class="input-group date" id="searchEndDate" data-target-input="nearest">

                                        <input type="text" class="form-control datetimepicker-input EndDate" name="spt_periode_jual2" id="EndDate" maxlength="10" placeholder="yyyy-mm-dd" data-target="#searchEndDate" />

                                        <div class="input-group-append" data-target="#searchEndDate" data-toggle="datetimepicker">

                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xs-3 col-sm-3">
                                <!-- <label for="tanggal" class="col-sm-6 col-form-label"> Klik untuk Cetak</label> -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-success" title="Add Data"><i class="fas fa-print"></i> Cetak Billing</button>
                                    <!-- <button type="button" class="btn btn-sm btn-success" onclick="location.href='<?php echo base_url('esptpd/espt_group_prt'); ?>'" title="Add Data"><i class="fas fa-print"></i> Cetak Billing</button> -->
                                </div>

                            </div>
                        </form>
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

<script>
    $(document).ready(function() {

        $('#searchStartDate').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#searchEndDate').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });

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
</script>