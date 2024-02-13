/* 

  This page is used for adding the vehicle details. 

*/
<div class="add-dynamic oc-card-add">

  <div class="oc-card-info">

    <div class="oc-card-heading">

      <div class="row">

        <div class="col-md-10">

          <h3 class="vehicle-detail"></h3>

        </div>

        <div class="col-md-2 text-right">

           <a href="javascript:void(0);" class="remove remove-more">

            <i class="fa fa-minus" aria-hidden="true"></i> Remove

          </a>

        </div>

      </div>

      <div class="oc-card-body">

        <div class="row">    

          <div class="col-md-3 mb-10">

            <label for="brand"> Vehicle make<span class="text-danger">*</span></label>

            <select class="form-control brand" name="brand[]" id="brand" data="<?php echo $post_data['data_id'];?>">

              <option value=""> Select Brand </option>

               <!-- Display all brand name of vehicle -->
               
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

            <select class="form-control" name="model[]" id="model_<?php echo $post_data['data_id'];?>">

              <option value=""> Select Model</option>

            </select>

            <?php echo form_error('model'); ?>

          </div>

          <div class="col-md-3 mb-10">

            <label for="year">Vehicle Year<span class="text-danger">*</span></label>

            <select class="form-control" name="year[]" id="year">

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

            <select class="form-control vehicle_type" name="vehicle_type[]" id="vehicle_type" data="<?php echo $post_data['data_id'];?>">

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

            <input type="text" class="form-control" id="rate_<?php echo $post_data['data_id'];?>" placeholder="" name="rate[]" value="<?php echo set_value('rate'); ?>"> 

            <?php echo form_error('rate'); ?>

          </div>

          <div class="col-md-3 mb-10">

            <label for="mobile">Vehicle Number<span class="text-danger">*</span></label>

            <input type="text" class="form-control" id="vehicle_no" placeholder="Vehicle Number" name="vehicle_no[]" value="<?php echo set_value('vehicle_no'); ?>"> 

            <?php echo form_error('vehicle_no'); ?>

          </div>

          <div class="col-md-3 mb-10">

            <label for="mobile">Vehicle Color<span class="text-danger">*</span></label>

            <input type="text" class="form-control" id="color" placeholder="Vehicle Color" name="color[]" value="<?php echo set_value('color'); ?>"> 

            <?php echo form_error('color'); ?>

          </div>      

          <div class="col-md-3 mb-10">

            <label for="mobile">Insurance<!-- <span class="text-danger">*</span> --></label>

            <input type="file" class="form-control" id="insurance" name="insurance[]" value="<?php echo set_value('insurance'); ?>"> 

            <?php echo form_error('insurance'); ?>

          </div>

          <div class="col-md-3 mb-10">

            <label for="mobile">License<!-- <span class="text-danger">*</span> --></label>

            <input type="file" class="form-control" id="license" name="license[]" value="<?php echo set_value('license'); ?>"> 

            <?php echo form_error('license'); ?>

          </div>

          <div class="col-md-3 mb-10">

            <label for="mobile">Vehicle Image<!-- <span class="text-danger">*</span> --></label>

            <input type="file" class="form-control" id="car_pic" placeholder="Car pic" name="car_pic[]" value="<?php echo set_value('car_pic'); ?>"> 

            <?php echo form_error('car_pic'); ?>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>  