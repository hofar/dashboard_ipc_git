<style>
	a{
		color:#666 !important;
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

<div class="page">
    <div class="page-content">
        
        <div class="col-md-12">
        <ol class="breadcrumb breadcrumb-right-arrow">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item"> <a href="<?php echo base_url(); ?>rkapinvestasi">RKAP Investasi</a></li>
            <li class="breadcrumb-item active">Detail Realisasi</li>
        </ol>
        </div>
        
        <?php if ($act == 'add'){ ?>
        
        <?php }else{ ?>
        
        <div class="headTab">
            <i class="icon md-time-interval"></i> Ganttchart RKAP Investasi
        </div>
        <div class="panels" align="center">
        	   
               <div style="width:95%;margin-bottom:15px;font-size:20px" align="right">
               		
                    	
						<?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                            <?php if ($act == 'add'): ?>
                                <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/view/" id="button-list" class="btn btn-default btn-round">
                                	List Sub Program
                                 </a>

                            <?php else: ?>
                                <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/view/<?php echo $list->RKAP_INVS_ID ?>" id="button-list" 
                                class="btn btn-default btn-round">List Sub Program</a>

                            <?php endif ?>
                        <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                            <?php if ($act == 'add'): ?>
                                <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/view/" id="button-list" class="btn btn-default btn-round">
                               List Sub Program</a>

                            <?php else: ?>
                                <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/view/<?php echo $list->RKAP_INVS_ID ?>" id="button-list" 
                                class="btn btn-default btn-round">List Sub Program</a>

                            <?php endif ?>
                        <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                            <?php if ($act == 'add'): ?>
                                <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/view/" id="button-list" class="btn btn-default btn-round">
                                List Sub Program</a>

                            <?php else: ?>
                                <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/view/<?php echo $list->RKAP_INVS_ID ?>" id="button-list" 
                                class="btn btn-default btn-round">List Sub Program</a>

                            <?php endif ?>
                        <?php else: ?>
                            <?php if ($act == 'add'): ?>
                                <a href="<?php echo base_url(); ?>ganttchart/view/" class="btn btn-default btn-round" id="button-gantt-chart" 
                                style="margin-bottom: 10px;"><div class="fa fa-gear"> Ubah Gantt Chart</a>
                                
                                <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/view/" id="button-list" 
                                class="btn btn-default btn-round" style="margin-bottom: 10px;">List Sub Program</a>
                                
                            <?php elseif ($act == 'detail'): ?>
                                  
                                <a class="btn btn-default btn-round" data-toggle="tooltip"
                                href="<?php echo base_url(); ?>ganttchart/view/<?php echo $list->RKAP_INVS_ID ?>"
                                data-original-title="Ubah Gantt Chart" id="button-gantt-chart"> Ubah Gantt Chart
                                    
                                </a>
                                
                                <a  class="btn btn-default btn-round" data-toggle="tooltip"
                                href="<?php echo base_url(); ?>subprogramrkapinvestasi/view/<?php echo $list->RKAP_INVS_ID ?>" 
                                data-original-title="List Sub Program" >
                                    List Sub Program
                                </a>
                            <?php else: ?>
                               <!--  <a href="<?php echo base_url(); ?>ganttchart/view/" class="btn btn-default btn-round" id="button-gantt-chart" 
                                style="margin-bottom: 10px;"><div class="fa fa-gear"> Edit Gantt Chart</a>
                                
                                <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/view/" id="button-list" 
                                class="btn btn-default btn-round" style="margin-bottom: 10px;">List Sub Program</a> -->
                                
                            <?php endif ?>

                        <?php endif ?>
                                               
               </div>
               
               
               <div style="width:95%; background-color:#F7F7F7;box-shadow:rgba(204,204,204,0.80) 5px 5px 15px 0px; padding:15px 15px 10px 15px">
               		<div id="timeline"  style="height:220px; width:100%; font-size:12px !important"></div>
               </div>
               
               <br />
               
               <div align="left" style="width:95%; background-color:#F7F7F7;box-shadow:rgba(204,204,204,0.80) 5px 5px 15px 0px; padding:15px 25px 10px 25px">
               		<div class="rows" style="padding-bottom:10px">
                    	
                        <div class="col-lg-4" style="margin-top:10px">
                        	<div style="padding-left:10px">
                            	<span class="" style="font-size:13px">
                                	<i class="icon md-boat"></i> Judul Investasi
                                </span><br />
                            	<span class="" style="font-weight:400;font-size:15px;color:#191919">
									<?php echo $list->RKAP_INVS_TITLE ?>
                                </span>
                        	</div>
                         </div>
                        
                        <div class="col-lg-4" style="margin-top:10px">
                        	<div style="padding-left:10px;border-left:1px solid #CCC">
                            	<span class="" style="font-size:13px">
                                	<i class="icon md-chart-donut"></i> Project Number
                                </span><br />
                            	<span class="" style="font-weight:400;font-size:15px;color:#191919">
									<?php echo $list->RKAP_INVS_PROJECT_NUMBER ?>
                                </span>
                        	</div>
                            
                            <div style="padding-left:10px;padding-top:5px;border-left:1px solid #CCC">
                            	<span class="" style="font-size:13px">
                                	<i class="icon md-calendar-alt"></i> Tahun Investasi
                                </span><br />
                            	<span class="" style="font-weight:400;font-size:15px;color:#191919" id="thn_investasi">
									
                                </span>
                        	</div>
                        </div>
                        
                        <div class="col-lg-4" style="margin-top:10px">
                        	<div style="border-left:1px solid #CCC;padding-left:10px">
                            	<span class="" style="font-size:13px">
                                	<i class="icon md-city-alt"></i> Jenis Aktiva
                                </span><br />
                            	<span class="" style="font-weight:400;font-size:15px;color:#191919" id="aktiva">
									<?php echo $list->RKAP_INVS_TITLE ?>
                                </span>
                        	</div>
                            
                            <div style="padding-left:10px;padding-top:5px;border-left:1px solid #CCC">
                            	<span class="" style="font-size:13px">
                                	<i class="icon md-trending-up"></i> Jenis Investasi
                                </span><br />
                            	<span class="" style="font-weight:400;font-size:15px;color:#191919" id="jns_investasi">
									
                                </span>
                        	</div>
                        </div>
                    </div>
                    
               </div>
               
               
               <div align="left" style="width:95%; background-color:#FFF;box-shadow:rgba(204,204,204,0.80) 5px 5px 15px 0px; 
               padding:15px 25px 10px 25px">
               		<table width="100%">
                    	<thead>
                        	<tr style="font-size:12px">
                            	<td width="26%">Kebutuhan Dana</td>
                                <td width="24%">Nilai RKAP</td>
                                <td width="30%">Realisasi s/d Tahun Sebelumnya</td>
                                <td width="20%">Taksasi</td>
                            </tr>
                        </thead>
                        
                        <tbody>
                        	<tr style="font-size:15px;font-weight:500;color:#093">
                            	<td>Rp. <?php echo number_format($list->RKAP_INVS_COST_REQ, 2, ',', '.') ?></td>
                            	<td>Rp. <?php echo number_format($list->RKAP_INVS_VALUE, 2, ',', '.') ?></td>
                                <td>Rp. <?php echo number_format($list->RKAP_INVS_REAL_BEFORE, 2, ',', '.') ?></td>
                                <td>Rp. <?php echo number_format($list->RKAP_INVS_TAKSASI, 2, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                    
               </div>
               
               <div align="left" style="width:95%; background-color:#FFF;box-shadow:rgba(204,204,204,0.80) 5px 5px 15px 0px; 
               padding:15px 25px 10px 25px">
               		<table width="100%">
                    	<thead>
                        	<tr style="font-size:12px">
                            	<td width="26%">Target Triwulan I</td>
                                <td width="24%">Target Triwulan II</td>
                                <td width="30%">Target Triwulan III</td>
                                <td width="20%">Target Triwulan IV</td>
                            </tr>
                        </thead>
                        
                        <tbody>
                        	<tr style="font-size:15px;font-weight:500;color:#FF2B2B">
                            	<td>Rp. <?php echo number_format($list->RKAP_INVS_QUARTER_I, 2, ',', '.') ?></td>
                            	<td>Rp. <?php echo number_format($list->RKAP_INVS_QUARTER_II, 2, ',', '.') ?></td>
                                <td>Rp. <?php echo number_format($list->RKAP_INVS_QUARTER_III, 2, ',', '.') ?></td>
                                <td>Rp. <?php echo number_format($list->RKAP_INVS_QUARTER_IV, 2, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                    
               </div>
               <br />
               <div align="right" style="width:90%">
               		<button class="btn btn-primary btn-round" style="display:none">Form Update</button>
               </div>
               <br />
        </div>
<?php } ?>        
<br />


<div id="formTogle">      
<div class="headTab">
    <i class="icon md-time-interval"></i> Form RKAP
</div>       
<div class="panels">
		
        <div class="rows" style="padding:30px">
        	<div class="col-lg-6">
            <form  id="addrkapinvestasi" class="form-horizontal" action="<?php echo ($act == 'add') ? base_url('rkapinvestasi/add') : base_url('rkapinvestasi/update/' . $list->RKAP_INVS_ID . ''); ?>" method="post">
                        <input type="hidden" name="act" value="<?php echo $act ?>" id="act">
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
                        <div>

                            
                                        
                                        <div class="form-group">
                                            <label class="control-label">Judul Investasi</label>
                                            <div>
                                                <input class="form-control" type="text" value="<?php echo ($act == 'add') ? '' : $list->RKAP_INVS_TITLE ?>" name="judul_investasi" data-validation="required" data-validation-error-msg="Judul investasi harus diisi" id="judul_investasi" />
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label class="control-label">Project Number</label>
                                            <div>
                                                <input type="text" class="form-control" value="<?php echo ($act == 'add') ? '' : $list->RKAP_INVS_PROJECT_NUMBER ?>" name="project_number" data-validation="required" data-validation-error-msg="Project number harus diisi" id="project_number" onchange="check_number()"/>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group" >
                                            <label class="control-label">Jenis Aktiva</label>
                                            <div>
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
                                        </div>
                                        <div class="form-group" >
                                            <label class="control-label">Jenis Investasi</label>
                                            <div>
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
                                        </div>
                                        <div class="form-group" >
                                            <label class="control-label">Tahun Investasi</label>
                                            <div>
                                                <select name="tahun_investasi" class="form-control" data-validation="required" data-validation-error-msg="Silahkan Pilih Tahun Investasi" id="tahun_investasi">
                                                    <option value="">--Pilih Tahun Investasi--</option>
                                                    <option value="2007" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2007') ? 'selected' : '' ?> >2007</option>;
                                                    <option value="2008" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2008') ? 'selected' : '' ?> >2008</option>;
                                                    <option value="2009" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2009') ? 'selected' : '' ?> >2009</option>;
                                                    <option value="2010" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2010') ? 'selected' : '' ?> >2010</option>;
                                                    <option value="2011" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2011') ? 'selected' : '' ?> >2011</option>;
                                                    <option value="2012" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2012') ? 'selected' : '' ?> >2012</option>;

                                                    <option value="2013" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2013') ? 'selected' : '' ?> >2013</option>;
                                                    <option value="2014" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2014') ? 'selected' : '' ?> >2014</option>;
                                                    <option value="2015" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2015') ? 'selected' : '' ?> >2015</option>;
                                                    <option value="2016" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2016') ? 'selected' : '' ?> >2016</option>;
                                                    <option value="2017" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2017') ? 'selected' : '' ?> >2017</option>;
                                                    <option value="2018" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2018') ? 'selected' : '' ?> >2018</option>;
                                                    <option value="2019" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2019') ? 'selected' : '' ?> >2019</option>;
                                                    <option value="2020" <?php echo ($act == 'add') ? '' : ($list->RKAP_INVS_YEAR == '2020') ? 'selected' : '' ?> >2020</option>;
                                                   
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" >
                                                <label class="control-label">Posisi</label>
                                                <div>
                                                    <select name="posisi" class="form-control" data-validation="required" data-validation-error-msg="Silahkan pilih posisi" id="posisi">
                                                        <option value="">-- Pilih Posisi --</option>

                                                        <?php
                                                        foreach ($groups3 as $row) {
                                                            if ($act == 'add') {
                                                                echo '<option value="' . $row->POSPROG_ID . '">' . $row->POSPROG_NAME . '</option>';
                                                            } else {
                                                                if ($list->RKAP_INVS_POS == $row->POSPROG_ID) {

                                                                    echo '<option selected value="' . $row->POSPROG_ID . '">' . $row->POSPROG_NAME . '</option>';
                                                                } else {

                                                                    echo '<option value="' . $row->POSPROG_ID . '">' . $row->POSPROG_NAME . '</option>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                       
                                       
                                       <div class="form-group" >
                                            <label class="control-label">Kebutuhan Dana</label>
                                            <div>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php if ($act == 'add'): ?>
                                                        <input class="form-control" type="text" name="kebutuhan_dana" value=" " data-validation="required" data-validation-error-msg="Kebutuhan dana harus diisi" id="kebutuhan_dana" onchange="rkap_check()"/>
                                                    <?php elseif ($act == 'detail'): ?>
                                                        <input class="form-control" type="text" name="kebutuhan_dana" value="<?php echo number_format($list->RKAP_INVS_COST_REQ, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Kebutuhan dana harus diisi" id="kebutuhan_dana" onchange="rkap_check()"/>
                                                    <?php else: ?>
                                                        <input class="form-control" type="text" name="kebutuhan_dana" value="<?php echo number_format($list->RKAP_INVS_COST_REQ, 2, ',', '.') ?> " data-validation="required" data-validation-error-msg="Kebutuhan dana harus diisi" id="kebutuhan_dana" onchange="rkap_check()"/>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                      
                                      <div>
                                            <!-- <a href="#" class="btn btn-success uppercase" ><div class="fa fa-plus"></div> TAMBAH</a> -->
                                            <button type="submit" class="btn btn-success" id="button-add" style="width:150px">
                                            	<div class="fa fa-plus"></div> Tambah
                                            </button>&nbsp;
                                            
                                            <button type="submit" class="btn btn-info" id="button-edit" style="width:150px">
                                            	<div class="fa fa-pencil"></div> Ubah
                                            </button>&nbsp;
                                            <a href="<?php echo base_url(); ?>rkapinvestasi" class="btn btn-default" style="width:150px">
                                            <div class="fa fa-ban"></div> Batal</a>
										</div>  
								</div>
							
            	</div>
            
            
            <div class="col-lg-6">
            		
                                        <div class="form-group" >
                                            <label class="control-label">Nilai RKAP</label>
                                            <div>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php if ($act == 'add'): ?>
                                                        <input class="form-control" type="text" name="nilai_rkap" data-validation="required" value=" " data-validation-error-msg="Nilai RKAP harus diisi" id="nilai_rkap" onchange="rkap_check()" />
                                                    <?php elseif ($act == 'detail'): ?>
                                                        <input class="form-control" type="text" name="nilai_rkap" data-validation="required" value="<?php echo number_format($list->RKAP_INVS_VALUE, 2, ',', '.') ?>" data-validation-error-msg="Nilai RKAP harus diisi" id="nilai_rkap" disabled onchange="rkap_check()" />
                                                    <?php else: ?>
                                                        <input class="form-control" type="text" name="nilai_rkap" data-validation="required" value="<?php echo number_format($list->RKAP_INVS_VALUE, 2, ',', '.') ?>" data-validation-error-msg="Nilai RKAP harus diisi" id="nilai_rkap" onchange="rkap_check()" />
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" >
                                            <label class="control-label">Target Triwulanan</label>
                                            <div>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        TW I Rp
                                                    </div>
                                                    <?php if ($act == 'add'): ?>
                                                        <input class="form-control" type="text" name="triwulan_satu" value=" " data-validation="required" data-validation-error-msg="Target triwulanan I harus diisi" id="triwulan_satu" />
                                                    <?php elseif ($act == 'detail'): ?>
                                                        <input class="form-control" type="text" name="triwulan_satu" value="<?php echo number_format($list->RKAP_INVS_QUARTER_I, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Target triwulanan I harus diisi" id="triwulan_satu" disabled/>
                                                    <?php else: ?>
                                                        <input class="form-control" type="text" name="triwulan_satu" value="<?php echo number_format($list->RKAP_INVS_QUARTER_I, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Target triwulanan I harus diisi" id="triwulan_satu" />
                                                    <?php endif ?>

                                                </div>						          		
                                            </div>
                                        </div>
                                        <div class="form-group" >
                                            <label class="control-label"></label>
                                            <div>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        TW II Rp
                                                    </div>
                                                    <?php if ($act == 'add'): ?>
                                                        <input class="form-control" type="text" name="triwulan_dua" value=" " data-validation="required" data-validation-error-msg="Target triwulanan II harus diisi" id="triwulan_dua" />
                                                    <?php elseif ($act == 'detail'): ?>
                                                        <input class="form-control" type="text" name="triwulan_dua" value="<?php echo number_format($list->RKAP_INVS_QUARTER_II, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Target triwulanan II harus diisi" id="triwulan_dua" disabled/>
                                                    <?php else: ?>
                                                        <input class="form-control" type="text" name="triwulan_dua" value="<?php echo number_format($list->RKAP_INVS_QUARTER_II, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Target triwulanan II harus diisi" id="triwulan_dua" />
                                                    <?php endif ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" >
                                            <label class="control-label"></label>
                                            <div>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        TW III Rp
                                                    </div>
                                                    <?php if ($act == 'add'): ?>
                                                        <input class="form-control" type="text" name="triwulan_tiga" value=" " data-validation="required" data-validation-error-msg="Target triwulanan III harus diisi" id="triwulan_tiga" />
                                                    <?php elseif ($act == 'detail'): ?>
                                                        <input class="form-control" type="text" name="triwulan_tiga" value="<?php echo number_format($list->RKAP_INVS_QUARTER_III, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Target triwulanan III harus diisi" id="triwulan_tiga" disabled/>
                                                    <?php else: ?>
                                                        <input class="form-control" type="text" name="triwulan_tiga" value="<?php echo number_format($list->RKAP_INVS_QUARTER_III, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Target triwulanan III harus diisi" id="triwulan_tiga" />
                                                    <?php endif ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" >
                                            <label class="control-label"></label>
                                            <div>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        TW IV Rp
                                                    </div>
                                                    <?php if ($act == 'add'): ?>
                                                        <input class="form-control" type="text" name="triwulan_empat" value=" " data-validation="required" data-validation-error-msg="Target triwulanan IV harus diisi" id="triwulan_empat"/>
                                                    <?php elseif ($act == 'detail'): ?>
                                                        <input class="form-control" type="text" name="triwulan_empat" value="<?php echo number_format($list->RKAP_INVS_QUARTER_IV, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Target triwulanan IV harus diisi" id="triwulan_empat" disabled/>
                                                    <?php else: ?>
                                                        <input class="form-control" type="text" name="triwulan_empat" value="<?php echo number_format($list->RKAP_INVS_QUARTER_IV, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Target triwulanan IV harus diisi" id="triwulan_empat"/>
                                                    <?php endif ?>

                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                         <div class="form-group" >
                                            <label class="control-label">Realisasi s/d Tahun Sebelumnya</label>
                                            <div>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php if ($act == 'add'): ?>
                                                        <input class="form-control" type="text" name="realisasi_sebelum" value="" data-validation="required" data-validation-error-msg="Realisasi harus diisi" id="realisasi_sebelum" />
                                                    <?php elseif ($act == 'detail'): ?>
                                                        <input class="form-control" type="text" name="realisasi_sebelum" value="<?php echo number_format($list->RKAP_INVS_REAL_BEFORE, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Realisasi harus diisi" id="realisasi_sebelum" disabled/>
                                                    <?php else: ?>
                                                        <input class="form-control" type="text" name="realisasi_sebelum" value="<?php echo number_format($list->RKAP_INVS_REAL_BEFORE, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Realisasi harus diisi" id="realisasi_sebelum" />
                                                    <?php endif ?>


                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" style="margin-bottom: 25px;">
                                            <label class="control-label">Taksasi</label>
                                            <div>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php if ($act == 'add'): ?>
                                                        <input class="form-control" type="text" name="taksasi" value="" data-validation="required" data-validation-error-msg="Taksasi harus diisi" id="taksasi" />
                                                    <?php elseif ($act == 'detail'): ?>
                                                        <input class="form-control" type="text" name="taksasi" value="<?php echo number_format($list->RKAP_INVS_TAKSASI, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Taksasi harus diisi" id="taksasi" disabled/>
                                                    <?php else: ?>
                                                        <input class="form-control" type="text" name="taksasi" value="<?php echo number_format($list->RKAP_INVS_TAKSASI, 2, ',', '.') ?>" data-validation="required" data-validation-error-msg="Taksasi harus diisi" id="taksasi" />
                                                    <?php endif ?>

                                                </div>
                                            </div>
                                        </div>
                                        
                                        
</form>         
   

			
            </div>
</div>

 <?php if ($act == 'add'): ?>
			 <?php else: ?>
             
<div class="panels" align="center">
				<br />
                <div class="rows" style="width:70%">
                    <div class="col-sm-12 col-md-6">
                        <form method="post" action="<?php echo base_url(); ?>rkapinvestasi/insert_before/<?php echo $list->RKAP_INVS_ID; ?>" 
                        enctype="multipart/form-data">
                                <div class="thumbnail">
                                    <a href="<?php echo base_url() ?>uploads/before/<?php echo $list->PICTURE_BEFORE; ?>"><img src="<?php echo base_url() ?>uploads/before/<?php echo $list->PICTURE_BEFORE; ?>" alt="" width="256" height="256"></a>
                                    <div class="caption">
                                        <h4>Sebelum</h4> &nbsp;  <a href="<?php echo base_url() ?>uploads/before/<?php echo $list->PICTURE_BEFORE; ?>" download data-toggle="tooltip" title="Download <?php echo $list->PICTURE_BEFORE ?>"><div class="icon md-cloud-download" style="font-size: 29px;"></div></a>
                                        <?php if ($list->IS_UPLOADED_BEFORE == 0): ?>
                                            <p>
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                    <p>Unggah Foto :</p>
                                                  
                                                    <div class="input-group">
                                                      <div class="input-group-addon">
                                                        <div class="icon md-cloud-download"></div>
                                                      </div>
                                                      
                                                      <input type="file" name="filefoto_before" id="pict_before" class="form-control" required>
                                                    </div><br>
                                                    <button type="submit" class="btn btn-md btn-success btn-block" id="pict_before_btn"> Unggah</button>
                                                  </div><br>
                                                </div>
                                            </p>
                                        <?php else: ?>
                                            
                                        <?php endif ?>
                                        
                                    </div>
                                </div>
                        </form>
                    </div>
                    
                    <div class="col-sm-12 col-md-6">
                        <form method="post" action="<?php echo base_url(); ?>rkapinvestasi/insert_after/<?php echo $list->RKAP_INVS_ID; ?>" enctype="multipart/form-data">
                                <div class="thumbnail">
                                    <a href="<?php echo base_url() ?>uploads/after/<?php echo $list->PICTURE_AFTER; ?>"><img src="<?php echo base_url() ?>uploads/after/<?php echo $list->PICTURE_AFTER; ?>" alt="" width="256" height="256"></a>
                                    <div class="caption">
                                        <h4>Sesudah</h4>&nbsp;  <a href="<?php echo base_url() ?>uploads/after/<?php echo $list->PICTURE_AFTER; ?>" download data-toggle="tooltip" title="Download <?php echo $list->PICTURE_AFTER ?>">
                                        <div class=" icon md-cloud-download" style="font-size: 29px;"></div></a>
                                       
                                        <p>
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                <p>Unggah Foto :</p>
                                              
                                                <div class="input-group">
                                                  <div class="input-group-addon">
                                                    <div class="fa fa-upload"></div>
                                                  </div>
                                                  
                                                  <input type="file" name="filefoto_after" id="pict_after" class="form-control" required>
                                                </div><br>
                                                <button type="submit" class="btn btn-md btn-success btn-block" id="pict_after_btn">
                                                Unggah</button>
                                              </div><br>
                                            </div>
                                        </p>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
           
</div>		
 <?php endif ?>	
</div>
</div>
<br>


   
       
   

<br />


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
    </div>







<script src="<?php echo base_url(); ?>assets/highcharts/jquery.js"></script>

<script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>

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

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
                                                            $.validate({
                                                                modules: 'security'
                                                            });
</script>


<script type="text/javascript">
    var act = $('#act').val();
    // alert(act);

    if (act == 'detail') {
        // alert('aaa')
        document.getElementById("pict_before").disabled = true;
        document.getElementById("pict_after").disabled = true;
        document.getElementById("pict_before_btn").disabled = true;
        document.getElementById("pict_after_btn").disabled = true;
        $("#addrkapinvestasi input").attr('disabled', 'disabled');
        $("#addrkapinvestasi select").attr('disabled', 'disabled');
        $("#addrkapinvestasi #pict_before_btn").hide('disabled', 'disabled');
        $("#addrkapinvestasi #pict_after_btn").hide('disabled', 'disabled');
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
        // $("#addrealisasi  #button-monitoring").attr('disabled', 'disabled');
    } else if (act == 'add') {
        $("#addrkapinvestasi  #button-edit").hide();
        $("#addrkapinvestasi  #button-list").attr('disabled', 'disabled');
        $("#addrkapinvestasi  #button-tambah-subadd").attr('disabled', 'disabled');
        $("#addrkapinvestasi  #button-gantt-chart").attr('disabled', 'disabled');
        $("#addsubprogramrkapinvestasi  #button-kurva").attr('disabled', 'disabled');
        $("#addsubprogramrkapinvestasi  #button-view-addendum").attr('disabled', 'disabled');
        $("#addsubprogramrkapinvestasi  #button-entry-addendum").attr('disabled', 'disabled');
        $("#addsubprogramrkapinvestasi  #button-view-realisasi").attr('disabled', 'disabled');
        $("#addsubprogramrkapinvestasi  #button-entry-realisasi").attr('disabled', 'disabled');
        $("#addsubprogramrkapinvestasi  #button-edit").hide();
        $("#entryaddendum  #button-edit").hide();
        $("#addrealisasi  #button-edit").hide();
        $("#addrealisasi  #button-monitoring").attr('disabled', 'disabled');

        function rkap_check() {
            
            var kebutuhan_dana = $("#kebutuhan_dana").val();
            var butuh_uang = kebutuhan_dana.replace(/\./g, '');
            var butuh_uang_dua = butuh_uang.replace(/\,/g, '.');
            var money_need = butuh_uang_dua;
            var money_need2 = parseFloat(money_need);
            //alert(money_need2);
            
            var nilai_rkap = $("#nilai_rkap").val();
            var butuh_rkap = nilai_rkap.replace(/\./g, '');
            var butuh_rkap_dua = butuh_rkap.replace(/\,/g, '.');
            var rkap_value = butuh_rkap_dua;
            var rkap_value2 = parseFloat(rkap_value);
            //alert(rkap_value2);

            if ( rkap_value2 >  money_need2 ) {
                alert('nilai rkap tidak boleh lebih dari kebutuhan dana');
                $("#nilai_rkap").val('');
            }

        }

        $("#button-add").click(function () {
            var nilai_rkap = document.getElementById("nilai_rkap").value;
            var butuh_rkap = nilai_rkap.replace(/\./g, '');
            var butuh_rkap_dua = butuh_rkap.replace(/\,/g, '.');
            var rkap_value = butuh_rkap_dua;

            var nilai_triwulan1 = document.getElementById("triwulan_satu").value;
            var butuh_nilai_triwulan1 = nilai_triwulan1.replace(/\./g, '');
            var butuh_nilai_triwulan1_dua = butuh_nilai_triwulan1.replace(/\,/g, '.');
            var triwulan1 = butuh_nilai_triwulan1_dua;


//            var nilai_triwulan1 = document.getElementById('triwulan_satu').value;
//            var triwulan1 = parseInt(nilai_triwulan1.replace(/,.*|[^0-9]/g, ''), 10);

            var nilai_triwulan2 = document.getElementById("triwulan_dua").value;
            var butuh_nilai_triwulan2 = nilai_triwulan2.replace(/\./g, '');
            var butuh_nilai_triwulan2_dua = butuh_nilai_triwulan2.replace(/\,/g, '.');
            var triwulan2 = butuh_nilai_triwulan2_dua;

//            var nilai_triwulan2 = document.getElementById('triwulan_dua').value;
//            var triwulan2 = parseInt(nilai_triwulan2.replace(/,.*|[^0-9]/g, ''), 10);

            var nilai_triwulan3 = document.getElementById("triwulan_tiga").value;
            var butuh_nilai_triwulan3 = nilai_triwulan3.replace(/\./g, '');
            var butuh_nilai_triwulan3_dua = butuh_nilai_triwulan3.replace(/\,/g, '.');
            var triwulan3 = butuh_nilai_triwulan3_dua;

//            var nilai_triwulan3 = document.getElementById('triwulan_tiga').value;
//            var triwulan3 = parseInt(nilai_triwulan3.replace(/,.*|[^0-9]/g, ''), 10);

            var nilai_triwulan4 = document.getElementById("triwulan_empat").value;
            var butuh_nilai_triwulan4 = nilai_triwulan4.replace(/\./g, '');
            var butuh_nilai_triwulan4_dua = butuh_nilai_triwulan4.replace(/\,/g, '.');
            var triwulan4 = butuh_nilai_triwulan4_dua;

//            var nilai_triwulan4 = document.getElementById('triwulan_empat').value;
//            var triwulan4 = parseInt(nilai_triwulan4.replace(/,.*|[^0-9]/g, ''), 10);
//            var result = parseFloat(money_need) + parseFloat(rkap_value);

            var total_triwulan = parseFloat(triwulan1) + parseFloat(triwulan2) + parseFloat(triwulan3) + parseFloat(triwulan4);
            //alert(total_triwulan);

            if (total_triwulan != rkap_value) {
                alert('total triwulan tidak boleh lebih atau kurang dari nilai rkap');
                $("#triwulan_empat").val('');
                $("#triwulan_tiga").val('');
                $("#triwulan_dua").val('');
                $("#triwulan_satu").val('');
            }
        });

    } else if (act == 'edit') {
        $("#addrkapinvestasi  #button-add").hide();
        $("#addrkapinvestasi  #button-list").attr('disabled', 'disabled');
        $("#addrkapinvestasi  #button-tambah-subedit").attr('disabled', 'disabled');
        $("#addrkapinvestasi  #button-gantt-chart").attr('disabled', 'disabled');
        $("#addsubprogramrkapinvestasi  #button-back").hide();
        $("#addsubprogramrkapinvestasi  #button-kurva").attr('disabled', 'disabled');
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

        function rkap_check() {
            
            var kebutuhan_dana = $("#kebutuhan_dana").val();
            var butuh_uang = kebutuhan_dana.replace(/\./g, '');
            var butuh_uang_dua = butuh_uang.replace(/\,/g, '.');
            var money_need = butuh_uang_dua;
            var money_need2 = parseFloat(money_need);
            //alert(money_need2);
            
            var nilai_rkap = $("#nilai_rkap").val();
            var butuh_rkap = nilai_rkap.replace(/\./g, '');
            var butuh_rkap_dua = butuh_rkap.replace(/\,/g, '.');
            var rkap_value = butuh_rkap_dua;
            var rkap_value2 = parseFloat(rkap_value);
            //alert(rkap_value2);

            if ( rkap_value2 >  money_need2 ) {
                alert('nilai rkap tidak boleh lebih dari kebutuhan dana');
                $("#nilai_rkap").val('');
            }

        }

        $("#button-edit").click(function () {

            var nilai_rkap = document.getElementById("nilai_rkap").value;
            var butuh_rkap = nilai_rkap.replace(/\./g, '');
            var butuh_rkap_dua = butuh_rkap.replace(/\,/g, '.');
            var rkap_value = butuh_rkap_dua;

            var nilai_triwulan1 = document.getElementById("triwulan_satu").value;
            var butuh_nilai_triwulan1 = nilai_triwulan1.replace(/\./g, '');
            var butuh_nilai_triwulan1_dua = butuh_nilai_triwulan1.replace(/\,/g, '.');
            var triwulan1 = butuh_nilai_triwulan1_dua;


//            var nilai_triwulan1 = document.getElementById('triwulan_satu').value;
//            var triwulan1 = parseInt(nilai_triwulan1.replace(/,.*|[^0-9]/g, ''), 10);

            var nilai_triwulan2 = document.getElementById("triwulan_dua").value;
            var butuh_nilai_triwulan2 = nilai_triwulan2.replace(/\./g, '');
            var butuh_nilai_triwulan2_dua = butuh_nilai_triwulan2.replace(/\,/g, '.');
            var triwulan2 = butuh_nilai_triwulan2_dua;

//            var nilai_triwulan2 = document.getElementById('triwulan_dua').value;
//            var triwulan2 = parseInt(nilai_triwulan2.replace(/,.*|[^0-9]/g, ''), 10);

            var nilai_triwulan3 = document.getElementById("triwulan_tiga").value;
            var butuh_nilai_triwulan3 = nilai_triwulan3.replace(/\./g, '');
            var butuh_nilai_triwulan3_dua = butuh_nilai_triwulan3.replace(/\,/g, '.');
            var triwulan3 = butuh_nilai_triwulan3_dua;

//            var nilai_triwulan3 = document.getElementById('triwulan_tiga').value;
//            var triwulan3 = parseInt(nilai_triwulan3.replace(/,.*|[^0-9]/g, ''), 10);

            var nilai_triwulan4 = document.getElementById("triwulan_empat").value;
            var butuh_nilai_triwulan4 = nilai_triwulan4.replace(/\./g, '');
            var butuh_nilai_triwulan4_dua = butuh_nilai_triwulan4.replace(/\,/g, '.');
            var triwulan4 = butuh_nilai_triwulan4_dua;

//            var nilai_triwulan4 = document.getElementById('triwulan_empat').value;
//            var triwulan4 = parseInt(nilai_triwulan4.replace(/,.*|[^0-9]/g, ''), 10);
//            var result = parseFloat(money_need) + parseFloat(rkap_value);

            var total_triwulan = parseFloat(triwulan1) + parseFloat(triwulan2) + parseFloat(triwulan3) + parseFloat(triwulan4);
            //alert(total_triwulan);

            if (total_triwulan != rkap_value) {
                alert('total triwulan tidak boleh lebih atau kurang dari nilai rkap');
                $("#triwulan_empat").val('');
                $("#triwulan_tiga").val('');
                $("#triwulan_dua").val('');
                $("#triwulan_satu").val('');
            }

        });

    }


</script>





<script type="text/javascript">
    google.charts.load('current', {'packages': ['timeline']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var container = document.getElementById('timeline');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();

        dataTable.addColumn({type: 'string', id: 'President'});
        dataTable.addColumn({type: 'date', id: 'Start'});
        dataTable.addColumn({type: 'date', id: 'End'});
        dataTable.addRows([
<?php if (empty($report)) { ?>

    // ['Tidak Ada Data', new Date(2008,1,28), new Date(2008,1,28)],
    ['Bob', new Date(2007,5,1)], 

    <?php
} else {
    $no = 0;
    $number = 0;
    foreach ($report as $rowdata) {
        $blnstart = strtotime($rowdata->RKAP_SUBPRO_START);
        $newstart = date('Y, m, d', $blnstart);
        $blnend = strtotime($rowdata->RKAP_SUBPRO_END);
        $newend = date('Y, m, d', $blnend);
        ?>
                ['<?php echo $rowdata->RKAP_SUBPRO_TITTLE; ?>', new Date(<?php echo $newstart; ?>), new Date(<?php echo $newend; ?>)],
        <?php
        $query3 = $this->db->query("select RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, add_months(RKAP_SUBPRO_CONTRACT_DATE, -1)  as RKAP_SUBPRO_CONTRACT_DATE, add_months(RKAP_SUBPRO_END_REAL, -1) as RKAP_SUBPRO_END_REAL 
                                    from TX_RKAP_SUB_PROGRAM where RKAP_SUBPRO_ID = '" . $rowdata->RKAP_SUBPRO_ID . "' and RKAP_SUBPRO_INVS_ID = '" . $rowdata->RKAP_SUBPRO_INVS_ID . "'  and IS_DELETED ='0'");

       
        foreach ($query3->result() as $rencadd) {
             $no++;
            $startrencana = strtotime($rencadd->RKAP_SUBPRO_CONTRACT_DATE);
            $newstartrencana = date('Y, m, d', $startrencana);
            $endrencana = strtotime($rencadd->RKAP_SUBPRO_END_REAL);
            $newendrencana = date('Y, m, d', $endrencana);
            ?>
                   <?php 
                        if ($startrencana || $endrencana != null) {
                    ?>
                          ['Realisasi <?php echo $no; ?>', new Date(<?php echo $newstartrencana; ?>), new Date(<?php echo $newendrencana; ?>)],
                    <?php 
                        }else{
                    ?>
                            
                    <?php 
                        }
                    ?>
            <?php
        }

        
        $query2 = $this->db->query("select RKAP_SUBPRO_ID, add_months(SUBPRO_ADD_DATE, -1)  as SUBPRO_ADD_DATE, add_months(SUBPRO_ADD_END_REAL, -1) as SUBPRO_ADD_END_REAL 
                                    from TX_SUB_PROGRAM_ADDENDUM where RKAP_SUBPRO_ID = '" . $rowdata->RKAP_SUBPRO_ID . "' and IS_DELETED ='0' order by SUBPRO_ADD_ID asc");

        foreach ($query2->result() as $gantadd) {
             $number++;
            $startganttadd = strtotime($gantadd->SUBPRO_ADD_DATE);
            $newstartganttadd = date('Y, m, d', $startganttadd);
            $endganttadd = strtotime($gantadd->SUBPRO_ADD_END_REAL);
            $newendganttadd = date('Y, m, d', $endganttadd);
            ?>

                    ['Addendum <?php echo $number; ?>', new Date(<?php echo $newstartganttadd; ?>), new Date(<?php echo $newendganttadd; ?>)],

       
            <?php
        }
    }
}
?>
        ]);

        var options = {
            timeline: {colorByRowLabel: true},
        };

        chart.draw(dataTable);
    }
</script>
<script type="text/javascript">

    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('kebutuhan_dana');
    tanpa_rupiah.addEventListener('keyup', function (e)
    {
        tanpa_rupiah.value = formatRupiah(this.value);
    });

    tanpa_rupiah.addEventListener('keydown', function (event)
    {
        limitCharacter(event);
    });


    var tanpa_rupiah2 = document.getElementById('nilai_rkap');
    tanpa_rupiah2.addEventListener('keyup', function (e)
    {
        tanpa_rupiah2.value = formatRupiah(this.value);
    });

    tanpa_rupiah2.addEventListener('keydown', function (event)
    {
        limitCharacter(event);
    });

    var tanpa_rupiah3 = document.getElementById('triwulan_satu');
    tanpa_rupiah3.addEventListener('keyup', function (e)
    {
        tanpa_rupiah3.value = formatRupiah(this.value);
    });

    tanpa_rupiah3.addEventListener('keydown', function (event)
    {
        limitCharacter(event);
    });

    var tanpa_rupiah4 = document.getElementById('triwulan_dua');
    tanpa_rupiah4.addEventListener('keyup', function (e)
    {
        tanpa_rupiah4.value = formatRupiah(this.value);
    });

    tanpa_rupiah4.addEventListener('keydown', function (event)
    {
        limitCharacter(event);
    });

    var tanpa_rupiah5 = document.getElementById('triwulan_tiga');
    tanpa_rupiah5.addEventListener('keyup', function (e)
    {
        tanpa_rupiah5.value = formatRupiah(this.value);
    });

    tanpa_rupiah5.addEventListener('keydown', function (event)
    {
        limitCharacter(event);
    });

    var tanpa_rupiah6 = document.getElementById('triwulan_empat');
    tanpa_rupiah6.addEventListener('keyup', function (e)
    {
        tanpa_rupiah6.value = formatRupiah(this.value);
    });

    tanpa_rupiah6.addEventListener('keydown', function (event)
    {
        limitCharacter(event);
    });

    var tanpa_rupiah7 = document.getElementById('realisasi_sebelum');
    tanpa_rupiah7.addEventListener('keyup', function (e)
    {
        tanpa_rupiah7.value = formatRupiah(this.value);
    });

    tanpa_rupiah7.addEventListener('keydown', function (event)
    {
        limitCharacter(event);
    });

    var tanpa_rupiah8 = document.getElementById('taksasi');
    tanpa_rupiah8.addEventListener('keyup', function (e)
    {
        tanpa_rupiah8.value = formatRupiah(this.value);
    });

    tanpa_rupiah8.addEventListener('keydown', function (event)
    {
        limitCharacter(event);
    });

    /* Fungsi */
    function formatRupiah(bilangan, prefix)
    {
        var number_string = bilangan.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }


    function limitCharacter(event)
    {
        key = event.which || event.keyCode;
        if (key != 188 // Comma
                && key != 8 // Backspace
                && key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
                && (key < 48 || key > 57) // Non digit
                // Dan masih banyak lagi seperti tombol del, panah kiri dan kanan, tombol tab, dll
                )
        {
            event.preventDefault();
            return false;
        }
    }

</script>
<script type="text/javascript">
	
	$(document).ready(function() {
    	var el = document.getElementById('jenis_aktiva');
		var text = el.options[el.selectedIndex].innerHTML;
		$("#aktiva").html(text);
		
		var el = document.getElementById('jenis_investasi');
		var text = el.options[el.selectedIndex].innerHTML;
		$("#jns_investasi").html(text);
		
		var el = document.getElementById('tahun_investasi');
		var text = el.options[el.selectedIndex].innerHTML;
		$("#thn_investasi").html(text);
		
		    
    });
	
	function togleForm(){
		$("#formTogle").slideToggle();	
	}
	
	
    function check_number()
        {
            var number_contract = $('#project_number').val();
            // alert(number_contract);
            var link_base = "<?php echo base_url(); ?>";

          $.ajax({
                
                url: link_base + "rkapinvestasi/GetContractNumber",
                type: "post",
                dataType: 'json',
                
                cache: false,
                data: {nomor_kontrak : number_contract},
                success: function(data){
                 console.log(data);
                     if(data == 'ada')
                     {
                      alert('Nomor kontrak '+number_contract+' sudah terdaftar');
                      $('#project_number').val('');
                     }
                     else
                     {
                      $('#project_number').val(number_contract);
                     }
                }
            });
        }

</script>
</body>
<!-- END BODY -->
</html>