<!-- Managing Daywise Percentage -->
<style type="text/css">
   

    .vd_panel-menu{margin-right: 0px;}

    .vd_bg-grey{background-color: #3c485c !important;}

    .light-widget .panel-heading{margin-top: 12px;}

    .vd_panel-menu{position: absolute; top: 7px;}

    .btn {padding: 4px 15px;}

    



/*    .form-horizontal .control-label, .form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline, .form-horizontal .control-value {padding-top: 16px;}

*/    .vd_bg-green {background-color: #FB8904 !important; padding: 6px 30px; } 

    
.form-control{
    padding: 8px;
    height: auto;
    box-shadow: none;
    border: 1px solid #F0D8B6 !important;
    background: rgba(38, 38, 38, 0.95) !important;
    display: inline-block;
    width: 100%;
    color: #fff !important;
} 
.vd_bg-green {
    background-color: #FB8904 !important;
    padding: 8px 30px;
}




</style>

<script>

    $(document).ready(function () {

        var msg = '<?php echo $this->session->userdata("msg"); ?>';

        var type = '<?php echo $this->session->userdata("type"); ?>';

        if (msg != "" && type != "") {

            if (type == "success") {

                var icon = "fa fa-check-circle vd_green";

            } else {

                var icon = "fa fa-exclamation-circle vd_red";

            }

            notification("topright", type, icon, type, msg);

<?php echo $this->session->unset_userdata("msg"); ?>

<?php echo $this->session->unset_userdata("type"); ?>

        }

    });

</script>

<div class="vd_content-wrapper">

    <div class="vd_container">

        <div class="vd_content clearfix">

            <div class="vd_head-section clearfix">

                <div class="vd_panel-header">

                    <div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">

                        <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu"> <i class="fa fa-arrows-h"></i> </div>

                        <div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu"> <i class="fa fa-arrows-v"></i> </div>

                        <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu"> <i class="glyphicon glyphicon-fullscreen"></i> </div>

                    </div>

                </div>

            </div>

            <div class="vd_content-section clearfix">

                <div class="panel widget oc-panel light-widget">
                   <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Ride Distance Master</h3></div>
                        </div>
                    </div>

                    

                    <div class="panel-body">
                        <div class="panel widget">
                            <div  class="search-filter">                             
                                <div  class="row">
									<form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">
										<div class="col-md-4">
											<label class="control-label">Driver distance  Accept Ride<span class="vd_red">*</span></label>
											<div id="first-name-input-wrapper"  class="controls">
												<input type="number"  placeholder="Paid Waiting Time At Pickup" value="<?php echo $res->driver_distance ?>" class="form-control width-120 required"  name="driver_distance" id="driver_distance" onkeydown="if(event.key==='.'){event.preventDefault();}" onpaste="let pasteData = event.clipboardData.getData('text'); if(pasteData){pasteData.replace(/[^0-9]*/g,'');} min="0" required />
												
											</div>
										</div>                                    
										
										<div class="col-md-2" style="margin-top:27px">
											<button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>
										</div>
									</form>
									
									<form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">
										<div class="col-md-4">
											<label class="control-label">Driver distance  from Pickup point<span class="vd_red">*</span></label>
											<div id="first-name-input-wrapper"  class="controls">
												<input type="number"  placeholder="Driver distance  from Pickup point" value="<?php echo $res->accept_ride_distance ?>" class="form-control width-120 required"  name="accept_ride_distance" id="accept_ride_distance" onkeydown="if(event.key==='.'){event.preventDefault();}" onpaste="let pasteData = event.clipboardData.getData('text'); if(pasteData){pasteData.replace(/[^0-9]*/g,'');}" min="0" required />
												
											</div>
										</div>                                    
										
										<div class="col-md-2" style="margin-top:27px">
											<button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>
										</div>
									</form>
									
									<form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">
										<div class="col-md-4">
											<label class="control-label">Distance from accept point<span class="vd_red">*</span></label>
											<div id="first-name-input-wrapper"  class="controls">
												<input type="number"  placeholder="Distance from accept point" value="<?php echo $res->accept_point_distance ?>" class="form-control width-120 required"  name="accept_point_distance" id="accept_point_distance"  min="0" required />
												
											</div>
										</div>                                    
										
										<div class="col-md-2" style="margin-top:27px">
											<button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>
										</div>
									</form>


                                    <form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">
										<div class="col-md-4">
											<label class="control-label">Distance from drop point<span class="vd_red">*</span></label>
											<div id="first-name-input-wrapper"  class="controls">
												<input type="number"  placeholder="Distance from accept point" value="<?php echo $res->drop_point_distance ?>" class="form-control width-120 required"  name="drop_point_distance" id="drop_point_distance"  min="0" required />
												
											</div>
										</div>                                    
										
										<div class="col-md-2" style="margin-top:27px">
											<button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>
										</div>
									</form>

                                </div>

                               

                            </div>

                        </div>

                    </div>

                </div>





			
				<div class="panel widget oc-panel light-widget">
                   <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Free Waiting time</h3></div>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="panel widget">
                            <div  class="search-filter">                               

                                <div  class="row">
									<form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">
										<div class="col-md-4">
											<label class="control-label">Free waiting time in minute for Pickup<span class="vd_red">*</span></label>
											<div id="first-name-input-wrapper"  class="controls">
												<input type="number"  placeholder="Pickup Waiting Time" value="<?php echo $res->free_waiting_time_pickup ?>" class="form-control width-120 required"  name="free_waiting_time_pickup" id="free_waiting_time_pickup" onkeydown="if(event.key==='.'){event.preventDefault();}" onpaste="let pasteData = event.clipboardData.getData('text'); if(pasteData){pasteData.replace(/[^0-9]*/g,'');} min="0" required />
												
											</div>
										</div>                                    
										
										<div class="col-md-2" style="margin-top:27px">
											<button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>
										</div>
									</form>
									
									<form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">
										<div class="col-md-4">
											<label class="control-label">Free waiting time in minute for stop<span class="vd_red">*</span></label>
											<div id="first-name-input-wrapper"  class="controls">
												<input type="number"  placeholder="Stop Waiting Time" value="<?php echo $res->free_waiting_time_stop ?>" class="form-control width-120 required"  name="free_waiting_time_stop" id="free_waiting_time_stop" onkeydown="if(event.key==='.'){event.preventDefault();}" onpaste="let pasteData = event.clipboardData.getData('text'); if(pasteData){pasteData.replace(/[^0-9]*/g,'');}" min="0" required />
												
											</div>
										</div>                                    
										
										<div class="col-md-2" style="margin-top:27px">
											<button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>
										</div>
									</form>
									
									<form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">
										<div class="col-md-4">
											<label class="control-label">Free waiting time in minute at Drop<span class="vd_red">*</span></label>
											<div id="first-name-input-wrapper"  class="controls">
												<input type="number"  placeholder="Drop Waiting Time" value="<?php echo $res->free_waiting_time_drop ?>" class="form-control width-120 required"  name="free_waiting_time_drop" id="free_waiting_time_drop" onkeydown="if(event.key==='.'){event.preventDefault();}" onpaste="let pasteData = event.clipboardData.getData('text'); if(pasteData){pasteData.replace(/[^0-9]*/g,'');}" min="0" required />
												
											</div>
										</div>                                    
										
										<div class="col-md-2" style="margin-top:27px">
											<button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>
										</div>
									</form>

                                </div>

                               

                            </div>

                        </div>

                    </div>

                </div>
				
				
				<div class="panel widget oc-panel light-widget">
                   <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Paid Waiting time</h3></div>
                        </div>
                    </div>

                    

                    <div class="panel-body">
                        <div class="panel widget">
                            <div  class="search-filter">                             
                                <div  class="row">
									<form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">
										<div class="col-md-4">
											<label class="control-label">Paid waiting time in minute at pickup<span class="vd_red">*</span></label>
											<div id="first-name-input-wrapper"  class="controls">
												<input type="number"  placeholder="Paid Waiting Time At Pickup" value="<?php echo $res->paid_waiting_time_pickup ?>" class="form-control width-120 required"  name="paid_waiting_time_pickup" id="paid_waiting_time_pickup" onkeydown="if(event.key==='.'){event.preventDefault();}" onpaste="let pasteData = event.clipboardData.getData('text'); if(pasteData){pasteData.replace(/[^0-9]*/g,'');} min="0" required />
												
											</div>
										</div>                                    
										
										<div class="col-md-2" style="margin-top:27px">
											<button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>
										</div>
									</form>
									
									<form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">
										<div class="col-md-4">
											<label class="control-label">Paid waiting time in minute stop<span class="vd_red">*</span></label>
											<div id="first-name-input-wrapper"  class="controls">
												<input type="number"  placeholder="Paid Waiting Time For Stop" value="<?php echo $res->paid_waiting_time_stop ?>" class="form-control width-120 required"  name="paid_waiting_time_stop" id="paid_waiting_time_stop" onkeydown="if(event.key==='.'){event.preventDefault();}" onpaste="let pasteData = event.clipboardData.getData('text'); if(pasteData){pasteData.replace(/[^0-9]*/g,'');}" min="0" required />
												
											</div>
										</div>                                    
										
										<div class="col-md-2" style="margin-top:27px">
											<button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>
										</div>
									</form>
									
									<form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">
										<div class="col-md-4">
											<label class="control-label">Paid waiting time in minute Drop<span class="vd_red">*</span></label>
											<div id="first-name-input-wrapper"  class="controls">
												<input type="number"  placeholder="Paid Waiting Time On Drop" value="<?php echo $res->paid_waiting_time_drop ?>" class="form-control width-120 required"  name="paid_waiting_time_drop" id="paid_waiting_time_drop" onkeydown="if(event.key==='.'){event.preventDefault();}" onpaste="let pasteData = event.clipboardData.getData('text'); if(pasteData){pasteData.replace(/[^0-9]*/g,'');}" min="0" required />
												
											</div>
										</div>                                    
										
										<div class="col-md-2" style="margin-top:27px">
											<button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>
										</div>
									</form>

                                </div>

                               

                            </div>

                        </div>

                    </div>

                </div>


                <div class="panel widget oc-panel light-widget">

                   <div class="panel-heading">

                        <div class="row">

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Change password</h3></div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                                <form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">

                                    <div  class="row">

                                        <div class="col-md-6">

                                            <label class="control-label">Old password<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="password" placeholder="Old Password" value="" class="width-120 required"  name="old_password" id="password" required pattern=".*\S+.*" >

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <label class="control-label">New password<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="password" placeholder="New Password" value="" class="width-120 required"  name="new_password" id="new_password" required pattern=".*\S+.*" >

                                            </div>

                                        </div>

                                        <div class="col-md-12" style="margin-top:20px">

                                            <button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

                

            </div>

        </div>

    </div>

</div>
