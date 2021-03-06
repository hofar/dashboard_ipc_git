
<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.2
Version: 3.6.2
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Penanganan Risiko</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/template/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/template/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/template/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo base_url(); ?>assets/template/admin/pages/css/invoice.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo base_url(); ?>assets/template/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/template/global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/template/admin/layout4/css/layout.css" rel="stylesheet" type="text/css"/>
        <link id="style_color" href="<?php echo base_url(); ?>assets/template/admin/layout4/css/themes/light.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/template/admin/layout4/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/icon.png"/>
        <style type="text/css">
            .table > thead > tr > th {
                vertical-align: bottom;
                background-color: #65054d !important;
                border: 1px solid #ddd;
                color:#FFF;
                text-align: center;
            }

            .table > tbody > tr > td {
                border: 1px solid #ddd;
            }

            .label-transparent {
                background-color: transparent;
                color: transparent;
            }

            .label-success {
                background-color: #5cb85c;
                color: #5cb85c;
            }

            .label-success-second {
                background-color: #a8fd13;
                color: #a8fd13;
            }

            .label-warning {
                background-color: #f6d71d;
                color: #f6d71d;
            }

            .label-warning-second {
                background-color: #ce820e;
                color: #ce820e;
            }
            .label-danger {
                background-color: #e73002;
                color: #e73002;
            }

            .label {
                display: inline;
                padding: .2em .6em .3em;
                font-size: 75%;
                font-weight: 700;
                line-height: 1;
                /*color: #fff;*/
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: .25em;
            }
            
            
            
            td{
                border: 1px solid black;
                padding: 5px;
                /*text-align: right;*/
            }
            
            th{
                border: 1px solid black;
                /*border-color: #dee3e5;*/
                padding: 8px;
                background-color: #4c94af;
                color: white;
                text-align: center;
            }
            
            .tngh{
                text-align: center;
            }
            
            body{
                background: #fff;
            }
            
            .ttljdl{
                text-transform: capitalize;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }
            /*th, td {
                text-align: center;
                padding: 8px;
            }*/
            /*tr:nth-child(even){background-color: #f2f2f2}*/
            /*th {
                background-color: #4c94af;
                color: white;
            }*/

            div#container {
                font: normal 12px Arial, Helvetica, Sans-serif;
                background: white;
                padding: 20px;
            }
            [data-iterate="item"] td:first-child {
                text-indent: -9999px;
            }
            .login_ipc {
                position: absolute;
                top: 2.5em;
                left: 15em;
                width: 150px;
            }
        </style>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
    <!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
    <!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
    <!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
    <!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
    <!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
    <!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
    <!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
    <!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo ">
        <!-- BEGIN HEADER -->
