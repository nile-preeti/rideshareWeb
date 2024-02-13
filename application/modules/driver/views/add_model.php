/* 

  This page is used for adding a new model details. 

*/
<style type="text/css">

    .vd_bg-grey {background-color: #3c485c !important; }

    .mt-20{margin-top: 20px;}

    .panel{-webkit-box-shadow:none;}

    .btn{font-size: 12px;}

    .form-control{font-size: 12px;}

    .light-widget .panel-heading{margin-top: 12px;}

    .vd_panel-menu{position: absolute; top: 7px;    margin: 0;}

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







<div aria-hidden="true" role="dialog" tabindex="-1" class="modal oc-model fade" id="confirm" >

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

                            <div class="col-md-6"> 

                                <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span><?php echo $breadcrumb;?></h3>

                            </div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                                <?php $this->load->view('common/error');?>

                                <form action="<?php echo base_url('admin/add_brand_model');?>" method="post">

                                    <div  class="row">

                                        <div class="col-md-4 label-H">

                                            <label for="brand_id">Make Name</label>

                                            <select name="brand_id" class="form-control"  id="brand_id">

                                                <?php if($brands->num_rows()>0){

                                                    foreach ($brands->result() as $row) {?>

                                                       <option value="<?php echo $row->id;?>"><?php echo $row->brand_name;?></option>

                                                <?php }

                                                }?>

                                            </select>

                                            <?php echo form_error('vehicle_no'); ?>

                                        </div>

                                        <div class="col-md-4 label-H">

                                            <label for="model_name">Model Make Name</label>

                                            <input type="text" class="form-control" id="model_name" placeholder="Name" name="model_name" value="<?php echo set_value('model_name'); ?>">

                                            <?php echo form_error('model_name'); ?>                         

                                        </div>

                                        <div class="col-md-4 label-H ">

                                            <label for="status">Status</label>

                                            <select name="status" class="form-control"  id="status">

                                                <option value="1">Active</option>

                                                <option value="2">Inactive</option> 

                                            </select>

                                            <?php echo form_error('vehicle_no'); ?>

                                        </div>

                                    

                                        <div class="col-md-12 mt-20">

                                            <button type="submit" class="btn btn-gr">Submit</button>

                                            <a href="<?php echo base_url('admin/brand_model_list') ; ?>" class="btn btn-gr">Back</a>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

