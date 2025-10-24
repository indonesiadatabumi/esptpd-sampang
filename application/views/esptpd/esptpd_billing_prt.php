<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title><?= $pajak ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link rel="shortcut icon" type="images/x-icon" href="images/fav.ico" />
</head>

<body>

    <table border=0 style="width: 400px">
        <tr>
            <td align="right" width="75"><img src="<?= FCPATH . 'assets/images/logo.png' ?>" width=" 55" height="60"></td>
            <td valign="top" style="font-weight:bold; text-align:center;">
                <span style="font-size:12px; ">PEMERINTAH KABUPATEN SAMPANG</span> <br />
                <span style="font-size:10px; ">BADAN PENDAPATAN DAERAH</span> <br />
                <div style="font-size:8px; ">Jl. Rajawali No.4, Bledanah, Karang Dalem, Kec. Sampang, Kabupaten Sampang, <br />
                    Jawa Timur 69216</div>
            </td>
            <!-- <td width="100" valign="top"><img src="images/logo-bank.jpg" width="90" height="50"></td> -->
        </tr>
    </table>
    <div style="width:400px; border-bottom:1px solid; "></div>
    <table border=0 style="width: 400px; font-size:10px;">
        <tr>
            <td style="width:100px; ">No. Transaksi</td>
            <td colspan="2" width="300">: <?= $spt_nomor ?></td>
        </tr>
        <tr>
            <td>WAJIB PAJAK</td>
            <td colspan="2">: <?= strtoupper($spt_nama) ?></td>
        </tr>
        <tr>
            <td>NPWPD</td>
            <td>: P.2.<?= $npwprd ?></td>
            <td rowspan="4" valign="top" style="width:150px; ">
                <table border=1 align="right" cellpadding="2" cellspacing="0">
                    <tr>
                        <td align="center">KODE BILLING</td>
                    </tr>
                    <tr>
                        <td style="width:120px; text-align:center; font-size:14px; font-weight:bold; "><?= $billing_id ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>JENIS PAJAK</td>
            <td>: <?php echo $pajak; ?></td>
        </tr>
        <tr>
            <td>Masa Pajak</td>
            <td>: <?= $bln_masapajak ?> <?= $spt_tahun_pajak ?></td>
        </tr>
        <tr>
            <td>Pokok Pajak</td>
            <td>: Rp. <?= number_format($spt_pajak, 2, ",", ".") ?></td>
            <?php if ($status_bayar == '1') :  ?>
                <td rowspan="4" align="center"><img src="<?= FCPATH . 'assets/images/stempel_lunas.jpg' ?>" width=" 100" height="100"></td>
            <?php endif ?>
        </tr>
        <tr>
            <td>Denda</td>
            <td>: Rp. <?= number_format($denda, 2, ",", ".") ?></td>
        </tr>
        <tr>
            <td>JUMLAH</td>
            <td>: Rp. <?= number_format($total_bayar, 2, ",", ".") . "&nbsp;"; ?> </td>

        </tr>
    </table>
    <table>
        <tr>
            <td style="font-size:8px; ">Tanggal Cetak : <?= date("d-m-Y h:i:s") ?> </td>
        </tr>
    </table>
    <div style="font-size:8px; width:400px; font-weight:bold; ">** Keterlambatan Pembayaran melewati tanggal jatuh tempo akan dikenakan sanksi administrasi berupa bunga
        sebesar 2% (dua persen) setiap bulannya </div>
    <div>&nbsp;</div>
    <div style="font-weight:bold; text-align:center; width:400px; font-size:10px; ">"PAJAK ANDA MEMBANGUN KAB. SAMPANG" <br />-- TERIMA KASIH --</div>
    </div>
</body>

</html>