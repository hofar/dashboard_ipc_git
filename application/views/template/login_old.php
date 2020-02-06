<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.2
Version: 3.3.0
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
        <title>Dashboard Realisasi Investasi | Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="<?php echo base_url(); ?>assets/template/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/template/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/template/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo base_url(); ?>assets/template/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo base_url(); ?>assets/template/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/template/global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/template/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/template/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo base_url(); ?>assets/template/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/icon.png"/>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="login" onunload="">
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="menu-toggler sidebar-toggler">
        </div>
        <!-- END SIDEBAR TOGGLER BUTTON -->
        <!-- BEGIN LOGO -->
        <div class="logo">
            <!-- <a href="index.html">
            <img src="<?php echo base_url(); ?>assets/template/admin/layout4/img/logo-big.png" alt=""/>
            </a> -->
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="col-md-12 col-sm-12">
            <div class="row">
                <div class="col-md-12 col-sm-5">
                    <!-- <div class="content"> --><center>
                        <img src="<?php echo base_url(); ?>assets/img/ipc_logo.png" width="200px" height="130px" class="img-responsive">
                        <!-- </div> --></center>
                </div>
                <div class="col-md-12 col-sm-7">
                    <div class="content">
                        <!-- BEGIN LOGIN FORM -->
                        <form  role="form" action="<?php echo base_url('login'); ?>" method="post">
                            <h3 class="form-title">Sign In</h3>
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
                            <div class="form-group">
                                <?php
                                if ($this->session->flashdata('user_name')):
                                    $user_name = $this->session->flashdata('user_name');
                                else :
                                    $user_name = "";
                                endif
                                ?>
                                <label class="control-label visible-ie8 visible-ie9">Username</label>
                                <input class="form-control form-control-solid placeholder-no-fix" autocomplete="off" placeholder="Username" name="user_name" value="<?php echo $user_name; ?>" type="text" data-validation="required" data-validation-error-msg="Username harus diisi"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Password</label>
                                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="user_password" data-validation="required" data-validation-error-msg="Password harus diisi"/>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success uppercase">Login</button>
                                <label class="rememberme check">
                                    <input type="checkbox" name="remember" value="1"/>Remember </label>
                                <a href="#" class="forget-password" data-toggle="modal" data-target="#myModal">Forgot Password?</a>
                            </div>
                        </form>
                        <!-- END LOGIN FORM -->

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Notification</h4>
                    </div>
                    <div class="modal-body">
                        <p>Please contact System Administrator.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning btn-md" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="copyright">
            2017 © Indonesia Port Corporation.
        </div>
        <!-- END LOGIN -->
        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- BEGIN CORE PLUGINS -->
        <!--[if lt IE 9]>
        <script src="<?php echo base_url(); ?>assets/template/global/plugins/respond.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/template/global/plugins/excanvas.min.js"></script> 
        <![endif]-->
        <script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/template/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url(); ?>assets/template/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url(); ?>assets/template/global/scripts/metronic.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/template/admin/layout/scripts/layout.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/template/admin/layout/scripts/demo.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/login.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                Login.init();
                Demo.init();
            });
        </script>
        <script src="<?php echo base_url(); ?>assets/form-validator/jquery.form-validator.min.js"></script>
        <script>
            $.validate({
                modules: 'security'
            });
        </script>
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>