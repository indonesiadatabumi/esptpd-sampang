<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>SKPD </title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link rel="shortcut icon" type="images/x-icon" href="images/fav.ico" />
</head>

<body>
    <div style="border:1px solid #000000; padding:10px; width:100%; ">
        <table width="100%">
            <tr>
                <td width="45%" style="border-right:1px solid; ">
                    <table>
                        <tr>
                            <td><img src="<?= base_url('assets/images/') ?>logo.png" width="80"></td>
                            <td valign="top" style="font-size:12px; font-weight:bold; ">
                                PEMERINTAH KOTA BEKASI <br />
                                DINAS PENDAPATAN DAERAH <br />
                                <div style="font-size:12px; ">Jl. Jendral Ahmad Yani No. 1 <br />
                                    Telp. (021)8858270 <br />
                                    Fax. (021)8859281</div>
                                BEKASI
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="40%" valign="top" style="text-align:center; border-right:1px solid; ">
                    <table>
                        <tr>
                            <td colspan="2" align="center" style="font-size:12px; "><b>SKPD</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" style="font-size:12px; "><b>(SURAT KETETAPAN PAJAK DAERAH)</b></td>
                        </tr>
                        <tr>
                            <td style="padding-left:50px; font-size:11px; text-align:left; " width="120">Masa Pajak </td>
                            <td style="font-size:11px; text-align:left; ">: <?= $bln_masapajak; ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:11px; padding-left:50px; text-align:left;">Tahun </td>
                            <td style="font-size:11px; text-align:left; ">: <?= $spt_periode ?></td>
                        </tr>
                    </table>
                </td>
                <td width="15%" valign="top" style="padding-top:2px; text-align:center; ">
                    <div style="font-size:12px; ">No. Urut</div>
                    <div><?= $spt_no_register ?></div>
                </td>
            </tr>
        </table>
        <hr>
        <table style="margin-top:20px; margin-left:50px; font-size:12px; ">
            <tr>
                <td width="200">No. Kohir</td>
                <td>:</td>
                <td><?= $spt_nomor ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?= $wp_rek_nama ?></td>
            </tr>
            <tr>
                <td valign="top">Alamat</td>
                <td valign="top">:</td>
                <td><?= $wp_rek_alamat ?></td>
            </tr>
            <tr>
                <td>NPWPD</td>
                <td>:</td>
                <td><?= $npwprd ?></td>
            </tr>
            <tr>
                <td>Tgl. Jatuh Tempo</td>
                <td>:</td>
                <td><?= date("d-m-Y", strtotime($netapajrek_tgl_jatuh_tempo)); ?></td>
            </tr>
            <tr>
                <td>Kode Billing</td>
                <td>:</td>
                <td><?= $spt_kode_billing ?></td>
            </tr>

        </table>
        <hr />
        <table border="1" cellpadding="5" cellspacing="0">
            <tr style="font-size:12px; ">
                <th width="50">N0</th>
                <th width="200">KODE REKENING</th>
                <th width="400">JENIS PAJAK DAERAH</th>
                <th width="150">JUMLAH</th>
            </tr>
            <tr>
                <td align="center">1</td>
                <td><?= $koderek_titik ?></td>
                <td><?= $korek_nama ?></td>
                <td align="right"><?= number_format($spt_pajak, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td colspan="4" height="10"></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td>Jumlah Ketetapan Pokok Pajak</td>
                <td align="right"><?= number_format($spt_pajak, 2, ',', '.'); ?></td>
            </tr>
        </table>
        <hr />
        <table>
            <tr>
                <td>
                    <div>&nbsp;</div>
                    <div>Bekasi, <?= date("d-m-Y", strtotime($spt_tgl_proses)); ?></div>
                    <div>a.n. Kepala Badan Pendapatan Daerah</div>
                    <div>Kepala Bidang PAD dan Dana Perimbangan</div>
                    <div style="height:50px ">&nbsp;</div>
                    <div style="height:50px ">&nbsp;</div>
                    <div style="height:50px ">&nbsp;</div>
                    <div style="height:50px ">&nbsp;</div>
                    <div style="height:50px ">&nbsp;</div>

                    <div>---------------------------------------------</div>
                </td>
            </tr>
        </table>
    </div>
    <div>&nbsp;</div>
    </div>
</body>

</html>