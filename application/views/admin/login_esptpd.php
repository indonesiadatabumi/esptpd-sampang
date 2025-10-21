<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/fav.ico">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $aplikasi->title; ?> | Login</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">


    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-5.5.0/css/all.min.css">
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-4.3.0/css/all.min.css"> -->
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
    <!-- Body style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/stylearyo.css">
    <!-- iCheck -->
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/square/blue.css"> -->
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css">

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,300,100,700,900' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/lib/getmdl-select.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/lib/nv.d3.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/application.min1.css">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontawesome/css/all.min.css">
    <!-- endinject -->

</head>

<body>
    <header>
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow mb-10">
            <a class="navbar-nav mx-sm-2" href="#"></a>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="<?= site_url('loginadmin') ?>">Admin <i class="fas fa-sign-in-alt"></i></a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="mdl-layout mdl-js-layout color--gray is-small-screen login">
        <main class="mdl-layout__content">
            <div class="mdl-card mdl-card__login mdl-shadow--2dp">
                <div class="mdl-card__supporting-text color--dark-gray">
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                            <span class="mdl-card__title-text text-color--smooth-gray">LOGIN WAJIB PAJAK</span>
                        </div>
                        <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                            <span class="login-name text-color--white">Sign in</span>
                        </div>
                        <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                            <form action="" role="form" id="quickForm" method="post">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="wp_wr_kode_pajak">Masukkan </label>
                                        <div class="input-group mb-3 kosong">
                                            <input type="text" name="wp_wr_kode_pajak" id="wp_wr_kode_pajak" class="form-control" size="1" maxlength="1" style="width: 10;" value="P" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="username">NPWPD</label>
                                        <div class="input-group mb-3 kosong">
                                            <input type="text" name="username" id="username" class="form-control" data-inputmask='"mask": "9.99.9999999.99.99"' data-mask>
                                        </div>
                                    </div>
                                </div>
                                <label for="password">Password</label>
                                <div class="input-group mb-3 kosong">
                                    <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo set_value('password'); ?>">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>

                        </div>
                        <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone submit-cell">
                            <a href="sign-up.html" class="login-link">Lupa password?</a>
                            <div class="mdl-layout-spacer"></div>
                            <buttons id="login" class="mdl-button mdl-js-button mdl-button--raised color--light-blue">
                                LOG IN
                            </buttons>
                        </div>
                        </form>
                        <?php
                        if (!empty($pesan)) {
                            echo $pesan;
                        } ?>

                        <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-phone">
                            <a href="<?= site_url('pendaftaranwp/pendaftaranuser') ?>">
                                <button class="mdl-button center mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-green full-size">
                                    <i class="material-icons" role="presentation"></i>
                                    Register User
                                </button>
                            </a>
                            <a href="<?= site_url('pendaftaranwp') ?>">
                                <button class="mdl-button center mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-red">
                                    <i class="material-icons" role="presentation"></i>
                                    Pendaftaran WP
                                </button>
                            </a>
                            <!-- <a href="<?= site_url('sendmail') ?>">
                                <button class="mdl-button center mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-red">
                                    <i class="material-icons" role="presentation"></i>
                                    Send Email
                                </button>
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- inject:js -->
    <script src="<?php echo base_url(); ?>assets/js/d3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/getmdl-select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/material.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/nv.d3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/layout/layout.min.js"></script>
    <!-- <script language="javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script> -->
    <!-- <script language="javascript" src="<?php echo base_url(); ?>assets/js/jquery.autotab.js"></script> -->
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>

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
        $(document).ready(function() {
            $("#username").focus();
        });

        $(function() {
            $('[data-mask]').inputmask();

            // $.autotab({
            //     tabOnSelect: true
            // });
            // $('.wp_npwpd').autotab('filter', 'wp_npwpd');
        });
    </script>

    <script>
        $("#login").on('click', function() {
            $.ajax({
                url: '<?php echo base_url('login/login') ?>',
                type: 'POST',
                data: $('#quickForm').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    if (data.status) {
                        toastr.success('Login Berhasil!');
                        var url = '<?php echo base_url('dashboard') ?>';
                        window.location = url;
                    } else if (data.error) {
                        toastr.error(
                            data.pesan
                        );
                    } else {

                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                            $('[name="' + data.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
                            $('[name="' + data.inputerror[i] + '"]').next().next().text(data.error_string[i]).addClass('invalid-feedback');
                        }
                    }
                }
            });

        });
    </script>


</body>

</html>