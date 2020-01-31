
<style type="text/css">
    .red > thead > tr > th {
        vertical-align: bottom;
        background-color: #f93636 !important;
        border: 1px solid #ddd;
        color:#FFF;
        text-align: center;
}

    .green > thead > tr > th {
        vertical-align: bottom;
        background-color: #45B6AF !important;
        border: 1px solid #ddd;
        color:#FFF;
        text-align: center;
}
    .yellow > thead > tr > th {
        vertical-align: bottom;
        background-color: #F9AC36 !important;
        border: 1px solid #ddd;
        color:#FFF;
        text-align: center;
}

</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->

            <div class="page-title">
                <h1 style="color:#67809F;"><b>DASHBOARD</b></h1>
            </div>
            <!-- END PAGE TITLE -->


        </div>
        <!-- END PAGE HEAD -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home fa-lg"></i>
                <a href="<?php echo base_url(); ?>home" style="color: #787305">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
        <!-- BEGIN PAGE CONTENT INNER -->

        <div class="row">

            <div class="col-md-12 col-sm-12">
                <?php if ($this->session->flashdata('login')): ?>
                    <div class="note note-info note-bordered">
                        <p>
                        <div class="fa fa-check"></div>&nbsp;<?php echo $this->session->flashdata('login'); ?>
                        </p>
                    </div>

                <?php endif; ?>
                 <?php if ($this->session->userdata('SESS_USER_PRIV') == 1): ?>
                    <?php else: ?>
                        <?php if ($notif_announcement > 0): ?>
                             <div class="note note-warning note-bordered">
                             <p>
                                <i class="fa fa-exclamation-circle"></i>&nbsp; Anda memiliki <b><?php echo $notif_announcement; ?></b>  pemberitahuan, silahkan cek di menu pengumuman atau klik <a href="<?php echo base_url(); ?>announcement" class="btn btn-primary">Disini</a>
                                <!-- <a href="#" class="btn btn-info" role="button">Link Button</a> -->
                            </p>
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                
                <!-- BEGIN PORTLET-->
                <div class="portlet light">
                <?php if ($this->session->userdata('SESS_USER_PRIV') == 1): ?>
                    <div class="col-sm-3">
                        <div class="form-group">
                          <select class="form-control" id="induk">
                            
                            <option value="0">
                              Perusahaan Induk
                            </option>
                             
                            <option value="2">
                              Anak Perusahaan
                            </option>
                          </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                          <button class="btn btn-success" onclick="induk($('#induk').val())">View</button>
                        </div>
                    </div>
                    <!-- <div class="col-sm-3">
                        <div class="form-group">
                          <button class="btn btn-success" onclick="pusat()">Pusat</button>
                        </div>
                    </div> -->

                <?php else: ?>
                <?php endif; ?>
                    <div id="mapss" style="padding: 7px 0 5px 0;">
                        <div id="chartdiv"></div>
                    </div>
                </div>
                    <!--                        <div class="col-sm-2"></div>
                                            <div class="col-sm-8">
                                                <img src="<?php echo base_url(); ?>assets/img/ipc_logo.png" class="img-responsive">
                                            </div>
                                            <div class="col-sm-2"></div>-->
                <!-- END PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->
</div>

