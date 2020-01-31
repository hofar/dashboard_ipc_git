<style type="text/css">
    table, td {
        border: 2px solid white !important;
        border-collapse: collapse;
        color:#000;
        font-size: 14px !important;
    }

    .panelCustom{
        width:100%; background-color:#FFF;box-shadow:rgba(204,204,204,0.60) 0px; 
        padding:15px 25px 10px 25px
    }

    .tdTitle{
        color:#6D6D6D;
    }


</style>
<div class="page">
    <div class="page-content">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <i class="icon-fire"></i>
                <a class="icon-fire" href="<?php echo base_url(); ?>rkapinvestasi">RKAP Investasi</a>
            </li>
            <li class="breadcrumb-item">
                <i class="icon-fire"></i>
                <a class="icon-fire" href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>">Sub Program RKAP Investasi</a>
            </li>
            <li class="breadcrumb-item">
                <i class="icon-fire"></i>
                <a class="icon-fire" href="<?php echo base_url(); ?>kurva/add/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>">Kurva S</a>
            </li>
            <li class="breadcrumb-item active">Form Kurva S Sub Program</li>
        </ol>
        <div class="headTab">
            <i class="icon-fire"></i>KURVA S SUB PROGRAM
        </div>
        <div class="panels">
            <div class="row">

                <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">
                        <form  id="addkurvas" class="form-horizontal" action="<?php echo base_url('kurva/added/' . $row_subprogram->RKAP_SUBPRO_ID . ''); ?>" method="post">
                            <fieldset style="border: 1px solid #e5e5e5; border-radius: 3px; color: #666666; margin-bottom: 20px;">
                                <legend style="font-size: 12px; border-radius: 3px; border: 1px solid #e5e5e5; padding: 3px 8px; margin: 10px 0 0 7px; width: auto; color: #666666;">Kurva S</legend>
                                <div class="kurva col-sm-12 panelCustom">
                                    <div class="the_kurva text-center">
                                        <div id="curve_chart"></div>
                                        <h4><b>Garis vertikal = Persentase , Garis horizontal = Bulan ke </b></h4>
                                        <canvas id="speedChart" style="height: 400px !important;"></canvas>
                                    </div>
                                    <?php if ($realisasi == null || $rencana == null): ?>

                                    <?php else: ?>
                                        <div class="col-sm-9"></div>
                                        <div class="col-sm-3 deviasi">
                                            <div class="main_deviasi" style="text-align: right; border: 1px solid #CCC; padding: 5px; border-radius: 5px;">
                                                <div class="headdev" style="text-align: center; border-bottom: 1px solid #CCC; margin-bottom: 10px; padding: 2px 5px 5px 5px;">
                                                    Deviasi
                                                </div>
                                                <div class="contdev">
                                                    <table style="width: 100%;">

                                                        <tr>
                                                            <td style="padding: 5px 10px;">Realisasi</td>
                                                            <td>
                                                                <input type="text" style="width: 100%;  margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="<?php echo $deviasi_realisasi; ?> %">
                                                            </td>
                                                        </tr>
                                                        <tr style="width: 100%;">
                                                            <td style="padding: 5px 10px;">Perencanaan</td>
                                                            <td>
                                                                <input style="width: 100%;  margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" type="text" value="<?php echo $deviasi_rencana; ?> %">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 5px 10px;">Deviasi</td>
                                                            <td>
                                                                <input type="text" style="width: 100%;  margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="<?php echo $deviasi_total; ?> %">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 5px 10px;">Indikator</td>
                                                            <?php if ($warna == 1): ?>
                                                                <td>
                                                                    <input type="text" style="width: 100%; background-color: #a8fd13; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="">
                                                                </td>
                                                            <?php elseif ($warna == 2): ?>
                                                                <td>
                                                                    <input type="text" style="width: 100%; background-color: #f6d71d; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="">
                                                                </td> 
                                                            <?php elseif ($warna == 3): ?>
                                                                <td>
                                                                    <input type="text" style="width: 100%; background-color: #e73002; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="">
                                                                </td>
                                                            <?php elseif ($warna == 4): ?>
                                                                <td>
                                                                    <input type="text" style="width: 100%; background-color: #a8fd13; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="">
                                                                </td>
                                                            <?php elseif ($warna == 5): ?>
                                                                <td>
                                                                    <input type="text" style="width: 100%; background-color: #f6d71d; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="">
                                                                </td>
                                                            <?php elseif ($warna == 6): ?>
                                                                <td>
                                                                    <input type="text" style="width: 100%;  background-color: #e73002;  margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="">
                                                                </td>
                                                            <?php endif ?>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="kurva col-sm-12">
                                    <div class="the_kurva text-center">

                                        <input type="hidden" name="act" value="" id="act">
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
                                        <?php if ($this->session->flashdata('success')): ?>
                                            <div class="alert alert-success">
                                                <button class="close" data-close="alert"></button>
                                                <span>
                                                    <?php echo $this->session->flashdata('success'); ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="portlet-body">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group rows">
                                                    <label class="tit-lbl control-label col-sm-3">Judul Sub Program</label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? $row_subprogram->RKAP_SUBPRO_TITTLE : $list->RKAP_SUBPRO_TITTLE ?>" name="judul_sub_program" data-validation="required" data-validation-error-msg="Judul sub program harus diisi" id="judul_sub_program" disabled/>
                                                    </div>
                                                </div>
                                                <div class="form-group rows" >
                                                    <label class="tit-lbl control-label col-sm-3">Jangka Waktu</label>
                                                    <div class="col-sm-3">
                                                        <div class="form-group" style="margin: 0;">
                                                            <div class='input-group date' id='datetimepicker1'>
                                                                <input class="form-control" type="number" value="<?php echo ($act == 'add') ? $row_subprogram->RKAP_SUBPRO_PERIODE : $list->RKAP_SUBPRO_PERIODE ?>" name="jangka_waktu" data-validation="required" data-validation-error-msg="Jangka waktu harus diisi" id="jangka_waktu" readonly/>
                                                                <div class="input-group-addon">
                                                                    Bulan
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group rows" >
                                                    <!-- <div class="col-sm-12"> -->
                                                    <!-- <div class="leftstart col-sm-6 rows"> -->
                                                    <label class="ctr-lbl col-sm-3">Start Date</label>
                                                    <div class="inputan col-sm-3">
                                                        <div class="form-group" style="margin: 0;">
                                                            <div class='input-group'>
                                                                <input type="text" class="form-control date-picker" value="<?php echo ($act == 'add') ? $row_subprogram->RKAP_SUBPRO_CONTRACT_DATE : $list->RKAP_SUBPRO_CONTRACT_DATE ?>" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="tgl_start" data-validation="required" data-validation-error-msg="Tanggal awal harus diisi" id="tgl_start" disabled/>
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--   </div>
                                                      <div class="rightend col-sm-6 rows"> -->
                                                    <label class=" ctr-lbl col-sm-3">End Date</label>
                                                    <div class="inputan col-sm-3">
                                                        <div class="form-group" style="margin: 0;">
                                                            <div class='input-group'>
                                                                <input type="text" class="form-control date-picker" value="<?php echo ($act == 'add') ? $row_subprogram->RKAP_SUBPRO_END_REAL : $list->RKAP_SUBPRO_END_REAL ?>"  data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="tgl_end" data-validation="required" data-validation-error-msg="Tanggal berakhir harus diisi" id="tgl_end" disabled/>
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- </div> -->
                                                    <!-- </div> -->
                                                </div>
                                                <div class="form-group rows" >
                                                    <label class="tit-lbl control-label col-sm-3">Nilai Kontrak</label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                Rp
                                                            </div>
                                                            <input class="form-control" type="text" name="nilai_kontrak" value="<?php echo ($act == 'add') ? number_format($row_subprogram->RKAP_SUBPRO_CONTRACT_VALUE, 0, '', '.') : number_format($list->RKAP_SUBPRO_CONTRACT_VALUE, 0, '', '.') ?>" data-validation="required" data-validation-error-msg="NIlai kontrak harus diisi" id="nilai_kontrak" disabled/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                            </fieldset>
                            <fieldset style="border: 1px solid #e5e5e5; border-radius: 3px; margin-bottom: 20px; color: #666666;">
                                <legend style="font-size: 12px; border-radius: 3px; border: 1px solid #e5e5e5; padding: 3px 8px; margin: 10px 0 0 7px; width: auto; color: #666666;">Bulan</legend>
                                <div  style="overflow: scroll;">

                                    <?php if ($resutl_all_month == NULL) { ?>
                                        <div class = "text-center">
                                            <?php $bulan = $row_subprogram->RKAP_SUBPRO_PERIODE;
                                            ?>

                                            <table>
                                                <tr>
                                                    <?php foreach ($kurvas_month as $m): ?>
                                                        <td>
                                                            <input type="hidden" name="kurva_month[]" value="<?php echo $m ?>" class="form-control">
                                                        </td>
                                                    <?php endforeach ?>
                                                </tr>
                                            </table>
                                            <table>
                                                <!-- <tr> -->
                                                <?php foreach ($kurvas_year as $y): ?>
                                                    <td>
                                                        <input type="hidden" name="kurva_years[]" value="<?php echo $y ?>" class="form-control">
                                                    </td>
                                                <?php endforeach ?>
                                                <!-- </tr> -->
                                            </table>
                                            <table>
                                                <tr>
                                                    <?php
                                                    $no = 0;
                                                    for ($i = 0; $i < $bulan; $i++) {
                                                        $no++;
                                                        ?>

                                                        <td class="col-sm-1" style="margin:3px !important; width:100px !important; padding-right: 1px !important; padding-left: 3px !important;">
                                                            <label>Bulan ke-<?php echo $no; ?></label>
                                                            <div class="input-group" style="margin-bottom: 5px;">

                                                                <?php if ($act == 'add'): ?>
                                                                    <input class="form-control" type="text" name="kurva_value[]" value="<?php echo ($row_subprogram_monthly == null) ? '' : $result_month[$i]->SUBPRO_VALUE ?>" id="jumlah_persen" />
                                                                <?php elseif ($act == 'edit'): ?>
                                                                    <input class="form-control" type="text" name="kurva_value[]" value="<?php echo ($list2->SUBPRO_VALUE == null) ? '' : $list2->SUBPRO_VALUE ?>" id="jumlah_persen" />
                                                                <?php endif ?>
                                                                <div class="input-group-addon">
                                                                    %
                                                                </div>
                                                            </div>
                                                        </td>
                                                    <?php } ?>
                                                </tr> 
                                            </table>
                                        </div>
                                    <?php } else { ?> 
                                        <div class="text-center">
                                            <table>
                                                <tr>
                                                    <?php foreach ($kurvas_month as $m): ?>
                                                        <td>
                                                            <input type="hidden" name="kurva_month[]" value="<?php echo $m ?>" class="form-control">
                                                        </td>
                                                    <?php endforeach ?>
                                                </tr>
                                            </table>
                                            <table>
                                                <!-- <tr> -->
                                                <?php foreach ($kurvas_year as $y): ?>
                                                    <td>
                                                        <input type="hidden" name="kurva_years[]" value="<?php echo $y ?>" class="form-control">
                                                    </td>
                                                <?php endforeach ?>
                                                <!-- </tr> -->
                                            </table>

                                            <table>
                                                <?php
                                                for ($j = 0; $j < $resutl_all_month_non_adden_group; $j++) {
                                                    ?>
                                                    <tr>
                                                        <td class="" style="margin: 3px !important; width:120px !important; padding-right: 1px !important; padding-left: 1px !important;">
                                                            <?php
                                                            if ($j == 0) {
                                                                echo '<label class="" style="width:120;">Kontrak Utama :</label>';
                                                            } else {
                                                                echo '<label class="">Addendum Ke ' . $j . ':</label>';
                                                            }
                                                            ?>
                                                        </td>

                                                        <!-- <div class="row"> -->
                                                        <?php
                                                        foreach ($Adden[$j] as $key => $value) {
                                                            ?>
                                                            <?php if ($Adden[$j][$key]->SUBPRO_MON == NULL): ?>
                                                                <td class="col-sm-1" style="margin: 3px !important; width:100px !important; padding-right: 1px !important; padding-left: 1px !important;">

                                                                </td>
                                                            <?php else: ?>
                                                                <td class="col-sm-1" style="margin: 3px !important; width:100px !important; padding-right: 1px !important; padding-left: 3px !important;">
                                                                    <div class="input-group" style="margin-bottom: 5px;">                                    
                                                                        <input type="hidden" name="SUBPRO_MON[]" value="<?php echo $Adden[$j][$key]->SUBPRO_MON; ?>" class="form-control" style="width: 70;">
                                                                        <?php if ($act == 'add'): ?>
                                                                            <input class="form-control" type="text" name="kurva_value[]" value="<?php echo number_format($Adden[$j][$key]->VAL, 2, ',', '.') ?>" id="<?php echo $Adden[$j][$key]->SUBPRO_MON; ?>" class="jumlah_persen" style="width: 70px;"/>
                                                                        <?php elseif ($act == 'edit'): ?>
                                                                            <input class="form-control" type="text" name="kurva_value[]" value="<?php echo ($Adden[$j][$key]->VAL == null) ? '' : number_format($Adden[$j][$key]->VAL, 2, ',', '.') ?>" id="<?php echo $Adden[$j][$key]->SUBPRO_MON; ?>" class="jumlah_persen" style="width: 70px;" />
                                                                        <?php endif ?>
                                                                        <div class="input-group-addon">
                                                                            %
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            <?php endif ?>

                                                        <?php } ?> 
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </fieldset>
                            <div class="">
                                <?php if ($row_subprogram->IS_GANTTCHART == 0): ?>
                                    <button type="submit" class="btn btn-success uppercase" id="button-add" disabled><div class="fa fa-save"></div> Simpan</button>
                                    &nbsp;
                                    <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-default uppercase" ><div class="fa fa-ban"></div> Batal</a>
                                    <small><p style="color:#f04014"> * harap input start date dan end date di ganttchart</p></small>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-success uppercase" id="button-add"><div class="fa fa-plus"></div> Simpan</button>
                                    &nbsp;
                                    <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-default uppercase" ><div class="fa fa-ban"></div> Batal</a>
                                <?php endif ?>

                            </div>
                        </form>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
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

<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner">
        2017 &copy; Indonesia Port Corporation.
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/excanvas.min.js"></script> 
<![endif]-->
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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    $.validate({
    modules: 'security'
    });</script>

<script>
    $(document).ready(function () {
    $('#table').DataTable({
    searching: false,
            lengthChange: false,
            bSort: false,
            // target: 'no-sort',
    });
    });
    jQuery(document).ready(function () {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Demo.init(); // init demo features 
    ComponentsPickers.init();
    Index.init(); // init index page
    Tasks.initDashboardWidget(); // init tash dashboard widget  
    TableAdvanced.init();
    });</script>

<script type="text/javascript">
    var act = $('#act').val();
    // alert(act);

    if (act == 'detail') {
<?php
/* Mengambil query report */
// foreach ($value as $result) {
// //    $title[] = $result->RKAP_SUBPRO_TITTLE; //ambil bulan
//     $persen[] = (float) $result->SUBPRO_VALUE; //ambil nilai
// }
/* end mengambil query */
?>
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
    $("#entryrisiko  #button-edit").hide();
    $("#entryrisiko  #button-add").hide();
    // $("#addrealisasi  #button-monitoring").attr('disabled', 'disabled');
    } else if (act == 'add') {
    $("#addrkapinvestasi  #button-edit").hide();
    $("#addrkapinvestasi  #button-list").attr('disabled', 'disabled');
    $("#addrkapinvestasi  #button-tambah-subadd").attr('disabled', 'disabled');
    $("#addrkapinvestasi  #button-gantt-chart").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-kurva").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-entry-risiko").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-view-addendum").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-entry-addendum").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-view-realisasi").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-entry-realisasi").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-edit").hide();
    $("#entryaddendum  #button-edit").hide();
    $("#addrealisasi  #button-edit").hide();
    $("#addrealisasi  #button-monitoring").attr('disabled', 'disabled');
    $("#entryrisiko  #button-edit").hide();
    } else if (act == 'edit') {
<?php
/* Mengambil query report */
// foreach ($value as $result) {
// //    $title[] = $result->RKAP_SUBPRO_TITTLE; //ambil bulan
//     $persen[] = (float) $result->SUBPRO_VALUE; //ambil nilai
// }
/* end mengambil query */
?>
    $("#addrkapinvestasi  #button-add").hide();
    $("#addrkapinvestasi  #button-list").attr('disabled', 'disabled');
    $("#addrkapinvestasi  #button-tambah-subedit").attr('disabled', 'disabled');
    $("#addrkapinvestasi  #button-gantt-chart").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-back").hide();
    $("#addsubprogramrkapinvestasi  #button-kurva").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-entry-risiko").attr('disabled', 'disabled');
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
    $("#entryrisiko  #button-add").hide();
    }


