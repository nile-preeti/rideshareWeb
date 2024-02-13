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
<div aria-hidden="true" role="dialog" tabindex="-1" class="modal del-model fade" id="confirmdel">
   <div class="modal-dialog">
      <div class="modal-body">
         <div class="modal-content-text">
            <h2 style="color:#fff">Are you sure you want to delete this driver?</h2>
            <button type="button" data-dismiss="modal" class="btn btn-re" id="btn_payout">Make Payment</button>
           <button type="button" data-dismiss="modal" class="btn-cancel">Cancel</button>
         </div>
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
                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> View Payment</h3></div>
                            <div class="col-md-6 text-right">
                                <a class="btn btn-gr" href="<?php echo base_url('admin/payout_driver')?>">Back</a>
                            </div>
                        </div>
                    </div>
                
                    <div class="panel-body">
                        <div class="panel widget">
                          
                        <div class="white-box">
							<!--?php $this->load->view('common/error');?-->
							<?php if ($this->session->flashdata('success_msg')){?> 
								<script type="text/javascript">
								  $(document).ready(function() {
								  swal({
									  icon: "success",
									  title: "Done",
									  text: "<?php echo $this->session->flashdata('success_msg'); ?>",
									  timer: 300000,
									  showConfirmButton: false,
									  type: 'success'
									  });
								  });
								</script>
							
							<?php }elseif($this->session->flashdata('error_msg')){ ?>
								<script type="text/javascript">
								  $(document).ready(function() {
								  swal({
									  icon: "error",
									  title: "Oops...",
									  text: "<?php echo $this->session->flashdata('error_msg'); ?>",
									  timer: 300000,
									  showConfirmButton: false,
									  type: 'error'
									  });
								  });
								</script>
							<?php }else{?>
								
							<?php } ?>				
  
							
							<?php 
							if($bankdata && !empty($bankdata->stripe_account_id) && ($bankdata->stripe_onboarding==1) ){
								//	echo "Authorized Stripe Account and Applicable for Payout";
							?>
							
							<?php
							}else{
								echo "<div class='alert alert-danger text-center' role='alert'><a href='".base_url('admin/stripe_authorize/'.$driver_id)."' class='btn btn-sm Payout-btn'>Click here to setup driver's payout account</a></div>";
							}
							?>
                           
                            <?php if($vendorsdata && count($vendorsdata)>0){ 
                            $i=1;
                            $j=0;
                             foreach($vendorsdata as $list) :
                             
                              //print_r($list);
							   $i++;
                            ?>
                            
                            <?php 
                                $this->helper('common_helper');
                                $week=$list->week;
                                $year=$list->year;
                                $pay_details = get_payout_list($driver_id,$week,$year);
                               // echo "<pre>";
                                // print_r($pay_details);die;
                                 
                                                             
                            if($list->total_paid_amount){ ?>
                                 <?php  //echo $list->total_paid_amount; ?>     

                            <div class="report-sale-accordion-item">
                                <div class="report-sale-head"><!-- data-toggle="collapse" href="#collapse<?php// echo $i; ?>"> onClick="event.stopPropagation();"-->
                                    <div class="report-sale-date">
                                        <?php 
                                        $weekname  = $list->week;
                                        $payoutweek=$weekname.' /'. $list->year;
                                        $payoutweek1=$week.'-'.$year;
                                        ?>
                                        <p>Week: <?php echo $payoutweek; ?></p>
                                    </div>
                                    <div class="report-sale-total">
                                        <?php 
                                         
											$rate_detail1 =get_payout_amount();
											 $sumval=0;
                                            $paidsum=0;                                           
                                            $total_amount=0;
											$admin_fee=0;
                                           foreach($pay_details as $paylist ):
                                          
                                           // $tip_amount+=$paylist->tip_amount;
                                              $total_amount = $list->total_paid_amount; 
                                              $day= strtolower(date('l',strtotime($paylist->ride_date)));
                                           
											$admin_fee = (($paylist->amount*($paylist->AdminRide_charges))/100);
											$paidsum+= $admin_fee;
											$admin_charges = $total_amount-$paidsum;
										?>
									
                                    <?php  endforeach;  ?>                                          
                                       
                                        <table class="tabletitle table-bordered">
                                          <tr>
                                            <th rowspan="2">Payout Total:</th>
                                            <th>Subtotal: </th>
                                            <th>Admin Ride Charges: </th>
                                            <th>Driver Ride Charges: </th>
                                            <th>Payable Amount: </th>
                                          </tr>
                                          <tr>
                                            

                                            <td> <?php echo '$' ?><?php echo number_format((float)($total_amount), 2, '.', ''); ?></td>
                                           
                                            <td> <?php echo "$" ?><?php echo number_format((float)($paidsum), 2, '.', ''); ?></td>
                                            <td> <?php echo "$" ?><?php echo number_format((float) ($total_amount-$paidsum), 2, '.', ''); ?></td>
                                            <td> <?= '$'.number_format((float) ($admin_charges), 2, '.', '') ?></td>
                                            <?php $final_amount=  $total_amount-$admin_charges; ?>
                                            <?php $payble_amt= $final_amount; ?>                                            
                                            
                                          </tr>
                                        </table>
                                    </div>
                                    <?php
                                     $this->helper('common_helper');                                
                                     $pay_status = get_payout_status($driver_id,$payble_amt,$payoutweek1);
                                     
                                    
                                    ?>
                                   <!-- <!?php 
                                        if(!empty($pay_status)){
                                    
                                        if(!empty($pay_status->driver_id)){
                                                                         
                                     ?>
                                    <div class="report-sale-action">
                                        <-?php if($pay_status->status==1 && $pay_status->paid_amount==$payble_amt && $pay_status->genrated_payout_date==$payoutweek1 ){ ?>
                                            <div class="transaction_id"><strong>TXN Id:</strong><-?php echo $pay_status->txn_id; ?></div>

                                            <button type="button" class="btn-AmountPaid" disabled>Amount Paid</button>
                                        <-?php }else{ ?>
                                            <a class="Payout-btn" href="#">View Payment</a>
                                        <-?php } ?>
                                    </div>
                                    <-?php }else{ ?>
                                        <div class="report-sale-action">
                                            
                                            <a class="Payout-btn" href="#">Payout1</a>
                                        </div>
                                    <--?php }}else{ ?>
                                        <-?php if($bankdata){ ?>
                                         <div class="report-sale-action">
                                         
                                            <a class="Payout-btn" href="#">View Payment</a>
                                         </div>
                                         <--?php }else{ ?>
                                            <div class="report-sale-action">                                         
                                                <a class="Payout-btn bankalert" href="#">View Payment</a>
                                            </div>
                                        

                                         <--?php  }} ?->-->
                                    <div class="report-sale-action-accordion"  data-toggle="collapse" href="#collapse<?php echo $i; ?>"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                </div>                                
                                
                                <div class="collapse" id="collapse<?php echo $i; ?>" >
                                  <div class="report-sale-accordion-card table-responsive">
                                    <table class="table text-nowrap  dataTable no-footer" id="data-table" role="grid">
                                        <thead>
                                            <tr>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80.8125px;">Ride ID</th>                                                
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 75.4688px;">Email</th>
                                                <!--th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Mobile No</th-->
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Ride Date</th>                                                
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Transection ID</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Customer Name</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80.8125px;">Total Paid Amt</th>
                                                                                                
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Admin Fee</th>                                                
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 71.6719px;">Payout Amount($)</th>
												<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Payout Date</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 71.6719px;">Make Payment</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>                                        
                                        <?php 
                                        
                                            $sumval=0;
                                            $paidsum=0;
											//print_r($pay_details);
                                           foreach($pay_details as $ordrList ):
                                         //echo $ordrList->amount;
                                            
                                              $total_amount+=$ordrList->amount; 
                                              $day= strtolower(date('l',strtotime($ordrList->ride_date)));
                                            
                                            $payout_amount = (($ordrList->amount*(100-$ordrList->AdminRide_charges))/100); 
                                            
                                        ?>
                                        
                                            <tr role="row" class="odd">
                                                <td><?php echo $ordrList->ride_id; ?></td>
												<td><?php echo $ordrList->driver_email; ?></td>
												<td><?php echo date('M d Y',strtotime($ordrList->ride_date)); ?></td>
                                                <?php if($ordrList->is_payout_completed =="1"){ ?>
													<td><?= $ordrList->payout_txn_id;  ?></td>
												<?php } else{ ?> 
													<td><p>Not Available </p></td>
												<?php } ?>
												
                                                <td><?php echo $ordrList->name; ?></td>
                                                <td><?= '$'.number_format((float) ($ordrList->amount), 2, '.', '') ?></td>
                                                
                                                <td><?= $ordrList->AdminRide_charges.'%' ?></td>
                                                <?php 
                                                    $admin_fee=($payout_amount*$ordrList->AdminRide_charges)/100;
                                                   // $admin_fee
                                                   $paidsum+=$payout_amount;
                                                    $paywithout =$payout_amount - $admin_fee;
                                                    $sumval+=$paywithout;

                                                ?>
                                                <td><?= '$'.number_format((float) ($payout_amount), 2, '.', '') ?></td>
												<?php if($ordrList->is_payout_completed =="1"){ ?>
													<td><?= date('M d Y',strtotime($ordrList->ride_created_time)); ?></td>
												<?php } else{ ?> 
													<td><p>Not Available </p></td>
												<?php } ?>
												<td>
												
													<div class="search-filter row">
														<form method="post" action="<?php echo base_url('admin/stripe_payout'); ?>"  class="form-horizontal">
															<input type="hidden" id="driver_id" name="driver_id" value="<?php echo $ordrList->driver_id; ?>" />
																<input type="hidden" id="ride_id" Name="ride_id" value="<?php echo $ordrList->ride_id; ?>" required />
															
																<input type="hidden" id="amt" Name="amount" value="1" />
															
															<div class="col-md-2">
															<?php 
																if($bankdata && !empty($bankdata->stripe_account_id) && ($bankdata->stripe_onboarding==1) ){													
															?>
																<?php if($ordrList->is_payout_completed == 1 ){ ?>
																	<a href="javascript:void(0)" class="btn btn-deinied" >Amount Paid</a>
																<?php }else{ ?>	
																
																	<input type="submit" onclick="return confirm('Are you sure you want to make payment ?')" class="btn btn-green" value="Make Payment" />
																<?php } ?>
																<?php }else{?>
																	<button type="button" onclick="return alert('Kindly activate driver\'s account before making payment')" class="btn btn-green">Make Payment</button>
																<?php } ?>	
															</div>
														</form>
													</div>
												</td>	
                                            </tr>
                                        <?php  endforeach;  ?>

                                        </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                            <?php  $j++; } endforeach; }else{ ?>
                            <div class="card" style="margin-top:50px">
                              <div class="card-body"><h3 class="text-center tex-white" style="color:#fff !important;">There is no Ride and Payout available for this Driver!</h3></div>
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
    background:#242424;
    border: 1px solid #404040;/*justify-content: space-between;*/
}

