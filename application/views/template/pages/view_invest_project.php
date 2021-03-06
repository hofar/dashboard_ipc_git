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
    a{
        text-decoration:none !important;
    }
    .labelGrid{
        font-size:12px;
        color:#999;
    }
    .headTable{
        font-size:14px !important;
        color:#666 !important;
        background-color:#F3F3F3 !important;
    }
    .isiGrid{
        font-size:15px;
        font-weight:600;
    }
    .isiGrid3{
        font-size:14px;
        font-weight:400;
        color:#666
    }
    .isiGrid2{
        font-size:15px;
        font-weight:600;
    }
</style>

<div class="page">
    <div class="page-content">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item"> <a href="<?php echo base_url(); ?>rkapinvestasi"> Investasi</a></li>
            <li class="breadcrumb-item active"> Investasi Project</li>
        </ol>
        <div class="headTab">
            <i class="icon md-time-interval"></i> 
            Investasi Project
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
                    <div class="form-actions" align="right">
                        <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>

                            <a href="<?php echo base_url(); ?>rkapinvestasi" class="btn btn-warning btn-round" id="reset"><div class="fa fa-eye"></div> Tampilkan semua data</a>

                            <!-- <!?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                    <a href="<!?php echo base_url(); ?>rkapinvestasi" class="btn btn-warning btn-round" id="reset">Tampilkan semua data</a>
                            <!?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                    <a href="<!?php echo base_url(); ?>rkapinvestasi" class="btn btn-warning btn-round" id="reset">Tampilkan semua data</a> -->
                            <!-- <!?php else: ?> -->
                            <a href="<?php echo base_url(); ?>rkapinvestasi/add" class="btn btn-success btn-round" style="width:150px"> Tambah</a>
                            <!-- <a href="<!?php echo base_url(); ?>rkapinvestasi" class="btn btn-info btn-round" id="reset">
                                    Tampilkan semua data
                            </a> -->
                        <?php endif ?>

                        <button class="btn btn-default btn-round" onclick="togleFilter()">
                            <i class="icon md-storage"></i> Filter
                        </button>

                    </div>
                    <br />
                    <div class="row" style="margin-bottom: 15px;font-size:13px;display:none" id="conFilter">
                        <div class="col-sm-6" >
                            <form  role="form" action="<?php echo base_url(); ?>rkapinvestasi/search1" method="post" style="margin-bottom: 15px;">
                                <fieldset style="border: 1px solid #e5e5e5; border-radius: 3px; color: #666666;">
                                    <div class="col-sm-12" style="padding: 15px;">
                                        <div class="form-group">
                                            <div class="row">
                                                <?php
                                                if ($this->session->flashdata('title')):
                                                    $title = $this->session->flashdata('title');
                                                else :
                                                    $title = "";
                                                endif
                                                ?>
                                                <label class="control-label col-lg-4 col-md-5 col-sm-5 col-xs-12 inpt">
                                                    <i class="icon md-calendar"></i> &nbsp;
                                                    Judul Investasi
                                                </label>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                    <input type= "text" name= "title" value="<?php echo $this->session->search1['title']; ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($this->session->userdata('SESS_USER_PRIV') == 1): ?>
                                            <div class="form-group">
                                                <div class="row">
                                                    <?php
                                                    if ($this->session->flashdata('cabang')):
                                                        $cabang = $this->session->flashdata('cabang');
                                                    else :
                                                        $cabang = "";
                                                    endif
                                                    ?>
                                                    <label class="control-label col-lg-4 col-md-5 col-sm-5 col-xs-12 inpt">
                                                        <i class="icon md-pin"></i> &nbsp;Cabang
                                                    </label>
                                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                        <select name="cabang" class="form-control">
                                                            <option value="">-- Pilih Cabang --</option>
                                                            <?php
                                                            foreach ($groups as $row) {
                                                                if ($row->BRANCH_NAME == $this->session->search1['cabang']) {
                                                                    echo '<option selected value="' . $row->BRANCH_NAME . '">' . $row->BRANCH_NAME . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $row->BRANCH_NAME . '">' . $row->BRANCH_NAME . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>

                                        <?php endif ?>

                                        <div class="form-group">
                                            <div class="row">
                                                <?php
                                                if ($this->session->flashdata('kode')):
                                                    $kode = $this->session->flashdata('kode');
                                                else :
                                                    $kode = "";
                                                endif
                                                ?>
                                                <label class="control-label col-lg-4 col-md-5 col-sm-5 col-xs-12 inpt">
                                                    <i class="icon md-card-travel"></i> &nbsp;Kode Investasi
                                                </label>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                    <input type= "text" name= "kode" value="<?php echo $this->session->search1['kode']; ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <?php
                                            if ($this->session->flashdata('posisi')):
                                                $posisi = $this->session->flashdata('posisi');
                                            else :
                                                $posisi = "";
                                            endif
                                            ?>
                                            <label class="control-label col-lg-4 col-md-5 col-sm-5 col-xs-12 inpt">
                                                <i class="icon md-navigation"></i> &nbsp;Posisi
                                            </label>
                                            <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                <select name="posisi" class="form-control">
                                                    <option value="">-- Pilih Posisi --</option>
                                                    <?php
                                                    foreach ($groups3 as $row) {
                                                        if ($row->POSPROG_NAME == $this->session->search1['posisi']) {
                                                            echo '<option selected value="' . $row->POSPROG_NAME . '">' . $row->POSPROG_NAME . '</option>';
                                                        } else {
                                                            echo '<option value="' . $row->POSPROG_NAME . '">' . $row->POSPROG_NAME . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success btn-block">Cari</button>
                                        </div>

                                    </div>
                                </fieldset>
                            </form>
                        </div>


                        <div class="col-sm-6">
                            <form  id="sortingrkap" role="form" action="<?php echo base_url(); ?>rkapinvestasi/search2" method="post" style="margin-bottom: 15px;">
                                <fieldset style="border: 1px solid #e5e5e5; border-radius: 3px; color: #666666; margin-bottom: 15px;">

                                    <div class="col-sm-12" style="padding: 15px;">
                                        <?php if ($this->session->userdata('SESS_USER_PRIV') == 1): ?>
                                            <div class="form-group">
                                                <div class="row">
                                                    <?php
                                                    if ($this->session->flashdata('sort_cabang')):
                                                        $sort_cabang = $this->session->flashdata('sort_cabang');
                                                    else :
                                                        $sort_cabang = "";
                                                    endif
                                                    ?>
                                                    <label class="control-label col-lg-4 col-md-5 col-sm-5 col-xs-12 inpt">
                                                        <i class="icon md-pin"></i> &nbsp;Cabang
                                                    </label>
                                                    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                        <select name="sort_cabang" class="form-control">
                                                            <option value="-">-- Pilih Cabang --</option>
                                                            <?php
                                                            foreach ($groups as $row) {
                                                                if ($row->BRANCH_NAME == $this->session->search2['sort_cabang']) {
                                                                    echo '<option selected value="' . $row->BRANCH_NAME . '">' . $row->BRANCH_NAME . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $row->BRANCH_NAME . '">' . $row->BRANCH_NAME . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>

                                        <?php endif ?>

                                        <div class="form-group">
                                            <div class="row">
                                                <?php
                                                if ($this->session->flashdata('kebutuhan')):
                                                    $kebutuhan = $this->session->flashdata('kebutuhan');
                                                else :
                                                    $kebutuhan = "";
                                                endif
                                                ?>
                                                <label class="control-label col-lg-4 col-md-5 col-sm-5 col-xs-12 inpt">
                                                    <i class="icon md-receipt"></i> &nbsp;Kebutuhan
                                                </label>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                    <select name="kebutuhan" class="form-control" id="kebutuhan_select" onchange="kebutuhansort()">
                                                        <?php
                                                        if ($this->session->search2['kebutuhan'] == "-" or $this->session->search2['kebutuhan'] == NULL) {
                                                            echo '<option selected value="-">-- Pilih Sorting --</option>';
                                                            echo '<option value="4">10 Teratas</option>';
                                                            echo '<option value="3">10 Terbawah</option>';
                                                        } elseif ($this->session->search2['kebutuhan'] == 4) {
                                                            echo '<option value="-">-- Pilih Sorting --</option>';
                                                            echo '<option selected value="4">10 Teratas</option>';
                                                            echo '<option value="3">10 Terbawah</option>';
                                                        } else {
                                                            echo '<option value="-">-- Pilih Sorting --</option>';
                                                            echo '<option value="4">10 Teratas</option>';
                                                            echo '<option selected value="3">10 Terbawah</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <?php
                                                if ($this->session->flashdata('rkap')):
                                                    $rkap = $this->session->flashdata('rkap');
                                                else :
                                                    $rkap = "";
                                                endif
                                                ?>
                                                <label class="control-label col-lg-4 col-md-5 col-sm-5 col-xs-12 inpt">
                                                    <i class="icon md-arrow-missed"></i> &nbsp;Nilai RKAP
                                                </label>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                    <select name="rkap" class="form-control" id="rkap_select" onchange="rkapsort()">
                                                        <?php
                                                        if ($this->session->search2['rkap'] == "-" or $this->session->search2['rkap'] == NULL) {
                                                            echo '<option selected value="-">-- Pilih Sorting --</option>';
                                                            echo '<option value="2">10 Teratas</option>';
                                                            echo '<option value="1">10 Terbawah</option>';
                                                        } elseif ($this->session->search2['rkap'] == 2) {
                                                            echo '<option selected value="-">-- Pilih Sorting --</option>';
                                                            echo '<option selected value="2">10 Teratas</option>';
                                                            echo '<option value="1">10 Terbawah</option>';
                                                        } else {
                                                            echo '<option value="-">-- Pilih Sorting --</option>';
                                                            echo '<option value="2">10 Teratas</option>';
                                                            echo '<option selected value="1">10 Terbawah</option>';
                                                        }
                                                        ?>                             
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success btn-block">Sortir</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>

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
                    <button type="button" class="btn btn-success mb-4 pull-right" data-toggle="modal" data-target="#exampleModal1">Create Investasi</button>
                    <div class="table-responsive" >
                        <table class="table table-hover dataTable w-full" style="font-size:13px" id="table1">
                            <thead>
                                <tr>
                                    <th class="headTable" width="36" height="40">Entitas</th>
                                    <th class="headTable" width="53">Organization</th>
                                    <th class="headTable" width="383">Project Number</th>
                                    <th class="headTable" width="258">Kebutuhan Dana</th>
                                    <th class="headTable" width="119">RKAP</th>
                                    <th class="headTable" width="313">Jangka Waktu</th>
                                    <th class="headTable" width="65">Indikator</th>
                                    <th class="headTable" width="65">Jenis Invest</th>
                                    <th class="headTable" width="65">status</th>
                                    <th class="headTable" width="65">Action</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <!-- <!?php  echo isset($halaman)?$halaman:""; ?> -->


                    </div>

                    <!-- modal -->
                    <!-- <div class="modal fade modal-3d-slit modal-danger" id="hapus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1"> 
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" id="modaldeleterkap" action="<!?php echo base_url() ?>rkapinvestasi/delete/<!?php echo $list->RKAP_INVS_ID ?>">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                    -->
                    <!-- END PORTLET-->
                </div>
            </div>
        </div>
    </div>
</div>                     

<!-- Modal 1-->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="#" method="POST" id="form-modal1">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Input Investasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1"> Entitas</label>
                            <input type="text" class="form-control" id="entitas" placeholder="Entitas" name="entitas">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1"> Project Number</label>
                            <input type="text" class="form-control" id="project_number" placeholder="Project Number" name="project_number">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Judul Investai</label>
                            <input type="text" class="form-control" id="judul_invest" placeholder="Judul Invest" name="judul_invest">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Trans Duration</label>
                            <input type="text" class="form-control" id="trans_duration" placeholder="Trans Duration" name="trans_duration">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Jenis Investasis</label>
                            <select name="jenis_investasi" class="form-control" data-validation="required" data-validation-error-msg="Silahkan Pilih Jenis Investasi" id="jenis_investasi">
                                <option value="">-- Pilih Jenis Investasi --</option>
                                <?php
                                foreach ($groups2 as $row) {
                                    if ($act == 'add') {
                                        echo '<option value="' . $row->INVS_TYPE_ID . '">' . $row->INVS_TYPE_NAME . '</option>';
                                    } else {
                                        if ($list->RKAP_INVS_TYPE == $row->INVS_TYPE_ID) {

                                            echo '<option selected value="' . $row->INVS_TYPE_ID . '">' . $row->INVS_TYPE_NAME . '</option>';
                                        } else {

                                            echo '<option value="' . $row->INVS_TYPE_ID . '">' . $row->INVS_TYPE_NAME . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Jenis Aktiva</label>
                            <select name="jenis_aktiva" class="form-control" data-validation="required" data-validation-error-msg="Silahkan Pilih Jenis Aktiva" id="jenis_aktiva">
                                <option value="">-- Pilih Jenis Aktiva --</option>

                                <?php
                                foreach ($groups1 as $row) {
                                    if ($act == 'add') {
                                        echo '<option value="' . $row->ASSETS_ID . '">' . $row->ASSETS_NAME . '</option>';
                                    } else {
                                        if ($list->RKAP_INVS_ASSETS == $row->ASSETS_ID) {

                                            echo '<option selected value="' . $row->ASSETS_ID . '">' . $row->ASSETS_NAME . '</option>';
                                        } else {

                                            echo '<option value="' . $row->ASSETS_ID . '">' . $row->ASSETS_NAME . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Input WBS</label>
                            <input type="text" class="form-control" id="input_wbs" placeholder="Input WBS" name="input_wbs">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Organization</label>
                            <input type="text" class="form-control" id="organization" placeholder="Organization" name="organization">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Nilai Kebutuhan Dana</label>
                            <div class="input-group-addon">
                                Rp &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" id="nilai" placeholder="Nilai Kebutuhan Dana" name="nilai">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Status</label>
                            <input type="text" class="form-control" id="status" placeholder="Status" readonly name="status">
                        </div>
                    </div>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn_save1">Save & Next</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal 2-->

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="#" method="POST" id="form-modal2">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Create modal2</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive"> 
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th width="col">Tahun RKAP</th>
                                    <th scope="col">Nilai RKAP</th>
                                    <th scope="col">Target Triwulan 1</th>
                                    <th scope="col">Target Triwulan 2</th>
                                    <th scope="col">Target Triwulan 3</th>
                                    <th scope="col">Target Triwulan 4</th>
                                    <th scope="col">Realisasi Tahun Sebelumnya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" id="tahun_rkap" placeholder="Tahun RKAP" name="tahun_rkap"></td>
                                    <td><input type="text" class="form-control" id="nilai_rkap" placeholder="Nilai RKAP" name="nilai_rkap"></td>
                                    <td><input type="text" class="form-control" id="triwulan_1" placeholder="Target Triwulan 1" name="triwulan_1"></td>
                                    <td><input type="text" class="form-control" id="triwulan_2" placeholder="Target Triwulan 2" name="triwulan_2"></td>
                                    <td><input type="text" class="form-control" id="triwulan_3" placeholder="Target Triwulan 3" name="triwulan_3"></td>
                                    <td><input type="text" class="form-control" id="triwulan_4" placeholder="Target Triwulan 3" name="triwulan_4"></td>
                                    <td><input type="text" class="form-control" id="realisasi" placeholder="Realisasi Tahun Sebelumnya" name="realisasi"></td>
                                </tr>

                            </tbody>
                        </table>                    
                    </div>                           
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="bten_save2">Save & Next</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- akhir modal 2 -->

<!-- awal modal gantt chart -->
<div class="modal fade" id="modal_gchart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Modal Gantt Chart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div align="center" class="panelCustom" style="background-color:#F5F5F5">
                        <div id="timeline" style="height:220px; width:100%; font-size:12px !important">
                            <div style="position: relative;">
                                <div dir="ltr" style="position: relative; width: 899px; height: 220px;">
                                    <div style="position: absolute; left: 0px; top: 0px; width: 100%; height: 100%;">
                                        <svg width="899" height="220" aria-label="A chart." style="overflow: hidden;">
                                        <defs id="_ABSTRACT_RENDERER_ID_0"></defs>
                                        <g>
                                        <text text-anchor="middle" x="174" y="191.05" font-family="Arial" font-size="13" font-weight="bold" stroke="none" stroke-width="0" fill="#000000">Jan</text>
                                        <text text-anchor="middle" x="174" y="206.05" font-family="Arial" font-size="13" font-weight="bold" stroke="none" stroke-width="0" fill="#000000"> 2020</text>
                                        <text text-anchor="middle" x="266.04" y="191.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#000000">Apr</text>
                                        <text text-anchor="middle" x="358.08000000000004" y="191.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#000000">Jul</text>
                                        <text text-anchor="middle" x="451.13142857142856" y="191.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#000000">Oct</text>
                                        <text text-anchor="middle" x="544.1828571428571" y="191.05" font-family="Arial" font-size="13" font-weight="bold" stroke="none" stroke-width="0" fill="#000000">Jan</text>
                                        <text text-anchor="middle" x="544.1828571428571" y="206.05" font-family="Arial" font-size="13" font-weight="bold" stroke="none" stroke-width="0" fill="#000000"> 2021</text>
                                        <text text-anchor="middle" x="635.2114285714285" y="191.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#000000">Apr</text>
                                        <text text-anchor="middle" x="727.2514285714286" y="191.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#000000">Jul</text>
                                        <text text-anchor="middle" x="820.3028571428572" y="191.05" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#000000">Oct</text>
                                        </g>
                                        <g></g>
                                        <g></g>
                                        </svg>
                                        <div style="height: 170px; overflow: hidden scroll; width: 899px; position: absolute; top: 0px; left: 0px;">
                                            <svg width="899" height="204.95999999999998" aria-label="A chart." style="overflow: hidden;">
                                            <defs id="_ABSTRACT_RENDERER_ID_1"></defs>
                                            <g>
                                            <rect x="0" y="0" width="899" height="40.992" stroke="none" stroke-width="0" fill="#ffffff"></rect>
                                            <path d="M174,0L174,40.992" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M266.04,0L266.04,40.992" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M358.08000000000004,0L358.08000000000004,40.992" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M451.13142857142856,0L451.13142857142856,40.992" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M544.1828571428571,0L544.1828571428571,40.992" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M635.2114285714285,0L635.2114285714285,40.992" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M727.2514285714286,0L727.2514285714286,40.992" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M820.3028571428572,0L820.3028571428572,40.992" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <rect x="0" y="40.992" width="899" height="40.992" stroke="none" stroke-width="0" fill="#e6e6e6"></rect>
                                            <path d="M174,40.992L174,81.984" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M266.04,40.992L266.04,81.984" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M358.08000000000004,40.992L358.08000000000004,81.984" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M451.13142857142856,40.992L451.13142857142856,81.984" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M544.1828571428571,40.992L544.1828571428571,81.984" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M635.2114285714285,40.992L635.2114285714285,81.984" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M727.2514285714286,40.992L727.2514285714286,81.984" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M820.3028571428572,40.992L820.3028571428572,81.984" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <rect x="0" y="81.984" width="899" height="40.992" stroke="none" stroke-width="0" fill="#ffffff"></rect>
                                            <path d="M174,81.984L174,122.976" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M266.04,81.984L266.04,122.976" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M358.08000000000004,81.984L358.08000000000004,122.976" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M451.13142857142856,81.984L451.13142857142856,122.976" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M544.1828571428571,81.984L544.1828571428571,122.976" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M635.2114285714285,81.984L635.2114285714285,122.976" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M727.2514285714286,81.984L727.2514285714286,122.976" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M820.3028571428572,81.984L820.3028571428572,122.976" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <rect x="0" y="122.976" width="899" height="40.992" stroke="none" stroke-width="0" fill="#e6e6e6"></rect>
                                            <path d="M174,122.976L174,163.968" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M266.04,122.976L266.04,163.968" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M358.08000000000004,122.976L358.08000000000004,163.968" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M451.13142857142856,122.976L451.13142857142856,163.968" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M544.1828571428571,122.976L544.1828571428571,163.968" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M635.2114285714285,122.976L635.2114285714285,163.968" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M727.2514285714286,122.976L727.2514285714286,163.968" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M820.3028571428572,122.976L820.3028571428572,163.968" stroke="#ffffff" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <rect x="0" y="163.968" width="899" height="40.992" stroke="none" stroke-width="0" fill="#ffffff"></rect>
                                            <path d="M174,163.968L174,204.95999999999998" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M266.04,163.968L266.04,204.95999999999998" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M358.08000000000004,163.968L358.08000000000004,204.95999999999998" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M451.13142857142856,163.968L451.13142857142856,204.95999999999998" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M544.1828571428571,163.968L544.1828571428571,204.95999999999998" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M635.2114285714285,163.968L635.2114285714285,204.95999999999998" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M727.2514285714286,163.968L727.2514285714286,204.95999999999998" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M820.3028571428572,163.968L820.3028571428572,204.95999999999998" stroke="#e6e6e6" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M0,40.992L899,40.992" stroke="#b7b7b7" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M0,81.984L899,81.984" stroke="#b7b7b7" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M0,122.976L899,122.976" stroke="#b7b7b7" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <path d="M0,163.968L899,163.968" stroke="#b7b7b7" stroke-width="1" fill-opacity="1" fill="none"></path>
                                            <text text-anchor="end" x="161" y="25.046" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#4d4d4d">Pembangunan Pondasi…</text>
                                            <text text-anchor="end" x="161" y="66.038" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#4d4d4d">Realisasi 1</text>
                                            <text text-anchor="end" x="161" y="107.02999999999999" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#4d4d4d">Addendum 1</text>
                                            <text text-anchor="end" x="161" y="148.02200000000002" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#4d4d4d">Addendum 2</text>
                                            <text text-anchor="end" x="161" y="189.014" font-family="Arial" font-size="13" stroke="none" stroke-width="0" fill="#4d4d4d">Penyesaian Pembangu…</text>
                                            <rect x="0" y="0" width="899" height="204.95999999999998" stroke="#9a9a9a" stroke-width="1" fill-opacity="1" fill="none"></rect>
                                            </g>
                                            <g></g>
                                            <g>
                                            <rect x="175" y="9" width="182.08000000000004" height="22.991999999999997" stroke="none" stroke-width="0" fill="#4285f4"></rect>
                                            <rect x="542.1600000000001" y="49.992" width="339.8399999999999" height="22.991999999999997" stroke="none" stroke-width="0" fill="#db4437"></rect>
                                            <rect x="542.1600000000001" y="90.984" width="339.8399999999999" height="22.991999999999997" stroke="none" stroke-width="0" fill="#f4b400"></rect>
                                            <rect x="542.1600000000001" y="131.976" width="333.7714285714285" height="22.991999999999997" stroke="none" stroke-width="0" fill="#0f9d58"></rect>
                                            <rect x="359.08000000000004" y="172.968" width="183.08000000000004" height="22.991999999999997" stroke="none" stroke-width="0" fill="#ab47bc"></rect>
                                            </g>
                                            <g></g>
                                            <g></g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div aria-hidden="true" style="display: none; position: absolute; top: 230px; left: 909px; white-space: nowrap; font-family: Arial; font-size: 13px; font-weight: bold;"> 2021</div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--akhir modal gantt chart-->

<script type="text/javascript">
    function kebutuhansort() {
        var kebutuhan_val = $("#kebutuhan_select").val();
        if (kebutuhan_val > 0) {
            $("#sortingrkap  #rkap_select").attr('disabled', 'disabled');
            $("#sortingrkap  #rkap_select").val('-');
        } else {
            $("#sortingrkap  #rkap_select").removeAttr('disabled');
        }

    }
    function rkapsort() {
        var rkap_val = $("#rkap_select").val();
        if (rkap_val > 0) {
            $("#sortingrkap  #kebutuhan_select").attr('disabled', 'disabled');
            $("#sortingrkap  #kebutuhan_select").val('-');
        } else {
            $("#sortingrkap  #kebutuhan_select").removeAttr('disabled');
        }

    }
    function list_invest() {
        var tbody = '';
        $.ajax({
            url: '<?php echo site_url('Rkapinvestasi/investasi_new_ajax') ?>',
            dataType: 'json',
            beforeSend: function (e) {
                tbody = '<tr><td colspan="10" align="center"><i class="fa fa-fw fa-spin fa-spinner fa-pulse"></i> Sedang memproses data...</td></tr>';
                $('#table1').children('tbody').html(tbody);
            },
            success: function (data) {
                tbody = ''; // reset tbody
                var data_json = data.data;
                //console.log(data_json);
                $.each(data_json, function (i, v) {
                    // console.log(i+' '+v);
                    tbody += '<tr>';
                    tbody += '<td>' + v[0] + '</td>';
                    tbody += '<td>' + v[1] + '</td>';
                    tbody += '<td>' + v[2] + '</td>';
                    tbody += '<td>' + v[3] + '</td>';
                    tbody += '<td>' + v[4] + '</td>';
                    tbody += '<td></td>';
                    tbody += '<td>' + v[6] + '</td>';
                    tbody += '<td>' + v[5] + '</td>';
                    tbody += '<td></td>';
                    tbody += '<td></td>';

                    tbody += '</tr>';
                });

                $('#table1').children('tbody').html(tbody);

                $('#table1').DataTable({
                    "order": [[0, "desc"]]
                });
            }
        });
    }

    //Save invest
    $('#btn_save1').on('click', function () {
        var entitas = $('#entitas').val();
        var project_number = $('#project_number').val();
        var judul_invest = $('#judul_invest').val();
        var trans_duration = $('#trans_duration').val();
        var jenis_investasi = $('#jenis_investasi').val();
        var jenis_aktiva = $('#jenis_aktiva').val();
        var input_wbs = $('#input_wbs').val();
        var organization = $('#organization').val();
        var nilai = $('#nilai').val();
        // var tahun_investasi         = $('#tahun_investasi').val();
        var status = $('#status').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('rkapinvestasi/save_inves') ?>",
            dataType: "JSON",
            data: {entitas: entitas, project_number: project_number, judul_invest: judul_invest, trans_duration: trans_duration
                , jenis_investasi: jenis_investasi, jenis_aktiva: jenis_aktiva, input_wbs: input_wbs, organization: organization, nilai: nilai,
                status: status},
            success: function (data) {
                $('[name="entitas"]').val("");
                $('[name="project_number"]').val("");
                $('[name="judul_invest"]').val("");
                $('[name="trans_duration"]').val("");
                $('[name="jenis_investasi"]').val("");
                $('[name="jenis_aktiva"]').val("");
                $('[name="input_wbs"]').val("");
                $('[name="organization"]').val("");
                $('[name="nilai"]').val("");
                // $('[name="tahun_investasi"]').val("");
                $('[name="status"]').val("");
                $('#exampleModal1').modal('hide');
                $('#exampleModal2').modal('show');
                // reload_table();
                // list_invest();
                // location.reload() ;
                // table.reload();
                // table.ajax.reload();
            }
        });
        return false;
    });
    // menutup modal pertama  modal 1 kemudian membuka modal 2
    $('#exampleModal1').on('hidden.bs.modal', function (e) {
        //$('#exampleModal2').modal('show');
    });
    $('#exampleModal2').on('hidden.bs.modal', function (e) {
        $('#modal_gchart').modal('show');
    });
    $('#form-modal1').submit(function (e) {
        e.preventDefault();

        $('#exampleModal1').modal('hide');
        $('#exampleModal2').modal('show');
    });
    $('#form-modal2').submit(function (e) {
        e.preventDefault();

        $('#exampleModal2').modal('hide');
        $('#exampleModal3').modal('show');
    });
    $(".reset").click(function () {
        $(this).closest('form').find("input[type=text], textarea").val("");
        alert('asdaduka');
    });

    function togleFilter() {
        $("#conFilter").slideToggle(300);
    }
    window.onload = function () {
        $("#rkapinvestasi").attr("class", "site-menu-item active");
    }

    $(document).ready(function () {
        //toltip button
        $('[data-toggle="tooltip"]').tooltip();

        list_invest();
    });
</script>

<script type="text/javascript">
    var link_base = "<?php echo base_url(); ?>";
    function btn_delete_rkap(id) {
        // alert(id);
        document.getElementById("modaldeleterkap").action = link_base + '/rkapinvestasi/delete/' + id;
        // $.ajax({
        //     type: 'GET',
        //    url: link_base+'/rkapinvestasi/delete_modal/'+ id,
        //     // data: {id : id},
        //     success: function (data) {
        //         // console.log(data);
        //         var obj = JSON.parse(data);
        //         // $('#editstatus').modal();
        //          $("#id_user_modal").val(obj.USER_ID);
        //         // alert(obj.USER_ID);
        //         // $('#editstatus').find('.modal-body').html(data);
        //     }
        // })
    }
</script>