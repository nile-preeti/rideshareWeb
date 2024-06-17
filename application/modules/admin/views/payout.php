<!-- All payout details -->
<!--?php print_r($bankdata) ; ?-->

<div aria-hidden="true" role="dialog" tabindex="-1" class="modal del-model fade" id="confirmdel">
   <div class="modal-dialog">
      <div class="modal-body">
         <div class="modal-content-text">
            <h2 style="color:#fff">Are you sure you want to delete this driver?</h2>
            <button type="button" data-dismiss="modal" class="btn btn-re" id="btn_payout">Make payment</button>
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
                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> View payment</h3></div>
							<?php if($bankdata && !empty($bankdata->stripe_account_id) && ($bankdata->stripe_onboarding==1) ){ ?>
							<div class="col-md-5 text-right">
                                <a href="<?php echo base_url('admin/reset_stripe_account/'.$encrypt_driver_id); ?>" class="btn btn-gr" onclick="return confirm('Are you sure to delete this stripe account')" style="background-color:#fff8a6 !important; color:#000;">Reset Stripe Account</a>
                            </div>
							<div class="col-md-1 text-right">
                                <a class="btn btn-gr" href="<?php echo base_url('admin/payout_driver')?>">Back</a>
                            </div>
							<?php }else{?>
								<div class="col-md-6 text-right">
									<a class="btn btn-gr" href="<?php echo base_url('admin/payout_driver')?>">Back</a>
								</div>

							<?php } ?>
                            
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
                                //echo "<pre>";
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
                                              $total_amount= $list->total_paid_amount; 
											  
                                              $day= strtolower(date('l',strtotime($paylist->ride_date)));
                                           
											$admin_fee = (($paylist->amount*($paylist->AdminRide_charges))/100);
											$paidsum+= $admin_fee;
											$admin_charges = $total_amount-$paidsum;
										?>
									
                                    <?php  endforeach;  ?>                                          
                                       
                                        <table class="tabletitle table-bordered">
                                          <tr>
                                            <th rowspan="2">Payout total:</th>
                                            <th>Subtotal: </th>
                                            <th>Admin ride charges: </th>
                                            <th>Driver ride charges: </th>
                                            <th>Payable amount: </th>
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
                                   
                                    <div class="report-sale-action-accordion"  data-toggle="collapse" href="#collapse<?php echo $i; ?>"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                </div>                                
                                
                                <div class="collapse" id="collapse<?php echo $i; ?>" >
                                  <div class="report-sale-accordion-card table-responsive">
                                    <table class="table text-nowrap  dataTable no-footer" id="data-table" role="grid">
                                        <thead>
                                            <tr>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80.8125px;">Ride id</th>                                                
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 75.4688px;">Email</th>
                                               
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Ride date</th>                                                
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Transaction id</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Customer name</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80.8125px;">Total paid amt</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80.8125px;">Cancellation charges</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80.8125px;">Waiting time on pickup</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80.8125px;">Waiting time on drop</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80.8125px;">Waiting  charge on pickup</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80.8125px;">Waiting  charge on drop</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Admin fee</th>                                                
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 71.6719px;">Payout amount($)</th>
												<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 58.1406px;">Payout date</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 71.6719px;">Make payment</th>
                                                
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
                                                <td><a href="<?= $this->config->base_url() ?>admin/map/<?= $ordrList->ride_id ?>"><?php echo $ordrList->ride_id; ?></a></td>
												<td><?php echo $ordrList->driver_email; ?></td>
												<td><?php echo date('M d Y',strtotime($ordrList->ride_date)); ?></td>
                                                <?php if($ordrList->is_payout_completed =="1"){ ?>
													<td><?= $ordrList->payout_txn_id;  ?></td>
												<?php } else{ ?> 
													<td><p>Not available </p></td>
												<?php } ?>
												
                                                <td><?php echo $ordrList->name; ?></td>
                                                <td><?= '$'.number_format((float) ($ordrList->amount), 2, '.', '') ?></td>
                                                <td><?= ($ordrList->cancellation_charge) ? ($ordrList->cancellation_charge) :0; ?></td>
                                                <?php 
                                                
                                                    $pickupCharge1 = ($ordrList->waiting_charge_onpickup) ? (preg_replace('/[^0-9\.]/ui','',$ordrList->waiting_charge_onpickup)) :0;
                                                    $dropCharge1 = ($ordrList->waiting_charge_ondrop) ? (preg_replace('/[^0-9\.]/ui','',$ordrList->waiting_charge_ondrop)) :0;
													$pickupCharge=($ordrList->AdminRide_charges / 100) * $pickupCharge1;
													$finalpickcharge=$pickupCharge1-$pickupCharge;
													$dropCharge=($ordrList->AdminRide_charges / 100) * $dropCharge1;
													$finaldropCharge=$dropCharge1-$dropCharge;

                                                    

                                                    
                                                    $pickupTime = $ordrList->total_waiting_time_onpickup;
                                                    if($pickupTime>0){ 				
                                                    $this->load->helper('common_helper');
                                                    $pickupTime1 = time_format(preg_replace('/[^0-9\.]/ui','',$ordrList->total_waiting_time_onpickup));
                                                    }else{
                                                        $pickupTime1="0";
                                                    }


                                                    $droptime = $ordrList->total_waiting_time_ondrop;
													
													if($droptime>0){ 				
													 $this->load->helper('common_helper');
													 $droptime1 = time_format(preg_replace('/[^0-9\.]/ui','',$ordrList->total_waiting_time_ondrop));
													 }else{
														$droptime1="0";
													 }


                                                ?>
                                                <td><?= $pickupTime1; ?></td>
                                                <td><?= $droptime1; ?></td>
                                                
                                                <td><?=($finalpickcharge>0?DEFAULT_CURRENCY.number_format($finalpickcharge,2):0); ?></td>
                                                <td><?= DEFAULT_CURRENCY .number_format($finaldropCharge,2); ?></td>
                                                
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
													<td><p>Not available </p></td>
												<?php } ?>
												<td>
												
													<div class="search-filter row">
														<form method="post" action="<?php echo base_url('admin/stripe_payout'); ?>"  class="form-horizontal">
															<input type="hidden" id="driver_id" name="driver_id" value="<?php echo $ordrList->driver_id; ?>" />
																<input type="hidden" id="ride_id" Name="ride_id" value="<?php echo $ordrList->ride_id; ?>" required />
															
																<input type="hidden" id="amt" Name="amount" value="<?= number_format((float) ($payout_amount), 2, '.', '') ?>" />
															
															<div class="col-md-2">
															<?php 
																if($bankdata && !empty($bankdata->stripe_account_id) && ($bankdata->stripe_onboarding==1) ){													
															?>
																<?php if($ordrList->is_payout_completed == 1 ){ ?>
																	<a href="javascript:void(0)" class="btn btn-deinied" >Amount paid</a>
																<?php }else{ ?>	
																
																	<input type="submit" onclick="return confirm('Are you sure you want to make payment ?')" class="btn btn-green" value="Make Payment" />
																<?php } ?>
																<?php }else{?>
																	<button type="button" onclick="return alert('Kindly activate driver\'s account before making payment')" class="btn btn-green">Make payment</button>
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
                              <div class="card-body"><h3 class="text-center tex-white" style="color:#fff !important;">There is no ride and payout available for this driver!</h3></div>
                            </div>
                           <?php } ?> 
                        </div>
                    </div>



                </div>



            </div>







        </div>



    </div>



</div>


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

