
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
             <?php if ($act == 'add'): ?>
                 <li class="breadcrumb-item">
                    <i class="icon-fire"></i>
                    <a class="icon-fire" href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>">Sub Program RKAP Investasi</a>
                </li>
                 <li class="breadcrumb-item">
                    <i class="icon-fire"></i>
                    <a class="icon-fire" href="<?php echo base_url(); ?>risiko/view/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>">Monitoring Risiko</a>
                </li>
            <?php else: ?>
                <li class="breadcrumb-item">
                    <i class="icon-fire"></i>
                    <a class="icon-fire" href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $list->RKAP_SUBPRO_ID ?>">Sub Program RKAP Investasi</a>
                </li>
                 <li class="breadcrumb-item">
                    <i class="icon-fire"></i>
                    <a class="icon-fire" href="<?php echo base_url(); ?>risiko/view/<?php echo $list->RKAP_SUBPRO_ID ?>">Monitoring Risiko</a>
                </li>
            <?php endif ?>
            <li class="breadcrumb-item active">Form Monitoring Risiko Sub Program</li>
        </ol>
        <div class="headTab">
          <i class="icon-fire"></i> Form Monitoring Risiko Sub Program
        </div>
        <div class="panels">
           <div class="row">

              <div class="col-md-12 col-sm-12">
                <!-- BEGIN PORTLET-->
                <div class="portlet light">
                    <form  id="entryrisiko" class="form-horizontal" action="<?php echo ($act == 'add') ? base_url('risiko/add/'.$row_subprogram->RKAP_SUBPRO_ID.'') : base_url('risiko/update/'.$list->SUBPRO_RISK_ID.''); ?>" method="post">
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
                                <div class="form-group rows">
                                    <label class="control-label col-sm-5">Risiko</label>
                                    <div class="col-sm-7">
                                         <select name="risiko_tipe" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih tipe risiko" id="risiko_tipe">
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
                          

                                <div class="form-group rows">
                                    <label class="control-label col-sm-5">Deskripsi Risiko</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? '' : $list->RISK_DESC ?>" name="risiko_deskripsi" data-validation="required" data-validation-error-msg="Deskripsi harus diisi" id="risiko_deskripsi"/>
                                    </div>
                                </div>
                                <div class="form-group rows">
                                    <label class="control-label col-sm-5">Dampak Risiko</label>
                                    <div class="col-sm-7">
                                         <select name="dampak_risiko" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih dampak risiko" id="dampak_risiko">
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
                                <div class="form-group rows">
                                    <label class="control-label col-sm-5">Risiko Residual IK</label>
                                    <div class="col-sm-7">
                                         <select name="risiko_ik" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih risiko ridual ik" id="risiko_ik">
                                            <option value="">-- Pilih IK --</option>
                                           
                                            <option value="1" <?php echo ($act == 'add') ? '' : ($list->RISK_IK == '1') ? 'selected' : '' ?> >
                                                1 - Sangat Jarang
                                            </option>;
                                            <option value="2"  <?php echo ($act == 'add') ? '' : ($list->RISK_IK == '2') ? 'selected' : '' ?> >
                                                2 - Jarang
                                            </option>;
                                            <option value="3" <?php echo ($act == 'add') ? '' : ($list->RISK_IK == '3') ? 'selected' : '' ?> >
                                                3 - Mungkin
                                            </option>;
                                            <option value="4" <?php echo ($act == 'add') ? '' : ($list->RISK_IK == '4') ? 'selected' : '' ?> >
                                                4 - Mungkin Sekali
                                            </option>;
                                            <option value="5" <?php echo ($act == 'add') ? '' : ($list->RISK_IK == '5') ? 'selected' : '' ?> >
                                                5 - Hampir Pasti
                                            </option>;
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group rows">
                                    <label class="control-label col-sm-5">Risiko Residual ID</label>
                                    <div class="col-sm-7">
                                         <select name="risiko_id" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih risiko ridual id" id="risiko_id">
                                            <option value="">-- Pilih ID --</option>
                                           
                                            <option value="1" <?php echo ($act == 'add') ? '' : ($list->RISK_ID == '1') ? 'selected' : '' ?> >
                                                1 - Sangat Kecil
                                            </option>;
                                            <option value="2"  <?php echo ($act == 'add') ? '' : ($list->RISK_ID == '2') ? 'selected' : '' ?> >
                                                2 - Kecil
                                            </option>;
                                            <option value="3" <?php echo ($act == 'add') ? '' : ($list->RISK_ID == '3') ? 'selected' : '' ?> >
                                                3 - Sedang
                                            </option>;
                                            <option value="4" <?php echo ($act == 'add') ? '' : ($list->RISK_ID == '4') ? 'selected' : '' ?> >
                                                4 - Besar
                                            </option>;
                                            <option value="5" <?php echo ($act == 'add') ? '' : ($list->RISK_ID == '5') ? 'selected' : '' ?> >
                                                5 - Sangat Besar
                                            </option>;
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group rows">
                                    <label class="control-label col-sm-5">Rencana Penanganan</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? '' : $list->RISK_SOLVING ?>" name="risiko_penanganan" data-validation="required" data-validation-error-msg="Penanganan harus diisi" id="risiko_penanganan"/>
                                    </div>
                                </div>                                
                                <div class="form-action pull-right" >
                                    <button type="submit" class="btn btn-success uppercase" id="button-add"><div class="fa fa-plus"></div> Tambah</button>&nbsp;
                                    <button type="submit" class="btn btn-info uppercase" id="button-edit"><div class="fa fa-gears"></div> Revisi</button>&nbsp;
                                    <?php if ($act == 'add'): ?>
                                        <a href="<?php echo base_url(); ?>risiko/view/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-default uppercase" ><div class="fa fa-ban"></div> Batal</a>&nbsp;
                                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>
                                    <?php else: ?>
                                        <a href="<?php echo base_url(); ?>risiko/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-default uppercase" ><div class="fa fa-ban"></div> Batal</a>&nbsp;
                                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>
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
</div>
<!-- END CONTENT -->

