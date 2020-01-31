<div class="page">
    <div class="page-content">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">User Management Desain</li>
        </ol>
        <div class="headTab">
            <i class="icon md-face"></i> User Management Desain
        </div>
        <div class="panels">       
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="col-md-12 col-sm-12">
                <h3>Form Import</h3>
                <hr/>

                <a href="javascript:void(0);" onclick="window.location.href = '<?= site_url("excel/format.xlsx"); ?>'" class="btn btn-default">Download Format / Template</a>
                <br/>
                <br/>

                <!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
                <!--Form untuk preview excel-->
                <form method="post" action="<?= site_url("usermanagement/form_exc"); ?>" enctype="multipart/form-data">
                    <input type="file" name="file" />
                    <button type="submit" name="preview" value="preview" class="btn btn-warning">Preview</button>
                </form>

                <?php
                $post_preview = filter_input(INPUT_POST, 'preview');
                if (isset($post_preview)) { // Jika user menekan tombol Preview pada form
                    if (isset($upload_error)) { // Jika proses upload gagal
                        ?>
                        <!--Muncul pesan error upload-->
                        <div style="color: red;">
                            <?= $upload_error ?>
                        </div>
                        <?php
                    } else {
                        ?>
                        <!--Buat sebuah tag form untuk proses import data ke database-->
                        <!--Buat sebuah div untuk alert validasi kosong-->            

                        <div class="table-responsive">
                            <table class="table table-hover dataTable w-full" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="5">Preview Data</th>
                                    </tr>
                                    <tr>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $numrow = 1;
                                    $kosong = 0;

                                    // Lakukan perulangan dari data yang ada di excel
                                    // $sheet adalah variabel yang dikirim dari controller
                                    foreach ($sheet as $row) {
                                        // Ambil data pada excel sesuai Kolom
                                        $nis = $row['A']; // Ambil data NIS
                                        $nama = $row['B']; // Ambil data nama
                                        $jenis_kelamin = $row['C']; // Ambil data jenis kelamin
                                        $alamat = $row['D']; // Ambil data alamat
                                        // Cek jika semua data tidak diisi
                                        if ($nis == "" && $nama == "" && $jenis_kelamin == "" && $alamat == "") {
                                            continue;
                                        }
                                        // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
                                        // Cek $numrow apakah lebih dari 1
                                        // Artinya karena baris pertama adalah nama-nama kolom
                                        // Jadi dilewat saja, tidak usah diimport
                                        if ($numrow > 1) {
                                            // Validasi apakah semua data telah diisi
                                            $nis_td = (!empty($nis)) ? "" : " background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                            $nama_td = (!empty($nama)) ? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                                            $jk_td = (!empty($jenis_kelamin)) ? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                                            $alamat_td = (!empty($alamat)) ? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                                            // Jika salah satu data ada yang kosong
                                            if ($nis == "" or $nama == "" or $jenis_kelamin == "" or $alamat == "") {
                                                $kosong++; // Tambah 1 variabel $kosong
                                            }
                                            ?>
                                            <tr>
                                                <td <?= $nis_td ?>><?= $nis ?></td>
                                                <td <?= $nama_td ?>><?= $nama ?></td>
                                                <td <?= $jk_td ?>><?= $jenis_kelamin ?></td>
                                                <td <?= $alamat_td ?>><?= $alamat ?></td>
                                            </tr>
                                            <?php
                                        }
                                        $numrow++; // Tambah 1 setiap kali looping
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!--Form untuk import-->
                        <form method="post" action="<?= site_url('usermanagement/import_file_exc') ?>">                

                            <?php
                            // Cek apakah variabel kosong lebih dari 0
                            // Jika lebih dari 0, berarti ada data yang masih kosong
                            if ($kosong > 0) {
                                ?>
                                <div style="color: red;">
                                    Semua data belum diisi, Ada <span id="jumlah_kosong"></span> data yang belum diisi.
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                                        $("#jumlah_kosong").html('<?= $kosong; ?>');
                                    });
                                </script>
                                <?php
                            } else { // Jika semua data sudah diisi
                                ?>
                                <hr/>

                                <!--Buat sebuah tombol untuk mengimport data ke database-->
                                <button type="submit" name="import" class="btn btn-primary">Import</button>
                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '<?= site_url('Siswa') ?>'">Cancel</button>
                                <?php
                            }
                            ?>
                        </form>
                        <?php
                    }
                }
                ?>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
    </div>
    <!-- END CONTENT -->
</div>

<script>
    $(document).ready(function () {
        $('.dataTable').dataTable({
            paging: true,
            searching: true,
            "columnDefs": [
                {"orderable": false}
            ]
        });
    });
</script>