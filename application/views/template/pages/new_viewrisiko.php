<style type="text/css">
    table, td {
        border: 2px solid white !important;
        border-collapse: collapse;
        font-size: 12px !important;
    }
</style>
<style type="text/css">
    .vertical-text {
        writing-mode: tb-rl;
        transform: rotate(180deg);
        /*text-align: right;*/
    }

</style>
<style type="text/css">
    .table > thead > tr > th {
        vertical-align: bottom;
        background-color: #65054d !important;
        border: 1px solid #ddd;
        color:#FFF;
        text-align: center;
    }

    .table > tbody > tr > td {
        border: 1px solid #ddd;
    }

    .label-transparent {
        background-color: transparent;
        color: transparent;
    }

    .label-success {
        background-color: #5cb85c;
        color: #5cb85c;
    }

    .label-success-second {
        background-color: #a8fd13;
        color: #a8fd13;
    }

    .label-warning {
        background-color: #f6d71d;
        color: #f6d71d;
    }

    .label-warning-second {
        background-color: #ce820e;
        color: #ce820e;
    }
    .label-danger {
        background-color: #e73002;
        color: #e73002;
    }

    .label {
        display: inline;
        padding: .2em .6em .3em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        /*color: #fff;*/
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25em;
    }

</style>
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
            <li class="breadcrumb-item">
                <i class="icon-fire"></i>
                <a class="icon-fire" href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>">Sub Program RKAP Investasi</a>
            </li>
            <li class="breadcrumb-item">
                <i class="icon-fire"></i>
                <a class="icon-fire" href="<?php echo base_url(); ?>risiko/view_risiko/<?php echo $row_subprogram->RKAP_SUBPRO_ID  ?>">Monitoring Risiko</a>
            </li>
            <li class="breadcrumb-item active">List Monitoring Sub Program</li>
        </ol>
        <div class="headTab">
          <i class="icon-fire"></i>RENCANA PENANGANAN RISIKO SUB PROGRAM
        </div>
        <div class="panels">
            <div class="row">

                <div class="col-md-12 col-sm-12">
                    <?php if ($this->session->flashdata('login')): ?>
                        <div class="note note-info note-bordered">
                            <p>
                            <div class="fa fa-check"></div>&nbsp;<?php echo $this->session->flashdata('login'); ?>
                            </p>
                        </div>

                    <?php endif; ?>
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">
                        <form  id="addrisiko" class="form-horizontal" action="<?php echo base_url('risiko/added/' . $row_subprogram->RKAP_SUBPRO_ID . ''); ?>" method="post">
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
                            <div class="row">
                                <div class="col-xs-12">
                                    <table cellpadding="10">
                                        <tr>
                                            <td>
                                                Judul Investasi&nbsp;
                                            </td>
                                            <td>
                                                : <?php echo $find->RKAP_INVS_TITLE ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Judul Sub Program&nbsp; 
                                            </td>
                                            <td>
                                                : <?php echo $find->RKAP_SUBPRO_TITTLE ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Jenis Sub Program&nbsp;
                                            </td>
                                            <td>
                                                : <?php echo $find->SUBPRO_TYPE_NAME ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Posisi Program&nbsp;
                                            </td>
                                            <td>
                                                : <?php echo $find->POSPROG_NAME ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                            </div><br>

                            <!-- <div class="form-actions" style="margin-top: 15px;"> -->
                                <div class="text-left col-sm-6 vaddm">
                                    <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>

                                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase" id="button-back"><div class="fa fa-arrow-left"></div> Ke Sub Program</a>
                                    <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase" id="button-back"><div class="fa fa-arrow-left"></div> Ke Sub Program</a>
                                    <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase" id="button-back"><div class="fa fa-arrow-left"></div> Ke Sub Program</a>

                                    <?php else: ?>
                                        <a href="<?php echo base_url(); ?>risiko/add/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-success uppercase"><div class="fa fa-plus"></div> Tambah</a>
                                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase" id="button-back"><div class="fa fa-arrow-left"></div> Ke Sub Program</a>
                                    <?php endif ?>


                                </div>
                            <!-- </div> -->

                            <!-- <div class="col-md-6"></div> -->
                            
                            <div class="pull-right">Version :
                                <select name="version" id="version" onchange="versioning()">
                                    <?php foreach ($get_version as $val): ?>
                                        <option value="<?php echo $val->RISK_VERSION; ?>"><?php echo $val->RISK_VERSION; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <br>
                            <div class="table table-responsive" style="margin-top: 15px">
                                <input type="hidden" id="jml_group" value="<?php echo count($version_history) ?>">
                                <input type="hidden" id="versi_max" value="<?php echo $find_history_max ?>">
                                <input type="hidden" name="id_risiko" value="<?php echo ($row_subprogram == null) ? '' : $row_subprogram->RKAP_SUBPRO_ID ?>" class="form-control" id="id_risiko">
                                <table class="table table-striped table-hover" id="tbl_resiko">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="padding-bottom: 23px;">NO</th>
                                            <th rowspan="2" style="padding-bottom: 23px;">Risiko</th>
                                            <th rowspan="2" style="padding-bottom: 23px;">Deskripsi Risiko</th>
                                            <th rowspan="2" style="padding-bottom: 23px;">Dampak Risiko</th>
                                            <th colspan="3">Nilai Risiko Residual</th>
                                            <th rowspan="2" style="padding-bottom: 23px;">Rencana Penanganan Risiko</th>
                                            <th rowspan="2" style="padding-bottom: 23px;">Tools</th>
                                        </tr>
                                        <tr>
                                            <th class="thikid" style="width: 15px;">IK</th>
                                            <th class="thikid" style="width: 15px;">ID</th>
                                            <th>Tingkat Risiko</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <div class="col-md-12" style="margin-top: 20px;">
                                        <?php if (count($list) == 0): ?>

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


                                        <?php $no = 0;
                                        for ($i = 0; $i < count($list); $i++) {
                                            $no++; ?>
                                            <tr id="hide_tr<?php echo $no ?>">
                                                <!--  <?php if ($version_history[$i]->RISK_VERSION == null): ?>
                                                         
            <?php endif ?> -->
                                            <input type="hidden" name="risiko_version[]" value="<?php echo ($row_subprogram_risiko_history == null) ? 0 : $version_history[$i]->RISK_VERSION ?>" class="form-control" id="risiko_version">

                                            <td>
                                                <?php echo $list[$i]->SERIAL; ?>
                                                <input class="form-control" type="hidden" name="serial[]" id="serial<?php echo $no ?>" value="<?php echo $list[$i]->SERIAL; ?>" readonly>
                                                <input class="form-control" type="hidden" name="realisasi_penanganan[]" id="realisasi_penanganan<?php echo $no ?>" value="<?php echo $list[$i]->RISK_REALISASI; ?>" readonly>
                                            </td>
                                            <td>
                                                <?php echo $list[$i]->tipe; ?>
                                                <input class="form-control" type="hidden" name="risiko_tipe_tampil[]" id="risiko_tipe_tampil<?php echo $no ?>" value="<?php echo $list[$i]->tipe; ?>" readonly>
                                                <input class="form-control" type="hidden" name="risiko_tipe[]" id="risiko_tipe<?php echo $no ?>" value="<?php echo $list[$i]->RISK_TYPE; ?>" readonly>
                                            </td>
                                            <td>
                                                <?php echo $list[$i]->RISK_DESC; ?>
                                                <input class="form-control" type="hidden" name="risiko_deskripsi[]" id="risiko_deskripsi<?php echo $no ?>"  value="<?php echo $list[$i]->RISK_DESC; ?>" readonly ></td>
                                            <td>
                                                <?php echo $list[$i]->dampak; ?>
                                                <input class="form-control" type="hidden" name="dampak_risiko_tampil[]" id="dampak_risiko_tampil<?php echo $no ?>" value="<?php echo $list[$i]->dampak; ?>" readonly>
                                                <input class="form-control" type="hidden" name="dampak_risiko[]" id="dampak_risiko<?php echo $no ?>" value="<?php echo $list[$i]->RISK_IMPACT; ?>" readonly>
                                            </td>
                                            <td>
                                                <?php echo $list[$i]->RISK_IK; ?>
                                                <input class="form-control" type="hidden" name="risiko_ik[]" id="risiko_ik<?php echo $no ?>" value="<?php echo $list[$i]->RISK_IK; ?>" readonly></td>
                                            <td>
                                                <?php echo $list[$i]->RISK_ID; ?>
                                                <input class="form-control" type="hidden" name="risiko_id[]" id="risiko_id<?php echo $no ?>" value="<?php echo $list[$i]->RISK_ID; ?>" readonly></td>
                                            <td>
                                                <?php if ($row_subprogram_risiko == null): ?>
                                                    <?php $warna = "label-transparent"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == null && $list[$i]->RISK_ID == null): ?>
                                                    <?php $warna = "label-transparent"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == null OR $list[$i]->RISK_ID == null): ?>
                                                    <?php $warna = "label-transparent"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-success"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 5): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 5): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 5): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 5): ?>
                                                    <?php $warna = "label-danger"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-danger"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 5): ?>
                                                    <?php $warna = "label-danger"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-success"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-danger"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 5): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 5): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 5): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 5): ?>
                                                    <?php $warna = "label-danger"; ?>
                                                <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 5): ?>
                <?php $warna = "label-danger"; ?>
            <?php endif ?>

                                                <span class="label <?php echo $warna ?>" id="color<?php echo $no ?>">Label warna</span>
                                            </td>
                                            <td>
                                                <?php echo $list[$i]->RISK_SOLVING; ?>
                                                <input class="form-control" type="hidden" name="risiko_penanganan[]" id="risiko_penanganan<?php echo $no ?>" value="<?php echo $list[$i]->RISK_SOLVING; ?>" readonly>
                                            </td>
                                            <td align=" center">
                                                <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>

                                                <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>

                                                <?php else: ?>
                                                    <a href="<?php echo base_url() ?>risiko/update/<?php echo $list[$i]->SUBPRO_RISK_ID ?>" class="btn btn-sm btn-info" title="Edit Data" id="button-edit"><i class="fa fa-gears"></i></a>
                                                    <a onclick="btn_delete_risk(<?php echo $list[$i]->SUBPRO_RISK_ID ?>)" href="<?php echo base_url() ?>risiko/delete/<?php echo $list[$i]->SUBPRO_RISK_ID ?>" class="btn btn-sm btn-danger" id="button-delete" title="Hapus Data" data-toggle="modal" data-target="#hapus" ><i class="fa fa-trash-o" ></i></a> 
                                                    <!-- <a href="<?php echo base_url() ?>risiko/delete_modal/<?php echo $list[$i]->SUBPRO_RISK_ID ?>" class="btn btn-sm btn-danger" id="button-delete" title="Hapus Data" data-toggle="modal" data-target="#hapus" ><i class="fa fa-trash-o" ></i></a>  -->
            <?php endif ?>

                                            </td>                                    
                                            </tr>
        <?php } ?> 
    <?php endif; ?> 
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if ($this->session->userdata('SESS_USER_PRIV') != 1 && $this->session->userdata('SESS_USER_POSITION') != 4): ?>
                                        <?php if (count($list) == 0): ?>

                                            <button type="submit" class="btn btn-success uppercase" id="button-add" disabled><div class="fa fa-save"></div> simpan revisi</button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-success uppercase" id="button-add" ><div class="fa fa-save"></div> simpan revisi</button>
                                        <?php endif ?>
                                    <?php elseif ($this->session->userdata('SESS_USER_PRIV') != 2 && $this->session->userdata('SESS_USER_POSITION') != 4): ?>
                                        <?php if (count($list) == 0): ?>

                                            <button type="submit" class="btn btn-success uppercase" id="button-add" disabled><div class="fa fa-save"></div> simpan revisi</button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-success uppercase" id="button-add" ><div class="fa fa-save"></div> simpan revisi</button>
                                        <?php endif ?>
                                    <?php elseif ($this->session->userdata('SESS_USER_PRIV') != 3 && $this->session->userdata('SESS_USER_POSITION') != 4): ?>
                                        <?php if (count($list) == 0): ?>

                                            <button type="submit" class="btn btn-success uppercase" id="button-add" disabled><div class="fa fa-save"></div> simpan revisi</button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-success uppercase" id="button-add" ><div class="fa fa-save"></div> simpan revisi</button>
                                        <?php endif ?>

                                    <?php else: ?>

                                    <?php endif ?>
                                    <a class="btn btn-md btn-primary" target="_blank" href="<?php echo base_url() ?>risiko/print_view_risiko/<?php echo $find->RKAP_SUBPRO_ID ?>" ><i class="fa fa-file-o"></i> Unduh pdf 
                                    </a>



                                </div>
                                <div class="col-md-12 rows" style="margin-top:30px;overflow-x: auto;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <center><h4> Peta Resiko</h4></center>
                                        <?php
                                        $_11 = [];
                                        $_12 = [];
                                        $_13 = [];
                                        $_14 = [];
                                        $_15 = [];
                                        $_21 = [];
                                        $_22 = [];
                                        $_23 = [];
                                        $_24 = [];
                                        $_25 = [];
                                        $_31 = [];
                                        $_32 = [];
                                        $_33 = [];
                                        $_34 = [];
                                        $_35 = [];
                                        $_41 = [];
                                        $_42 = [];
                                        $_43 = [];
                                        $_44 = [];
                                        $_45 = [];
                                        $_51 = [];
                                        $_52 = [];
                                        $_53 = [];
                                        $_54 = [];
                                        $_55 = [];
                                        foreach ($serial as $val) {
                                            if ($val->RISK_IK . '-' . $val->RISK_ID == '1-1') {
                                                $_11[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '1-2') {
                                                $_12[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '1-3') {
                                                $_13[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '1-4') {
                                                $_14[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '1-5') {
                                                $_15[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '2-1') {
                                                $_21[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '2-2') {
                                                $_22[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '2-3') {
                                                $_23[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '2-4') {
                                                $_24[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '2-5') {
                                                $_25[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '3-1') {
                                                $_31[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '3-2') {
                                                $_32[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '3-3') {
                                                $_33[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '3-4') {
                                                $_34[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '3-5') {
                                                $_35[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '4-1') {
                                                $_41[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '4-2') {
                                                $_42[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '4-3') {
                                                $_43[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '4-4') {
                                                $_44[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '4-5') {
                                                $_45[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '5-1') {
                                                $_51[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '5-2') {
                                                $_52[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '5-3') {
                                                $_53[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '5-4') {
                                                $_54[] = $val->SERIAL;
                                            } elseif ($val->RISK_IK . '-' . $val->RISK_ID == '5-5') {
                                                $_55[] = $val->SERIAL;
                                            }
                                        }

                                        $_11 = implode(', ', $_11);
                                        $_12 = implode(', ', $_12);
                                        $_13 = implode(', ', $_13);
                                        $_14 = implode(', ', $_14);
                                        $_15 = implode(', ', $_15);
                                        $_21 = implode(', ', $_21);
                                        $_22 = implode(', ', $_22);
                                        $_23 = implode(', ', $_23);
                                        $_24 = implode(', ', $_24);
                                        $_25 = implode(', ', $_25);
                                        $_31 = implode(', ', $_31);
                                        $_32 = implode(', ', $_32);
                                        $_33 = implode(', ', $_33);
                                        $_34 = implode(', ', $_34);
                                        $_35 = implode(', ', $_35);
                                        $_41 = implode(', ', $_41);
                                        $_42 = implode(', ', $_42);
                                        $_43 = implode(', ', $_43);
                                        $_44 = implode(', ', $_44);
                                        $_45 = implode(', ', $_45);
                                        $_51 = implode(', ', $_51);
                                        $_52 = implode(', ', $_52);
                                        $_53 = implode(', ', $_53);
                                        $_54 = implode(', ', $_54);
                                        $_55 = implode(', ', $_55);
                                        ?>
                                        <table >
                                            <tr>
                                                <td rowspan="8"> <div class="vertical-text"><b>Indeks<span style=" color:#fff">_</span>Kemungkinan</b></div></td>
                                            </tr>
                                            <tr>

                                                <td height = "45px" width = "30px" style="color:#333;">5</td>
                                                <td height = "45px" width = "30px" style="color:#333;">Hampir Pasti</td>
                                                <td height = "45px" width = "45px" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_51; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_52; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_53; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#e73002" style="font-weight: bold;"><center><?php echo $_54; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#e73002" style="font-weight: bold;"><center><?php echo $_55; ?></center></td>
                                            </tr>
                                            <tr>
                                                <td height = "45px" width = "30px" style="color:#333;">4</td>
                                                <td height = "45px" width = "30px" style="color:#333;">Mungkin Sekali</td>
                                                <td height = "45px" width = "45px" bgcolor="#a8fd13" style="font-weight: bold;"><center><?php echo $_41; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_42; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_43; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_44; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#e73002" style="font-weight: bold;"><center><?php echo $_45; ?></center></td>
                                            </tr>
                                            <tr>
                                                <td height = "45px" width = "30px" style="color:#333;">3</td>
                                                <td height = "45px" width = "30px" style="color:#333;">Mungkin</td>
                                                <td height = "45px" width = "45px" bgcolor="#a8fd13" style="font-weight: bold;"><center><?php echo $_31; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_32; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_33; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_34; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_35; ?></center></td>
                                            </tr>
                                            <tr>
                                                <td height = "45px" width = "30px" style="color:#333;">2</td>
                                                <td height = "45px" width = "30px" style="color:#333;">Jarang</td>
                                                <td height = "45px" width = "45px" bgcolor="#5cb85c" style="font-weight: bold;"><center><?php echo $_21; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#a8fd13" style="font-weight: bold;"><center><?php echo $_22; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_23; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_24; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_25; ?></center></td>
                                            </tr>
                                            <tr>
                                                <td height = "45px" width = "30px" style="color:#333;">1</td>
                                                <td height = "45px" width = "30px" style="color:#333;">Sangat Jarang</td>
                                                <td height = "45px" width = "45px" bgcolor="#5cb85c" style="font-weight: bold;"><center><?php echo $_11; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#5cb85c" style="font-weight: bold;"><center><?php echo $_12; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#a8fd13" style="font-weight: bold;"><center><?php echo $_13; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#a8fd13" style="font-weight: bold;"><center><?php echo $_14; ?></center></td>
                                            <td height = "45px" width = "45px" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_15; ?></center></td>
                                            </tr>
                                            <tr>
                                                <td height = "45px" width = "45px" style="color:#333;"></td>
                                                <td height = "45px" width = "45px" style="color:#333;"></td>
                                                <td height = "45px" width = "45px" style="color:#333;">Sangat Kecil</td>
                                                <td height = "45px" width = "45px" style="color:#333;">Kecil</td>
                                                <td height = "45px" width = "45px" style="color:#333;">Sedang</td>
                                                <td height = "45px" width = "45px" style="color:#333;">Besar</td>
                                                <td height = "45px" width = "45px" style="color:#333;">Sangat Besar</td>

                                            </tr>
                                            <tr>
                                                <td height = "45px" width = "45px" style="color:#333;"></td>
                                                <td height = "45px" width = "45px" style="color:#333;"></td>
                                                <td height = "45px" width = "45px" style="color:#333;">1</td>
                                                <td height = "45px" width = "45px" style="color:#333;">2</td>
                                                <td height = "45px" width = "45px" style="color:#333;">3</td>
                                                <td height = "45px" width = "45px" style="color:#333;">4</td>
                                                <td height = "45px" width = "45px" style="color:#333;">5</td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style="text-align: center"> <b>Indeks Dampak</b></td>
                                            </tr>

                                        </table>
                                    </div>
                                    <div class="col-md-6" >
                                        <h4> Keterangan Tingkat Resiko :</h4>
                                        <table >
                                            <tr>
                                                <td height = "15px" width = "30px" bgcolor="#5cb85c"></td>
                                                <td height = "15px" width = "100px" style="color:#333;">Sangat Rendah</td>
                                            </tr>
                                            <tr>
                                                <td height = "15px" width = "30px" bgcolor="#a8fd13"></td>
                                                <td height = "15px" width = "100px" style="color:#333;">Rendah</td>
                                            </tr>
                                            <tr>
                                                <td height = "15px" width = "30px" bgcolor="#f6d71d"></td>
                                                <td height = "15px" width = "100px" style="color:#333;">Menengah</td>
                                            </tr>
                                            <tr>
                                                <td height = "15px" width = "30px" bgcolor="#ce820e"></td>
                                                <td height = "15px" width = "100px" style="color:#333;">Tinggi</td>
                                            </tr>
                                            <tr>
                                                <td height = "15px" width = "30px" bgcolor="#e73002"></td>
                                                <td height = "15px" width = "100px" style="color:#333;">Sangat Tinggi</td>
                                            </tr>


                                        </table>
                                    </div>

                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal fade modal-3d-slit modal-danger" id="hapus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" id="modaldeleterisiko" action="<?php echo base_url() ?>risiko/delete/<?php echo $list->SUBPRO_RISK_ID ?>">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">×</span>
                                        </button>
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
                    <!-- END PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
    </div>
</div>
<!-- END CONTENT -->

<script type="text/javascript">
    function versioning() {
        var link_base = "<?php echo base_url(); ?>";
        var default_version = parseInt($('#version').val());
        var version_max = $("#versi_max").val();
        if (default_version < version_max) {
            $("#addrisiko  #button-add").attr('disabled', 'disabled');

        } else {
            $("#addrisiko  #button-add").removeAttr('disabled');

        }
        var id = parseInt(document.getElementById('id_risiko').value);
        // alert (default_version);              
        $.ajax({
            url: link_base + "risiko/cek/" + id,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {'id': id, 'versi': default_version},
            success: function (response) {
                console.log(response);
                $('#tbl_resiko').find('tbody').html('');
                var tbody = '';
                hide = '';
                no = 1;
                for (i = 0; i < response.jml; i++) {

                    var ik = response.ik[i];
                    var id = response.id[i];
                    if (ik == null || id == null) {
                        //alert('haha');
                        var warna = "label-transparent";
                    } else if (ik == null && id == null) {
                        var warna = "label-transparent";
                    } else if (ik == '1' && id == '1') {
                        var warna = "label-success";
                    } else if (ik == '1' && id == '2') {
                        var warna = "label-success";
                    } else if (ik == '1' && id == '3') {
                        var warna = "label-success-second";
                    } else if (ik == '1' && id == '4') {
                        var warna = "label-success-second";
                    } else if (ik == '1' && id == '5') {
                        var warna = "label-warning";
                    } else if (ik == '2' && id == '1') {
                        //alert(ik);
                        var warna = "label-success";
                    } else if (ik == '2' && id == '2') {
                        var warna = "label-success-second";
                    } else if (ik == '2' && id == '3') {
                        var warna = "label-warning";
                    } else if (ik == '2' && id == '4') {
                        var warna = "label-warning";
                    } else if (ik == '2' && id == '5') {
                        var warna = "label-warning-second";
                    } else if (ik == '3' && id == '1') {
                        var warna = "label-success-second";
                    } else if (ik == '3' && id == '2') {
                        var warna = "label-warning";
                    } else if (ik == '3' && id == '3') {
                        var warna = "label-warning";
                    } else if (ik == '3' && id == '4') {
                        var warna = "label-warning-second";
                    } else if (ik == '3' && id == '5') {
                        var warna = "label-warning-second";
                    } else if (ik == '4' && id == '1') {
                        var warna = "label-success-second";
                    } else if (ik == '4' && id == '2') {
                        var warna = "label-warning";
                    } else if (ik == '4' && id == '3') {
                        var warna = "label-warning-second";
                    } else if (ik == '4' && id == '4') {
                        var warna = "label-warning-second";
                    } else if (ik == '4' && id == '5') {
                        var warna = "label-danger";
                    } else if (ik == '5' && id == '1') {
                        var warna = "label-warning";
                    } else if (ik == '5' && id == '2') {
                        var warna = "label-warning-second";
                    } else if (ik == '5' && id == '3') {
                        var warna = "label-warning-second";
                    } else if (ik == '5' && id == '4') {
                        var warna = "label-danger";
                    } else if (ik == '5' && id == '5') {
                        var warna = "label-danger";
                    } else if (ik == '1' && id == '1') {
                        var warna = "label-success";
                    } else if (ik == '2' && id == '1') {
                        var warna = "label-success";
                    } else if (ik == '3' && id == '1') {
                        var warna = "label-success-second";
                    } else if (ik == '4' && id == '1') {
                        var warna = "label-success-second";
                    } else if (ik == '5' && id == '1') {
                        var warna = "label-warning";
                    } else if (ik == '1' && id == '2') {
                        var warna = "label-success";
                    } else if (ik == '2' && id == '2') {
                        var warna = "label-success-second";
                    } else if (ik == '3' && id == '2') {
                        var warna = "label-warning";
                    } else if (ik == '4' && id == '2') {
                        var warna = "label-warning";
                    } else if (ik == '5' && id == '2') {
                        var warna = "label-warning-second";
                    } else if (ik == '1' && id == '3') {
                        var warna = "label-success-second";
                    } else if (ik == '2' && id == '3') {
                        var warna = "label-warning";
                    } else if (ik == '3' && id == '3') {
                        var warna = "label-warning";
                    } else if (ik == '4' && id == '3') {
                        var warna = "label-warning-second";
                    } else if (ik == '5' && id == '3') {
                        var warna = "label-warning-second";
                    } else if (ik == '1' && id == '4') {
                        var warna = "label-success-second";
                    } else if (ik == '2' && id == '4') {
                        var warna = "label-warning";
                    } else if (ik == '3' && id == '4') {
                        var warna = "label-warning-second";
                    } else if (ik == '4' && id == '4') {
                        var warna = "label-warning-second";
                    } else if (ik == '5' && id == '4') {
                        var warna = "label-danger";
                    } else if (ik == '1' && id == '5') {
                        var warna = "label-warning";
                    } else if (ik == '2' && id == '5') {
                        var warna = "label-warning-second";
                    } else if (ik == '3' && id == '5') {
                        var warna = "label-warning-second";
                    } else if (ik == '4' && id == '5') {
                        var warna = "label-danger";
                    } else if (ik == '5' && id == '5') {
                        var warna = "label-danger";
                    }
<?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                        tbody += '<tr>\
                                               <td>' + response.serial[i] + '\
                                               </td>\
                                               <td>' + response.name_tipe[i] + '\
                                               </td>\
                                               <td>' + response.deskripsi[i] + '\
                                               </td>\
                                               <td>' + response.name_impact[i] + '\
                                               </td>\
                                               <td>' + response.ik[i] + '\
                                               </td>\
                                               <td>' + response.id[i] + '\
                                               </td>\
                                               <td><span class="label ' + warna + '" id="color' + i + '">Label warna</span>\
                                               </td>\
                                               <td>' + response.solving[i] + '\
                                               </td>\
                                               <td>\
                                               </td>\
                                           </tr>';
                            <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                            tbody += '<tr>\
                                               <td>' + response.serial[i] + '\
                                               </td>\
                                               <td>' + response.name_tipe[i] + '\
                                               </td>\
                                               <td>' + response.deskripsi[i] + '\
                                               </td>\
                                               <td>' + response.name_impact[i] + '\
                                               </td>\
                                               <td>' + response.ik[i] + '\
                                               </td>\
                                               <td>' + response.id[i] + '\
                                               </td>\
                                               <td><span class="label ' + warna + '" id="color' + i + '">Label warna</span>\
                                               </td>\
                                               <td>' + response.solving[i] + '\
                                               </td>\
                                               <td>\
                                               </td>\
                                           </tr>';
                            <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                            tbody += '<tr>\
                                               <td>' + response.serial[i] + '\
                                               </td>\
                                               <td>' + response.name_tipe[i] + '\
                                               </td>\
                                               <td>' + response.deskripsi[i] + '\
                                               </td>\
                                               <td>' + response.name_impact[i] + '\
                                               </td>\
                                               <td>' + response.ik[i] + '\
                                               </td>\
                                               <td>' + response.id[i] + '\
                                               </td>\
                                               <td><span class="label ' + warna + '" id="color' + i + '">Label warna</span>\
                                               </td>\
                                               <td>' + response.solving[i] + '\
                                               </td>\
                                               <td>\
                                               </td>\
                                           </tr>';
<?php else: ?>
                        tbody += '<tr>\
                                                   <td>' + response.serial[i] + '\
                                                   </td>\
                                                   <td>' + response.name_tipe[i] + '\
                                                   </td>\
                                                   <td>' + response.deskripsi[i] + '\
                                                   </td>\
                                                   <td>' + response.name_impact[i] + '\
                                                   </td>\
                                                   <td>' + response.ik[i] + '\
                                                   </td>\
                                                   <td>' + response.id[i] + '\
                                                   </td>\
                                                   <td><span class="label ' + warna + '" id="color' + i + '">Label warna</span>\
                                                   </td>\
                                                   <td>' + response.solving[i] + '\
                                                   </td>\
                                                   <td>\
                                                   <a href="' + link_base + 'risiko/update/' + response.id_subpro[i] + '" class="btn btn-sm btn-info" title="Edit Data"><i class="fa fa-gears"></i></a>\
                                                   <a href="' + link_base + 'risiko/delete/' + response.id_subpro[i] + '" class="btn btn-sm btn-danger" title="Hapus Data" data-toggle="modal" data-target="#hapus" ><i class="fa fa-trash-o" ></i></a>\
                                                   </td>\
                                               </tr>';


<?php endif ?>
                    no++;
                }

                // alert(tbody)

                $('#tbl_resiko').find('tbody').html(tbody);


            }

        });

    }

</script>

<script type="text/javascript">
    var link_base = "<?php echo base_url(); ?>";
    function btn_delete_risk(id) {
        // alert(id);
                document.getElementById("modaldeleterisiko").action = link_base+'/risiko/delete/'+id;
        // $.ajax({
        //     type: 'GET',
        //    url: link_base+'/risiko/delete_modal/'+ id,
        //     // data: {id : id},
        //     success: function (data) {
        //         // console.log(data);
        //         var obj = JSON.parse(data);
        //         // $('#editstatus').modal();
        //          $("#id_user_modal").val(obj.CRITIC_ID);
        //         // alert(obj.USER_ID);
        //         // $('#editstatus').find('.modal-body').html(data);
        //     }
        // })
    }
</script>