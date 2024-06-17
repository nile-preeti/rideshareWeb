<!-- Editing an driver details -->

<style type="text/css">

    .heading-popup{padding:10px; background: #3c485c;  margin-bottom: 20px;}

    .heading-popup h4{margin-bottom: 0px; color: #fff; font-size: 14px;}

    .panel .panel-body {padding: 0px 0px 0px; }

    .mt-20{margin-top: 20px;}

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



<script>

    function imageIsLoadededit(e) {

        $('#myImgedit').show();

        $('#myno_img').hide();

        $('#myImgedit').attr('src', e.target.result);

        $('#image-div').hide();

    };

    $(function(){

        $('#myImgedit').hide();

        $("#edituploadBtn").change(function () {

            $(".edit-file").val($("#edituploadBtn").val());

            if (this.files && this.files[0]) {

                var reader = new FileReader();

                reader.onload = imageIsLoadededit;

                reader.readAsDataURL(this.files[0]);

            }

        });

       

    });

</script>


<?php if(!empty($bankdata)){?>
<div class="panel widget oc-panel light-widget">
   <div class="panel-heading">
        <div class="row">
            <div class="col-md-6"> 
                <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Edit Driver Bank Details  </h3>
            </div>

            <div class="col-md-6">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

        </div>

    </div>

    <div class="panel-body">
        <div class="panel widget">            
            <div  class="search-filter">
                <form enctype="multipart/form-data" class="form-horizontal"  action="<?php echo $this->config->base_url() ?>admin/drivers/updateBankDetails" method="post" role="form" id="register-form">
                    <input type="hidden" value="<?php echo!empty($bankdata['user_id']) ? $bankdata['user_id'] : ''; ?>" name="user_id" id="user_id"/>
                    <div class="row">
                        <div class="col-md-6 mb-10 label-H">
                            <label class="control-label">Account holder name<span class="vd_red">*</span></label>
                              <?php //echo $bankdata['account_holder_name'];  ?>
                            <div id="first-name-input-wrapper"  class="controls">
                                <?php $account_holder_name = encrypt_decrypt('decrypt',$bankdata['account_holder_name']); ?>        
                                <input type="text" placeholder="John" value="<?php echo!empty($account_holder_name) ? $account_holder_name : ''; ?>" class="width-120 required" name="account_holder_name" id="account_holder_name" required >
                            </div>

                        </div>

        

                        <div class="col-md-6 mb-10 label-H">

                            <label class="control-label">Bank name</label>

                            <div id="website-input-wrapper"  class="controls">
                                <?php $bank_name = encrypt_decrypt('decrypt',$bankdata['bank_name']); ?>
                                <input type="text" placeholder="+66 1234 56789" class="width-120" value="<?php echo!empty($bank_name) ? $bank_name : ''; ?>"  name="bank_name" id="bank_name" disabled>

                            </div>

                        </div>

                        <div class="col-md-6 mb-10 label-H">

                            <label class="control-label" >Routing number <span class="vd_red">*</span></label>

                            <div id="email-input-wrapper"  class="controls">
                                <?php $routing_number = encrypt_decrypt('decrypt',$bankdata['routing_number']); ?>
                                <input type="number" placeholder="bankdata" class="width-120 required" required value="<?php echo!empty($routing_number) ? $routing_number : ''; ?>" name="routing_number" id="routing_number" disabled>

                            </div>

                        </div>

                         

                        <div class="col-md-6 mb-10 label-H">

                            <label for="rate">Account Number<span class="text-danger">*</span></label>
                            <?php $account_number = encrypt_decrypt('decrypt',$bankdata['account_number']); ?>
                            <input type="text" class="form-control" id="account_number" placeholder="" name="account_number" value="<?php echo!empty($account_number) ? $account_number: ''; ?>"> 
                            <?php echo form_error('account_number'); ?>
                        </div>

         

                        <div class="col-md-4 mb-10 label-H">

                            <label class="control-label">Status</label>

                            <div id="email-input-wrapper"  class="controls">

                                <div class="vd_radio radio-success">
                                    
                                    <input type="radio" <?php echo!empty($bankdata['status']) ? $bankdata['status'] == 1 ? 'checked' : ''  : '' ?> class="radiochk status" value="1" id="optionsRadios8" name="status">

                                    <label for="optionsRadios8"> Active</label>

                                    <input type="radio" <?php echo empty($bankdata['status']) ? 'checked' : '' ?> value="0" class="radiochk status" id="optionsRadios9" name="status">

                                    <label for="optionsRadios9"> Deactive</label>

                                </div>

                            </div>

                        </div>                   
                        
                        <div class="mgtp-10 col-md-12">

                            <button class="btn vd_bg-green vd_white" type="button" id="submit-register" name="submit-register">Submit</button>

                        </div>

                    </div>
                </form>
            </div>           
		</div>
    </div>
</div>

<?php }else{?>
           
			<div class="panel widget oc-panel light-widget">
   <div class="panel-heading">
        <div class="row">
            <div class="col-md-6"> 
                <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Add driver bank details  </h3>
            </div>
            <div class="col-md-6">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="panel widget">            
            <div  class="search-filter">
                <form enctype="multipart/form-data" class="form-horizontal"  action="<?php echo $this->config->base_url() ?>admin/drivers/addbankDetails" method="post" role="form" id="add-bank">
                    <input type="hidden" value="<?php echo $usrid; ?>" name="user_id" id="user_id"/>
                    <div class="row">
                        <div class="col-md-6 mb-10 label-H">
                            <label class="control-label">Account holder name<span class="vd_red">*</span></label> <div id="first-name-input-wrapper"  class="controls">                                        
                                <input type="text" placeholder="John"  class="form-control" name="account_holder_name" id="account_holder_name" disabled />
                            </div>
                        </div>       

                        <div class="col-md-6 mb-10 label-H">
                            <label class="control-label">Bank name</label>
                            <div id="website-input-wrapper"  class="controls">                                
                                <input type="text" value="Republic Bank & Trust" class="form-control"   name="bank_name" id="bank_name" disabled >
                            </div>
                        </div>

                        <div class="col-md-6 mb-10 label-H">
                            <label class="control-label" >Routing number <span class="vd_red">*</span></label>
                            <div id="website-input-wrapper"  class="controls">                                
                                <input type="number" value="264171241" class="form-control"  name="routing_number" id="routing_number" disabled >
                            </div>
                        </div>                         

                        <div class="col-md-6 mb-10 label-H">
                            <label for="rate">Account number<span class="text-danger">*</span></label>                            
                            <input type="text" class="form-control" id="account_number" placeholder="Account Number" name="account_number"> 
                            <?php echo form_error('account_number'); ?>
						</div>         

                        <div class="col-md-4 mb-10 label-H">
                            <label class="control-label">Status</label>
                            <div id="email-input-wrapper"  class="controls">
                                <div class="vd_radio radio-success">                                    
                                    <input type="radio"  class="radiochk status" value="1" id="optionsRadios8" name="status" checked="checked">
                                    <label for="optionsRadios8"> Active</label>
                                    <input type="radio"  value="0" class="radiochk status" id="optionsRadios9" name="status">
                                    <label for="optionsRadios9"> Deactive</label>
                                </div>
                            </div>
                        </div>                   
                        
                        <div class="mgtp-10 col-md-12">
                            <button class="btn vd_bg-green vd_white" type="button" id="submit-bank" name="submit-bank">Add bank details</button>

                        </div>

                    </div>
                </form>
            </div>           
		</div>
    </div>
</div>
 <?php } ?>

<script type="text/javascript">
    $(document).on('click','#submit-register',function(){
        var account_holder_name = $('#account_holder_name').val();
        var bank_name = $('#bank_name').val();
        var account_number = $('#account_number').val();
        var routing_number = $('#routing_number').val();
        var user_id = $('#user_id').val();
        var status = $('.status:checked').val();
		//alert(user_id);

        $.ajax({
            url:base_url+'admin/update_bank',
            type:'post',
            dataType:'json',
            data:{account_holder_name:account_holder_name,bank_name:bank_name,account_number:account_number,routing_number:routing_number,status:status,user_id:user_id},
            success:function(data){
                alert(data.message);
                location.reload();
            }
        });
    });
	
	$(document).on('click','#submit-bank',function(){
        var account_holder_name = $('#account_holder_name').val();
        var bank_name = $('#bank_name').val();
        var account_number = $('#account_number').val();
        var routing_number = $('#routing_number').val();
        var user_id = $('#user_id').val();
        var status = $('.status:checked').val();
		//alert(user_id);

        $.ajax({
            url:base_url+'admin/add_bank',
            type:'post',
            dataType:'json',
            data:{account_holder_name:account_holder_name,bank_name:bank_name,account_number:account_number,routing_number:routing_number,status:status,user_id:user_id},
            success:function(data){
                alert(data.message);
                location.reload();
            }
        });
    });
   
</script>