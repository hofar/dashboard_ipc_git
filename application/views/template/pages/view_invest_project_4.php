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
                    <div>
                        <?php if (count($list) == 0): ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <div class="fa fa-info-circle"></div> Tidak Ada Data<br>
                            </div>
                        <?php else: ?>
                            <?php if ($this->session->flashdata('message')): ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="fa fa-check"></div> <?php echo $this->session->flashdata('message'); ?><br>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">Create</button>
                    </div>
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
                                <!-- <!?php foreach ($list as $row): ?> -->
                                <tr style="color:#999;font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:500">
                                    <td>1</td>
                                    <td>2</td>
                                    <td>3</td>
                                    <td>4 </td>
                                    <td>4</td>
                                    <td>6</td>
                                    <td>7</td>
                                    <td>8</td>
                                    <td>9</td>
                                    <td>9</td>
                                </tr>
                                <!-- <!?php endforeach; ?> -->
                            </tbody>
                        </table>
                        <!--?php  echo isset($halaman)?$halaman:""; ?-->
                    </div>

                    <!-- modal -->
                    <!-- <div class="modal fade modal-3d-slit modal-danger" id="hapus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1"> 
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" id="modaldeleterkap" action="<?php echo base_url() ?>rkapinvestasi/delete/<?php echo $list->RKAP_INVS_ID ?>">
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
            <form action="" method="" id="form-modal1">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Create modal 1</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlInput1"> Entitas</label>
                        <input type="text" class="form-control" id="Entitas" placeholder="Entitas">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1"> Project Number</label>
                        <input type="text" class="form-control" id="project_number" placeholder="Project Number">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Judul Investai</label>
                        <input type="text" class="form-control" id="judul_invest" placeholder="Judul Invest">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Trans Duration</label>
                        <input type="text" class="form-control" id="trans_duration" placeholder="Trans Duration">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Jenis Investasis</label>
                        <input type="text" class="form-control" id="jenis_investasi" placeholder="Jenis Investasi">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Jenis Aktiva</label>
                        <input type="text" class="form-control" id="jenis_aktiva" placeholder="Jenis Aktiva">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Input WBS</label>
                        <input type="text" class="form-control" id="input_wbs" placeholder="Input WBS">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Organization</label>
                        <input type="text" class="form-control" id="organization" placeholder="Organization">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nilai Kebutuhan Dana</label>
                        <input type="text" class="form-control" id="nilai" placeholder="Nilai Kebutuhan Dana">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tahun Investasi</label>
                        <input type="text" class="form-control" id="iahun_investasi" placeholder="Tahun Investasi">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Status</label>
                        <input type="text" class="form-control" id="status" placeholder="Status" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal 2-->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Create modal2</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                    <th scope="col">Handle</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" id="Entitas" placeholder="Entitas"></td>
                                    <td><input type="text" class="form-control" id="Entitas" placeholder="Entitas"></td>
                                    <td><input type="text" class="form-control" id="Entitas" placeholder="Entitas"></td>
                                    <td><input type="text" class="form-control" id="Entitas" placeholder="Entitas"></td>
                                    <td><input type="text" class="form-control" id="Entitas" placeholder="Entitas"></td>
                                    <td><input type="text" class="form-control" id="Entitas" placeholder="Entitas"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSave3">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal 3-->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Create modal3</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Gantt Chart</h6>
                <div id="iframe1" class="iframe" style="width:100%;">
                    <div class="no-overflow">
                        <iframe id="iframe-1" class="iframe-tag" style="display:block;position:relative;margin:0px;height:220px;width:100%;"></iframe>

                    </div>
                    <fieldset class="btns">
                        <a class="btn-playground btn" target="_blank" href="//playground.anychart.com/docs/v8/samples/GANTT_Data_01">
                            <i class="ac ac-play"></i> Playground
                        </a>
                    </fieldset>
                </div>

                <h6>Example Table</h6>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                                <th scope="col">Handle</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" id="Entitas" placeholder="Entitas"></td>
                                <td><input type="text" class="form-control" id="Entitas" placeholder="Entitas"></td>
                                <td><input type="text" class="form-control" id="Entitas" placeholder="Entitas"></td>
                                <td><input type="text" class="form-control" id="Entitas" placeholder="Entitas"></td>
                                <td><input type="text" class="form-control" id="Entitas" placeholder="Entitas"></td>
                                <td><input type="text" class="form-control" id="Entitas" placeholder="Entitas"></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

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
    function togleFilter() {
        $("#conFilter").slideToggle(300);
    }

    // menutup modal pertama  modal 1 kemudian membuka modal 2
    $('#exampleModal1').on('hidden.bs.modal', function (e) {
        //$('#exampleModal2').modal('show');
    });
    $('#form-modal1').submit(function (e) {
        e.preventDefault();
        $('#exampleModal1').modal('hide');
        $('#exampleModal2').modal('show');
    });
    $('#btnSave3').on({
        click: function (e) {

            $('#exampleModal2').modal('hide');
            $('#exampleModal3').modal('show');
        }
    });
    $(".reset").click(function () {
        $(this).closest('form').find("input[type=text], textarea").val("");
        alert('asdaduka');
    });

    $(document).ready(function () {
        $("#rkapinvestasi").attr("class", "site-menu-item active");
        $('#table1').DataTable();
    });</script>

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

