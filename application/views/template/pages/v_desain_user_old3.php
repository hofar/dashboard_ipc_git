<script type="text/javascript">
    window.onload = function () {
        $("#user_management").attr("class", "site-menu-item active");
    }
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
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

    td {
        cursor: pointer;
    }
    .editor{
        display: none;
    }
</style>
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
                <?php if ($this->session->flashdata('login')): ?>
                    <div class="note note-info note-bordered">
                        <p>
                        <div class="fa fa-check"></div>&nbsp;<?php echo $this->session->flashdata('login'); ?>
                        </p>
                    </div>

                <?php endif; ?>
                <!-- BEGIN PORTLET-->
                <div class="portlet light">
                    <div class="rows">
                        <div class="col-sm-6" style="display:none">
                            <form  role="form" action="<?php echo base_url(); ?>usermanagement" method="post" style="margin-bottom: 15px;">
                                <?php if ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button>
                                        <span>
                                            <?php echo $this->session->flashdata('error'); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success">
                                        <button class="close" data-close="alert"></button>
                                        <span>
                                            <?php echo $this->session->flashdata('success'); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('warning')): ?>
                                    <div class="alert alert-warning">
                                        <button class="close" data-close="alert"></button>
                                        <span>
                                            <?php echo $this->session->flashdata('warning'); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <fieldset style="border: 1px solid #e5e5e5; border-radius: 3px; color: #666666;">
                                    <legend style="font-size: 12px; border-radius: 3px; border: 1px solid #e5e5e5; padding: 3px 8px; margin: 10px 0 0 7px; width: auto; color: #666666;">Searching Data</legend>
                                    <div class="col-sm-12" style="padding: 15px;">

                                        <div class="form-group">
                                            <?php
                                            if ($this->session->flashdata('username')):
                                                $username = $this->session->flashdata('username');
                                            else :
                                                $username = "";
                                            endif
                                            ?>
                                            <label class="lbl control-label col-lg-4 col-sm-3 col-xs-12">Username</label>
                                            <div class="col-lg-8 col-sm-9 col-xs-12" style="margin-bottom: 20px; padding: 0;">
                                                <input type= "text" name= "username" value="<?php echo $username; ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary uppercase"><div class="fa fa-search"></div> CARI</button>
                                        </div>

                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>

                    <style>
                        .btn-text-hide span {
                            /*display: none;*/
                        }
                        .btn-text-hide:hover span {
                            /*display: inline-block;*/
                        }

                        .icon-md {
                            font-size: 16pt;
                        }
                    </style>

                    <div class="form-actions" style="margin-top: 20px;" align="right">
                        <a href="<?php echo base_url(); ?>usermanagement/register" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Tambah Data">
                            <i class="icon icon-md md-plus-circle"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Simpan Data">
                            <i class="icon icon-md md-floppy"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger" id="delete_all" onclick="bulk_delete()" data-toggle="tooltip" data-placement="bottom" title="Delete Data">
                            <i class="icon icon-md md-delete"></i>
                        </a>

                        <a href="<?php echo base_url(); ?>usermanagement" class="btn btn-warning uppercase btnnn" style="display:none">
                            Tampilkan semua data</a>
                    </div>

                    <br />

                    <div class="table-responsive">
                        <table class="table table-hover dataTable w-full" data-plugin="dataTable" style="font-size:13px">
                            <thead>
                                <tr>
                                    <th align="center" class="headTable">
                                        <input type="checkbox" id="check_all" />
                                    </th>
                                    <th height="43" align="center" class="headTable">No</th>
                                    <th class="headTable">Username</th>
                                    <th class="headTable">Nipp</th>
                                    <th class="headTable">Email</th>
                                    <th class="headTable">Privilege</th>
                                    <th class="headTable">Cabang</th>
                                    <th class="headTable">Posisi</th>
                                    <th class="headTable">Organisasi</th>
                                    <th class="headTable">Start Date</th>
                                    <th class="headTable">End Date</th>
                                    <th class="headTable">Responsibility</th>
                                    <th class="headTable">Status</th>
                                    <th class="headTable">Integrasi</th>
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
                                    <?php if ($this->session->flashdata('success')): ?>
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <div class="fa  fa-check"></div> <?php echo $this->session->flashdata('success'); ?><br>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php
                                $no = 0;
                                foreach ($list as $row): $no++;
                                    ?>
                                    <tr>
                                        <td align="center">
                                            <input type="checkbox" class="field-data-check" value="<?= $row->USER_ID ?>" data-id="<?= $row->USER_ID ?>" />
                                        </td>
                                        <td align="center"><?php echo $no; ?></td>
                                        <td><span class='span-username caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->USER_NAME ?></span> <input type='text' class='field-username form-control editor' value='<?= $row->USER_NAME ?>' data-id='<?= $row->USER_ID ?>' /></td>
                                        <td><span class='span-nipp caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->USER_NIPP ?></span> <input type='text' class='field-nipp form-control editor' value='<?= $row->USER_NIPP ?>' data-id='<?= $row->USER_ID ?>' /></td>
                                        <td><span class='span-email caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->USER_EMAIL ?></span> <input type='text' class='field-email form-control editor' value='<?= $row->USER_EMAIL ?>' data-id='<?= $row->USER_ID ?>' /></td>
                                        <td><span class='span-priv-name caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->USER_PRIV_NAME ?></span> <input type='text' class='field-priv-name form-control editor' value='<?= $row->USER_PRIV_NAME ?>' data-id='<?= $row->USER_ID ?>' /></td>
                                        <td><span class='span-branch-name caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->BRANCH_NAME ?></span> <input type='text' class='field-branch-name form-control editor' value='<?= $row->BRANCH_NAME ?>' data-id='<?= $row->USER_ID ?>' /></td>
                                        <td><span class='span-position-name caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->POSITION_NAME ?></span> <input type='text' class='field-position-name form-control editor' value='<?= $row->POSITION_NAME ?>' data-id='<?= $row->USER_ID ?>' /></td>
                                        <td><span class='span-position-name caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->BRANCH_NAME ?></span> <input type='text' class='field-position-name form-control editor' value='<?= $row->BRANCH_NAME ?>' data-id='<?= $row->USER_ID ?>' /></td>

                                        <td><span class='span-start-date caption' data-id='<?php echo $row->USER_ID ?>' start-date="<?php echo $row->USER_ID ?>"></span><input type='text' onchange="setSpanStartDate(<?php echo $row->USER_ID ?>, this.value)" class='field-start-date form-control editor datepicker' value='' data-id='<?php echo $row->USER_ID ?>' /></td>
                                        <td><span class='span-end-date caption' data-id='<?php echo $row->USER_ID ?>' end-date="<?php echo $row->USER_ID ?>"></span><input type='text' onchange="setSpanEndDate(<?php echo $row->USER_ID ?>, this.value)" class='field-end-date form-control editor datepicker' value='' data-id='<?php echo $row->USER_ID ?>' /></td>
                                        <!-- <td><!?php echo $row->USER_STATUS; ?></td> -->
                                        <td><a href="javascript:void(0);">Modal</a></td>
                                        <td align="center">
                                           <!-- <input type="text" name="id_user" id="id_user" value="<!?php echo $row->USER_ID ?>"> -->
                                            <a onclick="btn_edit_stat(<?php echo $row->USER_ID ?>)" class="btn btn-sm btn-outline btn-primary" style="color:#fff !important;" data-toggle="modal" data-target="#editstatus"> <?php
                                                switch ($row->USER_STATUS) {
                                                    case 1:
                                                        $USER_STATUS = 'Aktif';
                                                        break;
                                                    case 2:
                                                        $USER_STATUS = 'Non Aktif';
                                                        break;

                                                    default:
                                                        # code...
                                                        break;
                                                }
                                                echo $USER_STATUS;
                                                ?>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <select name="inetgrasi" id="integrasi" class="form-control">
                                                <option value="1">Y</option>
                                                <option value="0">T</option>
                                            </select>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>                                   
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade modal-3d-slit modal-danger" id="hapus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1"> 
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" id="modaldeleteuser" action="<?php echo base_url() ?>usermanagement/delete/<?php echo $list->USER_ID ?>">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Konfirmasi</h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- <input type="text" name="id_user" id="id_user_modal1"> -->
                                        <p>Apakah anda yakin ingin menghapus data ini ?</p>        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-pure btn-default" id="hapus" data-dismiss="modal"><div class="fa fa-times"></div> Tidak</button>
                                        <button type="submit" class="btn btn-md btn-danger"><div class="fa fa-check"> Ya</div></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade modal-3d-flip-vertical modal-info" id="editstatus" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <?php echo validation_errors(); ?>
                                <form method="post" id="modaleditstatus" action="<?php echo base_url(); ?>usermanagement/update_status/<?php echo $list->USER_ID; ?>">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Status User</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div> 
                                    <div class="modal-body">
                                     <!-- <input type="text" name="id_user" id="id_user_modal"> -->
                                        <div class="form-group">
                                            <label>Status :</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <div class="fa fa-group "></div>
                                                </div>
                                                <select name="status" class="form-control" required>
                                                    <option value="1" <?php echo ($data->USER_STATUS == 1) ? "selected='selected'" : ""; ?>>Aktif</option>
                                                    <option value="2" <?php echo ($data->USER_STATUS == 2) ? "selected='selected'" : ""; ?>>Non Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-default btn-pure" data-dismiss="modal"><div class="fa fa-ban"></div> Batal</button>
                                        <button type="submit" onclick="edit_status_submit()" class="btn btn-info"><div class="fa fa-pencil"> Ubah</div></button>
                                    </div> 
                                </form>
                                <!-- </div>  -->
                            </div>
                        </div>
                    </div>
                    <div class="modal animated fadeIn" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-controls-modal="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
    </div>
    <!-- END CONTENT -->
