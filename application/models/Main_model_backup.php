<script type="text/javascript">
    window.onload=function(){
        $("#dashboard").attr("class","site-menu-item active");
    }
</script>
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

    .black > thead > tr > th {
        vertical-align: bottom;
        background-color: #000000 !important;
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

    .modal-responsive {
        width: 800px;
        margin-top: 0px;
}
    
    .modal-size {
                width: 1000px;
                height: 500px;
                position: absolute;
                right: 1cm  ;
                top: 83px;
                opacity: 0.9;
                display: none;
            }
    
    @media(max-width: 768px){
            .modal-responsive {
                width: 700px !important;
                margin-left: 107px;
        }
            .modal-size {
                width: 700px;
                height: 500px;
                position: absolute;
                right: 1cm  ;
                top: 83px;
                opacity: 0.9;
                display: none;
            }       
    }

    @media(max-width: 414px){
            .modal-responsive {
                width: 393px !important;
                margin-left: 438px;
                margin-top: 170px;
        }   

        .modal-size {
                width: 393px;
                height: 500px;
                position: absolute;
                right: 1cm  ;
                top: 83px;
                opacity: 0.9;
                display: none;
            }      
    }

    @media(max-width: 375px){
            .modal-responsive {
                width: 366px !important;
                margin-left: 475px;
                margin-top: 170px;
        }    

        .modal-size {
                width: 366px;
                height: 500px;
                position: absolute;
                right: 1cm  ;
                top: 83px;
                opacity: 0.9;
                display: none;
            }      
    }

    @media(max-width: 360px){
            .modal-responsive {
                width: 340px !important;
                margin-left: 490px;
                margin-top: 170px;
        }    

        .modal-size {
                width: 340px;
                height: 500px;
                position: absolute;
                right: 1cm  ;
                top: 83px;
                opacity: 0.9;
                display: none;
            }     
    }

        .btn-custom {
        background: #599de2;
        color: white;
        border-radius: 0px;
        padding: 7px;
    }

    .li-custom {
        padding: 1.5%;
    }

    .li-custom:hover {
        background-color: #e8e8e8;
    }
    
    .amcharts-chart-div{
        max-height:680px !important;
    }
    
    .row {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      margin-right: -1.0715rem;
    }
    
    
    
    .cards{
        margin-bottom:15px;
        padding-bottom:10px;
        background-color:#FFF;
    }
    
    .newTable{
         font-size:13px !important
    }
    
    .headTable{
        font-weight:bold;
        background-color:#F3F3F3;
    }
    
    .btnHead{
        width:100px;
    }
    
    a{
        text-decoration:none;
        color:#666;
        cursor:pointer;
    }
    
    a:hover{
        text-decoration:none;
        color:#F60;
    }
    
</style>
<div class="page">
    <div class="page-content">
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
        
        </div>
        <!-- END PAGE HEAD -->
        <ul class="page-breadcrumb breadcrumb" style="display:none">
            <li>
                <i class="fa fa-home fa-lg"></i>
                <a href="<?php echo base_url(); ?>home" style="color: #787305">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
        <!-- BEGIN PAGE CONTENT INNER -->
        <!-- BEGIN DASHBOARD STATS 1-->
        
      
        <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 3 OR $this->session->userdata('SESS_USER_POSITION') == 1) : ?>​
        <div>
        <div class="headAccount">
            <i class="icon md-dot-circle-alt"></i> Dashboard Pusat <span style="color:#CCC">|</span> 
            <span style="color:#F60">PT.Pelabuhan Indonesia 2 (Persero)</span>
            <span style="float:right;font-weight:500">
                <i class="icon md-account"></i> 
                <?php echo $this->session->userdata("SESS_USER_NAME"); ?>
            </span>
        </div>

        <div class="rows">
          <div class="col-xl-4 col-md-6">
            <!-- Widget Linearea One-->
            <div class="cards card-shadow" id="widgetLineareaOne">
              <div style="padding:20px 10px 0px 20px">
                    <div class="rows" style="padding:0px 20px">
                        <div>
                            <img src="<?php echo base_url() ?>assets/flat/computer.png"  style="height:60px" />
                        </div>
                        <div style="padding-left:20px">
                            <div>
                              <div class="grey-800 float-left py-10">
                                <i class="icon md-chart grey-600 font-size-24 vertical-align-bottom mr-5"></i>
                                Export
                                <div class="grey-500">
                                    <i class="icon md-long-arrow-down green-500 font-size-16"></i>
                                    Rekapitulasi KPI Fisik
                                </div>
                                <a class="dashboard-stat dashboard-stat-v2 blue-madison" href="<?php echo base_url(); ?>report/export_kpi_fisik">
                                <button class="btn btn-primary btn-block btn-round" style="z-index:0;margin-top:10px;width:10em">
                                    Process
                                 </button>
                                 </a>
                              </div>
                            </div>
                        </div>
                    </div>  
              </div>
            </div>
            <!-- End Widget Linearea One -->
          </div>
          
          <div class="col-xl-4 col-md-6">
            <!-- Widget Linearea Two -->
            <div class="cards card-shadow" id="widgetLineareaTwo">
              <div style="padding:20px 10px 0px 20px">
                <div class="rows" style="padding:0px 20px">
                        <div>
                            <img src="<?php echo base_url() ?>assets/flat/laptop.png" style="height:60px" />
                        </div>
                        <div style="padding-left:20px">
                            <div>
                              <div class="grey-800 float-left py-10">
                                <i class="icon md-view-list grey-600 font-size-24 vertical-align-bottom mr-5"></i>
                                Export
                                <div class="grey-500">
                                    <i class="icon md-long-arrow-down green-500 font-size-16"></i>
                                    Rekapitulasi KPI Program
                                </div>
                                <a class="dashboard-stat dashboard-stat-v2 red-haze" href="<?php echo base_url(); ?>report/export_kpi_program">
                                    <button class="btn btn-primary btn-block btn-round" style="z-index:0;margin-top:10px;width:10em">
                                        Process
                                     </button>
                                 </a>
                              </div>
                            </div>
                        </div>
                    </div>
              </div>
            </div>
            <!-- End Widget Linearea Two -->
          </div>
          
          
          <div class="col-xl-4 col-md-6">
            <!-- Widget Linearea Three -->
            <div class="cards card-shadow">
              <div style="padding:20px 10px 0px 20px">
                <div class="rows" style="padding:0px 20px">
                        <div>
                            <img src="<?php echo base_url() ?>assets/flat/analytics.png" style="height:60px"  />
                        </div>
                        <div style="padding-left:20px">
                            <div >
                              <div class="grey-800 py-10">
                                        <i class="icon md-flash grey-600 font-size-24 vertical-align-bottom mr-5"></i>
                                        Export
                                        <div class="grey-500">
                                            <i class="icon md-long-arrow-down green-500 font-size-16"></i>
                                             Rekapitulasi MMR
                                        </div>
                                        <a class="dashboard-stat dashboard-stat-v2 red-haze" href="<?php echo base_url(); ?>report/export_MMR">
                                            <button class="btn btn-primary btn-block  btn-round" style="z-index:0;margin-top:10px;width:10em">
                                                Process
                                            </button> 
                                         </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div> 
            </div>
         </div>
        </div>
      <div>
      
        <?php elseif($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 2 OR $this->session->userdata('SESS_USER_POSITION') == 4): ?>
        <?php else: ?>
            <div>
            <div class="headAccount">
                <i class="icon md-dot-circle-alt"></i> Dashboard <span id="NAME_DASHBOARD" style="color:#F60"></span>
                <span style="float:right;font-weight:500">
                    <i class="icon md-account"></i> 
                    <?php echo $this->session->userdata("SESS_USER_NAME"); ?>
                </span>
            </div>
            
            <div class="rows">
              <div class="col-lg-3">
                <!-- Card -->
                <a class="dashboard-stat dashboard-stat-v2 blue-madison" href="#" onclick="modalEWSkontrak()">
                <div class="cards" style="padding:15px 20px">
                <div class="rows">
                    <div class="col-lg-4" align="center">
                        <div class="white" align="center">
                            <img src="<?php echo base_url() ?>assets/flat/statistics2.png" style="height:60px" />
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="counter-number-group">
                      <span style="font-size:28px;font-weight:500">
                        <?php
                            if ($total_kontrak_kritis->KETERLAMBATAN) 
                                echo $total_kontrak_kritis->KETERLAMBATAN;
                            else
                                echo '0';
                        ?>
                      </span>
                      <div class="counter-label text-capitalize font-size-14" style="font-weight:500">Kontrak Kritis</div>
                    </div>
                    </div>
                </div>
                </div>
                </a>
                <!-- End Card -->
              </div>
              
              
               <div class="col-lg-3">
                <!-- Card -->
                 <a class="dashboard-stat dashboard-stat-v2 red-haze" href="javascript:void(0)" onclick="modalEWSsubprogram()">
                
                <div class="cards" style="padding:15px 20px">
                <div class="rows">
                    <div class="col-lg-4" align="center">
                        <div class="white" align="center">
                            <img src="<?php echo base_url() ?>assets/flat/statistics.png" style="height:60px" />
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="counter-number-group">
                      <span style="font-size:28px;font-weight:500">
                        <?php
                            if ($total_start_sub_program->START_SUB_PROGRAM) 
                                echo $total_start_sub_program->START_SUB_PROGRAM;
                            else
                                echo '0';
                        ?>
                      </span>
                      <div class="counter-label text-capitalize font-size-14" style="font-weight:500">Start Sub Program</div>
                    </div>
                    </div>
                </div>
                </div>
                </a>
               
                <div>
                                    
                </div>
                <!-- End Card -->
              </div>

              <div class="col-lg-3">
                <!-- Card -->
                <a class="dashboard-stat dashboard-stat-v2 purple-plum" style="background:#44b6ae;" href="javascript:void(0)" 
                onclick="modalEWSrealisasi()">
                <div class="cards" style="padding:15px 20px">
                <div class="rows">
                    <div class="col-lg-4" align="center">
                        <div class="white" align="center">
                            <img src="<?php echo base_url() ?>assets/flat/charts.png" style="height:60px" />
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="counter-number-group">
                      <span style="font-size:28px;font-weight:500">
                        <?php
                            if ($total_realisasi_pelaporan->REALISASI_PELAPORAN) 
                                echo $total_realisasi_pelaporan->REALISASI_PELAPORAN;
                            else
                                echo '0';
                        ?>
                      </span>
                      <div class="counter-label text-capitalize font-size-14" style="font-weight:500">Input Realisasi</div>
                    </div>
                    </div>
                </div>
                </div>
                </a>
                <!-- End Card -->
              </div>
              
              
               <div class="col-lg-3">
                <!-- Card -->
                <a class="dashboard-stat dashboard-stat-v2 purple-plum" href="javascript:void(0)" onclick="modalEWSkontrakBA()">
                <div class="cards" style="padding:15px 20px">
                <div class="rows">
                    <div class="col-lg-4" align="center">
                        <div class="white" align="center">
                            <img src="<?php echo base_url() ?>assets/flat/laptop.png" style="height:60px" />
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="counter-number-group">
                      <span style="font-size:28px;font-weight:500">
                        <?php
                            if ($total_kontrak_b_a->KONTRAK_B_A) 
                                echo $total_kontrak_b_a->KONTRAK_B_A;
                            else
                                echo '0';
                        ?>
                      </span>
                      <div class="counter-label text-capitalize font-size-14" style="font-weight:500">Kontrak Berakhir</div>
                    </div>
                    </div>
                </div>
                </div>
                </a>
              </div>
              
            </div>
        <div>
      
            
         <?php endif; ?>
        
        
        <div class="col-md-12 col-sm-12">
            <?php if ($this->session->flashdata('login')): ?>
                <div class="note note-info note-bordered" style="display:none">
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
        </div>
                
        
        <div class="divMaps">
            <?php if ($this->session->userdata('SESS_USER_PRIV') == 1): ?>
                <div>
                    <table>
                        <tr>
                            <td width="294">
                                <select class="form-control" id="induk" >
                                    <option value="0">
                                      Perusahaan Induk
                                    </option>
                                     
                                    <option value="2">
                                      Anak Perusahaan
                                    </option>
                                  </select>
                            </td>
                            <td width="50">
                                <button class="btn btn-success" onclick="induk($('#induk').val())" style="z-index:0">View</button>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php else: ?>
            <?php endif; ?>
            </div>
            <div id="mapss" style="padding: 0px 0 0px 0;">
                <div id="chartdiv"></div>
            </div>
        </div>
        
    </div>
    
    
