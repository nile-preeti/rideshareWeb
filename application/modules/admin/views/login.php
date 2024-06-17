<?php
    
//echo(date("Y-m-d h:i:s"));
    
// phpinfo();
 ?> 
<div class="vd-auth-page-section">
    <div class="vd_login-page">
        <div class="vd_login-heading">
            <div class="logo">
                <h2 class="mgbt-xs-5"><b><img src="<?php echo base_url('assets/images/logo.png')?>" alt="Ride Share Rate" height="100"></b></h2><br/>
            </div>
            <h4 class="text-center font-semibold vd_grey">LOGIN TO YOUR ACCOUNT</h4>
        </div>
        <div class="panel widget">
            <div class="panel-body">
                <!--<div class="login-icon entypo-icon"> <i class="icon-key"></i> </div>-->
                <form class="form-horizontal" action="<?php echo  base_url('admin/login');?>" method="post" role="form">
                    <?php $this->load->view('common/error');?>                  
                    <div class="form-group  mgbt-xs-20">
                        
                        <div class="col-md-12">
                            <div class="">
                            <div class="vd_input-wrapper" id="email-input-wrapper"> 
                                <span class="menu-icon"> <i class="fa fa-envelope"></i> </span>
                                <input type="email" placeholder="Email" name="email" required="">
								<?php echo form_error('email'); ?>
                            </div>
                            <div class="vd_input-wrapper" id="password-input-wrapper" > <span class="menu-icon"> <i class="fa fa-lock"></i> </span>
                                <input type="password" placeholder="Password" name="password"  required>
                                <?php echo form_error('password'); ?>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div id="vd_login-error" class="alert alert-danger hidden"><i class="fa fa-exclamation-circle fa-fw"></i> Please fill the necessary field </div>
                    <p><a href="javascript:void(0);" class="" id="forgot-password">Forgot Password</a></p>
                    <div class="form-group">
                        <div class="col-md-12 text-center mgbt-xs-5">
                            <button class="ride-btnLogin" type="submit" >Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Panel Widget -->
    </div>
</div>
<div class="modal fade" id="forgot-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog forgot-form" role="document" >
  </div>
</div>                 