</div>

<script>
    function setSpanStartDate(id, data) {
        console.log(data);
        //console.log($('.field-start-date [data-id="' + id + '"]').val());
        $('[start-date="' + id + '"]').html(data);
    }
    function setSpanEndDate(id, data) {
        console.log(data);
        //console.log($('.field-start-date [data-id="' + id + '"]').val());
        $('[end-date="' + id + '"]').html(data);
    }

    // initialize datepicker
    $('.datepicker').datepicker({
        autoclose: true
    });

    function showField(elem) {
        elem.find("span[class~='caption']").hide();
        elem.find("input[class~='editor']").fadeIn().focus();
    }

    function hideField(elem) {
        elem.find("span[class~='caption']").show();
        elem.find("input[class~='editor']").fadeOut().hide();
    }

    $("td").on({
        keydown: function (e) {
            console.log(e.keyCode);
            if (e.keyCode == 27) {
                hideField($(this));
            }
        },
        click: function (e) {
            showField($(this));
        },
        mouseout: function (e) {
            console.log('mouseout');
        }
    });

    $("tr").on({
        keydown: function (e) {
            console.log(e.keyCode);
            if (e.keyCode == 27) {
                hideField($(this));
            }
        },
        click: function (e) {
            showField($(this));
        },
        mouseout: function (e) {
            console.log('mouseout');
        }
    });

    $("#check_all").click(function () {
        $(".field-data-check").prop('checked', $(this).prop('checked'));

    })

    ////////////////delete table cread by johan & hofar 27/1/2020
    function bulk_delete()
    {
        var list_id = [];
        $(".field-data-check:checked").each(function () {
            list_id.push(this.value);
            //console.log(list_id);
        });
        console.log(list_id);
        if (list_id.length > 0)
        {
            if (confirm('Are you sure delete this ' + list_id.length + ' data?'))
            {
                //alert('<!?= site_url('Usermanagement/delete_all') ?>');
                $.ajax({
                    type: "POST",
                    data: {USER_ID: list_id},
                    //url: "http://localhost/live_crud/tes/ajax_bulk_delete",
                    url: "<?= site_url('Usermanagement/delete_all') ?>",
                    dataType: "JSON",
                    success: function (data)
                    {
                        console.log(data);
                        if (data.status)
                        {
                            window.location.reload(true);
                            // reload_table();
                        } else
                        {
                            alert('Failed.');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);

                    }
                });
            }
        } else
        {
            alert('no data selected');
        }
    }



    $('#table').dataTable({
        paging: true,
        searching: true,
        "columnDefs": [
            {"orderable": false}
        ]
    });
