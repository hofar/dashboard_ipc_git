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
                <a class="icon-fire" href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $find->RKAP_SUBPRO_ID ?>">Sub Program RKAP Investasi</a>
            </li>
            <li class="breadcrumb-item active">List Monitoring Sub Program</li>
        </ol>
        <div class="headTab">
          <i class="icon-fire"></i>RENCANA PENANGANAN RISIKO
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

                            <!-- <div class="col-md-6"></div> -->
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
		                                </tr>
		                                <tr>
		                                    <th>IK</th>
		                                    <th>ID</th>
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
		                                        
		                                       
		                                      <?php $no = 0;  for ($i=0; $i<count($list); $i++) {$no++; ?>
		                                        <tr id="hide_tr<?php echo $no ?>">
		                                          
		                                         
		                                         	<td><?php echo $list[$i]->SERIAL; ?></td>
		                                            <td><?php echo $list[$i]->tipe; ?></td>
		                                            <td><?php echo $list[$i]->RISK_DESC; ?></td>
		                                            <td><?php echo $list[$i]->dampak; ?></td>
		                                            <td><?php echo $list[$i]->RISK_IK; ?></td>
		                                           <td><?php echo $list[$i]->RISK_ID; ?></td>
		                                            <td>
		                                                <?php if ($row_subprogram_risiko == null): ?>
		                                                    <?php $warna = "label-transparent"; ?>
		                                                <?php elseif ($list[$i]->RISK_IK == null && $list[$i]->RISK_ID == null): ?>
		                                                    <?php $warna = "label-transparent"; ?>
		                                                <?php elseif ($list[$i]->RISK_IK == null OR $list[$i]->RISK_ID == null): ?>
		                                                    <?php $warna = "label-transparent"; ?>
		                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 1): ?>
		                                                    <?php $warna = "label-success"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 2): ?>
		                                                    <?php $warna = "label-success"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 3): ?>
		                                                     <?php $warna = "label-success-second"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 4): ?>
		                                                     <?php $warna = "label-success-second"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 5): ?>
		                                                     <?php $warna = "label-warning"; ?>
		                                                <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 1): ?>
		                                                    <?php $warna = "label-success"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 2): ?>
		                                                    <?php $warna = "label-success-second"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 3): ?>
		                                                     <?php $warna = "label-warning"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 4): ?>
		                                                    <?php $warna = "label-warning"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 5): ?>
		                                                    <?php $warna = "label-warning-second"; ?>
		                                                <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 1): ?>
		                                                    <?php $warna = "label-success-second"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 2): ?>
		                                                    <?php $warna = "label-warning"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 3): ?>
		                                                     <?php $warna = "label-warning"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 4): ?>
		                                                     <?php $warna = "label-warning-second"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 5): ?>
		                                                     <?php $warna = "label-warning-second"; ?>
		                                                <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 1): ?>
		                                                    <?php $warna = "label-success-second"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 2): ?>
		                                                    <?php $warna = "label-warning"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 3): ?>
		                                                    <?php $warna = "label-warning-second"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 4): ?>
		                                                     <?php $warna = "label-warning-second"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 5): ?>
		                                                     <?php $warna = "label-danger"; ?>
		                                                <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 1): ?>
		                                                   <?php $warna = "label-warning"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 2): ?>
		                                                    <?php $warna = "label-warning-second"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 3): ?>
		                                                     <?php $warna = "label-warning-second"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 4): ?>
		                                                    <?php $warna = "label-danger"; ?>
		                                                 <?php elseif($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 5): ?>
		                                                     <?php $warna = "label-danger"; ?>
		                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 1): ?>
		                                                    <?php $warna = "label-success"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 1): ?>
		                                                    <?php $warna = "label-success"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 1): ?>
		                                                     <?php $warna = "label-success-second"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 1): ?>
		                                                     <?php $warna = "label-success-second"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 1): ?>
		                                                     <?php $warna = "label-warning"; ?>
		                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 2): ?>
		                                                    <?php $warna = "label-success"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 2): ?>
		                                                    <?php $warna = "label-success-second"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 2): ?>
		                                                     <?php $warna = "label-warning"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 2): ?>
		                                                    <?php $warna = "label-warning"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 2): ?>
		                                                     <?php $warna = "label-warning-second"; ?>
		                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 3): ?>
		                                                    <?php $warna = "label-success-second"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 3): ?>
		                                                    <?php $warna = "label-warning"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 3): ?>
		                                                     <?php $warna = "label-warning"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 3): ?>
		                                                     <?php $warna = "label-warning-second"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 3): ?>
		                                                     <?php $warna = "label-warning-second"; ?>
		                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 4): ?>
		                                                    <?php $warna = "label-success-second"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 4): ?>
		                                                    <?php $warna = "label-warning"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 4): ?>
		                                                     <?php $warna = "label-warning-second"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 4): ?>
		                                                     <?php $warna = "label-warning-second"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 4): ?>
		                                                     <?php $warna = "label-danger"; ?>
		                                                <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 5): ?>
		                                                    <?php $warna = "label-warning"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 5): ?>
		                                                    <?php $warna = "label-warning-second"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 5): ?>
		                                                     <?php $warna = "label-warning-second"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 5): ?>
		                                                     <?php $warna = "label-danger"; ?>
		                                                <?php elseif($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 5): ?>
		                                                     <?php $warna = "label-danger"; ?>
		                                                <?php endif ?>
		                                                
		                                                <span class="label <?php echo $warna ?>" id="color<?php echo $no ?>">Label warna</span>
		                                            </td>
		                                            <td><?php echo $list[$i]->RISK_SOLVING; ?></td>
		                                        </tr>
		                                    <?php } ?> 
		                                <?php endif; ?> 
		                            </tbody>
		                        </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                	<a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $find->RKAP_SUBPRO_ID ?>" class="btn btn-danger btn-md" ><div class="fa fa-arrow-left"></div>Sub Program</a>
                                    <a class="btn btn-md btn-primary" target="_blank" href="<?php echo base_url() ?>risiko/cetakpdf/<?php echo $find->RKAP_SUBPRO_ID ?>" ><i class="fa fa-file-o"></i> Unduh pdf 
                                    </a>
                                </div>
                            </div>

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

