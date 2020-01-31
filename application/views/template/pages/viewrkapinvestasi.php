
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
            <li class="breadcrumb-item"> <a href="<?php echo base_url(); ?>rkapinvestasi">RKAP Investasi</a></li>
            <li class="breadcrumb-item active">List RKAP Investasi</li>
        </ol>
        <div class="headTab">
        	 	<i class="icon md-time-interval"></i> 
                RKAP Investasi
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

                             <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                     <a href="<?php echo base_url(); ?>rkapinvestasi" class="btn btn-warning btn-round" id="reset">Tampilkan semua data</a>
                             <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                     <a href="<?php echo base_url(); ?>rkapinvestasi" class="btn btn-warning btn-round" id="reset">Tampilkan semua data</a>
                            <?php else: ?>
                                <a href="<?php echo base_url(); ?>rkapinvestasi/add" class="btn btn-success btn-round" style="width:150px"> Tambah</a>
                                <a href="<?php echo base_url(); ?>rkapinvestasi" class="btn btn-info btn-round" id="reset">
                                	Tampilkan semua data
                                </a>
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
                                                                            if ( $row->BRANCH_NAME == $this->session->search1['cabang']) {
                                                                                echo '<option selected value="' . $row->BRANCH_NAME . '">' . $row->BRANCH_NAME . '</option>';
                                                                            }
                                                                            else{
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
                                                                 if ( $row->POSPROG_NAME == $this->session->search1['posisi']) {
                                                                    echo '<option selected value="' . $row->POSPROG_NAME . '">' . $row->POSPROG_NAME . '</option>';
                                                                }
                                                                else{
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
                                                                        if ( $row->BRANCH_NAME == $this->session->search2['sort_cabang']) {
                                                                                echo '<option selected value="' . $row->BRANCH_NAME . '">' . $row->BRANCH_NAME . '</option>';
                                                                            }
                                                                            else{
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
                                                                        if ( $this->session->search2['kebutuhan'] == "-" or $this->session->search2['kebutuhan'] == NULL) {
                                                                                echo '<option selected value="-">-- Pilih Sorting --</option>';
                                                                                echo '<option value="4">10 Teratas</option>';
                                                                                echo '<option value="3">10 Terbawah</option>';
                                                                            }
                                                                            elseif($this->session->search2['kebutuhan'] == 4){
                                                                                echo '<option value="-">-- Pilih Sorting --</option>';
                                                                                 echo '<option selected value="4">10 Teratas</option>';
                                                                                 echo '<option value="3">10 Terbawah</option>';
                                                                            }
                                                                            else{
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
                                                                        if ( $this->session->search2['rkap'] == "-" or $this->session->search2['rkap'] == NULL) {
                                                                                echo '<option selected value="-">-- Pilih Sorting --</option>';
                                                                                echo '<option value="2">10 Teratas</option>';
                                                                                echo '<option value="1">10 Terbawah</option>';
                                                                            }
                                                                            elseif($this->session->search2['rkap'] == 2){
                                                                                echo '<option selected value="-">-- Pilih Sorting --</option>';
                                                                                 echo '<option selected value="2">10 Teratas</option>';
                                                                                 echo '<option value="1">10 Terbawah</option>';
                                                                            }
                                                                            else{
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
                                <table class="table table-hover dataTable w-full" style="font-size:13px">
                                    <thead>
                                        <tr>
                                            <th class="headTable" width="36" height="40">Kode</th>
                                            <th class="headTable" width="53">Tools</th>
                                            <th class="headTable" width="383">Investasi</th>
                                            <th class="headTable" width="258">Nilai</th>
                                            <th class="headTable" width="119">Posisi</th>
                                            <th class="headTable" width="313">Jangka Waktu</th>
                                            <th class="headTable" width="65">Indikator</th>
                                            
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
                                            <?php endif; ?>
                                        </div>
        								<?php foreach ($list as $row): ?>
                                            <tr style="color:#999;font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:500">
                                                <td class="isiGrid"><?php echo $row->RKAP_INVS_ID; ?></td>
                                                <td align="center">
                                                	<div class="btn-group">
                                                      <button type="button" class="btn btn-warning dropdown-toggle" id="exampleAnimationDropdown1"
                                                        data-toggle="dropdown" aria-expanded="false"><B>Tools</B></button>
                                                      <div class="dropdown-menu animate" aria-labelledby="exampleAnimationDropdown1"
                                                        role="menu">
                                                        <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                            <a class="dropdown-item" 
                                                            href="<?php echo base_url() ?>rkapinvestasi/detail/<?php echo $row->RKAP_INVS_ID ?>" 
                                                            role="menuitem"><i class="icon md-card-travel" ></i>  Detail Data</a>
                                                        
                                                        <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                             <a class="dropdown-item" 
                                                            href="<?php echo base_url() ?>rkapinvestasi/detail/<?php echo $row->RKAP_INVS_ID ?>" 
                                                            role="menuitem"><i class="icon md-card-travel" ></i>  Detail Data</a>
                                                        <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                                            <a class="dropdown-item" 
                                                            href="<?php echo base_url() ?>rkapinvestasi/detail/<?php echo $row->RKAP_INVS_ID ?>" 
                                                            role="menuitem"><i class="icon md-card-travel" ></i>  Detail Data</a>
                                                        <?php else: ?>
                                                            <a class="dropdown-item" 
                                                            href="<?php echo base_url() ?>rkapinvestasi/detail/<?php echo $row->RKAP_INVS_ID ?>" 
                                                            role="menuitem"><i class="icon md-card-travel" ></i>  Detail Data</a>
                                                        
                                                            <a class="dropdown-item" 
                                                            href="<?php echo base_url() ?>rkapinvestasi/update/<?php echo $row->RKAP_INVS_ID ?>" 
                                                            role="menuitem"><i class="icon md-edit" ></i> Edit Data</a>
                                                            
                                                          <a class="dropdown-item" href="#" onclick="btn_delete_rkap(<?php echo $row->RKAP_INVS_ID ?>)" 
                                                            role="menuitem" data-toggle="modal" data-target="#hapus"><i class="icon md-delete" ></i>  Delete Data</a> 
                                                           <!--  <span data-toggle="tooltip" title="Delete Data">
                                                                <a href="<?php echo base_url() ?>rkapinvestasi/delete_modal/<?php echo $row->RKAP_INVS_ID ?>" class="btn btn-sm btn-danger btn-aksion" data-toggle="modal" data-target="#hapus" ><i class="fa fa-trash-o" ></i></a>&nbsp;
                                                            </span> -->
                                                        <?php endif ?>
                                                        
                                                      </div>
                                                    </div>
                                                    <?php
                                                    $sub1 = explode('-',$row->ON_USE);
                                                    ?>
                                                    <a href="<?php echo base_url('setting/change/').$row->RKAP_INVS_ID.'/'.$sub1[0]; ?>" class="btn btn-xs <?php if ($sub1[0] == 'Y') {echo "btn-primary";}else{echo "btn-danger";}?>" style="margin-top:10px;"><B><?php if ($sub1[0] == 'Y') {echo "Dipakai";}else{echo "Tidak-".$sub1[1];}?></B></a>
                            
                                                </td>
                                                <td>
                                                	<span class="labelGrid">
                                                    	Cabang :<br />
                                                    </span>
        											<span class="isiGrid" style="color:#F60">
        												<i class="icon md-pin"></i> 
        												<?php echo $row->BRANCH_NAME; ?>
        											</span>
                                                    <br /><br />
                                                    <span class="labelGrid">
                                                    	Judul :<br />
                                                    </span>
        											<span class="isiGrid3">
        												<?php echo $row->RKAP_INVS_TITLE; ?>
                                                 	</span>
                                                 </td>
                                                <td style="color:#090;font-size:15px">
                                                    <span class="labelGrid">
                                                    	<i class="icon md-receipt"></i>
                                                    	Kebutuhan :
                                                    </span><br />
                                                    <span class="isiGrid">Rp. <?php echo number_format($row->RKAP_INVS_COST_REQ, 2, ',', '.') ?></span>
                                                    <br />
                                                    <hr />
                                                    <span class="labelGrid">
                                                    	<i class="icon md-arrow-missed"></i> 
                                                        Nilai RKAP :
                                                    </span><br />
                                                    <b class="isiGrid">Rp. <?php echo number_format($row->RKAP_INVS_VALUE, 2, ',', '.') ?></b>
                                                </td>
                                                <td align="center">
                                                	<a style="color:#FFF; font-size:13px; padding:5px" class="badge badge-pill badge-success">
        											<?php echo $row->POSPROG_NAME; ?></a>
                                                </td>
                                                <td style="color:#090; font-weight:500;font-size:15px"> 
                                                	<span class="labelGrid">
                                                    	<i class="icon md-long-arrow-left"></i>
                                                    	Bulan Sebelumnya :
                                                    </span><br />
                                                    
                                                    
                                                    <?php foreach ($list2 as $list): 
                                                        if ($list->RKAP_SUBPRO_INVS_ID == $row->RKAP_INVS_ID) {
                                                            echo "<b class='isiGrid'>Rp. ".number_format($list->REAL_SUBPRO_VAL, 2, ',', '.')."</b>";
                                                        }
                                                    ?>
                                                    </b>
                                                    
                                                    <?php endforeach; ?> 
                                                 	<hr />
                                                    
                                                    <span class="labelGrid">
                                                    	<i class="icon md-calendar"></i> 
                                                        Bulan Ini :
                                                    </span><br />
                                                    
                                                    
                                                    <?php foreach ($list3 as $list): 
                                                        if ($list->RKAP_SUBPRO_INVS_ID == $row->RKAP_INVS_ID) {
                                                            echo "<b class='isiGrid'>Rp. ".number_format($list->REAL_SUBPRO_VAL, 2, ',', '.')."</b>";
                                                        } 
                                                    ?>
                                                    
                                                    <?php endforeach; ?>
                                                    <hr />
                                                  
                                                    <span class="labelGrid">
                                                    	<i class="icon md-long-arrow-right"></i>
                                                    	Sampai Dengan Bulan Ini :
                                                    </span><br />
                                                    
                                                    <?php foreach ($list4 as $list): 
                                                        if ($list->RKAP_SUBPRO_INVS_ID == $row->RKAP_INVS_ID) {
                                                            echo "<b class='isiGrid'>Rp. ".number_format($list->REAL_SUBPRO_VAL, 2, ',', '.')."</b>";
                                                        }
                                                    ?>
                                                    
                                                    <?php endforeach; ?>
                                                </td>
                                                <td align="center">
                                                <?php foreach ($hasil_persentase as $val): 
                                                     if ($val->RKAP_INVS_ID == $row->RKAP_INVS_ID) {
                                                         $target1 = 0.5 * $val->TARGETZ;
                                                         $target2 = 0.9 * $val->TARGETZ;
                                                            if ($val->REALISASI < $target1 ){
                                                                    echo'<button  class="btn btn-icon btn-round" style="background-color: #e73002; color: #e73002">
                                                                        <i class="icon md-pin"></i>
                                                                    </button>';
        															// $color = "#f6d71d";
                                                                    
                                                            }
                                                            else if ($val->REALISASI  >= $target2){
                                                                    echo'<button  class="btn btn-icon btn-round" style="background-color: #a8fd13; color: #a8fd13">
                                                                        <i class="icon md-pin"></i>
                                                                    </button>';
                                                                    // $color = "#e73002";
        															
                                                            }
                                                            else {
                                                                    echo'<button  class="btn btn-icon btn-round" style="background-color: #f6d71d; color: #f6d71d">
                                                                        <i class="icon md-pin"></i>
                                                                    </button>';
                                                                   // $color = "#a8fd13";
        														    
                                                            }
                                                        }
                                                      ?>      
                                                <?php endforeach; ?>
                                                </td>
                                                
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php  echo isset($halaman)?$halaman:""; ?>
                                
                                
                            </div>
                            <div class="modal fade modal-3d-slit modal-danger" id="hapus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1"> 
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
                    
                        <!-- END PORTLET-->
                    </div>
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

    $(".reset").click(function() {
        $(this).closest('form').find("input[type=text], textarea").val("");
        alert('asdaduka');
    });
	
	function togleFilter(){
		$("#conFilter").slideToggle(300);	
	}
    window.onload=function(){
        $("#rkapinvestasi").attr("class","site-menu-item active");
    }
</script>

<script type="text/javascript">
    var link_base = "<?php echo base_url(); ?>";
    function btn_delete_rkap(id) {
        // alert(id);
        document.getElementById("modaldeleterkap").action = link_base+'/rkapinvestasi/delete/'+id;
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