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

        <div class="form-group">

          <label for="title">Vehicle type name</label>

          <input name="title" class="form-control"  id="title" value="<?php echo set_value('vehicle_type'); ?>">              

          <?php echo form_error('title'); ?>

        </div> 

        <div class="form-group">

          <label for="title">

            Rate(/Km)

          </label>

          <input name="rate" class="form-control"  id="rate" value="<?php echo set_value('rate'); ?>">              

          <?php echo form_error('rate'); ?>

        </div> 

        <div class="form-group">

          <label for="title">Short Description</label>

          <input name="short_description" class="form-control"  id="short_description" value="<?php echo set_value('short_description'); ?>">              

          <?php echo form_error('short_description'); ?>

        </div> 

        <div class="form-group">

          <button type="button" class="btn btn-gr" id="submit">Add</button>

        </div>

      </form>

    </div> 

  </div>

<script type="text/javascript">

  $(document).ready(function(){

    $(document).on('click','#submit',function(){

      var title = $('#title').val();

      var short_description = $('#short_description').val();

      var rate = $('#rate').val();

      if (title=='') {

        $('#msg').html('<div class="alert alert-danger" role="alert">Vehicle type name is required<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

        return false;

      }

      if (rate=='') {

        $('#msg').html('<div class="alert alert-danger" role="alert">Rate field is required<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

        return false;

      }

      $.ajax({

        url:base_url+'admin/add_vehicle_type',

        data:{title:title,rate:rate,short_description:short_description},

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