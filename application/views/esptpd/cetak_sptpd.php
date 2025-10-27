<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>hotel</title>
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
                            <td>Masa Pajak</td>
                            <td>: <?= $bulan_pajak ?> <?= $spt_tahun_pajak ?></td>
                        </tr>
                        <tr>
                            <td>Tahun Pajak</td>
                            <td>: <?= $tahun_pajak ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr />
        <div style="text-align:center; font-weight:bold; "><span style="font-size:14px; ">SPTPD <br />
                (SURAT PEMBERITAHUAN PAJAK DAERAH) <br />
                <?= strtoupper($data_wp->nama_paret) ?></span>
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
                <td>NAMA OBJEK PAJAK</td>
                <td>: <?= $data_wp->nama ?></td>
            </tr>
            <tr>
                <td width="40%">N. O. P. D</td>
                <td>:
                    <input type="text" size="50" maxlength="50" value="<?= $data_wp->nopd ?>">
                </td>
            </tr>
        </table>
        <hr />
        <table border="0" style="font-size: 12px;">
            <tr>
                <td colspan="2">Daftar Pembayaran :<br />
                    <table border="1" cellpadding="2" cellspacing="0" style="font-size: 12px;">
                        <tr>
                            <th width="30">No</th>
                            <th>Masa Pajak</th>
                            <th>Kode Billing</th>
                            <th>Dasar Pengenaan</th>
                            <th>Nilai Pajak</th>
                        </tr>
                        <?php
                        $no = 1;
                        foreach ($data_lapor as $row) : ?>
                            <tr>
                                <td align="center"><?= $no++ ?></td>
                                <td align="center"><?= date('d-m-Y', strtotime($row->masa_pajak1)) ?> s/d <?= date('d-m-Y', strtotime($row->masa_pajak2)) ?></td>
                                <td align="center"><?= $row->kode_billing ?></td>
                                <td align="right">Rp. <?= number_format($row->nilai_terkena_pajak, 2, ",", ".") ?></td>
                                <td align="right">Rp. <?= number_format($row->pajak, 2, ",", ".") ?></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </td>
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
                    <td>Sampang, <?= date('d-m-Y') ?> </td>
                </tr>
                <tr>
                    <td align="center">Wajib Pajak</td>
                </tr>
                <tr>
                    <td height="50" valign="bottom" colspan="2">(<?= $data_wp->nama  ?>)</td>
                </tr>
            </table>
        </div>
        <div>&nbsp;</div>
        <div style="font-size: 12px;">* LEMBAR INI ADALAH BUKTI PELAPORAN PAJAK YANG SAH</div>
    </div>
</body>

</html>