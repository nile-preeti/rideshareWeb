<!-- Add vehicle type -->

<style type="text/css">

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

.form-control {
    padding: 8px;
    height: auto;
    box-shadow: none;
    border: 1px solid #F0D8B6;
    background: rgba(38, 38, 38, 0.95);
    display: inline-block;
    width: 100%;
    color: #fff;
}


</style>



  <div class="oc-modal-box">

    <div class="oc-modal-heading">

      <h4 class="">Add vehicle type</h4>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">

      <span aria-hidden="true">&times;</span>

      </button>

    </div>

    <div class="oc-modal-form">

      <div id="msg"></div>

    <form action="#" method="post">
      <div class="row">
        <div class="form-group col-md-6 label-H">
          <label for="title">Vehicle type name</label>
          <input name="title" class="form-control"  id="title" value="<?php echo set_value('vehicle_type'); ?>">              
          <?php echo form_error('title'); ?>
        </div> 
        
        <div class="form-group col-md-6 label-H">
          <label for="title">Short description</label>
          <input name="short_description" class="form-control"  id="short_description" value="<?php echo set_value('short_description'); ?>">              
          <?php echo form_error('short_description'); ?>
        </div>

        <div class="form-group col-md-6 label-H">
              <label for="start_year">Start Year</label>
              <input name="start_year" class="form-control"  id="start_year">              
              <?php echo form_error('start_year'); ?>
            </div>
        <div class="form-group col-md-6 label-H">
          <label for="end_year">End Year</label>
          <input name="end_year" class="form-control"  id="end_year">              
          <?php echo form_error('end_year'); ?>
        </div>
        
        

        <div class="form-group col-md-12 label-H">
          <button type="button" class="btn btn-gr" id="submit">Add</button>
        </div>
      </div>
    </form>

    </div> 

  </div>

<script type="text/javascript">

  $(document).ready(function(){

    $(document).on('click','#submit',function(){

      var title = $('#title').val();
      var start_year = $('#start_year').val();
      var end_year = $('#end_year').val();

      var short_description = $('#short_description').val();

      

      if (title=='') {

        $('#msg').html('<div class="alert alert-danger" role="alert test">All the mandatory fields are required<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

        return false;

      }

      

      $.ajax({

        url:base_url+'admin/add_vehicle_type',

        data:{title:title,start_year:start_year,end_year:end_year,short_description:short_description},

        dataType:'json',

        type:'post',

        success:function(data){

          if (data.status) {

            location.reload(true)

          }

        }

      });

    });

  });

</script>