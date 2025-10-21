<?php
error_reporting(~E_NOTICE);


header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=Rekap_User_Aktif.xls");
header("Expires:0");
header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
header("Pragma: public");
?>
<div class="panel-body">
    <div class="table-responsive">
        <form method="post" id="formulirku" name="formulirku">
            <table class="table table-striped table-bordered table-hover" border="1" id="dataTables-example">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>NPWPD</th>
                        <th>Nama Wajib Pajak</th>
                        <th width="300">Email</th>
                        <th width="300">Kecamatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($data_user as $row) {
                        $i++;
                    ?>
                        <tr class="gradeA">
                            <td align="center"><?= $i ?></td>
                            <td><?= $row->npwpd ?></td>
                            <td><?= $row->nama ?></td>
                            <td><?= $row->email ?></td>
                            <td><?= $row->camat_nama ?></td>
                            <td align="center">Aktif</td>

                        </tr>
                    <?php
                        $no++;
                    }

                    ?>
                </tbody>
            </table>
        </form>
    </div>

</div>
</div>