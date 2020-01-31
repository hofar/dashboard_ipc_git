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
                <h1>Data Siswa</h1>
                <hr/>
                <a href="<?= site_url("usermanagement/form_exc"); ?>">Import Data</a>
                <br/>
                <br/>

                <div class="table-responsive">
                    <table class="table table-hover dataTable w-full" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($siswa)) { // Jika data pada database tidak sama dengan empty (alias ada datanya)
                                foreach ($siswa as $data) { // Lakukan looping pada variabel siswa dari controller
                                    ?>
                                    <tr>
                                        <td><?= $data->NIS ?></td>
                                        <td><?= $data->NAMA ?></td>
                                        <td><?= $data->JENIS_KELAMIN ?></td>
                                        <td><?= $data->ALAMAT ?></td>
                                    </tr>
                                    <?php
                                }
                            } else { // Jika data tidak ada
                                ?>
                                <tr>
                                    <td colspan="">Data tidak ada</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
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