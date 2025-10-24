<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bars"></i>
                    Menu Lapor SPTPD
                </h3>
            </div>
            <div class="card-body">
                <!--menu LIst -->
                <table class="table table-striped  table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>NOPD</th>
                            <th>NAMA</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        foreach ($esptpd as $row) {
                            echo "<tr><td>" . $no++ . "</td>
                                        <td>" . $row->nopd . "</td>
                                        <td>" . $row->nama . "</td>";
                            echo "<td align='center'>
                                        <a href=" . base_url('lapor_pajak/daftar_lapor/') . $row->wp_wr_detil_id . " class='btn btn-sm btn-outline-success _lapor'><i class='fa fa-info'></i> Detil </a>&nbsp;
                                        <button   onclick=\"window.location='" . base_url('lapor_pajak/create_lapor/') . $row->wp_wr_detil_id . "'\"  class='btn btn-sm btn-outline-info _lapor'><i class='fa fa-edit'></i> Lapor Pajak</button>
                                        </td>
                                    </tr>";
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