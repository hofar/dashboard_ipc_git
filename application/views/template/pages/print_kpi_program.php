
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
        <title>RKAP Investasi</title>
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
            
            .tngh{
                text-align: center;
            }
            
            body{
                background: #fff;
            }
            
            .ttljdl{
                text-transform: capitalize;
            }

        </style>
        <style type="text/css">
            #customers {
			    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
			    border-collapse: collapse;
			    width: 100%;
			}

			#customers td, #customers th {
			    border: 1px solid #ddd;
			    padding: 8px;
			    text-align: center;
			}

			#customers tr:nth-child(even){background-color: #f2f2f2;}

			#customers tr:hover {background-color: #ddd;}

			#customers th {
			    padding-top: 12px;
			    padding-bottom: 12px;
			    text-align: left;
			    background-color: #4c94af;
			    color: white;
			    text-align: center;
			    font-size: 70%;
			}

            div#container {
                font: normal 12px Arial, Helvetica, Sans-serif;
                background: white;
                padding: 20px;
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
                                <div class="row">
                                    <div class="col-xs-12" style="text-align: center;">
                                        <center>
                                            <h4 style="font-weight: bold;">
                                                DIREKTORAT TEKNIK DAN MANAJEMEN RESIKO<br>
                                                PT PELABUHAN INDONESIA II (PERSERO)<br>
                                                REKAPITULASI LAPORAN KPI REALISASI PROGRAM BULANAN
                                            </h4>
                                            <hr>
                                        </center>
                                    </div>
                                    <div class="col-xs-12">
                                        <table id="customers">
							                <thead>
							                    <tr>
							                        <th rowspan="3" style="padding-bottom: 10px;">NO</th>
							                        <th rowspan="3" style="padding-bottom: 10px;">CABANG PELABUHAN / UNIT</th>
							                        <th colspan="8">KPI PROGRAM</th>
							                        <th rowspan="3" style="padding-bottom: 10px;">% PROGRAM BERJALAN</th>
							                    </tr>
							                    <tr>
							                        <th colspan="4">JUMLAH PROGRAM DALAM RKAP</th>
							                        <th colspan="4">JUMLAH PROGRAM BERJALAN</th>
							                    </tr>
							                    <tr>
							                        <th>SIPIL</th>
							                        <th>PERALATAN</th>
							                        <th>NON FISIK</th>
							                        <th>TOTAL</th>
							                        <th>SIPIL</th>
							                        <th>PERALATAN</th>
							                        <th>NON FISIK</th>
							                        <th>TOTAL</th>
							                    </tr>
							                </thead>
							                <tfoot style="background-color: black; color: white;">
							                    <tr style="text-align: center;">
							                      <td colspan="2">JUMLAH</td>
							                      <td>
							                            <?php foreach ($jumlah_sipil_rkap as $list):
							                                if ($list->TOTAL_PROGRAM > 0) {
							                                        echo $list->TOTAL_PROGRAM;
							                                    }
							                                else{
							                                        echo '0';
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                      </td>
							                      <td>
							                            <?php foreach ($jumlah_peralatan_rkap as $list):
							                                if ($list->TOTAL_PROGRAM > 0) {
							                                        echo $list->TOTAL_PROGRAM;
							                                    }
							                                else{
							                                        echo '0';
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                      </td>
							                      <td>
							                            <?php foreach ($jumlah_non_sipil_rkap as $list):
							                                if ($list->TOTAL_PROGRAM > 0) {
							                                        echo $list->TOTAL_PROGRAM;
							                                    }
							                                else{
							                                        echo '0';
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                      </td>
							                      <td>
							                            <?php foreach ($jumlah_total_rkap as $list):
							                                if ($list->TOTAL_PROGRAM > 0) {
							                                        echo $list->TOTAL_PROGRAM;
							                                    }
							                                else{
							                                        echo '0';
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                      </td>
							                      <td>
							                            <?php foreach ($jumlah_sipil_berjalan as $list):
							                                if ($list->TOTAL_PROGRAM > 0) {
							                                        echo $list->TOTAL_PROGRAM;
							                                    }
							                                else{
							                                        echo '0';
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                      </td>
							                      <td>
							                            <?php foreach ($jumlah_peralatan_berjalan as $list):
							                                if ($list->TOTAL_PROGRAM > 0) {
							                                        echo $list->TOTAL_PROGRAM;
							                                    }
							                                else{
							                                        echo '0';
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                      </td>
							                      <td>
							                            <?php foreach ($jumlah_non_sipil_berjalan as $list):
							                                if ($list->TOTAL_PROGRAM > 0) {
							                                        echo $list->TOTAL_PROGRAM;
							                                    }
							                                else{
							                                        echo '0';
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                      </td>
							                      <td>
							                            <?php foreach ($jumlah_total_berjalan as $list):
							                                if ($list->TOTAL_PROGRAM > 0) {
							                                        echo $list->TOTAL_PROGRAM;
							                                    }
							                                else{
							                                        echo '0';
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                      </td>
							                      <td>
							                          <?php foreach ($persentase_berjalan_footer as $list):
							                                if ($list->PERSENTASE_BERJALAN > 0) {
							                                        echo $list->PERSENTASE_BERJALAN;
							                                    }
							                                else{
							                                        echo '0';
							                                    }
							                                ?>
							                            <?php endforeach; ?>%
							                      </td>
							                    </tr>
							                </tfoot>
							                <tbody style="text-align: center;">
							                    <?php $a=1; foreach ($get_cabang_2 as $row): ?>
							                    <tr>
							                        <td><?php echo $a++; ?></td>
							                        <td style="text-align: left;"><?php echo $row->BRANCH_NAME; ?></td>
							                        <td>
							                            <?php foreach ($sipil_rkap as $list):
							                                if ($list->BRANCH_NAME == $row->BRANCH_NAME) {
							                                    if ($list->TOTAL_PROGRAM > 0) {
							                                            echo $list->TOTAL_PROGRAM;
							                                        }
							                                    else{
							                                           echo '0';
							                                        }
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                        </td>
							                        <td>
							                            <?php foreach ($peralatan_rkap as $list):
							                                if ($list->BRANCH_NAME == $row->BRANCH_NAME) {
							                                    if ($list->TOTAL_PROGRAM > 0) {
							                                            echo $list->TOTAL_PROGRAM;
							                                        }
							                                    else{
							                                           echo '0';
							                                        }
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                        </td>
							                        <td>
							                            <?php foreach ($non_fisik_rkap as $list):
							                                if ($list->BRANCH_NAME == $row->BRANCH_NAME) {
							                                    if ($list->TOTAL_PROGRAM > 0) {
							                                            echo $list->TOTAL_PROGRAM;
							                                        }
							                                    else{
							                                           echo '0';
							                                        }
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                        </td>
							                        <td>
							                            <?php foreach ($total_report_rkap as $list):
							                                if ($list->BRANCH_NAME == $row->BRANCH_NAME) {
							                                    if ($list->TOTAL_PROGRAM > 0) {
							                                            echo $list->TOTAL_PROGRAM;
							                                        }
							                                    else{
							                                           echo '0';
							                                        }
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                        </td>
							                        <td>
							                            <?php foreach ($sipil_berjalan as $list):
							                                if ($list->BRANCH_NAME == $row->BRANCH_NAME) {
							                                    if ($list->TOTAL_PROGRAM > 0) {
							                                            echo $list->TOTAL_PROGRAM;
							                                        }
							                                    else{
							                                           echo '0';
							                                        }
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                        </td>
							                        <td>
							                            <?php foreach ($peralatan_berjalan as $list):
							                                if ($list->BRANCH_NAME == $row->BRANCH_NAME) {
							                                    if ($list->TOTAL_PROGRAM > 0) {
							                                            echo $list->TOTAL_PROGRAM;
							                                        }
							                                    else{
							                                           echo '0';
							                                        }
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                        </td>
							                        <td>
							                            <?php foreach ($non_fisik_berjalan as $list):
							                                if ($list->BRANCH_NAME == $row->BRANCH_NAME) {
							                                    if ($list->TOTAL_PROGRAM > 0) {
							                                            echo $list->TOTAL_PROGRAM;
							                                        }
							                                    else{
							                                           echo '0';
							                                        }
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                        </td>
							                        <td>
							                            <?php foreach ($total_report_berjalan as $list):
							                                if ($list->BRANCH_NAME == $row->BRANCH_NAME) {
							                                    if ($list->TOTAL_PROGRAM > 0) {
							                                            echo $list->TOTAL_PROGRAM;
							                                        }
							                                    else{
							                                           echo '0';
							                                        }
							                                    }
							                                ?>
							                            <?php endforeach; ?>
							                        </td>
							                        <td>
							                            <?php foreach ($persentase_berjalan as $list):
							                                if ($list->BRANCH_NAME == $row->BRANCH_NAME) {
							                                    if ($list->PERSENTASE_BERJALAN > 0) {
							                                            echo $list->PERSENTASE_BERJALAN;
							                                        }
							                                    else{
							                                           echo '0';
							                                        }
							                                    }
							                                ?>
							                            <?php endforeach; ?>%
							                        </td>
							                    </tr>
							                    <?php endforeach; ?>
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