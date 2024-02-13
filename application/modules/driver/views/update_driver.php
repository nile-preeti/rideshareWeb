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
                                <form action="<?php echo base_url('driver/update_driver_profile/'.$post['user_id']);?>" method="post" enctype="multipart/form-data">
                                	<div class="update-driver-item">
                                		<div class="row">
	                                        <div class="col-md-12">
	                                          <h3 class="vehicle-detail-text">Personal Detail</h3>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                    	 <div class="col-md-2 mb-10 label-H uploads-driver-box-info">
	                                            <label class="control-label ">Profile Image</label>
	                                            <div id="email-input-wrapper"  class="controls cmb-1">
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
												<input type="file" class="form-control" id="avatar" name="avatar" >
	                                         </div>
	                                         <div class="col-md-10">
	                                         	<div class="row">
			                                        <div class="col-md-4 mb-10 label-H px-1" >
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
														<div class="form-group mt-2 d-inline" style="display:flex">
															<span class="border-end country-code px-2">
																<?php  $flag='+'; ?>
																<select class="form-control" name="country_code">
																	
																	<?php 
																   
																	foreach($countryCode->result() as $country_code){
																	   if($country_code->phone_code==$post['country_code']){ 
																	?>
																		<option value="<?php echo $flag.$country_code->phone_code;?>" selected ><?php echo $flag.$country_code->phone_code;?></option>
																		
																	<?php }else{ ?>
																		<option value="<?php echo $flag.$country_code->phone_code;?>"> <?php echo $flag.$country_code->phone_code; ?></option>
																	<?php } }?>
																</select>
															</span>
															
															<input type="text" class="form-control" id="mobile" placeholder="Mobile" name="mobile" value="<?php echo $post['mobile']; ?>">
			                                            
														</div>
														<p><?php echo form_error('mobile'); ?></p>
			                                        </div>
													
													
													
													
			                                        <div class="col-md-4 mb-10 label-H px-1">
			                                            <label for="mobile" class="status_dark">Document approvel Status<span class="text-danger">*</span></label>
			                                           <select class="form-control" name="driver_status">
			                                               <option value="1" <?php echo ($post['status']==1)?'selected':''; ?>>Active</option>
			                                               <option value="3" <?php echo ($post['status']==3)?'selected':''; ?>>Pending By Admin</option>
			                                               <option value="4" <?php echo ($post['status']==4)?'selected':''; ?>>Inactive</option>
			                                           </select>
			                                        </div>
			                                   
			                                        <div class="col-md-4 mb-10 label-H">
			                                            <label for="mobile" class="status_dark">Identification document<span class="text-danger">*</span></label>
			                                           <select class="form-control" name="identification_document_id">
			                                            <?php foreach($identification_documents->result() as $identification_document){ ?>
			                                               <option value="<?php echo $identification_document->id;?>" <?php echo ($identification_document->id==$post['identification_document_id'])?'selected':''; ?>><?php echo $identification_document->document_name;?></option>
			                                               
			                                            <?php }?>
			                                           </select>
			                                        </div>

			                                        <div class="col-md-4 mb-10 label-H">
			                                            <label class="control-label status_dark" >Background approve status</label>
			                                            <select class="form-controll" name="background_approval_status">
			                                                <option value="1" <?php echo ($post['background_approval_status']==1)?'selected':'';?>>Approved</option>
			                                                <option value="2" <?php echo ($post['background_approval_status']==2)?'selected':'';?>>Not Approve</option>
			                                            </select>
			                                            
			                                        </div>
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
										<!--?php print_r($row); die; ?-->
                                        <div class="row">
                                            <input type="hidden" name="vehicle_id[]" value="<?php echo $row->id;?>">
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="brand" class="control-label status_dark"> Vehicle Category<span class="text-danger">*</span></label>
                                                <select class="form-control" name="brand" id="brand">
                                                    <option value=""> Select Category </option>
                                                <?php if ($types->num_rows()>0) { 
                                                        foreach ($types->result() as $brand) {?>
                                                    <option value="<?php echo $brand->id;?>" <?php echo ($row->brand_id==$brand->id)?'selected':''; ?>><?php echo $brand->title;?></option>      
                                                <?php }
                                                    }?>
                                                    
                                                </select>
                                                
                                                <?php echo form_error('brand'); ?>
                                            </div>
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="set_option" class="control-label status_dark">Vehicle Model<span class="text-danger">*</span></label>
                                                <select class="form-control" name="model" id="set_option">
                                                    <?php $query = get_table_record(Tables::VEHICLE_SUBCATEGORY_TYPE,array('status'=>1,'vehicle_type_category_id'=>$row->brand_id),'id,vehicle_type_category_id, title as model_name');
                                                        foreach ($query->result() as $value) {?>
                                                           <option value="<?php echo $value->id;?>" <?php echo ($value->id==$row->model_id)?'selected':'';?>> <?php echo $value->model_name;?></option> 
                                                        <?php }
                                                    ?>
                                                    
                                                </select>
												
                                                <?php echo form_error('model'); ?>
                                            </div>
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="year" class="control-label status_dark">Vehicle Year<span class="text-danger">*</span></label>
                                                <select class="form-control" name="year[]" id="year">
                                                  
													<?php $query = get_table_record(Tables::TBL_CATEGORY_YEAR,array('status'=>1,'category_id'=>$row->brand_id),'id,category_id, category_year');
                                                        foreach ($query->result() as $value) {?>
                                                           <option value="<?php echo $value->category_year;?>" <?php echo ($value->category_year==$row->year)?'selected':'';?>> <?php echo $value->category_year;?></option> 
                                                        <?php }                                                   ?>
												
                                                </select>                                        
                                            <?php echo form_error('year'); ?>
                                            </div>
                                            
                                              
                                            <!--?php $service_rate =0; 
												if ($types->num_rows()>0) { 
                                               
                                                foreach ($subcategorytypes->result() as $subtype) {
													//echo"<pre>";  print_r($subtype->rate);
                                                    $service_rate=$subtype->rate;
													//echo $service_rate;
												 }}
											?-->                                            
                                           
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="rate" class="control-label status_dark">Seat<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="seat" placeholder="" name="seat_no[]" value="<?php echo $row->seat_no;?>"> 
                                                <?php echo form_error('seat'); ?>
                                            </div>
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="rate">Per Mile Rate($)<span class="text-danger">*</span></label>
                                                												
                                                    <?php $query = get_table_record(Tables::VEHICLE_SUBCATEGORY_TYPE,array('status'=>1,'vehicle_type_category_id'=>$row->brand_id),'id,title,rate');
                                                        foreach ($query->result() as $value) {?>
														<?php if($value->id==$row->model_id){?>
															<input type="text" class="form-control" id="rate" placeholder="" name="rate[]" value="<?php echo $value->rate;?>">
														<?php  }} ?>
                                                           
												<?php echo form_error('rate'); ?>
                                            </div>
											
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="mobile" class="control-label status_dark">Vehicle Number<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="vehicle_no" placeholder="Vehicle Number" name="vehicle_no[]" value="<?php echo $row->vehicle_no;?>"> 
                                            <?php echo form_error('vehicle_no'); ?>
                                            </div>
                                            <div class="col-md-3 mb-10 label-H">
                                                <label for="mobile">Vehicle Color<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="color" placeholder="Vehicle Color" name="color[]" value="<?php echo $row->color;?>"> 
                                            <?php echo form_error('color'); ?>
                                            </div>
                                            <div class="col-md-3 mb-10 label-H">
                                                <label class="control-label status_dark">Status</label>
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
                                                <label class="control-label status_dark">LICENCE</label>
                                                <input type="file" class="form-control" id="update_license" name="license[]" > 
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
                                                                <label class="control-label status_dark">LICENCE aprove Status</label>
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
                                                        <label class="control-label status_dark">LICENCE start date </label>
                                                        <input type="date" class="form-control" name="license_issue_date[]" value="<?php echo ($row->license_issue_date)?$row->license_issue_date:date('m-d-Y');?>" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="control-label status_dark">LICENCE expire date</label>
                                                        <input type="date" class="form-control" name="license_expiry_date[]" value="<?php echo ($row->license_expiry_date)?$row->license_expiry_date:date('m-d-Y');?>" />
                                                    </div>
                                                </div>
                                           <!--  <a href="<?php echo base_url('admin/download/permit_document/permit/'.$post['user_id']);?>" class="download1" data-folder="permit_document" data-driver="<?php echo $post['user_id']?>" data-file="permit">Download</a> -->
                                            </div>
                                        	</div>

                                            <div class="col-md-4 mb-10 label-H">
                                            	<div class="uploads-driver-box-info">  
                                            	<div class="mb-10">
                                                <label class="control-label status_dark">TNC Insurance</label>
                                                <input type="file" class="form-control" id="update_insurance" name="insurance[]" > 
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
                                                            <label class="control-label status_dark">Insurance aprove Status</label>
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
                                                        <label class="control-label">Insurance start date </label>
                                                        <input type="date" class="form-control" name="insurance_issue_date[]" value="<?php echo ($row->insurance_issue_date)?$row->insurance_issue_date:date('m-d-Y');?>" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="control-label ">Insurance expire date</label>
                                                        <input type="date" class="form-control" name="insurance_expiry_date[]" value="<?php echo ($row->insurance_expiry_date)?$row->insurance_expiry_date:date('m-d-Y');?>" />
                                                    </div>
                                                </div>
                                           <!--  <a href="<?php echo base_url('admin/download/permit_document/permit/'.$post['user_id']);?>" class="download1" data-folder="permit_document" data-driver="<?php echo $post['user_id']?>" data-file="permit">Download</a> -->
                                           		</div>
                                            </div>
                                            <div class="col-md-4 mb-10 label-H">
                                            	<div class="uploads-driver-box-info">  
                                            	<div class="mb-10">
                                                <label class="control-label status_dark">Car Registration</label>
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
                                                            <label class="control-label status_dark">Car Registration approve satatus</label>
                                                                <select class="form-controll" name="car_registration_approve_status[]">
                                                                    <option value="1" <?php echo ($row->car_registration_approve_status==1)?'selected':'';?>>Approved</option>
                                                                    <option value="2" <?php echo ($row->car_registration_approve_status==2)?'selected':'';?>>Not Approve</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label status_dark">Car start date </label>
                                                        <input type="date" class="form-control" name="car_issue_date[]" value="<?php echo ($row->car_issue_date)?$row->car_issue_date:date('m-d-Y');?>" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="control-label status_dark">Car expire date</label>
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
                                                        <label class="control-label ">Insurance expire date</label>
                                                        <input type="date" class="form-control" name="insurance_expiry_date[]" value="<?php echo ($row->insurance_expiry_date)?$row->insurance_expiry_date:date('m-d-Y');?>" />
                                                    </div>
                                                </div> -->
                                           <!--  <a href="<?php echo base_url('admin/download/permit_document/permit/'.$post['user_id']);?>" class="download1" data-folder="permit_document" data-driver="<?php echo $post['user_id']?>" data-file="permit">Download</a> -->
                                           		</div>
                                            </div>
                                            <div class="col-md-4 mb-10 label-H">
                                            	<div class="uploads-driver-box-info">  
                                            	<div class="mb-10">   		                                             
                                                <label class="control-label status_dark">Inspection document</label>
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
                                                            <label class="control-label status_dark">Inspection document status</label>
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
                                                        <label class="control-label status_dark">Inspection document start date </label>
                                                        <input type="date" class="form-control" name="inspection_issue_date[]" value="<?php echo ($row->inspection_issue_date)?$row->inspection_issue_date:date('Y-m-d');?>" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="control-label status_dark">Inspection document expire date</label>
                                                        <input type="date" class="form-control" name="inspection_expiry_date[]" value="<?php echo ($row->inspection_expiry_date)?$row->inspection_expiry_date:date('Y-m-d');?>" />
                                                    </div>
                                                </div>
                                               </div>
                                            </div>
                                            <div class="col-md-4 mb-10 label-H">
                                            	<div class="uploads-driver-box-info">  
                                            	<div class="mb-10">
                                                <label class="control-label status_dark">Vehicle Image</label>
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




