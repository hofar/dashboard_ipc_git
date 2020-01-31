<style type="text/css">
table, td {
    border: 2px solid white !important;
    border-collapse: collapse;
    color:#000;
    font-size: 14px !important;
}

.panelCustom{
	width:90%; background-color:#FFF;box-shadow:rgba(204,204,204,0.60) 4px 5px 12px 0px; 
               padding:15px 25px 10px 25px
}

.tdTitle{
	color:#6D6D6D;
}
.breadcrumb-right-arrow .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        vertical-align:top;
        font-size:40px;
        line-height:15px;
        line
    }
    .breadcrumb >li :hover {
        
    }

</style>
<link href="<?php echo base_url(); ?>assets/autocomplete/easy-autocomplete.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/autocomplete/easy-autocomplete.themes.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link href="<?php echo base_url(); ?>assets/template/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<div class="page">
    <div class="page-content">
    <div class="col-md-12">
        <ol class="breadcrumb breadcrumb-right-arrow">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item"> <a href="<?php echo base_url(); ?>rkapinvestasi">RKAP Investasi</a></li>
            <li class="breadcrumb-item"> <a href="<?php echo base_url('subprogramrkapinvestasi/view/').$list->RKAP_INVS_ID; ?>">List Sub Program</a></li>
            <li class="breadcrumb-item active">Detail Sub Program</li>
        </ol>
        </div>
        <div class="headTab">
            <i class="icon md-face"></i> Sub Program RKAP Investasi
        </div>
        <div class="panels">
        	
        	
            <div class="rows" style="padding:25px">
            	
                <div class="col-lg-6 panelCustom" style="background-color:#FFF">
                	<div class="the_kurva text-center">
                        <div id="curve_chart" style="width: 100%;"></div>
                        <span style="font-size:16px;font-weight:400">
                        Garis vertikal = Persentase ,<br /> Garis horizontal = Bulan ke</span>
                   
                        <canvas id="speedChart" width="600" height="400" style="margin-top:20px"></canvas>
                    </div>
                    
                       <br />
                                            <?php if ($realisasi == null || $rencana == null): ?>
                                            <div class="alert alert-warning" role="alert">
                                            Terdapat kesalahan ketika menampilkan deviasi 
                                            Silahkan cek data perencanaan <a href="<?php echo base_url(); ?>kurva/add/<?php echo $list->RKAP_SUBPRO_ID ?>">disini</a> dan realisasi <a href="<?php echo base_url(); ?>realisasi/view/<?php echo $list->RKAP_SUBPRO_ID ?>">disini</a> terlebih dahulu
                                            </div>
                                            <?php else: ?>
                                                <div>
                                                <div>
                                                     <div>
                                                        <table height="203" style="width: 100%;font-size:14px !important;color:#999">
                                                            
                                                            <tr>
                                                              <td height="37" colspan="2" style="padding: 5px 10px;font-size:18px !important">
                                                              	Deviasi
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tdTitle" style="padding: 5px 10px;">Realisasi</td>
                                                                <td>
                                                                    <input type="text" class="form-control" value="<?php echo ($act == 'add') ? '' : $deviasi_realisasi ?> %">
                                                                </td>
                                                            </tr>
                                                            <tr style="width: 100%;">
                                                                <td  class="tdTitle" style="padding: 5px 10px;">Perencanaan</td>
                                                                <td>
                                                                    <input class="form-control" type="text" value="<?php echo ($act == 'add') ? '' : $deviasi_rencana ?> %">
                                                                </td>
                                                            </tr>
                                                             <tr>
                                                                <td  class="tdTitle" style="padding: 5px 10px;">Deviasi</td>
                                                                <td>
                                                                    <input type="text" class="form-control" value="<?php echo ($act == 'add') ? '' : $deviasi_total ?> %">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tdTitle" style="padding: 5px 10px;">Indikator</td>
                                                                 <?php if ($act == 'add'): ?>
                                                                    <!-- <input type="text" style="width: 100%; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value=""> -->
                                                                <?php else: ?>
                                                                   <?php if ($warna == 1): ?>
                                                                     <td>
                                                                        <input type="text" style="width: 30%; background-color: #a8fd13; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="">
                                                                    </td>
                                                                <?php elseif ($warna == 2): ?>
                                                                    <td>
                                                                        <input type="text" style="width: 30%; background-color: #f6d71d; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="">
                                                                    </td> 
                                                                <?php elseif ($warna == 3): ?>
                                                                    <td>
                                                                        <input type="text" style="width: 30%; background-color: #e73002; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="">
                                                                    </td>
                                                                 <?php elseif ($warna == 4): ?>
                                                                    <td>
                                                                        <input type="text" style="width: 30%; background-color: #a8fd13; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="">
                                                                    </td>
                                                                 <?php elseif ($warna == 5): ?>
                                                                    <td>
                                                                        <input type="text" style="width: 30%; background-color: #f6d71d; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="">
                                                                    </td>
                                                                 <?php elseif ($warna == 6): ?>
                                                                    <td>
                                                                        <input type="text" style="width: 30%;  background-color: #e73002;  margin-bottom: 5px; border: 1px solid #ccc; border-radius: 3px; padding: 5px;" value="">
                                                                    </td>
                                                                <?php endif ?>
                                                                <?php endif ?>
                                                               
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif ?>
                                            
                                            <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                            <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                            <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>

                                            <?php else: ?>
                                                <?php if ($act == 'add'): ?>
                                                   <!--  <div class="text-right">
                                                        <a href="<?php echo base_url(); ?>kurva/add/" class="btn btn-success btn-round" id="button-kurva"><div class="fa fa-pencil"></div> Tambah / Ubah Kurva S</a>
                                                    </div> -->
                                                
                                                <?php elseif ($act == 'detail'): ?>
                                                    <div class="text-right">
                                                        <a href="<?php echo base_url(); ?>kurva/add/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-success btn-round" id="button-kurva"><div class="fa fa-pencil"></div> Tambah / Ubah Kurva S</a>
                                                    </div>
                                                <?php else: ?>
                                                <?php endif ?>
                                            <?php endif ?>
                                            
                                            
                             
                </div>
                
                <div class="col-lg-6 panelCustom">
                		
                                        <div class="kurva col-sm-12">
                                            <div class="the_kurva text-center">
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
                                                        if ($val->RISK_IK.'-'.$val->RISK_ID == '1-1') {
                                                            $_11[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '1-2') {
                                                            $_12[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '1-3') {
                                                            $_13[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '1-4') {
                                                            $_14[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '1-5') {
                                                            $_15[] = $val->SERIAL;
                                                        }
                                                         elseif ($val->RISK_IK.'-'.$val->RISK_ID == '2-1') {
                                                            $_21[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '2-2') {
                                                            $_22[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '2-3') {
                                                            $_23[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '2-4') {
                                                            $_24[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '2-5') {
                                                            $_25[] = $val->SERIAL;
                                                        }
                                                         elseif ($val->RISK_IK.'-'.$val->RISK_ID == '3-1') {
                                                            $_31[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '3-2') {
                                                            $_32[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '3-3') {
                                                            $_33[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '3-4') {
                                                            $_34[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '3-5') {
                                                            $_35[] = $val->SERIAL;
                                                        }
                                                         elseif ($val->RISK_IK.'-'.$val->RISK_ID == '4-1') {
                                                            $_41[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '4-2') {
                                                            $_42[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '4-3') {
                                                            $_43[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '4-4') {
                                                            $_44[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '4-5') {
                                                            $_45[] = $val->SERIAL;
                                                        }
                                                         elseif ($val->RISK_IK.'-'.$val->RISK_ID == '5-1') {
                                                            $_51[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '5-2') {
                                                            $_52[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '5-3') {
                                                            $_53[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '5-4') {
                                                            $_54[] = $val->SERIAL;
                                                        }
                                                        elseif ($val->RISK_IK.'-'.$val->RISK_ID == '5-5') {
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
                                                <table width="100%">
                                                      <tr>
                                                        <td height = "65px" width = "88" style="color:#333;">5</td>
                                                        <td height = "65px" width = "210" style="color:#333;">Hampir Pasti</td>
                                                        <td height = "65px" width = "149" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_51; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_52; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_53; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#e73002" style="font-weight: bold;"><center><?php echo $_54; ?></center></td>
                                                        <td height = "65px" width = "155" bgcolor="#e73002" style="font-weight: bold;"><center><?php echo $_55; ?></center></td>
                                                      </tr>
                                                      <tr>
                                                        <td height = "65px" width = "88" style="color:#333;">4</td>
                                                        <td height = "65px" width = "210" style="color:#333;">Mungkin Sekali</td>
                                                        <td height = "65px" width = "149" bgcolor="#a8fd13" style="font-weight: bold;"><center><?php echo $_41; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_42; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_43; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_44; ?></center></td>
                                                        <td height = "65px" width = "155" bgcolor="#e73002" style="font-weight: bold;"><center><?php echo $_45; ?></center></td>
                                                      </tr>
                                                      <tr>
                                                        <td height = "65px" width = "88" style="color:#333;">3</td>
                                                        <td height = "65px" width = "210" style="color:#333;">Mungkin</td>
                                                        <td height = "65px" width = "149" bgcolor="#a8fd13" style="font-weight: bold;"><center><?php echo $_31; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_32; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_33; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_34; ?></center></td>
                                                        <td height = "65px" width = "155" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_35; ?></center></td>
                                                      </tr>
                                                      <tr>
                                                        <td height = "65px" width = "88" style="color:#333;">2</td>
                                                        <td height = "65px" width = "210" style="color:#333;">Jarang</td>
                                                        <td height = "65px" width = "149" bgcolor="#5cb85c" style="font-weight: bold;"><center><?php echo $_21; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#a8fd13" style="font-weight: bold;"><center><?php echo $_22; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_23; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_24; ?></center></td>
                                                        <td height = "65px" width = "155" bgcolor="#ce820e" style="font-weight: bold;"><center><?php echo $_25; ?></center></td>
                                                      </tr>
                                                      <tr>
                                                        <td height = "65px" width = "88" style="color:#333;">1</td>
                                                        <td height = "65px" width = "210" style="color:#333;">Sangat Jarang</td>
                                                        <td height = "65px" width = "149" bgcolor="#5cb85c" style="font-weight: bold;"><center><?php echo $_11; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#5cb85c" style="font-weight: bold;"><center><?php echo $_12; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#a8fd13" style="font-weight: bold;"><center><?php echo $_13; ?></center></td>
                                                        <td height = "65px" width = "149" bgcolor="#a8fd13" style="font-weight: bold;"><center><?php echo $_14; ?></center></td>
                                                        <td height = "65px" width = "155" bgcolor="#f6d71d" style="font-weight: bold;"><center><?php echo $_15; ?></center></td>
                                                      </tr>
                                                      <tr>
                                                        <td height = "45px" width = "88" style="color:#333;"></td>
                                                        <td height = "45px" width = "210" style="color:#333;"></td>
                                                        <td height = "45px" width = "149" style="color:#333;">Sangat Kecil</td>
                                                        <td height = "45px" width = "149" style="color:#333;">Kecil</td>
                                                        <td height = "45px" width = "149" style="color:#333;">Sedang</td>
                                                        <td height = "45px" width = "149" style="color:#333;">Besar</td>
                                                        <td height = "45px" width = "155" style="color:#333;">Sangat Besar</td>
                                                      </tr>
                                                      <tr>
                                                        <td height = "45px" width = "88" style="color:#333;"></td>
                                                        <td height = "45px" width = "210" style="color:#333;"></td>
                                                        <td height = "45px" width = "149" style="color:#333;">1</td>
                                                        <td height = "45px" width = "149" style="color:#333;">2</td>
                                                        <td height = "45px" width = "149" style="color:#333;">3</td>
                                                        <td height = "45px" width = "149" style="color:#333;">4</td>
                                                        <td height = "45px" width = "155" style="color:#333;">5</td>
                                                      </tr>

                                                    </table>
                                            </div>
                                            
                                        <div align="right">    
                                        <?php if ($act == 'add'): ?>
                                            <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                            <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                            <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                            <?php else: ?>
                                                <?php if ($row_subprogram_risiko == null): ?>
                                                 
                                                            <!-- <a href="<?php echo base_url(); ?>risiko/view/" class="btn btn-success btn-round" id="button-entry-risiko"><div class="fa fa-plus"></div> Tambah Risiko</a> -->
                                                        
                                                <?php else: ?>
                                                    
                                                            <a href="<?php echo base_url(); ?>risiko/view/" class="btn btn-info btn-round" id="button-entry-risiko"><div class="fa fa-pencil"></div> Ubah Risiko</a>
                                                        
                                                <?php endif ?>
                                            <?php endif ?>
                                        <?php elseif ($act == 'detail'): ?>
                                            <?php if ($row_subprogram_risiko == null): ?>
                                                
                                                     <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                         
                                                            <a href="<?php echo base_url(); ?>risiko/print_risiko/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-default btn-round" id="button-entry-risiko"><div class="fa fa-eye"></div> View Risiko</a>
                                                       
                                                    <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                     
                                                            <a href="<?php echo base_url(); ?>risiko/print_risiko/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-default btn-round" id="button-entry-risiko"><div class="fa fa-eye"></div> View Risiko</a>
                                                        
                                                    <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                       
                                                            <a href="<?php echo base_url(); ?>risiko/print_risiko/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-default btn-round" id="button-entry-risiko"><div class="fa fa-eye"></div> View Risiko</a>
                                                       
                                                    <?php else: ?>
                                                         
                                                            <a href="<?php echo base_url(); ?>risiko/print_risiko/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-default btn-round" id="button-entry-risiko"><div class="fa fa-eye"></div> View Risiko</a>
                                                        
                                                            <a href="<?php echo base_url(); ?>risiko/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-success btn-round" id="button-entry-risiko"><div class="fa fa-plus"></div> Tambah Risiko</a>
                                                        
                                                    <?php endif ?>
                                                
                                            <?php else: ?>
                                                
                                                    <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                        
                                                            <a href="<?php echo base_url(); ?>risiko/print_risiko/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-default btn-round" id="button-entry-risiko"><div class="fa fa-eye"></div> View Risiko</a>
                                                        
                                                     <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                       
                                                            <a href="<?php echo base_url(); ?>risiko/print_risiko/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-default btn-round" id="button-entry-risiko"><div class="fa fa-eye"></div> View Risiko</a>
                                                        
                                                     <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                        
                                                            <a href="<?php echo base_url(); ?>risiko/print_risiko/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-default btn-round" id="button-entry-risiko"><div class="fa fa-eye"></div> View Risiko</a>
                                                        
                                                    <?php else: ?>
                                                         
                                                            <a href="<?php echo base_url(); ?>risiko/print_risiko/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-default btn-round" id="button-entry-risiko"><div class="fa fa-eye"></div> View Risiko</a>
                                                        
                                                            <a href="<?php echo base_url(); ?>risiko/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-info btn-round" id="button-entry-risiko"><div class="fa fa-pencil"></div> Ubah Risiko</a>
                                                        
                                                    <?php endif ?>
                                               
                                            <?php endif ?>
                                        <?php else: ?>
                                        <?php endif ?>
									</div>
                                    <br />
                                    
                </div>
            </div>
        	
             <div class="col-lg-6 panelCustom">
             	<div ><div class="risiko" style="margin-top: 12px">
                                    
                                </div>
                                <div class="addendum">
                                   
                                        <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                            <?php if ($act == 'add'): ?>
                                                      <!--  <a href="<?php echo base_url(); ?>addendum/view" class="btn btn-primary" id="button-view-addendum">View Addendum</a> -->
                                             <?php elseif ($act == 'detail'): ?>     
                                            
                                                    <a href="<?php echo base_url(); ?>addendum/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-primary" id="button-view-addendum">View Addendum</a>
                                              <?php else: ?>     
                                            <?php endif ?>
                                        <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                            <?php if ($act == 'add'): ?>
                                                <!-- <a href="<?php echo base_url(); ?>addendum/view" class="btn btn-primary" id="button-view-addendum">View Addendum</a> -->
                                            <?php elseif ($act == 'detail'): ?>        
                                            
                                               <a href="<?php echo base_url(); ?>addendum/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-primary" id="button-view-addendum">View Addendum</a>
                                             <?php else: ?>      
                                            <?php endif ?>
                                        <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                            <?php if ($act == 'add'): ?>
                                                <!--  <a href="<?php echo base_url(); ?>addendum/view" class="btn btn-primary" id="button-view-addendum">View Addendum</a> -->
                                            <?php elseif ($act == 'detail'): ?>       
                                            
                                                  <a href="<?php echo base_url(); ?>addendum/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-primary" id="button-view-addendum">View Addendum</a>
                                            <?php else: ?>       
                                            <?php endif ?>
                                        <?php else: ?>

                                            <?php if ($act == 'add'): ?>
                                                  <!-- <a href="<?php echo base_url(); ?>addendum/view" class="btn btn-primary" id="button-view-addendum">View Addendum</a>
                                                   <a href="<?php echo base_url(); ?>addendum/add" class="btn btn-success" id="button-entry-addendum">Entry Addendum</a> -->
                                            <?php elseif ($act == 'detail'): ?>        
                                            
                                               <a href="<?php echo base_url(); ?>addendum/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-primary" id="button-view-addendum"><div class="fa fa-eye"></div> View Addendum</a>
                                                     <a href="<?php echo base_url(); ?>addendum/add/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-success" id="button-entry-addendum"><div class="fa fa-plus"></div> Tambah Addendum</a>
                                             <?php else: ?>      
                                            <?php endif ?>
                                        <?php endif ?>
                                   
                                </div>
                                
                            </div>
             </div>
			 
             
             
             <div class="col-lg-6 panelCustom">
             		<div class="realisasi" style="margin-top: 12px">
                                     <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                            <?php if ($act == 'add'): ?>
                                                
                                                       <!--  <a href="<?php echo base_url(); ?>realisasi/view" class="btn btn-primary" id="button-view-realisasi">View Realisasi</a> -->
                                                    
                                            <?php elseif ($act == 'detail'): ?>
                                                
                                                        <a href="<?php echo base_url(); ?>realisasi/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-danger" id="button-view-realisasi"><div class="fa fa-eye"></div> View Realisasi</a>
                                            <?php else : ?>
                                                    
                                            <?php endif ?>
                                        <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                            <?php if ($act == 'add'): ?>
                                               
                                                        <!-- <a href="<?php echo base_url(); ?>realisasi/view" class="btn btn-primary" id="button-view-realisasi">View Realisasi</a> -->
                                                   
                                            
                                             <?php elseif ($act == 'detail'): ?>   
                                                        <a href="<?php echo base_url(); ?>realisasi/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-danger" id="button-view-realisasi"><div class="fa fa-eye"></div> View Realisasi</a>
                                              <?php else: ?>     
                                            <?php endif ?>
                                        <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                            <?php if ($act == 'add'): ?>
                                                
                                                        <!-- <a href="<?php echo base_url(); ?>realisasi/view" class="btn btn-primary" id="button-view-realisasi">View Realisasi</a> -->
                                            <?php elseif ($act == 'detail'): ?>         
                                            
                                               <a href="<?php echo base_url(); ?>realisasi/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-danger" id="button-view-realisasi"><div class="fa fa-eye"></div> View Realisasi</a>
                                            <?php else: ?>       
                                            <?php endif ?>
                                        <?php else: ?>
                                            <?php if ($act == 'add'): ?>
                                                <!--  <a href="<?php echo base_url(); ?>realisasi/view" class="btn btn-primary" id="button-view-realisasi">View Realisasi</a> -->
                                            <?php elseif ($act == 'detail'): ?>       
                                            
                                                 <a href="<?php echo base_url(); ?>realisasi/view/<?php echo $list->RKAP_SUBPRO_ID ?>" class="btn btn-danger" id="button-view-realisasi"><div class="fa fa-eye"></div> View Realisasi</a>
                                            <?php else: ?>        
                                            <?php endif ?>

                                        <?php endif ?>

                                </div>
             
             </div>
        
        </div>    
        
        <div class="col-md-12">
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
            </div>
		
        <form  id="addsubprogramrkapinvestasi" class="form-horizontal" action="<?php echo ($act == 'add') ? base_url('subprogramrkapinvestasi/add/' . $row_rkap->RKAP_INVS_ID . '') : base_url('subprogramrkapinvestasi/update/' . $list->RKAP_SUBPRO_ID . ''); ?>" method="post">
        <div class="rows" style="margin-top:40px; padding:5px 30px">
        	<div class="col-lg-6">
            	<input type="hidden" name="act" value="<?php echo $act ?>" id="act">
                        <input type="hidden" name="id" id="id" value="<?php echo ($act == 'add') ? '' : $list->RKAP_SUBPRO_ID ?>">
                        <input type="hidden" name="tgl_end_real" id="tgl_end_real" value="">
                        <div class="portlet-body">
                            <div>
                                <div class="form-group">
                                    <label class="control-label">Judul Investasi</label>
                                    <div>
                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? $list_rkap->RKAP_INVS_TITLE : $find->RKAP_INVS_TITLE ?>" disabled/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Judul SUB Program</label>
                                    <div>
                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? '' : $list->RKAP_SUBPRO_TITTLE ?>" name="judul_sub_program" data-validation="required" data-validation-error-msg="Judul sub program harus diisi" id="judul_sub_program" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Jenis SUB Program</label>
                                    <div>
                                        <select name="jenis_sub_program" class="form-control" id="jenis_sub_program">
                                            <option value="">-- Pilih Jenis Sub Program --</option>

                                            <?php
                                            foreach ($groups as $row) {
                                                if ($act == 'add') {
                                                    echo '<option value="' . $row->SUBPRO_TYPE_ID . '">' . $row->SUBPRO_TYPE_NAME . '</option>';
                                                } else {
                                                    if ($list->RKAP_SUBPRO_TYPE_ID == $row->SUBPRO_TYPE_ID) {

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
                                <div class="form-group" >
                                    <label class="control-label">NO Kontrak</label>
                                    <div>

                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? '' : $list->RKAP_SUBPRO_CONTRACT_NO ?>" name="no_kontrak" id="no_kontrak" />
                                    </div>
                                </div>
                                <?php if ($act == 'add'): ?>
                                    <div class="form-group" >
                                        <label class="control-label">Tanggal Kontrak</label>
                                        <div>
                                            <div class="form-group" style="margin: 0;">
                                                <div class='input-group'>
                                                    <input type="text" class="form-control date-picker" value="" data-date-format="dd-mm-yyyy" name="tgl_kontrak_new" id="tgl_kontrak_new"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group" >
                                        <label>Tanggal Kontrak</label>
                                        <div>
                                            <div class="form-group" style="margin: 0;">
                                                <div class='input-group'>
                                                    <input type="text" class="form-control date-picker" value="<?php echo ($list->RKAP_SUBPRO_CONTRACT_DATE_NEW == null) ? '' : date("d-m-Y", strtotime($list->RKAP_SUBPRO_CONTRACT_DATE_NEW)) ?>" data-date-format="dd-mm-yyyy" name="tgl_kontrak_new" id="tgl_kontrak_new"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                                <?php if ($act == 'add'): ?>
                                    <div class="form-group" >
                                        <label class="control-label">Tanggal BAMK</label>
                                        <div>
                                            <div class="form-group" style="margin: 0;">
                                                <div class='input-group'>
                                                    <input type="text" class="form-control date-picker" value="" data-date-format="dd-mm-yyyy" name="tgl_kontrak" id="tgl_kontrak" onchange="check_kontrak()" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group" >
                                        <label class="control-label">Tanggal BAMK</label>
                                        <div>
                                            <div class="form-group" style="margin: 0;">
                                                <div class='input-group'>
                                                    <input type="text" class="form-control date-picker" value="<?php echo ($list->RKAP_SUBPRO_CONTRACT_DATE == null) ? '' : date("d-m-Y", strtotime($list->RKAP_SUBPRO_CONTRACT_DATE)) ?>" data-date-format="dd-mm-yyyy" name="tgl_kontrak" id="tgl_kontrak"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                                
                                <div class="form-group" >
                                    <label class="control-label">Kebutuhan Dana</label>
                                    <div>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                Rp
                                            </div>
                                             <!-- <input class="form-control" type="text" name="sum_kontrak" value="<?php echo ($act == 'add') ? number_format($kontrak_val, 0, '', '.') : number_format($kontrak_val, 0, '', '.') ?>" id="sum_kontrak">  -->
                                            <input class="form-control" type="text" name="kebutuhan_dana" value="<?php echo ($act == 'add') ? number_format($row_rkap->RKAP_INVS_COST_REQ, 0, '', '.') : number_format($get_rkap->RKAP_INVS_COST_REQ, 0, '', '.') ?>" id="kebutuhan_dana" disabled/>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div>
                                    <button type="submit" class="btn btn-success" id="button-add" onclick="autodate()"><div class="fa fa-plus"></div> Tambah</button>
                                    <button type="submit" class="btn btn-info " id="button-edit" onclick="cek_kontrak_notslected()"><div class="fa fa-pencil"></div> Ubah</button>
                                    <?php if ($act == 'add'): ?>
                                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/view/<?php echo $row_rkap->RKAP_INVS_ID ?>" class="btn btn-default" ><div class="fa fa-ban"></div> Batal</a>
                                        <a href="<?php echo base_url(); ?>rkapinvestasi/detail/<?php echo $row_rkap->RKAP_INVS_ID ?>" class="btn btn-danger" id="button-back"><div class="fa fa-arrow-left"></div> Ke RKAP</a>
                                    <?php else: ?>
                                        <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/view/<?php echo $list->RKAP_INVS_ID ?>" class="btn btn-default" ><div class="fa fa-ban"></div> Batal</a>
                                        <a href="<?php echo base_url(); ?>rkapinvestasi/detail/<?php echo $list->RKAP_INVS_ID ?>" class="btn btn-danger" id="button-back"><div class="fa fa-arrow-left"></div> Ke RKAP</a>
                                    <?php endif ?>

                                </div>
                            </div>
                            
                        </div>
                        <div class="clearfix"></div>               
            </div>
            
            
            
            <div class="col-lg-6">
            	<div class="form-group" >
                                    <label class="control-label">Nilai RKAP</label>
                                    <div>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                Rp
                                            </div>
                                             <!-- <input class="form-control" type="text" name="sum_kontrak" value="<?php echo ($act == 'add') ? number_format($kontrak_val, 0, '', '.') : number_format($kontrak_val, 0, '', '.') ?>" id="sum_kontrak">  -->
                                            <input class="form-control" type="text" name="nilai_rkap" value="<?php echo ($act == 'add') ? number_format($row_rkap->RKAP_INVS_VALUE, 0, '', '.') : number_format($get_rkap->RKAP_INVS_VALUE, 0, '', '.') ?>" id="nilai_rkap" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($act == 'add'): ?>
                                    <div class="form-group" >
                                        <label class="control-label">Total Nilai Kontrak Sebelumnya</label>
                                        <div>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    Rp
                                                </div>
                                                <input class="form-control" type="text" name="sum_kontrak" value="<?php echo ($act == 'add') ? number_format($kontrak_val, 2, ',', '.') : number_format($kontrak_val, 2, ',', '.') ?>" id="sum_kontrak" disabled> 

                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group" >
                                        <label class="control-label">Nilai kontrak yang telah ada</label>
                                        <div>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    Rp
                                                </div>
                                                <input class="form-control" type="text" name="sum_kontrak_notselected" value="<?php echo ($act == 'add') ? number_format($kontrak_val_notselected, 2, ',', '.') : number_format($kontrak_val_notselected, 2, ',', '.') ?>" id="sum_kontrak_notselected" disabled> 

                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>

                                <?php if ($act == 'add'): ?>
                                    <div class="form-group" >
                                        <label class="control-label">Nilai Kontrak</label>
                                        <div>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    Rp
                                                </div>
                                                <!-- <input type="hidden" name="nilai_rkap" value="<?php echo $row_rkap->RKAP_INVS_VALUE ?>" id="nilai_rkap"> -->
                                                <input class="form-control" type="text" name="nilai_kontrak" value="<?php echo ($act == 'add') ? '' : number_format($list->RKAP_SUBPRO_CONTRACT_VALUE, 0, '', '.') ?>" id="nilai_kontrak" onchange="cek_kontrak()"/>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group" >
                                        <label class="control-label">Nilai Kontrak</label>
                                        <div>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    Rp
                                                </div>
                                                <!-- <input type="hidden" name="nilai_rkap" value="<?php echo $row_rkap->RKAP_INVS_VALUE ?>" id="nilai_rkap"> -->
                                                <input class="form-control" type="text" name="nilai_kontrak" value="<?php echo ($act == 'add') ? '' : number_format($list->RKAP_SUBPRO_CONTRACT_VALUE, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Nilai kontrak tidak boleh kosong" id="nilai_kontrak" onchange="cek_kontrak()"/>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                                <!-- <div class="form-group">
                                    <label class="control-label">Jenis Investasi</label>
                                    <div>
                                        <select name="jenis_investasi" class="form-control" data-validation="required" data-validation-error-msg="Silahkan Pilih Jenis Investasi" id="jenis_investasi" disabled >
                                            <option value="">-- Pilih Jenis Investasi --</option>
                                            <?php
                                            foreach ($groups2 as $row) {
                                                if ($act == 'add') {
                                                     if ($row_rkap->RKAP_INVS_TYPE == $row->INVS_TYPE_ID) {

                                                        echo '<option selected value="' . $row->INVS_TYPE_ID . '">' . $row->INVS_TYPE_NAME . '</option>';
                                                    } else {

                                                        echo '<option value="' . $row->INVS_TYPE_ID . '">' . $row->INVS_TYPE_NAME . '</option>';
                                                    }
                                                } else {
                                                    if ($get_rkap->RKAP_INVS_TYPE == $row->INVS_TYPE_ID) {

                                                        echo '<option selected value="' . $row->INVS_TYPE_ID . '">' . $row->INVS_TYPE_NAME . '</option>';
                                                    } else {

                                                        echo '<option value="' . $row->INVS_TYPE_ID . '">' . $row->INVS_TYPE_NAME . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                         <input class="form-control" type="hidden" name="input_invest" id="input_invest"/>
                                    </div>
                                </div> -->
                                <div class="form-group" >
                                    <label class="control-label">Jangka Waktu</label>
                                    <div>
                                        <div class="input-group">

                                            <input class="form-control" type="number" value="<?php echo ($act == 'add') ? '' : $list->RKAP_SUBPRO_PERIODE ?>" name="jangka_waktu" id="jangka_waktu<?php echo ($act == 'add') ? '' : $list->RKAP_SUBPRO_ID ?>"  min="0"/>
                                            <div class="input-group-addon">
                                                Bulan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <?php if ($act == 'add'): ?>
                                    <div class="form-group" >
                                        <label class="control-label">Tanggal Berakhir Jaminan</label>
                                        <div>
                                            <div class="form-group" style="margin: 0;">
                                                <div class='input-group'>
                                                    <input type="text" class="form-control date-picker" value="" name="tgl_berakhir_jaminan" data-date-format="dd-mm-yyyy"  data-validation-error-msg="Tanggal berakhir jaminan harus diisi" id="txtTo"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group" >
                                        <label class="control-label">Tanggal Berakhir Jaminan</label>
                                        <div>
                                            <div class="form-group" style="margin: 0;">
                                                <div class='input-group'>
                                                    <input type="text" class="form-control date-picker" value="<?php echo ($list->RKAP_SUBPRO_ENDOF_GUARANTEE == null) ? '' : date("d-m-Y", strtotime($list->RKAP_SUBPRO_ENDOF_GUARANTEE)) ?>" name="tgl_berakhir_jaminan" data-date-format="dd-mm-yyyy" data-validation-error-msg="Tanggal berakhir jaminan harus diisi" id="txtTo"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                                
                                <div class="form-group" >
                                    <label class="control-label">Realisasi s/d Tahun Sebelumnya</label>
                                    <div>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                Rp
                                            </div>
                                            <input class="form-control" type="text" name="realisasi_sebelum" value="<?php echo ($act == 'add') ? '' : number_format($list->RKAP_SUBPRO_REAL_BEFORE, 2, ',', '.') ?>" id="realisasi_sebelum" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Kontraktor Pelaksana</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" value="<?php echo ($act == 'add') ? '' : $list->RKAP_SUBPRO_CONTRACTOR ?>" name="kontraktor_pelaksana" id="kontraktor_pelaksana"  />
                                    </div>
                                </div>
            		</div>
       		 </div>
       </form> 	
      
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


<!-- BEGIN FOOTER -->
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/excanvas.min.js"></script> 
<![endif]-->
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>


<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script> -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script> -->
<!-- <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/start/jquery-ui.css" rel="Stylesheet" type="text/css" /> -->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
                                        $.validate({
                                        modules: 'security'
                                        });</script>

<!-- END PAGE LEVEL SCRIPTS -->

<script type="text/javascript">
    function check_kontrak () {
        var tgl_bamk = $("#tgl_kontrak").val();
        var tgl_kontrak = $("#tgl_kontrak_new").val();
        // alert(tgl_bamk)

        var newdate2 = tgl_kontrak.split("-").reverse().join("-");

        var e = new Date(newdate2);
        var months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        var day_kontrak = e.getDate();
        var monthIndex2 = e.getMonth();
        var yearIndex2 = e.getFullYear();
        var cek_kontrak = day_kontrak + '/' + monthIndex2 + '/' + yearIndex2;
        // alert(tgl_kontrak)

        var newdate = tgl_bamk.split("-").reverse().join("-");

        var d = new Date(newdate);
        var months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        var day_bamk = e.getDate();
        var monthIndex = d.getMonth();
        var yearIndex = d.getFullYear();
        var cek_bamk = day_bamk + '/' + monthIndex + '/' + yearIndex;
        if (d < e) {
            alert('Tanggal BAMK tidak boleh kurang dari tanggal Kontrak');
            $("#tgl_kontrak").val('');
        } else {

        }
    }
</script>

<!-- backup -->
<script type="text/javascript">
    function check_kontrak_backup () {
        var tgl_bamk = $("#tgl_kontrak").val();
        var tgl_kontrak = $("#tgl_kontrak_new").val();
        // alert(tgl_bamk)

        var newdate2 = tgl_kontrak.split("-").reverse().join("-");

        var e = new Date(newdate2);
        var months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        var monthIndex2 = e.getMonth() + 1;
        var yearIndex2 = e.getFullYear();
        var cek_kontrak = monthIndex2 + '/' + yearIndex2;
        // alert(tgl_kontrak)

        var newdate = tgl_bamk.split("-").reverse().join("-");

        var d = new Date(newdate);
        var months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        var monthIndex = d.getMonth() + 1;
        var yearIndex = d.getFullYear();
        var cek_bamk = monthIndex + '/' + yearIndex;

        if (cek_bamk < cek_kontrak) {
            alert('Tanggal BAMK tidak boleh kurang dari tanggal Kontrak');
            $("#tgl_kontrak").val('');
        } else {

        }
    }
</script>

<script type="text/javascript">
    var act = $('#act').val();
    // alert(act);

    if (act == 'detail') {
// <?php
// /* Mengambil query report */
// foreach ($value as $result) {
// //    $title[] = $result->RKAP_SUBPRO_TITTLE; //ambil bulan
//     $persen[] = (float) $result->SUBPRO_VALUE; //ambil nilai
// }
// /* end mengambil query */
// ?>
    $("#addrkapinvestasi input").attr('disabled', 'disabled');
    $("#addrkapinvestasi select").attr('disabled', 'disabled');
    $("#addrkapinvestasi  #button-edit").hide();
    $("#addrkapinvestasi  #button-add").hide();
    $("#addsubprogramrkapinvestasi input").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi select").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-add").hide();
    $("#addsubprogramrkapinvestasi  #button-edit").hide();
    $("#addsubprogramrkapinvestasi  #button-back").hide();
    $("#entryaddendum input").attr('disabled', 'disabled');
    $("#entryaddendum select").attr('disabled', 'disabled');
    $("#entryaddendum  #button-add").hide();
    $("#entryaddendum  #button-edit").hide();
    $("#entryaddendum  #button-back").hide();
    $("#addrealisasi  #button-add").hide();
    $("#addrealisasi  #button-edit").hide();
    $("#addrealisasi  #button-back").hide();
    $("#addrealisasi input").attr('disabled', 'disabled');
    $("#addrealisasi select").attr('disabled', 'disabled');
    $("#addrealisasi textarea").attr('disabled', 'disabled');
    $("#entryrisiko  #button-edit").hide();
    $("#entryrisiko  #button-add").hide();
    // $("#addrealisasi  #button-monitoring").attr('disabled', 'disabled');
    } else if (act == 'add') {
    $("#addrkapinvestasi  #button-edit").hide();
    $("#addrkapinvestasi  #button-list").attr('disabled', 'disabled');
    $("#addrkapinvestasi  #button-tambah-subadd").attr('disabled', 'disabled');
    $("#addrkapinvestasi  #button-gantt-chart").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-kurva").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-entry-risiko").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-view-addendum").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-entry-addendum").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-view-realisasi").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-entry-realisasi").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-edit").hide();
    $("#entryaddendum  #button-edit").hide();
    $("#addrealisasi  #button-edit").hide();
    $("#addrealisasi  #button-monitoring").attr('disabled', 'disabled');
    $("#entryrisiko  #button-edit").hide();
    } else if (act == 'edit') {
// <?php
// /* Mengambil query report */
// foreach ($value as $result) {
// //    $title[] = $result->RKAP_SUBPRO_TITTLE; //ambil bulan
//     $persen[] = (float) $result->SUBPRO_VALUE; //ambil nilai
// }
// /* end mengambil query */
// ?>
    $("#addrkapinvestasi  #button-add").hide();
    $("#addrkapinvestasi  #button-list").attr('disabled', 'disabled');
    $("#addrkapinvestasi  #button-tambah-subedit").attr('disabled', 'disabled');
    $("#addrkapinvestasi  #button-gantt-chart").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-back").hide();
    $("#addsubprogramrkapinvestasi  #button-kurva").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-entry-risiko").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-view-addendum").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-entry-addendum").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-view-realisasi").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-entry-realisasi").attr('disabled', 'disabled');
    $("#addsubprogramrkapinvestasi  #button-add").hide();
    $("#entryaddendum  #button-add").hide();
    $("#entryaddendum  #button-back").hide();
    $("#addrealisasi  #button-add").hide();
    $("#addrealisasi  #button-back").hide();
    $("#addrealisasi  #button-monitoring").attr('disabled', 'disabled');
    $("#entryrisiko  #button-add").hide();
    }


</script>

<script type="text/javascript">
    var speedCanvas = document.getElementById("speedChart");
    Chart.defaults.global.defaultFontFamily = "Calibri";
    Chart.defaults.global.defaultFontSize = 13;


    var dataFirst = {
    label: "Perencanaan",
            data: [0,
                <?php foreach ($resutl_all_month_non_adden as $rowdata): ?>
                    <?= $rowdata->SUBPRO_VALUE ?>,
                <?php endforeach; ?>
            ],
            lineTension: 0.5,
            fill: false,
            borderColor: 'blue',
            backgroundColor: 'transparent',
            pointBorderColor: '#000',
            pointBackgroundColor: '#fff',
            pointRadius: 2,
            pointHoverRadius: 5,
            pointHitRadius: 30,
            pointBorderWidth: 1,
            pointStyle: 'rect'
    };
    <?php
//$ary = array('Add1','Add2','Add3','Add4','Add5');
$warnak = array("",'#FF9800','#FF5722','#5D4037','#00796B','#E91E63','#7B1FA2','#512DA8','#FF9800','#FF5722','#5D4037','#00796B','#E91E63','#7B1FA2','#512DA8','#FF9800','#FF5722','#5D4037','#00796B','#E91E63','#7B1FA2','#512DA8');
for ($i=1; $i < $jmladdn ; $i++) { 
?>
var <?php echo $Adden2[$i];?> = {
    label: "<?php echo $Adden2[$i];?>",
            data: [0,
                <?php foreach ($Adden[$i] as $rowdata): ?>
                    <?= $rowdata->VAL ?>,
                <?php endforeach; ?>
            ],

            lineTension: 0.5,
            fill: false,
            borderColor: '<?php echo $warnak[$i];?>',
            backgroundColor: 'transparent',
            pointBorderColor: '#000',
            pointBackgroundColor: '#fff',
            pointRadius: 2,
            pointHoverRadius: 5,
            pointHitRadius: 30,
            pointBorderWidth: 1,
            pointStyle: 'rect'
    };
<?php
}
?>


// var dataThird = {
//     label: "Addendum",
//             data: [
// <?php foreach ($resutl_all_month_adden as $rowdata): ?>
//     <?= $rowdata->SUBPRO_VALUE ?>,
// <?php endforeach; ?>
//             ],
//             lineTension: 0.5,
//             fill: false,
//             borderColor: 'red',
//             backgroundColor: 'transparent',
//             pointBorderColor: '#000',
//             pointBackgroundColor: '#fff',
//             pointRadius: 2,
//             pointHoverRadius: 5,
//             pointHitRadius: 30,
//             pointBorderWidth: 1,
//             pointStyle: 'rect'
//     };


    var dataSecond = {
    label: "Realisasi",
            data: [0,
<?php foreach ($kurvarealisasi as $rowdata): ?>
    <?= $rowdata->VAL ?>,
<?php endforeach; ?>
            ],
            lineTension: 0.5,
            fill: false,
            borderColor: '#ff0606',
            backgroundColor: 'transparent',
            pointBorderColor: '#ffffff',
            pointBackgroundColor: 'lightgreen',
            pointRadius: 2,
            pointHoverRadius: 5,
            pointHitRadius: 30,
            pointBorderWidth: 1
    };
    

    var speedData = {
    labels: [0
<?php for ($i=1; $i <=$jmlhdata ; $i++) { 
    echo ",".$i;
} ?>
    ],
            datasets: [dataFirst, dataSecond<?php for ($j=1; $j <$jmladdn; $j++) { 
                echo ",".$Adden2[$j];
            }?>]
    };
    var chartOptions = {
    legend: {
    display: true,
            position: 'bottom',
            labels: {
            boxWidth: 5,
                    fontColor: 'black'
            }
    }
    };
    var lineChart = new Chart(speedCanvas, {
    type: 'line',
            data: speedData,
            options: chartOptions
    });</script>

<script type="text/javascript">

    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('nilai_kontrak');
    tanpa_rupiah.addEventListener('keyup', function (e)
    {
    tanpa_rupiah.value = formatRupiah(this.value);
    });
    var tanpa_rupiah2 = document.getElementById('realisasi_sebelum');
    tanpa_rupiah2.addEventListener('keyup', function (e)
    {
    tanpa_rupiah2.value = formatRupiah(this.value);
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
   function cek_kontrak() {

    var contract_val = $("#nilai_kontrak").val();
    var contract_set = contract_val.replace(/\./g, '');
    var contract_set_dua = contract_set.replace(/\,/g, '.');
    var contract_str = contract_set_dua;
    //alert(contract_str);
    var money_need = $("#kebutuhan_dana").val();
    var money_set = money_need.replace(/\./g, '');
    var money_set_dua = money_set.replace(/\,/g, '.');
    var money_str = money_set_dua;
    //alert(money_str);

    var contract_sum = $("#sum_kontrak").val();
    var contract_sum_set = contract_sum.replace(/\./g, '');
    var contract_sum_set_dua = contract_sum_set.replace(/\,/g, '.');
    var contract_sum_str = contract_sum_set_dua;
    //alert(contract_sum_str);

    var total_contract = parseFloat(contract_str) + parseFloat(contract_sum_str);
    if (total_contract <= money_str) {
    $("#nilai_kontrak").val(contract_val);
    $("#addsubprogramrkapinvestasi  #button-add").removeAttr('disabled');
    } else{
    alert('Total Nilai Kontrak tidak boleh lebih dari Kebutuhan Dana');
    $("#nilai_kontrak").val('');
    $("#addsubprogramrkapinvestasi  #button-add").attr('disabled', 'disabled');
    }

    }

    function cek_kontrak_notslected() {

    var contract_val = $("#nilai_kontrak").val();
    var contract_str_set = contract_val.replace(/\./g, '');
    var contract_str_set_dua = contract_str_set.replace(/\,/g, '.');
    var contract_str = contract_str_set_dua;
    //alert(contract_str);
    var money_need = $("#kebutuhan_dana").val();
    var money_set = money_need.replace(/\./g, '');
    var money_set_dua = money_set.replace(/\,/g, '.');
    var money_str = money_set_dua;
    // alert(money_str);

    var contract_sum_notselected = $("#sum_kontrak_notselected").val();
    var contract_sum_notselected_set = contract_sum_notselected.replace(/\./g, '');
    var contract_sum_notselected_set_dua = contract_sum_notselected_set.replace(/\,/g, '.');
    var contract_sum_notselected_str = contract_sum_notselected_set_dua;
    var total_contract_notselected = parseFloat(contract_str) + parseFloat(contract_sum_notselected_str);
    //alert(total_contract_notselected);

    if (total_contract_notselected <= money_str) {
    $("#nilai_kontrak").val(contract_val);
    // $("#addsubprogramrkapinvestasi  #button-edit").removeAttr('disabled');
    } else{
    alert('Total Nilai Kontrak tidak boleh lebih dari Kebutuhan Dana');
    $("#nilai_kontrak").val('');
    // $("#addsubprogramrkapinvestasi  #button-edit").attr('disabled', 'disabled');
    }

     // function autodate() {
        var id = document.getElementById('id').value;
        
        if (id == null) {
             var jangka = document.getElementById('jangka_waktu').value;
        }else{
             var jangka = document.getElementById('jangka_waktu' + id).value;
        }
        // var jangka = document.getElementById('jangka_waktu' + id).value;
        var jarak = parseInt(jangka);
        var startdate = $('#tgl_kontrak').val();
        var newstartdate = startdate.split("-").reverse().join("-");
        
        var myDate = new Date(newstartdate);
        
        var result1 = myDate.addMonths(jarak);
        var datebaru = new Date(result1);
        var dateIndex = datebaru.getDate();
        var monthIndex = datebaru.getMonth();
        var yearIndex = datebaru.getFullYear();
        
        var lengkapset = dateIndex + '-' + monthIndex  + '-' + yearIndex;

        // alert(lengkapset);
        
        document.getElementById('tgl_end_real').value = lengkapset;

    // }

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
</script>

<!-- <script type="text/javascript">
    $(document).ready(function() {
    $('#kontraktor_pelaksana').select2();
});
</script> -->
<script type="text/javascript">
    var link_base = "<?php echo base_url(); ?>";
    var options = {

    url: link_base + "subprogramrkapinvestasi/GetContractorName",
            getValue: "name",
            list: {
            match: {
            enabled: true
            }
            },
            theme: "square"
    };
    $("#kontraktor_pelaksana").easyAutocomplete(options);
</script>

<!-- <script type="text/javascript">

    function check_number()
        {
            var number_contract = $('#no_kontrak').val();
            // alert(number_contract);
            var link_base = "<?php echo base_url(); ?>";

          $.ajax({
                
                url: link_base + "subprogramrkapinvestasi/GetContractNumber",
                type: "post",
                dataType: 'json',
                
                cache: false,
                data: {nomor_kontrak : number_contract},
                success: function(data){
                 console.log(data);
                     if(data == 'ada')
                     {
                      alert('Nomor kontrak '+number_contract+' sudah terdaftar');
                      $('#no_kontrak').val('');
                     }
                     else
                     {
                      $('#no_kontrak').val(number_contract);
                     }
                }
            });
        }

</script> -->

<!-- <script type="text/javascript">

    function check_investasi()
        {
            var period = $('#jangka_waktu').val();
            var Invest = $('#jenis_investasi').val();

            // alert(period);

            if(period > 12){
                $('#jenis_investasi').val("3");
                 $('#input_invest').val("3");
            }else{
                $('#jenis_investasi').val("1");
                $('#input_invest').val("1");
            }
          
        }
</script> -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/components-pickers.js"></script>

<script>
                            $.validate({
                                modules: 'security'
                            });
</script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function () {

        ComponentsPickers.init();

    });
</script>

<script type="text/javascript">

    function autodate() {
        var id = document.getElementById('id').value;
        
        if (id == null) {
             var jangka = document.getElementById('jangka_waktu').value;
        }else{
             var jangka = document.getElementById('jangka_waktu' + id).value;
        }
        // var jangka = document.getElementById('jangka_waktu' + id).value;
        var jarak = parseInt(jangka);
        var startdate = $('#tgl_kontrak').val();
        var newstartdate = startdate.split("-").reverse().join("-");
        
        var myDate = new Date(newstartdate);
        
        var result1 = myDate.addMonths(jarak);
        var datebaru = new Date(result1);
        var dateIndex = datebaru.getDate();
        var monthIndex = datebaru.getMonth();
        var yearIndex = datebaru.getFullYear();
        
        var lengkapset = dateIndex + '-' + monthIndex  + '-' + yearIndex;

        // alert(lengkapset);
        
        document.getElementById('tgl_end_real').value = lengkapset;

    }

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
</script>

</body>
<!-- END BODY -->
</html>​