<style type="text/css">
.table > thead > tr > th {
        vertical-align: bottom;
        border: 1px solid #ddd;
        text-align: center;
		color:#666;
		background-color:#EBEBEB;
		font-size:14px
}

.table > tbody > tr > td {
    border: 1px solid #ddd;
}

.row {
	  display: -ms-flexbox;
	  display: flex;
	  -ms-flex-wrap: wrap;
	  flex-wrap: wrap;
	  margin-right: -1.0715rem;
	  margin-left: -1.0715rem;
	}
</style>


<div class="page">
<div class="page-content">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <i class="fa fa-home fa-lg"></i>
            <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
        </li>
        <li class="breadcrumb-item">Setting</li>
        <li class="breadcrumb-item active">Early Warning System</li>
    </ol>
<div class="panels"> 
		
        <?php if ($this->session->flashdata('login')): ?>
                    <div class="note note-info note-bordered">
                        <p>
                        <div class="fa fa-check"></div>&nbsp;<?php echo $this->session->flashdata('login'); ?>
                        </p>
                    </div>

                <?php endif; ?>
        
        <div>
        	<form action="<?php echo base_url() ?>setting/edit_ews" method="post" id="form-reminder">
                            <table class="table table-hover dataTable w-full" style="font-size:14px">
                                <thead>
                                    <tr>
                                        <th width="60%">Reminder</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for ($i=0; $i < count($list); $i++) { 
                                            echo "<tr>
                                                    <td>".$list[$i]->REMINDER."</td>
                                                    <td>
                                                        <div class='form-group setting-ews'>
                                                            <div class='input-group'>
                                                                <input type='number' class='form-control' name='reminderInput$i' value='".$list[$i]->DATA_REMINDER."'>
                                                                <span class='input-group-addon'>";
                                                                // kondisi satuan
                                                                if ($i == 0) 
                                                                    echo "<span>&nbsp;%&nbsp;&nbsp;</span>";
                                                                else
                                                                    echo "<span>hari</span>                 
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </form>
        </div>
        <div>
        	<button type="button" class="btn btn-primary btn-block" style="width: 100%;" data-toggle="modal" data-target="#saveModal"><div class="fa fa-save"></div> Simpan</button>
        </div>

</div>
</div>
</div>




<!--  MODAL SAVE  -->
<div class="modal fade modal-primary" id="saveModal" role="dialog">
    <div class="modal-dialog">
    
    <!-- Modal content-->
      
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Konfirmasi</h4>
        </div>
        <div class="modal-body">
            <p>Apakah anda yakin ingin memperbarui <i>reminder EWS</i> ?</p>
        </div>
        <div class="modal-footer">
                   
            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal"><div class="fa fa-times"></div> Tidak</button>
            <button type="button" class="btn btn-primary" id="clickYa"><div class="fa fa-check"></div> Ya</button>     
        </div>
    </div>
      
    </div>
</div>

<script>
    $("#clickYa").on('click', function(){
        $("#form-reminder").submit();
    })
</script>	