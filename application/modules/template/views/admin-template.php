<!DOCTYPE html>
<html>
        <head>

    <meta charset="utf-8" />

	<title><?php echo $title?? 'RideShareRates';?></title>

     <meta name="keywords" content="" />

        <meta name="description" content="">

        <!-- Set the viewport width to device width for mobile -->

        <meta name="viewport" content="width=device-width, initial-scale=1.0">    





        <!-- Fav and touch icons -->

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->config->base_url() ?>img/ico/apple-touch-icon-144-precomposed.png">

        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->config->base_url() ?>img/ico/apple-touch-icon-114-precomposed.png">

        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->config->base_url() ?>img/ico/apple-touch-icon-72-precomposed.png">

        <link rel="apple-touch-icon-precomposed" href="<?php echo $this->config->base_url() ?>img/ico/apple-touch-icon-57-precomposed.png">

        <link rel="shortcut icon" href="<?php echo $this->config->base_url() ?>assets/images/ico/favicon.png">





        <!-- CSS -->



        <!-- Bootstrap & FontAwesome & Entypo CSS -->

        <link href="<?php echo $this->config->base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

        <link href="<?php echo $this->config->base_url() ?>assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="<?php echo $this->config->base_url() ?>assets/css/payout.css" rel="stylesheet" type="text/css">

        <!--[if IE 7]><link type="text/css" rel="stylesheet" href="assets/css/font-awesome-ie7.min.css"><![endif]-->

        <link href="<?php echo $this->config->base_url() ?>assets/css/font-entypo.css" rel="stylesheet" type="text/css">    
		


        <!-- Fonts CSS -->

        <link href="<?php echo $this->config->base_url() ?>assets/css/fonts.css"  rel="stylesheet" type="text/css">



        <!-- Plugin CSS -->

        <link href="<?php echo $this->config->base_url() ?>assets/plugins/jquery-ui/jquery-ui.custom.min.css" rel="stylesheet" type="text/css">    

        <link href="<?php echo $this->config->base_url() ?>assets/plugins/prettyPhoto-plugin/css/prettyPhoto.css" rel="stylesheet" type="text/css">

        <link href="<?php echo $this->config->base_url() ?>assets/plugins/isotope/css/isotope.css" rel="stylesheet" type="text/css">

        <link href="<?php echo $this->config->base_url() ?>assets/plugins/pnotify/css/jquery.pnotify.css" media="screen" rel="stylesheet" type="text/css">    

        <link href="<?php echo $this->config->base_url() ?>assets/plugins/google-code-prettify/prettify.css" rel="stylesheet" type="text/css"> 



        <link href="<?php echo $this->config->base_url() ?>assets/plugins/mCustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">

        <link href="<?php echo $this->config->base_url() ?>assets/plugins/tagsInput/jquery.tagsinput.css" rel="stylesheet" type="text/css">

        <link href="<?php echo $this->config->base_url() ?>assets/plugins/bootstrap-switch/bootstrap-switch.css" rel="stylesheet" type="text/css">  
		
		
        <!-- <link href="<?php echo $this->config->base_url() ?>assets/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css">    

        <link href="<?php echo $this->config->base_url() ?>assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css">

        <link href="<?php echo $this->config->base_url() ?>assets/plugins/colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css">  --> 



        <!-- Theme CSS -->

        <link href="<?php echo $this->config->base_url() ?>assets/css/theme.min.css" rel="stylesheet" type="text/css">

        <!--[if IE]> <link href="assets/css/ie.css" rel="stylesheet" > <![endif]-->

        <link href="<?php echo $this->config->base_url() ?>assets/css/chrome.css" rel="stylesheet" type="text/chrome"> <!-- chrome only css -->    



         <link href="<?php echo $this->config->base_url() ?>assets/css/custom.css" rel="stylesheet" type="text/css">   
         <link href="<?php echo $this->config->base_url() ?>assets/css/responsive.css" rel="stylesheet" type="text/css">   



        <!-- Responsive CSS -->

        <link href="<?php echo $this->config->base_url() ?>assets/css/theme-responsive.min.css" rel="stylesheet" type="text/css"> 
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" integrity="sha512-fRVSQp1g2M/EqDBL+UFSams+aw2qk12Pl/REApotuUVK1qEXERk3nrCFChouag/PdDsPk387HJuetJ1HBx8qAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />




        





        <!-- Head SCRIPTS -->

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/js/modernizr.js"></script> 

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/js/mobile-detect.min.js"></script> 

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/js/mobile-detect-modernizr.js"></script> 

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/js/jquery.js"></script> 

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/plugins/dataTables/jquery.dataTables.min.js"></script>

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/js/dataTables.editor.min.js"></script>

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/plugins/dataTables/dataTables.bootstrap.js"></script>



        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/js/bootstrap.min.js"></script> 



        <script type="text/javascript" src='<?php echo $this->config->base_url() ?>assets/plugins/jquery-ui/jquery-ui.custom.min.js'></script>

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>



        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/js/caroufredsel.js"></script> 

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/js/plugins.js"></script>



        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/plugins/breakpoints/breakpoints.js"></script>

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/plugins/dataTables/jquery.dataTables.min.js"></script>

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/plugins/prettyPhoto-plugin/js/jquery.prettyPhoto.js"></script> 



        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/plugins/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/plugins/tagsInput/jquery.tagsinput.min.js"></script>

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/plugins/blockUI/jquery.blockUI.js"></script>

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/plugins/pnotify/js/jquery.pnotify.min.js"></script>

        <script type="text/javascript" src="https://www.niletechinnovations.com/projects/automonkey/assets/js/bootstrap-datepicker.min.js"></script>

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/js/theme.js"></script>

        <script type="text/javascript" src="<?php echo $this->config->base_url() ?>assets/js/custom.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		




	<?php if(isset($css_array) && count($css_array) > 0 ){ 
        foreach($css_array as $css){ ?>



	<link rel="stylesheet" type="text/css" href="<?php echo base_url($css);?>">



	<?php } } ?>

	



	<script type="text/javascript">



		var base_url = '<?php echo base_url();?>';

		 var hide_date = '';//Hide previous date in daterangepicker

		 

	</script>



	



</head>



	    <body id="dashboard" class="full-layout  nav-right-hide nav-right-start-hide  nav-top-fixed      responsive    clearfix" data-active="dashboard "  data-smooth-scrolling="1">     

        <div  class="vd_body">



        	<?php $this->load->view('header');?> 

            <?php $this->load->view('sidebar');?> 

            <?php $this->load->view($content);?> 

            <?php $this->load->view('footer');?> 

        	<?php if(isset($js_array) && count($js_array) > 0 ){ 
                foreach($js_array as $js){ ?>



		<script src="<?php echo base_url($js);?>"></script>



	<?php }} ?>

	

	</body>



</html>



