$(function() {
  'use strict';

  if($('#datePickerExample').length) {
    var date = new Date();
    var today = new Date(date.getDate(), date.getMonth(), date.getFullYear());
    // new Date(date.getFullYear(), date.getMonth(), date.getDate()); 
    $('#datePickerExample').datepicker({ 
      dateFormat:"dd-mm-yy",
      todayHighlight: true,
      autoclose: true
    });
    $('#datePickerExample').datepicker('setDate', today);
  }
  if($('#datePickerExample2').length) {
    var date = new Date();
    var today = new Date(date.getDate(), date.getMonth(), date.getFullYear());
    // new Date(date.getFullYear(), date.getMonth(), date.getDate()); 
    $('#datePickerExample2').datepicker({ 
      format: "dd/mm/yyyy",
      todayHighlight: true,
      autoclose: true
    });
    $('#datePickerExample2').datepicker('setDate', today);
  }

  

  if($('#tgl_awal').length) {
    var date = new Date();
    var today = new Date(date.getDate(), date.getMonth(), date.getFullYear());
    // new Date(date.getFullYear(), date.getMonth(), date.getDate()); 
    $('#tgl_awal').datepicker({ 
      format: "yyyy/mm/dd",
      todayHighlight: true,
      autoclose: true
    });
    $('#tgl_awal').datepicker('setDate', today);
  }
  if($('#tgl_akhir').length) {
    var date = new Date();
    var today = new Date(date.getDate(), date.getMonth(), date.getFullYear());
    // new Date(date.getFullYear(), date.getMonth(), date.getDate()); 
    $('#tgl_akhir').datepicker({ 
      format: "yyyy/mm/dd",
      todayHighlight: true,
      autoclose: true
    });
    $('#tgl_akhir').datepicker('setDate', today);
  }
  
});