<div id="modal_all" style=" display: none;">
    <div class="row">
        <div class="panel panel-default" style="width:800px;  margin-top: 2.5cm; ">
            <div class="panel-heading clearfix">
                <button type="submit"  id="close_all" class="btn btn-danger btn-sm pull-right" ><span class="fa fa-close"></span></button>
                <center><h3 class="panel-title" style="padding-top: 7.5px;">Dashboard Konsolidasi</h3></center>
            </div>
            <div class="panel-body">
                 <div class="col-md-12" >
                       <center><img src="<?php echo base_url(); ?>assets/img/ipc_logo.png" class="img-responsive ipc-image"></center><br>
                    </div>
                <div class="col-lg-12" style="padding-right:0px; padding-left:0px">
                    <div class="col-md-12" >
                        <div id="all_gaugeDetails1" class="col-sm-3" style="padding-right:0px; padding-left:0px;">
                        </div>
                        <div id="all_gaugeDetails2" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                        <div id="all_gaugeDetails3" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                        <div id="all_pieDetails4" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                    </div>
                    <!-- <div class="col-md-6" ><br>
                       <img src="<?php echo base_url(); ?>assets/img/ipc_logo.png" class="img-responsive ipc-image">
                    </div> -->
                </div>
                <div class="col-md-12">
                    <label class="col-sm-3"><center>Realisasi Fisik</center><br>&nbsp;</label>
                    <label class="col-sm-3"><center>KPI Realisasi <br> Program</center></label>
                    <label class="col-sm-3"><center>KPI Realisasi <br> Fisik</center></label>
                    <label class="col-sm-3"><center>Status Program<br> Investasi</center></label>
                </div>
                <div class="col-lg-12" style="margin-top:30px;">
                    <div class="col-xs-6" >
                        <label>Posisi Program Invetasi</label>
                    </div>
                    <div class="col-xs-6" >
                        <label>Kendala Program Invetasi</label>
                    </div>
                </div>
                <div class="col-lg-12" style="margin-bottom:10px;">
                    <div class="col-xs-6" >
                        <div id="all_tabung1"></div>
                    </div>
                    <div class="col-xs-6" >
                        <div id="all_tabung2"></div>
                    </div>
                </div>
                
                  <div class="col-lg-12" style="padding-right:0px; padding-left:0px">
                        <!-- <div class="col-sm-4"> -->
                            <center>
                                 <div id="all_gaugeKritis4" class="col-sm-4" style="padding-right:0px; padding-left:0px;"></div>
                            </center>
                        <!-- </div> -->
                        <!-- <div > -->
                            <center >
                                 <div id="all_gaugeKritis5" class="col-sm-4" style="padding-right:0px; padding-left:0px;"></div>
                            </center>
                        <!-- </div> -->
                        <!-- <div > -->
                            <center>
                                 <div id="all_gaugeKritis6" class="col-sm-4" style="padding-right:0px; padding-left:0px;"></div>
                            </center>
                        <!-- </div> -->
                   
                </div>
                  <div class="col-md-12">
                    <div class="col-sm-4">
                        <center>
                            <label >Kontrak Kritis Kategori 1</label>
                            <button type="submit" class="btn btn-primary" id="kritis_1_all" onclick="kritis_p_all()"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                            <label>Kontrak Kritis Kategori 2</label>
                            <button type="submit" class="btn btn-primary" id="kritis_1_all" onclick="kritis_p_2_all()"> Detail</button>
                        </center>
                    </div>
                     <div class="col-sm-4">
                         <center>
                             <label>Kontrak Kritis Kategori 3</label>
                            <button type="submit" class="btn btn-primary" id="kritis_3_all" onclick="kritis_p_3_all()"> Detail</button>
                         </center>
                     </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kritis_1_all" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Kontrak Kritis Kategori 1</span></h3>
            <button type="submit"  id="closeKritis1_all" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover green" id="show_detail_kritis_1_all">
                            <thead>
                                <tr>
                                    <th>Judul Investasi</th>
                                    <th>Sub Program</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kritis_2_all" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Berdasarkan Kendala</span></h3>
            <button type="submit"  id="closeKritis2_all" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover yellow" id="show_detail_kritis_2_all">
                            <thead>
                                <tr>
                                    <th>Judul Investasi</th>
                                    <th>Sub Program</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kritis_3_all" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Berdasarkan Kendala</span></h3>
            <button type="submit"  id="closeKritis3_all" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover red" id="show_detail_kritis_3_all">
                            <thead>
                                <tr>
                                    <th>Judul Investasi</th>
                                    <th>Sub Program</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="placeholder_awal" style=" display: none;">
    <div class="row">
        <div class="panel panel-default" style="width:800px;  margin-top: 4cm; ">
            <div class="panel-heading clearfix">
                <!-- <?php foreach ($result as $post): ?>
                    <?php echo $post->BRANCH_NAME; ?> 
                <?php endforeach ?> -->
                <button type="submit" id="close_place_awal" class="btn btn-danger btn-sm pull-right"><span class="fa fa-close"></span></button>
                <center><h3 class="panel-title" style="padding-top: 7.5px;">Dashboard Perusahaan <span id="NAME_DISPLAY"></span> </h3></center>
            </div>
            <div class="panel-body">
                <div class="col-lg-12" style="padding-right:0px; padding-left:0px">
                    <div class="col-md-12" >
                        <div id="gaugeDetails1awal" class="col-sm-3" style="padding-right:0px; padding-left:0px;">
                        </div>
                        <div id="gaugeDetails2awal" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                        <div id="gaugeDetails3awal" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                        <div id="pieDetails4awal" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="col-sm-3"><center>Realisasi Fisik</center><br>&nbsp;</label>
                    <label class="col-sm-3"><center>KPI Realisasi <br> Program</center></label>
                    <label class="col-sm-3"><center>KPI Realisasi <br> Fisik</center></label>
                    <label class="col-sm-3"><center>Status Program<br> Investasi</center></label>
                </div>
                <div class="col-md-12" ><br>
                    <div class="col-xs-12" >
                        <button type="submit" class="btn btn-xs btn-primary" id="infoKontrak" onClick="kontrak_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" style="margin-bottom:5px;">Lihat Program Investasi</button>
                        <!-- <button type="submit"  class="btn btn-xs btn-primary"  style="margin-bottom:5px;">Program Kritis</button> -->
                        <button type="submit" id="infoStatus" onClick="status_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" class="btn btn-xs btn-primary" style="margin-bottom:5px;">Status Program</button>
                       <!--  <button type="submit" id="infoProfil" onClick="profil_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" class="btn btn-xs btn-primary"  style="margin-bottom:5px;">Profil Perusahaan</button> -->
                        <button type="submit" class="btn btn-xs btn-primary" style="margin-bottom:5px;">Cetak Laporan</button>
                        <button type="submit" id="infoPosisi" onClick="posisi_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" class="btn btn-xs btn-primary" style="margin-bottom:5px;">Posisi Program</button>
                        <button type="submit" id="infoKendala" onClick="kendala_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" class="btn btn-xs btn-primary" style="margin-bottom:5px;">Program Terkendala</button>
                    </div>
                </div>
                <div class="col-lg-12" style="margin-top:30px;">
                    <div class="col-xs-6" >
                        <label>Posisi Program Invetasi</label>
                    </div>
                    <div class="col-xs-6" >
                        <label>Kendala Program Invetasi</label>
                    </div>
                </div>
                <div class="col-lg-12" style="margin-bottom:10px;">
                    <div class="col-xs-6" >
                        <div id="tabung1awal"></div>
                    </div>
                    <div class="col-xs-6" >
                        <div id="tabung2awal"></div>
                    </div>
                </div>
                <div class="col-lg-12" style="padding-right:0px; padding-left:0px">
                        <!-- <div class="col-sm-4"> -->
                            <center>
                                 <div id="gaugeKritisawal" class="col-sm-4" style="padding-right:0px; padding-left:0px;"></div>
                            </center>
                        <!-- </div> -->
                        <!-- <div > -->
                            <center >
                                 <div id="gaugeKritis2awal" class="col-sm-4" style="padding-right:0px; padding-left:0px;"></div>
                            </center>
                        <!-- </div> -->
                        <!-- <div > -->
                            <center>
                                 <div id="gaugeKritis3awal" class="col-sm-4" style="padding-right:0px; padding-left:0px;"></div>
                            </center>
                        <!-- </div> -->
                   
                </div>
                  <div class="col-md-12">
                    <div class="col-sm-4">
                        <center>
                            <label >Kontrak Kritis Kategori 1</label>
                           <button type="submit" class="btn btn-primary" id="kritis_1_awal" onClick="kritis_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                            <label>Kontrak Kritis Kategori 2</label>
                            
                             <button type="submit" class="btn btn-primary" id="kritis_2_awal" onClick="kritis_2_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"> Detail</button>
                        </center>
                    </div>
                     <div class="col-sm-4">
                         <center>
                             <label>Kontrak Kritis Kategori 3</label>
                             <button type="submit" class="btn btn-primary" id="kritis_3_awal" onClick="kritis_3_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"> Detail</button>
                         </center>
                     </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div id="placeholder" style=" display: none;">
    <div class="row">
        <div class="panel panel-default" style="width:800px;  margin-top: 4cm; ">
            <div class="panel-heading clearfix">
                <!-- <?php foreach ($result as $post): ?>
                    <?php echo $post->BRANCH_NAME; ?> 
                <?php endforeach ?> -->
                <button type="submit"  id="close" class="btn btn-danger btn-sm pull-right"><span class="fa fa-close"></span></button>
                <center><h3 class="panel-title" style="padding-top: 7.5px;">Dashboard Perusahaan <span id="DISPLAY_NAME"></span> </h3></center>
            </div>
            <div class="panel-body">
                <div class="col-lg-12" style="padding-right:0px; padding-left:0px">
                    <div class="col-md-12" >
                        <div id="gaugeDetails1" class="col-sm-3" style="padding-right:0px; padding-left:0px;">
                        </div>
                        <div id="gaugeDetails2" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                        <div id="gaugeDetails3" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                        <div id="pieDetails4" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="col-sm-3"><center>Realisasi Fisik</center><br>&nbsp;</label>
                    <label class="col-sm-3"><center>KPI Realisasi <br> Program</center></label>
                    <label class="col-sm-3"><center>KPI Realisasi <br> Fisik</center></label>
                    <label class="col-sm-3"><center>Status Program<br> Investasi</center></label>
                </div>
                <div class="col-md-12" ><br>
                        <div class="col-xs-12" >
                            <button type="submit" class="btn btn-xs btn-primary" id="infoKontrak" onClick="kontrak(id_branch)" style="margin-bottom:5px;">Lihat Program Investasi</button>
                            <!-- <button type="submit"  class="btn btn-xs btn-primary"  style="margin-bottom:5px;">Program Kritis</button> -->
                            <button type="submit" id="infoStatus" onClick="status(id_branch)" class="btn btn-xs btn-primary" style="margin-bottom:5px;">Status Program</button>
                            <!-- <button type="submit" id="infoProfil" onClick="profil(id_branch)" class="btn btn-xs btn-primary"  style="margin-bottom:5px;">Profil Perusahaan</button> -->
                            <button type="submit" class="btn btn-xs btn-primary" style="margin-bottom:5px;">Cetak Laporan</button>
                            <button type="submit" id="infoPosisi" onClick="posisi(id_branch)" class="btn btn-xs btn-primary" style="margin-bottom:5px;">Posisi Program</button>
                            <button type="submit" id="infoKendala" onClick="kendala(id_branch)" class="btn btn-xs btn-primary" style="margin-bottom:5px;">Program Terkendala</button>
                        </div>
                    </div>
                <div class="col-lg-12" style="margin-top:30px;">
                    <div class="col-xs-6" >
                        <label>Posisi Program Invetasi</label>
                    </div>
                    <div class="col-xs-6" >
                        <label>Kendala Program Invetasi</label>
                    </div>
                </div>
                <div class="col-lg-12" style="margin-bottom:10px;">
                    <div class="col-xs-6" >
                        <div id="tabung1"></div>
                    </div>
                    <div class="col-xs-6" >
                        <div id="tabung2"></div>
                    </div>
                </div>
                <div class="col-lg-12" style="padding-right:0px; padding-left:0px">
                        <!-- <div class="col-sm-4"> -->
                            <center>
                                 <div id="gaugeKritis" class="col-sm-4" style="padding-right:0px; padding-left:0px;"></div>
                            </center>
                        <!-- </div> -->
                        <!-- <div > -->
                            <center >
                                 <div id="gaugeKritis2" class="col-sm-4" style="padding-right:0px; padding-left:0px;"></div>
                            </center>
                        <!-- </div> -->
                        <!-- <div > -->
                            <center>
                                 <div id="gaugeKritis3" class="col-sm-4" style="padding-right:0px; padding-left:0px;"></div>
                            </center>
                        <!-- </div> -->
                   
                </div>
                  <div class="col-md-12">
                    <div class="col-sm-4">
                        <center>
                            <label >Kontrak Kritis Kategori 1</label>
                            <button type="submit" class="btn btn-primary" id="kritis_1" onClick="kritis(id_branch)"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                            <label>Kontrak Kritis Kategori 2</label>
                            <button type="submit" class="btn btn-primary" id="kritis_2" onClick="kritis_2(id_branch)"> Detail</button>
                        </center>
                    </div>
                     <div class="col-sm-4">
                         <center>
                             <label>Kontrak Kritis Kategori 3</label>
                             <button type="submit" class="btn btn-primary" id="kritis_3" onClick="kritis_3(id_branch)"> Detail</button>
                         </center>
                     </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div id="profil" style="right: 5cm; display: none;">
    <div class="panel panel-primary" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;"><span class="fa fa-institution"></span> Profil Perusahaan</h3>
            <button type="submit"  id="closeProfil" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-9" style="padding: 0px;">
                    <div class="form-group">
                        <div class="col-sm-5">
                            <p>Nama Kantor Cabang</p>
                        </div>
                        <div class="col-sm-7">
                            <p>: <span id="nama"></span></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <p>Luas Kantor</p>
                        </div>
                        <div class="col-sm-7">
                            <p>: 400 meter</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <p>Jumlah Aset</p>
                        </div>
                        <div class="col-sm-7">
                            <p>: Rp 1.000.000.000.000, 00</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <p>Jumlah Karyawan</p>
                        </div>
                        <div class="col-sm-7">
                            <p>: 200 orang</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <p>Income Tahun Lalu</p>
                        </div>
                        <div class="col-sm-7">
                            <p>: Rp 10.000.000.000, 00</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <p>Income Tahun Berjalan</p>
                        </div>
                        <div class="col-sm-7">
                            <p>: Rp 1.000.000.000, 00</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <p>Investasi Tahun Lalu</p>
                        </div>
                        <div class="col-sm-7">
                            <p>: Rp 5.000.000.000, 00</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <p>Investasi Tahun Berjalan</p>
                        </div>
                        <div class="col-sm-7">
                            <p>: Rp 5.000.000.000, 00</p>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-sm-3">
                    <img src="smr.jpg" width="150px" height="300px" alt="foto" class="img-thumbnail pull-right">
                </div> -->
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-3">
                        <p >Alamat</p>
                    </div>
                    <div class="col-sm-9"  style="left: 31px;">
                        <p >: Gedung Wisma SMR, Jl. Yos Sudarso Kav. 89 Jakarta Utara</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Kontrak Kritis -->
