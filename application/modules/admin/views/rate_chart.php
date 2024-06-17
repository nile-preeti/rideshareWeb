<!-- Daywise Percentage rate chart -->
<style type="text/css">


    .panel .panel-body {padding: 4px 0px 25px; } .form-control{padding:6px 8px; }


   .vd_content-section{background: #f7f6f6;}


   .vd_head-section .vd_panel-menu .menu:first-child{border-left: none;}


   .vd_head-section .vd_panel-menu .menu {


    color: #3c485b;


    border: none;


    background: #dde1e8; border-radius: 4px;}


    .vd_panel-menu{margin-right: 0px;}


    .vd_bg-grey{background-color: #3c485c !important;}


    .light-widget .panel-heading{margin-top: 12px;}


    .vd_panel-menu{position: absolute; top: 7px;}


    .form-control{font-size: 12px; height: 31px; padding: 5px 8px; height: 29px;}


    .btn {padding: 4px 15px;}


    .table-dashboard table tr td{font-size: 12px;}


    input[type="file"], input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input, select, textarea {width: 100%; border: 1px solid #D5D5D5; padding: 3px 6px 3px; font-size: 12px;}





    .form-horizontal .control-label, .form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline, .form-horizontal .control-value {padding-top: 16px;}


    .vd_bg-green {background-color: #81be19 !important; padding: 6px 30px; } 


    


    .label-H label{font-weight: 400; color: #494848; font-size: 12px;}








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


                <div class="panel widget light-widget">


                    <div class="panel-heading vd_bg-grey">


                        <h3 class="panel-title" style="color:#fff; font-size: 14px;"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Daywise Percentage Configurator</h3>


                    </div>


                    <div class="panel-body">


                        <div class="container panel widget">


                            <div  class="row panel-body table-responsive left">


                                <form class="form-horizontal"  action="<?= $this->config->base_url() ?>admin/rate_chart" method="post" role="form" id="register-form">


                                    <div class=" col-md-2 label-H">


                                        <label class="control-label">Monday(%)<span class="vd_red">*</span></label>


                                        <div id="first-name-input-wrapper"  class="controls">


                                            <input type="text" placeholder="Monday" value="<?php echo $res->monday ?>" name="monday" required >


                                        </div>


                                    </div>





                                    <div class=" col-md-2 label-H">


                                        <label class="control-label">Tuesday(%)<span class="vd_red">*</span></label>


                                        <div id="first-name-input-wrapper"  class="controls">


                                            <input type="text" placeholder="Tuesday" value="<?php echo $res->tuesday ?>" name="tuesday" required >


                                        </div>


                                    </div>


                                    <div class="col-md-2 label-H">


                                        <label class="control-label">Wednesday(%)<span class="vd_red">*</span></label>


                                        <div id="first-name-input-wrapper"  class="controls">


                                            <input type="text" placeholder="Wednesday" value="<?php echo $res->wednesday ?>" name="wednesday" required >


                                        </div>


                                    </div>


                                    <div class="col-md-2 label-H">


                                        <label class="control-label">Thursday(%)<span class="vd_red">*</span></label>


                                        <div id="first-name-input-wrapper"  class="controls">


                                            <input type="text" placeholder="Thursday" value="<?php echo $res->thursday ?>" name="thursday" required >


                                        </div>


                                    </div>


                                    <div class="col-md-1 label-H">


                                        <label class="control-label">Friday(%)<span class="vd_red">*</span></label>


                                        <div id="first-name-input-wrapper"  class="controls">


                                            <input type="text" placeholder="Friday" value="<?php echo $res->friday ?>" name="friday" id="friday" required >


                                        </div>


                                    </div>


                                    <div class="col-md-2 label-H">


                                        <label class="control-label">Saturday(%)<span class="vd_red">*</span></label>


                                        <div id="first-name-input-wrapper" class="controls">


                                            <input name="saturday" id="saturday" value="<?php echo $res->saturday ?>">                                                


                                        </div>


                                    </div>


                                    <div class="col-md-1 label-H">


                                        <label class="control-label">Sunday(%)<span class="vd_red">*</span></label>


                                        <div id="first-name-input-wrapper"  class="controls">


                                            <input type="text" placeholder="Sunday" value="<?php echo $res->sunday ?>" name="sunday" id="sunday" required >


                                        </div>


                                    </div>


                                    


                                    <div class="col-md-12" style="margin-top: 20px;">


                                        <button class="btn vd_bg-green vd_white" type="submit" id="submit-register">Submit</button>


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


