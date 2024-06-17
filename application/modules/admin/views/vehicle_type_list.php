<!-- list of vehicle type -->

<style type="text/css">

   .form-control{padding:6px 8px; }

    .vd_bg-grey{background-color: #3c485c !important;}

    .light-widget .panel-heading{margin-top: 12px;}

    .vd_panel-menu{position: absolute; top: 7px;}

    .form-control{font-size: 12px; height: 31px; padding: 5px 8px; height: 29px;}

    .btn {padding: 4px 15px; font-size: 12px;}

</style>

<div aria-hidden="true" role="dialog" tabindex="-1" class="modal del-model fade" id="confirmdel">

   <div class="modal-dialog">

		<div class="modal-body">
			<div class="modal-content-text">
				<p style="color:#fb8904">If you remove this category the vehicle subcategory automaticaly deleted which is listed in this category.</p>
				<h2 style="color:#fff">Are you sure to delete this Category? </h2>
				<button type="button" data-dismiss="modal" class="btn btn-re" id="delete">Delete</button>
				<button type="button" data-dismiss="modal" class="btn-cancel">Cancel</button>
			</div>
		</div>     

   </div>
</div>

<div aria-hidden="true" role="dialog" tabindex="-1" class="modal del-model fade" id="confirmdelsubcategory">

   <div class="modal-dialog">

		<div class="modal-body">
			<div class="modal-content-text">
				
				<h2 style="color:#fff">Are you sure to delete this subcategory? </h2>
				<button type="button" data-dismiss="modal" class="btn btn-re" id="delete">Delete</button>
				<button type="button" data-dismiss="modal" class="btn-cancel">Cancel</button>
			</div>
		</div>     

   </div>
</div>





<div aria-hidden="true" role="dialog" tabindex="-1" class="modal  oc-model fade" id="confirm">

    <div class="modal-dialog" >

        <div class="modal-body">

            <div class="" id="response"></div>

        </div>

    </div>

</div>

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

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> <?php echo $breadcrumb;?>  </h3></div>

                            <div class="col-md-6 text-right">

                                <a href="javascript:void(0);" class="btn btn-gr" id="vehicle_type" style="background-color:#fff8a6 !important; color:#000;">Add vehicle type</a>

                            </div>

                        </div>
                    </div>
                    <div class="panel-body">
                        <div  class="table-dashboard table-responsive"> 
                            <?php $this->load->view('common/error') ?>
                            <table id="example" class="table display border">
                                <thead>
                                    <tr>
                                        <th>Change sequence</th>
                                        <th>S.no</th>
                                        <th>Category type</th>
                                        <th>Category start year</th>
                                        <th>Category end year</th>
										<th>Short description</th>
                                        <th>Status</th>
                                        <th>Action</th>                                           
                                    </tr>
                                </thead>
                                <tbody id="row_position">
                                    <?php if ($types->num_rows()>0) {
										$this->helper('common_helper');                                
                                     
                                        $i=1;
                                       foreach ($types->result() as $row) {
									   $year_list = vehicle_category_year($row->id);
									   
									   $first = ($year_list?reset($year_list):"N/A");$last  = ($year_list?end($year_list):"N/A");
									    ?>
                                        <tr class="tableRow" data-id="<?php echo $row->id; ?>" >
                                            <td><img src="<?php echo base_url('uploads/arrows.png'); ?>"></td>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $row->title;?></td>
											<td><?php echo $first->category_year; ?></td>
                                            <td><?php echo $last->category_year; ?></td>
                                            <td><?php echo ($row->short_description)?$row->short_description:'N/A';?></td>
                                            
                                            <td><?= $row->status == 1 ? '<span id="span" class="label label-success" style="background-color:#fb8904;color:white;">Active</span>' : '<span id="span" class="label label-success" style="background-color:red;color:white;">Deactive</span>'; ?></td>
                                            <td style="white-space: nowrap;">
                                                <span class="menu-action hiderow<?= $row->id ?>">
                                                    <a  data-original-title="edit" href="<?php echo base_url('admin/edit_vehicle_category/'.$row->id);?>" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow"> <i class="fa fa-pencil"></i> </a> 
                                                    <a id="<?= $row->id ?>" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a> 
                                                </span>	
                                            </td>
                                        </tr>
                                    <?php }

                                    }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
            </div>



            <div class="vd_content-section clearfix">
                <div class="panel widget oc-panel light-widget">
                   <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Vehicle subcategory list</h3></div>
                            <div class="col-md-6 text-right">
                                <a href="javascript:void(0);" class="btn btn-gr" style="background-color:#fff8a6 !important; color:#000;" id="vehicle_subcategory_type">Add vehicle subcategory</a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div  class="table-dashboard table-responsive">                            
                            <table id="example" class="table display border">
                                <thead>
                                    <tr>
                                        <th>Change sequence</th>
                                        <th>S.No</th>
                                        <th>Vehicle name</th>
                                        <th>Category type</th>                                        
                                        <th>Base rate </th>   
                                        <th>Rates per mile </th>   
                                        <th>Taxes </th>   
                                        <th>Surcharge rate </th>   
                                        
                                        <th>Waiting rate<br>(Per min.)</th>
                                        <th>Admin charges(%)</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>                                            
                                    </tr>
                                </thead>
                                <tbody id="row_positionsubcategory">
                                    <?php if ($vhecile->num_rows()>0) {
                                        $i=1;
                                       foreach ($vhecile->result() as $row) {?>
                                      <!--?php print_r($row); die; ?-->
                                    <tr class="tableRowsubcategory" data-id="<?php echo $row->id; ?>" >
                                        <td><img src="<?php echo base_url('uploads/arrows.png'); ?>"></td>
                                        <td><?php echo $i++;?></td>
                                        
                                        <td><?php echo $row->title; ?></td>
                                        <?php foreach ($types->result() as $type) {
                                         if($type->id==$row->vehicle_type_category_id){ ?>
                                            <td><?php echo $type->title;?></td>  
                                        <?php } }?>
                                        <td><?php echo '$'.' '.$row->base_fare_fee ?></td>
                                        
                                        <td><?php echo '$'.' '.$row->rate ?></td>
                                        <td><?php echo '%'.' '.$row->taxes ?></td>
                                        <td><?php echo '$'.' '.$row->surcharge_fee ?></td>
                                        <?php $waitCharge =$row->base_fare_fee/60; ?>
                                        <td><?php echo '$'.' '.number_format($waitCharge,2); ?></td>
                                        <td><?php echo '%'.' '.$row->admin_charges; ?></td>
                                        <td><img src="<?php echo base_url('uploads/vehicle_image/'). $row->car_pic; ?>" width="60px"></td>
                                        <td><?= $row->status == 1 ? '<span id="span" class="label label-success" style="background-color:#fb8904;color:white;">Active</span>' : '<span id="span" class="label label-success" style="background-color:red;color:white;">Deactive</span>'; ?></td>
                                        <td>
											<span class="menu-action hiderow<?= $row->id ?>" style="display:flex">
												<a  data-original-title="edit" href="<?php echo base_url('admin/edit_vehicle_subcategory/'.$row->id);?>" data-toggle="tooltip" data-placement="top" class="btnaction  btn menu-icon vd_bd-yellow vd_yellow"> <i class="fa fa-pencil"></i> </a> 
												<a id="<?= $row->id ?>" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="subcategory_delete btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
											</span>
										</td>
                                    </tr>
                                    <?php } } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<!-- Modal -->



<div aria-hidden="true" role="dialog" tabindex="-1" class="modal oc-modal fade" id="vehicle_type_model">
    <div class="modal-dialog" >
        <div class="modal-body">
            <div class="vehicle_type_model" ></div>
        </div>
    </div>
</div>

<div aria-hidden="true" role="dialog" tabindex="-1" class="modal oc-modal fade" id="vehicle_subcategory_model">
    <div class="modal-dialog" >
        <div class="modal-body">
            <div class="vehicle_subcategory_model" ></div>
        </div>
    </div>
</div>

<script>
		$(function () {
				$("#table").DataTable();

				$("#row_position").sortable({
					items: "tr",
					cursor: 'move',
					opacity: 0.6,
					update: function() {
						sendOrderToServer();
					}
				});

				function sendOrderToServer() {

					var order = [];
					

					$('tr.tableRow').each(function(index,element) {
						order.push({
							id: $(this).attr('data-id'),
							position: index+1
						});
					});

					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: base_url+'admin/update_menu_order',
						data: {order: order},
						success: function(response) {
                        //console.log(response.status);
							if (response.status ==200) {
								swal("Success!","Category list position change succesfully !", "success");
								 setTimeout(function(){// wait for 5 secs(2)
									location.reload(); // then reload the page.(3)
								 }, 2000);
							} else {
								console.log(response);
							}
						}
					});
				}
			});




            $(function () {
				$("#table").DataTable();

				$("#row_positionsubcategory").sortable({
					items: "tr",
					cursor: 'move',
					opacity: 0.6,
					update: function() {
						sendOrderToServer();
					}
				});

				function sendOrderToServer() {
					var order = [];				

					$('tr.tableRowsubcategory').each(function(index,element) {
						order.push({
							id: $(this).attr('data-id'),
							position: index+1
						});
					});
//console.log(order);
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url:base_url+'admin/update_subcategory_order',
						data: {order: order},
						success: function(response) {
							if (response.status == 200) {
								swal("Success!", "Subcategory list position change succesfully !", "success");
								 setTimeout(function(){// wait for 5 secs(2)
									location.reload(); // then reload the page.(3)
								 },2000);
							} else {
								console.log(response);
							}
						}
					});
				}
			});
	</script>