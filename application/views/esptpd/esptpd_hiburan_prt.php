    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>

    <head>
        <title>hiburan</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link rel="shortcut icon" type="images/x-icon" href="images/fav.ico" />
    </head>

    <body>
        <div style="border:1px solid #000000; padding:10px; width:100%; ">
            <table width="100%">
                <tr>
                    <td width="50%">
                        <table>
                            <tr>
                                <td><img src="<?= FCPATH . 'assets/images/logo.png' ?>" width="40"></td>
                                <td valign="top" style="font-size:12px; font-weight:bold; ">PEMERINTAH KABUPATEN SAMPANG <br>
                                    BADAN PENDAPATAN DAERAH</td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" valign="top" style="border-left:1px solid #000; ">
                        <table>
                            <tr>
                                <td width="100">No. SPTPD</td>
                                <td>: <?= $spt_nomor ?></td>
                            </tr>
                            <tr>
                                <td>Masa Pajak</td>
                                <td>: <?= $bln_masapajak ?> <?= $spt_tahun_pajak ?></td>
                            </tr>
                            <tr>
                                <td>Tahun Pajak</td>
                                <td>: <?= $spt_periode ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <hr />
            <div style="text-align:center; font-weight:bold; "><span style="font-size:20px; ">SPTPD</span> <br />
                (SURAT PEMBERITAHUAN PAJAK DAERAH) <br />
                PAJAK HIBURAN
            </div>
            <div style="margin-top:20px; ">&nbsp;</div>
            <table border="0" width="100%" align="center">
                <tr>
                    <td valign="top">
                        Kepada Yth. <br />
                        Badan Pendapatan Daerah <br />
                        Pemerintahan Kabupaten Sampang <br />
                        Jl. Rajawali No.4, Bledanah, Karang Dalem, Kec. Sampang, Kabupaten Sampang, Jawa Timur 69216
                    </td>
                </tr>
            </table>
            <hr />
            <table width="100%">
                <tr>
                    <td>NAMA WAJIB PAJAK</td>
                    <td>: <?= $spt_nama ?></td>
                </tr>
                <tr>
                    <td width="40%">N. P. W. P. D</td>
                    <td>:
                        <input type="text" size="50" maxlength="50" value="P.2.<?= $npwprd ?>">
                    </td>
                </tr>
                <tr>
                    <td>KODE BILLING </td>
                    <td>: 3505<?= $kode_pajak->rek_bank ?><?= $billing_id ?></td>
                </tr>
                <tr>
                    <td colspan="2" height="10" style="border-bottom:1px solid #000; "></td>
                </tr>

                <tr>
                    <td valign="top">1. Pertunjukan yang diselenggarakan </td>
                    <td>: <?= $spt_korek_nama ?></td>
                </tr>
            </table>
            <hr />
            <table border="1" border="1" cellpadding="2" cellspacing="0" style="width:700px; ">
                <tr align="center">
                    <td width="400">&nbsp;</td>
                    <td>Jumlah Pembayaran dan Pajak Terhutang</td>
                </tr>
                <tr>
                    <td>
                        a. Masa Pajak <br />
                        b. Dasar Pengenaan <br />
                        c. Tarif Pajak (Sesuai Perda) <br />
                        d. Pajak Terhutang (bxc)
                    </td>
                    <td style="padding-left:8px; ">
                        <?= $bln_masapajak ?> <br />
                        Rp. <?= number_format($spt_dt_jumlah, 2, ",", ".") ?> <br />
                        <?= $spt_korek_persen_tarif ?> % <br />
                        <!-- Rp. <?php echo number_format($jml_denda, 2, ",", "."); ?> <br /> -->
                        Rp. <?= number_format($spt_pajak, 2, ",", ".") ?>
                    </td>
                </tr>
            </table>
            <hr />
            <div>
                Dengan menyadari sepenuhnya akan segala akibat termasuk sanksi-sanksi sesuia dengan ketentuan perundanga-undangan yang berlaku, saya atau yang saya beri kuasa
                menyatakan apa yang telah kami beritahukan tersebut diatas beserta lampiran lampirannya adalah benar, lengkap dan jelas.
            </div>
            <br />
            <div align="right">
                <table>
                    <tr>
                        <td>Sampang, <?= $spt_tgl_entry ?> </td>
                    </tr>
                    <tr>
                        <td align="center">Wajib Pajak</td>
                    </tr>
                    <tr>
                        <td height="50" valign="bottom" colspan="2">(<?= $spt_nama  ?>)</td>
                    </tr>
                </table>
            </div>
            <div>&nbsp;</div>
            <div>* LEMBAR INI ADALAH BUKTI PELAPORAN PAJAK YANG SAH</div>
        </div>
        <div style="height:100%; ">&nbsp;</div>

    </body>

    </html>