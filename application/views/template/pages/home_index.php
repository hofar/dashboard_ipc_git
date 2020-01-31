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

.parent{
    height: 100%;
    width: 100%;
    overflow: hidden;
}

.child{
    width: 100%;
    height: 100%;
    overflow-y: scroll;
    padding-right: 17px; /* Increase/decrease this value for cross-browser compatibility */
    box-sizing: content-box; /* So the width will be 100% + 17px */
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

                                 <div class="dropdown">
                                  <button class="btn btn-primary btn-block btn-round" style="z-index:0;margin-top:10px;width:10em" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Procces
                                  </button>
                                  <div class="dropdown-menu">
                                    <form class="px-4 py-3"  target="_blank" action="<?php echo base_url(); ?>report/export_kpi_fisik" method="GET">
                                      <div class="form-group">
                                        <label for="realisasifisik" style="width: 100%; text-align: center;">Pilih Waktu</label>
                                        <input type="text" class="form-control" name="tgl" id="realisasifisik" placeholder="" data-plugin="datepicker">
                                      </div>
                                      <button type="submit" style="width: 100%; text-align: center;" class="btn btn-primary">Download</button>
                                    </form>
                                  </div>
                                </div>

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
                                    <div class="dropdown">
                                  <button class="btn btn-primary btn-block btn-round" style="z-index:0;margin-top:10px;width:10em" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Procces
                                  </button>
                                  <div class="dropdown-menu">
                                    <form class="px-4 py-3" target="_blank" action="<?php echo base_url(); ?>report/export_MMR" method="GET">
                                      <div class="form-group">
                                        <label for="kpirealisasi" style="width: 100%; text-align: center;">Pilih Waktu</label>
                                        <input type="text" class="form-control" name="tgl" id="kpirealisasi" placeholder="" data-plugin="datepicker">
                                      </div>
                                      <button type="submit" style="width: 100%; text-align: center;" class="btn btn-primary">Download</button>
                                    </form>
                                  </div>
                                </div>
                              		</div>
                            	</div>
                        	</div>
                    	</div>
                   </div> 
            </div>
         </div>
        </div>
      <div>
      
        <?php elseif($this->session->userdata('SESS_USER_POSITION') == 4): ?>
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
                        	<img src="<?php echo base_url() ?>assets/flat/statistics22.png" style="height:60px" />
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
                      <div class="counter-label text-capitalize font-size-14" style="font-weight:500">Kontrak Akan Berakhir</div>
                    </div>
                    </div>
                </div>
                </div>
                </a>
              </div>
              
          	</div>
      	<div>
      
            
         <?php endif; ?>

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
                <div class="headAccount">
                    <i class="fa fa-exclamation-circle"></i> Pemberitahuan <span style="color:#CCC">|</span> 
                    <span style="color:#F60">Anda memiliki <b><?php echo $notif_announcement; ?></b> pemberitahuan, silahkan cek dimenu pengumuman atau klik link 
                        <b><a href="<?php echo base_url(); ?>announcement" class="btn btn-xs btn-danger waves-effect waves-classic">Disini</a></b>
                    </span>
                </div>
                <?php endif ?>
            <?php endif ?>
            
        
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
                                <button class="btn yayan-1" onclick="induk($('#induk').val())" style="z-index:0">View</button>
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
            <div class="headPanel" style="background-color:#144967">
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
                      <div id="graph111" style="width:120px; height:120px"></div>
                        	Realisasi Fisik<br>&nbsp;
                            <span class="btn btn-xs yayan-1" id="value_realisasi_all" style="margin-top: 30px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                    	<center>
                      <div id="graph222" style="width:120px; height:120px"></div>
                            KPI Realisasi <br> Program<br>
                            <span class="btn btn-xs yayan-1" id="value_program_all" style="margin-top: 10px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3" style="text-align: -webkit-center;">
                    <div id="graph333" style="width:120px; height:120px"></div>
                    	<center>KPI Realisasi <br> Fisik</center>
                    </div>
                    
                    <div class="col-sm-3">
                    	<div id="all_pieDetails4" class="gaugeKritis"></div>
                    	<center>Status Program<br> Investasi</center>
                    </div>
                    
                </div>
                
                
                <div class="rows" style="margin-top: 20px !important">
                    <div class="col-md-6" >
                        <div style="padding-bottom: 10px"><b>Posisi Program Investasi</b></div>
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
                                        <div data-role="content" id="kendala_investasi_all" style="padding-right: 10px;">
                                            
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
                        <div id="graph444" style="width:120px; height:120px"></div>
                        <label >Kontrak Kritis Kategori 1</label><br />
                        <button type="submit" class="btn yayan-2" id="kritis_1_all" onclick="kritis_p_all()"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="graph555" style="width:120px; height:120px"></div>
                        <label>Kontrak Kritis Kategori 2</label><br />
                        <button type="submit" class="btn yayan-2" id="kritis_1_all" onclick="kritis_p_2_all()"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="graph666" style="width:120px; height:120px"></div>
                        <label>Kontrak Kritis Kategori 3</label><br />
                        <button type="submit" class="btn yayan-2" id="kritis_3_all" onclick="kritis_p_3_all()"> Detail</button>
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
                    <th><b>Nilai</b></th>
                    <!-- <th><b>Nilai Kontrak</b></th>
                    <th><b>Nilai Realisasi</b></th> -->
                    <th><b>Keterlambatan</b></th>
                    <th><b>Action</b></th>
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
                    <th><b>Nilai</b></th>
                    <!-- <th><b>Nilai Kontrak</b></th>
                    <th><b>Nilai Realisasi</b></th> -->
                    <th><b>Keterlambatan</b></th>
                    <th><b>Action</b></th>
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
                    <th><b>Nilai</b></th>
                    <!-- <th><b>Nilai Kontrak</b></th>
                    <th><b>Nilai Realisasi</b></th> -->
                    <th><b>Keterlambatan</b></th>
                    <th><b>Action</b></th>
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
            <div class="headPanel" style="background-color:#144967">
                <!-- <?php foreach ($result as $post): ?>
                    <?php echo $post->BRANCH_NAME; ?> 
                <?php endforeach ?> -->
                <button type="submit"  id="close_place_awal" class="btn btn-danger btn-sm pull-right"><span class="fa fa-close"></span></button>
                <center>
                	<h3 class="panel-title" style="padding-top: 7.5px;color:#FFF">
                		Dashboard Perusahaan <span id="cabangawal"></span>
                    </h3>
                </center>
            </div>
            <div class="panel-body">
                <div class="rows" align="center" style="margin-bottom:20px">
                	<br>
                    <div class="col-md-12" >
                    	<button type="submit" class="btn btn-xs yayan-11" id="infoKontrak" 
                        onClick="kontrak_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" 
                        style="margin-bottom:5px; ">Lihat Program Investasi</button>
                        
                        <button type="submit" id="infoStatus" onClick="status_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" 
                        class="btn btn-xs  yayan-11" style="margin-bottom:5px;">Status Program</button>

                        <button type="submit" id="infoReporting" onClick="reporting_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" 
                        class="btn btn-xs  yayan-11" style="margin-bottom:5px;">Report</button>
                        
                        <!-- <button type="submit" id="infoReport" onClick="report_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" 
                        class="btn btn-xs btn-success" style="margin-bottom:5px;">Report</button> -->
                        
                        <button type="submit" id="infoPosisi" onClick="posisi_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" 
                        class="btn btn-xs  yayan-11" 
                        style="margin-bottom:5px;">Posisi Program</button>
                        
                        <button type="submit" id="infoKendala" onClick="kendala_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" 
                        class="btn btn-xs  yayan-11" 
                        style="margin-bottom:5px;">Program Terkendala</button>
                    </div>
                </div>
                
                <div class="rows">
                	<div class="col-sm-3">
                    	<center>
                      <div id="graph1" style="width:120px; height:120px"></div>
                        	Realisasi Fisik<br>&nbsp;
                            <span class="btn btn-xs  yayan-1" id="value_realisasi_awal" style="margin-top: 30px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                    	
                    	<center>
                      <div id="graph2" style="width:120px; height:120px"></div>
                            KPI Realisasi <br> Program<br>
                            <span class="btn btn-xs  yayan-1" id="value_program_awal" style="margin-top: 10px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3" style="text-align: -webkit-center;">
                    <div id="graph3" style="width:120px; height:120px;"></div>
                    	<center>KPI Realisasi <br> Fisik</center>
                    </div>
                    
                    <div class="col-sm-3">
                    	<div id="pieDetails4awal" class="gaugeKritis"></div>
                    	<center>Status Program<br> Investasi</center>
                    </div>
                </div>
                
                <div class="rows" style="margin-top: 20px !important">
                	<!-- <div class="col-md-6" >
                        <label>Posisi Program Invetasi</label>
                        <div id="tabung1awal"></div>
                    </div>
                    <div class="col-md-6" >
                        <label>Kendala Program Invetasi</label>
                        <div id="tabung2awal"></div>
                    </div> -->
                    <div class="col-md-6" >
                        <div style="padding-bottom: 10px"><b>Posisi Program Investasi</b></div>
                        <div class="example-wrap" style="margin-bottom:20px">
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
                        <div class="example-wrap" style="margin-bottom:20px">
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
                        <div id="graph4" style="width:120px; height:120px"></div>
                        <label >Kontrak Kritis Kategori 1</label><br />
                        <button type="submit" class="btn yayan-2 btn-round" id="kritis_1_awal" onClick="kritis_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="graph5" style="width:120px; height:120px"></div>
                        <label>Kontrak Kritis Kategori 2</label><br />
                        <button type="submit" class="btn yayan-2 btn-round" id="kritis_2_awal" onClick="kritis_2_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="graph6" style="width:120px; height:120px"></div>
                        <label>Kontrak Kritis Kategori 3</label><br />
                        <button type="submit" class="btn yayan-2 btn-round" id="kritis_3_awal" onClick="kritis_3_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)"> Detail</button>
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
            <div class="headPanel" style="background-color:#144967">
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
                    	<button type="submit" class="btn btn-xs yayan-11" id="infoKontrak" onclick="kontrak(id_branch)" 
                        style="margin-bottom:5px;">Lihat Program Investasi</button>
                        
                        <button type="submit" id="infoStatus" onclick="status(id_branch)" class="btn btn-xs yayan-11" 
                        style="margin-bottom:5px;">Status Program</button>
                        
                        <button type="submit" id="infoReport" onclick="reporting(id_branch)" class="btn btn-xs yayan-11" 
                        style="margin-bottom:5px;">Report</button>

                        <!-- <button type="submit" id="infoReport" onclick="report(id_branch)" class="btn btn-xs btn-success" 
                        style="margin-bottom:5px;">Report</button> -->
                        
                        <button type="submit" id="infoPosisi" onclick="posisi(id_branch)" class="btn btn-xs yayan-11" 
                        style="margin-bottom:5px;">Posisi Program</button>
                        
                        <button type="submit" id="infoKendala" onclick="kendala(id_branch)" class="btn btn-xs yayan-11" 
                        style="margin-bottom:5px;">Program Terkendala</button>
                    </div>
                </div>
                
                <div class="rows">
                	<div class="col-sm-3">
                    	<center>
                      <div id="graph1d" style="width:120px; height:120px"></div>
                        	Realisasi Fisik<br>&nbsp;
                            <span class="btn btn-xs yayan-1" id="value_realisasi" style="margin-top: 30px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                    	
                    	<center>
                      <div id="graph2d" style="width:120px; height:120px"></div>
                            KPI Realisasi <br> Program<br>
                            <span class="btn btn-xs yayan-1" id="value_program" style="margin-top: 10px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                    <div id="graph3d" style="width:120px; height:120px"></div>
                    	<center>KPI Realisasi <br> Fisik</center>
                    </div>
                    
                    <div class="col-sm-3">
                    	<div id="pieDetails4" class="gaugeKritis"></div>
                    	<center>Status Program<br> Investasi</center>
                    </div>
                </div>
                
                <div class="rows" style="margin-top: 20px !important">
                	<!-- <div class="col-md-6" >
                        <label>Posisi Program Invetasi</label>
                        <div id="tabung1"></div>
                    </div>
                    <div class="col-md-6" >
                        <label>Kendala Program Invetasi</label>
                        <div id="tabung2"></div>
                    </div> -->
                    <div class="col-md-6" >
                        <div style="padding-bottom: 10px"><b>Posisi Program Investasi</b></div>
                        <div class="example-wrap" style="margin-bottom: 30px;">
                            <div >
                                <div class="h-160"  style="overflow-y: scroll">
                                    <div>
                                        <div id="posisi_investasi" >
                                            
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
                                <div class="h-160" style="overflow-y: scroll">
                                    <div >
                                        <div id="kendala_investasi" style="padding-right: 10px;">
                                            
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
                        <div id="graph4d" style="width:120px; height:120px"></div>
                        <label >Kontrak Kritis Kategori 1</label><br />
                        <button type="submit" class="btn yayan-2 btn-round" id="kritis_1" onclick="kritis(id_branch)"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="graph5d" style="width:120px; height:120px"></div>
                        <label>Kontrak Kritis Kategori 2</label><br />
                        <button type="submit" class="btn yayan-2 btn-round" id="kritis_2" onclick="kritis_2(id_branch)"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="graph6d" style="width:120px; height:120px"></div>
                        <label>Kontrak Kritis Kategori 3</label><br />
                        <button type="submit" class="btn yayan-2 btn-round" id="kritis_3" onclick="kritis_3(id_branch)"> Detail</button>
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
                    <th>-></th>
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
  <div class="modal-dialog modal-simple modal-lg" style="">
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
                    <td>opt</td>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              
            </div>
            <!-- <div class="rows">
              <table class="table table-striped table-hover newTable w-full">
                <thead>
                  <tr class="headTable">
                    <th>Kode</th>
                    <th>Judul Investasi</th>
                    <th>Kebutuhan Dana</th>
                    <th>Nilai RKAP</th>
                    <th>Nilai realisasi</th>
                  </tr>
                </thead>
                <tbody id="show_test">
                </tbody>
              </table>
              
            </div> -->
            <div class="rows">
              
              <table class="table table-striped table-hover newTable w-full">
                <thead>
                  <tr class="headTable">
                    <th>Total Kebutuhan Dana</th>
                    <th>Total Nilai RKAP</th>
                    <th>Total Realisasi</th>
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
                    <th><b>Tahun RKAP</b></th>
                    <th><b>Judul RKAP Inv</b></th>
                    <th><b>Nilai Kebutuhan</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Nilai Total Realisasi</b></th>
                    <th><b>Status</b></th>
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
                    <th><b>Tahun Inv</b></th>
                    <th><b>Judul Inv</b></th>
                    <th><b>Judul Sub Program</b></th>
                    <th><b>Total Presentase</b></th>
                    <th><b>Status</b></th>
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
                    <th><b>Tahun Inv</b></th>
                    <th><b>Judul Inv</b></th>
                    <th><b>Judul Sub Program</b></th>
                    <th><b>Nilai Realisasi</b></th>
                    <th><b>Status</b></th>
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
    <div class="row">
        <div class="panel panel-default modal-responsive" style="margin-bottom:0 !important;">
            <div class="headPanel" style="background-color:#144967">
                <!-- <?php foreach ($result as $post): ?>
                    <?php echo $post->BRANCH_NAME; ?> 
                <?php endforeach ?> -->
                <button id="close_modal" class="btn btn-danger btn-sm pull-right"><span class="fa fa-close"></span></button>
                <center>
                	<h3 class="panel-title" style="padding-top: 7.5px;color:#FFF" id="name_perusahaan">
                		<i class="icon md-chart"></i> Dashboard Perusahaan 
                    </h3>
                </center>
            </div>
            <div class="panel-body">
                <div class="rows" align="center" style="margin-bottom:20px">
                	<br>
                    <div class="col-md-12" >
                    	<button type="submit" class="btn btn-xs yayan-11" id="infoKontrak_p" onclick="kontrak_p($('#induk').val())" 
                        style="margin-bottom:5px;">Lihat Program Investasi</button>
                        
                        <button type="submit" id="infoStatus_p" onclick="status_p($('#induk').val())" class="btn btn-xs yayan-11" 
                        style="margin-bottom:5px;">Status Program</button>
                        
                        
                        <button type="submit" id="infoPosisi_p" onclick="posisi_p($('#induk').val())" class="btn btn-xs yayan-11" 
                        style="margin-bottom:5px;">Posisi Program</button>
                        
                        <button type="submit" id="infoKendala" onclick="kendala_p($('#induk').val())" class="btn btn-xs yayan-11" 
                        style="margin-bottom:5px;">Program Terkendala</button>
                    </div>
                </div>
                
                <div class="rows">
                	<div class="col-sm-3">
                    	<center>
                      <div id="graph11" style="width:120px; height:120px"></div>
                        	Realisasi Fisik<br>&nbsp;
                            <span class="btn btn-xs yayan-1" id="value_realisasi_pusat" style="margin-top: 30px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3">
                    	
                    	<center>
                      <div id="graph22" style="width:120px; height:120px"></div>
                            KPI Realisasi <br> Program<br>
                            <span class="btn btn-xs yayan-1" id="value_program_pusat" style="margin-top: 10px;"></span>
                        </center>
                    </div>
                    
                    <div class="col-sm-3" style="text-align: -webkit-center;">
                    <div id="graph33" style="width:120px; height:120px"></div>
                    	<center>KPI Realisasi <br> Fisik</center>
                    </div>
                    
                    <div class="col-sm-3">
                    	<div id="p_pieDetails4" class="gaugeKritis"></div>
                    	<center>Status Program<br> Investasi</center>
                    </div>
                </div>
                
                <div class="rows" style="margin-top: 30px !important">
                	<!-- <div class="col-md-6" >
                        <label>Posisi Program Invetasi</label>
                        <div id="p_tabung1"></div>
                    </div>
                    <div class="col-md-6" >
                        <label>Kendala Program Invetasi</label>
                        <div id="p_tabung2"></div>
                    </div> -->
                     <div class="col-md-6" >
                        <div style="padding-bottom: 30px"><b>Posisi Program Investasi</b></div>
                        <div class="example-wrap">
                            <div >
                                <div class="h-160" style="overflow-y: auto;">
                                    <div>
                                        <div id="posisi_investasi_pusat" >
                                            
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
                                <div class="h-160"  style="overflow-y: scroll">
                                    <div >
                                        <div id="kendala_investasi_pusat" style="padding-right: 10px;">
                                            
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
                        <div id="graph44" style="width:120px; height:120px"></div>
                        <label >Kontrak Kritis Kategori 1</label><br />
                        <button type="submit" class="btn yayan-2 btn-round" id="kritis_1" onclick="kritis_p($('#induk').val())"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="graph55" style="width:120px; height:120px"></div>
                        <label>Kontrak Kritis Kategori 2</label><br />
                        <button type="submit" class="btn yayan-2 btn-round" id="kritis_2" onclick="kritis_p_2($('#induk').val())"> Detail</button>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                        <div id="graph66" style="width:120px; height:120px"></div>
                        <label>Kontrak Kritis Kategori 3</label><br />
                        <button type="submit" class="btn yayan-2 btn-round" id="kritis_3" onclick="kritis_p_3($('#induk').val())"> Detail</button>
                        </center>
                    </div>
                </div>        
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
                  <th>Nilai</th>
                  <!-- <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th> -->
                  <th>Keterlambatan</th>
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

<div class="modal fade modal-fade-in-scale-up modal-warning" id="detail_kritis_2_p" aria-hidden="true"
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
                  <th>Nilai</th>
                  <!-- <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th> -->
                  <th>Keterlambatan</th>
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




<div class="modal fade modal-fade-in-scale-up modal-danger" id="detail_kritis_3_p" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 3</h4>
        <button type="button" class="btn btn-warning" data-dismiss="modal" style="float:right">Close</button>
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
                  <th>Nilai</th>
                  <!-- <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th> -->
                  <th>Keterlambatan</th>
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
                  <!-- <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th> -->
                  <th>Keterlambatan</th>
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


<div class="modal fade modal-fade-in-scale-up modal-warning" id="detail_kritis_2" aria-hidden="true"
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
                  <!-- <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th> -->
                  <th>Keterlambatan</th>
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



<div class="modal fade modal-fade-in-scale-up modal-danger" id="detail_kritis_3" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 3</h4>
        <button type="button" class="btn btn-warning" data-dismiss="modal" style="float:right">Close</button>
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
                  <!-- <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th> -->
                  <th>Keterlambatan</th>
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




<div class="modal fade modal-fade-in-scale-up modal-primary" id="detail_kritis_1_awal" aria-hidden="true"
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
                  <th>Nilai</th>
                  <!-- <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th> -->
                  <th>Keterlambatan</th>
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
                  <th>Nilai</th>
                  <!-- <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th> -->
                  <th>Keterlambatan</th>
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



<div class="modal fade modal-fade-in-scale-up modal-danger" id="detail_kritis_3_awal" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Detail Kontrak Kritis Kategori 3</h4>
        <button type="button" class="btn btn-warning" data-dismiss="modal" style="float:right">Close</button>
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
                  <th>Nilai</th>
                  <!-- <th>Nilai Kontrak</th>
                  <th>Nilai Realisasi</th> -->
                  <th>Keterlambatan</th>
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
              <table class="table table-hover w-full" id="detail_status_ps" style="font-size:13px !important">
                <thead>
                  <tr style="background-color:#F7F7F7;">
                    <th><b>Unit</b></th>
                    <th><b>Tahun RKAP</b></th>
                    <th><b>Judul RKAP Inv</b></th>
                    <th><b>Nilai Kebutuhan</b></th>
                    <th><b>Nilai RKAP</b></th>
                    <th><b>Nilai Total Realisasi</b></th>
                    <th><b>Status</b></th>
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
                    <th><b>Tahun Inv</b></th>
                    <th><b>Judul Inv</b></th>
                    <th><b>Judul Sub Program</b></th>
                    <th><b>Nilai Realisasi</b></th>
                    <th><b>Status</b></th>
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


<div class="modal fade modal-fade-in-scale-up modal-primary" id="modalEWS-kontrak-kritis" aria-hidden="true"
    aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-md">
        <div class="modal-content">
            <div class="modal-header" style="display:nne">
                <h4 class="modal-title">Kontrak Kritis</h4>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" style="float:right">X</button>
            </div>
            <div class="modal-body" style="overflow-y:scroll; height:440px">
                <div style="margin:30px 5px">
                    <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                        <?php foreach ($detail_kontrak_kritis as $data) { ?>
                        <?php $url = base_url()."subprogramrkapinvestasi/detail/".$data->RKAP_SUBPRO_ID?>
                        <a href="<?=$url?>">
                            <blockquote class="blockquote custom-blockquote blockquote-info">
                                <p class="mb-0"><?=$data->RKAP_SUBPRO_TITTLE;?></p>
                            </blockquote>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade modal-fade-in-scale-up modal-primary" id="modalEWS-start-sub-program" aria-hidden="true"
    aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-md">
        <div class="modal-content">
            <div class="modal-header" style="display:nne">
                <h4 class="modal-title">Start Sub Program</h4>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" style="float:right">X</button>
            </div>
            <div class="modal-body" style="overflow-y:scroll; height:440px">
                <div style="margin:30px 5px">
                    <div class="portlet-body">
                        <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                            <?php foreach ($detail_start_sub_program as $data) { ?>
                            <?php $url = base_url()."subprogramrkapinvestasi/detail/".$data->RKAP_SUBPRO_ID?>
                            <a href="<?=$url?>">
                                <blockquote class="blockquote custom-blockquote blockquote-info">
                                    <p class="mb-0"><?=$data->RKAP_SUBPRO_TITTLE;?></p>
                                    <footer class="blockquote-footer">akan dimulai pada <?=$data->RKAP_SUBPRO_CONTRACT_DATE;?>
                                    </footer>
                                </blockquote>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade modal-fade-in-scale-up modal-primary" id="modalEWS-realisasi-pelaporan" aria-hidden="true"
    aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-md">
        <div class="modal-content">
            <div class="modal-header" style="display:nne">
                <h4 class="modal-title">Input Realisasi</h4>
                <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">X</button>
            </div>
            <div class="modal-body" style="overflow-y:scroll; height:440px">
                <div style="margin:30px 5px">
                    <div class="portlet-body">
                        <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                            <?php foreach ($detail_realisasi_pelaporan as $data) { ?>
                            <?php $url = base_url()."realisasi/view/".$data->RKAP_SUBPRO_ID?>
                            <a href="<?=$url?>">
                                <blockquote class="blockquote custom-blockquote blockquote-info">
                                    <p class="mb-0"><?=$data->RKAP_SUBPRO_TITTLE;?></p>
                                    <footer class="blockquote-footer">Mohon segera isi realisasi pada program ini
                                    </footer>
                                </blockquote>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade modal-fade-in-scale-up modal-primary" id="modalEWS-kontrak-B-A" aria-hidden="true"
    aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-md">
        <div class="modal-content">
            <div class="modal-header" style="display:nne">
                <h4 class="modal-title">Kontrak akan berakhir</h4>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" style="float:right">X</button>
            </div>
            <div class="modal-body" style="overflow-y:scroll; height:440px">
                <div style="margin:30px 5px">
                    <div class="portlet-body">
                        <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                            <?php foreach ($detail_kontrak_b_a as $data) { ?>
                            <?php $url = base_url()."subprogramrkapinvestasi/detail/".$data->RKAP_SUBPRO_ID?>
                            <a href="<?=$url?>">
                                <blockquote class="blockquote custom-blockquote blockquote-info">
                                    <p class="mb-0"><?=$data->RKAP_SUBPRO_TITTLE;?></p>
                                    <footer class="blockquote-footer">Kontrak program ini akan segera berakhir pada <?=$data->RKAP_SUBPRO_END_REAL;?>
                                    </footer>
                                </blockquote>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- REPORT -->
<div class="modal fade modal-fade-in-scale-up modal-primary" id="reporting_awal" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-md">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Report Detail MMR <span id="nama_cabang3"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll;">
        <div style="margin:30px 5px">
          <div>
            <div>
              <table>
                <tr style="font-size:13px">
                  <td width="56">
                    Tanggal :
                  </td>
                  <td width="150">
                    <input id="report_date" type="text" class="form-control" data-plugin="datepicker" onchange="get_report_date()" name="report_date" placeholder="Awal">
                    <input id="show_month" type="hidden" name="report_month">
                    <input id="show_years" type="hidden" name="report_years">
                  </td>
                  <td width="150">
                    <input id="report_date12" type="text" class="form-control" data-plugin="datepicker" onchange="get_report_date12()" name="report_date12" placeholder="Akhir">
                    <input id="show_month12" type="hidden" name="report_month12">
                    <input id="show_years12" type="hidden" name="report_years12">
                  </td>
                  <td>
                    <button id="btn_report_date" onclick="report_awal(<?php echo $this->session->userdata('SESS_USER_BRANCH') ?>)" class="btn btn-info" disabled="">
                    Cetak Laporan
                    </button>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-fade-in-scale-up modal-primary" id="reporting" aria-hidden="true"
  aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple modal-md">
    <div class="modal-content">
      <div class="modal-header" style="display:nne">
        <h4 class="modal-title">Report Detail MMR <span id="nama_cabang2"></span></h4>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right">Close</button>
      </div>
      <div class="modal-body" style="overflow-y:scroll;">
        <div style="margin:30px 5px">
          <div>
            <div>
              <table>
                <tr style="font-size:13px">
                  <td width="56">
                    Tanggal :
                  </td>
                  <td width="150">
                    <input id="report_date2" type="text" class="form-control" data-plugin="datepicker" onchange="get_report_date2()" placeholder="Awal">
                    <input id="show_month2" type="hidden" name="report_month">
                    <input id="show_years2" type="hidden" name="report_years">
                    <input id="show_tanggal" type="hidden" name="report_date">
                  </td>
                  <td width="150">
                    <input id="report_date21" type="text" class="form-control" data-plugin="datepicker" onchange="get_report_date21()" placeholder="Akhir">
                    <input id="show_month21" type="hidden" name="report_month21">
                    <input id="show_years21" type="hidden" name="report_years21">
                    <input id="show_tanggal21" type="hidden" name="report_date21">
                  </td>
                  <td>
                    <button id="btn_report_date2" onclick="report(id_branch)" class="btn btn-info" disabled="">
                    Cetak Laporan
                    </button>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="myDiv">
    
</div>

<!-- Modal -->
<?php
if (count($popupindikator) > 0) {
  ?>
<div class="modal fade" id="BannerAwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="">
      <div class="modal-header">
        <h3 style="margin: 0 auto;">WARNING</h3>
      </div>
      <div class="modal-body">
      <div class="alert alert-warning" role="alert">
          <strong>Pemberitahuan ini muncul karena system mencatat adanya indikator merah pada investasi yang nilai realisasi terhadap targetnya kurang dari 50%. Silahkan perbaiki / ubah realisasi yang berkendala, Dan Jika ada kendala silahkan kontak IPC pusat</strong>
        </div>
      <table class="table" style="font-size: 12px;">
        <thead>
          <tr>
            <th scope="col" width="15%">Indikator</th>
            <th scope="col" width="70%">Judul Investasi</th>
            <th scope="col" width="15%">Opsi</th>
          </tr>
        </thead>
        <tbody>
            <?php
              $jmlterlambat = 0;
              foreach ($popupindikator as $key => $value) {
                echo "<tr>";
                echo "<td><button class='btn btn-icon btn-round waves-effect waves-classic' style='background-color: #e73002; color: #e73002'>
                <i class='icon md-pin'></i>
            </button></td>";
                echo "<td>".$value['RKAP_INVS_TITLE']."</td>";
                if ($value['JML'] > 0) {
                  echo "<td><a href='".base_url('subprogramrkapinvestasi/view/').$value['RKAP_INVS_ID']."' class='btn btn-primary btn-sm' target='_blank'><i class='fa fa-mail-forward'></i></a></td>";
                  $jmlterlambat ++; 
                }else{
                  echo "<td>Progress Terlambat</td>";
                }
                echo "</tr>";
              }            
            ?>
        </tbody>
      </table>
      </div>
      <div class="modal-footer">
          <?php
            if ($jmlterlambat == 0) {
              echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
            }
          ?>
      </div>
    </div>
  </div>
</div>
  <?php
}
?>
