   <div class="row">
      <?php echo validation_errors(); ?>
        <form method="post" action="<?php echo base_url(); ?>setting/update_status/<?php echo $list->CRITIC_ID; ?>">
       <div class="col-lg-12">
          <div class="modal-header modal-header-warning">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p>Edit Status Deviasi</p>
          </div> 
          <div class="modal-body">
           
             <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <form role="form">
                         <div class="form-group">
                             <div class="col-lg-4">
                                <p>Status :</p>
                              </div>
                              <div class="col-lg-8">
                                <div class="input-group">
                                         <div class="input-group-addon">
                                            <div class="fa fa-cogs "></div>
                                         </div>
                                         
                                          <select name="status" class="form-control" required>
                                            <option value="1" <?php echo ($list->STATUS == 1) ? "selected='selected'" : ""; ?>>Aktif</option>
                                            <option value="0" <?php echo ($list->STATUS == 0) ? "selected='selected'" : ""; ?>>Non Aktif</option>
                                          </select>
                                       </div>
                              </div><br>
                          </div><br>
                    </form>
                </div>
                <div class="col-lg-1"></div>
              </div>
            </div>
            <div class="modal-footer">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-outline btn-default" data-dismiss="modal"><div class="fa fa-times"></div> Batal</button>
                        <button type="submit" class="btn btn-outline btn-info"><div class="fa fa-check"> Ubah</div></button>
                    </div>
            </div> 
    </div>
  </form>
  </div> 
