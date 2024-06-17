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







<div class="vd_content-wrapper">

    <div class="vd_container">

        <div class="vd_content clearfix">
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

                                <form action="<?= $this->config->base_url() . 'admin/addFirebaseUser' ?>" method="post">

                                    <div class="col-md-4 label-H">
                                        <label>Name</label>
                                        <input class="form-control" type="text" value="" name="name" />
                                    </div>
                                    <div class="col-md-4 label-H">
                                        <label>Last name</label>
                                        <input class="form-control" type="text" value="" name="last_name" />
                                    </div>
									
									<div class="col-md-4 label-H">
                                        <label>Latitude</label>
                                        <input class="form-control" type="text" value="" name="latitude" />
                                    </div>
									<div class="col-md-4 label-H">
                                        <label>Logtitude</label>
                                        <input class="form-control" type="text" value="" name="longitude" />
                                    </div>

                                    <div class="col-md-2" style="margin-top:25px">
                                        <input type="submit" value="Search" class="btn btn-gr"/>
                                        <!--a href="<?= $this->config->base_url() . 'admin/brand_list' ?>" class="btn btn-re"><i class="fa fa-refresh" aria-hidden="true"></i></a-->
                                    </div>
                                </form>

                            </div>



                        </div>

                        

                        <div  class="table-dashboard table-responsive">                           

                                <table id="example" class="table  display border">

                                    <thead>

                                        <tr>

                                           
                                            <th>User Id</th>                     
                                            <th>Latitude</th>                     
                                            <th>Longtitude</th>                     
                                        </tr>

                                    </thead>

                                     <tbody>

                                        <?php 
											//print_r($demo); die;
											
											if ($demo>0) {
                                            $i=1;
                                            foreach ($demo as $key=>$brand) {

                                                //print_r($brand);
                                        ?>

                                            <tr>
												<td><?php echo $brand['userID']; ?></td>
                                                <td><?php echo $brand['latitude']; ?></td>
                                                <td><?php echo $brand['longitude']; ?></td>                                              
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

