

<!-------- Customizable Css for Map  ----------------------------->
<style type="text/css">
    html {
        height: 100%;
    }
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    #map {
        margin: 0;
        padding: 0;
        height: 550px;
        max-width: none;
    }
    #map img {
        max-width: none !important;
    }
    .gm-style-iw {
        //width: 250px !important;
        top: 15px !important;
        left: 0px !important;
        background-color: #fff !important;
        //box-shadow: 0 1px 6px rgba(178, 178, 178, 0.6);
        //border: 1px solid rgba(72, 181, 233, 0.6);
        //border-radius: 2px 2px 10px 10px;
    }
    #iw-container {
        margin-bottom: 10px;
    }
	//gm-style-iw-d div{color:#fb8904 !important;}
    #iw-container .iw-title {
        font-family: 'Open Sans Condensed', sans-serif;
        font-size: 22px;
        font-weight: 400;
        padding: 10px;
        background-color: #fff !important;
        color: white;
        margin: 0;
        border-radius: 2px 2px 0 0;
    }
	.gm-style-iw-d{
		max-height:350px !important; 
	}
	
    #iw-container .iw-content {
        font-size: 13px;
        line-height: 18px;
        font-weight: 400;
        margin-right: 1px;
        padding: 15px 5px 20px 15px;
        max-height: 140px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .iw-content img {
        float: right;
        margin: 0 5px 5px 10px;	
    }
    .iw-subTitle {
        font-size: 16px;
        font-weight: 700;
        padding: 5px 0;
    }
    .iw-bottom-gradient {
        position: absolute;
        width: 326px;
        height: 25px;
        bottom: 10px;
        right: 18px;
        background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
        background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
        background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
        background: -ms-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
    }
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
    .vd_panel-menu{position: absolute; top: 7px; margin: 0;}
    .btn {padding: 4px 15px; font-size: 12px}
    .inline{display: inline;}
	
	
	
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