<div id="kontrak" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">List Program RKAP Investasi <span id="nama_cabang"></span></h3>
            <button type="submit"  id="closeKontrak" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group row col-lg-8">
                     
                        <div class="col-lg-4">
                           <button type="submit" onClick="print_kontrak(id_branch)" class="btn btn-warning uppercase"><div class="fa fa-file-o"></div> Cetak Pdf</button>
                        </div>
                    
                        
                    </div>
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover" id="list_prog_inv">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Judul Investasi</th>
                                    <th>Kebutuhan Dana</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="kontrak_awal" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">List Program RKAP Investasi <span id="cabang_name"></span></h3>
            <button type="submit"  id="closeKontrak_awal" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group row col-lg-8">
                     
                        <div class="col-lg-4">
                           <button type="submit" onClick="print_kontrak_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" class="btn btn-warning uppercase"><div class="fa fa-file-o"></div> Cetak Pdf</button>
                        </div>
                    
                        
                    </div>
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover" id="list_prog_inv_awal">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Judul Investasi</th>
                                    <th>Kebutuhan Dana</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai_realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Program Investasi Status-->
<div id="status" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">List Program RKAP Investasi Berdasarkan Status <span id="nama_cabang3"></span></h3>
            <button type="submit"  id="closeStatus" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group row col-lg-8">
                        <label class="col-lg-2">Jenis Status</label>
                        <div class="col-lg-4">
                            <select id="show_d_status" class="form-control">
                            </select>
                        </div>
                        <button type="submit" onclick="cari_status()" class="btn btn-primary uppercase"><div class="fa fa-search"></div> CARI</button>
                        <button type="submit" onclick="print_status()" class="btn btn-warning uppercase"><div class="fa fa-file-o"></div> Cetak Pdf</button>
                    </div>
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover green" id="list_status">
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Jumlah Status</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Realisasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="status_awal" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">List Program RKAP Investasi Berdasarkan Status <span id="cabang_nama3"></span></h3>
            <button type="submit"  id="closeStatus_awal" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group row col-lg-8">
                        <label class="col-lg-2">Jenis Status</label>
                        <div class="col-lg-4">
                            <select id="show_d_status_awal" class="form-control">
                            </select>
                        </div>
                        <button type="submit" onclick="cari_status_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" class="btn btn-primary uppercase"><div class="fa fa-search"></div> CARI</button>
                        <button type="submit" onclick="print_status_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" class="btn btn-warning uppercase"><div class="fa fa-file-o"></div> Cetak Pdf</button>
                    </div>
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover green" id="list_status_awal">
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Jumlah Status</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Realisasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Program Investasi Posisi-->
<div id="posisi" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">List Program RKAP Investasi Berdasarkan Posisi <span id="nama_cabang2"></span></h3>
            <button type="submit"  id="closePosisi" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group row col-lg-9">
                        <label class="col-lg-2">Jenis Posisi</label>
                        <div class="col-lg-4">
                            <select id="show_d_posisi" class="form-control">
                            </select>
                        </div>
                        <button type="submit" onclick="cari_posisi()" class="btn btn-primary uppercase"><div class="fa fa-search"></div> CARI</button>
                        <button type="submit" onclick="print_posisi()" class="btn btn-warning uppercase"><div class="fa fa-file-o"></div> Cetak Pdf</button>
                    </div>
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover yellow" id="list_posisi">
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Jumlah Posisi</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Realisasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="posisi_awal" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">List Program RKAP Investasi Berdasarkan Posisi <span id="cabang_nama2"></span></h3>
            <button type="submit"  id="closePosisi_awal" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group row col-lg-9">
                        <label class="col-lg-2">Jenis Posisi</label>
                        <div class="col-lg-4">
                            <select id="show_d_posisi_awal" class="form-control">
                            </select>
                        </div>
                        <button type="submit" onclick="cari_posisi_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" class="btn btn-primary uppercase"><div class="fa fa-search"></div> CARI</button>
                        <button type="submit" onclick="print_posisi_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" class="btn btn-warning uppercase"><div class="fa fa-file-o"></div> Cetak Pdf</button>
                    </div>
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover yellow" id="list_posisi_awal">
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Jumlah Posisi</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Realisasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Program Investasi Kendala-->
<div id="kendala" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">List Program RKAP Investasi Berdasarkan Kendala <span id="nama_cabang4"></span></h3>
            <button type="submit"  id="closeKendala" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group row col-lg-9">
                        <label class="col-lg-2">Jenis kendala</label>
                        <div class="col-lg-4">
                            <select id="show_d_kendala" class="form-control">
                            </select>
                        </div>
                        <button type="submit" onclick="cari_kendala()" class="btn btn-primary uppercase"><div class="fa fa-search"></div> CARI</button>
                        <button type="submit" onclick="print_kendala()" class="btn btn-warning uppercase"><div class="fa fa-file-o"></div> Cetak Pdf</button>
                    </div>
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover red" id="list_kendala">
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Jumlah Kendala</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Realisasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="kendala_awal" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">List Program RKAP Investasi Berdasarkan Kendala <span id="cabang_nama4"></span></h3>
            <button type="submit"  id="closeKendala_awal" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group row col-lg-9">
                        <label class="col-lg-2">Jenis kendala</label>
                        <div class="col-lg-4">
                            <select id="show_d_kendala_awal" class="form-control">
                            </select>
                        </div>
                        <button type="submit" onclick="cari_kendala_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" class="btn btn-primary uppercase"><div class="fa fa-search"></div> CARI</button>
                        <button type="submit" onclick="print_kendala_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" class="btn btn-warning uppercase"><div class="fa fa-file-o"></div> Cetak Pdf</button>
                    </div>
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover red" id="list_kendala_awal">
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Jumlah Kendala</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Realisasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Pusat -->
<div id="detail_status" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Berdasarkan Status <span id="nama_cabang"></span></h3>
            <button type="submit"  id="closeD_status" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover green" id="show_detail_status">
                            <thead>
                                <tr>
                                    <th>Judul RKAP</th>
                                    <th>SUB RKAP INV</th>
                                    <th>Jenis</th>
                                    <th>Nilai RKAP</th>
                                    <th>Realisasi Bulan Pelaporan</th>
                                    <th>Status</th>
                                    <th>Kendala</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_status_awal" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Berdasarkan Status <span id="nama_cabang"></span></h3>
            <button type="submit"  id="closeD_status_awal" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover green" id="show_detail_status_awal">
                            <thead>
                                <tr>
                                    <th>Judul RKAP</th>
                                    <th>SUB RKAP INV</th>
                                    <th>Jenis</th>
                                    <th>Nilai RKAP</th>
                                    <th>Realisasi Bulan Pelaporan</th>
                                    <th>Status</th>
                                    <th>Kendala</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_posisi" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Berdasarkan Posisi</h3>
            <button type="submit"  id="closeD_posisi" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover yellow" id="show_detail_posisi">
                            <thead>
                                <tr>
                                    <th>SUB RKAP INV</th>
                                    <th>Cabang</th>
                                    <th>Judul Investasi</th>
                                    <th>Kebutuhan</th>
                                    <th>Nilai RKAP</th>
                                    <th>Posisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_posisi_awal" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Berdasarkan Posisi</h3>
            <button type="submit"  id="closeD_posisi_awal" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover yellow" id="show_detail_posisi_awal">
                            <thead>
                                <tr>
                                    <th>SUB RKAP INV</th>
                                    <th>Cabang</th>
                                    <th>Judul Investasi</th>
                                    <th>Kebutuhan</th>
                                    <th>Nilai RKAP</th>
                                    <th>Posisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kendala" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Berdasarkan Kendala</span></h3>
            <button type="submit"  id="closeD_kendala" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover red" id="show_detail_kendala">
                            <thead>
                                <tr>
                                    <th>Judul RKAP</th>
                                    <th>SUB RKAP INV</th>
                                    <th>Jenis</th>
                                    <th>Nilai RKAP</th>
                                    <th>Realisasi Bulan Pelaporan</th>
                                    <th>Status</th>
                                    <th>Kendala</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kendala_awal" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Berdasarkan Kendala</span></h3>
            <button type="submit"  id="closeD_kendala_awal" class="btn btn-danger btn-sm pull-right red" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover red" id="show_detail_kendala_awal">
                            <thead>
                                <tr>
                                    <th>Judul RKAP</th>
                                    <th>SUB RKAP INV</th>
                                    <th>Jenis</th>
                                    <th>Nilai RKAP</th>
                                    <th>Realisasi Bulan Pelaporan</th>
                                    <th>Status</th>
                                    <th>Kendala</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pusat -->