</script>
<script type="text/javascript">
    var link_base = "<?php echo base_url(); ?>";
    function btn_edit_stat(id) {
        // alert(id);
        $.ajax({
            type: 'GET',
            url: link_base + '/tanpa_auth/edit_modalstatus/' + id,
            // data: {id : id},
            success: function (data) {
                // console.log(data);
                document.getElementById("modaleditstatus").action = link_base + '/usermanagement/update_status/' + id;
                var obj = JSON.parse(data);
                // $('#editstatus').modal();
                $("#id_user_modal").val(obj.USER_ID);
                // alert(obj.USER_ID);
                // $('#editstatus').find('.modal-body').html(data);
            }
        })
    }
</script>
<script type="text/javascript">
    var link_base = "<?php echo base_url(); ?>";
    function btn_delete_user(id) {
        // alert(id);
        $.ajax({
            type: 'GET',
            url: link_base + '/tanpa_auth/delete_modal/' + id,
            // data: {id : id},
            success: function (data) {
                // console.log(data);
                document.getElementById("modaldeleteuser").action = link_base + '/usermanagement/delete/' + id;
                var obj = JSON.parse(data);
                // $('#editstatus').modal();
                $("#id_user_modal1").val(obj.USER_ID);
                // alert(obj.USER_ID);
                // $('#editstatus').find('.modal-body').html(data);
            }
        })
    }
</script>
