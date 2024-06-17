// JavaScript Document
jQuery(document).ready(function($){
	$('[name="from"]').datepicker({
      format: 'mm/dd/yyyy',     
        todayHighlight: true,
        //startDate: '-0m',
        autoclose: true
    });
    $('[name="to"]').datepicker({
      format: 'mm/dd/yyyy',     
        todayHighlight: true,
        //startDate: '-0m',
        autoclose: true
    });
	
});