</head>
<body onLoad="initMap()">
   <!--?php print_r($detail); die; ?-->
   
    <div   class="vd_content-wrapper">
        <div class="vd_container">
            <div class="vd_content clearfix">
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
                                      <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Ride details</h3></div>
                                      <div class="col-md-6 text-right"> <a class="btn btn-gr" href="<?php echo base_url('admin/getrides');?>">Back</a></div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="panel widget">
                                        <div  class="search-filter">
                                            <div class="row">
												<div class="col-md-6">
                                                    <label class="inline">Ride id: </label>
                                                    <p class="inline"><?php echo ($detail->ride_id)?$detail->ride_id:'NA';?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="inline">Rider name: </label>
                                                    <p class="inline"><?php echo ($detail->name)?$detail->name:'NA';?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="inline">Rider email: </label>
                                                    <p class="inline"><?php echo ($detail->email)?$detail->email:'NA';?></p>
                                                </div>
                                                <div class="col-md-6">
                                                   <label class="inline">Driver name: </label> 
                                                     <p class="inline"><?php echo ($detail->driver_name)?$detail->driver_name:'NA';?></p>
                                                </div>
                                                <div class="col-md-6">
                                                   <label class="inline">Driver email: </label> 
                                                     <p class="inline"><?php echo ($detail->driver_email)?$detail->driver_email:'NA';?></p>
                                                </div>
                                                <div class="col-md-6">
                                                   <label class="inline">Vehicle no: </label> 
                                                    <p class="inline"><?php echo ($detail->vehicle_no)?$detail->vehicle_no:'NA';?></p>
                                                </div>
                                                <div class="col-md-6">
                                                   <label class="inline">Vehicle color: </label> 
                                                    <p class="inline"><?php echo ($detail->color)?$detail->color:'NA';?></p>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                   <label class="inline">Distance: </label> 
                                                   <?php $distance = number_format((float)$detail->distance, 2, '.', ''); ?>
                                                   <p class="inline"><?php echo ($detail->distance)?$distance.' '. 'Miles':'';?></p>
                                                </div>
                                                <div class="col-md-6">
                                                   <label class="inline">Pickup location: </label> 
                                                   <p class="inline"><?php echo ($detail->pickup_location)?$detail->pickup_location:'';?></p>
                                                </div>
												<?php if($stop_data){
													foreach($stop_data as $stop){ ?><div class="col-md-6">
                                                   <label class="inline">Stop location: </label>
                                                    <p class="inline"><?php echo ($stop->midstop_address)?$stop->midstop_address:"N/A";?></p> 
                                                </div>
														
												<?php }} ?>
												
                                                <div class="col-md-6">
                                                   <label class="inline">Drop location: </label>
                                                    <p class="inline"><?php echo ($detail->drop_location)?$detail->drop_location:'';?></p> 
                                                </div>
												
												
												
												
												
										<?php 
											$pickupTime = $detail->total_waiting_time_onpickup;
											if($pickupTime>0){ 				
											 $this->load->helper('common_helper');
											 $pickupTime1 = time_format(preg_replace('/[^0-9\.]/ui','',$detail->total_waiting_time_onpickup));
											 }else{
												$pickupTime1="0";
											 }
										?>
										
												<div class="col-md-6">
                                                   <label class="inline">Waiting time on pickup: </label>
                                                    <p class="inline">
													<?php 
														echo $pickupTime1; 
													?>
													</p>
                                                </div>
												
												
												
												
												<?php 
													 $droptime = $detail->total_waiting_time_ondrop;
													
													if($droptime>0){ 				
													 $this->load->helper('common_helper');
													 $droptime1 = time_format(preg_replace('/[^0-9\.]/ui','',$detail->total_waiting_time_ondrop));
													 }else{
														$droptime1="0";
													 }										 
												?>
												
												<div class="col-md-6">
                                                   <label class="inline">Waiting time on drop: </label>
                                                    <p class="inline"><?php echo $droptime1; ?></p>
                                                </div>

                                                <div class="col-md-6">
                                                   <label class="inline">Ride created time: </label>
                                                    <p class="inline"><?php echo ($detail->ride_created_time)?$detail->ride_created_time:'N/A';?></p>
                                                </div>									
												<div class="col-md-6">
                                                   <label class="inline">Ride completed time: </label>
                                                    <p class="inline"><?php echo ($detail->ride_complete_time)?$detail->ride_complete_time:'N/A';?></p>
                                                </div>
											</div>
										<table class="tabletitle table-bordered">
											  <tbody>
												  <tr>
													<th rowspan="2">Payment details:</th>
													<th>Total ride amount</th>
													<th>Hold amount</th>
													<th>Refund amount</th>
													<th>Admin charges (%)</th>
													<th>Waiting charge on pickup </th>
													<th>Waiting charge on drop</th>
													<th>Total waiting charge </th>
													<th>Cancellation charges</th>
													<th>Transaction id:</th>
												  </tr>
												  <tr>							
													<td><?php
													$pickupCharge =($detail->waiting_charge_onpickup)?(preg_replace('/[^0-9\.]/ui','',$detail->waiting_charge_onpickup)):'0';
													
													$dropCharge=($detail->waiting_charge_ondrop)?(preg_replace('/[^0-9\.]/ui','',$detail->waiting_charge_ondrop)):'0';
													$totalAmt = ($detail->rest_amount>=0? preg_replace('/[^0-9\.]/ui','',$detail->amount):'0');
													$totalrideAmt=$totalAmt+$detail->cancellation_charge;
													
													
													$holdAmt=$detail->hold_amount;
													
													echo DEFAULT_CURRENCY.' '. $totalrideAmt; ?></td>
													<td><?php echo ($holdAmt)?DEFAULT_CURRENCY.' '.$holdAmt:'';?></td>
													<td> <?php echo ($detail->hold_amount)?DEFAULT_CURRENCY.' '.preg_replace('/[^0-9\.]/ui','',$detail->hold_amount-$totalAmt):'0'; ?></td>
													<td> <?php echo ($detail->AdminRide_charges)?($detail->AdminRide_charges .' %'):'0'; ?></td>
													<td> <?php echo DEFAULT_CURRENCY.' '.$pickupCharge;?></td>
													<td> <?php echo DEFAULT_CURRENCY.' '.$dropCharge;?></td>
													<td> <?php
													$totalwaitcharge=0;
													$totalwaitcharge=$pickupCharge+$dropCharge;
													echo DEFAULT_CURRENCY.' '.$totalwaitcharge;?></td>
													<td> <?php echo ($detail->cancellation_charge)?DEFAULT_CURRENCY.' '.$detail->cancellation_charge:'N/A';?></td>
													<td> <?php echo ($detail->txn_id)? $detail->txn_id:'';?></td>
												 </tr>
											</tbody>
										</table>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div  class="vd_content-section clearfix">

                    <div id="map"></div>
                </div>
            </div>

        </div>
    </div>
</body>



