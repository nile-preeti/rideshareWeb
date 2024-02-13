<!-- Managing Daywise Percentage -->
<style type="text/css">
   

    .vd_panel-menu{margin-right: 0px;}

    .vd_bg-grey{background-color: #3c485c !important;}

    .light-widget .panel-heading{margin-top: 12px;}

    .vd_panel-menu{position: absolute; top: 7px;}

    .btn {padding: 4px 15px;}

    



/*    .form-horizontal .control-label, .form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline, .form-horizontal .control-value {padding-top: 16px;}

*/    .vd_bg-green {background-color: #FB8904 !important; padding: 6px 30px; } 

    





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

                <!-- <div class="panel widget oc-panel light-widget">

                   <div class="panel-heading">

                        <div class="row">

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Change API key </h3></div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                                <form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">

                                    <div  class="row">

                                    <div class="col-md-3 label-H">

                                        <label class="control-label ">Paypal Id<span class="vd_red">*</span></label>

                                        <div id="first-name-input-wrapper"  class="controls">

                                            <input type="text" placeholder="paypal ID" value="<?php echo $res->paypal_id ?>" class="width-120 required"  name="paypal_id" id="paypal_id" required >

                                        </div>

                                    </div>

                                    <div class="col-md-3 label-H">

                                        <label class="control-label ">Paypal Password<span class="vd_red">*</span></label>

                                        <div id="first-name-input-wrapper"  class="controls ">

                                            <input type="text" placeholder="Paypal Password" value="<?php echo $res->paypal_password ?>" class="width-120 required"  name="paypal_password" id="paypal_password" required >

                                        </div>

                                    </div>

                                    <div class="col-md-3 label-H">

                                        <label class="control-label">Paypal Signature<span class="vd_red">*</span></label>

                                        <div id="first-name-input-wrapper"  class="controls">

                                            <input type="text" placeholder="Paypal Signature" value="<?php echo $res->signature ?>" class="width-120 required"  name="signature" id="signature" required >

                                        </div>

                                    </div>

                                    <div class="col-md-3 label-H">

                                        <label class="control-label">Paypal Account<span class="vd_red">*</span></label>

                                        <div id="first-name-input-wrapper"  class="controls">

                                            <select name="paypal_account" class="form-control" id="paypal_account" >

                                                <option <?php echo $res->paypal_account == 'sandbox' ? 'selected' : '' ?> value="sandbox">Sandbox</option>

                                                <option <?php echo $res->paypal_account == 'live' ? 'selected' : '' ?> value="live">Live</option>

                                            </select>

                                        </div>

                                    </div>

                                   

                                    <div class="col-md-12" style="margin-top: 20px;">

                                        <button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div> -->

            <form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/rate_chart" method="post" role="form" id="register-form">

                <div class="panel widget oc-panel light-widget">

                   <div class="panel-heading">

                        <div class="row">

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Daywise Percentage Configurator</h3></div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                           <!--  <form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/rate_chart" method="post" role="form" id="register-form"> -->

                                    <div  class="row">

                                        <div class=" col-md-2 label-H">

                                            <label class="control-label">Monday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Monday" class="form-control" value="<?php echo $rate->monday ?>" name="monday" required >

                                            </div>

                                        </div>



                                        <div class=" col-md-2 label-H">

                                            <label class="control-label">Tuesday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Tuesday" class="form-control" value="<?php echo $rate->tuesday ?>" name="tuesday" required >

                                            </div>

                                        </div>

                                        <div class="col-md-2 label-H">

                                            <label class="control-label">Wednesday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Wednesday"class="form-control"  value="<?php echo $rate->wednesday ?>" name="wednesday" required >

                                            </div>

                                        </div>

                                        <div class="col-md-2 label-H">

                                            <label class="control-label">Thursday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Thursday" class="form-control" value="<?php echo $rate->thursday ?>" name="thursday" required >

                                            </div>

                                        </div>

                                        <div class="col-md-2 label-H">

                                            <label class="control-label">Friday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Friday"class="form-control"  value="<?php echo $rate->friday ?>" name="friday" id="friday" required >

                                            </div>

                                        </div>

                                        <div class="col-md-2 label-H">

                                            <label class="control-label">Saturday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper" class="controls">

                                                <input type="text" name="saturday" id="saturday" class="form-control" value="<?php echo $rate->saturday ?>">                                                

                                            </div>

                                        </div>

                                        <div class="col-md-2 label-H">

                                            <label class="control-label">Sunday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Sunday"class="form-control"  value="<?php echo $rate->sunday ?>" name="sunday" id="sunday" required >

                                            </div>

                                        </div>


                                        <div class="col-md-2" style="margin-top: 27px;">

                                            <button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>

                                        </div>

                                    </div>

                                <!-- </form> -->

                            </div>

                        </div>

                    </div>

                </div>

                <div class="panel widget oc-panel light-widget">

                   <div class="panel-heading">

                        <div class="row">

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Surge Rate</h3></div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                               <form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/rate_chart" method="post" role="form" id="register-form"> 

                                    <div  class="row">

                                        <div class="col-md-2 label-H">

                                            <label class="control-label">Total Surge Rate<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper" class="controls">

                                                <input type="text" name="total_highest_ride" id="total_highest_ride" class="form-control" value="<?php echo $rate->total_highest_ride ?>">                                                

                                            </div>

                                        </div>

                                        <div class="col-md-2 label-H">

                                            <label class="control-label">Highest Price(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Sunday"class="form-control"  value="<?php echo $rate->highest_ride_price ?>" name="highest_ride_price" id="highest_ride_price" required >

                                            </div>

                                        </div>

                                        

                                        <div class="col-md-2" style="margin-top: 27px;">

                                            <button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>

                                        </div>

                                    </div>

                                <!-- </form> -->

                            </div>

                        </div>

                    </div>

                </div>

            </form>

                <!-- <div class="panel widget oc-panel light-widget">

                   <div class="panel-heading">

                        <div class="row">

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Manage Highest Price</h3></div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                                <form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/rate_chart" method="post" role="form" id="register-form">

                                    <div  class="row">

                                        <div class=" col-md-2 label-H">

                                            <label class="control-label">Monday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Monday" class="form-control" value="<?php echo $rate->monday ?>" name="monday" required >

                                            </div>

                                        </div>



                                        <div class=" col-md-2 label-H">

                                            <label class="control-label">Tuesday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Tuesday" class="form-control" value="<?php echo $rate->tuesday ?>" name="tuesday" required >

                                            </div>

                                        </div>

                                        <div class="col-md-2 label-H">

                                            <label class="control-label">Wednesday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Wednesday"class="form-control"  value="<?php echo $rate->wednesday ?>" name="wednesday" required >

                                            </div>

                                        </div>

                                        <div class="col-md-2 label-H">

                                            <label class="control-label">Thursday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Thursday" class="form-control" value="<?php echo $rate->thursday ?>" name="thursday" required >

                                            </div>

                                        </div>

                                        <div class="col-md-2 label-H">

                                            <label class="control-label">Friday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Friday"class="form-control"  value="<?php echo $rate->friday ?>" name="friday" id="friday" required >

                                            </div>

                                        </div>

                                        <div class="col-md-2 label-H">

                                            <label class="control-label">Saturday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper" class="controls">

                                                <input type="text" name="saturday" id="saturday" class="form-control" value="<?php echo $rate->saturday ?>">                                                

                                            </div>

                                        </div>

                                        <div class="col-md-2 label-H">

                                            <label class="control-label">Sunday(%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="text" placeholder="Sunday"class="form-control"  value="<?php echo $rate->sunday ?>" name="sunday" id="sunday" required >

                                            </div>

                                        </div>

                                        

                                        <div class="col-md-2" style="margin-top: 27px;">

                                            <button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div> -->

                
                <div class="panel widget oc-panel light-widget">

                   <div class="panel-heading">

                        <div class="row">

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Driver Processing Fee</h3></div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                                <form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">

                                    <div  class="row">

                                        <div class="col-md-2">

                                            <label class="control-label">Driver Processing Fee (%)<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="number"  value="<?php echo $res->admin_fee ?>" class="width-120 required"  name="admin_fee" step="any"  required  >

                                            </div>

                                        </div>

                                        

                                        <div class="col-md-2" style="margin-top:27px">

                                            <button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>



                <div class="panel widget oc-panel light-widget">

                   <div class="panel-heading">

                        <div class="row">

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Driver Email and Riders Email Settings</h3></div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                                <form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/mail_setting" method="post" role="form" id="register-form">

                                <div  class="row">

                                    <div class="col-md-4">

                                        <label class="control-label">Host<span class="vd_red">*</span></label>

                                        <div id="first-name-input-wrapper"  class="controls">

                                            <input type="text" placeholder="SMTP host name" value="<?php echo $set[2]->value ?>" class="width-120 required"  name="SMTP_HOST" id="host" required >

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <label class="control-label">Port<span class="vd_red">*</span></label>

                                        <div id="first-name-input-wrapper"  class="controls">

                                            <input type="text" placeholder="SMTP port number" value="<?php echo $set[3]->value ?>" class="width-120 required"  name="SMTP_PORT" id="smtp_port" required >

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <label class="control-label">smtp username<span class="vd_red">*</span></label>

                                        <div id="first-name-input-wrapper"  class="controls">

                                            <input type="text" placeholder="SMTP user" value="<?php echo $set[4]->value ?>" class="width-120 required"  name="SMTP_USER" id="smtp_user" required >

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <label class="control-label">smtp password<span class="vd_red">*</span></label>

                                        <div id="first-name-input-wrapper"  class="controls">

                                            <input type="text" placeholder="SMTP pass" value="<?php echo $set[5]->value ?>" class="width-120 required"  name="SMTP_PASS" id="smtp_pass" required >

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <label class="control-label">From<span class="vd_red">*</span></label>

                                        <div id="first-name-input-wrapper"  class="controls">

                                            <input type="text" placeholder="Format: admin@icanstudioz.com" value="<?php echo $set[6]->value ?>" class="width-120 required"  name="FROM" id="smtp_from" required >

                                            <br/>

                                            <label class="col-md-12" style="padding-left: 0px;">example:- demo@icanstudioz.com</label>

                                        </div>



                                    </div>

                                    <div class="col-md-4" style="margin-top:27px">

                                        <button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>

                                    </div>

                                </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="panel widget oc-panel light-widget">

                   <div class="panel-heading">

                        <div class="row">

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Change Password</h3></div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                                <form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/settings" method="post" role="form" id="register-form">

                                    <div  class="row">

                                        <div class="col-md-6">

                                            <label class="control-label">Old Password<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="password" placeholder="Old Password" value="" class="width-120 required"  name="old_password" id="password" required >

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <label class="control-label">New Password<span class="vd_red">*</span></label>

                                            <div id="first-name-input-wrapper"  class="controls">

                                                <input type="password" placeholder="New Password" value="" class="width-120 required"  name="new_password" id="new_password" required >

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

