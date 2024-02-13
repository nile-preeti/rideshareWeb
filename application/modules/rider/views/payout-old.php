<!-- All payout details -->
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

   .vd_bg-grey {
      background-color: #3c485c !important;
   }
   .light-widget .panel-heading {
      margin-top: 12px;
   }
   .vd_panel-menu {
      position: absolute;
      top: 7px;
   }
   .form-control {
      font-size: 12px;
      height: 31px;
      padding: 5px 8px;
      height: 29px;
   }
   .btn {
      padding: 4px 15px;
      font-size: 12px;
   }
   .pagination {
      margin: 0px 20px 0px;
   }
   .dataTables_paginate.paging_bootstrap {
      text-align: right;
   }
</style>

<div class="vd_content-wrapper">
   <div class="vd_container">
      <div class="vd_content clearfix">
         <div class="vd_head-section clearfix">
            <div class="vd_panel-header">
               <div
                  class="vd_panel-menu hidden-sm hidden-xs"
                  data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code."
                  data-step="5"
                  data-position="left"
               >
                  <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu"><i class="fa fa-arrows-h"></i></div>

                  <div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu"><i class="fa fa-arrows-v"></i></div>
                  <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu">
                     <i class="glyphicon glyphicon-fullscreen"></i>
                  </div>
               </div>
            </div>
         </div>
         <div class="vd_content-section clearfix">
            <div class="panel widget oc-panel light-widget">
               <div class="panel-heading">
                  <div class="row">
                     <div class="col-md-6">
                        <h3 class="panel-title">
                           <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Payout
                        </h3>
                     </div>

                     <div class="col-md-6 text-right">
                        <a class="btn btn-gr" href="<?php echo base_url('admin/payout_driver')?>">Back</a>
                     </div>
                  </div>
               </div>

               <div class="panel-body">
                  <div class="panel widget">
                     <div class="search-filter">
                        <div class="row">
                           <form action="<?= $this->config->base_url() . 'admin/payout/'.$this->uri->segment(3) ?>" method="get">
                              <!-- <div class="col-md-2 label-H">

                                       <label>Driver Name</label>

                                       <input class="form-control" type="text" value="<?php echo!empty($filter_data['name']) ? $filter_data['name'] : ''; ?>" name="name"/>

                                    </div>

                                    <div class="col-md-2 label-H">

                                       <label>Driver Email</label>

                                       <input class="form-control" type="text" value="<?php echo!empty($filter_data['email']) ? $filter_data['email'] : ''; ?>" name="email"/>

                                    </div>

                                    <div class="col-md-2 label-H">

                                       <label>Mobile No</label>

                                       <input class="form-control" type="text" value="<?php echo!empty($filter_data['mobile_number']) ? $filter_data['mobile_number'] : ''; ?>" name="mobile_number"/>

                                    </div> -->

                              <div class="col-md-2 label-H">
                                 <label>From date</label>

                                 <input class="form-control" type="text" value="<?php echo!empty($filter_data['from']) ? $filter_data['from'] : ''; ?>" name="from" autocomplete="off" />
                              </div>

                              <div class="col-md-2 label-H">
                                 <label>To date</label>

                                 <input class="form-control" type="text" value="<?php echo!empty($filter_data['to']) ? $filter_data['to'] : ''; ?>" name="to" autocomplete="off" />
                              </div>

                              <div class="col-md-2" style="margin-top: 25px;">
                                 <input type="submit" value="Search" class="btn btn-gr" />

                                 <a style="margin-left: 5px;" href="<?= $this->config->base_url() . 'admin/payout' ?>" class="btn btn-re"><i class="fa fa-refresh" aria-hidden="true"></i></a>

                                 <?php if(isset($filter_data['driver_id'])){?>

                                 <a style="margin-left: 5px; background: #ecfdd2; color: #008000;" href="<?= $url.'&export=true' ?>" class="btn btn-re"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>

                                 <?php }else{ ?>

                                 <a style="margin-left: 5px; background: #ecfdd2; color: #008000;" href="#" class="btn btn-re"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>

                                 <?php }?>
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

                                 <th>Email</th>

                                 <th>Mobile No</th>

                                 <th>Ride date</th>

                                 <th>Customer name</th>

                                 <th>Ride Amount($)</th>

                                 <th>Tip Amount($)</th>

                                 <th>Percentage</th>

                                 <th>Payout Amount($)</th>

                                 <!-- <th>Txn Id</th>



                                            



                                            <th>Status</th> -->
                              </tr>
                           </thead>

                           <tbody>
                              <?php $total_amount = 0;



                                         $total_payout_amount=0;



                                        if ($result->num_rows()>0) { $count=1; $rate_detail =get_payout_amount(); foreach ($result->result() as $val) { $total_amount+=$val->amount; $day= strtolower(date('l',strtotime($val->ride_date)));
                              $payout_amount = (($val->amount*(100-$rate_detail->$day))/100); $total_payout_amount+=$payout_amount+$val->tip_amount; ?>

                              <tr>
                                 <td><?= $count++; ?></td>

                                 <td><?= $val->driver_name ?></td>

                                 <td><?= $val->driver_email ?></td>

                                 <td><?= $val->driver_mobile ?></td>

                                 <td><?= date('M d Y',strtotime($val->ride_date)) ?></td>

                                 <td><?= $val->user_name ?></td>

                                 <td><?= number_format((float) ($val->amount), 2, '.', '') ?></td>

                                 <td><?= number_format((float) ($val->tip_amount), 2, '.', '') ?></td>

                                 <td><?= $rate_detail->$day.'%' ?></td>

                                 <td><?= number_format((float) ($payout_amount), 2, '.', '') ?></td>

                                 <!-- <td><?= $val->txn_id ?></td>



                                                    <td><?= $val->payment_status ?></td> -->

                                 <!-- <td><button class="btn btn-primary btn-sm btnpay" id="<?= $val->user_id ?>">Pay</button></td> -->
                              </tr>

                              <?php



                                            }



                                        }



                                        ?>
                           </tbody>
                        </table>
                     </div>

                     <?php if ($result->num_rows()>0) {?>

                     <div class="row">
                        <div class="col-md-8"></div>

                        <div class="col-md-2"><b>Total Ride Amount($) :</b></div>

                        <div class="col-md-2">
                           <p>$<?= number_format((float) ($total_amount), 2, '.', '') ?></p>
                        </div>

                        <div class="col-md-7"></div>

                        <div class="col-md-3 text-right"><b>Total Payout Amount ($):-</b></div>

                        <div class="col-md-2">
                           <p>$<?= number_format((float) ($total_payout_amount), 2, '.', '') ?></p>

                           <p><a href="#" class="btn btn-gr">Pay</a></p>
                        </div>
                     </div>

                     <?php }?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
