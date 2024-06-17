<!-- Forgot password  -->
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


     <form id="forgot-email-form">


        <div class="form-group">


          <label for="recipient-name" class="col-form-label">User Name or Email:</label>


          <input type="text" class="form-control" id="email" name="email">


        </div>


        <button type="button" class="btn btn-primary" id="forgot-email">Submit</button>


      </form>


  </div>


 


</div>





<script type="text/javascript">


  $('#forgot-email').on('click',function(){


    var email =$('[name="email"]').val();


    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;





    if (email=='') {


      $('#message').html('<div class="alert alert-danger" role="alert">Email field is required</div>');


      return false;


    }else if(reg.test(email) == false){
		
       $('#message').html('<div class="alert alert-danger" role="alert">Email is not valid</div>');

      return false;

      }


    $.ajax({


      url:base_url+'driver/login/forgot_password',


      data:{email:email},


      dataType:'json',


      type:'post',


      success:function(data){


        if (data.status) {


          //$('#forgot-form').modal('show');


          $('.forgot-form').html(data.div);


        }else{


          $('#message').html('<div class="alert alert-danger" role="alert">'+data.message+'</div>');


        }


      }


    });


  });


</script>


  