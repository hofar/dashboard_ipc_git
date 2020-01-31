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

    a{
        color:#434343;
    }

    .panelCustom{
        width:95%; background-color:#FFF;box-shadow:rgba(204,204,204,0.80) 5px 5px 15px 0px; 
        padding:15px 25px 10px 25px
    }
    .breadcrumb-right-arrow .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        vertical-align:top;
        font-size:40px;
        line-height:15px;
        /*line*/
    }
    .breadcrumb >li :hover {

    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link href="<?php echo base_url(); ?>assets/template/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>

<div class="page">
    <div class="page-content">
        <div class="col-md-12">
            <ol class="breadcrumb breadcrumb-right-arrow">
                <li class="breadcrumb-item">
                    <i class="fa fa-home fa-lg"></i>
                    <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
                </li>
                <li class="breadcrumb-item"> <a href="<?php echo base_url(); ?>rkapinvestasi">RKAP Investasi</a></li>
                <li class="breadcrumb-item active">Detail Realisasi</li>
            </ol>
        </div>
        <div class="headTab">
            <i class="icon md-time-interval"></i> Detail Ganttchart
        </div>
        <div class="panels" align="center" style="padding-bottom:30px !important;"> 

            <div align="right" style="width:95%;margin-bottom:15px;font-size:20px">
                <a href="<?php echo base_url(); ?>rkapinvestasi/detail/<?php echo $row_rkap->RKAP_INVS_ID ?>" class="btn btn-default btn-round">
                    Kembali ke RKAP</a>

                <a onclick="btn_add_gantt(<?php echo $row->RKAP_INVS_ID ?>)" href="#" class="btn btn-default btn-round" data-toggle="modal" data-target="#add_subpro"><div class="fa fa-plus"></div> Tambah Sub Program</a>
            </div>



            <div align="center" class="panelCustom" style="background-color:#F5F5F5">
                <div id="timeline" style="height:220px; width:100%; font-size:12px !important"></div>
            </div>

            <div align="left" class="panelCustom">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button>
                        <span>
                            <?php echo $this->session->flashdata('success'); ?>
                        </span>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('message')): ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span>
                            <?php echo $this->session->flashdata('message'); ?>
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
                <table class="table table-hover dataTable w-full" data-plugin="dataTable" style="font-size:12px !important">
                    <thead>
                        <tr>
                            <th>Judul Sub Program</th>
                            <th>Jenis Subprogram</th>
                            <th>Start Date</th>
                            <th>End Date</th>
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
                        </div>
                        <?php foreach ($list as $row): ?>
                            <tr>
                                <td><?php echo $row->RKAP_SUBPRO_TITTLE; ?></td>
                                <td>
                                    <?php echo $row->SUBPRO_TYPE_NAME; ?>
                                </td>
                                <td>
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                        <input type="text" class="form-control date-picker" value="<?php echo ($row->RKAP_SUBPRO_START ) ? date("d-m-Y", strtotime($row->RKAP_SUBPRO_START)) : ''; ?>" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="tgl_start" id="tgl_start<?php echo $row->RKAP_SUBPRO_ID ?>" disabled/>

                                    </div>
                                </td>

                                <td>
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                        <input type="text" class="form-control date-picker" value="<?php echo ($row->RKAP_SUBPRO_END ) ? date("d-m-Y", strtotime($row->RKAP_SUBPRO_END)) : ''; ?>"  data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="tgl_end" id="tgl_end<?php echo $row->RKAP_SUBPRO_ID ?>" disabled/>

                                    </div>
                                </td>
                                <td align=" center">
                                    <?php if ($row->RKAP_SUBPRO_START && $row->RKAP_SUBPRO_END != null): ?>
                                        <a class="btn btn-sm btn-default btn-round" title="Edit Data" data-toggle="modal" onclick="btn_update_date(<?php echo $row->RKAP_SUBPRO_ID ?>)"  data-target="#update_date"><i class="fa fa-gears"></i></a>

                                        <a onclick="btn_delete_ganttchart(<?php echo $row->RKAP_SUBPRO_ID ?>)" data-toggle="modal" style="color:#fff !important;" data-target="#hapus_ganttchart" href="#" class="btn btn-sm btn-danger btn-round" title="Hapus Data"><i class="fa fa-trash-o" ></i></a>
                                    <?php else: ?>
                                        <a onclick="btn_add_date(<?php echo $row->RKAP_SUBPRO_ID ?>)" href="#" class="btn btn-sm btn-success btnnn" title="Tambah Data Ke Chart" data-toggle="modal" data-target="#add_date" ><i class="fa fa-plus"></i></a>

                                                                                                                <!-- <a onclick="btn_delete_ganttchart(<?php echo $row->RKAP_SUBPRO_ID ?>)" data-toggle="modal" style="color:#fff !important;" data-target="#hapus_ganttchart" href="#" class="btn btn-sm btn-default btn-round" title="Hapus Data"><i class="fa fa-trash-o" ></i></a> -->
                                    <?php endif ?>

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

