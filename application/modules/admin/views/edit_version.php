<!-- Editing an existing brand -->

<style type="text/css">

    .vd_bg-grey {background-color: #3c485c !important; }

    

   .form-control{padding:6px 8px; }

   

    .vd_panel-menu{margin-right: 0px;}

    .vd_bg-grey{background-color: #3c485c !important;}

    .light-widget .panel-heading{margin-top: 12px;}

    .vd_panel-menu{position: absolute; top: 7px;}

    .form-control{font-size: 12px; height: 31px; padding: 5px 8px; height: 29px;}

    .btn {padding: 4px 15px;}

    .table-dashboard table tr td{font-size: 12px; color: #4e4e4e; font-weight: 300;}

    .table-dashboard table tr th{font-weight: 400; color: #494848; font-size: 13px;}

    .label-H label{font-weight: 400; color: #494848; font-size: 13px;}

    .border{border:1px solid #ddd;}

    .table>thead>tr>th{border-bottom: 1px solid #ddd;}

    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{line-height: inherit;}

    .mt-20{margin-top: 20px;}

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

                            <div class="col-md-6"> 

                                <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i></span>Edit version details</h3>

                            </div>

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="panel widget">

                            <div  class="search-filter">

                                

                                <?php $this->load->view('common/error');?>

                                <form action="<?php echo base_url('admin/update_version');?>" method="post">

                                    <div  class="row">

                                        <div class="col-md-6">

                                            <input type="hidden" name="id" value="<?php echo $brand->id ?>" />

                                            <label for="brand_name">Version title</label>

                                            <input type="text" class="form-control" id="brand_name" placeholder="Version Title" name="version_title" value="<?php echo $brand->title ?>" required>

                                            <?php echo form_error('version_title'); ?>                         

                                        </div>

                                        <div class="col-md-6">

                                            <label for="status">Version number</label>

                                            <input type="text" class="form-control" id="brand_name" placeholder="Version Title" name="version_number" value="<?php echo $brand->version_no ?>" required>

                                            <?php echo form_error('version_number'); ?>

                                        </div>

                                        <div class="col-md-12 mt-20">

                                            <button type="submit" class="btn btn-gr">Submit</button>

                                            <a href="<?php echo base_url('admin/version');?>"><button type="button" class="btn btn-gr">Back</button></a>

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