</script>



<script type="text/javascript">
    var speedCanvas = document.getElementById("speedChart");
    Chart.defaults.global.defaultFontFamily = "Calibri";
    Chart.defaults.global.defaultFontSize = 13;
    var dataFirst = {
    label: "Perencanaan",
            data: [0,
<?php foreach ($resutl_all_month_non_adden as $rowdata): ?>
    <?= $rowdata->SUBPRO_VALUE ?>,
<?php endforeach; ?>
            ],
            lineTension: 0.5,
            fill: false,
            borderColor: 'blue',
            backgroundColor: 'transparent',
            pointBorderColor: '#000',
            pointBackgroundColor: '#fff',
            pointRadius: 2,
            pointHoverRadius: 5,
            pointHitRadius: 30,
            pointBorderWidth: 1,
            pointStyle: 'rect'
    };
<?php
//$ary = array('Add1','Add2','Add3','Add4','Add5');

$warnak = array("", '#FF9800', '#FF5722', '#5D4037', '#00796B', '#E91E63', '#7B1FA2', '#512DA8', '#FF9800', '#FF5722', '#5D4037', '#00796B', '#E91E63', '#7B1FA2', '#512DA8', '#FF9800', '#FF5722', '#5D4037', '#00796B', '#E91E63', '#7B1FA2', '#512DA8');
for ($i = 1; $i < $jmladdn; $i++) {
    ?>
        var <?php echo $Adden2[$i]; ?> = {
        label: "<?php echo $Adden2[$i]; ?>",
                data: [0,
    <?php foreach ($Adden[$i] as $rowdata): ?>
        <?= $rowdata->VAL ?>,
    <?php endforeach; ?>
                ],
                lineTension: 0.5,
                fill: false,
                borderColor: '<?php echo $warnak[$i]; ?>',
                backgroundColor: 'transparent',
                pointBorderColor: '#000',
                pointBackgroundColor: '#fff',
                pointRadius: 2,
                pointHoverRadius: 5,
                pointHitRadius: 30,
                pointBorderWidth: 1,
                pointStyle: 'rect'
        };
    <?php
}
?>


