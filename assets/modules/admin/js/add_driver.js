$(document).on('change', '.brand', function () {
	var brand_id = $(this).val();
	var data_id = $(this).attr('data');
	
	$.ajax({
		url:base_url+'admin/get_brand_model',
		type:'post',
		dataType:'json',
		data:{brand_id:brand_id},
		success:function(data){
			if (data.status) {
				
				option='';
				$.each(data.data, function( index, value ) {
					option+='<option value="'+value.id+'">'+value.model_name+'</option>';
				  
				});
				$('#model_'+data_id).html(option);
			}
		}
	})
	
});
$(document).on('change','.vehicle_type',function(){
	
	var rate = $(this).children("option:selected").attr('rate');
	var data_id = $(this).attr('data');
	$('#rate_'+data_id).val(rate);

});
$(document).ready(function(){
 	var x = 1;
    var maxField = 3; //Input fields increment limitation
    var addButton = $('#add-more'); //Add button selector
    var wrapper = $('.add-wrapper'); //Input field wrapper
    //Once add button is clicked
    $(addButton).click(function(){ 
    	var data_id = parseInt($(this).attr('data'))+1;
    	
	    var fieldHTML=''; 
	    var option =''; 
	    if(x < maxField){ 
	        $.ajax({
	            url:base_url+'admin/add_more_vehicle',
	            type:'get',
	            dataType:'json',	           
	            data:{data_id:data_id},	           
	            success:function(res){ 
		            fieldHTML =res.html;
		            $(wrapper).append(fieldHTML);
	            }
	        });
	    }
	});
    //Once remove button is clicked
    $(wrapper).on('click', '.remove', function(e){
        e.preventDefault(); 
        $(this).parents('div>.add-dynamic').remove();
        x--;
    });
});
$(document).ready(function() {
	jQuery.validator.addClassRules('brand', {
       
        required: true

    });

    jQuery.validator.addClassRules('model', {

        required: true,
        

    }); 
    jQuery.validator.addClassRules('year', {

        required: true,
        

    });
    jQuery.validator.addClassRules('vehicle_type', {
        required: true,

    });
    jQuery.validator.addClassRules('rate', {
        required: true,
        

    });
    jQuery.validator.addClassRules('vehicle_no', {
        required: true,
        

    });
    jQuery.validator.addClassRules('color', {
        required: true,
       

    });
    /*jQuery.validator.addClassRules('car_pic', {

        required: true,

        

    });*/
   
    $("#add_driver").validate({

        rules:{
        	name:{
        		required:true
        	},
        	email:{
        		required:true,
        		remote:base_url+'admin/remote_useremail_check',
        	},
        	mobile:{
        		required:true
        	},
        	

        },
        messages: {
		    email: {
		        remote: "Email is already exist"
		    }
		},

        errorElement: "small",

        errorPlacement: function ( error, element ) {

            error.addClass( "text-danger" );

            error.insertAfter( element );

        },

        focusInvalid: false,

        invalidHandler: function(form, validator) {

            if (!validator.numberOfInvalids()) return;

        },

        /*submitHandler: function(form) {
             var formData = $('#work-invoice-form').serialize();
            $.ajax({

                type: 'post',

                url: base_url + "admin/submit_invoice",

                data: formData,

                dataType: 'json',

                beforeSend: function() {

                    $(".Submit-form-button").html('Apply <i class="fa fa-spinner fa-spin"></i>').attr('disabled', true);

                    $(".error-message").html('');

                },

                success: function(res) {

                    if(res.status){

                        $('.invoice-summary').html(res.html);

                        window.location.replace(base_url+'admin/posted_job');

                    }

                }

            });

           

        }*/

    });
});