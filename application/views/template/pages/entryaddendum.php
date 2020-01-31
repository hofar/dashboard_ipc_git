<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link href="<?php echo base_url(); ?>assets/template/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<div class="page">
    <div class="page-content">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>rkapinvestasi">RKAP Investasi
                    
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>">Sub Program RKAP Investasi</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>addendum/view/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>">Addendum</a>
            </li>
            <li class="breadcrumb-item active">Form Addendum</li>
        </ol>

        <div class="headTab">
            <i class="icon md-laptop"></i> FORM TAMBAH ADDENDUM
        </div>

        <div class="panels">

           <div class="row">

              <div class="col-md-12 col-sm-12">
                <!-- BEGIN PORTLET-->
                <div class="portlet light">

                    <form  id="entryaddendum" class="form-horizontal" action="<?php echo ($act == 'add') ? base_url('addendum/add/' . $row_subprogram->RKAP_SUBPRO_ID . '') : base_url('addendum/update/' . $list->SUBPRO_ADD_ID . ''); ?>" method="post">
                        <input type="hidden" name="act" value="<?php echo $act ?>" id="act">
                        <input type="hidden" name="id" id="id" value="<?php echo ($act == 'add') ? $row_subprogram->RKAP_SUBPRO_ID : $list->RKAP_SUBPRO_ID ?>">
                        <input type="hidden" name="tgl_end_real" id="tgl_end_real" value="">
                         <input type="hidden" name="jangka_new" id="jangka_new" value="">
                         <input type="hidden" name="new_month_add" id="new_month_add" value="">
                         
                         <input type="hidden" name="max_month_last" id="max_month_last" value="<?php echo ($act == 'add') ? $max_subpro_years : $max_subpro_years ?>">
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
                        <div class="portlet-body">

                            <div class="col-md-12 col-sm-12">
                                <div class="form-group rows">
                                    <label class="control-label col-sm-3">Judul SUB Program</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? $row_subprogram->RKAP_SUBPRO_TITTLE : $list->RKAP_SUBPRO_TITTLE ?>" name="judul_sub_program" data-validation="required" data-validation-error-msg="Judul sub program harus diisi" id="judul_sub_program" disabled/>
                                    </div>
                                </div>
                                <div class="form-group rows">
                                    <label class="control-label col-sm-3">Jenis SUB Program</label>
                                    <div class="col-sm-6">
                                        <select name="jenis_sub_program" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih jenis sub program" id="jenis_sub_program" disabled="">
                                            <option value="">-- Pilih Jenis Sub Program --</option>

                                            <?php
                                            foreach ($groups as $row) {
                                                if ($act == 'add') {
                                                    if ($row_subprogram->RKAP_SUBPRO_TYPE_ID == $row->SUBPRO_TYPE_ID) {

                                                        echo '<option selected value="' . $row->SUBPRO_TYPE_ID . '">' . $row->SUBPRO_TYPE_NAME . '</option>';
                                                    } else {

                                                        echo '<option value="' . $row->SUBPRO_TYPE_ID . '">' . $row->SUBPRO_TYPE_NAME . '</option>';
                                                    }
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
                                <div class="form-group rows" >
                                    <label class="control-label col-sm-3">NO Kontrak</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? $row_subprogram->RKAP_SUBPRO_CONTRACT_NO : $list2->SUBPRO_ADD_NUM ?>" name="no_kontrak" data-validation="required" data-validation-error-msg="Nomor kontrak harus diisi" id="no_kontrak" />
                                    </div>
                                </div>
                                <!-- <div class="form-group rows" >
                                    <label class="control-label col-sm-3">Tanggal Kontrak</label>
                                    <div class="col-sm-6">
                                        <div class="form-group" style="margin: 0;">
                                            <div class='input-group'>
                                                <input type="hidden" name="date_contr_new" id="date_contr_new" value="<?php echo ($act == 'add') ? date("d-m-Y", strtotime($row_subprogram->RKAP_SUBPRO_CONTRACT_DATE_NEW)) : date("d-m-Y", strtotime($list2->SUBPRO_ADD_DATE_NEW)) ?>">
                                                <input type="text" class="form-control date-picker" value="<?php echo ($act == 'add') ? date("d-m-Y", strtotime($row_subprogram->RKAP_SUBPRO_CONTRACT_DATE_NEW)) : date("d-m-Y", strtotime($list2->SUBPRO_ADD_DATE_NEW)) ?>" data-date-format="dd-mm-yyyy" data-validation="required" name="tgl_kontrak_new" data-validation-error-msg="Tanggal kontrak harus diisi" id="tgl_kontrak_new"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group rows" >
                                    <label class="control-label col-sm-3">Tanggal Kontrak</label>
                                    <div class="col-sm-6">
                                        <div class="form-group" style="margin: 0;">
                                            <div class='input-group'>
                                                <input type="hidden" name="date_contr" id="date_contr" value="<?php echo ($act == 'add') ? date("d-m-Y", strtotime($row_subprogram->RKAP_SUBPRO_CONTRACT_DATE)) : date("d-m-Y", strtotime($row_subprogram->RKAP_SUBPRO_CONTRACT_DATE)) ?>">
                                                <input type="text" class="form-control date-picker" value="<?php echo ($act == 'add') ? date("d-m-Y", strtotime($row_subprogram->RKAP_SUBPRO_CONTRACT_DATE)) : date("d-m-Y", strtotime($list2->SUBPRO_ADD_DATE)) ?>" data-date-format="dd-mm-yyyy" data-validation="required" name="tgl_kontrak" data-validation-error-msg="Tanggal kontrak harus diisi" id="tgl_kontrak"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group rows" >
                                    <label class="control-label col-sm-3">Kebutuhan Dana</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                Rp
                                            </div>
                                            <input class="form-control" type="text" name="kebutuhan_dana" value="<?php echo ($act == 'add') ? number_format($row_rkap->RKAP_INVS_COST_REQ, 0, '', '.') : number_format($get_rkap->RKAP_INVS_COST_REQ, 0, '', '.') ?>" id="kebutuhan_dana" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group rows" >
                                    <label class="control-label col-sm-3">Nilai RKAP</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                Rp
                                            </div>
                                           
                                            <input class="form-control" type="text" name="nilai_rkap" value="<?php echo ($act == 'add') ? number_format($row_rkap->RKAP_INVS_VALUE, 0, '', '.') : number_format($get_rkap->RKAP_INVS_VALUE, 0, '', '.') ?>" id="nilai_rkap" disabled/>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if ($act == 'add'): ?>
                                    <div class="form-group rows" >
                                        <label class="control-label col-sm-3">Total Nilai Kontrak Sebelumnya</label>
                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    Rp
                                                </div>
                                                <input class="form-control" type="text" name="sum_kontrak" value="<?php echo ($act == 'add') ? number_format($kontrak_val_notselected, 0, '', '.') : number_format($kontrak_val_notselected, 0, '', '.') ?>" id="sum_kontrak" disabled> 

                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group rows" >
                                        <label class="control-label col-sm-3"> Total Nilai kontrak Sebelumnya</label>
                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    Rp
                                                </div>
                                                <input class="form-control" type="text" name="sum_kontrak_notselected" value="<?php echo ($act == 'add') ? number_format($kontrak_val_notselected_addendum, 0, '', '.') : number_format($kontrak_val_notselected_addendum, 0, '', '.') ?>" id="sum_kontrak_notselected" disabled> 

                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                                <!--  -->
                                <div class="form-group rows" >
                                    <label class="control-label col-sm-3">Nilai Realisasi yang telah ada</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                Rp
                                            </div>
                                           
                                            <input class="form-control" type="text" name="nilai_realisasi" value="<?php echo ($act == 'add') ? number_format($realisasi->REAL_SUBPRO_VAL, 0, '', '.') : number_format($realisasi->REAL_SUBPRO_VAL, 0, '', '.') ?>" id="nilai_realisasi" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form-group rows" >
                                    <label class="control-label col-sm-3">Nilai Kontrak sub program</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                Rp
                                            </div>
                                            <input class="form-control" type="text" name="nilai_kontrak_sub" value="<?php echo ($act == 'add') ? number_format($row_subprogram->RKAP_SUBPRO_CONTRACT_VALUE, 0, ',', '.') : number_format($list2->SUBPRO_ADD_VALUE, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="NIlai kontrak harus diisi" id="nilai_kontrak_sub" disabled/>
                                        </div>
                                    </div>
                                </div> -->
                                <!--  -->
                                <div class="form-group rows" >
                                    <label class="control-label col-sm-3">Nilai Kontrak</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                Rp
                                            </div>
                                            <input class="form-control" type="text" name="nilai_kontrak" value="<?php echo ($act == 'add') ? number_format($row_subprogram->RKAP_SUBPRO_CONTRACT_VALUE, 0, ',', '.') : number_format($list2->SUBPRO_ADD_VALUE, 0, ',', '.') ?>" data-validation="required" data-validation-error-msg="NIlai kontrak harus diisi" id="nilai_kontrak" onchange="check_contract()" />
                                            <!-- <input id="total_addendum" type="hidden" name=""> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group rows" >
                                    <label class="control-label col-sm-3">Jangka Waktu</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">

                                            <input class="form-control" type="number" value="<?php echo ($act == 'add') ? $row_subprogram->RKAP_SUBPRO_PERIODE : $list2->SUBPRO_ADD_PERIODE ?>" name="jangka_waktu" data-validation="required" data-validation-error-msg="Jangka waktu harus diisi" id="jangka_waktu<?php echo ($act == 'add') ? $row_subprogram->RKAP_SUBPRO_ID : $list2->RKAP_SUBPRO_ID ?>" min="0" />

                                            <div class="input-group-addon">
                                                Bulan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group rows" style="display: none;">
                                    <div class="col-sm-6">
                                        <div class="input-group" id="jangka_bulan">

                                        </div>
                                        <div class="input-group" id="div_jangka">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group rows" >
                                    <label class="control-label col-sm-3">Tanggal Berakhir Jaminan</label>
                                    <div class="col-sm-6">
                                        <div class="form-group" style="margin: 0;">
                                            <div class='input-group'>
                                                <input type="text" class="form-control date-picker" value="<?php echo ($act == 'add') ? date("d-m-Y", strtotime($row_subprogram->RKAP_SUBPRO_ENDOF_GUARANTEE)) : date("d-m-Y", strtotime($list2->SUBPRO_ADD_ENDOF_GUARANTEE)) ?>" data-date-format="dd-mm-yyyy" data-validation="required" name="tgl_berakhir_jaminan" data-validation-error-msg="Tanggal berakhir jaminan harus diisi" id="tgl_berakhir_jaminan"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group rows" >
                                    <label class="control-label col-sm-3">Realisasi s/d Tahun Sebelumnya</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                Rp
                                            </div>
                                            <input class="form-control" type="text" name="realisasi_sebelum" value="<?php echo ($act == 'add') ? number_format($row_subprogram->RKAP_SUBPRO_REAL_BEFORE, 0, '', '.') : number_format($list2->SUBPRO_ADD_REAL_BEFORE, 0, '', '.') ?>" data-validation="required" data-validation-error-msg="Realisasi harus diisi" id="realisasi_sebelum" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group rows">
                                    <label class="control-label col-sm-3">Kontraktor Pelaksana</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? $row_subprogram->RKAP_SUBPRO_CONTRACTOR : $list->RKAP_SUBPRO_CONTRACTOR ?>" name="kontraktor_pelaksana" data-validation="required" data-validation-error-msg="Kontraktor pelaksana harus diisi" id="kontraktor_pelaksana" disabled/>
                                    </div>
                                </div>
                                <div class="form-action pull-left" >
                                    <button type="submit" class="btn btn-success uppercase" id="button-add" onclick="cek_kontrak()"><div class="fa fa-plus"></div> Tambah</button>&nbsp;
                                    <button type="submit" class="btn btn-info uppercase" id="button-edit" onclick="cek_kontrak_notslected()"><div class="fa fa-pencil"></div> Ubah</button>&nbsp;
                                    <?php if ($act == 'add'): ?>
                                        <a href="<?php echo base_url(); ?>addendum/view/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-default uppercase" ><div class="fa fa-ban"></div> Batal</a>&nbsp;
                                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase addkesub" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>
                                    <?php else: ?>
                                        <a href="<?php echo base_url(); ?>addendum/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-default uppercase" ><div class="fa fa-ban"></div> Batal</a>&nbsp;
                                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase addkesub" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>
                                    <?php endif ?>

                                </div>
                            </div>
                           <!--  <div class="col-md-2 col-sm-2">

                            </div> -->
                        </div>
                        <div class="clearfix"></div>
                    </form>
                  </div>
                <!-- END PORTLET-->
               </div>
           </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Notification</h4>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin ingin menambahkan data ini ?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success uppercase"> Ya</button>&nbsp;
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
            </div>
        </div>

    </div>
</div>

<script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/table-advanced.js"></script>
<script src="<?php echo base_url(); ?>assets/form-validator/jquery.form-validator.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/components-pickers.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/select2-master/dist/js/select2.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/autocomplete/jquery.easy-autocomplete.min.js"></script>
<script type="text/javascript">
    function autoaddmonth() {
        
        var id = document.getElementById('id').value;
        //alert(id);

        if (id == null) {
            
            var bulan = document.getElementById('jangka_waktu').value;
        } else {
            
            var bulan = document.getElementById('jangka_waktu' + id).value;
        }

        //var bulan = $("#jangka_waktu").val();
        $bulan = parseInt(bulan);
        $("#jangka_bulan").html("");
        for (b = 1; b <= $bulan; b++) {
            $("#jangka_bulan").append('<input type="text" name="kurva_month[]" value="' + b + '"><br>');
        }

        var id = document.getElementById('id').value;

        if (id == null) {
            var jangka = document.getElementById('jangka_waktu').value;
        } else {
            var jangka = document.getElementById('jangka_waktu' + id).value;
        }


        // var jangka = document.getElementById('jangka_waktu' + id).value;
        var jarak = parseInt(jangka);

        var startdate = $('#tgl_kontrak').val();

        var newstartdate = startdate.split("-").reverse().join("-");
        // alert(newstartdate);
        var myDate = new Date(newstartdate);

        var result1 = myDate.addMonths(jarak);
        var datebaru = new Date(result1);
        var dateIndex = datebaru.getDate();
        var monthIndex = datebaru.getMonth() + 1;
        var yearIndex = datebaru.getFullYear();

        var lengkapset = dateIndex + '-' + monthIndex + '-' + yearIndex;

        // alert(lengkapset);

        document.getElementById('tgl_end_real').value = lengkapset;
    }

    function check_contract() {
        // var nilai_kontrak_sub = $('#nilai_kontrak_sub').val();
        // sub_format = nilai_kontrak_sub.replace(/\./g,'')
        // kontrak_sub = Number(sub_format)

        var nilai_addendum = $('#nilai_kontrak').val();
        addendum_format = nilai_addendum.replace(/\./g,'')
        addendum = Number(addendum_format)

        var nilai_realisasi = $('#nilai_realisasi').val();
        realisasi_format = nilai_realisasi.replace(/\./g,'')
        realisasi = Number(realisasi_format)

        console.log(addendum)
        console.log(realisasi)

        if (addendum < realisasi) {
            alert('Nilai kontrak tidak boleh kurang dari nilai realisasi yang telah ada')
            $("#nilai_kontrak").val('');
        }

        // var total = kontrak_sub + addendum;

        // $('#total_addendum').val(total);


    }
</script>


<script type="text/javascript">

    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('nilai_kontrak');
    tanpa_rupiah.addEventListener('keyup', function (e)
    {
        tanpa_rupiah.value = formatRupiah(this.value);
    });

    tanpa_rupiah.addEventListener('keydown', function (event)
    {
        limitCharacter(event);
    });

    var tanpa_rupiah2 = document.getElementById('realisasi_sebelum');
    tanpa_rupiah2.addEventListener('keyup', function (e)
    {
        tanpa_rupiah2.value = formatRupiah(this.value);
    });

    tanpa_rupiah2.addEventListener('keydown', function (event)
    {
        limitCharacter(event);
    });

    /* Fungsi */
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function limitCharacter(event)
    {
        key = event.which || event.keyCode;
        if (key != 188 // Comma
                && key != 8 // Backspace
                && key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
                && (key < 48 || key > 57) // Non digit
                // Dan masih banyak lagi seperti tombol del, panah kiri dan kanan, tombol tab, dll
                )
        {
            event.preventDefault();
            return false;
        }
    }

</script>

<script type="text/javascript">
    function cek_kontrak() {

        var contract_val = $("#nilai_kontrak").val();
        var contract_set = contract_val.replace(/\./g, '');
        var contract_set_dua = contract_set.replace(/\,/g, '.');
        var contract_str = contract_set_dua;

        var money_need = $("#kebutuhan_dana").val();
        var money_set = money_need.replace(/\./g, '');
        var money_set_dua = money_set.replace(/\,/g, '.');
        var money_str = money_set_dua;

        var contract_sum = $("#sum_kontrak").val();
        var contract_sum_set = contract_sum.replace(/\./g, '');
        var contract_sum_set_dua = contract_sum_set.replace(/\,/g, '.');
        var contract_sum_str = contract_sum_set_dua;


        var total_contract = parseFloat(contract_str) + parseFloat(contract_sum_str);


        if (total_contract <= money_str) {
            $("#nilai_kontrak").val(contract_val);
            $("#addsubprogramrkapinvestasi  #button-add").removeAttr('disabled');
        } else {
            alert('total nilai kontrak tidak boleh lebih dari kebutuhan dana');
            $("#nilai_kontrak").val('');
            $("#addsubprogramrkapinvestasi  #button-add").attr('disabled', 'disabled');
        }


        var id = document.getElementById('id').value;
        //alert(id);

        if (id == null) {
            
            var bulan = document.getElementById('jangka_waktu').value;
        } else {
            
            var bulan = document.getElementById('jangka_waktu' + id).value;
        }

        //var bulan = $("#jangka_waktu").val();
        $bulan = parseInt(bulan);
        $("#jangka_bulan").html("");
        for (b = 1; b <= $bulan; b++) {
            $("#jangka_bulan").append('<input type="text" name="kurva_month[]" value="' + b + '"><br>');
        }

        var id = document.getElementById('id').value;

        if (id == null) {
            var jangka = document.getElementById('jangka_waktu').value;
        } else {
            var jangka = document.getElementById('jangka_waktu' + id).value;
        }


        // var jangka = document.getElementById('jangka_waktu' + id).value;
        var jarak = parseInt(jangka);
        // alert(jarak);
        var contract_aw = $('#date_contr').val();
        
        var newcontract_aw = contract_aw.split("-").reverse().join("-");
        
        var myDateContract = new Date(newcontract_aw);
        var monthIndexContr = myDateContract.getMonth()+1;
        var yearIndexContr = myDateContract.getFullYear();
        // alert(monthIndexContr);
        var startdate = $('#tgl_kontrak').val();
       
        var newstartdate = startdate.split("-").reverse().join("-");
        // alert(newstartdate);
        var myDate = new Date(newstartdate);
        var dayIndexMyDate = myDate.getDate();
        var monthIndexMyDate = myDate.getMonth()+1;
        var yearsIndexMyDate = myDate.getFullYear();
        // alert(contract_aw);

        var selisih_jangkatahun = yearsIndexMyDate - yearIndexContr;
        if (selisih_jangkatahun == 0) {
            var selisih_jangkabulan = monthIndexMyDate - monthIndexContr;
        }
        else if(selisih_jangkatahun == 1){
             var selisih_jangkabulan = (monthIndexMyDate + 12) - monthIndexContr;
        }
        else if(selisih_jangkatahun == 2){
             var selisih_jangkabulan = (monthIndexMyDate + 24) - monthIndexContr;
        }
        else if(selisih_jangkatahun == 3){
             var selisih_jangkabulan = (monthIndexMyDate + 36) - monthIndexContr;
        }
       
        // alert(selisih_jangkabulan);

         var month_last = $('#max_month_last').val();
         var newMonthLastSplit = month_last.split("-").reverse().join("-");
          var newMonthLast = new Date(newMonthLastSplit);
            var dayMonthLast = newMonthLast.getDate();
            var MonthLast = newMonthLast.getMonth()+1;
            var yearMonthLast = newMonthLast.getFullYear();
       
        // var month_last_set = month_last.split("-").reverse().join("-");

         // alert(newMonthLastSplit); 
       
        function diff_months(date1, date2) 
         {

          var diff =(date2.getTime() - date1.getTime()) / 1000;
           diff /= (60 * 60 * 24 * 7 * 4);
          return Math.abs(Math.round(diff));
          
         }

         var date1 = new Date(newcontract_aw);
        var date2 = new Date(newstartdate);
        var month_pas = diff_months(date1, date2);

        var month_min_one = month_pas;

        // var jarak_monthLastContr = 
        
        var month_jarak =  monthIndexMyDate + jarak;

        if (month_jarak > 12) {
            var month_real = month_jarak - 13;
            if (month_real == 0) {
                var month_fix = 12;
            }else{
                var month_fix = month_real;
            }
        } else if(month_jarak > 24){
            var month_real = month_jarak - 25;
            if (month_real == 0) {
                var month_fix = 12;
            }else{
                var month_fix = month_real;
            }
        }else if(month_jarak > 36){
            month_real = month_jarak - 37;
            if (month_real == 0) {
                var month_fix = 12;
            }else{
                var month_fix = month_real;
            }
        }else if(month_jarak <= 12){
            var month_fix = month_jarak - 1;
        }
     
        myDate.setMonth(myDate.getMonth() - 1);
         // alert(month_pas);
        var result1 = myDate.addMonths(jarak);
          // alert(result1);
        var datebaru = new Date(result1);
        var dateIndex = 25;
        var monthIndex = month_fix;
        var yearIndex = datebaru.getFullYear();
        // alert(dateIndex);
        var lengkapset = dateIndex + '-' + monthIndex + '-' + yearIndex;
        var lengkapformat = lengkapset.split("-").reverse().join("-");
        // alert(month_last);
        // alert(lengkapformat);
        function diff_months_end(date3, date4) 
         {

          var diff_end =(date4.getTime() - date3.getTime()) / 1000;
           diff_end /= (60 * 60 * 24 * 7 * 4);
          return Math.abs(Math.round(diff_end));
          
         }

        var date3 = new Date(month_last);
        var date4 = new Date(lengkapformat);
        var month_pas_end = diff_months_end(date3, date4);
        var month_pas_end_one = month_pas_end - 1;

        var jarak_tot = jarak + selisih_jangkabulan;
        
        var selisih_month_end = yearIndex - yearMonthLast;

        if (selisih_month_end == 0) {
            var month_end_fix = monthIndex - MonthLast;
        }
        else if(selisih_month_end == 1){

            var month_end_fix = (monthIndex + 12) - MonthLast;
        }
        else if(selisih_month_end == 2){
             var month_end_fix = (monthIndex + 24) - MonthLast;
        }
        else if(selisih_month_end == 3){
             var month_end_fix = (monthIndex + 36) - MonthLast;
        }

         // alert(monthIndex);
         //  alert(MonthLast);
         // alert(month_end_fix);
          // alert(lengkapset);
        // alert(month_pas_end);
        document.getElementById('tgl_end_real').value = lengkapset;
        document.getElementById('jangka_new').value = jarak_tot;
        document.getElementById('new_month_add').value = month_end_fix;


    }


    //  function cek_kontrak_notslected() {

    //     var contract_val = $("#nilai_kontrak").val();
    //     var contract_set = contract_val.replace(/\./g, '');
    //     var contract_set_dua = contract_set.replace(/\,/g, '.');
    //     var contract_str = contract_set_dua;

    //     var money_need = $("#kebutuhan_dana").val();
    //     var money_set = money_need.replace(/\./g, '');
    //     var money_set_dua = money_set.replace(/\,/g, '.');
    //     var money_str = money_set_dua;

    //     var contract_sum = $("#sum_kontrak").val();
    //     var contract_sum_set = contract_sum.replace(/\./g, '');
    //     var contract_sum_set_dua = contract_sum_set.replace(/\,/g, '.');
    //     var contract_sum_str = contract_sum_set_dua;


    //     var total_contract = parseFloat(contract_str) + parseFloat(contract_sum_str);


    //     if (total_contract <= money_str) {
    //         $("#nilai_kontrak").val(contract_val);
    //         $("#addsubprogramrkapinvestasi  #button-add").removeAttr('disabled');
    //     } else {
    //         alert('total nilai kontrak tidak boleh lebih dari kebutuhan dana');
    //         $("#nilai_kontrak").val('');
    //         $("#addsubprogramrkapinvestasi  #button-add").attr('disabled', 'disabled');
    //     }


    //     var id = document.getElementById('id').value;
    //     //alert(id);

    //     if (id == null) {
            
    //         var bulan = document.getElementById('jangka_waktu').value;
    //     } else {
            
    //         var bulan = document.getElementById('jangka_waktu' + id).value;
    //     }

    //     //var bulan = $("#jangka_waktu").val();
    //     $bulan = parseInt(bulan);
    //     $("#jangka_bulan").html("");
    //     for (b = 1; b <= $bulan; b++) {
    //         $("#jangka_bulan").append('<input type="text" name="kurva_month[]" value="' + b + '"><br>');
    //     }

    //     var id = document.getElementById('id').value;

    //     if (id == null) {
    //         var jangka = document.getElementById('jangka_waktu').value;
    //     } else {
    //         var jangka = document.getElementById('jangka_waktu' + id).value;
    //     }


    //     // var jangka = document.getElementById('jangka_waktu' + id).value;
    //     var jarak = parseInt(jangka);
    //     // alert(jarak);
    //     var contract_aw = $('#date_contr').val();
        
    //     var newcontract_aw = contract_aw.split("-").reverse().join("-");
        
    //     var myDateContract = new Date(newcontract_aw);
    //     var monthIndexContr = myDateContract.getMonth()+1;
    //     var yearIndexContr = myDateContract.getFullYear();
    //     // alert(monthIndexContr);
    //     var startdate = $('#tgl_kontrak').val();
       
    //     var newstartdate = startdate.split("-").reverse().join("-");
    //     // alert(newstartdate);
    //     var myDate = new Date(newstartdate);
    //     var dayIndexMyDate = myDate.getDate();
    //     var monthIndexMyDate = myDate.getMonth()+1;
    //     var yearsIndexMyDate = myDate.getFullYear();
    //     // alert(contract_aw);

    //     var selisih_jangkatahun = yearsIndexMyDate - yearIndexContr;
    //     if (selisih_jangkatahun == 0) {
    //         var selisih_jangkabulan = monthIndexMyDate - monthIndexContr;
    //     }
    //     else if(selisih_jangkatahun == 1){
    //          var selisih_jangkabulan = (monthIndexMyDate + 12) - monthIndexContr;
    //     }
    //     else if(selisih_jangkatahun == 2){
    //          var selisih_jangkabulan = (monthIndexMyDate + 24) - monthIndexContr;
    //     }
    //     else if(selisih_jangkatahun == 3){
    //          var selisih_jangkabulan = (monthIndexMyDate + 36) - monthIndexContr;
    //     }
       
    //     // alert(selisih_jangkabulan);

    //      var month_last = $('#max_month_last').val();
    //      var newMonthLastSplit = month_last.split("-").reverse().join("-");
    //       var newMonthLast = new Date(newMonthLastSplit);
    //         var dayMonthLast = newMonthLast.getDate();
    //         var MonthLast = newMonthLast.getMonth()+1;
    //         var yearMonthLast = newMonthLast.getFullYear();
       
    //     // var month_last_set = month_last.split("-").reverse().join("-");

    //      // alert(newMonthLastSplit); 
       
    //     function diff_months(date1, date2) 
    //      {

    //       var diff =(date2.getTime() - date1.getTime()) / 1000;
    //        diff /= (60 * 60 * 24 * 7 * 4);
    //       return Math.abs(Math.round(diff));
          
    //      }

    //      var date1 = new Date(newcontract_aw);
    //     var date2 = new Date(newstartdate);
    //     var month_pas = diff_months(date1, date2);

    //     var month_min_one = month_pas;

    //     // var jarak_monthLastContr = 
        
    //     var month_jarak =  monthIndexMyDate + jarak;

    //     if (month_jarak > 12) {
    //         var month_real = month_jarak - 13;
    //         if (month_real == 0) {
    //             var month_fix = 12;
    //         }else{
    //             var month_fix = month_real;
    //         }
    //     } else if(month_jarak > 24){
    //         var month_real = month_jarak - 25;
    //         if (month_real == 0) {
    //             var month_fix = 12;
    //         }else{
    //             var month_fix = month_real;
    //         }
    //     }else if(month_jarak > 36){
    //         month_real = month_jarak - 37;
    //         if (month_real == 0) {
    //             var month_fix = 12;
    //         }else{
    //             var month_fix = month_real;
    //         }
    //     }else if(month_jarak <= 12){
    //         var month_fix = month_jarak - 1;
    //     }
     
    //     myDate.setMonth(myDate.getMonth() - 1);
    //      // alert(month_pas);
    //     var result1 = myDate.addMonths(jarak);
    //       // alert(result1);
    //     var datebaru = new Date(result1);
    //     var dateIndex = 25;
    //     var monthIndex = month_fix;
    //     var yearIndex = datebaru.getFullYear();
    //     // alert(dateIndex);
    //     var lengkapset = dateIndex + '-' + monthIndex + '-' + yearIndex;
    //     var lengkapformat = lengkapset.split("-").reverse().join("-");
    //     // alert(month_last);
    //     // alert(lengkapformat);
    //     function diff_months_end(date3, date4) 
    //      {

    //       var diff_end =(date4.getTime() - date3.getTime()) / 1000;
    //        diff_end /= (60 * 60 * 24 * 7 * 4);
    //       return Math.abs(Math.round(diff_end));
          
    //      }

    //     var date3 = new Date(month_last);
    //     var date4 = new Date(lengkapformat);
    //     var month_pas_end = diff_months_end(date3, date4);
    //     var month_pas_end_one = month_pas_end - 1;

    //     var jarak_tot = jarak + selisih_jangkabulan;
        
    //     var selisih_month_end = yearIndex - yearMonthLast;

    //     if (selisih_month_end == 0) {
    //         var month_end_fix = monthIndex - MonthLast;
    //     }
    //     else if(selisih_month_end == 1){

    //         var month_end_fix = (monthIndex + 12) - MonthLast;
    //     }
    //     else if(selisih_month_end == 2){
    //          var month_end_fix = (monthIndex + 24) - MonthLast;
    //     }
    //     else if(selisih_month_end == 3){
    //          var month_end_fix = (monthIndex + 36) - MonthLast;
    //     }

    //      // alert(monthIndex);
    //      //  alert(MonthLast);
    //      // alert(month_end_fix);
    //       // alert(lengkapset);
    //     // alert(month_pas_end);
    //     document.getElementById('tgl_end_real').value = lengkapset;
    //     document.getElementById('jangka_new').value = jarak_tot;
    //     document.getElementById('new_month_add').value = month_end_fix;


    // }

    function cek_kontrak_notslected() {

        var contract_val = $("#nilai_kontrak").val();
        var contract_set = contract_val.replace(/\./g, '');
        var contract_set_dua = contract_set.replace(/\,/g, '.');
        var contract_str = contract_set_dua;

        var money_need = $("#kebutuhan_dana").val();
        var money_set = money_need.replace(/\./g, '');
        var money_set_dua = money_set.replace(/\,/g, '.');
        var money_str = money_set_dua;

        var contract_sum_notselected = $("#sum_kontrak_notselected").val();
        var contract_sum_notselected_set = contract_sum_notselected.replace(/\./g, '');
        var contract_sum_notselected_set_dua = contract_sum_notselected_set.replace(/\,/g, '.');
        var contract_sum_notselected_str = contract_sum_notselected_set_dua;

        var total_contract_notselected = parseFloat(contract_str) + parseFloat(contract_sum_notselected_str);
        //alert(total_contract_notselected);

        if (total_contract_notselected <= money_str) {
            $("#nilai_kontrak").val(contract_val);
            // $("#addsubprogramrkapinvestasi  #button-edit").removeAttr('disabled');
        } else {
            $("#nilai_kontrak").val('');
            alert('total nilai kontrak tidak boleh lebih dari nilai Kebutuhan dana');
            // $("#addsubprogramrkapinvestasi  #button-edit").attr('disabled', 'disabled');
        }

        var id = document.getElementById('id').value;
        //alert(id);

        if (id == null) {
            
            var bulan = document.getElementById('jangka_waktu').value;
        } else {
            
            var bulan = document.getElementById('jangka_waktu' + id).value;
        }

        //var bulan = $("#jangka_waktu").val();
        $bulan = parseInt(bulan);
        $("#jangka_bulan").html("");
        for (b = 1; b <= $bulan; b++) {
            $("#jangka_bulan").append('<input type="text" name="kurva_month[]" value="' + b + '"><br>');
        }

        var id = document.getElementById('id').value;

        if (id == null) {
            var jangka = document.getElementById('jangka_waktu').value;
        } else {
            var jangka = document.getElementById('jangka_waktu' + id).value;
        }


        // var jangka = document.getElementById('jangka_waktu' + id).value;
        var jarak = parseInt(jangka);
        // alert(jarak);
        var contract_aw = $('#date_contr').val();
        var newcontract_aw = contract_aw.split("-").reverse().join("-");
        // alert(newcontract_aw);
        
        var myDateContract = new Date(newcontract_aw);
        var monthIndexContr = myDateContract.getMonth()+1;
        var yearIndexContr = myDateContract.getFullYear();
        // alert(monthIndexContr);
        var startdate = $('#tgl_kontrak').val();
       
        var newstartdate = startdate.split("-").reverse().join("-");
        // alert(newstartdate);
        var myDate = new Date(newstartdate);
        var dayIndexMyDate = myDate.getDate();
        var monthIndexMyDate = myDate.getMonth()+1;
        var yearsIndexMyDate = myDate.getFullYear();
        // alert(contract_aw);

        var selisih_jangkatahun = yearsIndexMyDate - yearIndexContr;
        // alert(selisih_jangkatahun);
        if (selisih_jangkatahun == 0) {
            var selisih_jangkabulan = monthIndexMyDate - monthIndexContr;
        }
        else if(selisih_jangkatahun == 1){
             var selisih_jangkabulan = (monthIndexMyDate + 12) - monthIndexContr;
        }
        else if(selisih_jangkatahun == 2){
             var selisih_jangkabulan = (monthIndexMyDate + 24) - monthIndexContr;
        }
        else if(selisih_jangkatahun == 3){
             var selisih_jangkabulan = (monthIndexMyDate + 36) - monthIndexContr;
        }
       
        // alert(selisih_jangkabulan);

         var month_last = $('#max_month_last').val();
         // alert(month_last);
         var newMonthLastSplit = month_last.split("-").reverse().join("-");
          var newMonthLast = new Date(newMonthLastSplit);
            var dayMonthLast = newMonthLast.getDate();
            var MonthLast = newMonthLast.getMonth();
            var yearMonthLast = newMonthLast.getFullYear();
       
        // var month_last_set = month_last.split("-").reverse().join("-");

         // alert(month_last); 
       
        function diff_months(date1, date2) 
         {

          var diff =(date2.getTime() - date1.getTime()) / 1000;
           diff /= (60 * 60 * 24 * 7 * 4);
          return Math.abs(Math.round(diff));
          
         }

         var date1 = new Date(newcontract_aw);
        var date2 = new Date(newstartdate);
        var month_pas = diff_months(date1, date2);

        var month_min_one = month_pas;

        // var jarak_monthLastContr = 
        
        var month_jarak =  monthIndexMyDate + jarak;

        if (month_jarak > 12) {
            var month_real = month_jarak - 13;
            if (month_real == 0) {
                var month_fix = 12;
            }else{
                var month_fix = month_real;
            }
        } else if(month_jarak > 24){
            var month_real = month_jarak - 25;
            if (month_real == 0) {
                var month_fix = 12;
            }else{
                var month_fix = month_real;
            }
        }else if(month_jarak > 36){
            month_real = month_jarak - 37;
            if (month_real == 0) {
                var month_fix = 12;
            }else{
                var month_fix = month_real;
            }
        }else if(month_jarak <= 12){
            var month_fix = month_jarak - 1;
        }
     
        myDate.setMonth(myDate.getMonth() - 1);
         // alert(month_pas);
        var result1 = myDate.addMonths(jarak);
          // alert(result1);
        var datebaru = new Date(result1);
        var dateIndex = 25;
        var monthIndex = month_fix;
        var yearIndex = datebaru.getFullYear();
        // alert(monthIndex);
        var lengkapset = dateIndex + '-' + monthIndex + '-' + yearIndex;
        var lengkapformat = lengkapset.split("-").reverse().join("-");
        // alert(month_last);
        // alert(lengkapformat);
        function diff_months_end(date3, date4) 
         {

          var diff_end =(date4.getTime() - date3.getTime()) / 1000;
           diff_end /= (60 * 60 * 24 * 7 * 4);
          return Math.abs(Math.round(diff_end));
          
         }

        var date3 = new Date(month_last);
        var date4 = new Date(lengkapformat);
        var month_pas_end = diff_months_end(date3, date4);
        var month_pas_end_one = month_pas_end - 1;

        var jarak_tot = jarak + selisih_jangkabulan;
        // alert(jarak_tot);
        var selisih_month_end = yearIndex - yearMonthLast;

        if (selisih_month_end == 0) {
            var month_end_fix = monthIndex - MonthLast;
        }
        else if(selisih_month_end == 1){

            var month_end_fix = (monthIndex + 12) - MonthLast;
        }
        else if(selisih_month_end == 2){
             var month_end_fix = (monthIndex + 24) - MonthLast;
        }
        else if(selisih_month_end == 3){
             var month_end_fix = (monthIndex + 36) - MonthLast;
        }

         // alert(monthIndex);
         //  alert(MonthLast);
         // alert(month_end_fix);
          // alert(lengkapset);
        // alert(month_pas_end);
        document.getElementById('tgl_end_real').value = lengkapset;
        document.getElementById('jangka_new').value = jarak_tot;
        document.getElementById('new_month_add').value = month_end_fix;


    }
</script>

<script type="text/javascript">

    function check_investasi()
    {
        var period = $('#jangka_waktu').val();
        var Invest = $('#jenis_investasi').val();

        // alert(period);

        if (period > 12) {
            $('#jenis_investasi').val("3");
            $('#input_invest').val("3");
        } else {
            $('#jenis_investasi').val("1");
            $('#input_invest').val("1");
        }

    }
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/components-pickers.js"></script>

<script>
    $.validate({
        modules: 'security'
    });
</script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function () {

        ComponentsPickers.init();

    });
</script>

<script type="text/javascript">
//    function autodate() {
//    
//
//    var id = document.getElementById('id').value;
//
//        if (id == null) {
//            var jangka = document.getElementById('jangka_waktu').value;
//        } else {
//            var jangka = document.getElementById('jangka_waktu' + id).value;
//        }
//
//
//        // var jangka = document.getElementById('jangka_waktu' + id).value;
//        var jarak = parseInt(jangka);
//
//        var startdate = $('#tgl_kontrak').val();
//
//        var newstartdate = startdate.split("-").reverse().join("-");
//        // alert(newstartdate);
//        var myDate = new Date(newstartdate);
//
//        var result1 = myDate.addMonths(jarak);
//        var datebaru = new Date(result1);
//        var dateIndex = datebaru.getDate();
//        var monthIndex = datebaru.getMonth() + 1;
//        var yearIndex = datebaru.getFullYear();
//
//        var lengkapset = dateIndex + '-' + monthIndex + '-' + yearIndex;
//
//        // alert(lengkapset);
//
//        document.getElementById('tgl_end_real').value = lengkapset;
//        }
    Date.isLeapYear = function (year) {
        return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
    };

    Date.getDaysInMonth = function (year, month) {
        return [31, (Date.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
    };

    Date.prototype.isLeapYear = function () {
        return Date.isLeapYear(this.getFullYear());
    };

    Date.prototype.getDaysInMonth = function () {
        return Date.getDaysInMonth(this.getFullYear(), this.getMonth());
    };

    Date.prototype.addMonths = function (value) {
        var n = this.getDate();
        this.setDate(1);
        this.setMonth(this.getMonth() + value);
        this.setDate(Math.min(n, this.getDaysInMonth()));
        return this;
    };
</script>