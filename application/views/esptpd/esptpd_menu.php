<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bars"></i>
                    Menu E-SPTPD
                </h3>
            </div>
            <div class="card-body">
                <!--menu LIst -->
                <table class="table table-striped  table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>NPWPD</th>
                            <th>NAMA</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        foreach ($esptpd as $row) {
                            echo "<tr><td>" . $no++ . "</td>
                                        <td>" . $row->npwprd . "</td>
                                        <td>" . $row->nama . "</td>";
                            // if ($row->pajak_id == 7) {
                            //     echo
                            //     "<td align='center'>
                            //             <button   onclick=\"window.location='" . base_url('esptpd/add/') . $row->wp_wr_detil_id . "'\"  class='btn btn-sm btn-outline-info _lapor'><i class='fa fa-edit'></i> Input SPTPD</button>
                            //             </td>
                            //         </tr>";
                            // } else {
                            //     echo "<td align='center'>
                            //             <a href=" . base_url('esptpd/billing/') . $row->wp_wr_detil_id . " class='btn btn-sm btn-outline-success _lapor'><i class='fa fa-info'></i> Detil </a>&nbsp;
                            //             <button   onclick=\"window.location='" . base_url('esptpd/add/') . $row->wp_wr_detil_id . "'\"  class='btn btn-sm btn-outline-info _lapor'><i class='fa fa-edit'></i> Input SPTPD</button>
                            //             </td>
                            //         </tr>";
                            // }
                            if ($row->wp_wr_detil_id == '1614') {
                                echo "<td align='center'>
                                        <a href=" . base_url('esptpd/billing/') . $row->wp_wr_detil_id . " class='btn btn-sm btn-outline-success _lapor'><i class='fa fa-info'></i> Detil </a>&nbsp;
                                        </td>
                                    </tr>";
                            } else {
                                echo "<td align='center'>
                                        <a href=" . base_url('esptpd/billing/') . $row->wp_wr_detil_id . " class='btn btn-sm btn-outline-success _lapor'><i class='fa fa-info'></i> Detil </a>&nbsp;
                                        <button   onclick=\"window.location='" . base_url('esptpd/create_billing/') . $row->wp_wr_detil_id . "'\"  class='btn btn-sm btn-outline-info _lapor'><i class='fa fa-edit'></i> Generate Billing</button>
                                        </td>
                                    </tr>";
                            }
                        }
                        ?>

                    </tbody>
                </table>

            </div>
            <!-- /.card -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.container-fluid -->
</section>

<script>
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = $(this).data('href');

        Swal.fire({
            title: 'Apakah anda Yakin?',
            text: "akan menghapus Grup ID: " + data,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            $.ajax({
                type: "post",
                url: "<?= site_url('esptpd/delete_menu') ?>",
                data: {
                    noid: data
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {

                        Swal.fire(
                            'Deleted!',
                            'Menu Grup berhasil di hapus.',
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr, thrownError) {
                    Swal(
                        'Billing Gagal dihapus!.',
                        'error'
                    )
                }
            });

        })

    });
</script>