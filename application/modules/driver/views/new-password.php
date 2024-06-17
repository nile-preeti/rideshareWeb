 <!-- Forgot password page  -->
<style type="text/css">


  .modal-content {


      background: #fff;


  }


</style>


<div class="modal-content">


  <div class="modal-header">


    <h5 class="modal-title" id="exampleModalLongTitle">Forgot Password</h5>


    <button type="button" class="close" data-dismiss="modal" aria-label="Close">


      <span aria-hidden="true">&times;</span>


    </button>


  </div>


  <div class="modal-body">


    <div id="message"></div>


     <form id="forgot-password-form" method="post">


        <div class="form-group">


          <input type="hidden" name="user_id" id="user_id" value="<?php echo encrypt_decrypt('encrypt',$user_detail->user_id);?>">


          <label for="password" class="col-form-label">New Password:</label>


          <input type="password" class="form-control" id="password" name="password">


        </div>


         <div class="form-group">


          <label for="confirm_password" class="col-form-label">Confirm Password:</label>


           <input type="password" class="form-control" id="confirm_password" name="confirm_password">


        </div>


        <button type="button" class="btn btn-primary" id="forgot">Submit</button>


      </form>


  </div>


 


</div>





<script type="text/javascript">


  $('#forgot').on('click',function(){


   


    var password='';


    var confirm_password='';


    password =$('#password').val();


    confirm_password =$('#confirm_password').val();


    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;





    if (password=='') {


      $('#message').html('<div class="alert alert-danger" role="alert">Password is required</div>');


      return false;


    }else if (confirm_password=='') {


       $('#message').html('<div class="alert alert-danger" role="alert">Confirm Password is required</div>');


       return false;


    }else if(password!=confirm_password){


      $('#message').html('<div class="alert alert-danger" role="alert">Your confirm password must be same to password</div>');


      return false;


    }





    $.ajax({


      url:base_url+'driver/login/forgot',


      data:{password:password,user_id:$('#user_id').val()},


      dataType:'json',


      type:'post',


      success:function(data){


        if (data.status) {


          $('#forgot-password-form').hide('fast');


           $('#message').html('<div class="alert alert-success" role="alert">'+data.message+'</div>');


        }else{


          $('#message').html('<div class="alert alert-danger" role="alert">'+data.message+'</div>');


        }


      }


    });


  });


</script>


  