<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fa fa-list text-blue"></i> Status Bayar Wajib Pajak</h3>
                        <!-- <div class="text-right">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_brg()" title="Add Data"><i class="fas fa-plus"></i> Add</button>
                        </div> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_bayar" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>No</th>
                                    <th>No. Kohir</th>
                                    <th>Nama WP</th>
                                    <th>Tgl_input</th>
                                    <th>Periode</th>
                                    <th>Masa Pajak</th>
                                    <th>Nilai Pajak</th>
                                    <th>Kode Bayar</th>
                                    <th>Status Bayar</th>
                                    <th>#</th>
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
        table = $("#tbl_bayar").DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data Barang Belum Ada"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('bayar/ajax_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [-1], //last column
                    "render": function(data, type, row) {

                        return "<a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"update(" + row[0] + ")\"><i class=\"fas fa-edit\"></i></a>";

                    },

                    "orderable": false, //set not orderable
                },

            ],
        });

        //set input/textarea/select event when change value, remove class error and remove text help block 
        $("input").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
        $("textarea").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
        $("select").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
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


    //delete
    function delbrg(id) {

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            $.ajax({
                url: "<?php echo site_url('bayar/delete'); ?>",
                type: "POST",
                data: "id=" + id,
                cache: false,
                dataType: 'json',
                success: function(respone) {
                    if (respone.status == true) {
                        reload_table();
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Delete Error!!.'
                        });
                    }
                }
            });
        })
    }

    function update2(id) {
        swal.fire({
            title: 'Are you sure?',
            text: "Yakin akan merubah Status bayar ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then(function(result) {

            $.ajax({
                url: "<?php echo site_url('bayar/update'); ?>",
                type: "POST",
                data: "id=" + id,
                cache: false,
                dataType: 'json',
                success: function(respone) {
                    if (respone.status == true) {
                        reload_table();
                        Swal.fire(
                            'Update!',
                            'Status Berhasil di Update.',
                            'success'
                        );
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Delete Error!!.'
                        });
                    }
                }
            });
        });
    }

    function update(id) {
        swal.fire({
            title: 'Are you sure?',
            text: "Yakin akan merubah Status bayar ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then(function(result) {

            if (result.value) {
                $.ajax({
                    url: "<?php echo site_url('bayar/update'); ?>",
                    type: "POST",
                    data: "id=" + id,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        swal.fire({
                            title: 'Please Wait..!',
                            text: 'Is working..',
                            onOpen: function() {
                                swal.showLoading()
                            }
                        })
                    },
                    success: function(data) {
                        reload_table();
                        Swal.fire(
                            'Update!',
                            'Status Berhasil di Update.',
                            'success'
                        );
                        // swal.fire({
                        //     position: 'top-right',
                        //     type: 'success',
                        //     title: 'Status  Updated successfully',
                        //     showConfirmButton: false,
                        //     timer: 2000
                        // });
                    },
                    complete: function() {
                        swal.hideLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swal.hideLoading();
                        swal.fire("!Opps ", "Something went wrong, try again later", "error");
                    }
                });
            }
        });
    }

    function edit_byr(id) {
        alert(id);
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('bayar/edit_bayar') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id"]').val(data.id);
                $('[name="nama"]').val(data.nama);
                $('[name="harga"]').val(data.harga);
                $('[name="satuan"]').val(data.satuan);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Bayar'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function save() {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        if (save_method == 'add') {
            url = "<?php echo site_url('bayar/insert') ?>";
        } else {
            url = "<?php echo site_url('bayar/update') ?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                    Toast.fire({
                        icon: 'success',
                        title: 'Success!!.'
                    });
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass('invalid-feedback');
                    }
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }
</script>



<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">

            <div class="modal-header">
                <h3 class="modal-title">Person Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="card-body">
                        <div class="form-group row ">
                            <label for="nama" class="col-sm-3 col-form-label">Nama Barang</label>
                            <div class="col-sm-9 kosong">
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Barang">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="nama_owner" class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-9 kosong">
                                <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="alamat" class="col-sm-3 col-form-label">Satuan</label>
                            <div class="col-sm-9 kosong">
                                <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->