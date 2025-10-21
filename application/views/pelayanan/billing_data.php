<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Verifikasi Laporan eSPTPD</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabelsubmenu" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>Nomor <br />Reg. SPT</th>
                                    <th>Tanggal Input</th>
                                    <th>Nama WP</th>
                                    <th>SPT Periode</th>
                                    <th>SPT Masa </th>
                                    <th>Tgl. Jatuh Tempo</th>
                                    <th align="right">SPT Pajak</th>
                                    <!-- <th align="right">Denda</th>
                                    <th align="right">Jml Harus Dibayar</th> -->
                                    <th>Kode Billing</th>
                                    <th>Status</th>
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

    // $('#noreg').change(function() {
    //     table.draw();
    // });

    $(document).ready(function() {

        //datatables
        table = $("#tabelsubmenu").DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data Billing Belum Ada"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode. 
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('pelayanan/ajax_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],
        });
    });



    $(document).on('click', '#edit', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = $(this).data('href');

        var url = "<?php echo site_url('pelayanan/register') ?>/" + data;
        window.location.href = url;

    });


    $(document).on('click', '#view', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = $(this).data('href');

        var url = "<?php echo site_url('pelayanan/view') ?>/" + data;
        window.location.href = url;

    });

    $(document).on('click', '#esptpd', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = $(this).data('href');

        var url = "<?php echo site_url('pelayanan/espt_print') ?>/" + data;
        window.location.href = url;

    });

    $(document).on('click', '#billing2', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = $(this).data('href');

        var url = "<?php echo site_url('pelayanan/espt_billing_prt') ?>/" + data;
        window.location.href = url;

    });

    $(document).on('click', '#billing', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = $(this).data('href');

        var url = "<?php echo site_url('pelayanan/espt_billing') ?>/" + data;
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

            $.ajax({
                type: "post",
                url: "<?= site_url('pelayanan/billing_hapus') ?>",
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
                    Swal(
                        'Billing Gagal dihapus!.',
                        'error'
                    )
                }
            });

        })

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
</script>