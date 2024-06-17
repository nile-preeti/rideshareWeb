<!-- All payout to a driver -->

<div aria-hidden="true" role="dialog" tabindex="-1" class="modal del-model fade" id="confirmdel">

    <div class="modal-dialog">

    <div class="modal-body">

        <div class="modal-content-text">

            <h2>Are you sure you want to delete the User?</h2>

            <button type="button" data-dismiss="modal" class="btn btn-re" id="delete">Delete</button>

            <button type="button" data-dismiss="modal" class="btn-cancel">Cancel</button>

        </div>

    </div>   

    </div>

</div>



<div aria-hidden="true" role="dialog" tabindex="-1" class="modal oc-model fade" id="confirm">

 <div class="modal-dialog">

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

                         <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Payout </h3></div>

                     </div>

                 </div>

                 

                 <div class="panel-body ">

                      <?php $this->load->view('common/error'); ?>

                      

                         <div  class="search-filter">

                             <div class="row">

                                 <form action="<?= $this->config->base_url(). 'admin/payout_driver' ?>" method="get">
								 
                                 <div class="col-md-2 label-H">

                                     <label>Email Or Name</label>

                                     <input class="form-control" type="text" value="<?php echo !empty($filter_data['email']) ? $filter_data['email'] : ''; ?>" name="email"/>

                                 </div>
									<div class="col-md-2" style="margin-top:25px">
                                         <input type="submit" value="Search" class="btn btn-gr"/>
                                          <a href="<?php echo  $this->config->base_url() . 'admin/payout_driver' ?>" class="btn btn-re" ><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                     </div>
                                 </form>

                             </div>

                         </div>

                        

                         <div class="table-dashboard table-responsive">
							<table id="example" class="table display border">
								<thead>

                                     <tr>
                                         <th>S.No</th>

                                         <th>Name</th>

                                         <th>Mobile</th>

                                         <th>Email</th>

                                         <th>SSN</th>

                                         <!-- <th>Country</th>

                                         <th>State</th>

                                         <th>City</th>-->

                                         <th>Payout  status</th>

                                         <th>Status</th>

                                         <th>Current status</th>

                                         <th>Action</th>

                                        

                                     </tr>

                                 </thead>

                                 <tbody>

                                     <?php if (!empty($result)) {

                                         $i=1;

                                         foreach ($result as $val) { 
                                            
                                         $this->helper('common_helper');
                                     ?>

                                             <tr>
												<td><?= $i++; ?></td>

                                                 <td><?= $val->name ?></td>

                                                 <td><?= $val->mobile ?></td>

                                                 <td><?= $val->email ?></td>

                                                 <td><?= ($val->ssn)?$val->ssn:'N/A' ?></td>

                                                 

                                                 <?php $getlastRidedata = get_driver_ride_status($val->user_id); ?>
                                                  

                                                <?php
                                                if(count($getlastRidedata)>0){ ?>
                                                    <td><span id="span" class="label label-success" style="background-color:#228B22;color:white;">Payout is available </span></td>
                                                <?php }else{?>
                                                    <td><span id="span" class="label label-success" style="background-color:#ff0000;color:white;">Payout not available </span></td>
                                                <?php } ?>
                                                
                                               
                                               
                                                 <?php if($val->status == 1){?>

                                                 <td><span id="span" class="label label-success" style="background-color:#228B22 ;color:white;">Active</span></td>

                                                 <?php }else if($val->status == 2){ ?>

                                                 <td><span id="span" class="label label-success" style="background-color:red;color:white;">Deactive</span></td>

                                                <?php }else{ ?>

                                                 <td><span id="span" class="label label-success" style="background-color:#ff0000;color:white;">Pending driver</span></td>

                                                 <?php } ?>

                                                 <td><?php if($val->is_online == 1){?>

                                                     <span id="span" class="label label-success" style="background-color:#228B22;color:white;">Online</span>

                                                 <?php }else if($val->is_online==2){?>

                                                 <span id="span" class="label label-success" style="background-color:#f89c2c;color:white;">Busy in ride</span>

                                                 <?php }else{?>

                                                     <span id="span" class="label label-success" style="background-color:red;color:white;">Offline</span>

                                                 <?php } ?>

                                             </td>

                                                 <td style="white-space:nowrap"><span class="menu-action hiderow<?= $val->user_id ?>">

                                                     <a id="<?= $val->user_id ?>" data-original-title="edit_bankdetails" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow"> <i class="fa fa-eye"></i>  </a>
                                                     
                                                      <a href="<?= base_url('admin/payout/'.encrypt_decrypt('encrypt',$val->user_id)) ?>" data-original-title="Payout" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green"> <i class="fa fa-credit-card"></i></span></td>

                                             </tr>

                                             <?php

                                         }

                                     }else{ ?>
                                        <tr><td colspan="9" style="text-align:center"><h3>No record founds</h3></td></tr>
                                    <?php  }  ?>

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