.report-sale-date {flex: 0 0 auto; width: 15%; } 
.report-sale-total{flex: 0 0 auto; width:70%;}
.report-sale-action-accordion{flex: 0 0 auto; width:5%; margin-left:10%}
.report-sale-action{flex: 0 0 auto; width:35%; padding-left: 120px;}
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
    color: #fff;
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
   color: #fff;
    font-weight: 500;
    font-size: 14px;
    margin-bottom: 0;
    padding: 0;
}
.report-sale-accordion-card {
    background: #242424;
    border-radius: 5px;
    position: relative;
    border: 1px solid #242424;
    padding: 1rem;
    margin-bottom: 10px;
	overflow-x:auto;
}
input:focus{background-color:#228B22}
.report-sale-accordion-card table.dataTable{margin-top: 0;}
.tabletitle tr th,td{
    padding:5px 10px;
    color: #fff;
}
.dataTable tbody tr td{color:#fff;font-size: 12px;}
.btn-deinied{
    
    background-color:#fff8a6;
    color:#000;
    padding:7px 19px;
}
.table-hover>tbody>tr:hover>td{background:#26231a}
.btn:hover{color:#fff !important;}
.btn:focus{color:#fff !important;}
.btn-green{background-color: #228B22;font-size: 10px;font-weight: 500;  color: #fff; padding: 6px 15px; border-radius: 3px; display: inline-block; position: relative; outline: none; border: none; box-shadow: none; }
a.btn-AmountPaid {background: #6fbf17;font-size: 13px;font-weight: 500;  padding: 6px 15px; border-radius: 3px; display: inline-block; color: #fff; position: relative; outline: none; border: none; box-shadow: none; }
a.btn-deinied {background-color: #ff0000;font-size: 10px;font-weight: 500;  color: #fff; padding: 7px 19px; border-radius: 3px; display: inline-block; position: relative; outline: none; border: none; box-shadow: none; }

a.Payout-btn {background: #FB8904; font-size: 13px; color: #fff; font-weight: 500; padding: 6px 15px; border-radius: 3px; display: inline-block; position: relative; outline: none; border: none; box-shadow: none; }

a.btn-cancel{background: #d9433e;font-size: 13px;font-weight: 500;  padding: 6px 15px; border-radius: 3px; display: inline-block; color: #fff; position: relative; outline: none; border: none; box-shadow: none; }
a.btn-Accept{background-color:#6fbf17;font-size: 13px;font-weight: 500;  color: #fff; padding: 6px 15px; border-radius: 3px; display: inline-block; position: relative; outline: none; border: none; box-shadow: none; }

a.btn-Make-Payout{background:#5b08c9;font-size: 13px;font-weight: 500;  padding: 6px 15px; border-radius: 3px; display: inline-block; color: #fff; position: relative; outline: none; border: none; box-shadow: none; }
a.btn-Accepted{background: #6fbf17;font-size: 13px;font-weight: 500;  padding: 6px 15px; border-radius: 3px; display: inline-block; color: #fff; position: relative; outline: none; border: none; box-shadow: none; }

.table.dataTable thead th {
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #fff !important;
    padding: 8px !important;
    border-top: none;
    border-bottom: 1px solid #f6ffe8 !important;
}
.table.dataTable thead{
    background:#3c3c3c;
}
</style>
<!--script>
	$(document).ready(function(){
		$('.btn-gr').on('click', function(e){
			e.preventDefault();
			$('#confirmdel').modal('show');
		});
			var driver_id = $('#driver_id').val();
			var ride_id = $('#ride_id').val();
			var amount = $('#amt').val();
		$('#btn_payout').on('click', function(e){
			 
			$.ajax({
				type: 'post',
				url: base_url+'admin/stripe_payout',
				data : {
					driver_id: driver_id,
					ride_id: ride_id,
					amount:amount,
				},
				//console.log(data);
				success:function(){
					alert('Payment has been Done successfully');
					$('.hiderow' + id).closest('tr').hide();
				   location.reload();
				}
			});
		});	
	});
</script-->

