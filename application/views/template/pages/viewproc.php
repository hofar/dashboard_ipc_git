<style type="text/css">
    .table>thead>tr>th {
        vertical-align: bottom;
        border: 1px solid #ddd;
        text-align: center;
        color: #666;
        background-color: #EBEBEB;
        font-size: 14px
    }

    .table>tbody>tr>td {
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
</style>


<div class="page">
    <div class="page-content">

        <div class="row">
        <div class="col-9">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Project Costing Integrasi</li>
        </ol>
        </div>
        <div class="col-3">
        <a href="<?php echo base_url(); ?>projectcostingcems/pilihintegrasi" class="btn btn-primary">Pilih Kontrak / Addendum <span class="badge badge-pill"><?php echo $notif_in->JML;?></span></a>
        </div>
        </div>
        <div class="panels">

            <div class="example-wrap">
                <div class="nav-tabs-horizontal" data-plugin="tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#exampleTabsOne"
                                aria-controls="exampleTabsOne" role="tab" aria-selected="false">INVESTASI / RKAP</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#exampleTabsTwo"
                                aria-controls="exampleTabsTwo" role="tab" aria-selected="false">SUB PROGRAM</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#exampleTabsThree"
                                aria-controls="exampleTabsThree" role="tab" aria-selected="false">REALISASI <span class="badge badge-pill badge-danger"><?php echo $notif_re->JML;?></span></a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#exampleTabsFour"
                                aria-controls="exampleTabsFour" role="tab" aria-selected="true">ADDENDUM</a></li>
                    </ul>
                    <div class="tab-content pt-20">
                        <div class="tab-pane active" id="exampleTabsOne" role="tabpanel">
                            <!-- pilih data -->
                            <h4>DATA LOG INVESTASI / RKAP</h4>
                            <hr>
                            <div id="alertrkap" class="alert dark alert-alt alert-success alert-dismissible" role="alert" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                !!! Data berhasil masuk
                            </div>
                            <table class="table table-bordered" id="mydata1">
                            <thead>
                                <tr>
                                    <th>Cabang</th>
                                    <th>Data Yang Di Proses</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody id="show_data1">
                                
                            </tbody>
                            </table>

                        </div>
                        <div class="tab-pane" id="exampleTabsTwo" role="tabpanel">
                            <!-- pilih data -->
                            <h4>DATA LOG SUBPROGRAM</h4>
                            <hr>
                            <div id="alertkontrak" class="alert dark alert-alt alert-success alert-dismissible" role="alert" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                !!! Data berhasil masuk
                            </div>
                            <table class="table table-bordered" id="mydata2">
                            <thead>
                                <tr>
                                    <th>Cabang</th>
                                    <th>Data Yang Di Proses</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody id="show_data2">
                                
                            </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="exampleTabsThree" role="tabpanel">
                            <!-- pilih data -->
                            <h4>DATA LOG REALISASI</h4>
                            <hr>
                            <button id="regeneratereal" class="btn btn-primary">Generate Ulang</button>
                            <hr>
                            <div id="alertrealisasi" class="alert dark alert-alt alert-success alert-dismissible" role="alert" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                Generate Ulang data realisasi Selesai !!!
                            </div>
                            <table class="table table-bordered" id="mydata3">
                            <thead>
                                <tr>
                                    <th>Cabang</th>
                                    <th>Data Yang Di Proses</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody id="show_data3">
                                
                            </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="exampleTabsFour" role="tabpanel">
                            <!-- pilih data -->
                            <h4>DATA LOG ADDENDUM</h4>
                            <hr>
                            <div id="alertaddendum" class="alert dark alert-alt alert-success alert-dismissible" role="alert" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                !!! Data berhasil masuk
                            </div>
                            <table class="table table-bordered" id="mydata4">
                            <thead>
                                <tr>
                                    <th>Cabang</th>
                                    <th>Data Yang Di Proses</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody id="show_data4">
                                
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>