<div id="modal_pusat" style=" display: none;">
    <div class="row">
        <div class="panel panel-default" style="width:800px;  margin-top: 4cm; ">
            <div class="panel-heading clearfix">
                <!-- <?php foreach ($result as $post): ?>
                    <?php echo $post->BRANCH_NAME; ?> 
                <?php endforeach ?> -->
                <button type="submit"  id="close_modal" class="btn btn-danger btn-sm pull-right"><span class="fa fa-close"></span></button>
                <center><h3 class="panel-title" style="padding-top: 7.5px;" id="name_perusahaan">Dashboard Perusahaan </h3></center>
            </div>
            <div class="panel-body">
                <div class="col-lg-12" style="padding-right:0px; padding-left:0px">
                    <div class="col-md-12" >
                        <div id="p_gaugeDetails1" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                        <div id="p_gaugeDetails2" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                        <div id="p_gaugeDetails3" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                        <div id="p_pieDetails4" class="col-sm-3" style="padding-right:0px; padding-left:0px;"></div>
                    </div>
                </div>
                   <div class="col-md-12">
                    <label class="col-sm-3"><center>Realisasi Fisik</center><br>&nbsp;</label>
                    <label class="col-sm-3"><center>KPI Realisasi <br> Program</center></label>
                    <label class="col-sm-3"><center>KPI Realisasi <br> Fisik</center></label>
                    <label class="col-sm-3"><center>Status Program<br> Investasi</center></label>
                </div>
                <div class="col-md-12" ><br>
                        <div class="col-xs-12" >
                            <button type="submit" class="btn btn-xs btn-success" id="infoKontrak_p" onclick="kontrak_p($('#induk').val())" style="margin-bottom:5px;">Lihat Program Investasi</button>
                            <!-- <button type="submit"  class="btn btn-xs btn-default"  style="margin-bottom:5px;">Program Kritis</button> -->
                            <button type="submit" id="infoStatus_p" onclick="status_p($('#induk').val())" class="btn btn-xs btn-success" style="margin-bottom:5px;">Status Program</button>
                            <!-- <button type="submit" id="infoProfil" onClick="profil(id_branch)" class="btn btn-xs btn-default"  style="margin-bottom:5px;">Profil Perusahaan</button> -->
                        
                            <button type="submit" class="btn btn-xs btn-success" style="margin-bottom:5px;">Cetak Laporan</button>
                            <button type="submit" id="infoPosisi_p" onclick="posisi_p($('#induk').val())" class="btn btn-xs btn-success" style="margin-bottom:5px;">Posisi Program</button>
                            <button type="submit" id="infoKendala" onclick="kendala_p($('#induk').val())" class="btn btn-xs btn-success" style="margin-bottom:5px;">Program Terkendala</button>
                        </div>
                    </div>
                <div class="col-lg-12" style="margin-top:30px;">
                    <div class="col-xs-6" >
                        <label>Posisi Program Invetasi</label>
                    </div>
                    <div class="col-xs-6" >
                        <label>Kendala Program Invetasi</label>
                    </div>
                </div>
                <div class="col-lg-12" style="margin-bottom:10px;">
                    <div class="col-xs-6" >
                        <div id="p_tabung1"></div>
                    </div>
                    <div class="col-xs-6" >
                        <div id="p_tabung2"></div>
                    </div>
                </div>
                 <div class="col-lg-12" style="padding-right:0px; padding-left:0px">
                        <!-- <div class="col-sm-4"> -->
                            <center>
                                 <div id="gaugeKritis4" class="col-sm-4" style="padding-right:0px; padding-left:0px;"></div>
                            </center>
                        <!-- </div> -->
                        <!-- <div > -->
                            <center >
                                 <div id="gaugeKritis5" class="col-sm-4" style="padding-right:0px; padding-left:0px;"></div>
                            </center>
                        <!-- </div> -->
                        <!-- <div > -->
                            <center>
                                 <div id="gaugeKritis6" class="col-sm-4" style="padding-right:0px; padding-left:0px;"></div>
                            </center>
                        <!-- </div> -->
                   
                </div>
                  <div class="col-md-12">
                    <div class="col-sm-4">
                        <center>
                            <label >Kontrak Kritis Kategori 1</label>
                            <button type="submit" class="btn btn-primary" id="kritis_1" onclick="kritis_p($('#induk').val())"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                            <label>Kontrak Kritis Kategori 2</label>
                             <button type="submit" class="btn btn-primary" id="kritis_2" onclick="kritis_p_2($('#induk').val())"> Detail</button>
                        </center>
                    </div>
                     <div class="col-sm-4">
                         <center>
                             <label>Kontrak Kritis Kategori 3</label>
                            <button type="submit" class="btn btn-primary" id="kritis_3" onclick="kritis_p_3($('#induk').val())"> Detail</button>
                         </center>
                     </div>
                    
                </div>
                               
            </div>
        </div>
    </div>
