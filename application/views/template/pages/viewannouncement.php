<script type="text/javascript">
    window.onload = function () {
        $("#announcement").attr("class", "site-menu-item active");
    }
</script>
<style type="text/css">
    .table > thead > tr > th {
        vertical-align: bottom;
        border: 1px solid #ddd;
        text-align: center;
        color:#666;
        background-color:#EBEBEB;
        font-size:14px
    }
    .table > tbody > tr > td {
        border: 1px solid #ddd;
    }
    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -1.0715rem;
        margin-left: -1.0715rem;
    }
</style>

<div class="page">
    <div class="page-content">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Announcement</li>
        </ol>
        <div class="panels"> 
            <div class="col-lg-6">
                <?php if ($this->session->flashdata('login')): ?>
                    <div class="note note-info note-bordered">
                        <p>
                        <div class="fa fa-check"></div>&nbsp;<?php echo $this->session->flashdata('login'); ?>
                        </p>
                    </div>

                <?php endif; ?>
                <!-- BEGIN PORTLET-->


                <form  role="form" action="<?php echo base_url(); ?>announcement/upload" method="post" style="margin-bottom: 15px;" enctype="multipart/form-data">
                    <!-- <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success">
                                    <button class="close" data-close="alert"></button>
                                    <span>
                        <?php echo $this->session->flashdata('success'); ?>
                                    </span>
                                </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('fail')): ?>
                                <div class="alert alert-warning">
                                    <button class="close" data-close="alert"></button>
                                    <span>
                        <?php echo $this->session->flashdata('fail'); ?>
                                    </span>
                                </div>
                    <?php endif; ?> -->
                    <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 1): ?>
                        <fieldset style="border: 1px solid #e5e5e5; border-radius: 3px; color: #666666;">
                            <legend style="font-size: 12px; border-radius: 3px; border: 1px solid #e5e5e5; padding: 3px 8px; margin: 10px 0 0 7px; width: auto; color: #666666;">File Announcement</legend>
                            <div class="col-sm-12" style="padding: 15px;">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <p>Unggah Pemberitahuan :</p>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <div class="fa fa-upload"></div>
                                            </div>

                                            <input type="file" name="announcement_file" id="announcement_file" class="form-control" required>
                                        </div><br>
                                        <!-- <button type="reset" class="btn btn-md btn-danger pull-right"> Cancel</button> -->
                                        <button type="submit" class="btn btn-md btn-warning pull-right" id="announcement_file_btn" style="margin-right: 5px; color: #fff !important;"> Unggah</button>
                                    </div><br>
                                </div>

                            </div>
                        </fieldset>
                    <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 2): ?>
                        <fieldset style="border: 1px solid #e5e5e5; border-radius: 3px; color: #666666;">
                            <legend style="font-size: 12px; border-radius: 3px; border: 1px solid #e5e5e5; padding: 3px 8px; margin: 10px 0 0 7px; width: auto; color: #666666;">File Announcement</legend>
                            <div class="col-sm-12" style="padding: 15px;">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <p>Unggah Pemberitahuan :</p>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <div class="fa fa-upload"></div>
                                            </div>

                                            <input type="file" name="announcement_file" id="announcement_file" class="form-control" required>
                                        </div><br>
                                        <button type="submit" class="btn btn-md btn-warning pull-right" id="announcement_file_btn"> Unggah</button>
                                    </div><br>
                                </div>

                            </div>
                        </fieldset>
                    <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 3): ?>
                        <fieldset style="border: 1px solid #e5e5e5; border-radius: 3px; color: #666666;">
                            <legend style="font-size: 12px; border-radius: 3px; border: 1px solid #e5e5e5; padding: 3px 8px; margin: 10px 0 0 7px; width: auto; color: #666666;">File Announcement</legend>
                            <div class="col-sm-12" style="padding: 15px;">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <p>Unggah Pemberitahuan :</p>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <div class="fa fa-upload"></div>
                                            </div>

                                            <input type="file" name="announcement_file" id="announcement_file" class="form-control" required>
                                        </div><br>
                                        <button type="submit" class="btn btn-md btn-warning pull-right" id="announcement_file_btn"> Unggah</button>
                                    </div><br>
                                </div>

                            </div>
                        </fieldset>
                    <?php else: ?>

                    <?php endif ?>                              
                </form>
            </div>

            <div>
                <table  class="table table-hover dataTable w-full" data-plugin="dataTable" style="font-size:13px" id="table">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Nama File</th>
                            <th>Waktu Upload</th>
                            <th>Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                    <div class="col-md-12">
                        <?php if (count($list) == 0): ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <div class="fa fa-info-circle"></div> Tidak Ada Data<br>
                            </div>
                        <?php else: ?>
                            <?php if ($this->session->flashdata('message')): ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="fa  fa-check"></div> <?php echo $this->session->flashdata('message'); ?><br>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('success')): ?>
                                <br><div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="fa  fa-check"></div> <?php echo $this->session->flashdata('success'); ?><br>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('fail')): ?>
                                <div class="alert alert-warning">
                                    <button class="close" data-close="alert"></button>
                                    <span>
                                        <?php echo $this->session->flashdata('fail'); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php $no = 0;
                        foreach ($list as $row): $no++;
                            ?>
                            <tr align="center">
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row->ANNOUNCEMENT_NAME; ?></td>
                                <td><?php echo $row->UPLOADED_AT; ?></td>

                                <td align="center">
        <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 1): ?>
                                        <a href="<?php echo base_url() ?>uploads/announcement/<?php echo $row->ANNOUNCEMENT_NAME; ?>" download data-toggle="tooltip" title="Download <?php echo $row->ANNOUNCEMENT_NAME ?>" class="btn btn-sm btn-primary" ><i class=" fa fa-download" ></i></a>
                                        <!-- <span title="Delete File" data-toggle="tooltip">
                                            <a href="<?php echo base_url() ?>announcement/delete_modal/<?php echo $row->ANNOUNCEMENT_ID; ?>" class="btn btn-sm btn-danger btn-aksion" data-toggle="modal" data-target="#hapus" ><i class="fa fa-trash-o" ></i></a>
                                        </span> -->
                                       <!--  <input type="text" name="id_user" id="id_user" value="<?php echo $row->ANNOUNCEMENT_ID ?>"> -->
                                        <span title="Hapus Berkas" data-toggle="tooltip">
                                            <a onclick="btn_delete_announ(<?php echo $row->ANNOUNCEMENT_ID ?>)" data-toggle="modal" style="color:#fff !important;" data-target="#hapus" class="btn btn-sm btn-danger btn-aksion"><i class="fa fa-trash-o" ></i></a>
                                        </span>
                                        <?php
                                        if ($row->NOTIF == "1") {
                                            echo "<a href='" . base_url('announcement/updatehorn/') . $row->ANNOUNCEMENT_ID . "/" . $row->NOTIF . "' style='color:#fff !important;' class='btn btn-sm btn-success btn-aksion'><i class='fa fa-bell' ></i></a>";
                                        } else {
                                            echo "<a href='" . base_url('announcement/updatehorn/') . $row->ANNOUNCEMENT_ID . "/" . $row->NOTIF . "' style='color:#fff !important;' class='btn btn-sm btn-warning btn-aksion'><i class='fa fa-bell-slash' ></i></a>";
                                        }
                                        ?>

        <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 2): ?>
                                        <a href="<?php echo base_url() ?>uploads/announcement/<?php echo $row->ANNOUNCEMENT_NAME; ?>" download data-toggle="tooltip" title="Download <?php echo $row->ANNOUNCEMENT_NAME ?>" class="btn btn-sm btn-primary" ><i class=" fa fa-download" ></i></a>
                                        <!-- <span title="Delete File" data-toggle="tooltip">
                                            <a href="<?php echo base_url() ?>announcement/delete_modal/<?php echo $row->ANNOUNCEMENT_ID; ?>" class="btn btn-sm btn-danger btn-aksion" data-toggle="modal" data-target="#hapus" ><i class="fa fa-trash-o" ></i></a>
                                        </span> -->
                                      <!--   <input type="text" name="id_user" id="id_user" value="<?php echo $row->ANNOUNCEMENT_ID ?>"> -->
                                        <span title="Hapus Berkas" data-toggle="tooltip">
                                            <a onclick="btn_delete_announ(<?php echo $row->ANNOUNCEMENT_ID ?>)"  data-toggle="modal" style="color:#fff !important;" data-target="#hapus" class="btn btn-sm btn-danger btn-aksion" ><i class="fa fa-trash-o" ></i></a>
                                        </span>

        <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 3): ?>
                                        <a href="<?php echo base_url() ?>uploads/announcement/<?php echo $row->ANNOUNCEMENT_NAME; ?>" download data-toggle="tooltip" title="Download <?php echo $row->ANNOUNCEMENT_NAME ?>" class="btn btn-sm btn-primary" ><i class=" fa fa-download" ></i></a>

                        <!--  <span title="Delete File" data-toggle="tooltip">
                            <a href="<?php echo base_url() ?>announcement/delete_modal/<?php echo $row->ANNOUNCEMENT_ID; ?>" class="btn btn-sm btn-danger btn-aksion" data-toggle="modal" data-target="#hapus" ><i class="fa fa-trash-o" ></i></a>
                        </span> -->
                        <!-- <input type="text" name="id_user" id="id_user" value="<?php echo $row->ANNOUNCEMENT_ID ?>"> -->
                                        <span title="Hapus Berkas" data-toggle="tooltip">
                                            <a onclick="btn_delete_announ(<?php echo $row->ANNOUNCEMENT_ID ?>)"  data-toggle="modal" style="color:#fff !important;" data-target="#hapus" class="btn btn-sm btn-danger btn-aksion" ><i class="fa fa-trash-o" ></i></a>
                                        </span>

        <?php else: ?>
                                        <a href="<?php echo base_url() ?>uploads/announcement/<?php echo $row->ANNOUNCEMENT_NAME; ?>" download data-toggle="tooltip" title="Download <?php echo $row->ANNOUNCEMENT_NAME ?>" class="btn btn-sm btn-primary" ><i class=" fa fa-download" ></i></a>

                                        <?php
                                        if ($row->BACA == "0" && $row->NOTIF == "1") {
                                            echo "<a href='" . base_url() . "/announcement/sudahbaca/$row->ANNOUNCEMENT_ID' class='btn btn-sm btn-success' ><i class=' fa fa-bullhorn' ></i></a>";
                                        }
                                    endif
                                    ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
