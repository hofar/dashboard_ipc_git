
<style type="text/css">
    .table > thead > tr > th {
        vertical-align: bottom;
        background-color: #99a023 !important;
        border: 1px solid #ddd;
        color:#FFF;
        text-align: center;
    }

    .table > tbody > tr > td {
        border: 1px solid #ddd;
    }
</style>
<div class="page">
    <div class="page-content">
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <!-- END PAGE TITLE -->

        </div>
        <!-- END PAGE HEAD -->


        <!-- BEGIN PAGE CONTENT INNER -->

        

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item"> <a href="<?php echo base_url(); ?>rkapinvestasi">RKAP Investasi</a></li>
            <li class="breadcrumb-item"> <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>">Sub Program RKAP Investasi</a></li>
            <li class="breadcrumb-item"> <a href="<?php echo base_url(); ?>addendum/view/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>">Addendum</a></li>
            <li class="breadcrumb-item active">List Realisasi Sub Program</li>
        </ol>

        <div class="headTab">
            <i class="icon md-laptop"></i> ADDENDUM SUB PROGRAM
        </div>

        <div class="panels">

            <div class="col-md-12 col-sm-12">
                <?php if ($this->session->flashdata('login')): ?>
                    <div class="note note-info note-bordered">
                        <p>
                        <div class="fa fa-check"></div>&nbsp;<?php echo $this->session->flashdata('login'); ?>
                        </p>
                    </div>

                <?php endif; ?>
                <!-- BEGIN PORTLET-->
                
                    
                    <?php if ($this->session->flashdata('message')): ?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span>
                                <?php echo $this->session->flashdata('message'); ?>
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
                    <?php if ($this->session->flashdata('warning')): ?>
                        <div class="alert alert-warning">
                            <button class="close" data-close="alert"></button>
                            <span>
                                <?php echo $this->session->flashdata('warning'); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    <div class="panels">
                        <div class="form-actions col-sm-12" style="margin-top: 10px;" align="right">
                            <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                
                                    <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>
                               
                            <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                
                                    <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>
                                
                            <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                
                                    <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>
                                

                            <?php else: ?>
                                <a href="<?php echo base_url(); ?>addendum/add/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-success uppercase"><div class="fa fa-plus"></div> Tambah</a>
                                <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>

                            <?php endif ?>
                        </div>
                    </div>
                <div class="portlet light">
                <div class="form-group col-lg-12 col-md-12" style="margin-bottom: 30px;">
                    <div class="row">
                        <div class="form-actions col-sm-12 rows" style="margin-top: 0px;">
                            <label class="control-label col-sm-2" style="padding: 0; margin-top: 7px;">SUB Program RKAP INVESTASI</label>
                            <div class="col-sm-9" style="padding: 0;">
                                <input class="form-control" type="text" value="<?php echo $list->RKAP_SUBPRO_TITTLE ?>" disabled/>
                            </div>
                        </div>

                        <div class="form-actions col-sm-12 rows" style="margin-top: 15px;">
                            <label class="control-label col-sm-2" style="padding: 0; margin-top: 7px;">Nilai Kontrak Awal</label>
                            <div class="col-sm-3" style="padding: 0;">
                                <div class='input-group'>
                                    <span class="input-group-addon">
                                        <span>Rp.</span>
                                    </span>
                                    <input class="form-control" type="text" value="<?php echo number_format($list->RKAP_CONTRACT_VALUE_HISTORY, 0, '', '.'); ?>" disabled/>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <label class="control-label col-sm-1" style="padding: 0; margin-top: 7px;">Total Waktu</label>
                            <div class="col-sm-3" style="padding: 0;">
                                <div class='input-group'>
                                    <input class="form-control" type="text" value="<?php echo $list->RKAP_SUBPRO_PERIODE ?>" disabled/>
                                    <span class="input-group-addon">
                                        <span>Bulan</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions col-sm-12 rows" style="margin-top: 15px;">
                            <label class="control-label col-sm-2" style="padding: 0; margin-top: 7px;">Start Date</label>
                            <div class="col-sm-3" style="padding: 0;">
                                <div class='input-group'>
                                    <input type="text" class="form-control date-picker" value="<?php echo $list->RKAP_SUBPRO_CONTRACT_DATE ?> " data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="tgl_start" data-validation="required" data-validation-error-msg="Tanggal awal harus diisi" id="tgl_start" disabled/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <label class="control-label col-sm-1" style="padding: 0; margin-top: 7px;">End Date</label>
                            <div class="col-sm-3" style="padding: 0;">
                                <div class='input-group'>
                                    <input type="text" class="form-control date-picker" value="<?php echo $list->RKAP_SUBPRO_END_REAL ?> " data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="tgl_start" data-validation="required" data-validation-error-msg="Tanggal awal harus diisi" id="tgl_start" disabled/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="row">
                        <div class="table col-sm-12">
                            <table class="table table-striped table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>Addm ke-</th>
                                        <th>NO Kontrak</th>
                                        <th>Tanggal Kontrak</th>
                                        <th>Nilai Kontrak</th>
                                        <th>Jangka Waktu</th>
                                        <th>Expired Jaminan</th>
                                        <th>Kontraktor</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <div class="col-md-12" style="margin-top: 20px;">
                                    <?php if (count($list2) == 0): ?>

                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <div class="fa fa-info-circle"></div> Tidak Ada Data<br>
                                        </div>
                                    <?php else: ?>
                                        <?php if ($this->session->flashdata('message')): ?>
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <div class="fa  fa-check"></div> <?php echo $this->session->flashdata('message'); ?><br>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php $no =count($list2); foreach ($list2 as $row): ?>
                                        <tr>
                                            <td align="center"><?php echo $no--; ?></td>
                                            <td><?php echo $row->SUBPRO_ADD_NUM; ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($row->SUBPRO_ADD_DATE)); ?></td>
                                            <td>Rp <?php echo number_format($row->SUBPRO_ADD_VALUE, 0, '', '.'); ?></td>
                                            <td><?php echo $row->SUBPRO_ADD_PERIODE; ?> Bulan</td>
                                            <td><?php echo date("d-m-Y", strtotime($row->SUBPRO_ADD_ENDOF_GUARANTEE)); ?></td>
                                            <td><?php echo $row->RKAP_SUBPRO_CONTRACTOR; ?></td>

                                            <td align=" center">
                                                <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>

                                                    <a href="<?php echo base_url() ?>addendum/detail/<?php echo $row->SUBPRO_ADD_ID ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Detail Data"><i class="fa fa-eye"></i></a>
                                                 <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                    <a href="<?php echo base_url() ?>addendum/detail/<?php echo $row->SUBPRO_ADD_ID ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Detail Data"><i class="fa fa-eye"></i></a>
                                                 <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                    <a href="<?php echo base_url() ?>addendum/detail/<?php echo $row->SUBPRO_ADD_ID ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Detail Data"><i class="fa fa-eye"></i></a>

                                                <?php else: ?>
                                                    <?php if ($last_data == $row->SUBPRO_ADD_ID): ?>
                                                        <a href="<?php echo base_url() ?>addendum/update/<?php echo $row->SUBPRO_ADD_ID ?>" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit Data"><i class="fa fa-gears"></i></a>

                                                        <a href="<?php echo base_url() ?>addendum/detail/<?php echo $row->SUBPRO_ADD_ID ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Detail Data"><i class="fa fa-eye"></i></a>

                                                        <span data-toggle="tooltip" title="Hapus Data">
                                                            <a href="#" onclick="btn_delete_addendum(<?php echo $row->SUBPRO_ADD_ID ?>)" data-toggle="modal" data-target="#hapus" class="btn btn-sm btn-danger" ><i class="fa fa-trash-o" ></i></a>
                                                        </span>
                                                    <?php else: ?>
                                                        <a href="<?php echo base_url() ?>addendum/detail/<?php echo $row->SUBPRO_ADD_ID ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Detail Data"><i class="fa fa-eye"></i></a>

                                                        <!-- <span data-toggle="tooltip" title="Hapus Data">
                                                            <a href="<?php echo base_url() ?>addendum/delete_modal/<?php echo $row->SUBPRO_ADD_ID ?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapus" ><i class="fa fa-trash-o" ></i></a>
                                                        </span> -->
                                                    <?php endif ?>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal fade modal-3d-slit modal-danger" id="hapus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" id="modaldeleteaddendum" action="<?php echo base_url() ?>addendum/delete/<?php echo $list->SUBPRO_ADD_ID ?>">
                                    <div class="modal-header modal-type-colorful">
                                        <button class="close" area-hidden="true" data-dismiss="modal" type="button">x</button>
                                        <h4 class="modal-title">Konfirmasi</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah anda yakin ingin menghapus data ini ?</p>        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-pure btn-default" id="hapus" data-dismiss="modal"><div class="fa fa-times"></div> Tidak</button>
                                        <button type="submit" class="btn btn-md btn-danger"><div class="fa fa-check"> Ya</div></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->

<script type="text/javascript">
    var link_base = "<?php echo base_url(); ?>";
    function btn_delete_addendum(id) {
        document.getElementById("modaldeleteaddendum").action = link_base+'/addendum/delete/'+id;
        
    }
</script>