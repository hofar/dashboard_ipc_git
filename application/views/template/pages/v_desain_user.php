<script type="text/javascript">
    window.onload = function () {
        $("#user_management").attr("class", "site-menu-item active");
    };
</script>
<script src="<?php echo base_url('assets/template/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
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
                        <a href="javascript:void(0);" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Tambah Data" id="tambah-data">
                            <i class="icon icon-md md-plus-circle"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Simpan Data" id="simpan-data">
                            <i class="icon icon-md md-floppy"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger" id="delete_all" data-toggle="tooltip" data-placement="bottom" title="Delete Data">
                            <i class="icon icon-md md-delete"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-default" id="reload" onclick="reload_table()" data-toggle="tooltip" data-placement="bottom" title="Reload Data">
                            <i class="icon icon-md md-refresh-sync"></i>
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
                                    <th class="headTable">Username</th>
                                    <th class="headTable">Password</th>
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
                            <tbody id="table-body">
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
                                        <td>
                                            <span class='span-username caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->USER_NAME ?></span>
                                            <input type='text' class='field-username form-control editor' value='<?= $row->USER_NAME ?>' data-id='<?= $row->USER_ID ?>' />
                                        </td>
                                        <td>
                                            <span class='span-password caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->USER_PASSWORD ?></span>
                                            <input type='password' class='field-password form-control editor' value='<?= $row->USER_PASSWORD ?>' data-id='<?= $row->USER_ID ?>' readonly />
                                        </td>
                                        <td>
                                            <span class='span-nipp caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->USER_NIPP ?></span>
                                            <input type='text' class='field-nipp form-control editor' value='<?= $row->USER_NIPP ?>' data-id='<?= $row->USER_ID ?>' />
                                        </td>
                                        <td>
                                            <span class='span-email caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->USER_EMAIL ?></span>
                                            <input type='text' class='field-email form-control editor' value='<?= $row->USER_EMAIL ?>' data-id='<?= $row->USER_ID ?>' />
                                        </td>
                                        <td>
                                            <span class='span-priv-name caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->USER_PRIV_NAME ?></span>
                                            <input type='text' class='field-priv-name form-control editor' value='<?= $row->USER_PRIV ?>' data-id='<?= $row->USER_ID ?>' readonly />
                                        </td>
                                        <td>
                                            <span class='span-branch-name caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->BRANCH_NAME ?></span>
                                            <input type='text' class='field-branch-name form-control editor' value='<?= $row->USER_BRANCH ?>' data-id='<?= $row->USER_ID ?>' readonly />
                                        </td>
                                        <td>
                                            <span class='span-position-name caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->POSITION_NAME ?></span>
                                            <input type='text' class='field-position-name form-control editor' value='<?= $row->USER_POSITION ?>' data-id='<?= $row->USER_ID ?>' readonly />
                                        </td>
                                        <td>
                                            <span class='span-position-name caption' data-id='<?php echo $row->USER_ID ?>'><?= $row->BRANCH_NAME ?></span>
                                            <input type='text' class='field-position-name form-control editor' value='<?= $row->USER_BRANCH ?>' data-id='<?= $row->USER_ID ?>' readonly />
                                        </td>

                                        <td>
                                            <span class='span-start-date caption' data-id='<?php echo $row->USER_ID ?>' start-date="<?php echo $row->USER_ID ?>"><?= date('Y-m-d'); ?></span>
                                            <input type='text' onchange="setSpanStartDate(<?php echo $row->USER_ID ?>, this)" onkeydown="return false;" class='field-start-date form-control editor datepicker' value='<?= date('Y-m-d'); ?>' data-id='<?php echo $row->USER_ID ?>' readonly />
                                        </td>
                                        <td>
                                            <span class='span-end-date caption' data-id='<?php echo $row->USER_ID ?>' end-date="<?php echo $row->USER_ID ?>"><?= date('Y-m-d'); ?></span>
                                            <input type='text' onchange="setSpanEndDate(<?php echo $row->USER_ID ?>, this)" class='field-end-date form-control editor datepicker' value='<?= date('Y-m-d'); ?>' data-id='<?php echo $row->USER_ID ?>' readonly />
                                        </td>
                                        <td><a href="javascript:void(0);">Modal</a></td>
                                        <td align="center">
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
                                            <select name="inetgrasi" id="integrasi" class="form-control" >
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
    /*
     * (simpan), (edit) created by johan & hofar 29/01/2020
     */
    function setSpanStartDate(id, elem) {
        var value = elem.value;
        //console.log(value);
        $('[start-date="' + id + '"]').html(value);
        //$('.datepicker [data-id="' + id + '"]').val(value);
        //console.log($(elem).target);
    }
    function setSpanEndDate(id, data) {
        console.log(data);
        $('[end-date="' + id + '"]').html(data);
    }
    function showField(elem) {
        elem.find("span[class~='caption']").hide();
        elem.find("input[class~='editor']").fadeIn().focus();
    }
    function hideField(elem) {
        elem.find("span[class~='caption']").show();
        elem.find("input[class~='editor']").fadeOut().hide();
    }
    /*
     * (delete table) created by johan & hofar 27/1/2020
     */
    function bulk_delete() {
        var list_id = [];
        $(".field-data-check:checked").each(function () {
            list_id.push(this.value);
            //console.log(list_id);
        });
        //console.log(list_id);
        if (list_id.length > 0) {
            if (confirm('Are you sure delete this ' + list_id.length + ' data?')) {
                //alert('<!?= site_url('Usermanagement/delete_all') ?>');
                $.ajax({
                    type: "POST",
                    data: {USER_ID: list_id},
                    //url: "http://localhost/live_crud/tes/ajax_bulk_delete",
                    url: "<?= site_url('Usermanagement/delete_all') ?>",
                    dataType: "JSON",
                    success: function (data) {
                        console.log(data);
                        if (data.status) {
                            window.location.reload(true);
                            // reload_table();
                        } else {
                            alert('Failed.');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);

                    }
                });
            }
        } else {
            alert('no data selected');
        }
    }
    function reload_table() {
        //table.ajax.reload(null, false); //reload datatable ajax
        location.reload();
    }
    function focusField(elem) {
        elem.find('input')[0].focus();
    }
    function simpanField(target) {
        console.log(target);

        var value = target.val();
        //console.log(value);
        var id = target.attr("data-id");
        var data = {id: id, value: value};
        if (target.is(".field-username")) {
            data.modul = "username";
        } else if (target.is(".field-password")) {
            data.modul = "password";
        } else if (target.is(".field-nipp")) {
            data.modul = "nipp";
        } else if (target.is(".field-email")) {
            data.modul = "email";
        } else if (target.is(".field-priv-name")) {
            data.modul = "privilage";
        } else if (target.is(".field-branch-name")) {
            data.modul = "branch";
        } else if (target.is(".field-position-name")) {
            data.modul = "posisi";
        } else if (target.is(".field-organization")) {
            data.modul = "organization";
        } else if (target.is(".field-responsibility")) {
            data.modul = "responsibility";
        } else if (target.is(".field-posisi")) {
            data.modul = "posisi";
        } else if (target.is(".field-status")) {
            data.modul = "status";
        } else if (target.is(".field-integrasi")) {
            data.modul = "integrasi";
        } else if (target.is(".field-strat-date")) {
            data.modul = "integrasi";
        } else if (target.is(".field-start-date")) {
            data.modul = "start-date";
        } else if (target.is(".field-end-date")) {
            data.modul = "end-date";
        }

        $.ajax({
            data: data,
            type: 'POST',
            url: "<?php echo base_url('tes/update'); ?>",
            success: function (a) {
                target.hide();
                target.siblings("span[class~='caption']").html(value).fadeIn();
            }
        });
    }
    function hapusMember(id) {
        swal({
            title: "Hapus Member",
            text: "Yakin akan menghapus member ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Hapus",
            closeOnConfirm: true
        },
                function () {
                    $.ajax({
                        url: "<?php echo base_url('tes/delete'); ?>",
                        data: {id: id},
                        success: function () {
                            $("tr[data-id='" + id + "']").fadeOut("fast", function () {
                                $(this).remove();
                            });
                        }
                    });
                });
    }
    function setOptionPriv(id) {
        $.ajax({})
    }
    function setOptionPosition(id) {

    }
    function setOptionBranch(id) {

    }

    // untuk tambah data
    $('#tambah-data').on({
        click: function () {
            $.ajax({
                url: "<?php echo base_url('Usermanagement/create'); ?>",
                dataType: 'json',
                success: function (data) {
                    var id = data.id;
                    var a = id.MAX_USER_ID;
                    //console.log(data);
                    //console.log(id);
                    console.log(a);

                    setOptionPriv(a);
                    setOptionPosition(a);
                    setOptionBranch(a);

                    var ele = "";
                    ele += "<tr data-id='" + a + "'>";
                    ele += "<td><input type='checkbox' class='field-data-check' value='" + a + "' data-id='" + a + "' /></td>";

                    ele += "<td><span class='span-username caption' data-id='" + a + "'></span> <input type='text' class='field-username form-control editor' style='display:inline-block;' data-id='" + a + "' /></td>";

                    ele += "<td><span class='span-password caption' data-id='" + a + "'></span> <input type='text' class='field-password form-control editor' style='display:inline-block;' data-id='" + a + "' /></td>";

                    ele += "<td><span class='span-nipp caption' data-id='" + a + "'></span> <input type='text' class='field-nipp form-control editor' style='display:inline-block;' data-id='" + a + "' /></td>";

                    ele += "<td><span class='span-email caption' data-id='" + a + "'></span> <input type='text' class='field-email form-control editor' style='display:inline-block;'  data-id='" + a + "' /></td>";

                    ele += "<td><span class='span-privilage caption' data-id='" + a + "'></span>";
                    //ele += "<input type='text' class='field-privilage form-control editor' style='display:inline-block;'  data-id='" + a + "' />";
                    ele += "<select name='privilage' class='field-priv-name form-control '  data-validation='required' data-validation-error-msg='Privilege harus di pilih' id='privilage' onchange='privilage_select()'><option value=''>-- Pilih Privilege --</option><?php foreach ($groups as $row) { ?><option value='<?php echo $row->USER_PRIV_ID; ?>'><?php echo $row->USER_PRIV_NAME; ?> </option><?php } ?></select>";
                    ele += "</td>";

                    ele += "<td><span class='span-cabang caption' data-id='" + a + "'></span>";
                    //ele += "<input type='text' class='field-cabang form-control editor' style='display:inline-block;' data-id='" + a + "' />";
                    ele += "<select name='branch' class='field-branch-name form-control' data-validation='required' data-validation-error-msg='Branch harus di pilih' id='branch' onchange='branch_select()'><option value=''>-- Pilih Branch --</option><?php foreach ($groupsPusat1 as $row) { ?><option value='<?php echo $row->BRANCH_ID; ?>'><?php echo $row->BRANCH_NAME; ?></option><?php } ?></select> ";
                    ele += "</td>";

                    ele += "<td><span class='span-posisi caption' data-id='" + a + "'></span>";
                    //ele += "<input type='text' class='field-posisi form-control editor' style='display:inline-block;'  data-id='" + a + "' />";
                    ele += "<select name='posisi' class='field-posisi-name form-control' data-validation='required' data-validation-error-msg='Posisi harus di pilih' id='posisi' ><option value=''>-- Pilih Posisi --</option><?php foreach ($groups2 as $row) { ?><option value='<?php echo $row->POSITION_ID; ?>'><?php echo $row->POSITION_NAME; ?></option><?php } ?></select>";
                    ele += "</td>";

                    ele += "<td><span class='span-organisasi caption' data-id='" + a + "'></span> <input type='text' class='field-organisasi form-control editor' style='display:inline-block;'  data-id='" + a + "' /></td>";

                    ele += "<td><span class='span-start-date caption' data-id='" + a + "'></span> <input type='text' class='field-start-date form-control editor datepicker' value='<?= date('Y-m-d'); ?>' style='display:inline-block;' data-id='" + a + "' /></td>";

                    ele += "<td><span class='span-end-date caption' data-id='" + a + "'></span> <input type='text' class='field-end-date form-control editor datepicker' style='display:inline-block;'  data-id='" + a + "' /></td>";

                    ele += "<td><a href='javascript:void(0);'>Modal</a></td>";

<?php
$combo_user_ = '';
switch ($row->USER_STATUS) {
    case 1:
        $USER_STATUS = 'Aktif';
        break;
    case 2:
        $USER_STATUS = 'Non Aktif';
        break;
}
$combo_user_ = $USER_STATUS;
?>

                    ele += "<td align='center'>";
                    ele += "<a onclick='btn_edit_stat(" + a + ")' class='btn btn-sm btn-outline btn-primary' style='color:#fff !important;' data-toggle='modal' data-target='#editstatus'><?php echo $combo_user_ ?></a>";
                    ele += "</td>";

                    ele += "<td><select name='inetgrasi' id='integrasi' class='form-control'><option value='>Y</option><option value='>T</option></select></td>";

                    ele += "</tr>";

                    var element = $(ele);
                    var cells = element[0].cells;
                    console.log(cells);
                    element.hide();
                    element.prependTo("#table-body").fadeIn(0);

                    console.log($($(cells[1]).children()[1]).focus());
                }
            });
        }
    });
    // datepicker
    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        startDate: '0d'
    });
    $("td").on({
        keydown: function (e) {
            var kc = e.keyCode;
            //console.log(kc);
            if (kc === 27) {
                hideField($(this));
            }
            if (kc === 13) {
                //console.log($(e.target));
                simpanField($(e.target));
            }
        },
        click: function (e) {
            showField($(this));
        },
        mouseout: function (e) {
            console.log('mouseout');
        }
    });
    $('#delete_all').on({
        click: function () {
            bulk_delete();
        }
    });
    $('#simpan-data').on({
        click: function () {
            $.each($('.editor'), function (i, v) {
                var e = $(v);
                simpanField(e);
                //console.log(e);
            });
        }
    });
    $('#reload').on({
        click: function () {
            window.location.reload();
        }
    });
    $("#check_all").click(function () {
        $(".field-data-check").prop('checked', $(this).prop('checked'));

    });
    $('.field-data-check').on({
        change: function (e) {
            var elem = $(this).parent();
            var cells = [];
            cells = $(elem[0]).parent()[0].cells;
            //console.log($(elem[0]).parent());
            if ($(this).prop('checked')) {
                // editable row
                $.each(cells, function (i, v) {
                    var el = $(cells[i]);
                    //console.log(el);
                    showField(el);
                    //$(cells[i]).click();
                });

                focusField($(cells[1]));
            } else {
                // not editable row
                $.each(cells, function (i, v) {
                    var el = $(cells[i]);
                    //console.log(el);
                    hideField(el);
                    //$(cells[i]).click();
                });
            }
        }
    });
    $('#table').dataTable({
        paging: true,
        searching: true,
        "columnDefs": [
            {"orderable": false}
        ]
    });