</div>

<!-- END CONTENT -->
</div>

<div id="modal_all" style=" display: none;">
    <div class="row">
        <div class="panel panel-default modal-responsive" style="margin-bottom:0 !important;">
            <div class="headPanel">
                <button type="submit"  id="close_all" class="btn btn-danger btn-sm pull-right" ><span class="fa fa-close"></span></button>
                <center><h3 class="panel-title" style="padding-top:7.5px;color:#FFF">Dashboard Konsolidasi</h3></center>
            </div>
            
            <div class="panel-body">
                 <div class="col-md-12">
                   <center>
                        <img src="<?php echo base_url(); ?>assets/img/ipc_logo.png" class="img-responsive ipc-image">
                   </center><br>
                </div>
               
                
                <div class="rows">
                    <div class="col-sm-3">
                        <center>
                            <div id="all_gaugeDetails1" class="gaugeKritis"></div>
                            Realisasi Fisik<br>&nbsp;
                            <span class="btn btn-xs btn-danger" id="value_realisasi_all" style="margin-top: 30px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                        <center>
                            <div id="all_gaugeDetails2" class="gaugeKritis"></div>
                            KPI Realisasi <br> Program<br>
                            <span class="btn btn-xs btn-danger" id="value_program_all" style="margin-top: 10px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                        <div id="all_gaugeDetails3" class="gaugeKritis"></div>
                        <center>KPI Realisasi <br> Fisik</center>
                    </div>
                    
                    <div class="col-sm-3">
                        <div id="all_pieDetails4" class="gaugeKritis"></div>
                        <center>Status Program<br> Investasi</center>
                    </div>
                    
                </div>
                
                
                <div class="rows" style="margin-top: 50px !important">
                    <div class="col-md-6" >
                        <div style="padding-bottom: 30px"><b>Posisi Program Investasi</b></div>
                        <div class="example-wrap">
                            <div >
                                <div class="h-160"  data-plugin="scrollable">
                                    <div data-role="container">
                                        <div data-role="content" id="posisi_investasi_all" >
                                            
                                            <div style="height: 400px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" >
                        <div style="padding-bottom: 30px"><b>Kendala Program Investasi</b></div>
                        <div class="example-wrap">
                            <div >
                                <div class="h-160"  data-plugin="scrollable">
                                    <div data-role="container">
                                        <div data-role="content" id="kendala_investasi_all" >
                                            
                                            <div style="height: 400px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="rows">
                    <div class="col-sm-4">
                        <center>
                        <div id="all_gaugeKritis4" class="gaugeKritis"></div>
                        <label >Kontrak Kritis Kategori 1</label><br />
                        <button type="submit" class="btn btn-primary" id="kritis_1_all" onclick="kritis_p_all()"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                         <div id="all_gaugeKritis5" class="gaugeKritis"></div>
                        <label>Kontrak Kritis Kategori 2</label><br />
                        <button type="submit" class="btn btn-primary" id="kritis_1_all" onclick="kritis_p_2_all()"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="all_gaugeKritis6" class="gaugeKritis"></div>
                        <label>Kontrak Kritis Kategori 3</label><br />
                        <button type="submit" class="btn btn-primary" id="kritis_3_all" onclick="kritis_p_3_all()"> Detail</button>
                        </center>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_kritis_1_all" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 1</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div style="padding:20px 20px">
            <div class="rows">
              <table class="table table-striped table-hover w-full newTable" id="show_detail_kritis_1_all">
                <thead>
                  <tr>
                    <th><b>Unit</b></th>
                    <th><b>Judul Investasi</b></th>
                    <th><b>Sub Program</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Nilai Kontrak</b></th>
                    <th><b>Nilai Realisasi</b></th>
                    <th><b>Keterlambatan</b></th>
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-warning" id="detail_kritis_2_all" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 2</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div style="padding:20px 20px">
            <div class="rows">
              <table class="table table-striped table-hover w-full newTable" id="show_detail_kritis_2_all">
                <thead>
                  <tr>
                    <th><b>Unit</b></th>
                    <th><b>Judul Investasi</b></th>
                    <th><b>Sub Program</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Nilai Kontrak</b></th>
                    <th><b>Nilai Realisasi</b></th>
                    <th><b>Keterlambatan</b></th>
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-danger" id="detail_kritis_3_all" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 3</h4>
        <button type="button" class="btn btn-warning" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div style="padding:20px 20px">
            <div class="rows">
              <table class="table table-striped table-hover w-full newTable" id="show_detail_kritis_3_all">
                <thead>
                  <tr>
                    <th><b>Unit</b></th>
                    <th><b>Judul Investasi</b></th>
                    <th><b>Sub Program</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Nilai Kontrak</b></th>
                    <th><b>Nilai Realisasi</b></th>
                    <th><b>Keterlambatan</b></th>
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
</div>


