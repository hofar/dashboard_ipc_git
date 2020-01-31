<form method="post" action="<?php echo base_url() ?>usermanagement/delete/<?php echo $list->USER_ID ?>">
    <div class="modal-header modal-type-colorful">
        <button class="close" area-hidden="true" data-dismiss="modal" type="button">x</button>
        <h4 class="modal-title">Konfirmasi</h4>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin ingin menghapus data ini ?</p>        
    </div>
    
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-default" id="hapus" data-dismiss="modal"><div class="fa fa-times"></div> Tidak</button>
    <button type="submit" class="btn btn-sm btn-danger"><div class="fa fa-check"> Ya</div></button>
</div>
</form>