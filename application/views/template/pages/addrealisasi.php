<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link href="<?php echo base_url(); ?>assets/template/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<div class="page">
    <div class="page-content">
        <!-- BEGIN PAGE HEAD -->
        <!-- END PAGE HEAD -->


        <!-- BEGIN PAGE CONTENT INNER -->



        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>rkapinvestasi">RKAP Investasi
                    
                </a>
            </li>
            <?php if ($act == 'add'): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>">Sub Program RKAP Investasi</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?php echo base_url(); ?>realisasi/view/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>">Realisasi</a>
                </li>
            <?php else: ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $list->RKAP_SUBPRO_ID ?>">Sub Program RKAP Investasi</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?php echo base_url(); ?>realisasi/view/<?php echo $list->RKAP_SUBPRO_ID ?>">Realisasi</a>
                </li>
            <?php endif ?>          
            <li class="breadcrumb-item active">Form Realisasi Sub Program</li>
        </ol>

        <div class="headTab">
            <i class="icon md-laptop"></i> REALISASI SUB PROGRAM
        </div>

        <div class="panels">


        <div class="row">

            <div class="col-md-12 col-sm-12">
                <!-- BEGIN PORTLET-->
                <div class="portlet light">
                    <form  id="addrealisasi" class="form-horizontal" action="<?php echo ($act == 'add') ? base_url('realisasi/add/' . $row_subprogram->RKAP_SUBPRO_ID . '') : base_url('realisasi/update/' . $list->REAL_SUBPRO_ID . ''); ?>" method="post">
                        <input type="hidden" name="act" value="<?php echo $act ?>" id="act">
                        <input type="hidden" name="id" id="id" value="<?php echo $listrkap->RKAP_SUBPRO_ID ?>">
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
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group rows">
                                        <label class="ctrl-lbl col-sm-3">SUB RKAP INVESTASI</label>
                                        <div class="inputan col-sm-6">
                                            <input class="form-control" type="text" value="<?php echo ($act == 'add') ? $row_subprogram->RKAP_SUBPRO_TITTLE : $list->RKAP_SUBPRO_TITTLE ?>" name="judul_sub_program" data-validation="required" data-validation-error-msg="Judul sub program harus diisi" id="judul_sub_program" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group rows">
                                        <label class="ctrl-lbl col-sm-3">Jenis RKAP Investasi</label>
                                        <div class="inputan col-sm-3">
                                            <select name="jenis_sub_program" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih jenis sub program" id="jenis_sub_program" disabled="">
                                                <option value="">-- Pilih Jenis Sub Program --</option>

                                                <?php
                                                foreach ($groups as $row) {
                                                    if ($act == 'add') {
                                                        if ($row_subprogram->RKAP_SUBPRO_TYPE_ID == $row->SUBPRO_TYPE_ID) {

                                                            echo '<option selected value="' . $row->SUBPRO_TYPE_ID . '">' . $row->SUBPRO_TYPE_NAME . '</option>';
                                                        } else {

                                                            echo '<option value="' . $row->SUBPRO_TYPE_ID . '">' . $row->SUBPRO_TYPE_NAME . '</option>';
                                                        }
                                                    } else {
                                                        if ($list->SUBPRO_TYPE_ID == $row->SUBPRO_TYPE_ID) {

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
                                    <div class="form-group rows" >
                                        <label class="ctrl-lbl col-sm-3">Nilai Kontrak</label>
                                        <div class="inputan col-sm-3">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    Rp
                                                </div>
                                                <input class="form-control" type="text" name="nilai_kontrak" value="<?php echo ($act == 'add') ? number_format($row_subprogram->RKAP_SUBPRO_CONTRACT_VALUE, 2, ',', '.') : number_format($list->RKAP_SUBPRO_CONTRACT_VALUE, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="NIlai kontrak harus diisi" id="nilai_kontrak" disabled/>
                                            </div>                                      
                                        </div>
                                    </div>
                                    <div class="form-group rows" >
                                        <label class="ctrl-lbl col-sm-3">Jangka Waktu</label>
                                        <div class="inputan col-sm-3">
                                            <div class="input-group">

                                                <input class="form-control" type="text" name="jangka_waktu" value="<?php echo ($act == 'add') ? $row_subprogram->RKAP_SUBPRO_PERIODE : $list->RKAP_SUBPRO_PERIODE ?>" data-validation="required" data-validation-error-msg="Jangka waktu kontrak harus diisi" id="jangka_waktu" disabled/>

                                                <div class="input-group-addon">
                                                    Bulan
                                                </div>
                                            </div>                                      
                                        </div>
                                    </div>

                                    <div class="form-group rows">
                                        <!-- <div class="lbl-inpt col-sm-6" style="margin-bottom: 5px;"> -->
                                            <label class="lbl col-sm-3">Tanggal Mulai</label>
                                            <div class="bsbs col-sm-3 tglreal">

                                                <div class="input-group">

                                                    <input class="form-control" type="text" name="tgl_start" value="<?php echo ($act == 'add') ? date("d-m-Y", strtotime($row_subprogram->RKAP_SUBPRO_CONTRACT_DATE)) : date("d-m-Y", strtotime($list->RKAP_SUBPRO_CONTRACT_DATE)) ?>" data-validation="required" data-validation-error-msg="Tanggal mulai kontrak harus diisi" id="tgl_start" disabled/>

                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>

                                            </div>
                                        <!-- </div> -->
                                        <!-- <div class="lbl-inpt col-sm-6"> -->
                                            <label class="lbl_bsbs col-sm-3">Tanggal Akhir</label>
                                            <div class="bsbs col-sm-3">
                                                <div class="input-group">

                                                    <input class="form-control" type="text" name="tgl_end" value="<?php echo ($act == 'add') ? date("d-m-Y", strtotime($row_subprogram->RKAP_SUBPRO_END_REAL)) : date("d-m-Y", strtotime($list->RKAP_SUBPRO_END_REAL)) ?>" data-validation="required" data-validation-error-msg="Tanggal akhir waktu kontrak harus diisi" id="tgl_end" disabled/>

                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>                                      
                                            </div>
                                        <!-- </div> -->
                                    </div>

                                    <div class="form-group rows" >
                                        <label class="ctrl-lbl col-sm-3">Bulan Pelaporan Sebelumnya</label>
                                        <div class="inputan col-sm-3">
                                            <div class="input-group">
                                                <?php if ($cek == null): ?>
                                                    <input class="form-control" type="text" value="" name="bln_pelaporan_sebelumnya" id="bln_pelaporan_sebelumnya" disabled/>
                                                <?php else: ?>
                                                    <?php if ($list3['REAL_SUBPRO_DATE'] == ''): ?>
                                                        <input class="form-control" type="text" value="" name="bln_pelaporan_sebelumnya" id="bln_pelaporan_sebelumnya" disabled/>
                                                    <?php else: ?>
                                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? date("m-Y", strtotime($list4->REAL_SUBPRO_DATE)) : date("m-Y", strtotime($list3['REAL_SUBPRO_DATE'])) ?>" name="bln_pelaporan_sebelumnya" id="bln_pelaporan_sebelumnya" disabled/>
                                                    <?php endif ?>
                                                <?php endif ?>


                                                <div class="input-group-addon">
                                                    <span class="fa fa-calendar"></span>
                                                </div>
                                            </div>                                      
                                        </div>
                                    </div>

                                    <div class="form-group rows" style="display: none;">
                                        <label class="ctrl-lbl col-sm-3">Jangka Waktu pelaporan</label>
                                        <div class="inputan col-sm-3">
                                            <div class="input-group">

                                                <input class="form-control" type="text" name="jangka_waktu_pelaporan" value="1" data-validation="required" data-validation-error-msg="Jangka waktu kontrak harus diisi" id="jangka_waktu_pelaporan<?php echo $listrkap->RKAP_SUBPRO_ID ?>" disabled/>

                                                <div class="input-group-addon">
                                                    Bulan
                                                </div>
                                            </div>                                      
                                        </div>
                                    </div>

                                    <div class="form-group rows">
                                        <label class="ctrl-lbl col-sm-3">Bulan Pelaporan</label>
                                        <div class="inputan col-sm-3">
                                            <div class="form-group" style="margin: 0;">

                                                <div class='input-group'>
                                                    <?php if ($act == 'add'): ?>
                                                        <input type="text" class="form-control date-picker" value=""  name="bln_pelaporan" id="bln_pelaporan" onchange="check_date()"/>
                                                    <?php elseif ($act == 'edit'): ?>
                                                        <input type="text" class="form-control date-picker" value="<?php echo ($list->REAL_SUBPRO_DATE == null) ? '' : date("m-Y", strtotime($list->REAL_SUBPRO_DATE)) ?>"  name="bln_pelaporan" id="bln_pelaporan" onchange="check_date()"/>
                                                    <?php elseif ($act == 'detail'): ?>
                                                        <!-- <?php echo date("m-Y", strtotime($list->REAL_SUBPRO_DATE)); ?> -->
                                                        <input type="text" class="form-control date-picker" value="<?php echo ($list->REAL_SUBPRO_DATE == null) ? '' : date("m-Y", strtotime($list->REAL_SUBPRO_DATE)) ?>" name="bln_pelaporan" id="bln_pelaporan" onchange="check_date()"/>
                                                    <?php endif ?>
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="persen_select" id="persen_select" value="<?php echo ($act == 'add') ? $persen_tot_val : $persen_select ?>">
                                    <input type="hidden" name="realisasi_persen_tot" id="realisasi_persen_tot" value="<?php echo ($act == 'add') ? $persen_tot_val : $persen_select ?>">
                                    <div class="form-group rows">
                                        <!-- <div class="lbl-inpt col-sm-6"> -->
                                            <label class="lbl col-sm-3">Persen bulan pelaporan yang telah ada</label>
                                            <div class="penil col-sm-3">
                                                <div class="row">
                                                    <div class="main_penil ">
                                                        <div class= persen">
                                                            <div class="input-group">
                                                                <?php if ($cek == null): ?>
                                                                    <input class="form-control col-sm-4" type="text" value="<?php echo ($act == 'add') ? $persen_tot_val : $persen_select ?>" name="persen_tot_sebelum" id="persen_tot_sebelum" disabled/>
                                                                <?php else: ?>
                                                                    <?php if ($list3['REAL_SUBPRO_PERCENT'] == ''): ?>
                                                                        <input class="form-control col-sm-4" type="text" value="<?php echo ($act == 'add') ? $persen_tot_val : $persen_select ?>" name="persen_tot_sebelum" id="persen_tot_sebelum" disabled/>
                                                                    <?php else: ?>
                                                                        <input class="form-control col-sm-4" type="text" value="<?php echo ($act == 'add') ? $persen_tot_val : $persen_select ?>" name="persen_tot_sebelum" id="persen_tot_sebelum" disabled/>
                                                                    <?php endif ?>
                                                                <?php endif ?>


                                                                <div class="input-group-addon">
                                                                    %
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        <!-- </div> -->
                                    </div>

                                    <div class="form-group rows">
                                        <!-- <div class="lbl-inpt col-sm-6"> -->
                                            <label class="ctrl-lbl col-sm-2">Realisasi s/d Bulan Sebelumnya</label>
                                            <!-- <div class="penil col-sm-3 rows"> -->
                                                <!-- <div class="rows"> -->
                                                    <!-- <div class="main_penil col-sm-12"> -->
                                                        <div class="col-sm-2">
                                                            <div class="input-group">
                                                                <?php if ($cek == null): ?>
                                                                    <input class="form-control" type="text" value="" name="realisasi_persen_sebelumnya" id="realisasi_persen_sebelumnya" disabled/>
                                                                    <input class="form-control" type="hidden" value="" name="persen_total" id="persen_total" disabled/>
                                                                <?php else: ?>
                                                                    <?php if ($list3['REAL_SUBPRO_PERCENT'] == ''): ?>
                                                                        <input class="form-control" type="text" value="" name="realisasi_persen_sebelumnya" id="realisasi_persen_sebelumnya" disabled/>
                                                                        <input class="form-control" type="hidden" value="" name="persen_total" id="persen_total" disabled/>
                                                                    <?php else: ?>
                                                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? $list4->REAL_SUBPRO_PERCENT : $list3['REAL_SUBPRO_PERCENT'] ?>" name="realisasi_persen_sebelumnya" id="realisasi_persen_sebelumnya" disabled/>
                                                                        <input class="form-control" type="hidden" value="<?php echo ($act == 'add') ? $list4->REAL_SUBPRO_PERCENT_TOT: $list3['REAL_SUBPRO_PERCENT_TOT'] ?>" name="persen_total" id="persen_total" disabled/>
                                                                    <?php endif ?>
                                                                <?php endif ?>


                                                                <div class="input-group-addon">
                                                                    %
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-3 nilai">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    Rp
                                                                </div>
                                                                <?php if ($cek == null): ?>
                                                                    <input class="form-control" type="text" value="" name="realisasi_value_sebelumnya" id="realisasi_value_sebelumnya" disabled/>
                                                                <?php else: ?>
                                                                    <?php if ($list3['REAL_SUBPRO_VAL'] == ''): ?>
                                                                        <input class="form-control" type="text" value="" name="realisasi_value_sebelumnya" id="realisasi_value_sebelumnya" disabled/>
                                                                    <?php else: ?>
                                                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? number_format($list4->REAL_SUBPRO_VAL, 2, ',', '.') : number_format($list3['REAL_SUBPRO_VAL'], 2, ',', '.') ?>" name="realisasi_value_sebelumnya" id="realisasi_value_sebelumnya" disabled/>
                                                                    <?php endif ?>
                                                                <?php endif ?>
                                                            </div>
                                                        </div>
                                                    <!-- </div> -->
                                                <!-- </div> -->
                                            <!-- </div> -->
                                        <!-- </div> -->
                                        <!-- <div class="lbl-inpt col-sm-6"> -->
                                            <label class="ctrl-lbl col-sm-2">Biaya s/d Bulan Sebelumnya</label>
                                            <div class="bsbs col-sm-3">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php if ($cek == null): ?>
                                                        <input class="form-control" type="text" value="" name="realisasi_biaya_sebelumnya" id="realisasi_biaya_sebelumnya" disabled/>
                                                    <?php else: ?>
                                                        <?php if ($list3['REAL_SUBPRO_COST'] == ''): ?>
                                                            <input class="form-control" type="text" value="" name="realisasi_biaya_sebelumnya" id="realisasi_biaya_sebelumnya" disabled/>
                                                        <?php else: ?>
                                                            <input class="form-control" type="text" value="<?php echo ($act == 'add') ? number_format($list4->REAL_SUBPRO_COST, 2, ',', '.') : number_format($list3['REAL_SUBPRO_COST'], 2, ',', '.') ?>" name="realisasi_biaya_sebelumnya" id="realisasi_biaya_sebelumnya" disabled/>
                                                        <?php endif ?>
                                                    <?php endif ?>


                                                </div>                                      
                                            </div>
                                        <!-- </div> -->
                                    </div>

                                    <div class="form-group rows">
                                        <!-- <div class="lbl-inpt col-sm-6"> -->
                                            <label class="ctrl-lbl col-sm-2">Realisasi Bln Pelaporan</label>
                                            <!-- <div class="penil col-sm-5 rows"> -->
                                                <!-- <div class="row"> -->
                                                    <!-- <div class="main_penil col-sm-12"> -->
                                                        <div class="col-sm-2">
                                                            <div class="input-group">
                                                                <?php  if ($act == 'add'): ?>
                                                                <input class="form-control" type="text" value=" " name="realisasi_persen_pelaporan" id="realisasi_persen_pelaporan"  data-validation="required" data-validation-error-msg="Persen bulan pelaporan harus diisi" onchange ="pelaporan()"/>
                                                                <?php else: ?>
                                                                <input class="form-control" type="text" value="<?php echo $list->REAL_SUBPRO_PERCENT ?>" name="realisasi_persen_pelaporan" id="realisasi_persen_pelaporan"  data-validation="required" data-validation-error-msg="Persen bulan pelaporan harus diisi" onchange ="pelaporan_edit()"/>
                                                                <?php endif ?>
                                                                <div class="input-group-addon">
                                                                    %
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    Rp
                                                                </div>

                                                                <input class="form-control" type="text" value="<?php echo ($act == 'add') ? '' : number_format($list->REAL_SUBPRO_VAL, 2, ',', '.') ?>" id="realisasi_value_pelaporan" readonly/>
                                                                <input class="form-control" type="hidden" value="<?php echo ($act == 'add') ? '' : $list->REAL_SUBPRO_VAL ?>" name="realisasi_value_pelaporan" id="realisasi_value_pelaporan2" readonly/>
                                                            </div>
                                                        </div>
                                                    <!-- </div> -->
                                                <!-- </div> -->
                                            <!-- </div> -->
                                        <!-- </div> -->
                                        <!-- <div class="lbl-inpt col-sm-6"> -->
                                            <label class="ctrl-lbl col-sm-2">Biaya Bulan Pelaporan</label>
                                            <div class="bsbs col-sm-3">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <input class="form-control" type="text" name="realisasi_biaya_pelaporan" value="<?php echo ($act == 'add') ? '' : number_format($list->REAL_SUBPRO_COST, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Biaya bulan pelaporan harus diisi" id="realisasi_biaya_pelaporan"/>
                                                </div>                                      
                                            </div>
                                        <!-- </div> -->
                                    </div>

                                    <div class="form-group rows">
                                        <div class="lbl-inpt col-sm-6">
                                            <div class="form-group rows">
                                                <label class="ctrl-lbl col-sm-4">Status</label>
                                                <div class="spkd col-sm-8">
                                                    <select name="status" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih status" id="status">
                                                        <option value="">-- Pilih Status --</option>

                                                        <?php
                                                        foreach ($groups2 as $row) {
                                                            if ($act == 'add') {
                                                                echo '<option value="' . $row->STATUS_ID . '">' . $row->STATUS_NAME . '</option>';
                                                            } else {
                                                                if ($list->REAL_SUBPRO_STATUS == $row->STATUS_ID) {

                                                                    echo '<option selected value="' . $row->STATUS_ID . '">' . $row->STATUS_NAME . '</option>';
                                                                } else {

                                                                    echo '<option value="' . $row->STATUS_ID . '">' . $row->STATUS_NAME . '</option>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group rows" >
                                                <label class="ctrl-lbl col-sm-4">Kendala</label>
                                                <div class="spkd col-sm-8">
                                                    <select name="kendala" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih kendala" id="kendala" onchange="cek_kendala()">
                                                        <option value="">-- Pilih Kendala --</option>

                                                        <?php
                                                        foreach ($groups4 as $row) {
                                                            if ($act == 'add') {
                                                                echo '<option value="' . $row->CONTRAINTS_ID . '">' . $row->CONTRAINTS_NAME . '</option>';
                                                            } else {
                                                                if ($list->REAL_SUBPRO_CONSTRAINTS == $row->CONTRAINTS_ID) {

                                                                    echo '<option selected value="' . $row->CONTRAINTS_ID . '">' . $row->CONTRAINTS_NAME . '</option>';
                                                                } else {

                                                                    echo '<option value="' . $row->CONTRAINTS_ID . '">' . $row->CONTRAINTS_NAME . '</option>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if ($act == 'add'): ?>
                                                <div class="form-group rows">
                                                    <label class="ctrl-lbl col-sm-6">Deadline penyelesaian kendala</label>
                                                    <div class="spkd col-sm-6">
                                                        <div class="form-group" style="margin: 0;">
                                                            <div class='input-group'>
                                                                <input type="text" class="form-control date-picker"  value="" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="tgl_deadline" id="tgl_deadline"/>
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>                                  
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="form-group rows">
                                                    <label class="ctrl-lbl col-sm-6">Deadline penyelesaian kendala</label>
                                                    <div class="spkd col-sm-6">
                                                        <div class="form-group" style="margin: 0;">
                                                            <div class='input-group'>
                                                                <input type="text" class="form-control date-picker" data-plugin="datepicker" value="<?php echo ($list->REAL_SUBPRO_DEADLINE == null) ? '' : date("d-m-Y", strtotime($list->REAL_SUBPRO_DEADLINE)) ?>" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="tgl_deadline" id="tgl_deadline"/>
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>                                  
                                                    </div>
                                                </div>
                                            <?php endif ?>

                                        </div>
                                        <div class="cttn col-sm-6">
                                            <div class="addendum">
                                                <fieldset style="border: 1px solid #e5e5e5; border-radius: 3px; color: #666666;">
                                                    <legend style="font-size: 12px; border-radius: 3px; border: 1px solid #e5e5e5; padding: 3px 8px; margin: 10px 0 0 7px; width: auto; color: #666666;">Catatan</legend>
                                                    <div class="kurva col-sm-12">
                                                        <textarea class="form-control" rows="5" name="catatan" data-validation="required" data-validation-error-msg="Catatan harus diisi" id="catatan"><?php echo ($act == 'add') ? '' : $list->REAL_SUBPRO_COMMENT ?></textarea>

                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="btnsave col-md-6 col-sm-6">
                                    <div class="form-action">
                                        <?php if ($act == 'add'): ?>
                                            <?php if ($cek == null): ?>
                                                <button type="submit" class="btn btn-success uppercase btnnn addsavreal" id="button-add"><div class="fa fa-save"></div> SAVE</button>&nbsp;
                                                <button type="submit" class="btn btn-info uppercase btnnn addsavreal" id="button-edit"><div class="fa fa-gears" onclick="pelaporan_edit()"></div> Ubah</button>&nbsp;
                                            <?php else: ?>
                                                <?php if ($list4->REAL_SUBPRO_PERCENT == '100'): ?>
                                                    <small><p style="color:#f04014"> * Realisasi sebelumnya telah mencapai 100%</p></small>
                                                    <button type="submit" class="btn btn-success uppercase btnnn addsavreal" id="button-add" disabled><div class="fa fa-save"></div> SAVE</button>&nbsp;
                                                    <button type="submit" class="btn btn-info uppercase btnnn addsavreal" id="button-edit" disabled><div class="fa fa-gears" onclick="pelaporan_edit()"></div> Ubah</button>&nbsp;
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-success uppercase btnnn addsavreal" id="button-add"><div class="fa fa-save"></div> Simpan</button>&nbsp;
                                                    <button type="submit" class="btn btn-info uppercase btnnn addsavreal" id="button-edit"><div class="fa fa-gears" onclick="pelaporan_edit()"></div> Ubah</button>&nbsp;
                                                <?php endif ?>
                                            <?php endif ?>

                                        <?php else: ?>
                                            <?php if ($list3['REAL_SUBPRO_PERCENT'] == '100'): ?>
                                                <small><p style="color:#f04014"> * Realisasi sebelumnya telah mencapai 100%</p></small>
                                                <button type="submit" class="btn btn-success uppercase btnnn addsavreal"  id="button-add" disabled><div class="fa fa-save"></div> Simpan</button>&nbsp;
                                                <button type="submit" class="btn btn-info uppercase btnnn addsavreal" id="button-edit" disabled><div class="fa fa-gears" onclick="pelaporan_edit()"></div> Ubah</button>&nbsp;
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-success uppercase btnnn addsavreal" id="button-add"><div class="fa fa-save"></div> SAVE</button>&nbsp;
                                                <button type="submit" class="btn btn-info uppercase btnnn addsavreal" id="button-edit"><div class="fa fa-pencil" onclick="pelaporan_edit()"></div> Ubah</button>&nbsp;
                                            <?php endif ?>

                                        <?php endif ?>

                                        <?php if ($act == 'add'): ?>
                                            <a href="<?php echo base_url(); ?>realisasi/view/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-default uppercase btnnn addsavreal" ><div class="fa fa-ban"></div> Batal</a>&nbsp;
                                            <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>
                                        <?php else: ?>
                                            <a href="<?php echo base_url(); ?>realisasi/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-default uppercase btnnn addsavreal" ><div class="fa fa-ban"></div> Batal</a>&nbsp;
                                            <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-danger uppercase" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogam</a>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="mot col-md-6 col-sm-6 text-right">

                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
                <!-- END PORTLET-->
            </div>
          </div>
       </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Notification</h4>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin ingin menambahkan data ini ?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success uppercase"> Ya</button>&nbsp;
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
            </div>
        </div>

    </div>
</div>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/template/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/index3.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/datatables/plugins/bootstrap/jquery.dataTables.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/table-advanced.js"></script>
<script src="<?php echo base_url(); ?>assets/form-validator/jquery.form-validator.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/components-pickers.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/select2-master/dist/js/select2.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/autocomplete/jquery.easy-autocomplete.min.js"></script>
<script type="text/javascript">
     var act = $('#act').val();
    // alert(act);

    if (act == 'add') {
         function pelaporan() {
            // alert('aaa');
            var persen_pelaporan = $("#realisasi_persen_pelaporan").val();
            var persen_tot_belum = $("#persen_tot_sebelum").val();
            // alert(persen_tot_belum)
            var contract_val = $("#nilai_kontrak").val();
            var contract_str_set = contract_val.replace(/\./g, '');
            var contract_str_set_dua = contract_str_set.replace(/\,/g, '.');
            var contract_str = contract_str_set_dua;

            var rupiah_persen_set = persen_pelaporan.replace(/\./g, '');
            var rupiah_persen_set_dua = rupiah_persen_set.replace(/\,/g, '.');
            var rupiah_persen = contract_str / 100;
            // alert(rupiah_persen); 
            var tot_persen_set = persen_tot_belum.replace(",", "");
            var tot_persen_set_dua = tot_persen_set.replace(/\,/g, '.');
           // alert(tot_persen_set);
            var persen_lapor_parse = parseFloat(rupiah_persen_set_dua);
            var persen_tot_belum_parse = parseFloat(tot_persen_set_dua);

            var persen_tot = persen_lapor_parse + persen_tot_belum_parse;
            // alert(persen_tot_belum_parse)

            var persen_tot_parse = parseFloat(persen_tot);
            // alert(persen_tot_parse);

            var number = persen_pelaporan.replace(".",",");
            // alert(number)

            if (persen_tot > 100) {
                alert('jumlah persen bulan pelaporan dan persen bulan pelaporan yang telah ada tidak boleh lebih dari 100 %');
                $("#realisasi_persen_pelaporan").val('');
            } else {
                $("#realisasi_persen_tot").val(persen_tot_parse);
            }

            //alert(rupiah_persen);
           
            // alert(contract_str);
            var value_pelaporan_set = rupiah_persen * rupiah_persen_set_dua;
            var value_pelaporan = parseFloat(value_pelaporan_set);
            // alert(value_pelaporan_set);
            $("#realisasi_value_pelaporan").val(value_pelaporan);
            $("#realisasi_value_pelaporan2").val(value_pelaporan);

        }
    }
    else if (act == 'edit') {
        function pelaporan_edit() {
            var persen_pelaporan = $("#realisasi_persen_pelaporan").val();
            var persen_tot_belum = $("#persen_select").val();
            var persen_total_sebelum = $("#persen_total").val();
            var persen_tot_belum = $("#persen_tot_sebelum").val();
            var cek_realisasi_sebelum = $("#realisasi_persen_sebelumnya").val();
            // alert(persen_tot_belum)

            var contract_val = $("#nilai_kontrak").val();
            var contract_str_set = contract_val.replace(/\./g, '');
            var contract_str_set_dua = contract_str_set.replace(/\,/g, '.');
            var contract_str = contract_str_set_dua;
            
            // alert(persen_pelaporan);
            var rupiah_persen_set = persen_pelaporan.replace(/\./g, '');
            var rupiah_persen_set_dua = rupiah_persen_set.replace(/\,/g, '.');
            var rupiah_persen = contract_str / 100;
            
            var tot_persen_set = persen_tot_belum.replace(",", "");
            var tot_persen_set_dua = tot_persen_set.replace(/\,/g, '.');

            var persen_total_sebelum_set = persen_total_sebelum.replace(/\./g, '');
            var persen_total_sebelum_set_dua = persen_total_sebelum_set.replace(/\,/g, '.');

            var cek_sebelum_set = cek_realisasi_sebelum.replace(/\./g, '');
            var cek_sebelum_set_dua = cek_sebelum_set.replace(/\,/g, '.');
           // alert(cek_sebelum_set_dua);
            var persen_lapor_parse = parseFloat(rupiah_persen_set_dua);
            var persen_tot_belum_parse = parseFloat(tot_persen_set_dua);
            var cek_sebelum_parse = parseFloat(cek_sebelum_set_dua);
            var persen_total_sebelum_parse = parseFloat(persen_total_sebelum_set_dua);

            var persen_with_sebelum = persen_lapor_parse + persen_total_sebelum_parse;
            var persen_tot = persen_lapor_parse + persen_tot_belum_parse;
            // alert(persen_tot)

            var persen_tot_parse = parseFloat(persen_tot);
            var sebelum_parse = parseFloat(persen_with_sebelum);
            // alert(persen_lapor_parse);
            if (persen_tot > 100) {
                alert('jumlah persen bulan pelaporan tidak boleh lebih dari 100 %');
                $("#realisasi_persen_pelaporan").val('');
            } else {
                if(cek_realisasi_sebelum != ''){
                    // alert('not null');
                    $("#realisasi_persen_tot").val(sebelum_parse);
                }else{
                    // alert('null');
                    $("#realisasi_persen_tot").val(persen_lapor_parse);
                }
                
            }

            //alert(rupiah_persen);
            
            //alert(contract_str);
            var value_pelaporan_set = rupiah_persen * rupiah_persen_set_dua;
            var value_pelaporan = parseFloat(value_pelaporan_set);
            // alert(value_pelaporan);
            $("#realisasi_value_pelaporan").val(value_pelaporan);
            $("#realisasi_value_pelaporan2").val(value_pelaporan);

        }
    }
   
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $("#bln_pelaporan").datepicker(
                {
                    format: "mm-yyyy",
                    viewMode: "months",
                    minViewMode: "months"
                });
    });
</script>

<script type="text/javascript">

    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('realisasi_biaya_pelaporan');
    tanpa_rupiah.addEventListener('keyup', function (e)
    {
        tanpa_rupiah.value = formatRupiah(this.value);
    });



    /* Fungsi */
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>

<script type="text/javascript">

    function cek_kendala() {

        var kendala_val = $('#kendala').val();

        if (kendala_val == 1) {

            $("#tgl_deadline").removeAttr('required');

        } else {
            $("#tgl_deadline").attr('required', 'required');
        }

        // alert(kendala_val);
    }

</script>

<script type="text/javascript">

     var act = $('#act').val();
    // alert(act);

    if (act == 'add') {
        $(window).load(function () {
            var id = document.getElementById('id').value;
            //alert(id);
            var jangka = document.getElementById('jangka_waktu_pelaporan' + id).value;
            //alert(jangka);
            var jarak = parseInt(jangka);
            var startdate = $('#bln_pelaporan_sebelumnya').val();
            var newstartdate = startdate.split("-").reverse().join("-");

            var myDate = new Date(newstartdate);

            var result1 = myDate.addMonths(jarak);
            var datebaru = new Date(result1);
            var dateIndex = datebaru.getDate();
            var monthIndex = datebaru.getMonth() + 1;
            var yearIndex = datebaru.getFullYear();

            var lengkapset = monthIndex + '-' + yearIndex;

            document.getElementById('bln_pelaporan').value = lengkapset;

            //tgl mulai jika bulan pelaporan kosong
            var pelaporan_sblm = $('#bln_pelaporan_sebelumnya').val();
            var newdate4 = pelaporan_sblm.split("-").reverse().join("-");

            var tgl_mulai = $('#tgl_start').val();
            var newdatemulai = tgl_mulai.split("-").reverse().join("-");

            //tgl nulai
            var g = new Date(newdatemulai);

            var months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
            var monthIndexmulai = g.getMonth() + 2;
            var yearIndexmulai = g.getFullYear();
            var yearmonthmulai = (monthIndexmulai <= 9 ? '0' + monthIndexmulai : monthIndexmulai) + '-' + yearIndexmulai;

            if (pelaporan_sblm == 0) {
                $("#bln_pelaporan").val(yearmonthmulai);
            }
        });

        Date.isLeapYear = function (year) {
            return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
        };

        Date.getDaysInMonth = function (year, month) {
            return [31, (Date.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
        };

        Date.prototype.isLeapYear = function () {
            return Date.isLeapYear(this.getFullYear());
        };

        Date.prototype.getDaysInMonth = function () {
            return Date.getDaysInMonth(this.getFullYear(), this.getMonth());
        };

        Date.prototype.addMonths = function (value) {
            var n = this.getDate();
            this.setDate(1);
            this.setMonth(this.getMonth() + value);
            this.setDate(Math.min(n, this.getDaysInMonth()));
            return this;
        };
    } 
        else if (act == 'detail') {
            $("#bln_pelaporan").val();
    } 
        else if (act == 'edit') {
            $("#bln_pelaporan").val();
    }


    
</script>
<script type="text/javascript">

    function check_date() {
        var tanggal_mulai   = $('#tgl_start').val();
        var tanggal_akhir   = $('#tgl_end').val();
        var bln_pelaporan   = $('#bln_pelaporan').val();
        var bln_plp_sblmnya = $('#bln_pelaporan_sebelumnya').val();

        var newdate_mulai       = tanggal_mulai.split("-").reverse().join("-");        
        var newdate_akhir       = tanggal_akhir.split("-").reverse().join("-");
        var newdate_plp         = bln_pelaporan.split("-").reverse().join("-");
        var newdate_plp_sblmnya = bln_plp_sblmnya.split("-").reverse().join("-");

        // get mulai
        var _tglMulai       = new Date(newdate_mulai); 
        var getBlnMulai     = _tglMulai.getMonth() + 1;
        var getThnMulai     = _tglMulai.getFullYear();

        // get akhir
        var _tglAkhir       = new Date(newdate_akhir); 
        var getBlnAkhir     = _tglAkhir.getMonth() + 1;
        var getThnAkhir     = _tglAkhir.getFullYear();

        // get bulan pelaporan
        var _tglPlp       = new Date(newdate_plp); 
        var getBlnPlp     = _tglPlp.getMonth() + 1;
        var getThnPlp     = _tglPlp.getFullYear();

        // get  pelaporan sebelumnya
        var _tglPlpSblmnya      = new Date(newdate_plp_sblmnya); 
        var getBlnPlpSblmnya    = _tglPlpSblmnya.getMonth() + 1;
        var getThnPlpSblmnya    = _tglPlpSblmnya.getFullYear();
        
        if (getThnPlp > getThnAkhir) {
            alert('Tahun pelaporan tidak boleh lebih dari tanggal akhir !');
            $("#bln_pelaporan").val('');
        } else if (getThnPlp < getThnMulai) {
            alert('Tahun pelaporan tidak boleh kurang dari tanggal mulai !');
            $("#bln_pelaporan").val('');
        } else if (getBlnPlp <= getBlnPlpSblmnya && getThnPlp <= getThnPlpSblmnya) {
            alert('Bulan pelaporan tidak boleh kurang sama dengan dari pelaporan sebelumnya !');
            $("#bln_pelaporan").val('');
        } else if (getThnPlp >= getThnMulai && getThnPlp <= getThnAkhir) {
            if (getBlnPlp < getBlnMulai && getThnPlp == getThnMulai) {
                alert('Bulan pelaporan tidak boleh kurang dari tanggal mulai !');
                $("#bln_pelaporan").val('');
            } else if (getBlnPlp > getBlnAkhir && getThnPlp == getThnAkhir) {
                alert('Bulan pelaporan tidak boleh lebih dari tanggal akhir !');
                $("#bln_pelaporan").val('');
            }
        }

    }

    function formatDate(date) {
        var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

</script> 