<div id="placeholder_awal" style=" display: none;">
    <div class="row">
        <div class="panel panel-default modal-responsive" style="margin-bottom:0 !important;">
            <div class="headPanel" style="background-color:#069">
                <!-- <?php foreach ($result as $post): ?>
                    <?php echo $post->BRANCH_NAME; ?> 
                <?php endforeach ?> -->
                <button type="submit"  id="close_place_awal" class="btn btn-danger btn-sm pull-right"><span class="fa fa-close"></span></button>
                <center>
                    <h3 class="panel-title" style="padding-top: 7.5px;color:#FFF">
                        Dashboard Perusahaan <span id="DISPLAY_NAME"></span>
                    </h3>
                </center>
            </div>
            <div class="panel-body">
                <div class="rows" align="center" style="margin-bottom:20px">
                    <br>
                    <div class="col-md-12" >
                        <button type="submit" class="btn btn-xs btn-success" id="infoKontrak" 
                        onClick="kontrak_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" 
                        style="margin-bottom:5px;">Lihat Program Investasi</button>
                        
                        <button type="submit" id="infoStatus" onClick="status_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" 
                        class="btn btn-xs btn-success" 
                        style="margin-bottom:5px;">Status Program</button>
                        
                        
                        <button type="submit" id="infoPosisi" onClick="posisi_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" 
                        class="btn btn-xs btn-success" 
                        style="margin-bottom:5px;">Posisi Program</button>
                        
                        <button type="submit" id="infoKendala" onClick="kendala_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" 
                        class="btn btn-xs btn-success" 
                        style="margin-bottom:5px;">Program Terkendala</button>
                    </div>
                </div>
                
                <div class="rows">
                    <div class="col-sm-3">
                        <center>
                            <div id="gaugeDetails1awal" class="gaugeKritis"></div>
                            Realisasi Fisik<br>&nbsp;
                            <span class="btn btn-xs btn-danger" id="value_realisasi_awal" style="margin-top: 30px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                        
                        <center>
                            <div id="gaugeDetails2awal" class="gaugeKritis"></div>
                            KPI Realisasi <br> Program<br>
                            <span class="btn btn-xs btn-danger" id="value_program_awal" style="margin-top: 10px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                        <div id="gaugeDetails3awal" class="gaugeKritis"></div>
                        <center>KPI Realisasi <br> Fisik</center>
                    </div>
                    
                    <div class="col-sm-3">
                        <div id="pieDetails4awal" class="gaugeKritis"></div>
                        <center>Status Program<br> Investasi</center>
                    </div>
                </div>
                
                <div class="rows" style="margin-top: 50px !important">
                    <!-- <div class="col-md-6" >
                        <label>Posisi Program Invetasi</label>
                        <div id="tabung1awal"></div>
                    </div>
                    <div class="col-md-6" >
                        <label>Kendala Program Invetasi</label>
                        <div id="tabung2awal"></div>
                    </div> -->
                    <div class="col-md-6" >
                        <div style="padding-bottom: 30px"><b>Posisi Program Investasi</b></div>
                        <div class="example-wrap">
                            <div >
                                <div class="h-160"  data-plugin="scrollable">
                                    <div data-role="container">
                                        <div data-role="content" id="posisi_investasi_awal" >
                                            
                                            <div style="height: 400px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" >
                        <div style="padding-bottom: 30px"><b>Kendala Program Investasi</b></div>
                        <div class="example-wrap">
                            <div >
                                <div class="h-160"  data-plugin="scrollable">
                                    <div data-role="container">
                                        <div data-role="content" id="kendala_investasi_awal" >
                                            
                                            <div style="height: 400px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="rows">
                    <div class="col-sm-4">
                        <center>
                         <div id="gaugeKritisawal" class="gaugeKritis"></div>
                        <label >Kontrak Kritis Kategori 1</label><br />
                        <button type="submit" class="btn btn-success btn-round" id="kritis_1_awal" onClick="kritis_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="gaugeKritis2awal" class="gaugeKritis"></div>
                        <label>Kontrak Kritis Kategori 2</label><br />
                        <button type="submit" class="btn btn-success btn-round" id="kritis_2_awal" onClick="kritis_2_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="gaugeKritis3awal" class="gaugeKritis"></div>
                        <label>Kontrak Kritis Kategori 3</label><br />
                        <button type="submit" class="btn btn-success btn-round" id="kritis_3_awal" onClick="kritis_3_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"> Detail</button>
                        </center>
                    </div>
                </div>        
            </div>
        </div>
    </div>
    
   
