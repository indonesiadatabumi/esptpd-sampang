<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <form action="" method="post">
                            <select name="kecamatan">
                                <option value="">---- PILIH KECAMATAN ----</option>
                                <option value="11">BEKASI TIMUR</option>
                                <option value="12">BEKASI BARAT</option>
                                <option value="13">BEKASI UTARA</option>
                                <option value="14">BEKASI SELATAN</option>
                                <option value="15">JATI ASIH</option>
                                <option value="16">PONDOK GEDE</option>
                                <option value="17">BANTAR GEBANG</option>
                                <option value="18">JATI SAMPURNA</option>
                                <option value="19">RAWA LUMBU</option>
                                <option value="20">MEDAN SATRIA</option>
                                <option value="21">MUSTIKA JAYA</option>
                                <option value="22">PONDOK MELATI</option>

                            </select>
                            <button class="btn btn-success btn-sm fa" name="submit" id="submit">SUBMIT</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Rekap Data User Per Kecamatan </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_datawp" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>No.</th>
                                    <th>NPWPD</th>
                                    <th>Nama WP</th>
                                    <th>Email</th>
                                    <th>Kecamatan</th>
                                    <th>Status</th>
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
                "url": "<?php echo site_url('rekapdatawp/ajax_list') ?>",
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

    function edit_brg(wr_id, no_urut, bid_usaha) {

        // alert(wr_id + ' ' + no_urut + ' ' + bid_usaha);
        // save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('datawp/lihat') ?>",
            data: {
                wr_id: wr_id,
                no_urut: no_urut,
                bid_usaha: bid_usaha
            },
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id"]').val(data.id);
                $('[name="nama"]').val(data.nama);
                $('[name="harga"]').val(data.harga);
                $('[name="satuan"]').val(data.satuan);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Barang'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>