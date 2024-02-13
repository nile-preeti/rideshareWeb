<!-- Display all brand list  -->

<style type="text/css">

   

   .vd_content-section{background: #fafff2;}

   .vd_head-section .vd_panel-menu .menu:first-child{border-left: none;}

    .vd_head-section .vd_panel-menu .menu {color: #8ec431;border: none;background: #ecfdd2;border-radius: 4px;}



    .vd_panel-menu{margin-right: 0px;}

    .vd_bg-grey{background-color: #3c485c !important;}

    .light-widget .panel-heading{margin-top: 12px;}

    .vd_panel-menu{position: absolute; top: 7px;}

    .form-control{font-size: 12px; height: 31px; padding: 5px 8px; height: 29px;}

    .btn {padding: 4px 15px; font-size: 12px;}



    

</style>



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

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Make List </h3></div>

                            <div class="col-md-6 text-right">

                                <a href="<?php echo base_url('admin/add_brand');?>" class="btn btn-gr">Add Make</a>

                            </div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div  class="search-filter">

                            <div class="row">

                                <form action="<?= $this->config->base_url() . 'admin/brand_list' ?>" method="get">

                                    <div class="col-md-4 label-H">

                                        <label>Make name</label>

                                        <input class="form-control" type="text" value="<?php echo !empty($filter_data['brand_name']) ? $filter_data['brand_name'] : ''; ?>" name="brand_name"/>

                                    </div>



                                    <div class="col-md-2 label-H">

                                        <label>Status</label>

                                        <select class="form-control" name="status">

                                            <option value="">Select</option>

                                            <option <?php echo!empty($filter_data['status']) ? $filter_data['status'] == '1' ? 'selected' : '' : ''; ?>  value="1">Active</option>

                                            <option <?php echo isset($filter_data['status']) ? $filter_data['status'] == '2' ? 'selected' : '' : ''; ?>  value="4">Inactive</option>

                                        </select>

                                    </div>

                                    <div class="col-md-2" style="margin-top:25px">

                                        <input type="submit" value="Search" class="btn btn-gr"/>

                                        <a href="<?= $this->config->base_url() . 'admin/brand_list' ?>" class="btn btn-re"><i class="fa fa-refresh" aria-hidden="true"></i></a>

                                    </div>

                                </form>

                            </div>



                        </div>

                        

                        <div  class="table-dashboard table-responsive">

                            <?php if($filter_data && isset($filter_data['status']) ){

                                if($filter_data['status']==3){?>

                                    <a href="javascript:void(0)" class="btn btn-success" id="approved">Approve</a>

                            <?php } }?>

                                <table id="example" class="table  display border">

                                    <thead>

                                        <tr>

                                            <th>S.No</th>

                                            <th>Make name</th>                     

                                            <th>status</th>

                                            <th>Action</th>                                           

                                        </tr>

                                    </thead>

                                     <tbody>

                                        <?php 

                                        if ($brands->num_rows()>0) {  

                                        $i=1;                          

                                        foreach ($brands->result()   as $brand) {?>

                                            <tr>

                                                <td><?php echo $i++;?></td>

                                                <td><?php echo $brand->brand_name;?></td>

                                                 <td><?= $brand->status == 1 ? '<span id="span" class="label label-success" style="background-color:#8ec431;color:white;">Active</span>' : '<span id="span" class="label label-success" style="background-color:red;color:white;">Deactive</span>'; ?></td>

                                                 <td><span class="menu-action hiderow<?= $brand->id ?>"><a id="<?= $brand->id ?>" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow" href="<?php echo base_url('admin/edit_brand/'.$brand->id);?>"> <i class="fa fa-pencil"></i> </a> 

                                                <a id="<?= $brand->id ?>" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a></span></td>

                                            </tr>

                                        <?php }}?>

                                    

                                   

                                        

                                    </tbody>

                                </table>



                            

                        </div>

                    </div>

                </div>

            </div>



        </div>

    </div>

</div>

