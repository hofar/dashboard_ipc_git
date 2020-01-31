<div class="page">
    <div class="page-content">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Edit Password User</li>
        </ol>
        <div class="headTab">
          <i class="icon-fire"></i>EDIT PASSWORD USER
        </div>
        <div class="panels">
           <div class="row">

              <div class="col-md-12 col-sm-12">
                <!-- BEGIN PORTLET-->
                <div class="portlet light">

                   <form method="post" action="<?php echo base_url(); ?>user/update_pass/<?php echo $list->USER_ID; ?>" class="form-horizontal">
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
                       
                            <div class="col-md-8 col-sm-8">
                                                                
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Username</label>
                                    <div class="col-sm-7">
                                      
                                       <input type="text" name="username" class="form-control" value="<?php echo $list->USER_NAME; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Password Lama</label>
                                    <div class="col-sm-7">
                                      <input type="password" name="password" class="form-control" placeholder="Masukkan Password Lama" data-validation="required" data-validation-error-msg="Password harus diisi">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Password Baru</label>
                                    <div class="col-sm-7">
                                      <input type="password" name="password_new" class="form-control" placeholder="Masukkan Password Baru" data-validation="required" data-validation-error-msg="Password Baru harus diisi">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Konfirmasi Password Baru</label>
                                    <div class="col-sm-7">
                                      <input type="password" name="password_konfirm" class="form-control" placeholder="Ulangi Password Baru" data-validation="required" data-validation-error-msg="konfirmasi Password Baru harus diisi">
                                    </div>
                                </div>
                              
                                <div class="form-action pull-right" >
                                    <button type="submit" class="btn btn-primary uppercase" id="button-save"><div class="fa fa-check"></div> SIMPAN</button>
                                   
                                    
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