<script type="text/javascript">
    (function () {
    var doc = document.getElementById('iframe-1').contentWindow.document;
            doc.open();
            doc.write("<!DOCTYPE html><html lang=\"en\"><head><meta charset=\"UTF-8\" \/><meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\" \/><meta content=\"width=device-width, initial-scale=1\" name=\"viewport\" \/><title><\/title><meta content=\"AnyChart - JavaScript Charts designed to be embedded and integrated\" name=\"description\" \/><!--[if lt IE 9]>\n<script src=\"https:\/\/oss.maxcdn.com\/html5shiv\/3.7.3\/html5shiv.min.js\"><\/script>\n<script src=\"https:\/\/oss.maxcdn.com\/respond\/1.4.2\/respond.min.js\"><\/script>\n<![endif]--><link href=\"https:\/\/cdn.anychart.com\/releases\/8.7.1\/css\/anychart-ui.min.css?hcode=a0c21fc77e1449cc86299c5faa067dc4\" rel=\"stylesheet\" type=\"text\/css\" \/><style>html, body, #container {\n width: 100 %;\n height: 100%;\n margin: 0; \n  padding: 0; \n}<\/style><\/head><body><div id=\"container\"><\/div><script src=\"https:\/\/cdn.anychart.com\/releases\/8.7.1\/js\/anychart-base.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4\"><\/script><script src=\"https:\/\/cdn.anychart.com\/releases\/8.7.1\/js\/anychart-gantt.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4\"><\/script><script src=\"https:\/\/cdn.anychart.com\/releases\/8.7.1\/js\/anychart-exports.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4\"><\/script><script src=\"https:\/\/cdn.anychart.com\/releases\/8.7.1\/js\/anychart-ui.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4\"><\/script><script type=\"text\/javascript\">anychart.onDocumentReady(function () {\n\n\/\/create data\n var data = [\n {\n id: \"1\",\n  name: \"Development\",\n        start_date: \"2018-01-15\",\n end_date: \"2018-03-10\",\n  child_items: [\n {\n  id: \"1_1\",\n  name: \"Analysis\",\n  start_date: \"2018-01-15\",\n end_date: \"2018-01-25\"\n },\n  {\n  id: \"1_2\",\n  name: \"Design\",\n start_date: \"2018-01-20\",\n end_date: \"2018-02-04\"\n },\n  {\n  id: \"1_3\",\n  name: \"Meeting\",\n start_date: \"2018-02-05\",\n actualEnd: \"2018-02-05\"\n },\n {\n  id: \"1_4\",\n  name: \"Implementation\",\n start_date: \"2018-02-05\",\n  end_date: \"2018-02-24\"\n },\n  {\n  id: \"1_5\",\n name: \"Testing\",\n  start_date: \"2018-02-25\",\n  end_date: \"2018-03-10\"\n }\n ]}\n ];\n \n \/\/ create a data tree\n var treeData = anychart.data.tree(data, \"as-tree\", null, {children: \"child_items\"});\n\n \/\/ map the data\n var mapping = treeData.mapAs({actualStart: \"start_date\", actualEnd: \"end_date\"});\n\n \/\/ create a chart\n var chart = anychart.ganttProject();\n\n \/\/ set the data\n chart.data(mapping);\n\n \/\/ configure the scale\n  chart.getTimeline().scale().maximum(\"2018-03-15\");\n\n \/\/ set the container id\n chart.container(\"container\");\n\n \/\/ initiate drawing the chart\n chart.draw();\n\n \/\/ fit elements to the width of the timeline\n chart.fitAll();\n});<\/script><\/body><\/html>");
        doc.close();
    })();
</script>