</script>

<script>
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
        });
    }
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
        });
    }
</script>

<script type="text/javascript">
    function privilage_select() {
        var privilage_val = $("#privilage").val();
        var branch_val = $("#branch").val();
        var posisi_val = $("#posisi").val();
        var data_branch_pusat = <?php echo json_encode($groupsPusat1) ?>;
        var data_posisi_pusat = <?php echo json_encode($groupsPusat2) ?>;
        var data_branch = <?php echo json_encode($groups1) ?>;
        var data_posisi = <?php echo json_encode($groups2) ?>;
        var data_branch_anak = <?php echo json_encode($groupsAnak1) ?>;
        var data_posisi_anak = <?php echo json_encode($groupsAnak2) ?>;
        var branch_html = '<option value="">-- Pilih Branch --</option>';
        var posisi_html = '<option value="">-- Pilih Posisi --</option>';


        // alert(privilage_val);    
        if (privilage_val == 1) {
            data_branch_pusat.forEach(function (element) {
                console.log(element);
                branch_html += '<option value="' + element.BRANCH_ID + '">' + element.BRANCH_NAME + '</option>';

            });
        } else if (privilage_val == 2) {
            data_branch.forEach(function (element) {
                console.log(element);
                branch_html += '<option value="' + element.BRANCH_ID + '">' + element.BRANCH_NAME + '</option>';

            });
        } else if (privilage_val == 3) {
            data_branch_anak.forEach(function (element) {
                console.log(element);
                branch_html += '<option value="' + element.BRANCH_ID + '">' + element.BRANCH_NAME + '</option>';

            });
        } else {
            branch_html = '<option value="">-- Pilih Branch --</option>';
        }

        // console.log(branch_html);

        $('#branch').html(branch_html);

        if (privilage_val > 0) {
            $("#add_user  #branch").removeAttr('disabled');
            $("#add_user  #posisi").attr('disabled', 'disabled');
        } else {
            $("#add_user  #branch").attr('disabled', 'disabled');
            $("#add_user  #posisi").attr('disabled', 'disabled');
        }

    }
    function branch_select() {
        var privilage_val = $("#privilage").val();
        var branch_val = $("#branch").val();
        var posisi_val = $("#posisi").val();
        var data_branch_pusat = <?php echo json_encode($groupsPusat1) ?>;
        var data_posisi_pusat = <?php echo json_encode($groupsPusat2) ?>;
        var data_branch = <?php echo json_encode($groups1) ?>;
        var data_posisi = <?php echo json_encode($groups2) ?>;
        var data_branch_anak = <?php echo json_encode($groupsAnak1) ?>;
        var data_posisi_anak = <?php echo json_encode($groupsAnak2) ?>;

        var branch_html = '<option value="">-- Pilih Branch --</option>';
        var posisi_html = '<option value="">-- Pilih Posisi --</option>';

        if (privilage_val == 1) {
            data_posisi_pusat.forEach(function (element1) {
                console.log(element1);
                posisi_html += '<option value="' + element1.POSITION_ID + '">' + element1.POSITION_NAME + '</option>';

            });
        } else if (privilage_val == 2) {
            data_posisi.forEach(function (element1) {
                console.log(element1);
                posisi_html += '<option value="' + element1.POSITION_ID + '">' + element1.POSITION_NAME + '</option>';

            });
        } else if (privilage_val == 3) {
            data_posisi_anak.forEach(function (element1) {
                console.log(element1);
                posisi_html += '<option value="' + element1.POSITION_ID + '">' + element1.POSITION_NAME + '</option>';

            });
        } else {
            posisi_html = '<option value="">-- Pilih Posisi --</option>';
        }

        // console.log(branch_html);

        $('#posisi').html(posisi_html);

        // alert(branch_val);
        if (branch_val >= 0) {
            $("#add_user  #posisi").removeAttr('disabled');
        } else {
            $("#add_user  #posisi").attr('disabled', 'disabled');
        }
    }
</script>