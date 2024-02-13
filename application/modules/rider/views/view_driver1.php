<style type="text/css">
    .heading-popup{padding:10px; background: #3c485c;  margin-bottom: 20px;}
    .heading-popup h4{margin-bottom: 0px; color: #fff; font-size: 14px; }
    .panel .panel-body {padding: 0px 0px 0px; }
    .mt-20{margin-top: 10px;}
    .font-c{    color: #4e4e4e; font-size: 13px; font-weight: 300; background: #f7f8f8; height: 30px; align-items: center; display: flex; padding: 0px 10px; border-radius: 2px;}
     .card{padding: 0px 14px 14px; display: inline-block;}
    .label-H label{font-weight: 400; color: #494848; font-size: 12px;}
     button.close {
    -webkit-appearance: none;
    padding: 1px 8px 3px;
    background: #4a5669;
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

<div class="panel widget light-widget container">
    <div class="panel-body row">
        <div class="heading-popup">
            <h4>View Driver Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card">
            <form enctype="multipart/form-data" class="form-horizontal"  action="<?php echo $this->config->base_url() ?>admin/drivers/update" method="post" role="form" id="register-form">
                <input type="hidden" value="<?php echo!empty($post['user_id']) ? $post['user_id'] : ''; ?>" name="user_id"/>
                <div class="col-md-6 label-H">
                    <label class="control-label">Name</label>
                    <div id="first-name-input-wrapper"  class="controls font-c">
                        <?php echo!empty($post['name']) ? $post['name'] : ''; ?>
                    </div>
                </div>
                <div class="col-md-6 label-H">
                    <label class="control-label ">Mobile No.</label>
                    <div id="website-input-wrapper"  class="controls font-c">
                        <?php echo!empty($post['mobile']) ? $post['mobile'] : ''; ?>
                    </div>
                </div>
                <div class="col-md-6 mt-20 label-H">
                    <label class="control-label" >Email</label>
                    <div id="email-input-wrapper"  class="controls font-c">
                        <?php echo!empty($post['email']) ? $post['email'] : ''; ?>
                    </div>
                </div>
                <div class="col-md-6 mt-20 label-H">
                    <label class="control-label " >Vehicle Number</label>
                    <div id="email-input-wrapper"  class="controls font-c">
                        <?php echo!empty($post['vehicle_no']) ? $post['vehicle_no'] : ''; ?>
                    </div>
                </div>
                <div class="col-md-6 mt-20 label-H">
                    <label class="control-label " >Vehicle Make</label>
                    <div id="email-input-wrapper"  class="controls font-c">
                        <?php echo!empty($post['brand_name']) ? $post['brand_name'] : ''; ?>
                    </div>
                </div>
                <div class="col-md-6 mt-20 label-H">
                    <label class="control-label " >Vehicle Make Model</label>
                    <div id="email-input-wrapper"  class="controls font-c">
                        <?php echo!empty($post['model_name']) ? $post['model_name'] : ''; ?>
                    </div>
                </div>
                <div class="col-md-6 mt-20 label-H">
                    <label class="control-label " >Vehicle Year</label>
                    <div id="email-input-wrapper"  class="controls font-c">
                        <?php echo!empty($post['year']) ? $post['year'] : ''; ?>
                    </div>
                </div>
                <div class="col-md-6 mt-20 label-H">
                    <label class="control-label " >Vehicle Type</label>
                    <div id="email-input-wrapper"  class="controls font-c">
                        <?php echo!empty($post['title']) ? $post['title'] : ''; ?>
                    </div>
                </div>
                <div class="col-md-6 mt-20 label-H">
                    <label class="control-label " >Service Rate($)(/Km)</label>
                    <div id="email-input-wrapper"  class="controls font-c">
                        <?php echo!empty($post['rate']) ? $post['rate'] : ''; ?>
                    </div>
                </div>
                <div class="col-md-6 mt-20 label-H">
                    <label class="control-label " >Color</label>
                    <div id="email-input-wrapper"  class="controls font-c">
                        <?php echo!empty($post['color']) ? $post['color'] : ''; ?>
                    </div>
                </div>
                <div class="col-md-12 mt-20 label-H">
                    <label class="control-label">Status</label>
                    <div id="email-input-wrapper"  class="controls font-c">
                        <?php echo!empty($post['status']) ? $post['status'] == 1 ? 'Active' : 'Deactive' : '' ?>
                    </div>
                </div>
                <div class="col-md-6 mt-20 label-H">
                    <label class="control-label ">Profile Image</label>
                    <div id="email-input-wrapper"  class="controls ">
                        <?php if (!empty($post['avatar'])) { ?>
                            <div id="image-div">
                                <img id="img" src="<?php echo $post['avatar'] ?>" style="height: 80px;width: 80px"/>
                            </div>
                        <?php } else {
                            ?>
                            <img id="myno_img" style="width: 80px;height: 80px" src="<?= base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />
                        <?php }
                        ?>
                    </div>
                </div>
                <!-- <div class="col-md-6 mt-20 label-H">
                    <label class="control-label ">License</label>
                    <div id="email-input-wrapper"  class="controls ">
                        <?php if (!empty($post['license'])) { ?>
                            <div id="image-div">
                                <img id="img" src="<?php echo base_url('uploads/license_document/'.$post['user_id'].'/'. $post['license'])  ?>" style="height: 200px;width: 300px"/>
                            </div>
                        <?php } else {
                            ?>
                            <img id="myno_img" style="width: 80px;height: 80px" src="<?= base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />
                        <?php }
                        ?>
                    </div>
                    <?php if (!empty($post['license'])) {?>
                        <a href="<?php echo base_url('admin/download/license_document/license/'.$post['user_id']);?>" class="download1" data-folder="license_document" data-driver="<?php echo $post['user_id']?>" data-file="license">Download</a>
                    <?php }?>
                </div>
                <div class="col-md-6 mt-20 label-H">
                    <label class="control-label ">Insurance</label>
                    <div id="email-input-wrapper"  class="controls ">
                        <?php if (!empty($post['insurance'])) { ?>
                            <div id="image-div">
                                <img id="img" src="<?php echo base_url('uploads/insurance_document/'.$post['user_id'].'/'. $post['insurance']); ?>" style="height: 300px;width: 200px"/>
                            </div>
                        <?php } else {
                            ?>
                            <img id="myno_img" style="width: 80px;height: 80px" src="<?php echo base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />
                        <?php }
                        ?>
                    </div>
                     <?php if (!empty($post['insurance'])) {?>
                    <a href="<?php echo base_url('admin/download/insurance_document/insurance/'.$post['user_id']);?>" class="download1" data-folder="insurance_document" data-driver="<?php echo $post['user_id']?>" data-file="insurance"> Download</a>
                <?php }?>
                </div>
                <div class="col-md-6 mt-20 label-H">
                    <label class="control-label ">Permit</label>
                    <div id="email-input-wrapper"  class="controls ">
                        <?php if (!empty($post['permit'])) { ?>
                            <div id="image-div">
                                <img id="img" src="<?php echo base_url('uploads/permit_document/'.$post['user_id'].'/'. $post['permit']);?>" style="height: 200px;width: 200px"/>
                            </div>
                        <?php } else {
                            ?>
                            <img id="myno_img" style="width: 80px;height: 80px" src="<?php echo base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />
                        <?php }
                        ?>
                    </div>
                    <?php if (!empty($post['permit'])) {?>
                    <a href="<?php echo base_url('admin/download/permit_document/permit/'.$post['user_id']);?>" class="download1" data-folder="permit_document" data-driver="<?php echo $post['user_id']?>" data-file="permit">Download</a>
                <?php }?>
                </div> -->
                <div class="col-md-6 mt-20 label-H">
                    <label class="control-label ">Vehicle Image</label>
                    <div id="email-input-wrapper"  class="controls ">
                        <?php if (!empty($post['car_pic'])) { ?>
                            <div id="image-div">
                                <img id="img" src="<?php echo base_url('uploads/car_pic/'.$post['user_id'].'/'. $post['car_pic']);?>" style="height: 200px;width: 300px"/>
                            </div>
                        <?php } else {
                            ?>
                            <img id="myno_img" style="width: 80px;height: 80px" src="<?php echo base_url() ?>assets/images/avatar/no-image.jpg" alt="your image" />
                        <?php }
                        ?>
                    </div>
                    <?php if (!empty($post['car_pic'])) {?>                       
                        <a href="<?php echo base_url('admin/download/car_pic/car_pic/'.$post['user_id']);?>" class="download1" data-folder="car_pic" data-driver="<?php echo $post['user_id']?>" data-file="car_pic">Download</a>
                    <?php }?>
                </div>
            </form>
        </div>
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