</div>


<div id="placeholder" style=" display: none;">
    <div class="row">
        <div class="panel panel-default modal-responsive" style="margin-bottom:0 !important;">
            <div class="headPanel" style="background-color:#3f51b5">
                <!-- <?php foreach ($result as $post): ?>
                    <?php echo $post->BRANCH_NAME; ?> 
                <?php endforeach ?> -->
                <button type="submit"  id="close" class="btn btn-danger btn-sm pull-right"><span class="fa fa-close"></span></button>
                <center>
                    <h3 class="panel-title" style="padding-top: 7.5px;color:#FFF">
                        Dashboard Perusahaan <span id="cabang"></span>
                    </h3>
                </center>
            </div>
            <div class="panel-body">
                <div class="rows" align="center" style="margin-bottom:20px">
                    <br>
                    <div class="col-md-12" >
                        <button type="submit" class="btn btn-xs btn-success" id="infoKontrak" onclick="kontrak(id_branch)" 
                        style="margin-bottom:5px;">Lihat Program Investasi</button>
                        
                        <button type="submit" id="infoStatus" onclick="status(id_branch)" class="btn btn-xs btn-success" 
                        style="margin-bottom:5px;">Status Program</button>
                        
                        
                        <button type="submit" id="infoPosisi" onclick="posisi(id_branch)" class="btn btn-xs btn-success" 
                        style="margin-bottom:5px;">Posisi Program</button>
                        
                        <button type="submit" id="infoKendala" onclick="kendala(id_branch)" class="btn btn-xs btn-success" 
                        style="margin-bottom:5px;">Program Terkendala</button>
                    </div>
                </div>
                
                <div class="rows">
                    <div class="col-sm-3">
                        <center>
                            <div id="gaugeDetails1" class="gaugeKritis"></div>
                            Realisasi Fisik<br>&nbsp;
                            <span class="btn btn-xs btn-danger" id="value_realisasi" style="margin-top: 30px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                        
                        <center>
                            <div id="gaugeDetails2" class="gaugeKritis"></div>
                            KPI Realisasi <br> Program<br>
                            <span class="btn btn-xs btn-danger" id="value_program" style="margin-top: 10px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                        <div id="gaugeDetails3" class="gaugeKritis"></div>
                        <center>KPI Realisasi <br> Fisik</center>
                    </div>
                    
                    <div class="col-sm-3">
                        <div id="pieDetails4" class="gaugeKritis"></div>
                        <center>Status Program<br> Investasi</center>
                    </div>
                </div>
                
                <div class="rows" style="margin-top: 50px !important">
                    <!-- <div class="col-md-6" >
                        <label>Posisi Program Invetasi</label>
                        <div id="tabung1"></div>
                    </div>
                    <div class="col-md-6" >
                        <label>Kendala Program Invetasi</label>
                        <div id="tabung2"></div>
                    </div> -->
                    <div class="col-md-6" >
                        <div style="padding-bottom: 30px"><b>Posisi Program Investasi</b></div>
                        <div class="example-wrap">
                            <div >
                                <div class="h-160"  data-plugin="scrollable">
                                    <div data-role="container">
                                        <div data-role="content" id="posisi_investasi" >
                                            
                                            <div style="height: 400px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" >
                        <div style="padding-bottom: 30px"><b>Kendala Program Investasi</b></div>
                        <div class="example-wrap">
                            <div >
                                <div class="h-160"  data-plugin="scrollable">
                                    <div data-role="container">
                                        <div data-role="content" id="kendala_investasi" >
                                            
                                            <div style="height: 400px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="rows">
                    <div class="col-sm-4">
                        <center>
                         <div id="gaugeKritis" class="gaugeKritis"></div>
                        <label >Kontrak Kritis Kategori 1</label><br />
                        <button type="submit" class="btn btn-success btn-round" id="kritis_1" onclick="kritis(id_branch)"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="gaugeKritis2" class="gaugeKritis"></div>
                        <label>Kontrak Kritis Kategori 2</label><br />
                        <button type="submit" class="btn btn-success btn-round" id="kritis_2" onclick="kritis_2(id_branch)"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="gaugeKritis3" class="gaugeKritis"></div>
                        <label>Kontrak Kritis Kategori 3</label><br />
                        <button type="submit" class="btn btn-success btn-round" id="kritis_3" onclick="kritis_3(id_branch)"> Detail</button>
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

