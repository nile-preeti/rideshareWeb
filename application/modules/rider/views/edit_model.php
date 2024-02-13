<!-- Editing model -->

<style type="text/css">

    

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

    .panel .panel-body {

    padding: 15px 16px 25px;

   }

   .form-control{padding:6px 8px; }

   

    .vd_panel-menu{margin-right: 0px;}

    .vd_bg-grey{background-color: #3c485c !important;}

    .light-widget .panel-heading{margin-top: 12px;}

    .vd_panel-menu{position: absolute; top: 7px;}

    .form-control{font-size: 12px; height: 31px; padding: 5px 8px; height: 29px;}

    .btn {padding: 4px 15px; font-size: 12px}



    .panel-body table tr td{font-size: 12px; color: #4e4e4e; font-weight: 300;}

    .panel-body table tr th{font-weight: 400; color: #494848; font-size: 12px;}

    .label-H label{font-weight: 400; color: #494848; font-size: 12px;}

    .border{border:1px solid #ddd;}

    .table>thead>tr>th{border-bottom: 1px solid #ddd;}

    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{line-height: inherit;}

    .panel{-webkit-box-shadow:none;}

    .panel>.panel-body+.table, .panel>.panel-body+.table-responsive{border-top:none;}

    .mt-20 {margin-top: 20px; }

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





<div aria-hidden="true" role="dialog" tabindex="-1" class="modal fade" id="confirm">

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

                            <div class="col-md-6"> 

                                <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span><?php echo $breadcrumb;?></h3>

                            </div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                            <?php $model = $models->row();?>

                            <?php $this->load->view('common/error');?>

                                <form action="<?php echo base_url('admin/edit_brand_model');?>" method="post">

                                    <div  class="row">

                                        <div class="col-md-4">

                                            <label for="brand_id">Brand Name</label>

                                            <select name="brand_id" class="form-control"  id="brand_id">

                                                <?php if($brands->num_rows()>0){

                                                    foreach ($brands->result() as $row) {?>

                                                       <option value="<?php echo $row->id;?>"><?php echo $row->brand_name;?></option>

                                                <?php }

                                                }?>

                                            </select>

                                            <?php echo form_error('brand_id'); ?>

                                        </div>

                                        <div class="col-md-4">

                                            <input type="hidden" name="id" value="<?php echo ($model)?$model->id:''; ?>" />

                                            <label for="model_name">Model Name</label>

                                            <input type="text" class="form-control" id="model_name" placeholder="Name" name="model_name" value="<?php echo ($model)?$model->model_name:''; ?>">

                                            <?php echo form_error('model_name'); ?>                         

                                        </div>

                                        <div class="col-md-4">

                                            <label for="status">Status</label>

                                            <select name="status" class="form-control"  id="status">

                                                <option value="1" <?php echo ($model)?($model->status==1)?'selected':'':'';?>>Active</option>

                                                <option value="2" <?php echo ($model)?($model->status==2)?'selected':'':'';?>>Inactive</option>

                                            </select>

                                            <?php echo form_error('status'); ?>

                                        </div>

                                        <div class="col-md-12 mt-20">

                                            <button type="submit" class="btn btn-gr">Submit</button>

                                            <a href="<?php echo base_url('admin/brand_model_list');?>"><button class="btn btn-gr" type="button">Back</button></a>

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

