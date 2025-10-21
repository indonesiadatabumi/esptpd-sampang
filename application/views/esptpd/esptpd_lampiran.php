<?php
if ($lampiran == '') {
    $lampiran = 'default.pdf';
} else {
    $lampiran = $lampiran;
} ?>

<embed src="<?= base_url('assets/foto/lampiran/' . $lampiran); ?>" type="application/pdf" width="900" height="800"></embed>