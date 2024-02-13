<!-- Update driver details -->

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
                            <div class="col-md-6"> 
                                <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Update Driver </h3>
                            </div>
                            <div class="col-md-6 text-right">
                                <a class="btn btn-gr" href="<?php echo base_url('admin/drivers');?>">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="panel widget">
                            <div  class="search-filter">
                                <?php $post = $post->row_array();?>
                                <?php $this->load->view('common/error');?>
                                <form action="<?php echo base_url('admin/update_driver/'.$post['user_id']);?>" method="post" enctype="multipart/form-data">
                                	<div class="update-driver-item">
	                                    <div class="row">
	                                        <div class="col-md-4 mb-10 label-H">
	                                            <input type="hidden" name="user_id" value="<?php echo $post['user_id'];?>">
	                                            <label for="name">Full Name<span class="text-danger">*</span></label>
	                                            <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo $post['name']; ?>">
	                                            <?php echo form_error('name'); ?>
	                                        </div>
	                                        <div class="col-md-4 mb-10 label-H">
	                                            <label for="email">Email<span class="text-danger">*</span></label>
	                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo $post['email']; ?>">
	                                            <?php echo form_error('email'); ?>
	                                        </div>
	                                        <div class="col-md-4 mb-10 label-H">
	                                            <label for="mobile">Mobile<span class="text-danger">*</span></label>
	                                            <input type="number" class="form-control" id="mobile" placeholder="Mobile" name="mobile" value="<?php echo $post['mobile']; ?>">
	                                            <?php echo form_error('mobile'); ?>
	                                        </div>
	                                        <div class="col-md-6 mb-10 label-H">
	                                            <label for="mobile">Document aprroval status<span class="text-danger">*</span></label>
	                                           <select class="form-control" name="driver_status">
	                                               <option value="1" <?php echo ($post['status']==1)?'selected':''; ?>>Active</option>
	                                               <option value="3" <?php echo ($post['status']==3)?'selected':''; ?>>Pending By Admin</option>
	                                               <option value="4" <?php echo ($post['status']==4)?'selected':''; ?>>Inactive</option>
	                                           </select>
	                                        </div>
	                                   
	                                        <div class="col-md-6 mb-10 label-H">
	                                            <label for="mobile">Identification document<span class="text-danger">*</span></label>
	                                           <select class="form-control" name="identification_document_id">
	                                            <?php foreach($identification_documents->result() as $identification_document){ ?>
	                                               <option value="<?php echo $identification_document->id;?>" <?php echo ($identification_document->id==$post['identification_document_id'])?'selected':''; ?>><?php echo $identification_document->document_name;?></option>
	                                               
	                                            <?php }?>
	                                           </select>
	                                        </div>
	                                        <div class="col-md-12 mb-10 label-H">                                                
	                                            <label class="control-label ">Identity document</label>
	                                            
	                                            <input type="hidden" class="form-control" id="identity_document" name="identity_document[]" value=""> 
	                                            <?php echo form_error('identity_document'); ?>
	                                            <div id="email-input-wrapper"  class="controls ">    
	                                                <div class="row">
	                                                    <div class="col-md-3 mb-10 "> 
	                                                        <?php if (!empty($post['verification_id'])) { ?>
	                                                            <div id="image-div" class="document-media">
	                                                                <a href="<?php echo base_url('uploads/verification_document/'.$post['user_id'].'/'. $post['verification_id']);?>" data-fancybox="gallery">
	                                                                <img id="img" src="<?php echo base_url('uploads/verification_document/'.$post['user_id'].'/'. $post['verification_id']);?>" />
	                                                                </a>
	                                                            </div>   
	                                                                
	                                                            <?php } else {
	                                                                ?>
	                                                            <div id="image-div" class="document-media">
	                                                                <img id="myno_img"  src="<?php echo base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />
	                                                            </div>
	                                                        <?php }
	                                                        ?>
	                                                    </div>
	                                                    <div class="col-md-3 mb-10 ">     
															<input type="hidden" name="city" value="<?php echo $post['city'];?>">
															<label for="name">City<span class="text-danger"></span></label>
															<input type="text" class="form-control" id="city" placeholder="City" name="city" value="<?php echo $post['city']; ?>">
															<?php echo form_error('city'); ?>
														</div>
														
														<div class="col-md-3 mb-10 ">     
															<input type="hidden" name="state" value="<?php echo $post['state'];?>">
															<label for="name">State<span class="text-danger"></span></label>
															<input type="text" class="form-control" id="state" placeholder="state" name="state" value="<?php echo $post['state']; ?>">
															<?php echo form_error('state'); ?>
														</div>
														<div class="col-md-3 mb-10 ">     
															<input type="hidden" name="country" value="<?php echo $post['country'];?>">
															<label for="name">Country<span class="text-danger"></span></label>
															<input type="text" class="form-control" id="country" placeholder="country" name="country" value="<?php echo $post['country']; ?>">
															<?php echo form_error('country'); ?>
														</div>
														
														
														<div class="col-md-12 mb-10 ">
	                                                        <div id="image-div">
	                                                        <label class="control-label ">Identity document status</label>
	                                                            <select class="form-controll" name="verification_id_approval_atatus">
	                                                                <option value="1" <?php echo ($post['verification_id_approval_atatus']==1)?'selected':'';?>>Approved</option>
	                                                                <option value="2" <?php echo ($post['verification_id_approval_atatus']==2)?'selected':'';?>>Not Approve</option>
	                                                            </select>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="row">
	                                                <div class="col-md-6">
	                                                    <label class="control-label ">Identity document start date </label>
	                                                    <input type="date" class="form-control" name="identification_issue_date" value="<?php echo ($post['identification_issue_date'])?$post['identification_issue_date']:date('Y-m-d');?>" />
	                                                </div>
	                                                <div class="col-md-6">
	                                                    <label class="control-label ">Identity document expiry date</label>
	                                                    <input type="date" class="form-control" name="identification_expiry_date" value="<?php echo ($post['identification_expiry_date'])?$post['identification_expiry_date']:date('Y-m-d');?>" />
	                                                </div>
	                                            </div>
	                                        </div>
	                                        
	                                        <div class="col-md-12 mb-10 label-H">
	                                           
	                                            <label class="control-label">Background approve status</label>
	                                            <select class="form-controll" name="background_approval_status">
	                                                <option value="1" <?php echo ($post['background_approval_status']==1)?'selected':'';?>>Approved</option>
	                                                <option value="2" <?php echo ($post['background_approval_status']==2)?'selected':'';?>>Not Approve</option>
	                                            </select>
	                                            
	                                        </div>
	                                        <div class="col-md-12 mb-10 label-H">
	                                            <label class="control-label ">Profile Image</label>
	                                            <div id="email-input-wrapper"  class="controls ">
	                                                <?php if (!empty($post['avatar'])) { ?>
	                                                <div id="image-div" class="document-media">
	                                                    <a href="<?php echo base_url('uploads/profile_image/'.$post['user_id'].'/'.$post['avatar']) ?>" data-fancybox="gallery">
	                                                    <img id="img" src="<?php echo base_url('uploads/profile_image/'.$post['user_id'].'/'.$post['avatar']) ?>" />
	                                                    </a>
	                                                    <!-- <img id="img" src="<?php echo base_url('uploads/profile_image/'.$post['user_id'].'/'.$post['avatar']) ?>" style="height: 80px;width: 80px"/> -->
	                                                </div>
	                                                <?php } else {
	                                                ?>
	                                                <div class="document-media">
	                                                <img id="myno_img"  src="<?= base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />
	                                            	</div>
	                                            <?php }
	                                            ?>
	                                            </div>
	                                         </div>
	                                         
	                                    </div>
	                                </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                          <h3 class="vehicle-detail-text">Vehicle Detail</h3>
                                        </div>
                                    </div>
                                    <?php if ($vehicle_query->num_rows()>0) {
                                        foreach ($vehicle_query->result() as $row) {?>
                                        <div class="row">
                                            <input type="hidden" name="vehicle_id[]" value="<?php echo $row->id;?>">
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="brand"> Vehicle make<span class="text-danger">*</span></label>
                                                <select class="form-control" name="brand[]" id="brand">
                                                    <option value=""> Select Brand </option>
                                                <?php if ($brands->num_rows()>0) { 
                                                        foreach ($brands->result() as $brand) {?>
                                                    <option value="<?php echo $brand->id;?>" <?php echo ($row->brand_id==$brand->id)?'selected':''; ?>><?php echo $brand->brand_name;?></option>      
                                                <?php }
                                                    }?>
                                                    
                                                </select>
                                                
                                                <?php echo form_error('brand'); ?>
                                            </div>
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="set_option">Vehicle Model<span class="text-danger">*</span></label>
                                                <select class="form-control" name="model[]" id="set_option">
                                                    <?php $query = get_table_record(Tables::MODEL,array('status'=>1,'brand_id'=>$row->brand_id),'id,brand_id,model_name');
                                                        foreach ($query->result() as $value) {?>
                                                           <option value="<?php echo $value->id;?>" <?php echo ($value->id==$row->model_id)?'selected':'';?>> <?php echo $value->model_name;?></option> 
                                                        <?php }
                                                    ?>
                                                    
                                                </select>
                                                
                                                <?php echo form_error('model'); ?>
                                            </div>
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="year">Vehicle Year<span class="text-danger">*</span></label>
                                                <select class="form-control" name="year[]" id="year">
                                                    <option value=""> Select Year </option>
                                                <?php 
                                                  for ($i=2000; $i<=date('Y');$i++) {?>
                                                    <option value="<?php echo $i;?>" <?php echo ($row->year==$i)?'selected':'';?>><?php echo $i;?></option>      
                                                <?php }?>                                                
                                                </select>                                        
                                            <?php echo form_error('year'); ?>
                                            </div>
                                            
                                            <div class="col-md-5 mb-10 label-H"> 
                                            <p  class="vehicle-service-text">Vehicle Service</P>   
                                            <?php $service_rate =0; if ($types->num_rows()>0) { 
                                               
                                                foreach ($types->result() as $type) {
                                                    $service_rate=$type->rate;?>
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" value="<?php echo $type->id;?>" rate="<?php echo $type->rate;?>" <?php echo (in_array($type->id, $vehicle_service))?'checked':'';?> disabled><?php echo $type->title;?>
                                                    </label>
                                                         
                                                <?php }
                                                    }?>                                            
                                            </div>
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="rate">Seat<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="rate" placeholder="" name="seat_no[]" value="<?php echo $row->seat_no;?>"> 
                                                <?php echo form_error('seat'); ?>
                                            </div>
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="rate">Service Rate($)(/Km)<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="rate" placeholder="" name="rate[]" value="<?php echo $service_rate;?>"> 
                                                <?php echo form_error('rate'); ?>
                                            </div>
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="mobile">Vehicle Number<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="vehicle_no" placeholder="Vehicle Number" name="vehicle_no[]" value="<?php echo $row->vehicle_no;?>"> 
                                            <?php echo form_error('vehicle_no'); ?>
                                            </div>
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="mobile">Vehicle Color<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="color" placeholder="Vehicle Color" name="color[]" value="<?php echo $row->color;?>"> 
                                            <?php echo form_error('color'); ?>
                                            </div>
                                            <div class="col-md-3 mb-10 label-H">
                                                <label class="control-label">Status</label>
                                                <div id="email-input-wrapper" class="controls">
                                                    <select class="form-control" name="status[]">
                                                        <option value="1" <?php echo ($row->status==1)?'selected':''?>>Active</option>
                                                        <option value="2" <?php echo ($row->status==2)?'selected':''?>>Inactive</option>
                                                    </select>
                                                   <!--  <div class="vd_radio radio-success">
                                                    <input type="radio" <?php echo ($row->status==1)?'checked':''?> class="radiochk" value="1" id="optionsRadios<?php echo $row->id;?>" name="status[]">
                                                    <label for="optionsRadios<?php echo $row->id;?>"> Active</label>
                                                    <input type="radio" <?php echo ($row->status==2)?'checked': '' ?> value="2" class="radiochk" id="optionsRadios<?php echo $row->id;?>" name="status[]">
                                                    <label for="optionsRadios<?php echo $row->id;?>"> Inactive</label>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-10 label-H">
                                            	<div class="uploads-driver-box-info">    
                                            	<div class="mb-10">                                            
                                                <label class="control-label ">License</label>
                                                <input type="file" class="form-control" id="update_license" name="car_pic[]" > 
                                                <input type="hidden" class="form-control" id="car_pic" name="license[]" value="<?php echo (!empty($row->license))?$row->license:'';?>">
                                                </div> 
                                                <?php echo form_error('license'); ?>
                                                <div id="email-input-wrapper"  class="controls ">    
                                                    <div class="row">
                                                        <div class="col-md-12 mb-10">
                                                            <?php if (!empty($row->license)) { ?>
                                                            <div id="image-div" class="document-media">    
                                                                <a href="<?php echo base_url('uploads/license_document/'.$post['user_id'].'/'. $row->license);?>" data-fancybox="gallery">
                                                                <img id="img" src="<?php echo base_url('uploads/license_document/'.$post['user_id'].'/'. $row->license);?>" style="height: 200px;width: 200px"/>
                                                                </a>
                                                                <!--  <img id="img" src="<?php echo base_url('uploads/license_document/'.$post['user_id'].'/'. $row->license);?>" style="height: 200px;width: 200px"/> -->
                                                            </div>   
                                                            <?php } else {
                                                                ?>
                                                            <div class="document-media">
                                                                <img id="myno_img" style="width: 80px;height: 80px" src="<?php echo base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />
                                                            </div>
                                                            <?php }
                                                            ?>
                                                        </div>
                                                        <div class="col-md-12 mb-10">
                                                            <div id="image-div">
                                                                <label class="control-label">License aprove Status</label>
                                                                <select class="form-controll" name="license_approve_status">
                                                                    <option value="1" <?php echo ($row->license_approve_status==1)?'selected':'';?>>Approved</option>
                                                                    <option value="2" <?php echo ($row->license_approve_status==2)?'selected':'';?>>Not Approve</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label ">License start date </label>
                                                        <input type="date" class="form-control" name="license_issue_date[]" value="<?php echo ($row->license_issue_date)?$row->license_issue_date:date('m-d-Y');?>" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="control-label ">License expiry date</label>
                                                        <input type="date" class="form-control" name="license_expiry_date[]" value="<?php echo ($row->license_expiry_date)?$row->license_expiry_date:date('m-d-Y');?>" />
                                                    </div>
                                                </div>
                                           <!--  <a href="<?php echo base_url('admin/download/permit_document/permit/'.$post['user_id']);?>" class="download1" data-folder="permit_document" data-driver="<?php echo $post['user_id']?>" data-file="permit">Download</a> -->
                                            </div>
                                        	</div>

                                            <div class="col-md-4 mb-10 label-H">
                                            	<div class="uploads-driver-box-info">  
                                            	<div class="mb-10">
                                                <label class="control-label ">Insurance</label>
                                                <input type="file" class="form-control" id="update_insurance" name="car_pic[]" > 
                                                <input type="hidden" class="form-control" id="car_pic" name="insurance[]" value="<?php echo (!empty($row->insurance))?$row->insurance:'';?>">
                                                </div> 
                                                <?php echo form_error('car_pic'); ?>
                                                <div id="email-input-wrapper"  class="controls ">                                            
                                                    <div class="row">
                                                        <div class="col-md-12 mb-10">
                                                            <?php if (!empty($row->insurance)) { ?>
                                                            <div id="image-div" class="document-media">       
                                                                <a href="<?php echo base_url('uploads/insurance_document/'.$post['user_id'].'/'. $row->insurance);?>" data-fancybox="gallery">
                                                                <img id="img" src="<?php echo base_url('uploads/insurance_document/'.$post['user_id'].'/'. $row->insurance);?>"/>
                                                                </a>
                                                                <!-- <img id="img" src="<?php echo base_url('uploads/insurance_document/'.$post['user_id'].'/'. $row->insurance);?>" style="height: 200px;width: 200px"/> -->
                                                            </div>    
                                                            <?php } else {
                                                                ?>
                                                            <div class="document-media">   
                                                                <img id="myno_img" src="<?php echo base_url() ?>assets/images/avatar/no-doc.png" alt="your image" />
                                                            </div>   
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-md-12 mb-10">
                                                            <div id="image-div">
                                                            <label class="control-label">Insurance aprove Status</label>
                                                                <select class="form-controll" name="insurance_approve_status">
                                                                    <option value="1" <?php echo ($row->insurance_approve_status==1)?'selected':'';?>>Approved</option>
                                                                    <option value="2" <?php echo ($row->insurance_approve_status==2)?'selected':'';?>>Not Approve</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label ">Insurance start date </label>
                                                        <input type="date" class="form-control" name="insurance_issue_date[]" value="<?php echo ($row->insurance_issue_date)?$row->insurance_issue_date:date('m-d-Y');?>" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="control-label ">Insurance expiry date</label>
                                                        <input type="date" class="form-control" name="insurance_expiry_date[]" value="<?php echo ($row->insurance_expiry_date)?$row->insurance_expiry_date:date('m-d-Y');?>" />
                                                    </div>
                                                </div>
                                           <!--  <a href="<?php echo base_url('admin/download/permit_document/permit/'.$post['user_id']);?>" class="download1" data-folder="permit_document" data-driver="<?php echo $post['user_id']?>" data-file="permit">Download</a> -->
                                           		</div>
                                            </div>
                                            <div class="col-md-4 mb-10 label-H">
                                            	<div class="uploads-driver-box-info">  
                                            	<div class="mb-10">
                                                <label class="control-label ">Car Registration</label>
                                                <input type="file" class="form-control" id="update_car_registration" name="update_car_registration[]" > 
                                                <input type="hidden" class="form-control" id="car_pic" name="car_registration[]" value="<?php echo (!empty($row->car_registration))?$row->car_registration:'';?>"></div> 
                                                <?php echo form_error('car_pic'); ?>
                                                <div id="email-input-wrapper"  class="controls ">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12 mb-10">
                                                            <?php if (!empty($row->car_registration)) { ?>
                                                            <div id="image-div" class="document-media">    
                                                                <a href="<?php echo base_url('uploads/car_registration/'.$post['user_id'].'/'. $row->car_registration);?>" data-fancybox="gallery">
                                                                <img id="img" src="<?php echo base_url('uploads/car_registration/'.$post['user_id'].'/'. $row->car_registration);?>"/>
                                                                </a>
                                                                <!-- <img id="img" src="<?php echo base_url('uploads/insurance_document/'.$post['user_id'].'/'. $row->car_registration);?>" style="height: 200px;width: 200px"/> -->
                                                            </div>        
                                                                <?php } else {
                                                                    ?>
                                                            <div class="document-media">  
                                                                <img id="myno_img" src="<?php echo base_url() ?>assets/images/avatar/no-doc.png" alt="your image" />
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-md-12 mb-10">
                                                            <div id="image-div">
                                                            <label class="control-label ">Car Registration approve satatus</label>
                                                                <select class="form-controll" name="car_registration_approve_status[]">
                                                                    <option value="1" <?php echo ($row->car_registration_approve_status==1)?'selected':'';?>>Approved</option>
                                                                    <option value="2" <?php echo ($row->car_registration_approve_status==2)?'selected':'';?>>Not Approve</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label ">Car start date </label>
                                                        <input type="date" class="form-control" name="car_issue_date[]" value="<?php echo ($row->car_issue_date)?$row->car_issue_date:date('m-d-Y');?>" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="control-label ">Car expiry date</label>
                                                        <input type="date" class="form-control" name="car_expiry_date[]" value="<?php echo ($row->car_expiry_date)?$row->car_expiry_date:date('m-d-Y');?>" />
                                                    </div>
                                                </div>
                                                </div>
                                               <!--  <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label ">Insurance start date </label>
                                                        <input type="date" class="form-control" name="insurance_issue_date[]" value="<?php echo ($row->insurance_issue_date)?$row->insurance_issue_date:date('m-d-Y');?>" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label ">Insurance expiry date</label>
                                                        <input type="date" class="form-control" name="insurance_expiry_date[]" value="<?php echo ($row->insurance_expiry_date)?$row->insurance_expiry_date:date('m-d-Y');?>" />
                                                    </div>
                                                </div> -->
                                           <!--  <a href="<?php echo base_url('admin/download/permit_document/permit/'.$post['user_id']);?>" class="download1" data-folder="permit_document" data-driver="<?php echo $post['user_id']?>" data-file="permit">Download</a> -->
                                           		</div>
                                            </div>
                                            <div class="col-md-4 mb-10 label-H">
                                            	<div class="uploads-driver-box-info">  
                                            	<div class="mb-10">   		                                             
                                                <label class="control-label ">Inspection document</label>
                                                <input type="file" class="form-control" id="update_car_registration" name="inspection_document[]" > 
                                                <input type="hidden" class="form-control" id="inspection_document" name="update_inspection_document[]" value="<?php echo $row->inspection_document?>">
                                                </div> 
                                                <?php echo form_error('inspection_document'); ?>
                                                <div id="email-input-wrapper"  class="controls ">    
                                                    <div class="row">
                                                        <div class="col-md-12 mb-10">
                                                            <?php if (!empty($row->inspection_document)) { ?>
                                                            <div id="image-div" class="document-media">        
                                                                <a href="<?php echo base_url('uploads/inspection_document/'.$post['user_id'].'/'. $row->inspection_document);?>" data-fancybox="gallery">
                                                                <img id="img" src="<?php echo base_url('uploads/inspection_document/'.$post['user_id'].'/'. $row->inspection_document);?>" />
                                                                </a>
                                                            </div>    
                                                                    
                                                            <?php } else {
                                                                    ?>
                                                            <div class="document-media"> 
                                                                <img id="myno_img" src="<?php echo base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />
                                                            </div>
                                                            <?php }
                                                            ?>
                                                        </div>
                                                        
                                                        <div class="col-md-12 mb-10">
                                                            <div id="image-div">
                                                            <label class="control-label ">Inspection document status</label>
                                                                <select class="form-controll" name="inspection_approval_status[]">
                                                                    <option value="1" <?php echo ($row->inspection_approval_status==1)?'selected':'';?>>Approved</option>
                                                                    <option value="2" <?php echo ($row->inspection_approval_status==2)?'selected':'';?>>Not Approve</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label ">Inspection document start date </label>
                                                        <input type="date" class="form-control" name="inspection_issue_date[]" value="<?php echo ($row->inspection_issue_date)?$row->inspection_issue_date:date('Y-m-d');?>" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="control-label ">Inspection document expiry date</label>
                                                        <input type="date" class="form-control" name="inspection_expiry_date[]" value="<?php echo ($row->inspection_expiry_date)?$row->inspection_expiry_date:date('Y-m-d');?>" />
                                                    </div>
                                                </div>
                                               </div>
                                            </div>
                                            <div class="col-md-4 mb-10 label-H">
                                            	<div class="uploads-driver-box-info">  
                                            	<div class="mb-10">
                                                <label class="control-label ">Vehicle Image</label>
                                                <input type="file" class="form-control" id="update_car_pic" name="update_car_pic[]" > 
                                           		</div>
                                                <input type="hidden" class="form-control" id="car_pic" name="car_pic[]" value="<?php echo (!empty($row->car_pic))?$row->car_pic:'';?>"> 
                                                <?php echo form_error('car_pic'); ?>
                                                <div id="email-input-wrapper"  class="controls ">
                                                    <?php if (!empty($row->car_pic)) { ?>
                                                        <div id="image-div" class="document-media">
                                                            <a href="<?php echo base_url('uploads/car_pic/'.$post['user_id'].'/'. $row->car_pic);?>" data-fancybox="gallery">
                                                            <img id="img" src="<?php echo base_url('uploads/car_pic/'.$post['user_id'].'/'. $row->car_pic);?>" />
                                                            </a>
                                                            <!-- <img id="img" src="<?php echo base_url('uploads/car_pic/'.$post['user_id'].'/'. $row->car_pic);?>" style="height: 200px;width: 200px"/> -->
                                                        </div>
                                                    <?php } else {
                                                        ?>
                                                        <div class="document-media">
                                                        <img id="myno_img" src="<?php echo base_url() ?>assets/images/avatar/no-vehicle.png" alt="your image" />
                                                    	</div>
                                                    <?php }
                                                    ?>
                                                </div>
                                               
                                           <!--  <a href="<?php echo base_url('admin/download/permit_document/permit/'.$post['user_id']);?>" class="download1" data-folder="permit_document" data-driver="<?php echo $post['user_id']?>" data-file="permit">Download</a> -->
                                            </div>
                                            </div>
                                        </div>         
                                    <?php    }
                                       
                                    }?>
                                    <div class="row">
                                        <div class="col-md-12 mt-20">
                                            <!-- <a href="<?php echo base_url('admin/drivers');?>" class="btn btn-success">Back</a> -->
                                            <button type="submit" class="btn btn-gr">Update</button>  
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