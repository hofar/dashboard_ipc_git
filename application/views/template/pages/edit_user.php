
<div class="page">
    <div class="page-content">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
             <li class="breadcrumb-item">
                <i class="fa fa-face fa-lg"></i>
                <a class="icon md-face" href="<?php echo base_url(); ?>usermanagement">User Management</a>
            </li>
            <li class="breadcrumb-item active">Form User Management</li>
        </ol>
        <div class="headTab">
          <i class="icon md-face"></i> Form User Management
        </div>
        <div class="panels">
          <div class="row" style="margin:30px">
            <a href="<?php echo base_url(); ?>usermanagement" class="btn btn-warning btn-round" ><div class="fa fa-arrow-left"></div> KEMBALI</a>
          </div>
          
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
               <?php if($this->session->flashdata('username')): ?>
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="fa fa-info-circle"></div>&nbsp;<?php echo $this->session->flashdata('username'); ?>
              </div>
              <?php endif; ?>
              <?php if($this->session->flashdata('email')): ?>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="fa fa-info-circle"></div>&nbsp;<?php echo $this->session->flashdata('email'); ?>
                  </div>
                  <?php endif; ?>
              <?php if($this->session->flashdata('password')): ?>
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="fa fa-info-circle"></div>&nbsp;<?php echo $this->session->flashdata('password'); ?>
              </div>
              <?php endif; ?>
          <div class="rows">
            <div class="col-md-6">
              <form method="post" action="<?php echo base_url(); ?>usermanagement/update/<?php echo $list->USER_ID; ?>" class="form-horizontal">
                <CENTER><h3>Data User</h3></CENTER><hr><br>
                  <div class="form-group">
                      <label class="control-label">Username</label>
                      <div>
                          <input class="form-control" type="text" value="<?php echo $list->USER_NAME ?>" name="username" data-validation="required" data-validation-error-msg="Username harus diisi" id="username"/>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label">NIPP</label>
                      <div>
                          <input class="form-control" type="text" value="<?php echo $list->USER_NIPP ?>" name="nipp" data-validation="required" data-validation-error-msg="NIPP harus diisi" id="nipp"/>
                      </div>
                  </div>
                  
                  
                  <div class="form-group">
                      <label class="control-label">Email</label>
                      <div>
                        
                          <input class="form-control" type="email" value="<?php echo $list->USER_EMAIL ?>" name="email" data-validation="required" data-validation-error-msg="Email harus diisi" id="email"/>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label">Privilage</label>
                      <div>
                          <select name="privilage" class="form-control" id="privilage" data-validation="required" data-validation-error-msg="Privilage harus di pilih" id="privilage" readonly>
                            <option value="<?php echo $list->USER_PRIV ?>"><?php echo $list->USER_PRIV_NAME; ?></option>;
                             <?php 
                               foreach($groups as $row)
                               {
                                if ($row->USER_PRIV_ID != $list->USER_PRIV) 
                                {
                                  echo '<option value="'.$row->USER_PRIV_ID.'">'.$row->USER_PRIV_NAME.'</option>';
                                }
                              } 
                             ?>
                          </select>
                      </div>
                  </div>
                  <?php if ($list->USER_PRIV == 1): ?>
                        <div class="form-group">
                            <label class="control-label">Branch</label>
                            <div>
                                <select name="branch" class="form-control" id="branch" data-validation="required" data-validation-error-msg="Branch harus di pilih" id="branch">
                                  <option value="<?php echo $list->USER_BRANCH ?>"><?php echo $list->BRANCH_NAME; ?></option>;
                                   <?php 
                                     foreach($groupsPusat1 as $row)
                                     {
                                      if ($row->BRANCH_ID != $list->USER_BRANCH) 
                                      {
                                        echo '<option value="'.$row->BRANCH_ID.'">'.$row->BRANCH_NAME.'</option>';
                                      }
                                    } 
                                   ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Posisi</label>
                            <div>
                                <select name="posisi" class="form-control" id="posisi" data-validation="required" data-validation-error-msg="Posisi harus di pilih" id="posisi">
                                  <option value="<?php echo $list->USER_POSITION ?>"><?php echo $list->POSITION_NAME; ?></option>;
                                   <?php 
                                     foreach($groupsPusat2 as $row)
                                     {
                                      if ($row->POSITION_ID != $list->USER_POSITION) 
                                      {
                                        echo '<option value="'.$row->POSITION_ID.'">'.$row->POSITION_NAME.'</option>';
                                      }
                                    } 
                                   ?>
                                </select> 
                            </div>
                        </div>
                  <?php elseif($list->USER_PRIV == 2): ?>
                        <div class="form-group">
                              <label class="control-label">Branch</label>
                              <div>
                                  <select name="branch" class="form-control" id="branch" data-validation="required" data-validation-error-msg="Branch harus di pilih" id="branch">
                                    <option value="<?php echo $list->USER_BRANCH ?>"><?php echo $list->BRANCH_NAME; ?></option>;
                                     <?php 
                                       foreach($groups1 as $row)
                                       {
                                        if ($row->BRANCH_ID != $list->USER_BRANCH) 
                                        {
                                          echo '<option value="'.$row->BRANCH_ID.'">'.$row->BRANCH_NAME.'</option>';
                                        }
                                      } 
                                     ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label">Posisi</label>
                              <div>
                                  <select name="posisi" class="form-control" id="posisi" data-validation="required" data-validation-error-msg="Posisi harus di pilih" id="posisi">
                                    <option value="<?php echo $list->USER_POSITION ?>"><?php echo $list->POSITION_NAME; ?></option>;
                                     <?php 
                                       foreach($groups2 as $row)
                                       {
                                        if ($row->POSITION_ID != $list->USER_POSITION) 
                                        {
                                          echo '<option value="'.$row->POSITION_ID.'">'.$row->POSITION_NAME.'</option>';
                                        }
                                      } 
                                     ?>
                                  </select> 
                              </div>
                          </div>
                  <?php elseif($list->USER_PRIV == 3): ?>
                        <div class="form-group">
                              <label class="control-label">Branch</label>
                              <div>
                                  <select name="branch" class="form-control" id="branch" data-validation="required" data-validation-error-msg="Branch harus di pilih" id="branch">
                                    <option value="<?php echo $list->USER_BRANCH ?>"><?php echo $list->BRANCH_NAME; ?></option>;
                                     <?php 
                                       foreach($groupsAnak1 as $row)
                                       {
                                        if ($row->BRANCH_ID != $list->USER_BRANCH) 
                                        {
                                          echo '<option value="'.$row->BRANCH_ID.'">'.$row->BRANCH_NAME.'</option>';
                                        }
                                      } 
                                     ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label">Posisi</label>
                              <div>
                                  <select name="posisi" class="form-control" id="posisi" data-validation="required" data-validation-error-msg="Posisi harus di pilih" id="posisi">
                                    <option value="<?php echo $list->USER_POSITION ?>"><?php echo $list->POSITION_NAME; ?></option>;
                                     <?php 
                                       foreach($groupsAnak2 as $row)
                                       {
                                        if ($row->POSITION_ID != $list->USER_POSITION) 
                                        {
                                          echo '<option value="'.$row->POSITION_ID.'">'.$row->POSITION_NAME.'</option>';
                                        }
                                      } 
                                     ?>
                                  </select> 
                              </div>
                          </div>
                  <?php endif ?>
                  
                  
                  <div class="form-action pull-right" >
                      <button type="submit" class="btn btn-primary uppercase" id="button-adeditd"><div class="fa fa-pencil"></div> EDIT DATA</button>&nbsp;
                      
                      
                  </div>
              </form>
            </div>
            <div class="col-md-6">
              <form method="post" action="<?php echo base_url(); ?>usermanagement/update_pass_user/<?php echo $list->USER_ID; ?>" class="form-horizontal">
              <CENTER><h3>Password</h3></CENTER><hr><br>
                <div class="form-group">
                      <label class="control-label ">Password Baru</label>
                      <div>
                        <input type="password" name="password_new" class="form-control" placeholder="Masukkan Password Baru" data-validation="required" data-validation-error-msg="Password Baru harus diisi">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label">Konfirmasi Password Baru</label>
                      <div>
                        <input type="password" name="password_konfirm" class="form-control" placeholder="Ulangi Password Baru" data-validation="required" data-validation-error-msg="konfirmasi Password Baru harus diisi">
                      </div>
                  </div>
                  <div class="form-action pull-right" >
                      <button type="submit" class="btn btn-primary uppercase" id="button-adeditd"><div class="fa fa-pencil"></div> EDIT PASSWORD</button>&nbsp;                      
                  </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</div>

