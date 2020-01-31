<div class="page">
    <div class="page-content">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
             <li class="breadcrumb-item">
                <i class="icon-fire"></i>
                <a class="icon-fire" href="<?php echo base_url(); ?>setting">Setting Kontrak Kritis</a>
            </li>
            <li class="breadcrumb-item active">Form Add Setting</li>
        </ol>
        <div class="headTab">
          <i class="icon-fire"></i> Form Add Setting
        </div>
        <div class="panels">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                <!-- BEGIN PORTLET-->
                    <div class="portlet light">

                       <form id="add_user" method="post" action="<?php echo base_url(); ?>setting/add" class="form-horizontal">
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success">
                                    <button class="close" data-close="alert"></button>
                                    <span>
                                        <?php echo $this->session->flashdata('success'); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('fail')): ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button>
                                    <span>
                                        <?php echo $this->session->flashdata('fail'); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                             
                            <div class="portlet-body">
                           
                                <div class="col-md-6 col-sm-6" style="padding: 0;">
                                    <fieldset style="border: 1px solid #e5e5e5; border-radius: 3px; color: #666666; padding: 15px 20px 20px 20px;">
                                        <legend style="font-size: 12px; border-radius: 3px; border: 1px solid #e5e5e5; padding: 3px 8px; margin: 10px 0 0 7px; width: auto; color: #666666;">Add Data</legend>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-sm-5">Deviasi 0% - 70%</label>
                                            <div class="col-sm-7">
                                                <input class="form-control" placeholder="Input deviasi 0% - 70%" type="number" name="deviasi_a" data-validation="required" data-validation-error-msg="Deviasi 0% - 70% harus diisi" id="deviasi_a"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-5">Deviasi 70% - 100%</label>
                                            <div class="col-sm-7">
                                                <input class="form-control" placeholder="Input deviasi 70% - 100%" type="number" name="deviasi_b" data-validation="required" data-validation-error-msg="Deviasi 70% - 100% harus diisi" id="deviasi_b"/>
                                            </div>
                                        </div>
                                       
                                     


                                        <div class="form-action pull-right adcanser">
                                            <button type="submit" class="btn btn-success uppercase addusr" id="button-add"><div class="fa fa-plus"></div> Tambah</button>&nbsp;
                                            <a href="<?php echo base_url(); ?>setting" class="btn btn-default uppercase" ><div class="fa fa-ban"></div> Batal</a>&nbsp;

                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    
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