<div class="modal fade modal-fade-in-scale-up modal-primary" id="kontrak" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">List Program RKAP Investasi <span id="nama_cabang"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div align="right" style="margin-top:20px">
            <button type="submit" onclick="print_kontrak(id_branch)" class="btn btn-primary btn-round">
            Cetak Pdf
            </button>
          </div>
          <div style="padding:20px 20px">
            
            <div class="rows">
              <table class="table table-striped table-hover w-full newTable" id="list_prog_inv">
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
            <div class="rows">
              <table class="table table-striped table-hover newTable w-full">
                <thead>
                  <tr>
                    <th>Total Kebutuhan Dana</th>
                    <th>Total Nilai RKAP</th>
                    <th>Total Nilai Realisasi</th>
                  </tr>
                </thead>
                <tbody id="show_investasi" style="text-align: center;">
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="kontrak_awal" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">List Program RKAP Investasi <span id="cabang_name"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div align="right" style="margin-top:20px">
            <button type="submit" onClick="print_kontrak_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"
            class="btn btn-info btn-round">
            Cetak Pdf
            </button>
          </div>
          <div style="padding:20px 20px">
            
            <div class="rows">
              <table class="table table-striped table-hover newTable w-full" id="list_prog_inv_awal">
                <thead>
                  <tr class="headTable">
                    <th>Kode</th>
                    <th>Judul Investasi</th>
                    <th>Kebutuhan Dana</th>
                    <th>Nilai RKAP</th>
                    <th>Nilai realisasi</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              
            </div>
            <div class="rows">
              
              <table class="table table-striped table-hover newTable w-full">
                <thead>
                  <tr class="headTable">
                    <th>Total Kebutuhan Dana</th>
                    <th>Total Nilai RKAP</th>
                    <th>Total Nilai Realisasi</th>
                  </tr>
                </thead>
                <tbody id="show_investasi_awal" style="text-align: center;">
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="status" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">List Program RKAP Investasi Berdasarkan Status <span id="nama_cabang3"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <div>
              <table>
                <tr style="font-size:13px">
                  <td width="56">
                    Status :
                  </td>
                  <td width="268">
                    <select id="show_d_status" class="form-control">
                    </select>
                  </td>
                  <td width="475">
                    &nbsp;&nbsp;
                    <button type="submit" onclick="cari_status()" class="btn btn-success btn-round btnHead">
                    Cari
                    </button>
                    
                    <button type="submit" onclick="print_status()" class="btn btn-primary btn-round btnHead">
                    Cetak Pdf
                    </button>
                  </td>
                </tr>
              </table>
            </div>
            
            <br />
            
            <div>
              <table class="table table-striped table-hover newTable" id="list_status">
                <thead>
                  <tr class="headTable">
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="status_awal" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">List Program RKAP Investasi Berdasarkan Status <span id="nama_cabang3"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <div>
              <table>
                <tr style="font-size:13px">
                  <td width="56">
                    Status :
                  </td>
                  <td width="268">
                    <select id="show_d_status_awal" class="form-control">
                    </select>
                  </td>
                  <td width="475">
                    &nbsp;&nbsp;
                    <button type="submit" onclick="cari_status_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"
                    class="btn btn-success btn-round btnHead">
                    Cari
                    </button>
                    
                    <button type="submit" onclick="print_status_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"
                    class="btn btn-info btn-round btnHead">
                    Cetak Pdf
                    </button>
                  </td>
                </tr>
              </table>
            </div>
            
            <br />
            
            <div>
              <table class="table table-striped table-hover newTable" id="list_status_awal">
                <thead>
                  <tr class="headTable">
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="posisi" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">List Program RKAP Investasi Berdasarkan Posisi <span id="nama_cabang3"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <div>
              <table>
                <tr style="font-size:13px">
                  <td width="96">
                    Jenis Posisi :
                  </td>
                  <td width="239">
                    <select id="show_d_posisi" class="form-control">
                    </select>
                  </td>
                  <td width="464">
                    &nbsp;&nbsp;
                    <button type="submit" onclick="cari_posisi()" class="btn btn-success btn-round btnHead">
                    Cari
                    </button>
                    
                    <button type="submit" onclick="print_posisi()" class="btn btn-primary btn-round btnHead">
                    Cetak Pdf
                    </button>
                  </td>
                </tr>
              </table>
            </div>
            
            <br />
            
            <div>
              <table class="table table-striped table-hover newTable" id="list_posisi">
                <thead>
                  <tr class="headTable">
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="posisi_awal" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">List Program RKAP Investasi Berdasarkan Posisi <span id="cabang_nama2"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <div>
              <table>
                <tr style="font-size:13px">
                  <td width="96">
                    Jenis Posisi :
                  </td>
                  <td width="239">
                    <select id="show_d_posisi_awal" class="form-control">
                    </select>
                  </td>
                  <td width="464">
                    &nbsp;&nbsp;
                    <button type="submit" onclick="cari_posisi_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"
                    class="btn btn-success btn-round btnHead">
                    Cari
                    </button>
                    
                    <button type="submit" onclick="print_posisi_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"
                    class="btn btn-info btn-round btnHead">
                    Cetak Pdf
                    </button>
                  </td>
                </tr>
              </table>
            </div>
            
            <br />
            
            <div>
              <table class="table table-striped table-hover newTable" id="list_posisi_awal">
                <thead>
                  <tr class="headTable">
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="kendala" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">List Program RKAP Investasi Berdasarkan Kendala <span id="nama_cabang4"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <div>
              <table>
                <tr style="font-size:13px">
                  <td width="96">
                    Jenis Kendala :
                  </td>
                  <td width="254">
                    <select id="show_d_kendala" class="form-control">
                    </select>
                  </td>
                  <td width="449">
                    &nbsp;&nbsp;
                    <button type="submit" onclick="cari_kendala()" class="btn btn-success btn-round btnHead">
                    Cari
                    </button>
                    
                    <button type="submit" onclick="print_kendala()" class="btn btn-primary btn-round btnHead">
                    Cetak Pdf
                    </button>
                  </td>
                </tr>
              </table>
            </div>
            
            <br />
            
            <div>
              <table class="table table-striped table-hover newTable" id="list_kendala">
                <thead>
                  <tr class="headTable">
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="kendala_awal" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">List Program RKAP Investasi Berdasarkan Kendala <span id="nama_cabang4"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <div>
              <table>
                <tr style="font-size:13px">
                  <td width="96">
                    Jenis Kendala :
                  </td>
                  <td width="254">
                    <select id="show_d_kendala_awal" class="form-control">
                    </select>
                  </td>
                  <td width="449">
                    &nbsp;&nbsp;
                    <button type="submit" onclick="cari_kendala_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"
                    class="btn btn-success btn-round btnHead">
                    Cari
                    </button>
                    
                    <button type="submit" onclick="print_kendala_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"
                    class="btn btn-info btn-round btnHead">
                    Cetak Pdf
                    </button>
                  </td>
                </tr>
              </table>
            </div>
            
            <br />
            
            <div>
              <table class="table table-striped table-hover newTable" id="list_kendala_awal">
                <thead>
                  <tr class="headTable">
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
</div>

<!-- Detail Cabang -->
<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_status" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Berdasarkan Status <span id="nama_cabang"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div style="padding:20px 20px">
            
            <div class="rows">
              <table class="table table-hover w-full" id="show_detail_status" style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
                    <th><b>Unit</b></th>
                    <th><b>Judul RKAP</b></th>
                    <th><b>Sub RKAP Inv</b></th>
                    <th><b>Jenis</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Realisasi Bulan Pelaporan</b></th>
                    <th><b>Status</b></th>
                    <th><b>Kendala</b></th>
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_status_awal" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Berdasarkan Status <span id="nama_cabang"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div style="padding:20px 20px">
            
            <div class="rows">
              <table class="table table-hover w-full" id="show_detail_status_awal" style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
                    <th><b>Unit</b></th>
                    <th><b>Judul RKAP</b></th>
                    <th><b>Sub RKAP Inv</b></th>
                    <th><b>Jenis</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Realisasi Bulan Pelaporan</b></th>
                    <th><b>Status</b></th>
                    <th><b>Kendala</b></th>
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_posisi" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Berdasarkan Posisi</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div style="padding:20px 20px">
            
            <div class="rows">
              <table class="table table-hover w-full" id="show_detail_posisi" style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
                    <th><b>Unit</b></th>
                    <th><b>Judul RKAP</b></th>
                    <th><b>Nilai Kebutuhan</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Posisi</b></th>
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_posisi_awal" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Berdasarkan Posisi <span id="nama_cabang"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div style="padding:20px 20px">
            
            <div class="rows">
              <table class="table table-hover w-full" id="show_detail_posisi_awal" style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
                    <th><b>Unit</b></th>
                    <th><b>Judul RKAP</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Nilai Kebutuhan</b></th>
                    <th><b>Posisi</b></th>
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_kendala" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Berdasarkan Status <span id="nama_cabang"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div style="padding:20px 20px">
            
            <div class="rows">
              <table class="table table-hover w-full" id="show_detail_kendala" style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
                    <th><b>Unit</b></th>
                    <th><b>Judul RKAP</b></th>
                    <th><b>Sub RKAP Inv</b></th>
                    <th><b>Jenis</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Realisasi Bulan Pelaporan</b></th>
                    <th><b>Status</b></th>
                    <th><b>Kendala</b></th>
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_kendala_awal" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Berdasarkan Kendala <span id="nama_cabang"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div style="padding:20px 20px">
            <div class="rows">
              <table class="table table-hover w-full" id="show_detail_kendala_awal" style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
                    <th><b>Unit</b></th>
                    <th><b>Judul RKAP</b></th>
                    <th><b>Sub RKAP Inv</b></th>
                    <th><b>Jenis</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Realisasi Bulan Pelaporan</b></th>
                    <th><b>Status</b></th>
                    <th><b>Kendala</b></th>
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
</div>

