<!-- Add vehicle type -->

<style type="text/css">

    button.close {

    -webkit-appearance: none;

    padding: 1px 8px 3px;

    background: #f44336;

    border: 0;

    position: absolute;

    right: 10px;

    top: 6px;

    color: #fff;

    border-radius: 5px;

    opacity: inherit;}

    .close:hover, .close:focus {

    color: #fff;

    text-decoration: none;

    cursor: pointer;

    filter: alpha(opacity=50);

    opacity: .5;

}

</style>



  <div class="oc-modal-box">

    <div class="oc-modal-heading">

      <h4 class="">Add vehicle Subcategory type</h4>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">

      <span aria-hidden="true">&times;</span>

      </button>

    </div>

    <div class="oc-modal-form">

      <div id="msg"></div>
    <?php //print_r($result); ?>
      <form action="<?php echo base_url('admin/add_vehiclesubcategory_type'); ?>" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="form-group col-md-6">
			  <label for="title">Vehicle type name</label>
			  <span class="text-danger">*</span>	
			  <input type="text" name="title" class="form-control"  id="title" value="<?php echo set_value('vehicle_type'); ?>">              
			  <?php echo form_error('title'); ?>
			</div> 

			<div class="form-group col-md-6">
			  <label for="title">Number of Seats</label>
			  <span class="text-danger">*</span>
			  <input type="text"  name="seat" class="form-control"  id="seat">              
			  <?php echo form_error('seat'); ?>
			</div>


			<div class="form-group col-md-6">
			  <label for="title">Vehicle Category </label>
			  <span class="text-danger">*</span>
			  <select name="vehicle_type_category_id" class="form-control"  id="vehicle_type_category_id" required >
			  <option value=" ">Select Category</option>     
				<?php foreach($result as $category){ ?>
				   <option value="<?php echo $category->id; ?>" id="<?php echo $category->id; ?>"><?php echo $category->title; ?></option>     
				<?php } ?>            
			  </select>
			</div> 

			

			 
			
			
			<div class="form-group col-md-6">
			  <label for="title">Short Description</label>
			  <input type="text" name="short_description" class="form-control"  id="short_description">              
			  <?php echo form_error('short_description'); ?>
			</div>
		</div>	
		<div class="row">
		
			<h5 style="color:#fff">Add Fee</h5>
			<div class="form-group col-md-6">
			  <label for="title">Base Rate </label>
			  <span class="text-danger">*</span>
				<div class="input-group">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default">$</button> 
					</span>
					<!-- /btn-group -->
					<input type="number" name=" base_fare_fee" class="form-control"  id="base_fare_fee" value="<?php echo set_value('base_fare_fee'); ?>" step=".01">  
				</div>
				<?php echo form_error('base_fare_fee'); ?>
			</div>
			
			<div class="form-group col-md-6">
			  <label for="title"> Per Mile Rate</label>
			  <span class="text-danger">*</span>
			  <input type="number" name="rate" class="form-control"  id="rate" value="<?php echo set_value('rate'); ?>" step=".01">              
			  <?php echo form_error('rate'); ?>
			</div>

			<div class="form-group col-md-6">
			  <label for="title">Cancellation Rate</label>
			  <div class="input-group">				
				<span class="input-group-btn">
					<button type="button" class="btn btn-default">$</button> 
				</span>
				<input type="number" name=" cancellation_fee" class="form-control"  id="cancellation_fee" value="<?php echo set_value('cancellation_fee'); ?>" step=".01">
			  </div>
			  <?php echo form_error('cancellation_fee'); ?>
			</div>
			<div class="form-group col-md-6">
			  <label for="title">Taxes</label>
			  <span class="text-danger">*</span>
			  <div class="input-group">				
				<span class="input-group-btn">
					<button type="button" class="btn btn-default">%</button> 
				</span>
				<input type="number" name="taxes" class="form-control" step=".01"  id="taxes" value="<?php echo set_value('taxes'); ?>">              
				<?php echo form_error('taxes'); ?>
				</div>
			</div>
			<div class="form-group col-md-4">
			  <label for="title">Surcharge Rate</label>
			  <div class="input-group">				
				<span class="input-group-btn">
					<button type="button" class="btn btn-default">$</button> 
				</span>
			  <input type="number" name="surcharge_fee" class="form-control"  id="surcharge_fee" step=".01" value="<?php echo set_value('surcharge_fee'); ?>">
			 </div>              
			  <?php echo form_error('surcharge_fee'); ?>
			</div>
			
			<div class="form-group col-md-4">
				<label for="title">Pre-authorized amount</label>
				<span class="text-danger">*</span>
				<div class="input-group">				
					<span class="input-group-btn">
						<button type="button" class="btn btn-default">$</button> 
					</span>
				  <input type="number" name="hold_amount" class="form-control" step=".01"  id="hold_amount" value="<?php echo set_value('hold_amount'); ?>">
				</div>              
				 <?php echo form_error('hold_amount'); ?>
			</div>
			
			<div class="form-group col-md-4">
			  <label for="title">Admin Charges</label>
			  <div class="input-group">				
				<span class="input-group-btn">
					<button type="button" class="btn btn-default">%</button> 
				</span>
			  <input type="number" name="admin_charges" class="form-control" step=".01"  id="admin_charges">
			 </div>              
			  <?php echo form_error('admin_charges'); ?>
			</div>
			
			<div class="form-group col-md-6">
			  <label for="title">Status</label>
			  <span class="text-danger">*</span>
			  <select name="status" class="form-control"  id="status" required>
			  <option value="1">Active</option>
			  <option value="2">Inactive</option>            
			  </select>
			</div>
			
			<div class="form-group col-md-6">
			  <label for="title">Vehicle Image</label>
			  <span class="text-danger">*</span>
			  <input type="file" name="car_pic" class="form-control">              
			  <?php echo form_error('car_pic'); ?>
			</div>
			  

			<div class="form-group col-md-12">
			  <button type="submit" class="btn btn-gr" id="submit">Add</button>
			</div>
		</div>	
      </form>
    </div> 

  </div>