<!--        <style>
            table, th, td {
                border: 1px solid black;
            }
        </style>-->
        <div class="clearfix">
        </div>
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <div class="page-content">


                    <!-- BEGIN PAGE CONTENT-->
                    <div class="portlet light">
                        <div class="portlet-body">
                            <div class="invoice">
                                <div class="row invoice-logo">
                                    <div class="col-xs-12" style="text-align: center;">
                                        <div class="col-xs-2">
                                            <img class="login_ipc" src="<?php echo base_url(); ?>assets/img/ipc_logo.png"/>
                                        </div>
                                        <div class="col-xs-6">
                                            <h4>DIREKTORAT TEKNIK DAN MANAJEMEN RESIKO</h4>
                                            <h4>PT PELABUHAN INDONESIA II (PERSERO)</h4>
                                            <h4>Penanganan Risiko</h4>
                                        </div>
                                        <div class="col-xs-2"></div><hr>
                                    </div>
                                </div>
                                <div style="text-align: left;">
                                    <label>Judul Program &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                        <span><?php echo $find->RKAP_INVS_TITLE ?></span>
                                    </label><br>
                                    <label>Judul Sub Program :
                                        <span><?php echo $find->RKAP_SUBPRO_TITTLE ?></span>
                                    </label><br>
                                    <label>Jenis Sub Program&nbsp;:
                                        <span><?php echo $find->SUBPRO_TYPE_NAME ?></span>
                                    </label><br>
                                    <label>Posisi Program &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                        <span><?php echo $find->POSPROG_NAME ?></span>
                                    </label><br>
                                </div>
                                <div class="row">
                                    <div class="col-xs-7">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">NO</th>
                                                    <th rowspan="2">Risiko</th>
                                                    <th rowspan="2">Deskripsi Risiko</th>
                                                    <th rowspan="2">Dampak Risiko</th>
                                                    <th colspan="3">Nilai Risiko Residual</th>
                                                    <th rowspan="2">Rencana Penanganan Risiko</th>
                                                </tr>
                                                <tr>
                                                    <th>IK</th>
                                                    <th>ID</th>
                                                    <th>Tingkat Risiko</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            <div class="col-md-12" style="margin-top: 20px;">
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


                                                <?php $no = 0; for ($i = 0; $i < count($list); $i++) { $no++; ?>
                                                    <tr id="hide_tr<?php echo $no ?>">
                                                        <td class="tngh"><?php echo $list[$i]->SERIAL; ?></td>
                                                        <td><?php echo $list[$i]->tipe; ?></td>
                                                        <td><?php echo $list[$i]->RISK_DESC; ?></td>
                                                        <td><?php echo $list[$i]->dampak; ?></td>
                                                        <td class="tngh"><?php echo $list[$i]->RISK_IK; ?></td>
                                                        <td class="tngh"><?php echo $list[$i]->RISK_ID; ?></td>
                                                        <td class="tngh">
                                                            <?php if ($row_subprogram_risiko == null): ?>
                                                                <?php $warna = "label-transparent"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == null && $list[$i]->RISK_ID == null): ?>
                                                                <?php $warna = "label-transparent"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == null OR $list[$i]->RISK_ID == null): ?>
                                                                <?php $warna = "label-transparent"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 1): ?>
                                                                <?php $warna = "label-success"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 2): ?>
                                                                <?php $warna = "label-success"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 3): ?>
                                                                <?php $warna = "label-success-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 4): ?>
                                                                <?php $warna = "label-success-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 5): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 1): ?>
                                                                <?php $warna = "label-success"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 2): ?>
                                                                <?php $warna = "label-success-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 3): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 4): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 5): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 1): ?>
                                                                <?php $warna = "label-success-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 2): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 3): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 4): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 5): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 1): ?>
                                                                <?php $warna = "label-success-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 2): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 3): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 4): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 5): ?>
                                                                <?php $warna = "label-danger"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 1): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 2): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 3): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 4): ?>
                                                                <?php $warna = "label-danger"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 5): ?>
                                                                <?php $warna = "label-danger"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 1): ?>
                                                                <?php $warna = "label-success"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 1): ?>
                                                                <?php $warna = "label-success"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 1): ?>
                                                                <?php $warna = "label-success-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 1): ?>
                                                                <?php $warna = "label-success-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 1): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 2): ?>
                                                                <?php $warna = "label-success"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 2): ?>
                                                                <?php $warna = "label-success-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 2): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 2): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 2): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 3): ?>
                                                                <?php $warna = "label-success-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 3): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 3): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 3): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 3): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 4): ?>
                                                                <?php $warna = "label-success-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 4): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 4): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 4): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 4): ?>
                                                                <?php $warna = "label-danger"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 5): ?>
                                                                <?php $warna = "label-warning"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 5): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 5): ?>
                                                                <?php $warna = "label-warning-second"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 5): ?>
                                                                <?php $warna = "label-danger"; ?>
                                                            <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 5): ?>
                                                            <?php $warna = "label-danger"; ?>
                                                            <?php endif ?>

                                                            <span class="label <?php echo $warna ?>" id="color<?php echo $no ?>">Label warna</span>
                                                        </td>
                                                        <td><?php echo $list[$i]->RISK_SOLVING; ?></td>
                                                    </tr>
                                                <?php } ?> 
                                            <?php endif; ?> 
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-xs-4">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">Realisasi Penanganan Risiko</th>
                                                    <th colspan="3">Nilai Risiko Residual</th>
                                                    <th rowspan="2" style="padding-bottom: 30px;">Status</th>
                                                </tr>
                                                <tr>
                                                    <th>IK</th>
                                                    <th>ID</th>
                                                    <th>Tingkat Risiko</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 0;for ($i = 0; $i < count($list_real); $i++) { $no++; ?>
                                                <tr>
                                                    <td><?php echo $list_real[$i]->RISK_REALISASI; ?></td>
                                                    <td><?php echo $list_real[$i]->RISK_IK; ?></td>
                                                    <td><?php echo $list_real[$i]->RISK_ID; ?></td>
                                                    <td>
                                                    <?php if ($row_subprogram_risiko == null): ?>
                                                        <?php $warna = "label-transparent"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == null && $list[$i]->RISK_ID == null): ?>
                                                        <?php $warna = "label-transparent"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == null OR $list[$i]->RISK_ID == null): ?>
                                                        <?php $warna = "label-transparent"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 1): ?>
                                                        <?php $warna = "label-success"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 2): ?>
                                                        <?php $warna = "label-success"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 3): ?>
                                                        <?php $warna = "label-success-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 4): ?>
                                                        <?php $warna = "label-success-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 5): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 1): ?>
                                                        <?php $warna = "label-success"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 2): ?>
                                                        <?php $warna = "label-success-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 3): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 4): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 5): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 1): ?>
                                                        <?php $warna = "label-success-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 2): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 3): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 4): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 5): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 1): ?>
                                                        <?php $warna = "label-success-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 2): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 3): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 4): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 5): ?>
                                                        <?php $warna = "label-danger"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 1): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 2): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 3): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 4): ?>
                                                        <?php $warna = "label-danger"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 5): ?>
                                                        <?php $warna = "label-danger"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 1): ?>
                                                        <?php $warna = "label-success"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 1): ?>
                                                        <?php $warna = "label-success"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 1): ?>
                                                        <?php $warna = "label-success-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 1): ?>
                                                        <?php $warna = "label-success-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 1): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 2): ?>
                                                        <?php $warna = "label-success"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 2): ?>
                                                        <?php $warna = "label-success-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 2): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 2): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 2): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 3): ?>
                                                        <?php $warna = "label-success-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 3): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 3): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 3): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 3): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 4): ?>
                                                        <?php $warna = "label-success-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 4): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 4): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 4): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 4): ?>
                                                        <?php $warna = "label-danger"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 1 && $list[$i]->RISK_ID == 5): ?>
                                                        <?php $warna = "label-warning"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 2 && $list[$i]->RISK_ID == 5): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 3 && $list[$i]->RISK_ID == 5): ?>
                                                        <?php $warna = "label-warning-second"; ?>
                                                    <?php elseif ($list[$i]->RISK_IK == 4 && $list[$i]->RISK_ID == 5): ?>
            <?php $warna = "label-danger"; ?>
        <?php elseif ($list[$i]->RISK_IK == 5 && $list[$i]->RISK_ID == 5): ?>
            <?php $warna = "label-danger"; ?>
        <?php endif ?>

                                                    <span class="label <?php echo $warna ?>" id="color<?php echo $no ?>">Label warna</span>
                                                </td>
                                                <td align="center">Aktif</td>
                                                </tr>
                                            <?php } ?> 
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT-->
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
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
        <script src="<?php echo base_url(); ?>assets/template/global/scripts/metronic.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/template/admin/layout4/scripts/layout.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/template/admin/layout4/scripts/demo.js" type="text/javascript"></script>
        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                Demo.init(); // init demo features
            });
        </script>
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>