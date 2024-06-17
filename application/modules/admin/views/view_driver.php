<!-- View driver details -->

<style type="text/css">

    .heading-popup{padding:10px; background: #3c485c;  margin-bottom: 20px;}

    .heading-popup h4{margin-bottom: 0px; color: #fff; font-size: 14px; }

    .panel .panel-body {padding: 0px 0px 0px; }

    .mt-20{margin-top: 10px;}

    .font-c {color: #4e4e4e; font-size: 13px; font-weight: 300; background: #f7ffe9; height: 40px; align-items: center; display: flex; padding: 10px 10px; border-radius: 5px; } 



     button.close {

    -webkit-appearance: none;

    padding: 1px 8px 3px;

    background: #f44336;

    border: 0;

    position: absolute;

    right: 10px;

    top: 6px;

    color: #fff;

    border-radius: 5px;

    opacity: inherit;}

    .close:hover, .close:focus {

    color: #fff;

    text-decoration: none;

    cursor: pointer;

    filter: alpha(opacity=50);

    opacity: .5;

}



</style>

<div class="oc-modal-box">

    <div class="oc-modal-heading">

        <h4 class="">View driver information</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

    </div>
		<!--?php print_r($post); die; ?-->
    <div class="oc-modal-form">

        <form enctype="multipart/form-data" class="form-horizontal"  action="<?php echo $this->config->base_url() ?>admin/drivers/update" method="post" role="form" id="register-form">

            <input type="hidden" value="<?php echo!empty($post['user_id']) ? $post['user_id'] : ''; ?>" name="user_id"/>

            <div class="row">

                <div class="col-md-4 label-H">

                    <label>Name</label>

                    <div id="first-name-input-wrapper"  class="controls font-c">

                        <?php echo!empty($post['name']) ? $post['name'] : ''; ?>

                    </div>

                </div>

                <div class="col-md-4 label-H">

                    <label >Mobile no.</label>

                    <div id="website-input-wrapper"  class="controls font-c">
						<?php if($post['country_code']){
							$country_code=$post['country_code'].'-';
							}else{
							$country_code='';
							}
						?>
						 <?php echo!empty($post['mobile']) ? $country_code.$post['mobile'] : ''; ?>

                    </div>

                </div>

                <div class="col-md-4 label-H">
                    <label  >Email</label>
                    <div id="email-input-wrapper"  class="controls font-c" style="overflow-y: scroll;">
                        <?php echo!empty($post['email']) ? $post['email'] : ''; ?>

                    </div>

                </div>

                <div class="col-md-4 mt-20 label-H">

                    <label >Status</label>

                    <div id="email-input-wrapper"  class="controls font-c">

                        <?php echo $post['status'];?>

                    </div>

                </div>

                <div class="col-md-4 mt-20 label-H">

                    <label >Background approve status</label>

                    <div id="email-input-wrapper"  class="controls font-c">

                        <?php echo ($post['background_approval_status']==1)?'Approved':'Not Approved';?>

                    </div>

                </div>
				
				<div class="col-md-4 mt-20 label-H">

                    <label >SSN number</label>

                    <div id="email-input-wrapper"  class="controls font-c">

                       <?php echo $post['ssn'];?>

                    </div>

                </div>



                <div class="col-md-3 mt-20 label-H">

                    <label >Profile image</label>

                    <div id="email-input-wrapper"  class="controls ">
						
                        <?php if (!empty($post['avatar'])) { ?>

                            <div id="image-div" class="oc-modal-media">

                                <img id="img" src="<?php echo base_url('uploads/profile_image/'.$post['user_id'].'/'.$post['avatar']) ?>" /> 

                            </div>

                        <?php } else {

                            ?>

                            <div class="oc-modal-media">

                                <img id="myno_img"  src="<?= base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />

                            </div>

                        <?php }

                        ?>

                    </div>

                </div>



            </div>

            <div class="row">

                <div class="col-md-6 mt-20 label-H">

                   <h4 class="title-text" style="color:#fff">Vehicle detail</h4> 

                </div>

            </div>

            <?php 

            if ($vehicle->num_rows()>0){

                foreach ($vehicle->result() as  $row) {?>

                <div class="row">

                    <div class="col-md-3 mt-20 label-H">

                        <label  >Vehicle number</label>

                        <div id="email-input-wrapper"  class="controls font-c">

                            <?php echo $row->vehicle_no; ?>

                        </div>

                    </div>

                    <div class="col-md-3 mt-20 label-H">

                        <label  >Vehicle category</label>

                        <div id="email-input-wrapper"  class="controls font-c">

                            <?php echo $row->vehicle_category; ?>

                        </div>

                    </div>
					<div class="col-md-6 mt-20 label-H">

                        <label  >Vehicle model</label>

                        <div id="email-input-wrapper"  class="controls font-c" style="overflow: scroll;">

                            <?php echo $row->title; ?>

                        </div>

                    </div>
				</div>
				<div class="row">

                    <div class="col-md-3 mt-20 label-H">

                        <label  >Vehicle year</label>

                        <div id="email-input-wrapper"  class="controls font-c">

                            <?php echo $row->year; ?>

                        </div>

                    </div>

                    

                    <div class="col-md-3 mt-20 label-H">

                        <label  >Per mile rate($)</label>

                        <div id="email-input-wrapper"  class="controls font-c">

                            <?php echo $row->rate; ?>

                        </div>

                    </div>

                    <div class="col-md-3 mt-20 label-H">

                        <label>Color</label>

                        <div id="email-input-wrapper"  class="controls font-c">

                            <?php echo $row->color; ?>

                        </div>

                    </div>

                    <div class="col-md-3 mt-20 label-H">

                        <label>Status</label>

                        <div id="email-input-wrapper"  class="controls font-c">

                            <?php echo ($row->status==1) ?'Active' : 'Inactive' ;?>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mt-20 label-H">
                        <div class="view-driver-box-info">
                            <label>Vehicle image</label>
                            <div id="email-input-wrapper"  class="controls ">
                                <?php if (!empty($row->car_pic)) { ?>
                                    <div id="image-div" class="oc-modal-media">
                                        <img id="img" src="<?php echo base_url('uploads/car_pic/'.$row->user_id.'/'. $row->car_pic);?>" />
                                    </div>
                                <?php } else {
                                    ?>
                                    <div class="oc-modal-media">
                                        <img id="myno_img"  src="<?php echo base_url() ?>assets/images/avatar/no-doc.png" alt="your image" />
                                    </div>
                                <?php }
                                ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Vehicle start date</label>
                                    <div id="email-input-wrapper"  class="controls font-c">
                                        <?php echo date('m-d-Y',strtotime($row->car_issue_date)); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Vehicle expiry date</label>
									<?php $row->car_expiry_date; ?> 
                                    <div id="email-input-wrapper"  class="controls font-c">
                                        <?php echo date('m-d-Y',strtotime($row->car_expiry_date)); ?>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($row->car_pic)) {?>                       
                                 <div class=" mt-20">
                                    <a href="<?php echo base_url('admin/download/car_pic/'.$row->id);?>" class="download1" data-folder="car_pic" data-driver="<?php echo $row->user_id?>" data-file="car_pic">Download</a>
                                </div>
                            <?php }?>
                        </div>
                    </div>

                    <div class="col-md-6 mt-20 label-H">
                        <div class="view-driver-box-info">
                        <label>TNC insurance</label>

                        <div id="email-input-wrapper"  class="controls ">

                            <?php if (!empty($row->insurance)) { ?>

                                <div id="image-div" class="oc-modal-media">

                                    <img id="img" src="<?php echo base_url('uploads/insurance_document/'.$row->user_id.'/'. $row->insurance);?>"/>

                                </div>

                            <?php } else {

                                ?>

                                <div class="oc-modal-media">

                                    <img id="myno_img"  src="<?php echo base_url() ?>assets/images/avatar/no-doc.png" alt="your image" />

                                </div>

                            

                            <?php }

                            ?>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <label>Insurance start date</label>

                                <div id="email-input-wrapper"  class="controls font-c">

                                    <?php echo date('m-d-Y',strtotime($row->insurance_issue_date)); ?>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <label>Insurance start date</label>

                                <div id="email-input-wrapper"  class="controls font-c">

                                    <?php echo date('m-d-Y',strtotime($row->insurance_expiry_date)); ?>

                                </div>

                            </div>

                        </div>

                        <?php if (!empty($row->car_pic)) {?>                       
                            <div class=" mt-20">
                                <a href="<?php echo base_url('admin/download/insurance/'.$row->id);?>" class="download1" data-folder="car_pic" data-driver="<?php echo $row->user_id?>" data-file="car_pic">Download</a>
                            </div>

                        <?php }?>
                        </div>
                    </div>

                    <div class="col-md-6 mt-20 label-H">
                        <div class="view-driver-box-info">
                        <label>License</label>

                        <div id="email-input-wrapper"  class="controls ">

                            <?php if (!empty($row->license)) { ?>

                                <div id="image-div" class="oc-modal-media">

                                    <img id="img" src="<?php echo base_url('uploads/license_document/'.$row->user_id.'/'. $row->license);?>"/>

                                </div>

                            <?php } else {

                                ?>

                                <div class="oc-modal-media">

                                    <img id="myno_img"  src="<?php echo base_url() ?>assets/images/avatar/no-doc.png" alt="your image" />

                                </div>

                            <?php }

                            ?>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <label>License start date</label>

                                <div id="email-input-wrapper"  class="controls font-c">

                                    <?php echo date('m-d-Y',strtotime($row->license_issue_date)); ?>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <label>License start date</label>

                                <div id="email-input-wrapper"  class="controls font-c">

                                    <?php echo date('m-d-Y',strtotime($row->license_expiry_date)); ?>

                                </div>

                            </div>

                        </div>

                        <?php if (!empty($row->car_pic)) {?>                       
                            <div class=" mt-20">
                            <a href="<?php echo base_url('admin/download/license/'.$row->id);?>" class="download1" data-folder="car_pic" data-driver="<?php echo $row->user_id?>" data-file="car_pic">Download</a>
                            </div>
                        <?php }?>
                        </div>
                    </div>

                    <div class="col-md-6 mt-20 label-H">
                        <div class="view-driver-box-info">
                        <label>Inspection document</label>

                        <div id="email-input-wrapper"  class="controls ">

                            <?php if (!empty($row->inspection_document)) { ?>

                                <div id="image-div" class="oc-modal-media">

                                    <img id="img" src="<?php echo base_url('uploads/inspection_document/'. $row->user_id.'/'.$row->inspection_document);?>" />

                                </div>

                            <?php } else {

                                ?>

                                <div class="oc-modal-media">

                                    <img id="myno_img"  src="<?php echo base_url() ?>assets/images/avatar/no-doc.png" alt="your image" />

                                </div>

                            <?php }

                            ?>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <label>Inspection document start date</label>

                                <div id="email-input-wrapper"  class="controls font-c">

                                    <?php echo date('m-d-Y',strtotime($row->inspection_issue_date)); ?>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <label>Inspection document expiry date</label>

                                <div id="email-input-wrapper"  class="controls font-c">

                                    <?php echo date('m-d-Y',strtotime($row->inspection_expiry_date)); ?>

                                </div>

                            </div>

                        </div>

                        <!-- <?php if (!empty($row->car_pic)) {?>                       

                            <a href="<?php echo base_url('admin/download/car_pic/'.$row->id);?>" class="download1" data-folder="car_pic" data-driver="<?php echo $row->user_id?>" data-file="car_pic">Download</a>

                        <?php }?> -->
                        </div>
                    </div>

                </div> 

            <?php }

            }?>           

        </form>

    </div>

</div>



<script type="text/javascript">

    $(document).on('click','.download',function(){

        var folder = $(this).data('folder');

        var driver = $(this).data('driver');

        var file = $(this).data('file');

        alert(folder);

        alert(driver);

        $.ajax({

            url:base_url+'admin/download',

            dataType:"json",

            data:{folder:folder,driver:driver,file:file},

            type:'post',

            success:function(data){



            }

        });

    })

</script>


