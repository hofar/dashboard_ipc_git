<form id="add_ganttchart" method="post" action="<?php echo base_url() ?>ganttchart/add_subpro/<?php echo $row_rkap->RKAP_INVS_ID ?>">
    <div class="modal-header modal-type-colorful">
        <button class="close" area-hidden="true" data-dismiss="modal" type="button">x</button>
        <h4 class="modal-title">Tambah Data Sub Program</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="id_rkap" id="id_rkap" value="<?php echo $row_rkap->RKAP_INVS_ID ?>">
        <div class="form-group" style="margin-bottom: 20px;">
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
        <div class="form-group" style="margin-bottom: 20px;">
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
        <div class="clearfix"></div>

    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-sm btn-default" ><div class="fa fa-times"></div> Reset</button>
        <button type="submit" class="btn btn-success"><div class="fa fa-plus"> tambah</div></button>
    </div>
</form>