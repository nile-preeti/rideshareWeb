0<!-- All rides details -->

<style>

    .fileUpload {

        position: relative;

        overflow: hidden;

        margin: 10px;

    }

    .fileUpload input.upload {

        position: absolute;

        top: 0;

        right: 0;

        margin: 0;

        padding: 0;

        font-size: 20px;

        cursor: pointer;

        opacity: 0;

        filter: alpha(opacity=0);

    }

    

    .vd_panel-menu{margin-right: 0px;}

    .vd_bg-grey{background-color: #3c485c !important;}

    .light-widget .panel-heading{margin-top: 12px;}

    .vd_panel-menu{position: absolute; top: 7px;}

    .form-control{font-size: 12px; height: 31px; padding: 5px 8px; height: 29px;}

    .btn {padding: 4px 15px; font-size: 12px}

    

</style>



<script>

    $(document).ready(function () {

        var msg = '<?php echo $this->session->userdata("msg"); ?>';

        var type = '<?php echo $this->session->userdata("type"); ?>';

        if (msg != "" && type != "") {

            if (type == "success") {

                var icon = "fa fa-check-circle vd_green";
            } else {
                var icon = "fa fa-exclamation-circle vd_red";
            }

            notification("topright", type, icon, type, msg);
            <?php echo $this->session->unset_userdata("msg"); ?>
            <?php echo $this->session->unset_userdata("type"); ?>

        }





        $(document).on('click', '.btnaction', function () {
            var action = $(this).attr('data-original-title');
            var id = $(this).attr('id');
            if (action == 'edit' || action == "view") {
                $.ajax({
                    type: 'post',

                    url: '<?php echo $this->config->base_url() ?>admin/getUser',

                    data: "user_id=" + id,

                    success: function (data) {

                        $("#confirm").modal("show");

                        $("#response").html(data);

                    }

                });

            }

            if (action == 'delete') {

                $('#confirmdel')

                        .modal('show', {backdrop: 'static', keyboard: false})

                        .one('click', '#delete', function (e) {

                            $.ajax({

                                type: 'post',

                                url: '<?php echo $this->config->base_url() ?>admin/users/delete',

                                data: "user_id=" + id,

                                success: function () {

                                    $('.hiderow' + id).closest('tr').hide();

                                }

                            });

                        });

            }

        });



    });

</script>

<div aria-hidden="true" role="dialog" tabindex="-1" class="modal fade" id="confirmdel" style="display: none;z-index: 2147483648">

    <div class="modal-dialog">

        <div class="modal-body">

            Are you sure want to delete!

        </div>

        <div class="modal-footer">

            <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>

            <button type="button" data-dismiss="modal" class="btn">Cancel</button>

        </div>

    </div>

</div>

<div aria-hidden="true" role="dialog" tabindex="-1" class="modal fade" id="confirm" style="display: none;z-index: 2147483648">

    <div class="modal-dialog" id="response">



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

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Rides </h3></div>

                        </div>

                    </div>

                

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                                <div class="row">

                                    <form action="<?= $this->config->base_url() . 'admin/getrides' ?>" method="get">



                                        <div class="col-md-2 label-H" >

                                            <label>Driver name</label>

                                            <input class="form-control" type="text" value="<?php echo!empty($filter_data['email']) ? $filter_data['email'] : ''; ?>" name="email"/>

                                        </div>

                                        <div class="col-md-2 label-H" >

                                            <label>Country</label>

                                            <input class="form-control" type="text" value="<?php echo!empty($filter_data['country']) ? $filter_data['country'] : ''; ?>" name="country"/>

                                        </div>

                                        <div class="col-md-2 label-H" >

                                            <label>State</label>

                                            <input class="form-control" type="text" value="<?php echo!empty($filter_data['state']) ? $filter_data['state'] : ''; ?>" name="state"/>

                                        </div>

                                        <div class="col-md-2 label-H" >

                                            <label>City</label>

                                            <input class="form-control" type="text" value="<?php echo!empty($filter_data['city']) ? $filter_data['city'] : ''; ?>" name="city"/>

                                        </div>



                                        <div class="col-md-2 label-H" >

                                            <label>Status</label>

                                            <select class="form-control" name="status">

                                                <option value="">Select</option>

                                                <option <?php echo!empty($filter_data['status']) ? $filter_data['status'] == 'ACCEPTED' ? 'selected' : '' : ''; ?>  value="ACCEPTED">Accepted</option>

                                                <option <?php echo!empty($filter_data['status']) ? $filter_data['status'] == 'COMPLETED' ? 'selected' : '' : ''; ?>  value="COMPLETED">Completed</option>

                                                <option <?php echo isset($filter_data['status']) ? $filter_data['status'] == 'PENDING' ? 'selected' : '' : ''; ?>  value="PENDING">Pending</option>

                                                <option <?php echo isset($filter_data['status']) ? $filter_data['status'] == 'CANCELLED' ? 'selected' : '' : ''; ?>  value="CANCELLED">Cancelled</option>

                                            </select>

                                        </div>

                                        <div class="col-md-2" style="margin-top:25px">

                                            <input type="submit" value="Search" class="btn btn-gr"/>

                                            <a style="margin-left:5px" href="<?= $this->config->base_url() . 'admin/getrides' ?>" class="btn btn-re" ><i class="fa fa-refresh" aria-hidden="true"></i></a>

                                        </div>

                                    </form>

                                </div>



                            </div>

                            

                            <div  class="table-dashboard table-responsive"> 

                                <table id="example" class="table display border">

                                    <thead>

                                        <tr>



                                            <th>Ride id</th>

                                            <th>Driver name</th>

                                            <th>Rider name</th> 

                                            <th style="min-width:180px">Pickup address</th>
                                            <th style="min-width:180px">Stop address</th>

                                            <th style="min-width:180px">Drop address</th>

                                            <th>Hold amount</th>

                                            

                                            <th>Ride amount</th>
                                            <th>Waiting charges</th>
											<th>Waiting time on pickup</th>
											<th>Waiting time on drop</th>
                                            <th>Refund amount</th>
                                            <th>Cancelation charges</th>
                                            <th>Payment status</th>

											<th>Date</th>

                                            <th>Status</th>

                                            <th>Action</th>



                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php
										//print_r($result); die; 
                                        if (!empty($result)) {

                                            //$i=1;

                                            foreach ($result as $val){

                                                ?>

                                                <tr>

                                                    <td><?php echo $val->ride_id; ?></td>

                                                    <td><?= $val->driver ?></td>

                                                    <td><?= $val->customer ?></td>

                                                    <td><?= $val->pickup_adress ?></td>
                                                    <td><?= ($val->midstop_address?$val->midstop_address:"N/A"); ?></td>

                                                    <td><?= $val->drop_address ?></td>

                                                    <td>$<?= $val->hold_amount ?></td> 
                                                    
                                                    <?php
													
                                                        $amount= ($val->rest_amount>=0? preg_replace('/[^0-9\.]/ui','',$val->amount):'0');
														
                                                        $pickup_charge=($val->waiting_charge_onpickup) ? ( preg_replace('/[^0-9\.]/ui','',$val->waiting_charge_onpickup)) : "0";
                                                        $drop_charge= ($val->waiting_charge_ondrop) ? (  preg_replace('/[^0-9\.]/ui','', $val->waiting_charge_ondrop)) : "0";
                                                        //$total_amt=$amount+$pickup_charge+$drop_charge 
                                                    ?>

                                                    <td>$<?= number_format($amount,2) ?></td>
                                                    <td>$<?= number_format($pickup_charge+$drop_charge,2) ?></td>
													
													<?php 
														$totalPickupTime = $val->total_waiting_time_onpickup;
														$totalDropTime = $val->total_waiting_time_ondrop;
														
														$this->load->helper('common_helper');
														if($totalPickupTime>0){ 			
														 $pickupTime1 = time_format(preg_replace('/[^0-9\.]/ui','',$val->total_waiting_time_onpickup));
														 }else{
															$pickupTime1="0";
														 }
														 if($totalDropTime>0){ 			
														 $dropTime1 = time_format(preg_replace('/[^0-9\.]/ui','',$val->total_waiting_time_ondrop));
														 }else{
															$dropTime1="0";
														 }
													?>
													<td><?php echo $pickupTime1; ?></td>
													<td><?php echo $dropTime1; ?></td>
                                                    <td>
													$<?= ($val->rest_amount>=0?$val->rest_amount:$val->hold_amount)  ?></td>
													
													
                                                    <td>$<?= ($val->status=="COMPLETED" ||$val->status =="CANCELLED"?$val->cancellation_charge:0)  ?></td>

                                                    <td><?= $val->payment_status ?></td>

													<!-- <td><?= $val->payment_mode ?></td> -->

                                                    <td><?=  date('M d Y',strtotime($val->time)) ?></td>

                                                    <td><?php if ($val->status == 'COMPLETED') { ?>

                                                            <span id="span" class="label label-success" style="background-color:#228B22; color:white;">COMPLETED</span>

                                                        <?php } else if ($val->status == 'CANCELLED') { ?>

                                                            <span id = "span" class = "label label-success" style = "background-color:red;color:white;">CANCELLED</span >

                                                            <?php

                                                        } else if ($val->status == 'ACCEPTED') {

                                                            ?>

                                                            <span id = "span" class = "label label-success" style = "color:white;">ACCEPTED</span >

                                                            <?php

                                                        }else if ($val->status == 'FAILED') {

                                                            ?>

                                                            <span id = "span" class = "label label-success" style = "background-color:red;color:white;">FAILED</span >

                                                            <?php

                                                        } else {

                                                            ?>

                                                            <span id = "span" class = "label label-success" style = "background-color:orange;color:white;">PENDING</span >

                                                        <?php }

                                                        ?></td>

                                                    <td><a type="button" class="btn btn-gr" href="<?= $this->config->base_url() ?>admin/map/<?= $val->ride_id ?>">View</a>

                                                       

                                                </tr>

                                                <?php

                                            }

                                        }else{?> 
                                            <tr><td colspan="14" style="text-align:center"><h3>No record found</h3></td></tr>
                                        <?php } ?>

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

</div>

