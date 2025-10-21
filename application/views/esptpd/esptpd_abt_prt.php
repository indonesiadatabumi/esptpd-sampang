<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>air tanah</title>
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
                    <table style="font-size: 12px;">
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
        <div style="text-align:center; font-weight:bold; "><span style="font-size:14px; ">SPTPD <br />
                (SURAT PEMBERITAHUAN PAJAK DAERAH) <br />
                PAJAK AIR TANAH</span>
        </div>
        <div style="margin-top:20px; ">&nbsp;</div>
        <table border="0" width="100%" align="center" style="font-size: 12px;">
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
        <table width="100%" style="font-size: 12px;">
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
            <!-- <tr>
                <td>KODE BILLING </td>
                <td>: 3505<?= $kode_pajak->rek_bank ?><?= $billing_id ?></td>
            </tr> -->
        </table>
        <hr />
        <table border="1" cellspacing="0" style="font-size: 12px;" width="100%">
            <tr>
                <td style='text-align:center; vertical-align:middle'>Petunjuk Meter Air</td>
                <td style='text-align:center; vertical-align:middle'>Bukan Meter Air</td>
            </tr>
            <tr>
                <td>Hari ini : <?= $row->ptnjk_meter_hari_ini ?> m<sup>3</sup></td>
                <td>Penggunaan 1 hari : <?= $row->bkn_meter_hari ?> m<sup>3</sup></td>
            </tr>
            <tr>
                <td>Bulan lalu : <?= $row->ptnjk_meter_bulan_lalu ?> m<sup>3</sup></td>
                <td>Penggunaan 1 bulan : <?= $row->bkn_meter_bulan ?> hari</td>
            </tr>
            <tr>
                <td>Volume air (1 bulan) : <?= $row->ptnjk_meter_volume ?> m<sup>3</sup></td>
                <td>Volume air (1 bulan) : <?= $row->bkn_meter_volume ?> m<sup>3</sup></td>
            </tr>
        </table>
        <hr />
        <div style="font-size: 12px;">
            Dengan menyadari sepenuhnya akan segala akibat termasuk sanksi-sanksi sesuai dengan ketentuan perundang-undangan yang berlaku, saya atau yang saya beri kuasa
            menyatakan apa yang telah kami beritahukan tersebut diatas beserta lampiran lampirannya adalah benar, lengkap dan jelas.
        </div>
        <br />
        <div style="align-content: right;">
            <table style="font-size: 12px;">
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
        <div style="font-size: 12px;">* LEMBAR INI ADALAH BUKTI PELAPORAN PAJAK YANG SAH</div>
    </div>
</body>

</html>