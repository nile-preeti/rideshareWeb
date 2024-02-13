<!-- Managing Daywise Percentage -->
<style type="text/css">

    

    .vd_panel-menu{margin-right: 0px;}

    .vd_bg-grey{background-color: #3c485c !important;}

    .light-widget .panel-heading{margin-top: 12px;}

    .vd_panel-menu{position: absolute; top: 7px;}

    .btn {padding: 4px 15px;}

    



/*    .form-horizontal .control-label, .form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline, .form-horizontal .control-value {padding-top: 16px;}

*/    .vd_bg-green {background-color: #81be19 !important; padding: 6px 30px; } 

    





</style>


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
                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Rider Profile Details</h3></div>
                            <div class="col-md-6 float-right"><a href="<?php echo base_url('rider/update-profile/');?><?php echo $res->user_id; ?>"<i class="fa fa-edit"></i></a></div>   

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">                         

                                    <div  class="row">   
                                        
                                        <div class="oc-modal-form">
                                            <form enctype="multipart/form-data" class="form-horizontal" action="https://staging.getduma.com/admin/drivers/update" method="post" role="form" id="register-form">
                                                <input type="hidden" value="" name="user_id">
                                                <div class="row">
                                                    <div class="col-md-6 label-H">
                                                        <label>Name</label>
                                                        <div id="first-name-input-wrapper" class="controls font-c">
                                                        <?php echo $res->name; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 label-H">
                                                        <label>Mobile No.</label>
                                                        <div id="website-input-wrapper" class="controls font-c">
                                                        <?php echo $res->mobile; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 label-H">
                                                        <label>Email</label>
                                                        <div id="email-input-wrapper" class="controls font-c">
                                                        <?php echo $res->email; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mt-20 label-H">

                                                        <label>Status</label>

                                                        <div id="email-input-wrapper" class="controls font-c">

                                                            <?php if($res->status==1){
                                                                    echo"Active";                      
                                                                }else if($res->status==2){
                                                                    echo "Need to email verification";
                                                                }else if($res->status==3){
                                                                    echo"Need to admin approval";
                                                                }else{
                                                                    echo "Inactive by admin";
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                

                                                    <div class="col-md-6 mt-20 label-H">

                                                        <label>Background approve status</label>
                                                        <div id="email-input-wrapper" class="controls font-c">
                                                           <?php  if($res->verification_id_approval_atatus==1){
                                                                echo"approved";
                                                                }else{
                                                                echo "Not approved";
                                                                }   
                                                            ?>             
                                                        
                                                        </div>

                                                    </div>

                                                    <div class="col-md-6 mt-20 label-H">
                                                        <label>ID Proof </label>
                                                        <div id="email-input-wrapper" class="controls font-c">

                                                            <?php if($res->identification_document_id==1){
                                                                    echo"Passport";                      
                                                                }else if($res->identification_document_id==2){
                                                                    echo "Driving Licence";
                                                                }else if($res->identification_document_id==3){
                                                                    echo"Green Card";
                                                                }else{
                                                                    echo"No Id Proof";
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>



                                                    <div class="col-md-6 mt-50 label-H">
                                                        <label>Profile Image</label>
                                                        <div id="email-input-wrapper" class="controls ">
                                                            <div class="oc-modal-media">
                                                                <?php if(!empty($res->avatar)){ ?>
                                                                    <img id="myno_img" src="<?php echo site_url('/uploads/profile_image'); ?>/<?php echo $res->user_id; ?>/<?php echo $res->avatar; ?>" alt="your image">
                                                                <?php }else{ ?>    
                                                                    <img id="myno_img" src="<?php echo site_url('assets/images/avatar/no-image.jpg') ?>" alt="your image">
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>    
                                            </form>

                                        </div>
                                 

                                    </div>

                                <!-- </form> -->

                            </div>

                        </div>

                    </div>

                </div>


             </div>

        </div>

    </div>

</div>

