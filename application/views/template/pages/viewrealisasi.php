<style type="text/css">
    .table > thead > tr > th {
        vertical-align: bottom;
        background-color: #F9AC36 !important;
        border: 1px solid #ddd;
        color:#FFF;
        text-align: center;
    }

    .table > tbody > tr > td {
        border: 1px solid #ddd;
    }
    .breadcrumb-right-arrow .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        vertical-align:top;
        font-size:40px;
        line-height:15px;
        /*line*/
    }
    .breadcrumb >li :hover {

    }
    .styleforp1 {
        font-weight: bold;
    }
</style>
<div class="page">
    <div class="page-content">

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item"> <a href="<?php echo base_url(); ?>rkapinvestasi">RKAP Investasi</a></li>
            <li class="breadcrumb-item"> <a href="<?php echo base_url('subprogramrkapinvestasi/view/') . $row_subprogram->RKAP_SUBPRO_INVS_ID; ?>">List Sub Program</a></li>            
            <li class="breadcrumb-item"> <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>">Detail Sub Program</a></li>
            <li class="breadcrumb-item active">List Realisasi Sub Program</li>
        </ol>
        <!-- BEGIN PAGE HEAD -->
        <div class="headTab">
            <i class="icon md-laptop"></i> REALISASI SUB PROGRAM
        </div>
        <!-- END PAGE HEAD -->

        <!-- BEGIN PAGE CONTENT INNER -->

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
                <div class="form-actions" align="right">

                    <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                        <a href="<?php echo base_url(); ?>risiko/view_risiko/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-warning btn-round" id="button-monitoring"><div class="fa fa-eye"></div> Monitoring Risiko</a>
                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-danger btn-round" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>

                    <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                        <a href="<?php echo base_url(); ?>risiko/view_risiko/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-warning btn-round" id="button-monitoring"><div class="fa fa-eye"></div> Monitoring Risiko</a>

                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-danger btn-round" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>

                    <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>

                        <a href="<?php echo base_url(); ?>risiko/view_risiko/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-warning btn-round" id="button-monitoring"><div class="fa fa-eye"></div> Monitoring Risiko</a>
                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-danger btn-round" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>

                    <?php else: ?>



                        <a href="<?php echo base_url(); ?>realisasi/add/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-success btn-round" ><div class="fa fa-plus"></div> Tambah</a>
                        <a href="<?php echo base_url(); ?>risiko/view_risiko/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-warning btn-round" id="button-monitoring"><div class="fa fa-eye"></div> Monitoring Risiko</a>


                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/detail/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-danger btn-round" id="button-back"><div class="fa fa-arrow-left"></div> Ke Subprogram</a>
                    <?php endif ?>

                </div>
                <br/>

                <div class="portlet light">

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

                    <div class="form-group col-lg-12 col-md-12" style="margin-bottom: 30px;">
                        <div class="row">
                            <form  role="form" action="<?php echo base_url(); ?>realisasi/view/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" method="post">
                                <fieldset style="border: 1px solid #e5e5e5; border-radius: 3px; color: #666666;">
                                    <legend style="font-size: 12px; border-radius: 3px; border: 1px solid #e5e5e5; padding: 3px 8px; margin: 10px 0 0 7px; width: auto; color: #666666;">Pencarian</legend>
                                    <div class="kurva col-sm-12">
                                        <?php
                                        if ($this->session->flashdata('title')):
                                            $title = $this->session->flashdata('title');
                                        else :
                                            $title = "";
                                        endif
                                        ?>
                                        <div class="form-group" style="margin-top: 10px;">
                                            <div class="rows">
                                                <label class="control-label col-lg-3">
                                                    <i class="icon md-calendar"></i> &nbsp;
                                                    Judul Investasi
                                                </label>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 styleforp1">
                                                    <?php echo ucfirst($find->RKAP_INVS_TITLE); ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-top: 10px;">
                                            <div class="rows">
                                                <label class="control-label col-lg-3">
                                                    <i class="icon md-calendar"></i> &nbsp;
                                                    Judu Sub Program
                                                </label>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 styleforp1">
                                                    <?php echo ucfirst($find->RKAP_SUBPRO_TITTLE); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-top: 10px;">
                                            <div class="rows">
                                                <label class="control-label col-lg-3">
                                                    <i class="icon md-calendar"></i> &nbsp;
                                                    No Kontrak
                                                </label>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 styleforp1">
                                                    <?php echo $find->RKAP_SUBPRO_CONTRACT_NO; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-top: 10px;">
                                            <div class="rows">
                                                <?php
                                                if ($this->session->flashdata('type')):
                                                    $type = $this->session->flashdata('type');
                                                else :
                                                    $type = "";
                                                endif
                                                ?>
                                                <label class="control-label col-lg-3">
                                                    <i class="icon md-calendar"></i> &nbsp;
                                                    Jenis
                                                </label>
                                                <div class="col-lg-3">
                                                    <select name="type" class="form-control">
                                                        <option value="">-- Pilih Jenis --</option>
                                                        <?php
                                                        foreach ($groups as $row) {
                                                            if ($row->SUBPRO_TYPE_NAME == $type) {
                                                                echo '<option selected value="' . $row->SUBPRO_TYPE_NAME . '">' . $row->SUBPRO_TYPE_NAME . '</option>';
                                                            } else {
                                                                echo '<option value="' . $row->SUBPRO_TYPE_NAME . '">' . $row->SUBPRO_TYPE_NAME . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
<?php
if ($this->session->flashdata('status')):
    $status = $this->session->flashdata('status');
else :
    $status = "";
endif
?>
                                                <label class="control-label col-lg-2">
                                                    <i class="icon md-calendar"></i> &nbsp;
                                                    Status
                                                </label>
                                                <div class="col-lg-3">
                                                    <select name="status" class="form-control">
                                                        <option value="">-- Pilih Status --</option>
<?php
foreach ($groups2 as $row) {
    if ($row->STATUS_NAME == $status) {
        echo '<option selected value="' . $row->STATUS_NAME . '">' . $row->STATUS_NAME . '</option>';
    } else {
        echo '<option value="' . $row->STATUS_NAME . '">' . $row->STATUS_NAME . '</option>';
    }
}
?>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-top: 10px;">
                                            <div class="rows">
<?php
if ($this->session->flashdata('kendala')):
    $kendala = $this->session->flashdata('kendala');
else :
    $kendala = "";
endif
?>
                                                <label class="control-label col-lg-3">
                                                    <i class="icon md-calendar"></i> &nbsp;
                                                    Kendala
                                                </label>
                                                <div class="col-lg-3">
                                                    <select name="kendala" class="form-control">
                                                        <option value="">-- Pilih Kendala --</option>
<?php
foreach ($groups4 as $row) {
    if ($row->CONTRAINTS_NAME == $kendala) {
        echo '<option selected value="' . $row->CONTRAINTS_NAME . '">' . $row->CONTRAINTS_NAME . '</option>';
    } else {
        echo '<option value="' . $row->CONTRAINTS_NAME . '">' . $row->CONTRAINTS_NAME . '</option>';
    }
}
?>
                                                    </select>
                                                </div>
                                                        <?php
                                                        if ($this->session->flashdata('month')):
                                                            $month = $this->session->flashdata('month');
                                                        else :
                                                            $month = "";
                                                        endif
                                                        ?>
                                                <label class="control-label col-lg-2">
                                                    <i class="icon md-calendar"></i> &nbsp;
                                                    Bulan
                                                </label>
                                                <div class="col-lg-3">
                                                    <select name="month" class="form-control">
                                                        <option value="">-- Pilih Bulan --</option>
<?php
foreach ($groups5 as $row) {
    if ($row->MONTH_ID == $month) {
        echo '<option selected value="' . $row->MONTH_ID . '">' . $row->MONTH_NAME . '</option>';
    } else {
        echo '<option value="' . $row->MONTH_ID . '">' . $row->MONTH_NAME . '</option>';
    }
}
?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-top: 10px;">
                                            <div class="rows">
                                                        <?php
                                                        if ($this->session->flashdata('years')):
                                                            $years = $this->session->flashdata('years');
                                                        else :
                                                            $years = "";
                                                        endif
                                                        ?>
                                                <label class="control-label col-lg-3">
                                                    <i class="icon md-calendar"></i> &nbsp;
                                                    Tahun
                                                </label>
                                                <div class="col-lg-3">
                                                    <select name="years" class="form-control">
                                                        <option value="">-- Pilih Tahun --</option>
                                                <?php
                                                foreach ($groups6 as $row) {
                                                    if ($row->YEARS_NAME == $years) {
                                                        echo '<option selected value="' . $row->YEARS_NAME . '">' . $row->YEARS_NAME . '</option>';
                                                    } else {
                                                        echo '<option value="' . $row->YEARS_NAME . '">' . $row->YEARS_NAME . '</option>';
                                                    }
                                                }
                                                ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <button type="submit" class="btn btn-primary uppercase btn-cari"><div class="fa fa-search"></div> CARI</button>
                                                    <a href="<?php echo base_url(); ?>realisasi/view/<?php echo $row_subprogram->RKAP_SUBPRO_ID ?>" class="btn btn-warning uppercase"><div class="fa fa-eye"></div> Tampilkan semua data</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>


                    <div class="table">
                        <table class="table table-striped table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>Bulan Pelaporan</th>
                                    <th>Jenis</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Realisasi Bulan Sebelumnya</th>
                                    <th>Realisasi Bulan Pelaporan</th>
                                    <th>persen</th>
                                    <th>Status</th>
                                    <th>Kendala</th>
                                    <!-- <th>Deadline</th> -->
                                    <th>Tools</th>
                                </tr>
                            </thead>

                            <tbody>
                            <div class="col-md-12">
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
    <?php $niai_sebelumnya = 0; ?>
                                    <?php foreach ($list as $key => $row): ?>
                                        <?php
                                        $seb[$key] = $niai_sebelumnya;
                                        $seb2[$key] = $row->REAL_SUBPRO_VAL;
                                        if ($key == 0) {
                                            $niai_sebelumnya = $niai_sebelumnya;
                                        } else {
                                            $niai_sebelumnya = $seb[$key] + $seb2[$key - 1];
                                        }
                                        $total = $row->REAL_SUBPRO_VAL + $niai_sebelumnya;
                                        $datetot = date("M-Y", strtotime($row->REAL_SUBPRO_DATE));
                                        $pertot = number_format($row->REAL_SUBPRO_PERCENT_TOT, 2, ",", ".");
                                        ?>

                                    <tr>
                                        <td><?php echo date("M-Y", strtotime($row->REAL_SUBPRO_DATE)); ?></td>
                                        <td><?php echo $row->SUBPRO_TYPE_NAME; ?></td>
                                        <td>Rp <?php echo number_format($row->RKAP_SUBPRO_CONTRACT_VALUE, 2, ',', '.'); ?></td>
                                        <td>Rp <?php echo number_format($niai_sebelumnya, 2, ',', '.'); ?></td>
                                        <td>Rp <?php echo number_format($row->REAL_SUBPRO_VAL, 2, ',', '.'); ?></td>
                                        <!-- <td><?php echo $row->REAL_SUBPRO_PERCENT; ?>%</td>  -->
                                        <td><?php echo number_format($row->REAL_SUBPRO_PERCENT, 2, ",", "."); ?>%</td> 
                                        <td><?php echo $row->STATUS_NAME; ?></td>
                                        <td><?php echo $row->CONTRAINTS_NAME; ?></td>
                                        <!-- <td><?php echo date("d-m-Y", strtotime($row->REAL_SUBPRO_DEADLINE)); ?></td> -->

                                        <td align=" center">
        <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>

                                                <a href="<?php echo base_url() ?>realisasi/detail/<?php echo $row->REAL_SUBPRO_ID ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Detail Data"><i class="fa fa-eye"></i></a>
        <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                <a href="<?php echo base_url() ?>realisasi/detail/<?php echo $row->REAL_SUBPRO_ID ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Detail Data"><i class="fa fa-eye"></i></a>
        <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                <a href="<?php echo base_url() ?>realisasi/detail/<?php echo $row->REAL_SUBPRO_ID ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Detail Data"><i class="fa fa-eye"></i></a>
        <?php else: ?>
                                                <a href="<?php echo base_url() ?>realisasi/update/<?php echo $row->REAL_SUBPRO_ID ?>" class="btn btn-sm btn-info" data-toggle="tooltip" title="Ubah Data"><i class="fa fa-gears"></i></a>
                                                <a href="<?php echo base_url() ?>realisasi/detail/<?php echo $row->REAL_SUBPRO_ID ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Detail Data"><i class="fa fa-eye"></i></a>
                                              <!--   <a href="<?php echo base_url() ?>realisasi/delete_modal/<?php echo $row->REAL_SUBPRO_ID ?>" class="btn btn-sm btn-danger" title="Hapus Data" data-toggle="modal" data-target="#hapus" ><i class="fa fa-trash-o" ></i></a> -->
                                            <?php endif ?>



                                        </td>
                                    </tr>
        <?php //$niai_sebelumnya = $row->REAL_SUBPRO_VAL;  ?>
    <?php endforeach; ?>
                                <tr>
                                    <td colspan="9"></td></tr>
                                <tr>
                                    <td colspan="3" style="font-weight: bold;"><b>Total Sampai Bulan <?php echo $datetot; ?></b></td>
                                    <td colspan="2" style="font-weight: bold;">Progres :<?php echo $pertot; ?>%</td>
                                    <td colspan="4" style="font-weight: bold;"></b>Rp <?php echo number_format($total, 2, ',', '.'); ?></b></td>
                                </tr>
                            <?php endif; ?> 
                            </tbody>
                        </table>
                    </div>
                    <div class="modal animated fadeIn" id="hapus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-controls-modal="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

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

<!-- END CONTAINER