</div>
<div id="posisi_p" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">List Program RKAP Investasi Berdasarkan Posisip</h3>
            <button type="submit"  id="closePosisi_p" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group row col-lg-9">
                        <label class="col-lg-2">Jenis Posisi</label>
                        <div class="col-lg-4">
                            <select id="show_d_posisi_p" class="form-control">
                            </select>
                        </div>
                        <button type="submit" onclick="cari_posisi_p($('#induk').val())" class="btn btn-primary uppercase"><div class="fa fa-search"></div> CARI</button>
                        <button type="submit" onclick="print_cari_posisi_p($('#induk').val())" class="btn btn-warning uppercase"><div class="fa fa-file-o"></div> Cetak Pdf</button>
                    </div>
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover yellow" id="list_posisi_p">
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Jumlah Posisi</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Realisasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbod>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_posisi_p" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Berdasarkan Status</h3>
            <button type="submit"  id="closeD_posisi_p" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover yellow" id="detail_posisi_pusat">
                            <thead>
                                <tr>
                                    <th>SUB RKAP INV</th>
                                    <th>Cabang</th>
                                    <th>Judul Investasi</th>
                                    <th>Kebutuhan</th>
                                    <th>Nilai RKAP</th>
                                    <th>Posisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Program Investasi Status-->
