<!-- All Users details  -->

<div aria-hidden="true" role="dialog" tabindex="-1" class="modal del-model fade" id="confrecover">

   <div class="modal-dialog">

      <div class="modal-body">

         <div class="modal-content-text">

            <h2 style="color:#fff">Are you sure want to recover  this rider account  ?</h2>

            <button type="button" data-dismiss="modal" class="btn btn-re" id="recover">Recover</button>

           <button type="button" data-dismiss="modal" class="btn-cancel">Cancel</button>
         </div>
      </div>

   </div>

</div>


<div aria-hidden="true" role="dialog" tabindex="-1" class="modal del-model fade" id="confirmdel">

   <div class="modal-dialog">

      <div class="modal-body">

         <div class="modal-content-text">

            <h2 style="color:#fff">Are you sure want to delete this rider ?</h2>

            <button type="button" data-dismiss="modal" class="btn btn-re" id="delete">Delete</button>

           <button type="button" data-dismiss="modal" class="btn-cancel">Cancel</button>
         </div>
      </div>

   </div>

</div>

<div aria-hidden="true" role="dialog" tabindex="-1" class="modal del-model fade" id="confirmdeldelete">

   <div class="modal-dialog">

      <div class="modal-body">

         <div class="modal-content-text">

            <h2 style="color:#fff">your account and rides data will be permanently delete from the system ?</h2>

            <button type="button" data-dismiss="modal" class="btn btn-re" id="deleteall">Delete</button>

           <button type="button" data-dismiss="modal" class="btn-cancel">Cancel</button>
         </div>
      </div>

   </div>

</div>

