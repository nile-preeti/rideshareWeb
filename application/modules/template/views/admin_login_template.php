<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <title><?php echo $title;?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="Admin Panel - Welcome to the world's only High-end RideshareRates!">
    <meta name="author" content="Venmond">
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/ico/favicon.png');?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo $title?? 'Club Reward';?></title>
    <!-- CSS -->
    <!-- Bootstrap & FontAwesome & Entypo CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css');?>">
    <!--[if IE 7]><link type="text/css" rel="stylesheet" href="css/font-awesome-ie7.min.css"><![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-entypo.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fonts.css');?>">
    <!-- Plugin CSS -->
    <link href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.custom.min.css');?>" rel="stylesheet" type="text/css">    
    <link href="<?php echo base_url('assets/plugins/prettyPhoto-plugin/css/prettyPhoto.css');?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/plugins/isotope/css/isotope.css');?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/plugins/pnotify/css/jquery.pnotify.css');?>" media="screen" rel="stylesheet" type="text/css">    
    <link href="<?php echo base_url('assets/plugins/google-code-prettify/prettify.css')?>" rel="stylesheet" type="text/css"> 
    <link href="<?php echo base_url('assets/plugins/mCustomScrollbar/jquery.mCustomScrollbar.css');?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/plugins/tagsInput/jquery.tagsinput.css');?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/plugins/bootstrap-switch/bootstrap-switch.css');?>" rel="stylesheet" type="text/css">    
    <link href="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker-bs3.css');?>" rel="stylesheet" type="text/css">    
    <link href="<?php echo base_url('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css');?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/plugins/colorpicker/css/colorpicker.css');?>" rel="stylesheet" type="text/css">
   <!-- Theme CSS -->
    <link href="<?php echo base_url('assets/css/theme.min.css')?>" rel="stylesheet" type="text/css">
    <!--[if IE]> <link href="<?php echo base_url('css/ie.css')?>" rel="stylesheet" > <![endif]-->
    <link href="<?php echo base_url('assets/css/chrome.css')?>" rel="stylesheet" type="text/chrome"> <!-- chrome only css -->    
    <!-- Responsive CSS -->
    <link href="<?php echo base_url('assets/css/theme-responsive.min.css')?>" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo base_url('assets/js/modernizr.js')?>"></script> 
    <script type="text/javascript" src="<?php echo base_url('assets/js/mobile-detect.min.js')?>"></script> 
    <script type="text/javascript" src="<?php echo base_url('assets/js/mobile-detect-modernizr.js')?>"></script>
    <?php if(isset($css_array) && count($css_array) > 0 ){ foreach($css_array as $css){ ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url($css);?>">
    <?php } } ?>
    
    <script type="text/javascript">
        var base_url = '<?php echo base_url();?>';
         var hide_date = '';//Hide previous date in daterangepicker
         
    </script>
    
</head>
    <body id="pages" class="full-layout no-nav-left no-nav-right  nav-top-fixed background-login     responsive remove-navbar login-layout   clearfix" data-active="pages "  data-smooth-scrolling="1">     
        <div class="">
            <!-- Header Start -->
            <!-- Header Ends --> 
            <div class="content">
                <?php $this->load->view($content);?>   
            </div>
                <!-- .container --> 
            <!-- .content -->
            <!-- Footer Start -->
           <!--  <footer class="footer-2"  id="footer">      
                <div class="vd_bottom ">
                    <div class="container">
                        <div class="row">
                            <div class=" col-xs-12">
                                <div class="copyright text-center">
                                    Copyright &copy;2016 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer> -->
            <!-- Footer END -->
        </div>
        <!--
        <a class="back-top" href="#" id="back-top"> <i class="icon-chevron-up icon-white"> </i> </a> -->
        <!-- Javascript =============================================== --> 
        <!-- Placed at the end of the document so the pages load faster --> 
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js');?>"></script> 
        <!--[if lt IE 9]>
          <script type="text/javascript" src="js/excanvas.js"></script>      
        <![endif]-->
        <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script> 
        <script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.custom.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/caroufredsel.js');?>"></script> 
        <script type="text/javascript" src="<?php echo base_url('assets/js/plugins.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/plugins/breakpoints/breakpoints.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/plugins/prettyPhoto-plugin/js/jquery.prettyPhoto.js');?>"></script> 
        <script type="text/javascript" src="<?php echo base_url('assets/plugins/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/plugins/tagsInput/jquery.tagsinput.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/plugins/bootstrap-switch/bootstrap-switch.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/plugins/blockUI/jquery.blockUI.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/plugins/pnotify/js/jquery.pnotify.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/theme.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/custom.js');?>"></script>
        <!-- Specific Page Scripts Put Here -->
        <script type="text/javascript">
            var base_url = '<?php echo base_url();?>';
            $(document).ready(function () {
                var msg = '<?= $this->session->userdata("msg"); ?>';
                var type = '<?= $this->session->userdata("type"); ?>';
                if (msg != "" && type != "") {
                    if (type == "success") {
                        var icon = "fa fa-check-circle vd_green";
                    } else {
                        var icon = "fa fa-exclamation-circle vd_red";
                    }
                    notification("topright", type, icon, type, msg);
<?= $this->session->unset_userdata('msg'); ?>;
<?= $this->session->unset_userdata('type'); ?>;
                }
                "use strict";
                var form_register_2 = $('#login-form');
                var error_register_2 = $('.alert-danger', form_register_2);
                var success_register_2 = $('.alert-success', form_register_2);
                form_register_2.validate({
                    errorElement: 'div', //default input error message container
                    errorClass: 'vd_red', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "",
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 6
                        },
                    },
                    errorPlacement: function (error, element) {
                        if (element.parent().hasClass("vd_checkbox") || element.parent().hasClass("vd_radio")) {
                            element.parent().append(error);
                        } else if (element.parent().hasClass("vd_input-wrapper")) {
                            error.insertAfter(element.parent());
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    invalidHandler: function (event, validator) { //display error alert on form submit              
                        success_register_2.hide();
                        error_register_2.show();
                    },
                    highlight: function (element) { // hightlight error inputs
                        $(element).addClass('vd_bd-red');
                        $(element).parent().siblings('.help-inline').removeClass('help-inline hidden');
                        if ($(element).parent().hasClass("vd_checkbox") || $(element).parent().hasClass("vd_radio")) {
                            $(element).siblings('.help-inline').removeClass('help-inline hidden');
                        }
                    },
                    unhighlight: function (element) { // revert the change dony by hightlight
                        $(element)
                                .closest('.control-group').removeClass('error'); // set error class to the control group
                    },
                    success: function (label, element) {
                        label
                                .addClass('valid').addClass('help-inline hidden') // mark the current input as valid and display OK icon
                                .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
                        $(element).removeClass('vd_bd-red');
                    },
                    submitHandler: function (form) {
                        $(form).find('#login-submit').prepend('<i class="fa fa-spinner fa-spin mgr-10"></i>')/*.addClass('disabled').attr('disabled')*/;
                        success_register_2.show();
                        error_register_2.hide();
                        setTimeout(function () {
                            window.location.href = "index.html"
                        }, 2000);
                    }
                });
            });
        </script>
        <?php if(isset($js_array) && count($js_array) > 0 ){ foreach($js_array as $js){ ?>
        <script src="<?php echo base_url($js);?>"></script>
        <?php }} ?>
    
    </body>
</html>