<!-- Modal Kontrak Kritis -->
<div id="kontrak_p" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">List Program RKAP Investasi</h3>
            <button type="submit"  id="closeKontrak_p" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group row col-lg-8">
                     
                        <div class="col-lg-4">
                           <button type="submit" onclick="print_kontrak_p($('#induk').val())" class="btn btn-warning uppercase"><div class="fa fa-file-o"></div> Cetak Pdf</button>
                        </div>
                    
                        
                    </div>
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover" id="list_prog_inv_pusat">
                            <thead>
                                <tr>
                                   <th>Cabang</th>
                                    <th>Kebutuhan Dana</th>
                                    <th>Total RKAP</th>
                                    <th>Total Realisasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="status_p" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">List Program RKAP Investasi Berdasarkan Status</h3>
            <button type="submit"  id="closeStatus_p" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group row col-lg-8">
                        <label class="col-lg-2">Jenis Status</label>
                        <div class="col-lg-4">
                            <select id="show_d_status_p" class="form-control">
                            </select>
                        </div>
                        <button type="submit" onclick="cari_status_p($('#induk').val())" class="btn btn-primary uppercase"><div class="fa fa-search"></div> CARI</button>
                        <button type="submit" onclick="print_cari_status_p($('#induk').val())" class="btn btn-warning uppercase"><div class="fa fa-file-o"></div> Cetak Pdf</button>
                    </div>
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover green" id="list_status_p">
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Jumlah Status</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Realisasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Program Investasi Posisi-->