<div aria-hidden="true" role="dialog" tabindex="-1" class="modal oc-modal fade" id="confirm">

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

                  <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button  menu"> <i class="fa fa-arrows-h"></i> </div>

                  <div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu "> <i class="fa fa-arrows-v"></i> </div>

                  <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu"> <i class="glyphicon glyphicon-fullscreen"></i> </div>

               </div>

            </div>

         </div>

         <div class="vd_content-section clearfix">

            <div class="panel widget oc-panel light-widget">

               <div class="panel-heading">

                  <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Riders </h3>

               </div>

               

                  

               

               <div class="panel-body">
                     <?php $this->load->view('common/error');?>
                     <div  class="search-filter">

                        <div class="row">

                           <form action="<?= $this->config->base_url() . 'admin/riders' ?>" method="get">

                              <div class="col-md-2 label-H">

                                 <label>Search from email or name</label>

                                 <input class="form-control" type="text" value="<?php echo!empty($filter_data['email']) ? $filter_data['email'] : ''; ?>" name="email"/>

                              </div>

                              <div class="col-md-2 label-H">

                                 <label>Country</label>

                                 <input class="form-control" type="text" value="<?php echo!empty($filter_data['country']) ? $filter_data['country'] : ''; ?>" name="country"/>

                              </div>

                              <div class="col-md-2 label-H">

                                 <label>State</label>

                                 <input class="form-control" type="text" value="<?php echo!empty($filter_data['state']) ? $filter_data['state'] : ''; ?>" name="state"/>

                              </div>

                              <div class="col-md-2 label-H">

                                 <label>City</label>

                                 <input class="form-control" type="text" value="<?php echo!empty($filter_data['city']) ? $filter_data['city'] : ''; ?>" name="city"/>

                              </div>

                              <div class="col-md-2 label-H">

                                 <label>Status</label>

                                 <select class="form-control" name="status">

                                    <option value="">Select</option>

                                    <option <?php echo!empty($filter_data['status']) ? $filter_data['status'] == '1' ? 'selected' : '' : ''; ?>  value="1">Active</option>

                                    <option <?php echo isset($filter_data['status']) ? $filter_data['status'] == '4' ? 'selected' : '' : ''; ?>  value="4">Inactive</option>

                                 </select>

                              </div>

                              <div class="col-md-2 mt-25">
                                 <input type="submit" value="Search" class="btn btn-gr"/>

                                 <a style="margin-left:5px" href="<?= $this->config->base_url() . 'admin/riders' ?>" class="btn btn-re" ><i class="fa fa-refresh" aria-hidden="true"></i></a>

                              </div>

                              

                           </form>

                        </div>

                     </div>

                     <div  class="table-dashboard table-responsive">

                        <table id="example" class="table display border">

                           <thead>

                              <tr>

                                

                                 <th>Name</th>                                 

                                 <th>Mobile</th>

                                 <th>Email</th>
                                 <th>Ratings</th>

                                 <th>Country</th>

                                 <th>State</th>

                                 <th>City</th>

                                 <th>Status</th>

                                 <th>Login status</th>

                                 <th>Action</th>

                                 

                              </tr>

                           </thead>

                           <tbody>

                              <?php

                                 if (!empty($result)) {
									      $this->helper('common_helper');
									foreach ($result as $val) {
									  //print_r($val);
										$this->helper('common_helper');
										$reting = get_Rider_retings($val->user_id);
										$ridedata = getriderrides($val->user_id);
										//print_r($$val);
										
								?>
						
                              <tr>
							  
                                 <?php $lastName=($val->last_name)?$val->last_name:''; ?>
                                    <td><a href="<?= $this->config->base_url() ?>admin/riders_ride/<?= $val->user_id ?>"><?php echo  $val->name.' '.$lastName ?></a></td>
                              <?php if($val->country_code){
                                 $country_code=$val->country_code.'-';
                                 }else{
                                 $country_code='';
                                 }
                              ?>
                                <td><?php echo $country_code. phoneusformat($val->mobile); ?></td>

                                <td><?= $val->email ?></td>
								         <td><?= number_format($reting[0]->rating,1) ?></td>
                                 <td><?= ucfirst($val->country) ?></td>

                                 <td><?= ucfirst($val->state) ?></td>

                                 <td><?= ucfirst($val->city) ?></td>

									<!--?= $val->status == 1 ? '<span id="span" class="label label-success">Active</span>' : '<span id="span" class="label label-Deactive">Inactive</span>'; ?-->
									
									<?php if($val->status == 1 && $val->is_deleted != 1){?>

										<td><span id="span" class="label label-success" style="background-color:#fb8904 ;color:white;">Active</span></td>

										<?php }else if($val->is_deleted == 1){ ?>

										<td><span id="span" class="label label-success" style="background-color:red;color:white;">Tempreary deleted</span></td>
										<?php }else{ ?>

										<td><span id="span" class="label label-success" style="background-color:red;color:white;">Inactive</span></td>

										<?php } ?>
								
								

                                <td><?= $val->is_logged_in == 1 ? '<a data-original-title="Click to Logged Out" data-toggle="tooltip" data-placement="top" href="'.base_url('admin/logout_driver_user/'.encrypt_decrypt('encrypt',$val->user_id).'/1').'"><span id="span" class="label label-success label-Loggedin" >Logged-in</span></a>' : '<span id="span" class="label label-Loggedout">Logged-out</span>'; ?></td>

                                <td style="white-space: nowrap;"><span class="menu-action hiderow<?= $val->user_id ?>"><a id="<?= $val->user_id ?>" data-original-title="change_password" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon  vd_bd-yellow vd_yellow"> <i class="fa fa-key"></i> </a> 
								
								<a id="<?= $val->user_id ?>" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon  vd_bd-yellow vd_yellow"> <i class="fa fa-pencil"></i> </a>
								<?php if($val->is_deleted !=1){ ?>
									<a id="<?= $val->user_id ?>" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
								<?php }else{ ?>
									<?php if($ridedata[0]->ride_id > 0){ ?>
										<a id="<?= $val->user_id ?>" data-original-title="recover_account" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-refresh"></i> </a>
									<?php }else{?>
										<a id="<?= $val->user_id ?>" data-original-title="recover_account" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-refresh"></i> </a>
										<a id="<?= $val->user_id ?>" data-original-title="permanently_delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
										
									<?php  } ?>
									
								
								<?php } ?>
								
								</span></td>

                              </tr>

                              <?php

                                 }

                                 }else{?>
                                 <tr><td colspan="9" style="text-align:center"><h3>No record founds</h3></td></tr>
                                <?php  } ?>

                           </tbody>

                        </table>

                        <?= !empty($links) ? $links : ''; ?>

                     </div>

               </div>

            </div>

         </div>

      </div>

   </div>

</div>