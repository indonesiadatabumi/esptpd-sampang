<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <select id="kecamatan" name="kecamatan">
                            <option value="">---- PILIH KECAMATAN ----</option>
                            <option value="010">BAKUNG</option>
                            <option value="020">WONOTIRTO</option>
                            <option value="030">SUTOJAYAN</option>
                            <option value="040">PANGGUNGREJO</option>
                            <option value="050">WATES</option>
                            <option value="060">BINANGUN</option>
                            <option value="070">KESAMBEN</option>
                            <option value="080">SELOREJO</option>
                            <option value="090">DOKO</option>
                            <option value="100">WLINGI</option>
                            <option value="110">SELOPURO</option>
                            <option value="120">TALUN</option>
                            <option value="130">KANIGORO</option>
                            <option value="140">KADEMANGAN</option>
                            <option value="150">SANANKULON</option>
                            <option value="160">SRENGAT</option>
                            <option value="170">WOONODADI</option>
                            <option value="180">UDANAWU</option>
                            <option value="190">PONGGOK</option>
                            <option value="200">NGLEGOK</option>
                            <option value="210">GARUM</option>
                            <option value="220">GANDUSARI</option>
                        </select>
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

        $('#kecamatan').change(function() {
            table.draw();
        });

        //datatables
        var table = $("#tbl_datawp").DataTable({
            dom: 'Bfrtip',
            buttons: {
                buttons: [{
                    'text': 'Cetak Data User',
                    'className': 'btn-default',
                    'action': function(data) {
                        window.open('rekapdatawp/cetakdatauser?search=' + $('#kecamatan').val(), "", "width=800,height=1200,titlebar=no,toolbar=no,location=no,status=no,menubar=no");
                    }
                }, 'excel'],
                dom: {
                    button: {
                        className: 'btn'
                    },
                    buttonLiner: {
                        tag: null
                    }
                }
            },
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data WP Belum Ada"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "serverMethod": "post",
            "searching": false, //remove default searching
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('rekapdatawp/ajax_list') ?>",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    var kecamatan = $('#kecamatan').val();
                    // Append to data
                    data.searchByName = kecamatan;
                }
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