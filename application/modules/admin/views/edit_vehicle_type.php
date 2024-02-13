

<style type="text/css">

    .vd_bg-grey {background-color: #3c485c !important; }

    .mt-20{margin-top: 20px;}

    .panel{-webkit-box-shadow:none;}

    .btn{font-size: 12px;}

    .form-control{font-size: 12px;}

    .light-widget .panel-heading{margin-top: 12px;}

    .vd_panel-menu{position: absolute; top: 7px;    margin: 0;}
	.warning{font-size:11px; color:#fb8904; margin-left:4px;}

</style>
<?php //print_r($category); die; ?>
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

                                <?php $row = $category->row();
                                      //print_r($row);die; 
                               ?>
                                <?php //$category = $category->result();
                                      //print_r($category);die; ?>

                                <form action="<?php echo base_url('admin/update_vehicle_category');?>" method="post" enctype='multipart/form-data'>
                                    <input type="hidden" name="id" value="<?php echo $row->id;?>">

                                    <div class="row">
                                        <div class="col-md-3 label-H">
                                            <label for="title">category Name </label>
                                            <input type="text" name="title" class="form-control"  id="title" value="<?php echo $row->title ?>">
                                            <?php echo form_error('title'); ?>
                                        </div>
										<div class="col-md-3 label-H">

                                            <label for="rate">Short Description</label>

                                            <input type="text" class="form-control" id="short_description" name="short_description" value="<?php echo $row->short_description ?>">

                                            <?php echo form_error('short_description'); ?>                         

                                        </div>
										<div class="col-md-3 label-H">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control"  id="status">
                                                <option value="1" <?php echo ($row->status==1)?'selected':'';?>>Active</option>
                                                <option value="2" <?php echo ($row->status==2)?'selected':'';?>>Inactive</option>
                                            </select>
                                            <?php echo form_error('status'); ?>
                                        </div>
										
										<div class="col-md-3 mt-20">
                                            <?php if ($row->id) {?>                                             

                                                <button type="submit" class="btn btn-gr">Update</button>
                                                <?php }else{?>
                                                    <button type="submit" class="btn btn-gr">Add </button>
                                            <?php }?>

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