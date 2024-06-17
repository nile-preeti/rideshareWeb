

<style type="text/css">

    .vd_bg-grey {background-color: #3c485c !important; }

    .mt-20{margin-top: 20px;}

    .panel{-webkit-box-shadow:none;}

    .btn{font-size: 12px;}

    .form-control{font-size: 12px;}

    .light-widget .panel-heading{margin-top: 12px;}

    .vd_panel-menu{position: absolute; top: 7px;    margin: 0;}
	.warning{font-size:11px; color:#fb8904; margin-left:4px;}

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
			
			<?php $this->load->view('common/error');?>
			
            <div class="vd_content-section clearfix">

                <div class="panel widget oc-panel light-widget">

                    <div class="panel-heading">

                        <div class="row">

                            <div class="col-md-6"> 

                                <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span><?php echo $breadcrumb;?></h3>

                            </div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                                <?php $this->load->view('common/error');?>

                                <?php $row = $types->row();
                                      //print_r($row);die; 
                               ?>
                                <?php //$category = $category->result();
                                      //print_r($category);die; ?>

                                <form action="<?php echo base_url('admin/update_vehicle_subcategory');?>" method="post" enctype='multipart/form-data'>
                                    <input type="hidden" name="id" value="<?php echo $row->id;?>">

                                    <div class="row">
                                        <div class="col-md-4 label-H">
                                            <label for="title">Vehicle name </label>
											<span class="text-danger">*</span>
                                            <input type="text" name="title" class="form-control"  id="title" value="<?php echo $row->title ?>" required />
                                            <?php echo form_error('title'); ?>
                                        </div>

                                        <div class="col-md-4 label-H">
                                            <label for="category">Vehicle category </label>
											<span class="text-danger">*</span>
                                            <select name="vehicle_type_category_id" class="form-control"  id="category_id" required />
                                            
                                            <?php 
                                                $category = $category->result();
                                                foreach($category as $list) { 
                                                if($row->vehicle_type_category_id == $list->id){
                                            ?>                                            
                                                <option value="<?php echo $list->id ?>" selected><?php echo $list->title; ?></option>
                                            <?php }else{ ?>
                                                <option value="<?php echo $list->id ?>"><?php echo $list->title; ?></option>     
											<?php }  }?>
                                            </select>
                                            
                                        </div>

                                        <div class="col-md-4 label-H">
                                            <label for="rate">Seat</label>
											<span class="text-danger">*</span>
                                            <input type="number" class="form-control" id="seat" name="seat"  value="<?php echo $row->seat ?>" required>
                                            <?php echo form_error('seat'); ?>                         
                                        </div>
                                    </div>
									
									
                                    
									<div class="row">
										<div class="col-md-4 label-H">
                                            <label for="rate">Short description</label>
                                            <input type="text" class="form-control" id="short_description" name="short_description" value="<?php echo $row->short_description ?>" required>
                                            <?php echo form_error('short_description'); ?>
                                        </div>
									
										<div class="form-group col-md-4">
										  <label for="title">Base rate </label>
										  <span class="text-danger">*</span>
											<div class="input-group">				
												<span class="input-group-btn">
													<button type="button" class="btn btn-default">$</button> 
												</span>
													<input type="number" name=" base_fare_fee" class="form-control"  id="base_fare_fee" step=".01" value="<?php echo $row->base_fare_fee; ?>" required>              
												<?php echo form_error('base_fare_fee'); ?>
											</div>
										</div>

                                        <div class="col-md-4 label-H">
                                            <label for="rate">Per mile rate</label>
											<span class="text-danger">*</span>
											<div class="input-group">				
												<span class="input-group-btn">
													<button type="button" step=".01" class="btn btn-default">$</button> 
												</span>
												<input type="number" class="form-control" id="rate" onkeypress="return isNumberKey(event)" name="rate" value="<?php echo $row->rate ?>" required>
												<?php echo form_error('rate'); ?>                         
											</div>
                                        </div>
										
									</div>
									<div class="row">
										<div class="form-group col-md-4">
										  <label for="title">Cancellation rate</label>
											<div class="input-group">				
												<span class="input-group-btn">
													<button type="button" step=".01" class="btn btn-default">$</button> 
												</span>
												<input type="number" name=" cancellation_fee" class="form-control"  id="cancellation_fee" value="<?php echo $row->cancellation_fee; ?>">              
												<?php echo form_error('cancellation_fee'); ?>
											</div>
										</div>
										<div class="form-group col-md-4">
										  <label for="title">Taxes</label>
											<span class="text-danger">*</span>
											<div class="input-group">				
												<span class="input-group-btn">
													<button type="button" step=".01" class="btn btn-default">%</button> 
												</span>
												<input type="number" name="taxes" class="form-control"  id="taxes" value="<?php echo $row->taxes; ?>" required>              
												<?php echo form_error('taxes'); ?>
											</div>
										</div>
										
										<div class="form-group col-md-4">
										  <label for="title">Surcharge rate</label>
											<div class="input-group">				
												<span class="input-group-btn">
													<button type="button" step=".01" class="btn btn-default">$</button> 
												</span>
												<input type="number" name="surcharge_fee" class="form-control"  id="surcharge_fee" value="<?php echo $row->surcharge_fee; ?>">              
												<?php echo form_error('surcharge_fee'); ?>
											</div>
										</div>
										
										
										
										<div class="form-group col-md-4">
										  <label for="title">Waiting rate (Per minute)</label>
										  <span class="text-danger">*</span>
											<div class="input-group">				
												<span class="input-group-btn">
													<button type="button" step=".01" class="btn btn-default">$</button> 
												</span>
												<?php $waitcharge=$row->base_fare_fee/60; ?>
												<input type="number" class="form-control"   value="<?php echo number_format($waitcharge,2); ?>" readonly>
											</div>
										</div>
										<div class="form-group col-md-4">
										  <label for="title">Admin charges</label>
										  <div class="input-group">				
											<span class="input-group-btn">
												<button type="button" step=".01" class="btn btn-default">%</button> 
											</span>
										  <input type="number" name="admin_charges" class="form-control"  id="admin_charges" value="<?php echo $row->admin_charges; ?>" required>
										 </div>              
										  <!--?php echo form_error('admin_charges'); ?-->
										</div>
									
                                        <div class="col-md-4 label-H">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control"  id="status" required>
                                                <option value="1" <?php echo ($row->status==1)?'selected':'';?>>Active</option>
                                                <option value="2" <?php echo ($row->status==2)?'selected':'';?>>Inactive</option>
                                            </select>
                                            <?php echo form_error('status'); ?>
                                        </div>

                                        <div class="col-md-4 label-H">
                                            <label for="rate">Vehicle image <span class="warning">( Icon size must be less than 2 MB )</span></label>
                                            <input type="file" class="form-control" id="car_pic" name="car_pic">
                                            <img src="<?php echo base_url('uploads/vehicle_image/'). $row->car_pic; ?>" class="img-fluid">
                                            <?php echo form_error('car_pic'); ?>
											
										</div>

                                        

                                        <div class="col-md-12 mt-20">

                                            <?php if ($row->id) {?>                                               

                                                <button type="submit" class="btn btn-gr">Update</button>

                                                <?php }else{?>

                                                    <button type="submit" class="btn btn-gr">Add </button>

                                            <?php }?>

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

	<SCRIPT language=Javascript>
       <!--
       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
       //-->
    </SCRIPT>