<?php endif; ?>                                   
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- END CONTENT -->
<!-- <div class="modal animated fadeIn" id="hapus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-controls-modal="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div> -->

<!-- The Modal -->
<div class="modal fade modal-3d-slit modal-danger" id="hapus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="modaldeleteannoun" action="<?php echo base_url() ?>announcement/delete/<?php echo $list[0]->ANNOUNCEMENT_ID; ?>">
                <div class="modal-header">
                    <button class="close" area-hidden="true" data-dismiss="modal" type="button">x</button>
                    <h4 class="modal-title">Konfirmasi</h4>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus <?php echo $list[0]->ANNOUNCEMENT_NAME; ?> ?</p>        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-pure btn-default" id="hapus" data-dismiss="modal"><div class="fa fa-times"></div> Tidak</button>
                    <button type="submit" class="btn btn-md btn-danger"><div class="fa fa-check"> Ya</div></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var link_base = "<?php echo base_url(); ?>";
    function btn_delete_announ(id) {
        // alert(id);
        document.getElementById("modaldeleteannoun").action = link_base + '/announcement/delete/' + id;
        // $.ajax({
        //     type: 'GET',
        //    url: link_base+'/announcement/delete_modal/'+ id,
        //     // data: {id : id},
        //     success: function (data) {
        //         // console.log(data);
        //         var obj = JSON.parse(data);
        //         // $('#editstatus').modal();
        //          $("#id_user_modal").val(obj.ANNOUNCEMENT_ID);
        //         // alert(obj.USER_ID);
        //         // $('#editstatus').find('.modal-body').html(data);
        //     }
        // })
    }
</script>