<div class="wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                        <table>
                            <tr>
                                <td>
                                    <img src="<?= base_url('assets/images/logo.png') ?>" width=100px>
                                </td>
                                <td>
                                    <h3><b> PEMERINTAH KOTA BEKASI <br> BADAN PENDAPATAN DAERAH</b><br>JL. IR. JUANDA KOTA BEKASI</h3>
                                </td>
                            </tr>
                        </table>
                    </div>


                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <!-- <i class="fas fa-globe"></i>  -->SURAT PEMBERITAHUAN PAJAK DAERAH ELEKTRONIK (E-SPTPD)
                                    <!-- <small class="float-right">Date: 2/10/2014</small> -->
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <h4><b><?= $npwprd ?></b></h4>
                                <address>
                                    <strong><?= $wp_wr_nama ?></strong><br>
                                    <!-- <?php echo $rows['JENIS_PAJAK'] ?> <br> -->
                                    <?= $wp_wr_almt ?><br>
                                    Phone: <? $ ?><br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <h4><b>ID BILLING :<?= $billing_id ?></b></h4><br>
                                <br>
                                <b>No. SSPD:</b><?= $spt_idwpwr ?><br>
                                <b>Tanggal lapor:</b> <?= $spt_tgl_entry ?><br>
                                <!-- <b>SPTPD : </b> <? echo $no_sptpd ?> -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Berkas</th>
                                            <th>Periode</th>
                                            <th>Dasar Pengenaan</th>
                                            <!-- <th>Description</th> -->
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><? ?></td>
                                            <td><?= $spt_periode ?></td>
                                            <td>Rp.<?= number_format($spt_pajak) ?></td>
                                            <!-- <td><? echo $rows['URAIAN_PAJAK'] . "<br> dari : " . $rows['NO_BILL_KET_LAIN'] ?></td> -->
                                            <td>Rp.<?= number_format($spt_pajak) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                <p class="lead">Deskripsi:</p>

                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    <!-- <? echo $rows['URAIAN_PAJAK'] . "" . $rows['NO_BILL_KET_LAIN'] ?> -->

                                <p class="lead">Metode Pembayaran:</p>
                                Pembayaran melalui Channel Bank BJB dengan menyertakan Kode Billing / NIOP
                            </div>
                            <!-- /.col -->
                            <div class="col-6">

                                <div class="table-responsive">
                                    <table class="table">
                                        <!-- <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>Rp.<?= number_format($spt_pajak) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tarif Pajak:</th>
                                            <td><?= 0; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Denda:</th>
                                            <td><?php echo "Rp. " . number_format($denda) ?></td>
                                        </tr> -->
                                        <tr>
                                            <th>Total Pajak Terutang:</th>
                                            <td>Rp.<?= number_format($spt_pajak) ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->


                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
    </section>

</div>


<script type="text/javascript">
    window.addEventListener("load", window.print());
</script>
</body>

</html>