<!-- Modal Pusat -->
<div id="modal_pusat" style=" display: none;">
    <div class="rows">
        <div class="panel panel-default modal-responsive" style="margin-bottom:0 !important;">
            <div class="headPanel">
                <button id="close_modal" class="btn btn-danger btn-sm pull-right"><span class="fa fa-close"></span></button>
                <center>
                    <h3 class="panel-title" style="padding-top: 7.5px;color:#FFF" id="name_perusahaan">
                        <i class="icon md-chart"></i> Dashboard Perusahaan 
                    </h3>
                </center>
            </div>
            <div class="panel-body">
                <!-- <div class="rows" align="center" style="margin-bottom:20px">
                    <br>
                    <div class="col-md-12" >
                        <button type="submit" class="btn btn-xs btn-success" id="infoKontrak_p" onclick="kontrak_p($('#induk').val())" 
                        style="margin-bottom:5px;">Lihat Program Investasi</button>
                        
                        <button type="submit" id="infoStatus_p" onclick="status_p($('#induk').val())" class="btn btn-xs btn-success" 
                        style="margin-bottom:5px;">Status Program</button>
                        
                        
                        <button type="submit" id="infoPosisi_p" onclick="posisi_p($('#induk').val())" class="btn btn-xs btn-success" 
                        style="margin-bottom:5px;">Posisi Program</button>
                        
                        <button type="submit" id="infoKendala" onclick="kendala_p($('#induk').val())" class="btn btn-xs btn-success" 
                        style="margin-bottom:5px;">Program Terkendala</button>
                    </div>
                </div> -->
                
                <!-- <div class="rows">
                    <div class="col-sm-3">
                        <center>
                            <div id="p_gaugeDetails1" class="gaugeKritis"></div>
                            Realisasi Fisik<br>&nbsp;
                            <span class="btn btn-xs btn-danger" id="value_realisasi_pusat" style="margin-top: 30px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                        
                        <center>
                            <div id="p_gaugeDetails2" class="gaugeKritis"></div>
                            KPI Realisasi <br> Program<br>
                            <span class="btn btn-xs btn-danger" id="value_program_pusat" style="margin-top: 10px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                        <div id="p_gaugeDetails3" class="gaugeKritis"></div>
                        <center>KPI Realisasi <br> Fisik</center>
                    </div>
                    
                    <div class="col-sm-3">
                        <div id="p_pieDetails4" class="gaugeKritis"></div>
                        <center>Status Program<br> Investasi</center>
                    </div>
                </div> -->
                
                <div class="rows">
                    <div>
                        <div style="padding-bottom: 30px"><b>Posisi Program Investasi</b></div>
                        <div class="example-wrap">
                            <div >
                                <div class="h-160"  data-plugin="scrollable">
                                    <div data-role="container">
                                        <div data-role="content" id="posisi_investasi_pusat" >
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="example-wrap">
                        <h4 class="example-title">Shadow</h4>
                          <div class="example">
                            <div class="h-300" data-skin="scrollable-shadow" data-plugin="scrollable">
                              <div data-role="container">
                                <div data-role="content">
                                  Habet voluptatibus umbram licet cyrenaicisque simplicem
                                    diis profecto liberavisse. Sola videri exercitumque,
                                    gaudere conclusum minorem importari potiora torquatos,
                                    illa animadvertat. Perinde discordiae totum delectu
                                    disseruerunt physici eligendi percussit. Disputata
                                    aristippus totus, alia putant, dolore facere censet
                                    utrumque litterae, scientia aliqua scriptum paulo addidisti
                                    locus.
                                  Has quisquis quin disseruerunt sentiunt inquit quae.
                                    Dolore vicinum maximam gloriae explicavi qua homero
                                    afferat, consul aiunt opera ancillae complectitur proprius
                                    quaeritur accommodare leniter, ars docui inportuno
                                    distrahi gravitate insatiabiles pater patet ferre litterae,
                                    adversarium transferrem secutus conformavit sanciret
                                    satis sensu multo, perciperet partiendo.
                                  Deterritum acutum mutae poenis, volumus novi. Erga dignissimos
                                    fortitudo existunt utrumque usque frui beate provocatus
                                    perferendis, perpessio voluerint. O, horum amotio,
                                    culpa aequitatem rationem iucunditas sapiens mediocrium
                                    epicurei. Istius beata necessitatibus praesentibus
                                    arbitratu, quaerendum controversia pronuntiaret, praesentium
                                    notae solemus ambigua tempore simul cepisse. Armatum.
                                  Saluto plato falsis, idem nosmet adiungimus, blanditiis
                                    horreat, gaudere perspiciatis statuam fabulas legendam,
                                    credo brutus multitudinem migrare his o moderatio infinitio,
                                    prompta quas derigatur scripserit parta accedit ego
                                    tamquam expectat, efficiatur sinat facta saepti, dissentiunt
                                    monstruosi cotidieque vacuitate initia hoc iudicabit
                                    vacuitate vis, quietem.
                                  Iuberet brevis delectamur virtute haeret divinum gubernatoris
                                    doctrina soliditatem is, miser disputata copulationesque
                                    concursio effecerit. Commodi platonis aeterno reperietur
                                    intus pluribus terrore triarium pulcherrimum quamquam,
                                    impetum declinare ea scribere disputationi odia, inesse
                                    possent bonae quippe inquam gymnasia parabilis assumenda
                                    superstitio uberius, timiditatem loco corrupti.
                                  Adiungimus disputata reperiuntur placatae vide ruinae
                                    reliquaque epicuri nostri, profecta modi administrari
                                    utuntur torquatis, tenebo, cruciantur dubitat servire
                                    reliquerunt explicabo coniuncta accusamus vituperari
                                    incursione. Philosophis diesque scriptorem exedunt
                                    aspernari. Interesse inutile finxerat ingenia, interrogari
                                    liber liberiusque regione usque successerit tenuit,
                                    dolorum odioque tradere appetere.
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    <!-- <div>
                        <div style="padding-bottom: 30px"><b>Kendala Program Investasi</b></div>
                        <div class="example-wrap">
                            <div >
                                <div class="h-160"  data-plugin="scrollable">
                                    <div data-role="container">
                                        <div data-role="content" id="kendala_investasi_all" >
                                            
                                            <div style="height: 400px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>

                
                <!-- <div class="rows">
                    <div class="col-sm-4">
                        <center>
                         <div id="gaugeKritis4" class="gaugeKritis"></div>
                        <label >Kontrak Kritis Kategori 1</label><br />
                        <button type="submit" class="btn btn-success btn-round" id="kritis_1" onclick="kritis_p($('#induk').val())"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="gaugeKritis5" class="gaugeKritis"></div>
                        <label>Kontrak Kritis Kategori 2</label><br />
                        <button type="submit" class="btn btn-success btn-round" id="kritis_2" onclick="kritis_p_2($('#induk').val())"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="gaugeKritis6" class="gaugeKritis"></div>
                        <label>Kontrak Kritis Kategori 3</label><br />
                        <button type="submit" class="btn btn-success btn-round" id="kritis_3" onclick="kritis_p_3($('#induk').val())"> Detail</button>
                        </center>
                    </div>
                </div>   -->      
            </div>
        </div>
    </div>