<?php if ($this->session->flashdata('login')): ?>
    <div class="note note-info note-bordered">
        <p>
        <div class="fa fa-check"></div>&nbsp;<?php echo $this->session->flashdata('login'); ?>
    </p>
    </div>

<?php endif; ?>
<!-- BEGIN PORTLET-->
<div class="portlet light">
    <!--  <div class="col-sm-12 ganttchart">
         <img src="<?php echo base_url(); ?>assets/img/gantchart.png" style="width: 100%; height: 300px;" alt="" class="logo-default"/>
     </div> -->

    <div class="modal animated fadeIn" id="add" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-controls-modal="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <div class="modal animated fadeIn" id="hapus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-controls-modal="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <div class="modal animated fadeIn" id="update" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-controls-modal="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <div class="modal fade modal-fade-in-scale-up modal-success" id="add_subpro" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="add_ganttchart" method="post" action="<?php echo base_url() ?>ganttchart/add_subpro/<?php echo $row_rkap->RKAP_INVS_ID ?>">
                    <div class="modal-header">
                        <button class="close" area-hidden="true" data-dismiss="modal" type="button">x</button>
                        <h4 class="modal-title">Tambah Data Sub Program</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_rkap" id="id_rkap" value="<?php echo $row_rkap->RKAP_INVS_ID ?>">
                        <div class="form-group rows" style="margin-bottom: 20px;">
                            <label class="control-label col-sm-5">Judul Sub Program</label>
                            <div class="col-sm-7">
                                <div class="form-group" >
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            <span class="fa fa-file"></span>
                                        </span>
                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? '' : $list->RKAP_SUBPRO_TITTLE ?>" name="judul_sub_program" data-validation="required" data-validation-error-msg="Judul sub program harus diisi" id="judul_sub_program" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group rows" style="margin-bottom: 20px;">
                            <label class="control-label col-sm-5">Jenis Sub Program</label>
                            <div class="col-sm-7">
                                <div class="form-group" >
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            <span class="fa fa-file"></span>
                                        </span>
                                        <select name="jenis_sub_program" class="form-control" data-validation="required" data-validation-error-msg="Jenis sub program harus diisi" id="jenis_sub_program">
                                            <option value="">-- Pilih Jenis Sub Program --</option>

                                            <?php
                                            foreach ($groups as $row) {
                                                if ($act == 'add') {
                                                    echo '<option value="' . $row->SUBPRO_TYPE_ID . '">' . $row->SUBPRO_TYPE_NAME . '</option>';
                                                } else {
                                                    if ($list->RKAP_SUBPRO_TYPE_ID == $row->SUBPRO_TYPE_ID) {

                                                        echo '<option selected value="' . $row->SUBPRO_TYPE_ID . '">' . $row->SUBPRO_TYPE_NAME . '</option>';
                                                    } else {

                                                        echo '<option value="' . $row->SUBPRO_TYPE_ID . '">' . $row->SUBPRO_TYPE_NAME . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <!-- <div class="clearfix"></div> -->

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-pure btn-default" ><div class="fa fa-refresh"></div> Reset</button>
                        <button type="submit" class="btn btn-success"><div class="fa fa-plus"> tambah</div></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal Add date -->

    <div class="modal fade modal-fade-in-scale-up modal-success" id="add_date" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="add_ganttchart_date" method="post" action="<?php echo base_url() ?>ganttchart/add_subpro/<?php echo $row_rkap->RKAP_INVS_ID ?>">
                    <div class="modal-header">
                        <button class="close" area-hidden="true" data-dismiss="modal" type="button">x</button>
                        <h4 class="modal-title">Tambah Data Ke Ganttchart</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" value="<?php echo $list->RKAP_SUBPRO_ID ?>">
                        <input type="hidden" name="id_rkap" id="id_rkap" value="<?php echo $list->RKAP_SUBPRO_INVS_ID ?>">
                        <div class="form-group rows" style="margin-bottom: 20px;">
                            <label class="control-label col-sm-5">Jenis SUB Program</label>
                            <div class="col-sm-7">
                                <div class="form-group" >
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            <span class="fa fa-file"></span>
                                        </span>
                                        <input id="subpro_title" class="form-control" type="text" value=" <?php echo $list->RKAP_SUBPRO_TITTLE; ?>" disabled />
                                        <p id="subpro_title"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group rows" style="margin-bottom: 20px;">
                            <label class="control-label col-sm-5">Start Date</label>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                        <input type="text" class="form-control date-picker" autocomplete="off" value="<?php echo $list->RKAP_SUBPRO_START; ?>"  name="tgl_start"  data-date-format="dd-mm-yyyy" data-validation="required" data-validation-error-msg="Tanggal awal harus diisi" id="tgl_start"/>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group rows" style="margin-bottom: 20px;">
                            <label class="control-label col-sm-5">End Date</label>
                            <div class="col-sm-7">
                                <div class="form-group" >
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                        <input type="text" class="form-control date-picker" autocomplete="off" value="<?php echo $list->RKAP_SUBPRO_END; ?>"  data-date-format="dd-mm-yyyy" name="tgl_end" data-validation="required"  data-validation-error-msg="Tanggal berakhir harus diisi" id="tgl_end" onchange="date_validation()"/>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-pure btn-default" ><div class="fa fa-refresh"></div> Reset</button>
                        <button type="submit" class="btn btn-success"><div class="fa fa-plus"> tambah</div></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal update date -->

    <div class="modal fade modal-fade-in-scale-up modal-success" id="update_date" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="update_ganttchart_date" method="post" action="<?php echo base_url() ?>ganttchart/update/<?php echo $row_rkap->RKAP_INVS_ID ?>">
                    <div class="modal-header">
                        <button class="close" area-hidden="true" data-dismiss="modal" type="button">x</button>
                        <h4 class="modal-title">Update Data Dari Ganttchart</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" value="<?php echo $list->RKAP_SUBPRO_ID ?>">
                        <input type="hidden" name="id_rkap" id="id_rkap" value="<?php echo $list->RKAP_SUBPRO_INVS_ID ?>">
                        <div class="form-group rows" style="margin-bottom: 20px;">
                            <label class="control-label col-sm-5">Jenis SUB Program</label>
                            <div class="col-sm-7">
                                <div class="form-group" >
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            <span class="fa fa-file"></span>
                                        </span>
                                        <input id="u_subpro_title" class="form-control" autocomplete="off" type="text" value=" " disabled /><span ></span>
                                        <!-- <p id="subpro_title"></p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group rows" style="margin-bottom: 20px;">
                            <label class="control-label col-sm-5">Start Date</label>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                        <input type="text" class="form-control date-picker" autocomplete="off" value="" data-date-format="dd-mm-yyyy" name="tgl_start" data-validation="required" data-validation-error-msg="Tanggal awal harus diisi" id="u_tgl_start"/>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group rows" style="margin-bottom: 20px;">
                            <label class="control-label col-sm-5">End Date</label>
                            <div class="col-sm-7">
                                <div class="form-group" >
                                    <div class='input-group'>
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                        <input type="text" class="form-control date-picker"  value=""  data-date-format="dd-mm-yyyy" name="tgl_end" data-validation="required" data-validation-error-msg="Tanggal berakhir harus diisi" id="u_tgl_end" />
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-pure btn-default" ><div class="fa fa-refresh"></div> Reset</button>
                        <button type="submit" class="btn btn-success"><div class="fa fa-plus"> Ubah</div></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal delete -->
    <div class="modal fade modal-3d-slit modal-danger" id="hapus_ganttchart" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="modaldelete" action="<?php echo base_url() ?>ganttchart/delete/<?php echo $list->RKAP_SUBPRO_ID ?>">
                    <div class="modal-header">
                        <button class="close" area-hidden="true" data-dismiss="modal" type="button">x</button>
                        <h4 class="modal-title">Konfirmasi</h4>
                    </div>
                    <div class="modal-body">
                        <!-- <input type="text" name="id_user" id="id_user_modal"> -->
                        <p>Apakah anda yakin ingin menghapus data <span id="delete_title"></span> ini dari ganttchart?</p>        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-pure btn-default" id="hapus" data-dismiss="modal"><div class="fa fa-times"></div> Tidak</button>
                        <button type="submit" class="btn btn-md btn-danger"><div class="fa fa-check"> Ya</div></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/highcharts/jquery.js"></script>

    <!-- BEGIN FOOTER -->
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> -->

    <script src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="<?php echo base_url(); ?>assets/template/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/admin/layout4/scripts/layout.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/admin/layout4/scripts/demo.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/index3.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/tasks.js" type="text/javascript"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/datatables/plugins/bootstrap/jquery.dataTables.min.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/table-advanced.js"></script>
    <script src="<?php echo base_url(); ?>assets/form-validator/jquery.form-validator.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/components-pickers.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
                                            $.validate({
                                                modules: 'security'
                                            });</script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/components-pickers.js"></script>

    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- <script>
        jQuery(document).ready(function () {
    
            ComponentsPickers.init();
    
        });
    </script> -->

    <script type="text/javascript">
                                            var act = $('#act').val();
                                            // alert(act);

                                            if (act == 'detail') {
                                                $("#addrkapinvestasi input").attr('disabled', 'disabled');
                                                $("#addrkapinvestasi select").attr('disabled', 'disabled');
                                                $("#addrkapinvestasi  #button-edit").hide();
                                                $("#addrkapinvestasi  #button-add").hide();
                                                $("#addsubprogramrkapinvestasi input").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi select").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-add").hide();
                                                $("#addsubprogramrkapinvestasi  #button-edit").hide();
                                                $("#addsubprogramrkapinvestasi  #button-back").hide();
                                                $("#entryaddendum input").attr('disabled', 'disabled');
                                                $("#entryaddendum select").attr('disabled', 'disabled');
                                                $("#entryaddendum  #button-add").hide();
                                                $("#entryaddendum  #button-edit").hide();
                                                $("#entryaddendum  #button-back").hide();
                                                $("#addrealisasi  #button-add").hide();
                                                $("#addrealisasi  #button-edit").hide();
                                                $("#addrealisasi  #button-back").hide();
                                                $("#addrealisasi input").attr('disabled', 'disabled');
                                                $("#addrealisasi select").attr('disabled', 'disabled');
                                                $("#addrealisasi textarea").attr('disabled', 'disabled');
                                                // $("#addrealisasi  #button-monitoring").attr('disabled', 'disabled');
                                            } else if (act == 'add') {
                                                $("#addrkapinvestasi  #button-edit").hide();
                                                $("#addrkapinvestasi  #button-list").attr('disabled', 'disabled');
                                                $("#addrkapinvestasi  #button-tambah-subadd").attr('disabled', 'disabled');
                                                $("#addrkapinvestasi  #button-gantt-chart").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-kurva").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-view-addendum").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-entry-addendum").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-view-realisasi").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-entry-realisasi").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-edit").hide();
                                                $("#entryaddendum  #button-edit").hide();
                                                $("#addrealisasi  #button-edit").hide();
                                                $("#addrealisasi  #button-monitoring").attr('disabled', 'disabled');
                                            } else if (act == 'edit') {
                                                $("#addrkapinvestasi  #button-add").hide();
                                                $("#addrkapinvestasi  #button-list").attr('disabled', 'disabled');
                                                $("#addrkapinvestasi  #button-tambah-subedit").attr('disabled', 'disabled');
                                                $("#addrkapinvestasi  #button-gantt-chart").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-back").hide();
                                                $("#addsubprogramrkapinvestasi  #button-kurva").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-view-addendum").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-entry-addendum").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-view-realisasi").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-entry-realisasi").attr('disabled', 'disabled');
                                                $("#addsubprogramrkapinvestasi  #button-add").hide();
                                                $("#entryaddendum  #button-add").hide();
                                                $("#entryaddendum  #button-back").hide();
                                                $("#addrealisasi  #button-add").hide();
                                                $("#addrealisasi  #button-back").hide();
                                                $("#addrealisasi  #button-monitoring").attr('disabled', 'disabled');
                                            }


    </script>

    <script type="text/javascript">
        var link_base = "<?php echo base_url(); ?>";
        function check_btn_update(id) {
            // alert(id);
            $.ajax({
                type: 'GET',
                url: link_base + '/ganttchart/update_modal/' + id,
                // data: {id : id},
                success: function (data) {
                    // console.log(data);
                    $('#update').modal();
                    $('#update').find('.modal-content').html(data);
                }
            })
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {'packages': ['timeline']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var container = document.getElementById('timeline');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();

            dataTable.addColumn({type: 'string', id: 'President'});
            dataTable.addColumn({type: 'date', id: 'Start'});
            dataTable.addColumn({type: 'date', id: 'End'});
            dataTable.addRows([

<?php if (empty($report)) { ?>


    <?php
} else {

    $no = 0;
    $number = 0;
    foreach ($report as $rowdata) {
        $blnstart = strtotime($rowdata->RKAP_SUBPRO_START);
        $newstart = date('Y, m, d', $blnstart);
        $blnend = strtotime($rowdata->RKAP_SUBPRO_END);
        $newend = date('Y, m, d', $blnend);
        ?>
                    ['<?php echo $rowdata->RKAP_SUBPRO_TITTLE; ?>', new Date(<?php echo $newstart; ?>), new Date(<?php echo $newend; ?>)],
        <?php
        $query3 = $this->db->query("select RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, add_months(RKAP_SUBPRO_CONTRACT_DATE, -1)  as RKAP_SUBPRO_CONTRACT_DATE, add_months(RKAP_SUBPRO_END_REAL, -1) as RKAP_SUBPRO_END_REAL 
                                        from TX_RKAP_SUB_PROGRAM where RKAP_SUBPRO_ID = '" . $rowdata->RKAP_SUBPRO_ID . "' and RKAP_SUBPRO_INVS_ID = '" . $rowdata->RKAP_SUBPRO_INVS_ID . "'  and IS_DELETED ='0'");


        foreach ($query3->result() as $rencadd) {
            $no++;
            $startrencana = strtotime($rencadd->RKAP_SUBPRO_CONTRACT_DATE);
            $newstartrencana = date('Y, m, d', $startrencana);
            $endrencana = strtotime($rencadd->RKAP_SUBPRO_END_REAL);
            $newendrencana = date('Y, m, d', $endrencana);
            ?>
            <?php
            if ($startrencana || $endrencana != null) {
                ?>
                            ['Realisasi <?php echo $no; ?>', new Date(<?php echo $newstartrencana; ?>), new Date(<?php echo $newendrencana; ?>)],
                <?php
            } else {
                ?>

                <?php
            }
            ?>

            <?php
        }

        $query2 = $this->db->query("select RKAP_SUBPRO_ID, add_months(SUBPRO_ADD_DATE, -1)  as SUBPRO_ADD_DATE, add_months(SUBPRO_ADD_END_REAL, -1) as SUBPRO_ADD_END_REAL 
                                        from TX_SUB_PROGRAM_ADDENDUM where RKAP_SUBPRO_ID = '" . $rowdata->RKAP_SUBPRO_ID . "' and IS_DELETED ='0' order by SUBPRO_ADD_ID asc");
        // print_r($query2->result); die();
        foreach ($query2->result() as $gantadd) {
            $number++;
            $startganttadd = strtotime($gantadd->SUBPRO_ADD_DATE);
            $newstartganttadd = date('Y, m, d', $startganttadd);
            $endganttadd = strtotime($gantadd->SUBPRO_ADD_END_REAL);
            $newendganttadd = date('Y, m, d', $endganttadd);
            ?>
                        // console.log($gantadd);
                        ['Addendum <?php echo $number; ?>', new Date(<?php echo $newstartganttadd; ?>), new Date(<?php echo $newendganttadd; ?>)],
            <?php
        }
    }
}
?>
            ]);

            var options = {
                timeline: {colorByRowLabel: true}
            };

            chart.draw(dataTable);
        }
    </script>

    <script type="text/javascript">
        var link_base = "<?php echo base_url(); ?>";
        function btn_add_gantt(id) {
            // alert(id);
            $.ajax({
                type: 'GET',
                url: link_base + '/ganttchart/addsubpro_modal/' + id,
                // data: {id : id},
                success: function (data) {
                    // console.log(data);
                    var obj = JSON.parse(data);
                    document.getElementById("add_ganttchart").action = link_base + '/ganttchart/add_subpro/' + id;
                    $("#id_user_modal").val(obj.CRITIC_ID);

                }
            })

            $.ajax({
                url: link_base + "/ganttchart/list_subpro/",
                success(res) {
                    var data = JSON.parse(res);
                    console.log(data);

                    /*dropdown*/
                    var d_status = "";

                    $.each(data.subpro, function (key, val) {
                        d_status += '<option value=' + val.SUBPRO_TYPE_ID + '>' + val.SUBPRO_TYPE_NAME + '</option>';

                    });

                    // value="val.STATUS_NAME"
                    $('#jenis_sub_program').html(d_status);
                }
            })
        }
        //modal add date ganttchart
        function btn_add_date(id) {
            document.getElementById("add_ganttchart_date").action = link_base + '/ganttchart/update/' + id;
            // $.ajax({
            //     type: 'GET',
            //     url: link_base+'/ganttchart/add_modal/' + id,
            //     // data: {id : id},
            //     success: function (data) {
            //         // console.log(data);
            //         var obj = JSON.parse(data);

            //     }
            // })
            ComponentsPickers.init();
            $.ajax({
                url: link_base + "/ganttchart/add_modal/" + id,
                success(res) {
                    var data = JSON.parse(res);
                    console.log(data);
                    $('#subpro_title').val(data.list['RKAP_SUBPRO_TITTLE']);

                    // alert(data.list['RKAP_SUBPRO_TITTLE'])
                }
            })
        }
        function btn_update_date(id) {
            // $.ajax({
            //     type: 'GET',
            //     url: link_base+'/ganttchart/update_modal/' + id,
            //     // data: {id : id},
            //     success: function (data) {
            //         // console.log(data);
            document.getElementById("update_ganttchart_date").action = link_base + '/ganttchart/update/' + id;
            //         var obj = JSON.parse(data);

            //     }
            // })

            $.ajax({
                url: link_base + "/ganttchart/update_modal/" + id,
                success(res) {
                    var data = JSON.parse(res);
                    // console.log(res);
                    // console.log(data.list['RKAP_SUBPRO_START']);
                    // console.log(data.list['RKAP_SUBPRO_END']);

                    var d = new Date(data.list['RKAP_SUBPRO_START']);
                    var day = ("0" + d.getDate()).slice(-2);
                    var month = ("0" + (d.getMonth() + 1)).slice(-2);
                    var year = d.getFullYear();
                    var start_date = day + "-" + month + "-" + year;

                    var e = new Date(data.list['RKAP_SUBPRO_END']);
                    var day2 = ("0" + e.getDate()).slice(-2);
                    var month2 = ("0" + (e.getMonth() + 1)).slice(-2);
                    var year2 = e.getFullYear();

                    var end_date = day2 + "-" + month2 + "-" + year2;

                    // alert(start_date)

                    // var s = new Date(data.list['RKAP_SUBPRO_START']);
                    // alert(s)
                    $('#u_tgl_end').val(end_date);
                    $('#u_subpro_title').val(data.list['RKAP_SUBPRO_TITTLE']);
                    $('#u_tgl_start').val(start_date);

                    ComponentsPickers.init();

                    //alert(data.list['RKAP_SUBPRO_START'])
                }
            })
        }
        function btn_delete_ganttchart(id) {
            document.getElementById("modaldelete").action = link_base + '/ganttchart/delete/' + id;
            // $.ajax({
            //     url: link_base+"/ganttchart/update_modal/" + id,
            //     success(res){

            //         $('#delete_title').text(data.list['RKAP_SUBPRO_TITTLE']);
            //     }
            // })

        }
        // `validation
        function date_validation() {

            var tanggal_mulai = $('#tgl_start').val();
            var tanggal_akhir = $('#tgl_end').val();

            var newdate_mulai = tanggal_mulai.split("-").reverse().join("-");
            var newdate_akhir = tanggal_akhir.split("-").reverse().join("-");

            // get mulai
            var _tglMulai = new Date(newdate_mulai);
            var getBlnMulai = _tglMulai.getMonth() + 1;
            var getThnMulai = _tglMulai.getFullYear();

            // get akhir
            var _tglAkhir = new Date(newdate_akhir);
            var getBlnAkhir = _tglAkhir.getMonth() + 1;
            var getThnAkhir = _tglAkhir.getFullYear();


            // if (getThnAkhir < getThnMulai) {
            //     alert('Tanggal Akhir tidak boleh kurang dari Tanggal Mulai')
            //     $("#tgl_end").val('');
            // }  else if (getBlnAkhir < getBlnMulai && getThnAkhir == getThnMulai) {
            //     alert('Tanggal Akhir tidak boleh kurang dari Tanggal Mulai')
            //     $("#tgl_end").val('');
            // }
        }
        function update_date_validation() {

            var tanggal_mulai = $('#u_tgl_start').val();
            var tanggal_akhir = $('#u_tgl_end').val();

            var newdate_mulai = tanggal_mulai.split("-").reverse().join("-");
            var newdate_akhir = tanggal_akhir.split("-").reverse().join("-");

            //tanggal start

            var c = new Date(newdate_mulai);
            var month_mulai = c.getMonth() + 1;
            var year_mulai = c.getFullYear();
            var tgl_mulai = month_mulai + '-' + year_mulai;


            //tanggal end

            var d = new Date(newdate_akhir);
            var month_akhir = d.getMonth() + 1;
            var year_akhir = d.getFullYear();
            var tgl_akhir = month_akhir + '-' + year_akhir;


            // if (tgl_akhir < tgl_mulai) {
            //     alert('Tanggal Akhir tidak boleh kurang dari Tanggal Mulai')
            //     $("#u_tgl_end").val('');
            // } 
        }
    </script>

</body>
<!-- END BODY -->
</html>