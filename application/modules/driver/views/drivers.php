<!-- add a new driver -->

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

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Drivers </h3></div>

                            <div class="col-md-6 text-right">

                               <!--  <a href="<?php echo base_url('admin/add_driver');?>" class="btn btn-gr">Add Driver</a> -->

                            </div>

                        </div>

                    </div>

                    

                    <div class="panel-body">

                         <?php $this->load->view('common/error');?>

                         

                            <div  class="search-filter">

                                <div class="row">

                                    <form action="<?= $this->config->base_url() . 'admin/drivers' ?>" method="get">



                                    <div class="col-md-2 label-H">

                                        <label>Email Or Name</label>

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

                                        <label>From date</label>

                                        <input class="form-control" type="text" value="<?php echo!empty($filter_data['from']) ? $filter_data['from'] : ''; ?>" name="from" autocomplete="off" />

                                    </div>

                                    <div class="col-md-2 label-H">

                                        <label>To date</label>

                                        <input class="form-control" type="text" value="<?php echo!empty($filter_data['to']) ? $filter_data['to'] : ''; ?>" name="to" autocomplete="off"/>

                                    </div>



                                        <div class="col-md-2 label-H">

                                            <label>Status</label>

                                            <select class="form-control" name="status">

                                                <option value="">Select</option>

                                                <option <?php echo!empty($filter_data['status']) ? $filter_data['status'] == '1' ? 'selected' : '' : ''; ?>  value="1">Active</option>

                                                <option <?php echo!empty($filter_data['status']) ? $filter_data['status'] == '3' ? 'selected' : '' : ''; ?>  value="3">Pending Driver </option>

                                                <option <?php echo isset($filter_data['status']) ? $filter_data['status'] == '4' ? 'selected' : '' : ''; ?>  value="4">Inactive</option>

                                            </select>

                                        </div>

                                        <div class="col-md-2" style="margin-top:25px">

                                            <input type="submit" value="Search" class="btn btn-gr"/>

                                                <a href="<?= $this->config->base_url() . 'admin/drivers' ?>" class="btn btn-re" ><i class="fa fa-refresh" aria-hidden="true"></i></a>

                                        </div>

                                        



                                    </form>

                                </div>



                            </div>

                           

                            <div  class="table-dashboard table-responsive">

                                <?php if($filter_data && isset($filter_data['status']) ){

                                    if($filter_data['status']==3){?>

                                        <a href="javascript:void(0)" class="btn btn-success" id="approved">Approve</a>

                                <?php } }?>

                                <table id="example" class="table display border">

                                    <thead>

                                        <tr>

                                        <?php if($filter_data && isset($filter_data['status']) ){

                                            if($filter_data['status']==3){?>

                                                <th><input type="checkbox" class="check" id="checkAll">All</th>

                                        <?php } }?>



                                            <th>S.No</th>

                                            <th>Name</th>

                                            <th>Mobile</th>

                                            <th>Email</th>

                                            <th>SSN</th>

                                            <th>Country</th>

                                            <th>State</th>

                                            <th>City</th>

                                            <th>Total Earning($)</th>

                                            <th>Registration date</th>

                                            <th>Status</th>
                                            <th>Login Status</th>
                                            <th>Current Status</th>

                                            <th>Action</th>

                                           

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php

                                        if (!empty($result)) {

                                            $i=1;

                                            foreach ($result as $val) {

                                                ?>

                                                <tr>

                                                    <?php if($filter_data && isset($filter_data['status']) ){

                                                    if($filter_data['status']==3){?>

                                                        <td><div class="unapproved"><label><input type="checkbox" class="check" name="approve[]" value="<?php echo $val->user_id;?>"></label></div></td>

                                                    <?php } }?>

                                                    <td><?= $i++; ?></td>

                                                    <td><?= $val->name ?></td>

                                                    <td><?= $val->mobile ?></td>

                                                    <td><?= $val->email ?></td>

                                                    <td><?= ($val->ssn)?$val->ssn:'N/A' ?></td>

                                                    <td><?= ucfirst($val->country) ?></td>

                                                    <td><?= ucfirst($val->state) ?></td>

                                                    <td><?= ucfirst($val->city) ?></td>

                                                    <td><?= ($val->earning_amount)?number_format($val->earning_amount,2):0 ?></td>

                                                    <td><?= date('M d Y',strtotime($val->created_date)) ?></td>

                                                    <?php if($val->status == 1){?>

                                                    <td><span id="span" class="label label-success" style="background-color:#81bd19 ;color:white;">Active</span></td>

                                                    <?php }else if($val->status == 2){ ?>

                                                    <td><span id="span" class="label label-success" style="background-color:red;color:white;">Deactive</span></td>

                                                    <?php }else{ ?>

                                                    <td><span id="span" class="label label-success" style="background-color:#f89c2c;color:white;">Pending Driver</span></td>

                                                    <?php } ?>
                                                    <td><?= $val->is_logged_in == 1 ? '<a data-original-title="Click to Logged Out" data-toggle="tooltip" data-placement="top" href="'.base_url('admin/logout_driver_user/'.encrypt_decrypt('encrypt',$val->user_id).'/2').'"><span id="span" class="label label-success" style="background-color:#8ec431;color:white;">Logged-in</span></a>' : '<span id="span" class="label label-success" style="background-color:red;color:white;">Logged-out</span>'; ?></td>
                                                    <td><?php if($val->is_online == 1){?>

                                                        <span id="span" class="label label-success" style="background-color:#81bd19 ;color:white;">Online</span>

                                                    <?php }else if($val->is_online==2){?>

                                                    <span id="span" class="label label-success" style="background-color:#f89c2c;color:white;">Busy in ride</span>

                                                    <?php }else{?>

                                                        <span id="span" class="label label-success" style="background-color:red;color:white;">Offline</span>

                                                    <?php } ?>

                                                    </td>
                                                    
                                                    <td style="white-space: nowrap;">
                                                        <span class="menu-action hiderow<?= $val->user_id ?>">

                                                        <!-- <a id="<?= $val->user_id ?>" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow"> <i class="fa fa-pencil"></i> </a> -->

                                                        <a id="<?= $val->user_id ?>" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction1 btn menu-icon vd_bd-yellow vd_yellow" href="<?php echo base_url('admin/update_driver/'.$val->user_id);?>"> <i class="fa fa-pencil"></i> </a> 

                                                        <a id="<?= $val->user_id ?>" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>

                                                        <a id="<?= $val->user_id ?>" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a></span></td>

                                                </tr>

                                                <?php

                                            }

                                        }

                                        ?>

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

