<!-- All payout to a driver -->

<div aria-hidden="true" role="dialog" tabindex="-1" class="modal del-model fade" id="confirmdel">

    <div class="modal-dialog">

    <div class="modal-body">

        <div class="modal-content-text">

            <h2>Are you sure you want to delete the User?</h2>

            <button type="button" data-dismiss="modal" class="btn btn-re" id="delete">Delete</button>

            <button type="button" data-dismiss="modal" class="btn-cancel">Cancel</button>

        </div>

    </div>   

    </div>

</div>



<div aria-hidden="true" role="dialog" tabindex="-1" class="modal oc-model fade" id="confirm">

 <div class="modal-dialog">

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

                            <div class="col-md-6"> <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Version list  </h3></div>

                        </div>

                 </div>

                 <div class="panel-body">

                      <?php $this->load->view('common/error');?>

                        
                         <div  class="table-dashboard table-responsive">

                             <table id="example" class="table display border">

                                 <thead>

                                     <tr>

                                         <th>S.No</th>
                                         
                                         <th>Device</th>

                                         <th>Version title</th>

                                         <th>Version number</th>

                                         <th>Action</th>

                                     </tr>

                                 </thead>

                                 <tbody>

                                     <?php

                                     if (!empty($result)) {

                                         $i=1;

                                         foreach ($result as $val) {

                                             ?>

                                             <tr>

                                                 <td><?= $i++; ?></td>
                                                 
                                                 <td><?= $val->is_android==1 ? "Android" : "IOS" ?></td>

                                                 <td><?= $val->title ?></td>

                                                 <td><?= $val->version_no ?></td>

                                                 <td><span class="menu-action hiderow"><a href="<?php echo base_url('admin/edit_version/'.$val->id);?>" class="btnaction btn menu-icon vd_bd-yellow vd_yellow"> <i class="fa fa-pencil"></i> </a></span></td>

                                             </tr>

                                             <?php

                                         }

                                     }

                                     ?>

                                 </tbody>

                             </table>

                     </div>

                 </div>

             </div>

         </div>



     </div>

 </div>

</div>

