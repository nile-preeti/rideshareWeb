
<div aria-hidden="true" role="dialog" tabindex="-1" class="modal fade" id="confirmdel" style="display: none;z-index: 2147483648">
   <div class="modal-dialog">
      <div class="modal-body">
         Are you sure want to delete!
         <div class="modal-footer">
           <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
           <button type="button" data-dismiss="modal" class="btn">Cancel</button>
        </div>
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
                  <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Users </h3>
               </div>
               <div class="panel-body">
                     <div  class="search-filter">
                        <div class="row">
                           <form action="<?= $this->config->base_url() . 'admin/users' ?>" method="get">
                              <div class="col-md-4 label-H">
                                 <label>Search from Email or Name</label>
                                 <input class="form-control" type="text" value="<?php echo!empty($filter_data['email']) ? $filter_data['email'] : ''; ?>" name="email"/>
                              </div>
                              <div class="col-md-3 label-H">
                                 <label>Status</label>
                                 <select class="form-control" name="status">
                                    <option value="">Select</option>
                                    <option <?php echo!empty($filter_data['status']) ? $filter_data['status'] == '1' ? 'selected' : '' : ''; ?>  value="1">Active</option>
                                    <option <?php echo isset($filter_data['status']) ? $filter_data['status'] == '4' ? 'selected' : '' : ''; ?>  value="4">Inactive</option>
                                 </select>
                              </div>
                              <div class="col-md-3" style="margin-top:25px">
                                 <input type="submit" value="Search" class="btn btn-gr"/>
                                 <a style="margin-left:5px" href="<?= $this->config->base_url() . 'admin/users' ?>" class="btn btn-re" ><i class="fa fa-refresh" aria-hidden="true"></i></a>
                              </div>
                              
                           </form>
                        </div>
                     </div>
                     <div  class="table-dashboard table-responsive">
                        <table id="example" class="table display ">
                           <thead>
                              <tr>
                                 <!--<th>#</th>-->
                                 <!--<th>Avatar</th>-->
                                 <th>Name</th>
                                 <th>Mobile</th>
                                 <th>Email</th>
                                 <th>Status</th>
                                 <th>Action</th>
                                 <!--<th>Member</th>-->
                                 <!--                                            <th>Status</th>-->
                                 <!--                                            <th style="width:20%">Action</th>-->
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 if (!empty($result)) {
                                     foreach ($result as $val) {
                                         ?>
                              <tr>
                                 <td><?= $val->name ?></td>
                                 <td><?= $val->mobile ?></td>
                                 <td><?= $val->email ?></td>
                                 <td><?= $val->status == 1 ? '<span id="span" class="label label-success" style="background-color:#8ec431;color:white;">Active</span>' : '<span id="span" class="label label-success" style="background-color:red;color:white;">Deactive</span>'; ?></td>
                                 <td><span class="menu-action hiderow<?= $val->user_id ?>"><a id="<?= $val->user_id ?>" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon  vd_bd-yellow vd_yellow"> <i class="fa fa-pencil"></i> </a> <a id="<?= $val->user_id ?>" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a></span></td>
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