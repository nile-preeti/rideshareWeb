<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $title ?></title>
  <meta content="<?php echo $description ;?>" name="descriptison">
  <meta content="<?php echo $keyword ;?>" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url('assets/modules/web/img/favicon.png');?>" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url('assets/modules/web/vendor/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/modules/web/vendor/icofont/icofont.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/modules/web/vendor/owl.carousel/assets/owl.carousel.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/modules/web/vendor/aos/aos.css');?>" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="<?php echo base_url('assets/modules/web/css/style.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/modules/web/css/fontello.css');?>" rel="stylesheet">
  <?php if(isset($css_array) && count($css_array) > 0 ){ 
        foreach($css_array as $css){ ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url($css);?>">
	<?php } } ?>
  <link href="<?php echo base_url('assets/modules/web/css/responsive.css');?>" rel="stylesheet">
</head>

<body>
<script>var base_url = "<?php echo base_url();?>";</script>
  <!-- ======= Header ======= -->
  

  <!-- ======= Hero Section ======= -->
  <?php $this->load->view($content);?>

  <!-- ======= Footer ======= -->
 
  <!-- End Footer -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
  <div id="preloader"></div>


  <!-- Vendor JS Files -->
  <script src="<?php echo base_url('assets/modules/web/vendor/jquery/jquery.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/web/vendor/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/web/vendor/jquery.easing/jquery.easing.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/web/vendor/counterup/counterup.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/web/vendor/owl.carousel/owl.carousel.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/web/vendor/aos/aos.js')?>"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo base_url('assets/modules/web/js/main.js')?>"></script>
  <?php if(isset($js_array) && count($js_array) > 0 ){ 
        foreach($js_array as $js){ ?>
		<script src="<?php echo base_url($js);?>"></script
	<?php }} ?>
</body>

</html>