</div>





<div class="modal fade modal-fade-in-scale-up modal-primary" id="posisi_p" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">List Program RKAP Investasi Berdasarkan Posisi</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <div>
              <table>
                <tr style="font-size:13px">
                  <td width="85">
                    Jenis Posisi :
                  </td>
                  <td width="291">
                    <select id="show_d_posisi_p" class="form-control">
                    </select>
                  </td>
                  <td width="423">
                    &nbsp;&nbsp;
                    <button type="submit" onclick="cari_posisi_p($('#induk').val())" class="btn btn-success btn-round btnHead">
                    Cari
                    </button>
                    
                    <button type="submit" onclick="print_cari_posisi_p($('#induk').val())" class="btn btn-primary btn-round btnHead">
                    Cetak Pdf
                    </button>
                  </td>
                </tr>
              </table>
            </div>
            
            <br />
            
            <div>
              <table class="table table-hover w-full newTable" id="list_posisi_p">
                <thead>
                  <tr class="headTable">
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
              
              <br />
              
              <table class="table table-striped table-hover newTable">
                <thead>
                  <tr class="headTable">
                    <th>Total Posisi</th>
                    <th>Total Nilai RKAP</th>
                    <th>Total Nilai Realisasi</th>
                  </tr>
                </thead>
                <tbody id="show_posisi" style="text-align: center;">
                  
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_posisi_p" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Berdasarkan Posisi</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div style="padding:20px 20px">
            
            <div class="rows">
              <table class="table table-hover w-full" id="detail_posisi_pusat" style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
                    <th><b>Unit</b></th>
                    <th><b>Judul RKAP</b></th>
                    <th><b>Nilai Kebutuhan</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Posisi</b></th>
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
</div>



<div class="modal fade modal-fade-in-scale-up modal-primary" id="kontrak_p" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Program Investasi</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div align="right" style="margin-top:20px">
            <button type="submit" onclick="print_kontrak_p($('#induk').val())" class="btn btn-primary btn-round">
            Cetak Pdf
            </button>
          </div>
          <div style="padding:20px 20px">
            
            <div class="rows">
              <table class="table table-hover w-full" id="list_prog_inv_pusat" style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
                    <th><b>Cabang</b></th>
                    <th><b>Kebutuhan Dana</b></th>
                    <th><b>Total RKAP</b></th>
                    <th><b>Total Realisasi</b></th>
                    <th><b>Action</b></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <div class="rows">
              <table class="table table-hover dataTable w-full"  style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
                    <th><b>Total Kebutuhan Dana</b></th>
                    <th><b>Total Nilai RKAP</b></th>
                    <th><b>Total Nilai Realisasi</b></th>
                  </tr>
                </thead>
                <tbody id="show_inves" style="text-align: center;">
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="status_p" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">List Program RKAP Investasi Berdasarkan Status</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <div>
              <table>
                <tr style="font-size:13px">
                  <td width="56">
                    Status :
                  </td>
                  <td width="268">
                    <select id="show_d_status_p" class="form-control">
                    </select>
                  </td>
                  <td width="475">
                    &nbsp;&nbsp;
                    <button type="submit" onclick="cari_status_p($('#induk').val())" class="btn btn-success btn-round btnHead">
                    Cari
                    </button>
                    
                    <button type="submit" onclick="print_cari_status_p($('#induk').val())" class="btn btn-primary btn-round btnHead">
                    Cetak Pdf
                    </button>
                  </td>
                </tr>
              </table>
            </div>
            
            <br />
            
            <div>
              <table class="table table-hover w-full newTable" id="list_status_p">
                <thead>
                  <tr class="headTable">
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
              <br />
              <table class="table table-hover w-full newTable">
                <thead>
                  <tr class="headTable">
                    <th>Total Status</th>
                    <th>Total Nilai RKAP</th>
                    <th>Total Nilai Realisasi</th>
                  </tr>
                </thead>
                <tbody id="show_status" style="text-align: center;">
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="kendala_p" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">List Program RKAP Investasi Berdasarkan Kendala</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <div>
              <table>
                <tr style="font-size:13px">
                  <td width="106">
                    Jenis Kendala :
                  </td>
                  <td width="281">
                    <select id="show_d_kendala_p" class="form-control">
                    </select>
                  </td>
                  <td width="412">
                    &nbsp;&nbsp;
                    <button type="submit" onclick="cari_kendala_p($('#induk').val())" class="btn btn-success btn-round btnHead">
                    Cari
                    </button>
                    
                    <button type="submit" onclick="print_cari_kendala_p($('#induk').val())" class="btn btn-primary btn-round btnHead">
                    Cetak Pdf
                    </button>
                  </td>
                </tr>
              </table>
            </div>
            
            <br/>
            
            <div>
              <table class="table table-hover w-full newTable" id="list_kendala_p">
                <thead>
                  <tr class="headTable">
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
              
              <br />
              
              <table class="table table-striped table-hover newTable">
                <thead>
                  <tr class="headTable">
                    <th>Total Kendala</th>
                    <th>Total Nilai RKAP</th>
                    <th>Total Nilai Realisasi</th>
                  </tr>
                </thead>
                <tbody id="show_kendala" style="text-align: center;">
                  
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_kontrak_p" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Program Investasi</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div align="right" style="margin-top:20px">
            <!-- <button type="submit" onclick="print_kontrak_p($('#induk').val())" class="btn btn-primary btn-round">
            Cetak Pdf
            </button> -->
          </div>
          <div style="padding:20px 20px">
            
            <div class="rows">
              <table class="table table-hover w-full" id="detail_prog_inv" style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_kritis_1_p" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 1</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <table class="table table-striped w-full table-hover newTable" id="show_detail_kritis_1_p">
              <thead>
                <tr class="headTable">
                  <th>Unit</th>
                  <th>Judul Investasi</th>
                  <th>Sub Program</th>
                  <th>Nilai RKAP</th>
                  <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th>
                  <th>Keterlambatan</th>
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

<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_kritis_2_p" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 2</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <table class="table table-striped w-full table-hover newTable" id="show_detail_kritis_2_p">
              <thead>
                <tr class="headTable">
                  <th>Unit</th>
                  <th>Judul Investasi</th>
                  <th>Sub Program</th>
                  <th>Nilai RKAP</th>
                  <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th>
                  <th>Keterlambatan</th>
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




<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_kritis_3_p" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 3</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <table class="table table-striped table-hover w-full newTable" id="show_detail_kritis_3_p">
              <thead>
                <tr class="headTable">
                  <th>Unit</th>
                  <th>Judul Investasi</th>
                  <th>Sub Program</th>
                  <th>Nilai RKAP</th>
                  <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th>
                  <th>Keterlambatan</th>
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



