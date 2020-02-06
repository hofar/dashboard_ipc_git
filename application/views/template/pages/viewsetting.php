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
            <li class="breadcrumb-item active">Kontrak Kritis</li>
        </ol>
        <div class="panels"> 
            <div align="right">
                <a href="<?php echo base_url(); ?>setting/add" class="btn btn-success btn-round" style="width:150px">Tambah</a>
            </div>
            <br />
            <?php if ($this->session->flashdata('login')): ?>
                <div class="note note-info note-bordered">
                    <p>
                    <div class="fa fa-check"></div>&nbsp;<?php echo $this->session->flashdata('login'); ?>
                    </p>
                </div>
            <?php endif; ?>

            <div>
                <table class="table table-hover dataTable w-full" data-plugin="dataTable" style="font-size:13px">
                    <thead>
                        <tr>
                            <th>Nomor</th>

                            <th>Deviasi 0% - 70%</th>
                            <th>Deviasi 70% - 100%</th>
                            <th>Status</th>
                            <th>Tools</th>

                        </tr>
                    </thead>
                    <tbody>
                    <div class="col-md-12">
                        <?php if (count($list) == 0): ?>
                            <br>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <div class="fa fa-info-circle"></div> Tidak Ada Data<br>
                            </div>
                        <?php else: ?>
                            <?php if ($this->session->flashdata('success')): ?>
                                <br><div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="fa  fa-check"></div> <?php echo $this->session->flashdata('success'); ?><br>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('fail')): ?>
                                <br><div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="fa  fa-exclamation-circle"></div> <?php echo $this->session->flashdata('fail'); ?><br>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php $no = 0;
                        foreach ($list as $row): $no++;
                            ?>
                            <tr>
                                <td><center><?php echo $no; ?></center></td>
                            <td><center><?php echo $row->CRITIC_DEVIASI_A; ?></center></td>
                            <td><center><?php echo $row->CRITIC_DEVIASI_B; ?></center></td>
                            <td><center>
                               <!-- <input type="text" name="id_user" id="id_user" value="<?php echo $row->CRITIC_ID ?>"> -->
                                <a onclick="btn_edit_set(<?php echo $row->CRITIC_ID ?>)" class="btn btn-sm btn-outline btn-default" data-toggle="modal" data-target="#editstatus"> <?php
                                    switch ($row->STATUS) {
                                        case 1:
                                            $STATUS = 'Aktif';
                                            break;
                                        case 0:
                                            $STATUS = 'Non Aktif';
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                    echo $STATUS;
                                    ?></a></center></td>
                            <td align="center">
                                  <!--   <a href="<!?php echo base_url() ?>uploads/announcement/<!?php echo $row->ANNOUNCEMENT_NAME; ?>" download data-toggle="tooltip" title="Download <!?php echo $row->ANNOUNCEMENT_NAME ?>" class="btn btn-sm btn-primary" ><i class=" fa fa-download" ></i></a> -->
                                  <!-- <input type="text" name="id_user" id="id_user" value="<!?php echo $row->CRITIC_ID ?>"> -->
                                <span data-toggle="tooltip" title="Hapus Data">
                                    <a onclick="btn_delete_set(<?php echo $row->CRITIC_ID ?>)" class="btn btn-sm btn-danger" style="color:#fff !important;" data-toggle="modal" data-target="#hapus"><i class="fa fa-trash-o" ></i></a>
                                </span>
                                 <!-- <span data-toggle="tooltip" title="Delete Data">
                                    <a href="<?php echo base_url() ?>setting/delete_modal/<?php echo $row->CRITIC_ID; ?>" class="btn btn-sm btn-danger btn-aksion" data-toggle="modal" data-target="#hapus" ><i class="fa fa-trash-o" ></i></a>
                                </span> -->
                            </td>
                            </tr>
                        <?php endforeach; ?>
<?php endif; ?>                                   
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-3d-flip-vertical modal-info" id="editstatus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
<?php echo validation_errors(); ?>
            <form method="post" id="modaleditsetting" action="<?php echo base_url(); ?>setting/update_status/<?php echo $list[0]->CRITIC_ID; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Edit Status Deviasi</h4>
                </div> 
                <div class="modal-body">
                    <div class="form-group">
                        <p>Status :</p>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <div class="fa fa-cogs "></div>
                            </div>
                            <select name="status" class="form-control" required>
                                <option value="1" <?php echo ($list[0]->STATUS == 1) ? "selected='selected'" : ""; ?>>Aktif</option>
                                <option value="0" <?php echo ($list[0]->STATUS == 0) ? "selected='selected'" : ""; ?>>Non Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-pure btn-default" data-dismiss="modal"><div class="fa fa-ban"></div> Batal</button>
                    <button type="submit" class="btn btn-info"><div class="fa fa-pencil"> Ubah</div></button>
                </div> 
            </form>
        </div> 
    </div>
</div>

<div class="modal fade modal-3d-slit modal-danger" id="hapus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="modaldeletesetting" action="<?php echo base_url() ?>setting/delete/<?php echo $list[0]->CRITIC_ID; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Konfirmasi</h4>
                </div>
                <div class="modal-body">
                    <!-- <input type="text" name="id_user" id="id_user_modal"> -->
                    <p>Apakah anda yakin ingin menghapus data ini ?</p>        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default btn-pure" id="hapus" data-dismiss="modal"><div class="fa fa-times"></div> Tidak</button>
                    <button type="submit" class="btn btn-sm btn-danger"><div class="fa fa-check"> Ya</div></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- <div class="modal fade modal-3d-slit modal-danger" id="exampleModalDanger" aria-hidden="true"
                      aria-labelledby="exampleModalDanger" role="dialog" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title">Modal Title</h4>
                          </div>
                          <div class="modal-body">
                            <p>One fine body…</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                          </div>
                        </div>
                      </div>
                    </div> -->

<script type="text/javascript">
    var link_base = "<?php echo base_url(); ?>";
    function btn_edit_set(id) {
        // alert(id);
        $.ajax({
            type: 'GET',
            url: link_base + '/tanpa_auth/edit_modalstatus2/' + id,
            // data: {id : id},
            success: function (data) {
                // console.log(data);
                document.getElementById("modaleditsetting").action = link_base + '/setting/update_status/' + id;
                var obj = JSON.parse(data);
                // $('#editstatus').modal();
                $("#id_user_modal").val(obj.CRITIC_ID);
                // alert(obj.USER_ID);
                // $('#editstatus').find('.modal-body').html(data);
            }
        })
    }

</script>
<script type="text/javascript">
    var link_base = "<?php echo base_url(); ?>";
    function btn_delete_set(id) {
        // alert(id);
        $.ajax({
            type: 'GET',
            url: link_base + '/tanpa_auth/delete_modal2/' + id,
            // data: {id : id},
            success: function (data) {
                // console.log(data);
                document.getElementById("modaldeletesetting").action = link_base + '/setting/delete/' + id;
                var obj = JSON.parse(data);
                // $('#editstatus').modal();
                $("#id_user_modal").val(obj.CRITIC_ID);
                // alert(obj.USER_ID);
                // $('#editstatus').find('.modal-body').html(data);
            }
        })
    }
</script>