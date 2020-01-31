
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->

            <div class="page-title">
                <h1 style="color:#65054d;"><b>MONITORING RISIKO REALISASI</b></h1>
            </div>
            <!-- END PAGE TITLE -->

        </div>
        <!-- END PAGE HEAD -->

        <!-- BEGIN PAGE CONTENT INNER -->
         <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="fa fa-home fa-lg"></i>
                    <a href="<?php echo base_url(); ?>home" style="color: #787305">Dashboard</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>rkapinvestasi" style="color: #787305">RKAP Investasi</a>
                    <i class="fa fa-circle"></i>
                </li>
                
                <?php if ($act == 'add'): ?>
                    <li>
                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" style="color: #787305">Sub Program RKAP Investasi</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>risiko/view/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" style="color: #787305">Monitoring Risiko</a>
                        <i class="fa fa-circle"></i>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $list->RKAP_SUBPRO_ID ?>" style="color: #787305">Sub Program RKAP Investasi</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>risiko/view_risiko/<?php echo $list->RKAP_SUBPRO_ID ?>" style="color: #787305">Monitoring Risiko</a>
                        <i class="fa fa-circle"></i>
                    </li>
                <?php endif ?>
                
                <li>
                    <p style="color:#4C4C4C">Form Monitoring Risiko Sub Program</p>
                </li>
            </ul>


        <div class="row">

            <div class="col-md-12 col-sm-12">
                <!-- BEGIN PORTLET-->
                <div class="portlet light">

                    <form  id="entryrisiko" class="form-horizontal" action="<?php echo ($act == 'add') ? base_url('risiko/add/'.$row_subprogram->RKAP_SUBPRO_ID.'') : base_url('risiko/update_risiko/'.$list->RISK_HISTORY_ID.''); ?>" method="post">
                        <input type="hidden" name="act" value="<?php echo $act ?>" id="act">
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
                            <div class="col-md-8 col-sm-8">
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Risiko</label>
                                    <div class="col-sm-7">
                                         <select name="risiko_tipe" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih tipe risiko" id="risiko_tipe" readonly>
                                            <option value="">-- Pilih Risiko --</option>
                                             <?php
                                            foreach ($groups as $row) {
                                                if ($act == 'add') {
                                                    echo '<option value="' . $row->RISK_TYPE_ID . '">' . $row->RISK_TYPE . '</option>';
                                                } else {
                                                    if ($list->RISK_TYPE == $row->RISK_TYPE_ID) {

                                                        echo '<option selected value="' . $row->RISK_TYPE_ID . '">' . $row->RISK_TYPE . '</option>';
                                                    } else {

                                                        echo '<option value="' . $row->RISK_TYPE_ID . '">' . $row->RISK_TYPE . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Deskripsi Risiko</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? '' : $list->RISK_DESC ?>" name="risiko_deskripsi" data-validation="required" data-validation-error-msg="Deskripsi harus diisi" id="risiko_deskripsi" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Dampak Risiko</label>
                                    <div class="col-sm-7">
                                         <select name="dampak_risiko" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih dampak risiko" id="dampak_risiko" readonly>
                                            <option value="">-- Pilih Dampak Risiko --</option>

                                            <?php
                                            foreach ($groups2 as $row) {
                                                if ($act == 'add') {
                                                    echo '<option value="' . $row->RISK_IMPACT_ID . '">' . $row->RISK_IMPACT . '</option>';
                                                } else {
                                                    if ($list->RISK_IMPACT == $row->RISK_IMPACT_ID) {

                                                        echo '<option selected value="' . $row->RISK_IMPACT_ID . '">' . $row->RISK_IMPACT . '</option>';
                                                    } else {

                                                        echo '<option value="' . $row->RISK_IMPACT_ID . '">' . $row->RISK_IMPACT . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>                   
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Risiko Residual IK</label>
                                    <div class="col-sm-7">
                                         <select name="risiko_ik" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih risiko ridual ik" id="risiko_ik">
                                            <option value="">-- Pilih IK --</option>
                                           
                                            <option value="1" <?php echo ($act == 'add') ? '' : ($list->RISK_IK == '1') ? 'selected' : '' ?> >1</option>;
                                            <option value="2"  <?php echo ($act == 'add') ? '' : ($list->RISK_IK == '2') ? 'selected' : '' ?> >2</option>;
                                            <option value="3" <?php echo ($act == 'add') ? '' : ($list->RISK_IK == '3') ? 'selected' : '' ?> >3</option>;
                                            <option value="4" <?php echo ($act == 'add') ? '' : ($list->RISK_IK == '4') ? 'selected' : '' ?> >4</option>;
                                            <option value="5" <?php echo ($act == 'add') ? '' : ($list->RISK_IK == '5') ? 'selected' : '' ?> >5</option>;
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Risiko Residual ID</label>
                                    <div class="col-sm-7">
                                         <select name="risiko_id" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih risiko ridual id" id="risiko_id">
                                            <option value="">-- Pilih ID --</option>
                                           
                                            <option value="1" <?php echo ($act == 'add') ? '' : ($list->RISK_ID == '1') ? 'selected' : '' ?> >1</option>;
                                            <option value="2"  <?php echo ($act == 'add') ? '' : ($list->RISK_ID == '2') ? 'selected' : '' ?> >2</option>;
                                            <option value="3" <?php echo ($act == 'add') ? '' : ($list->RISK_ID == '3') ? 'selected' : '' ?> >3</option>;
                                            <option value="4" <?php echo ($act == 'add') ? '' : ($list->RISK_ID == '4') ? 'selected' : '' ?> >4</option>;
                                            <option value="5" <?php echo ($act == 'add') ? '' : ($list->RISK_ID == '5') ? 'selected' : '' ?> >5</option>;
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Rencana Penanganan</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? '' : $list->RISK_SOLVING ?>" name="risiko_penanganan" data-validation="required" data-validation-error-msg="Penanganan harus diisi" id="risiko_penanganan" readonly/>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Penanganan Risiko</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? '' : $list->RISK_REALISASI ?>" name="realisasi_penanganan" data-validation="required" data-validation-error-msg="Realisasi penanganan harus diisi" id="realisasi_penanganan"/>
                                    </div>
                                </div>                              
                                <div class="form-action pull-right" >
                                    <button type="submit" class="btn btn-success uppercase" id="button-add"><div class="fa fa-plus"></div> TAMBAH</button>&nbsp;
                                    <button type="submit" class="btn btn-info uppercase" id="button-edit"><div class="fa fa-gears"></div> Revisi</button>&nbsp;
                                    <?php if ($act == 'add'): ?>
                                        <a href="<?php echo base_url(); ?>risiko/view_risiko/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-default uppercase" ><div class="fa fa-ban"></div> CANCEL</a>&nbsp;
                                       
                                    <?php else: ?>
                                        <a href="<?php echo base_url(); ?>risiko/view_risiko/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-default uppercase" ><div class="fa fa-ban"></div> CANCEL</a>&nbsp;
                                      
                                    <?php endif ?>
                                    
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>


                </div>
                <!-- END PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->

