<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Penerimaan Pajak Hiburan Tanggal <?= date('d/m/Y'); ?> </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_datawp" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>No.</th>
                                    <th>NPWPD</th>
                                    <th>Kode Billing</th>
                                    <th>Tahun</th>
                                    <th>Jml. Pajak</th>
                                    <th>Denda</th>
                                    <th>jml Bayar</th>
                                    <th>Tgl Bayar</th>
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

    $(document).ready(function() {

        //datatables
        table = $("#tbl_datawp").DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ],
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data WP Belum Ada"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('penerimaan/ajax_list') ?>",
                "data": {
                    jenis: '4'
                },
                "type": "POST"
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
</script>