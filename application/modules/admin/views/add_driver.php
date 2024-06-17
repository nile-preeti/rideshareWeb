/* 

  This page is used for adding a new driver. 

*/

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

                      <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Add Driver </h3></div>

                      <div class="col-md-6 text-right"> <a class="btn btn-gr" href="<?php echo base_url('admin/drivers');?>">Back</a></div>

                  </div>

              </div>

              <div class="panel-body">

                <div class="panel widget">

                  <div  class="search-filter">

                  <?php $this->load->view('common/error');?>

                    <form action="<?php echo base_url('admin/add_driver');?>" method="post" enctype="multipart/form-data" id="add_driver">

                      <div class="row">

                        <div class="col-md-4">

                          <label for="name">Full Name<span class="text-danger">*</span></label>

                          <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo set_value('name'); ?>">

                          <?php echo form_error('name'); ?>                                    

                        </div>

                        <div class="col-md-4">

                          <label for="email">Email<span class="text-danger">*</span></label>

                          <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo set_value('email'); ?>">

                          <?php echo form_error('email'); ?>

                        </div>

                        <div class="col-md-4">

                          <label for="mobile">Mobile<span class="text-danger">*</span></label>

                          <input type="number" class="form-control" id="mobile" placeholder="Mobile" name="mobile" value="<?php echo set_value('mobile'); ?>">

                          <?php echo form_error('mobile'); ?>

                        </div>

                      </div>

                      <div class="oc-card-info">

                        <div class="oc-card-heading">

                          <div class="row">

                            <div class="col-md-10">

                              <h3 class="vehicle-detail">Vehicle Detail</h3>

                            </div>

                            <div class="col-md-2 text-right">

                              <a href="javascript:void(0);" class="add-more" id="add-more" data="0">

                                <i class="fa fa-plus" aria-hidden="true"></i> Add More

                              </a>

                            </div>

                          </div>

                          <div class="oc-card-body">

                            <div class="add-wrapper">

                              <div class="oc-card-add">

                                  <div class="row">

                                    <div class="col-md-3 mb-10">

                                      <label for="brand"> Vehicle make<span class="text-danger">*</span></label>

                                      <select class="form-control brand" name="brand[]" id="brand" data="0">

                                      <option value=""> Select Brand </option>

                                      <?php if ($brands->num_rows()>0) { 

                                      foreach ($brands->result() as $brand) {?>

                                      <option value="<?php echo $brand->id;?>"><?php echo $brand->brand_name;?></option>      

                                      <?php }

                                      }?>

                                      </select>

                                      <?php echo form_error('brand'); ?>

                                    </div>

                                    <div class="col-md-3 mb-10">

                                      <label for="set_option">Vehicle Model<span class="text-danger">*</span></label>

                                      <select class="form-control model" name="model[]" id="model_0">

                                          <option value=""> Select Model</option>

                                      </select>

                                      <?php echo form_error('model'); ?>

                                    </div>

                                    <div class="col-md-3 mb-10">

                                      <label for="year">Vehicle Year<span class="text-danger">*</span></label>

                                      <select class="form-control year" name="year[]" id="year">

                                        <option value=""> Select Year </option>

                                        <?php 

                                          for ($i=2000; $i<=date('Y');$i++) {?>

                                            <option value="<?php echo $i;?>" ><?php echo $i;?></option>      

                                        <?php }?>

                                      </select>

                                      <?php echo form_error('year'); ?>

                                    </div>

                                    <div class="col-md-3 mb-10">

                                      <label for="vehicle_type">Vehicle Type<span class="text-danger">*</span></label>

                                      <select class="form-control vehicle_type" name="vehicle_type[]" id="vehicle_type" data="0">

                                          <option value=""> Select Vehicle Type </option>

                                          <?php if ($types->num_rows()>0) { 

                                          foreach ($types->result() as $type) {?>

                                          <option value="<?php echo $type->id;?>" rate="<?php echo $type->rate;?>"><?php echo $type->title;?></option>      

                                          <?php }

                                          }?>

                                      </select>

                                      <?php echo form_error('vehicle_type'); ?>

                                    </div>                                     

                                    <div class="col-md-3 mb-10">

                                      <label for="rate">Service Rate($)(/Km)<span class="text-danger">*</span></label>

                                      <input type="text" class="form-control rate" id="rate_0" placeholder="" name="rate[]" value="<?php echo set_value('rate'); ?>"> 

                                      <?php echo form_error('rate'); ?>

                                    </div>

                                    <div class="col-md-3 mb-10">

                                      <label for="mobile">Vehicle Number<span class="text-danger">*</span></label>

                                      <input type="text" class="form-control vehicle_no" id="vehicle_no" placeholder="Vehicle Number" name="vehicle_no[]" value="<?php echo set_value('vehicle_no'); ?>"> 

                                      <?php echo form_error('vehicle_no'); ?>

                                    </div>

                                    <div class="col-md-3 mb-10">

                                      <label for="mobile">Vehicle Color<span class="text-danger">*</span></label>

                                      <input type="text" class="form-control color" id="color" placeholder="Vehicle Color" name="color[]" value="<?php echo set_value('color'); ?>"> 

                                      <?php echo form_error('color'); ?>

                                    </div>

                                    <div class="col-md-3 mb-10">

                                      <label for="mobile">Insurance<!-- <span class="text-danger">*</span> --></label>

                                      <input type="file" class="form-control" id="insurance"  name="insurance[]" > 

                                      <?php echo form_error('insurance'); ?>

                                    </div>

                                    <div class="col-md-3 mb-10">

                                      <label for="mobile">License<!-- <span class="text-danger">*</span> --></label>

                                      <input type="file" class="form-control" id="license" name="license[]" > 

                                      <?php echo form_error('license'); ?>

                                    </div>

                                    <div class="col-md-3 mb-10">

                                      <label for="mobile">Vehicle Image<!-- <span class="text-danger">*</span> --></label>

                                      <input type="file" class="form-control car_pic" id="car_pic" placeholder="Car pic" name="car_pic[]" value="<?php echo set_value('car_pic'); ?>"> 

                                      <?php echo form_error('car_pic'); ?>

                                    </div>

                                  </div> 

                              </div>                   

                            </div>

                          </div>

                        </div>

                        <div class="row">

                          <div class="col-md-12 mt-20">

                            <a href="<?php echo base_url('admin/drivers');?>" class="btn btn-gr">Back</a>

                            <button type="submit" class="btn btn-gr">Submit</button>   

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

