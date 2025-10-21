<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>restoran </title>
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
            PAJAK RESTORAN
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
        <table border="0">
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
                <td width="300">1. Jenis Restoran </td>
                <td>: <?= $golongan ?></td>
            </tr>
            <tr>
                <td>2. Menggunakan kas register </td>
                <td><input type="checkbox" name="kas_r" value="Y"> Ya <input type="checkbox" name="kas_r" value="T"> Tidak</td>
            </tr>
            <?php if ($pengguna_catering != null) : ?>
                <tr>
                    <td width="300">3. Pengguna Catering </td>
                    <td>: <?= $pengguna_catering ?></td>
                </tr>
            <?php endif ?>
        </table>
        <hr />
        <table border="1" cellpadding="2" cellspacing="0" style="width:700px; ">
            <tr align="center">
                <td width="300">&nbsp;</td>
                <td width="200">Jumlah Pembayaran dan Pajak Terhutang</td>
                <?php if ($keterangan != null) : ?>
                    <td align="center">Keterangan</td>
                <?php endif ?>
            </tr>
            <tr>
                <td>
                    a. Masa Pajak <br />
                    b. Dasar Pengenaan Pajak (DPP) <br />
                    c. Tarif Pajak (Sesuai Perda) <br />
                    <!-- d. Denda <br /> -->
                    d. Pajak Terhutang (bxc)+d
                </td>
                <td style="padding-left:5px; ">
                    <?= $bln_masapajak ?> <br />
                    Rp. <?= number_format($spt_dt_jumlah, 2, ",", ".") ?> <br />
                    <?= $spt_korek_persen_tarif ?> % <br />
                    <!-- Rp. <?php echo number_format($jml_denda, 2, ",", "."); ?> <br /> -->
                    Rp. <?= number_format($spt_pajak, 2, ",", ".")  ?>
                </td>
                <?php if ($keterangan != null) : ?>
                    <td><?= $keterangan ?></td>
                <?php endif ?>
            </tr>
        </table>
        <hr />
        <div>
            Dengan menyadari sepenuhnya akan segala akibat termasuk sanksi-sanksi sesuai dengan ketentuan perundang-undangan yang berlaku, saya atau yang saya beri kuasa
            menyatakan apa yang telah kami beritahukan tersebut diatas beserta lampiran lampirannya adalah benar, lengkap dan jelas.
        </div>
        <br />
        <table border="0" width="100%">
            <tr>
                <td>Sampang, <?= $spt_tgl_entry ?> </td>
                <td rowspan="2" style="text-align:right; padding-right:10px; ">
                    <!-- <barcode code="<?= '[' . $spt_nama . ']-[' . $bln_masapajak . '_' . $spt_tahun_pajak . ']'; ?>" type="QR" class="barcode" size="0.8" error="M" /> -->
                </td>
            </tr>
            <tr>
                <td width="60%">Wajib Pajak</td>
            </tr>
            <tr>
                <td height="50" valign="bottom" colspan="2">(<?= $spt_nama  ?>)</td>
            </tr>
        </table>
        <div>&nbsp;</div>
        <div style="font-size:12px; ">* LEMBAR INI ADALAH BUKTI PELAPORAN PAJAK YANG SAH</div>
    </div>
</body>

</html>