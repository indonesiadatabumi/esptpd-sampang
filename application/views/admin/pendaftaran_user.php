<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,200i,500" rel="stylesheet"> -->

    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/stylearyo.css"> -->
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css">


</head>


<body class="hold-transition login-page">
    <div class="login-box" style="margin-top:20px!important">
        <div class="login-logo">
            <strong>e-SPTPD</strong>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <div class="text-center">
                <img src="<?= base_url() ?>assets/images/logo.png" style="width:100px">
            </div>
            <p class="login-box-msg">
                <!-- Link aktivasi dikirim melalui alamat email anda -->
                User aktif apabila anda memasukkan alamat email yang sesuai saat Pendaftaran
            </p>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"> Form Register</h3>
                </div>
                <div class="card-body">
                    <form action="" id="form" method="post">
                        <div class="form-group has-feedback">
                            <input type="text" name="npwpd" id="npwpd" class="form-control" placeholder="NPWPD" data-inputmask='"mask": "P.9.99.9999999.99.99"' data-mask required>
                            <input type="hidden" name="nama" id="nama" class="form-control">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            <p id="namawp" style="font-style: oblique; font-size:small; color:gray; text-align:right"></p>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Alamat Email" required>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            <p id="emailid" style="font-style: oblique; font-size:small; color:gray; text-align:right"></p>

                        </div>

                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK/Nomor KTP" required>
                            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
                            <p id="nikid" style="font-style: oblique; font-size:small; color:gray; text-align:right"></p>

                        </div>

                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="kriteria_byr" value="1" checked>
                                <label for="radioPrimary1"> Single </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary2" name="kriteria_byr" value="2">
                                <label for="radioPrimary2"> Group </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <i class="fas fa-info-circle" style="margin-left:20px; cursor:pointer; " alt="info pembayaran" title="info pembayaran" id="opener"></i>
                                Information
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" name="pass1" id="pass1" placeholder="Password" required autocomplete="off">
                            <span class="glyphicon glyphicon-wrench form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" name="pass2" id="pass2" placeholder="Verify New Password" required autocomplete="off">
                            <span class="glyphicon glyphicon-wrench form-control-feedback pass2" style="font-style: oblique; font-size:small; color:red; text-align:right"></span>
                        </div>

                        <div class="row">
                            <!-- /.col -->
                            <div class="col-xs-4 col-xs-offset-8">
                                <input type="submit" name="submit" class="btn btn-info  btn-block " id="btnSave" value="Register"></input>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <div style="text-align:right"><a href="<?= base_url('/') ?>"><i class="fas fa-angle-double-left"></i>
                            Kembali ke Form Login</a> &nbsp;</div>
                </div>
            </div>
        </div>
        <!-- /.login-box-body -->

        <div class="help-block text-center">
        </div>
    </div>

    <span id="output"></span>

    <div id="dialog" title="Info Pembayaran">
        <p>Info kriteria pembayaran :
        <ul style="margin-left:-28px; ">
            <li type="circle"><b>Single :</b> Jika pelaporan spt dan pembayaran hanya terdiri dari satu tenant.</li>
            <li type="circle"><b>Group :</b> Jika penanggung jawab atau yang dikuasakan melakukan pelaporan dan pembayaran yang terdiri dari beberapa tenant.</li>
        </ul>
        </p>
    </div>
    <!-- /.login-box -->
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- input mask -->
    <script src="<?php echo base_url(); ?>assets/plugins/moment/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

    <!-- jquery-validation -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo base_url(); ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>



    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $('#pass2').focusout(function() {
            var pass = $('#pass1').val();
            var pass2 = $('#pass2').val();
            if (pass != pass2) {
                // alert('the passwords didn\'t match!');
                $(".pass2").text('konfirmasi password tidak cocok!');
                $('#btnSave').attr('disabled', true); //set button disable 
            } else {
                $(".pass2").text('');
                $('#btnSave').attr('disabled', false); //set button disable 
            }

        });

        $("#npwpd").blur(function() {
            // alert('npwp');
            var npwpd = $("#npwpd").val();
            if (npwpd == '') {
                $("#namawp").text('Silahkan isi npwpd..');
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('pendaftaranwp/get_namawp') ?>",
                    dataType: "JSON",
                    data: {
                        npwpd: npwpd
                    },
                    cache: false,
                    success: function(data) {
                        console.log(data);
                        $("#nama").val(data);
                        $("#namawp").text(data);
                    }
                })
            }
        });

        $("#email").blur(function() {
            // alert('npwp');
            var email = $("#email").val();
            if (email == '') {
                $("#emailid").text('Silahkan isi email..');
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('pendaftaranwp/get_email') ?>",
                    dataType: "JSON",
                    data: {
                        email: email
                    },
                    cache: false,
                    success: function(data) {
                        console.log(data);
                        if (data == '1') {
                            $('#btnSave').attr('disabled', false); //set button disable 
                            $("#emailid").text('');
                        } else {
                            $('#btnSave').attr('disabled', true); //set button disable 
                            $("#emailid").text('Email salah/Tidak Terdaftar!');
                        }
                    }
                })
            }
        });

        $("#nik").blur(function() {
            // alert('npwp');
            var nik = $("#nik").val();
            if (nik == '') {
                $("#nikid").text('Silahkan isi NIK..');
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('pendaftaranwp/get_nik') ?>",
                    dataType: "JSON",
                    data: {
                        nik: nik
                    },
                    cache: false,
                    success: function(data) {
                        // console.log(data);
                        if (data == '1') {
                            $('#btnSave').attr('disabled', false); //set button disable 
                            $("#nikid").text('');
                        } else {
                            $('#btnSave').attr('disabled', true); //set button disable 
                            $("#nikid").text('Nik salah/Tidak Terdaftar!');
                        }
                    }
                })
            }
        });


        $(document).ready(function() {

            $("#dialog").dialog({
                autoOpen: false,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });

            $("#opener").on("click", function() {
                $("#dialog").dialog("open");
            });

            $(function() {
                $('[data-mask]').inputmask();
            });
        });

        $(document).on('submit', '#form', function(e) {
            e.preventDefault();

            var npwpd = $('#npwpd').val();
            var nama = $('#nama').val();
            var email = $('#email ').val();
            var nik = $('#nik').val();
            var kriteria_byr = $('#kriteria_byr').val();
            var pass1 = $('#pass1').val();

            var url = "<?php echo site_url('pendaftaranwp/register_user') ?>";

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
                            text: 'Pendaftaran User Berhasil. Silakan lakukan aktivasi pada email anda',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            showConfirmButton: true
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            window.location.assign("<?php echo site_url('pendaftaranwp/pendaftaranuser') ?>");
                        })

                    } else if (data.error == true) {
                        Swal.fire({
                            title: 'Error!',
                            text: data.msg,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            showConfirmButton: false,
                            timer: 1500
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
                error: function(e) {
                    $("#output").text(e.responseText);
                    console.log("ERROR : ", e);
                    $('#btnSave').attr('disabled', false); //set button enable 
                    return false;
                }
            });
        });
    </script>