<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Data Laporan SPTPD</h3>
                        <div class="text-right">
                            <?php if (!empty($bil_nama)) {
                                echo $bil_nama;
                            } else {
                                echo $this->session->userdata('username');
                            } ?> -
                            <?php if (!empty($bil_npwpd)) {
                                echo $bil_npwpd;
                            } else {
                                echo $info_wp->nama;
                            } ?>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabelsubmenu" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>No</th>
                                    <th>SPT Periode</th>
                                    <th>SPT Masa </th>
                                    <th align="right">Total Pembayaran</th>
                                    <th>Tgl Lapor</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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

<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $('#noreg').change(function() {
        table.draw();
    });

    $(document).ready(function() {

        //datatables
        table = $("#tabelsubmenu").DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data Pelaporan Belum Ada"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": false, //Feature control DataTables' server-side processing mode.
            "serverMethod": "post",
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('lapor_pajak/ajax_list') ?>",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    var noreg = "<?= $this->session->userdata('username'); ?>";
                    var wp_wr_detil_id = "<?= $info_wp->wp_wr_detil_id; ?>";

                    // Append to data
                    data.searchByName = noreg;
                    data.wp_wr_detil_id = wp_wr_detil_id;
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],
        });
    });

    $(document).on('click', '#lampiran', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = $(this).data('href');

        var url = "<?php echo site_url('esptpd/lihat_lampiran') ?>/" + data;
        window.location.href = url;

    });


    $(document).on('click', '#view', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = $(this).data('href');

        var url = "<?php echo site_url('esptpd/view') ?>/" + data;
        window.location.href = url;

    });

    $(document).on('click', '#esptpd', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = $(this).data('href');

        var url = "<?php echo site_url('lapor_pajak/esptd_print') ?>/" + data;
        window.location.href = url;

    });

    $(document).on('click', '#billing2', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = $(this).data('href');

        var url = "<?php echo site_url('esptpd/espt_billing_prt') ?>/" + data;
        window.location.href = url;

    });

    $(document).on('click', '#billing', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = $(this).data('href');

        var url = "<?php echo site_url('esptpd/espt_billing') ?>/" + data;
        window.location.href = url;

    });


    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = $(this).data('href');

        Swal.fire({
            title: 'Apakah anda Yakin?',
            text: "akan menghapus Billing: " + data,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value == true) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('esptpd/billing_hapus') ?>",
                    data: {
                        idbilling: data
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Deleted!',
                                'Billing berhasil di hapus.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr, thrownError) {
                        Swal.fire(
                            'Billing Gagal dihapus!.',
                            '',
                            'error'
                        )
                    }
                });
            }
        });

    });


    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });


    //view
    // $(".v_submenu").click(function(){
    function vsubmenu(id) {
        $('.modal-title').text('View Submenu');
        $("#modal-default").modal();
        $.ajax({
            url: '<?php echo base_url('submenu/viewsubmenu'); ?>',
            type: 'post',
            data: 'table=tbl_submenu&id=' + id,
            success: function(respon) {

                $("#md_def").html(respon);
            }
        })


    }

    function edit_submenu(id) {
        var url = "<?php echo site_url('esptpd/verifikasi') ?>/" + id;
        Window.location.href(url);
    }
</script>