<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_kritis_1" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 1</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <table class="table table-striped table-hover newTable w-full" id="show_detail_kritis_1">
              <thead>
                <tr class="headTable">
                  <th>Unit</th>
                  <th>Judul Investasi</th>
                  <th>Sub Program</th>
                  <th>Nilai RKAP</th>
                  <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th>
                  <th>Keterlambatan</th>
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


<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_kritis_2" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 2</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <table class="table table-striped table-hover newTable w-full" id="show_detail_kritis_2">
              <thead>
                <tr class="headTable">
                  <th>Unit</th>
                  <th>Judul Investasi</th>
                  <th>Sub Program</th>
                  <th>Nilai RKAP</th>
                  <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th>
                  <th>Keterlambatan</th>
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



<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_kritis_3" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 3</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <table class="table table-striped table-hover newTable w-full" id="show_detail_kritis_3">
              <thead>
                <tr class="headTable">
                  <th>Unit</th>
                  <th>Judul Investasi</th>
                  <th>Sub Program</th>
                  <th>Nilai RKAP</th>
                  <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th>
                  <th>Keterlambatan</th>
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




<div class="modal fade modal-fade-in-scale-up modal-info" id="detail_kritis_1_awal" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 1</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <table class="table table-striped table-hover newTable w-full" id="show_detail_kritis_1_awal">
              <thead>
                <tr class="headTable">
                  <th>Unit</th>
                  <th>Judul Investasi</th>
                  <th>Sub Program</th>
                  <th>Nilai RKAP</th>
                  <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th>
                  <th>Keterlambatan</th>
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




<div class="modal fade modal-fade-in-scale-up modal-warning" id="detail_kritis_2_awal" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 2</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <table class="table table-striped table-hover newTable w-full" id="show_detail_kritis_2_awal">
              <thead>
                <tr class="headTable">
                  <th>Unit</th>
                  <th>Judul Investasi</th>
                  <th>Sub Program</th>
                  <th>Nilai RKAP</th>
                  <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th>
                  <th>Keterlambatan</th>
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



<div class="modal fade modal-fade-in-scale-up modal-danger" id="detail_kritis_3_awal" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 3</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div style="margin:30px 5px">
          <div>
            <table class="table table-striped table-hover newTable w-full" id="show_detail_kritis_3_awal">
              <thead>
                <tr class="headTable">
                  <th>Unit</th>
                  <th>Judul Investasi</th>
                  <th>Sub Program</th>
                  <th>Nilai RKAP</th>
                  <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th>
                  <th>Keterlambatan</th>
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
<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_status_p" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Berdasarkan Status</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div style="padding:20px 20px">
            
            <div class="rows">
              <table class="table table-hover w-full" id="detail_status_pusat" style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
                    <th><b>Unit</b></th>
                    <th><b>Judul RKAP</b></th>
                    <th><b>SUB RKAP INV</b></th>
                    <th><b>Jenis</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Realisasi Bulan Pelaporan</b></th>
                    <th><b>Status</b></th>
                    <th><b>Kendala</b></th>
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
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_kendala_p" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Berdasarkan Kendala</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
        <div>
          <div style="padding:20px 20px">
            
            <div class="rows">
              <table class="table table-hover w-full" id="detail_kendala_pusat" style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
                    <th><b>Unit</b></th>
                    <th><b>Judul RKAP</b></th>
                    <th><b>SUB RKAP INV</b></th>
                    <th><b>Jenis</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Realisasi Bulan Pelaporan</b></th>
                    <th><b>Status</b></th>
                    <th><b>Kendala</b></th>
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
</div>


<div class="modal fade modal-fade-in-scale-up modal-success" id="modalEWS-kontrak-kritis" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-md">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Kontrak Kritis</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
            <div style="margin:30px 5px">
                <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                            <ul class="feeds">
                                <?php foreach ($detail_kontrak_kritis as $data) { ?>
                                    <?php $url = base_url()."rkapinvestasi/detail/".$data->RKAP_SUBPRO_INVS_ID?>
                                    <li class="li-custom">
                                        <a href="<?=$url?>">
                                            <div class="row">
                                                <div class="col-md-1 col-sm-1">
                                                    <button class="btn btn-custom"><i class="fa fa-briefcase"></i></button>
                                                </div>
                                                <div class="col-md-11 col-sm-11">
                                                    <?=$data->RKAP_INVS_TITLE;?>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
            </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade modal-fade-in-scale-up modal-success" id="modalEWS-start-sub-program" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-md">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Start Sub Program</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
            <div style="margin:30px 5px">
                <div class="portlet-body">
                        <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                            <ul class="feeds">
                                <?php foreach ($detail_start_sub_program as $data) { ?>
                                    <?php $url = base_url()."ganttchart/view/".$data->RKAP_SUBPRO_INVS_ID?>
                                    <li class="li-custom">
                                        <a href="<?=$url?>">
                                            <div class="row">
                                                <div class="col-md-1 col-sm-1">
                                                    <button class="btn btn-custom"><i class="fa fa-briefcase"></i></button>
                                                </div>
                                                <div class="col-md-11 col-sm-11">
                                                    <?=$data->RKAP_SUBPRO_TITTLE;?>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                   </div>
            </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade modal-fade-in-scale-up modal-success" id="modalEWS-realisasi-pelaporan" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-md">
    <div class="modal-content">
      <div class="modal-header" style="display:none">
        <h4 class="modal-title">Input Realisasi Pelaporan</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
            <div style="margin:30px 5px">
                <div class="portlet-body">
                        <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                            <ul class="feeds">
                                <?php foreach ($detail_realisasi_pelaporan as $data) { ?>
                                    <?php $url = base_url()."realisasi/view/".$data->RKAP_SUBPRO_ID; ?>
                                       <li class="li-custom">
                                            <a href="<?=$url?>">
                                                <div class="row">
                                                    <div class="col-md-1 col-sm-1">
                                                        <button class="btn btn-custom"><i class="fa fa-briefcase"></i></button>
                                                    </div>
                                                    <div class="col-md-11 col-sm-11">
                                                        <?=$data->RKAP_SUBPRO_TITTLE;?>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>                                    
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
            </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade modal-fade-in-scale-up modal-success" id="modalEWS-kontrak-B-A" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-md">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Input Realisasi Pelaporan</h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:440px">
            <div style="margin:30px 5px">
                <div class="portlet-body">
                        <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                            <ul class="feeds">
                                <?php foreach ($detail_kontrak_b_a as $data) { ?>
                                    <?php $url = base_url()."subprogramrkapinvestasi/detail/".$data->RKAP_SUBPRO_ID?>
                                    <li class="li-custom">
                                        <a href="<?=$url?>">
                                            <div class="row">
                                                <div class="col-md-1 col-sm-1">
                                                    <button class="btn btn-custom"><i class="fa fa-briefcase"></i></button>
                                                </div>
                                                <div class="col-md-11 col-sm-11">
                                                    <?=$data->RKAP_SUBPRO_TITTLE;?>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
            </div>
      </div>
    </div>
  </div>
</div>