<!-- Program Investasi Kendala-->
<div id="kendala_p" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">List Program RKAP Investasi Berdasarkan Kendala</h3>
            <button type="submit"  id="closeKendala_p" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group row col-lg-9">
                        <label class="col-lg-2">Jenis kendala</label>
                        <div class="col-lg-4">
                            <select id="show_d_kendala_p" class="form-control">
                            </select>
                        </div>
                        <button type="submit" onclick="cari_kendala_p($('#induk').val())" class="btn btn-primary uppercase"><div class="fa fa-search"></div> CARI</button>
                        <button type="submit" onclick="print_cari_kendala_p($('#induk').val())" class="btn btn-warning uppercase"><div class="fa fa-file-o"></div> Cetak Pdf</button>
                    </div>
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover red" id="list_kendala_p">
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Jumlah Kendala</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Realisasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kontrak_p" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Program Investasi</h3>
            <button type="submit"  id="closeD_kontrak_p" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover" id="detail_prog_inv">
                            <thead>
                                <tr>
                                    <th>Cabang</th>
                                    <th>Judul RKAP</th>
                                    <th>Nilai Kebutuhan</th>
                                    <th>Nilai RKAP</th>
                                    <th>Realisasi Bulan Pelaporan</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kritis_1_p" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Kontrak Kritis Kategori 1</span></h3>
            <button type="submit"  id="closeKritis1_p" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover" id="show_detail_kritis_1_p">
                            <thead>
                                <tr>
                                    <th>Judul Investasi</th>
                                    <th>Sub Program</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kritis_2_p" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Kontrak Kritis Kategori 2</span></h3>
            <button type="submit"  id="closeKritis2_p" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover" id="show_detail_kritis_2_p">
                            <thead>
                                <tr>
                                    <th>Judul Investasi</th>
                                    <th>Sub Program</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kritis_3_p" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Kontrak Kritis Kategori 3</span></h3>
            <button type="submit"  id="closeKritis3_p" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover" id="show_detail_kritis_3_p">
                            <thead>
                                <tr>
                                    <th>Judul Investasi</th>
                                    <th>Sub Program</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kritis_1" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Kontrak Kritis Kategori 1</h3>
            <button type="submit"  id="closeKritis1" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover green" id="show_detail_kritis_1">
                            <thead>
                                <tr>
                                    <th>Judul Investasi</th>
                                    <th>Sub Program</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kritis_2" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Kontrak Kritis Kategori 2</h3>
            <button type="submit"  id="closeKritis2" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover yellow" id="show_detail_kritis_2">
                            <thead>
                                <tr>
                                    <th>Judul Investasi</th>
                                    <th>Sub Program</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kritis_3" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Kontrak Kritis Kategori 3</h3>
            <button type="submit"  id="closeKritis3" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover red" id="show_detail_kritis_3">
                            <thead>
                                <tr>
                                    <th>Judul Investasi</th>
                                    <th>Sub Program</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kritis_1_awal" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Kontrak Kritis Kategori 1</h3>
            <button type="submit"  id="closeKritis1_awal" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover green" id="show_detail_kritis_1_awal">
                            <thead>
                                <tr>
                                    <th>Judul Investasi</th>
                                    <th>Sub Program</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kritis_2_awal" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Kontrak Kritis Kategori 2</h3>
            <button type="submit"  id="closeKritis2_awal" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover yellow" id="show_detail_kritis_2_awal">
                            <thead>
                                <tr>
                                    <th>Judul Investasi</th>
                                    <th>Sub Program</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kritis_3_awal" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Kontrak Kritis Kategori 3</h3>
            <button type="submit"  id="closeKritis3_awal" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover red" id="show_detail_kritis_3_awal">
                            <thead>
                                <tr>
                                    <th>Judul Investasi</th>
                                    <th>Sub Program</th>
                                    <th>Nilai RKAP</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Nilai Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Pusat -->
