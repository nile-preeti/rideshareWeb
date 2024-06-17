<!-- list of vehicle type -->

<style type="text/css">

   .form-control{padding:6px 8px; }

    .vd_bg-grey{background-color: #3c485c !important;}

    .light-widget .panel-heading{margin-top: 12px;}

    .vd_panel-menu{position: absolute; top: 7px;}

    .form-control{font-size: 12px; height: 31px; padding: 5px 8px; height: 29px;}

    .btn {padding: 4px 15px; font-size: 12px;}

</style>

<div aria-hidden="true" role="dialog" tabindex="-1" class="modal del-model fade" id="confirmdel">

   <div class="modal-dialog">

      <div class="modal-body">

         <div class="modal-content-text">

            <h2>Are you sure want to delete!</h2>

            <button type="button" data-dismiss="modal" class="btn btn-re" id="delete">Delete</button>

           <button type="button" data-dismiss="modal" class="btn-cancel">Cancel</button>

         </div>

      </div>

      

   </div>

</div>





<div aria-hidden="true" role="dialog" tabindex="-1" class="modal  oc-model fade" id="confirm">

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

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> <?php echo $breadcrumb;?>  </h3></div>

                            <div class="col-md-6 text-right">

                                <a href="javascript:void(0);" class="btn btn-gr" id="vehicle_type">Add Vehicle Type</a>

                            </div>

                        </div>

                    </div>

                    

                    <div class="panel-body">

                        <div  class="table-dashboard table-responsive"> 

                            <?php $this->load->view('common/error') ?>

                            <table id="example" class="table display border">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <th>Vehicle Type</th>                     

                                        <th>Rate($)(/KM)</th>

                                        <th>Short Description</th>

                                        <th>Status</th>

                                        <th>Action</th>                                            

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php if ($types->num_rows()>0) {

                                        $i=1;

                                       foreach ($types->result() as $row) {?>

                                    <tr>

                                        <td><?php echo $i++;?></td>

                                        <td><?php echo $row->title;?></td>

                                        <td><?php echo $row->rate;?></td>

                                        <td><?php echo ($row->short_description)?$row->short_description:'N/A';?></td>

                                       <td><?= $row->status == 1 ? '<span id="span" class="label label-success" style="background-color:#81bd19;color:white;">Active</span>' : '<span id="span" class="label label-success" style="background-color:red;color:white;">Deactive</span>'; ?></td>

                                        <td><span class="menu-action hiderow<?= $row->id ?>"><a  data-original-title="edit" href="<?php echo base_url('admin/add_vehicle_chart/'.$row->id);?>" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow"> <i class="fa fa-pencil"></i> </a> <!-- <a id="<?= $row->id ?>" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a> --></span></td>

                                    </tr>

                                    <?php }

                                    }?>

                                

                                    

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div> 

            </div>

        </div>

    </div>

</div>

<!-- Modal -->



<div aria-hidden="true" role="dialog" tabindex="-1" class="modal oc-modal fade" id="vehicle_type_model">

    <div class="modal-dialog" >

        <div class="modal-body">

            <div class="vehicle_type_model" ></div>

        </div>

    </div>

</div>

