<!-- All payment information -->
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

    .btn {padding: 4px 15px; font-size: 12px;}



    

    .pagination{margin: 0px 20px 0px;}

    .dataTables_paginate.paging_bootstrap{text-align: right;}



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





        $(document).on('click', '.btnpay', function () {

            var id = $(this).attr('id');

            $.ajax({

                type: 'post',

                url: '<?php echo $this->config->base_url() ?>admin/pay',

                data: "ids=" + id,

                success: function (data) {

                    if(data == 'ok'){

                        notification("topright", 'success', 'fa fa-check-circle vd_green', 'success', "pay done");

                    }else{

                         notification("topright", 'error', 'fa fa-exclamation-circle vd_red', 'error', "pay fail");

                    }

                }

            });





        });



        ///$('#example').DataTable();

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

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Payments </h3></div>

                        </div>

                    </div>

                

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                                <div class="row">

                                   <form action="<?= $this->config->base_url() . 'admin/getPayments' ?>" method="get">

                                      <div class="col-md-2 label-H">

                                         <label>Driver Email</label>

                                         <input class="form-control" type="text" value="<?php echo!empty($filter_data['email']) ? $filter_data['email'] : ''; ?>" name="email"/>

                                      </div>

                                      <div class="col-md-2 label-H">

                                         <label>Driver Name</label>

                                         <input class="form-control" type="text" value="<?php echo!empty($filter_data['name']) ? $filter_data['name'] : ''; ?>" name="name"/>

                                      </div>

                                      <div class="col-md-2 label-H">

                                         <label>Driver Mobile No</label>

                                          <input class="form-control" type="text" value="<?php echo!empty($filter_data['mobile']) ? $filter_data['mobile'] : ''; ?>" name="mobile"/>

                                      </div>

                                      <div class="col-md-2 label-H">

                                         <label>From date</label>

                                          <input class="form-control" type="text" value="<?php echo !empty($filter_data['from']) ? $filter_data['from'] : ''; ?>" name="from" autocomplete="off" />

                                      </div>

                                      <div class="col-md-2 label-H">

                                         <label>To date</label>

                                          <input class="form-control" type="text" value="<?php echo!empty($filter_data['to']) ? $filter_data['to'] : ''; ?>" name="to" autocomplete="off"/>

                                      </div>

                                      <div class="col-md-2" style="margin-top:25px">

                                         <input type="submit" value="Search" class="btn btn-gr"/>

                                         <a style="margin-left:5px" href="<?= $this->config->base_url() . 'admin/getPayments' ?>" class="btn btn-re" ><i class="fa fa-refresh" aria-hidden="true"></i></a>

                                         <?php if(isset($filter_data['name'])){?>

                                            <a style="margin-left:5px;background: #ecfdd2;color:#008000" href="<?= $url.'&export=true' ?>" class="btn btn-re" ><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>

                                         <?php }else{ ?>

                                            <a style="margin-left:5px;background: #ecfdd2;color:#008000" href="<?= $url.'?export=true' ?>" class="btn btn-re" ><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>

                                        <?php }?>

                                      </div>

                                      

                                   </form>

                                </div>

                            </div>

                            <div  class="table-dashboard table-responsive"> 

                                <table id="example" class="table  display border">

                                    <thead>

                                        <tr>

                                            <th>S.No</th>

                                            <th>Email</th>

                                            <th>Driver name</th>

                                            <th>Driver Mobile No</th>

                                            <th>Customer name</th>

                                            <th>Txn Id</th>

                                            <th>Amount</th>

                                            <th>Payment date</th>

                                            <th>Status</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php

                                        if ($result->num_rows()>0) {

                                            $count=1;

                                            foreach ($result->result() as $val) {

                                                ?>

                                                <tr>

                                                    <td><?= $count++; ?></td>

                                                    <td><?= $val->driver_email ?></td>

                                                    <td><?= $val->driver_name ?></td>

                                                    <td><?= $val->driver_mobile ?></td>

                                                    <td><?= $val->user_name ?></td>

                                                    <td><?= $val->txn_id ?></td>

                                                    <td><?= number_format((float) ($val->amount), 2, '.', '') ?></td>

                                                    <td><?= date('M d Y',strtotime($val->ride_date)) ?></td>

                                                    <td><?= $val->payment_status ?></td>

                                                    <!-- <td><button class="btn btn-primary btn-sm btnpay" id="<?= $val->user_id ?>">Pay</button></td> -->

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

</div>