// var dataThird = {
//     label: "Addendum",
//             data: [
// <?php foreach ($resutl_all_month_adden as $rowdata): ?>
        //     <?= $rowdata->SUBPRO_VALUE ?>,
        // <?php endforeach; ?>
//             ],
//             lineTension: 0.5,
//             fill: false,
//             borderColor: 'red',
//             backgroundColor: 'transparent',
//             pointBorderColor: '#000',
//             pointBackgroundColor: '#fff',
//             pointRadius: 2,
//             pointHoverRadius: 5,
//             pointHitRadius: 30,
//             pointBorderWidth: 1,
//             pointStyle: 'rect'
//     };


    var dataSecond = {
    label: "Realisasi",
            data: [0,
<?php foreach ($kurvarealisasi as $rowdata): ?>
    <?= $rowdata->VAL ?>,
<?php endforeach; ?>
            ],
            lineTension: 0.5,
            fill: false,
            borderColor: '#ff0606',
            backgroundColor: 'transparent',
            pointBorderColor: '#ffffff',
            pointBackgroundColor: 'lightgreen',
            pointRadius: 2,
            pointHoverRadius: 5,
            pointHitRadius: 30,
            pointBorderWidth: 1
    };
    var speedData = {
    labels: [0
<?php
for ($i = 1; $i <= $jmlhdata; $i++) {
    echo "," . $i;
}
?>
    ],
            datasets: [dataFirst, dataSecond<?php
for ($j = 1; $j < $jmladdn; $j++) {
    echo "," . $Adden2[$j];
}
?>]
    };
    var chartOptions = {
    legend: {
    display: true,
            position: 'bottom',
            labels: {
            boxWidth: 5,
                    fontColor: 'black'
            }
    }
    };
    var lineChart = new Chart(speedCanvas, {
    type: 'line',
            data: speedData,
            options: chartOptions
    });</script>


<script type="text/javascript">

    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('jumlah_persen');
    tanpa_rupiah.addEventListener('keyup', function (e)
    {
    tanpa_rupiah.value = formatRupiah(this.value);
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
</script>

<!-- Date Picker -->

</body>
<!-- END BODY -->
</html>