<script type="text/javascript">

  $(document).ready(function(){

    $(document).on('click','#submit',function(e){
    
      var title = $('#title').val();
      var vehicle_type_category_id = $('#vehicle_type_category_id').children(":selected").val();  
      var short_description = $('#short_description').val();
      var seat = $('#seat').val();
      var base_fare_fee = $('#base_fare_fee').val();
      var taxes = $('#taxes').val();
      var admin_charges = $('#admin_charges').val();
      var rate = $('#rate').val();
      var status = $('#status').val();
      var car_pic = $('#car_pic').val();
      //alert(vehicle_img);
      

      if (title=='') {
        $('#msg').html('<div class="alert alert-danger" role="alert">All the mandatory fields are required<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return false;
      }

      if (seat=='') {
        $('#msg').html('<div class="alert alert-danger" role="alert">Seat field is required<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return false;
      }
      

      if (base_fare_fee=='') {
        $('#msg').html('<div class="alert alert-danger" role="alert">Base Rate field is required<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return false;
      }
	  if (taxes=='') {
        $('#msg').html('<div class="alert alert-danger" role="alert">Tax field is required<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return false;
      }
	  if (admin_charges=='') {
        $('#msg').html('<div class="alert alert-danger" role="alert">Admin Charges is required<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return false;
      }
	  if (rate=='') {
        $('#msg').html('<div class="alert alert-danger" role="alert">Per mile Rate field is required<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return false;
      }
      if (short_description=='') {
        $('#msg').html('<div class="alert alert-danger" role="alert">Short Description  is required<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return false;
      }
      if (vehicle_type_category_id=='') {
        $('#msg').html('<div class="alert alert-danger" role="alert">Vehicle type Category name is required<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return false;
      }
    
    });
    

  });

</script>