<script type="text/javascript">

    $('#brand').change(function() {
        var category_id = $('#brand').val();		
		//alert(category_id);

        $.ajax({
			type: 'get',
			url: base_url+'admin/getsubCategory',
			data: "vehicle_type_category_id=" + category_id,
            dataType : 'json',
			success: function (res) {
				if(res.data != 0) {
                    $("#set_option").empty();
					//$("#set_option1").attr("style", "display:block");
					//document.querySelector('#set_option').innerHTML = '';
					$('#set_option').append('<option>Select model type</option>');
                    $.each(res.data, function (key, value) {
                        //console.log(value);
                        $('#set_option').append('<option value=' + value.id + ' data-seat=' + value.seat + ' >' + value.title + '</option>');
                    });

                      /*
					$.each(res.catdata, function (i, p){
						$('#set_option').append($('<option></option>').val(p.id).html(p.title));
					});
                    */
				}	
			}
		});
	});
	
	$('#set_option').on("change",function(){
        //var seat = $("#set_option option:selected").attr('data-seat');
        var seat = $('#set_option option:selected').data('seat');
        $('#seat').val(seat);
    });
		
		
	$('#brand').change(function() {
        var cat_id = $('#brand').val();	
		$.ajax({
			type: 'get',
			url: base_url+'admin/getYear',
			data: "category_id=" + cat_id,
            dataType : 'json',
			success: function (res) {
				if(res.data != 0) {
                    $("#year").empty();
					//$("#set_option1").attr("style", "display:block");
					//document.querySelector('#set_option').innerHTML = '';
					$('#year').append('<option>Select Year</option>');
                    $.each(res.data, function (key, value) {
                        //console.log(value);
                        $('#year').append('<option value=' + value.category_year + ' >' + value.category_year + '</option>');
                    });

				}	
			}
		});

    });

    // Get seat no. from model dropdown

    

</script>