<div id="detail_status_p" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Berdasarkan Status <span id="nama_cabang"></span></h3>
            <button type="submit"  id="closeD_status_p" class="btn btn-danger btn-sm pull-right" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover green" id="detail_status_pusat">
                            <thead>
                                <tr>
                                    <th>Judul RKAP</th>
                                    <th>SUB RKAP INV</th>
                                    <th>Jenis</th>
                                    <th>Nilai RKAP</th>
                                    <th>Realisasi Bulan Pelaporan</th>
                                    <th>Status</th>
                                    <th>Kendala</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detail_kendala_p" class="modal-size">
    <div class="panel panel-default" style="margin-top: 4cm;">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Detail Berdasarkan Kendala</span></h3>
            <button type="submit"  id="closeD_kendala_p" class="btn btn-danger btn-sm pull-right red" data-lilili="tooltip" title="Close"><span class="fa fa-close"></span></button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="container" style="padding: 0px;">
                    <div class="form-group col-sm-9">
                        <table class="table table-striped table-hover red" id="detail_kendala_pusat">
                            <thead>
                                <tr>
                                    <th>Judul RKAP</th>
                                    <th>SUB RKAP INV</th>
                                    <th>Jenis</th>
                                    <th>Nilai RKAP</th>
                                    <th>Realisasi Bulan Pelaporan</th>
                                    <th>Status</th>
                                    <th>Kendala</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function myFunction() {
    window.print();
}
</script>
