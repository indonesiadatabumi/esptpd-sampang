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
                                    PEMERINTAH KOTA BEKASI <br />
                                    BADAN PENDAPATAN DAERAH <br />
                                    <div style="font-size:10px; ">Jl. Jendral Ahmad Yani No. 100 <br />
                                        Telp. (021)88397963/64 <br />
                                        Fax. (021)88397965</div>
                                    BEKASI
                                </td>
                            </tr>
                        </table>
                    </div>

                    <hr />
                    <br />
                    <table border="1" cellpadding="3" cellspacing="0">
                        <tr>
                            <th>NPWPD</th>
                            <th>Masa Pajak</th>
                            <th>Nilai Pajak</th>
                            <th>Kode Billing</th>
                        </tr>
                        <?php
                        foreach ($billing_induk as $induk) {
                        ?>
                            <tr>
                                <td style="text-align:center; width:200px; "><?= $induk->npwpd ?></td>
                                <td style="width:200px; text-align:center; "><?= $induk->spt_periode_jual1 ?> s/d <?= $induk->spt_periode_jual2 ?></td>
                                <td style="width:100px; text-align:right; "><?= number_format($induk->spt_pajak, 0, ",", "."); ?></td>
                                <td style="width:150px; text-align:center; "><?= $induk->spt_kode_billing ?></td>
                            </tr>

                        <?php } ?>

                        <?php
                        foreach ($billing_anak as $anak) {
                        ?>
                            <tr>
                                <td style="text-align:center; width:200px; "><?= $anak->npwpd ?></td>
                                <td style="width:200px; text-align:center; "><?= $anak->spt_periode_jual1 ?> s/d <?= $anak->spt_periode_jual2 ?></td>
                                <td style="width:100px; text-align:right; "><?= number_format($anak->spt_pajak, 0, ",", "."); ?></td>
                                <td style="width:150px; text-align:center; "><?= $anak->spt_kode_billing ?></td>
                            </tr>

                        <?php } ?>

                    </table>
                    <hr />
                    <div>&nbsp;</div>
                    <div align="left">
                        <table>
                            <tr>
                                <td style="font-size:12px;">Bekasi, <?= date("d-m-Y") ?> </td>
                            </tr>
                            <tr>
                                <td align="center" style="font-size:12px; ">Dicetak Oleh,</td>
                            </tr>
                            <tr>
                                <td height="50" align="center" valign="bottom" style="font-size:12px; ">(<?= $_SESSION['pj_wp'] ?>)</td>
                            </tr>
                        </table>
                    </div>
                    <div>&nbsp;</div>
                </div>
            </div><!-- /.row -->

        </div><!-- /.container-fluid -->
    </section>

</div>


<script type="text/javascript">
    window.addEventListener("load", window.print());
</script>
</body>

</html>