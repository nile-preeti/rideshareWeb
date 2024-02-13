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









    .vd_bg-grey{background-color: #3c485c !important;}



    .light-widget .panel-heading{margin-top: 12px;}



    .vd_panel-menu{position: absolute; top: 7px;}



    .form-control{font-size: 12px; height: 31px; padding: 5px 8px; height: 29px;}



    .btn {padding: 4px 15px; font-size: 12px;}











    .pagination{margin: 0px 20px 0px;}



    .dataTables_paginate.paging_bootstrap{text-align: right;}







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



            <div class="vd_content-section clearfix">

               <div class="panel widget oc-panel light-widget">

                   <div class="panel-heading">

                        <div class="row">

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Payout </h3></div>

                            <div class="col-md-6 text-right">

                                <a class="btn btn-gr" href="<?php echo base_url('admin/payout_driver')?>">Back</a>

                            </div>

                        </div>

                    </div>

                

                    <div class="panel-body">

                        <div class="panel widget">

                            <!--div  class="search-filter">

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

                                    </div> >

                                    <div class="col-md-2 label-H">

                                       <label>From date</label>

                                        <input class="form-control" type="text" value="<?php echo!empty($filter_data['from']) ? $filter_data['from'] : ''; ?>" name="from" autocomplete="off" />

                                    </div>



                                    <div class="col-md-2 label-H">

                                       <label>To date</label>

                                        <input class="form-control" type="text" value="<?php echo!empty($filter_data['to']) ? $filter_data['to'] : ''; ?>" name="to" autocomplete="off"/>

                                    </div>



                                    <div class="col-md-2" style="margin-top:25px">

                                       <input type="submit" value="Search" class="btn btn-gr"/>

                                       <a style="margin-left:5px" href="<?= $this->config->base_url() . 'admin/payout' ?>" class="btn btn-re" ><i class="fa fa-refresh" aria-hidden="true"></i></a>

                                       <?php if(isset($filter_data['driver_id'])){?>

                                            <a style="margin-left:5px;background: #ecfdd2;color:#008000" href="<?= $url.'&export=true' ?>" class="btn btn-re" ><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>

                                         <?php }else{ ?>

                                            <a style="margin-left:5px;background: #ecfdd2;color:#008000" href="#" class="btn btn-re" ><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>

                                        <?php }?>
                                    </div>

                                 </form>

                               </div>

                            </div-->
                        
                        <div class="white-box">
                           
                            <?php if($vendorsdata && count($vendorsdata)>0){ 
                            $i=1;
                            $j=0;
                            ?>
                            
                            <?php foreach($vendorsdata as $list) : ?>
                            <?php $i++; ?>
                            
                            <?php 
                                $this->helper('common_helper');
                                $week=$list->week;
                                $year=$list->year;
                                $pay_details = get_payout_list($driver_id,$week,$year);
                            
                            if($list->total_paid_amount){ ?>
                            
                           

                            <div class="report-sale-accordion-item">
                                <div class="report-sale-head"><!-- data-toggle="collapse" href="#collapse<?php// echo $i; ?>"> onClick="event.stopPropagation();"-->
                                    <div class="report-sale-date">
                                        <?php 
                                        $weekname  = $list->week;
                                        
                                        ?>
                                        <p>Week: <?php echo $weekname.' /'. $list->year; ?></p>
                                    </div>
                                    <div class="report-sale-total">
                                        <?php 
                                            $total=$list->total_paid_amount;
                                            $tip_amount=$list->total_tip_amount;
                                            $admin_charge=20;
                                            $admin_fee=($total*$admin_charge)/100;
                                           $subtotal =$total - $admin_fee;
                                        ?>
                                        <?php $total_amount = 0;



                                         $total_payout_amount=0;



                                         
                                         
                                    
                                    // foreach ($pay_details as $val){ 
                                     
                                      // $total_amount+=$val->amount; 
                                      // $day= strtolower(date('l',strtotime($val->ride_date)));
                             
                                       // $payout_amount = (($val->amount*(100-$rate_detail->$day))/100); 
                                       // $total_payout_amount+=$payout_amount+$val->tip_amount;
                                    // }
                                    ?>
                                          
                                       
                                        <table class="tabletitle table-bordered">
                                          <tr>
                                            <th rowspan="2">Payout total:</th>
                                            <th>Subtotal: </th>
                                            <th>Admin Fee: </th>
                                            <th>payable Amt: </th>
                                          </tr>
                                          <tr>
                                            <td> <?php echo $total; ?></td>
                                            <td> <?php echo $admin_fee; ?></td>
                                            <td> <?php echo $subtotal+$tip_amount; ?></td>
                                          </tr>
                                        </table>
                                    </div>
                                    <?php
                                    $accepet=1;
                                    $notaccepet=2;
                                   // print_r($vendorpayRequest);die;
                                    //print_r($vendorpayRequest[0]->vendor_accountstripe_id);die;
                                    if(!empty($vendorpayRequest) && count($vendorpayRequest)>0){
                                    if(!empty($vendorpayRequest[$j]->request_payout_status)){
                                    ?>  
                                    <div class="report-sale-action">
                                        <?php 
                                            $pId=$vendorpayRequest[$j]->payout_id;
                                            
                                        ?>
                                        <?php if($vendorpayRequest[$j]->request_payout_status==1 && $vendorpayRequest[$j]->payment_status==1 && $vendorpayRequest[$j]->status_byadmin==1 ){ ?>
                                            <div class="transaction_id"><strong>TXN Id:</strong><?php echo $vendorpayRequest[$j]->transaction_id; ?></div>

                                            <a href="#" class="btn-AmountPaid">Amount Paid</a>
                                            
                                        <?php }else if($vendorpayRequest[$j]->request_payout_status==1 && $vendorpayRequest[$j]->status_byadmin==0 ){ ?>
                                            <p class="Payout-Request-title">Payout Request</p>
                                            <a href="<?php echo site_url('admin/users/vendorReqStatus_update'); ?>/<?php echo $pId; ?>/<?php echo $notaccepet; ?>" class="btn-cancel cancel">Cancel</a> 
                                            <a class="btn-Accept" href="<?php echo site_url('admin/users/vendorReqStatus_update'); ?>/<?php echo $pId; ?>/<?php echo $accepet; ?>">Accept</a>
                                            
                                        <?php }else if($vendorpayRequest[$j]->request_payout_status==1 && $vendorpayRequest[$j]->status_byadmin==1 ){ ?>
                                            <a class="btn-Accepted">Accepted</a> 
                                            <a class="btn-Make-Payout" href="#" id="button">Make Payout</a>
                                        <?php }else if($vendorpayRequest[$j]->status_byadmin==2){ ?>
                                                <a href="#" class="btn-deinied">Denied</a> 
                                        <?php }else{ ?>
                                            <a class="Payout-btn" href="#">Payout</a>
                                        <?php } ?>
                                    </div>
                                    <?php }else{ ?>
                                        <div class="report-sale-action">
                                            <a class="Payout-btn" href="#">Payout</a>
                                        </div>
                                    <?php }}else{ ?>
                                         <div class="report-sale-action">
                                            <a class="Payout-btn" href="#">Payout</a>
                                         </div>
                                         <?php } ?>

                                    <div class="report-sale-action-accordion"  data-toggle="collapse" href="#collapse<?php echo $i; ?>"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                    
                                </div>
                                
                                
                                <div class="collapse" id="collapse<?php echo $i; ?>" >
                                  <div class="report-sale-accordion-card table-responsive">
                                    <table class="table table-hover text-nowrap  dataTable no-footer" id="data-table" role="grid">
                                        <thead>
                                            <tr>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80.8125px;">Name</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 75.4688px;">Email</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Mobile No</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Ride date</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Customer name</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Ride Amount($)</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Tip Amount($)</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Percentage</th>
                                                
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 71.6719px;">Payout Amount($)</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <?php 
                                        //print_r($pay_details);die;
                                           $rate_detail =get_payout_amount();
                                           foreach($pay_details as $ordrList ):
                                           
                                            
                                              $total_amount+=$ordrList->amount; 
                                              $day= strtolower(date('l',strtotime($ordrList->ride_date)));
                                            
                                            $payout_amount = (($ordrList->amount*(100-$rate_detail->$day))/100); 
                                            $total_payout_amount+=$payout_amount+$ordrList->tip_amount;
                                        ?>
                                        
                                            <tr role="row" class="odd">
                                                <td><?php echo $ordrList->driver_name; ?></td>
                                                <td><?php echo $ordrList->driver_email; ?></td>
                                                <td><?php echo $ordrList->driver_mobile; ?></td>
                                                <td><?php echo date('M d Y',strtotime($ordrList->ride_date))  ?></td>
                                                <td><?php echo $ordrList->user_name; ?></td>
                                                <td><?= number_format((float) ($ordrList->amount), 2, '.', '') ?></td>

                                                <td><?= number_format((float) ($ordrList->tip_amount), 2, '.', '') ?></td>
                                                
                                                <td><?= $rate_detail->$day.'%' ?></td>
                                                <td><?= number_format((float) ($payout_amount), 2, '.', '') ?></td>
                                                    
                                            </tr>
                                        <?php  endforeach; ?>
                                        </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                            <?php  $j++; } endforeach; }else{ ?>
                            <div class="card" style="margin-top:50px">
                              <div class="card-body"><h3 class="text-center">There is no Booking available for this Driver!</h3></div>
                            </div>
                           <?php } ?> 
                        </div>
                    </div>



                </div>



            </div>







        </div>



    </div>



</div>

<style type="text/css">
    .report-sale-head {
    display: flex;
    align-items: center;
    padding: 10px 10px 10px 10px;
    margin-bottom: 1rem;
    position: relative;
    border-radius: 5px;
    /* box-shadow: 0px 8px 13px rgb(0 0 0 / 5%); */
    background:#ecfdd2;/*
    border: 1px solid #eeeeee;justify-content: space-between;*/
}

.report-sale-date {flex: 0 0 auto; width: 15%; } 
.report-sale-total{flex: 0 0 auto; width:45%;}
.report-sale-action-accordion{flex: 0 0 auto; width:5%;}
.report-sale-action{flex: 0 0 auto; width:35%; padding-left: 20px;}
/* .report-sale-head:before {content: "\f107"; font-family: "FontAwesome"; font-weight: 900; padding: 0px; color: #444444; float: right; position: absolute; right: 15px; font-size: 24px; top: 12px; transition: .5s all ease-out; transform: rotate(360deg); }
*/
/*.report-sale-head.collapsed:before {content: "\f107"; transition: .5s all ease-out; transform: rotate(180deg); top:12px; right: 15px; }
*/

.report-sale-action-accordion i {
    font-size: 32px;
    transition: .5s all ease-out;
    transform: rotate(360deg);
    width: 40px; 
    height: 40px;
    text-align: center;
    line-height: 40px; 
    cursor: pointer;
}
.report-sale-head .report-sale-action-accordion.collapsed i{transition: .5s all ease-out; transform: rotate(180deg);}

.tabletitle {width: 100%;}


p.Payout-Request-title {
    color: #313131;
    margin: 0 0 5px 0;
    font-size: 13px;
    font-weight: 500;
    line-height: normal;
    text-transform: uppercase;
}

.report-sale-total h2{
    color: #4b4d52;
    font-weight: 500;
    font-size: 14px;
    margin: 0;
    padding: 0;
    line-height: normal;
}
.report-sale-total p {
   color: #8f97b2;
    font-weight: 500;
    font-size: 14px;
    margin-bottom: 0;
    padding: 0;
}
.report-sale-date h2{
   color: #4b4d52;
    font-weight: 500;
    font-size: 14px;
    margin: 0;
    padding: 0;
    line-height: normal;
}
.report-sale-date p {
   color: #8f97b2;
    font-weight: 500;
    font-size: 14px;
    margin-bottom: 0;
    padding: 0;
}
.report-sale-accordion-card{background: #fff;
    border-radius: 5px;
    position: relative;
    border: 1px solid #eeeeee;
    padding: 1rem;margin-bottom: 10px;}
.report-sale-accordion-card table.dataTable{margin-top: 0;}
.tabletitle tr th,td{
    padding:5px 10px;
}
.btn-deinied{
    
    background-color:#d88109;
    color:#fff;
    padding:5px 15px;
}

a.btn-AmountPaid {background: #6fbf17;font-size: 13px;font-weight: 500;  padding: 6px 15px; border-radius: 3px; display: inline-block; color: #fff; position: relative; outline: none; border: none; box-shadow: none; }
a.btn-deinied {background-color: #d88109;font-size: 13px;font-weight: 500;  color: #fff; padding: 6px 15px; border-radius: 3px; display: inline-block; position: relative; outline: none; border: none; box-shadow: none; }

a.Payout-btn {background: #81bd19; font-size: 13px; color: #fff; font-weight: 500; padding: 6px 15px; border-radius: 3px; display: inline-block; position: relative; outline: none; border: none; box-shadow: none; }

a.btn-cancel{background: #d9433e;font-size: 13px;font-weight: 500;  padding: 6px 15px; border-radius: 3px; display: inline-block; color: #fff; position: relative; outline: none; border: none; box-shadow: none; }
a.btn-Accept{background-color:#6fbf17;font-size: 13px;font-weight: 500;  color: #fff; padding: 6px 15px; border-radius: 3px; display: inline-block; position: relative; outline: none; border: none; box-shadow: none; }

a.btn-Make-Payout{background:#5b08c9;font-size: 13px;font-weight: 500;  padding: 6px 15px; border-radius: 3px; display: inline-block; color: #fff; position: relative; outline: none; border: none; box-shadow: none; }
a.btn-Accepted{background: #6fbf17;font-size: 13px;font-weight: 500;  padding: 6px 15px; border-radius: 3px; display: inline-block; color: #fff; position: relative; outline: none; border: none; box-shadow: none; }

.table.dataTable thead th {
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #81bd19 !important;
    padding: 8px !important;
    border-top: none;
    border-bottom: 1px solid #f6ffe8 !important;
}
.table.dataTable thead{
    background:#f6ffe8;
}
</style>

