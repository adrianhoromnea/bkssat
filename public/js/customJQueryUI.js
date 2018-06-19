

//** datePicker */
    //**date picker restricted >= today*/
   $( ".datePickerRestr" ).datepicker({dateFormat: 'yy-mm-dd',minDate: 0, maxDate: "+1M +10D"});

   $(".datePickerRestrToday").datepicker({dateFormat: 'yy-mm-dd',minDate: 0, maxDate: "+1M +10D"}).datepicker("setDate",new Date());

   //**tomorrow */
   var today = new Date();
   today.setDate(today.getDate()+1);
   $(".datePickerRestrTomorrow").datepicker({dateFormat: 'yy-mm-dd',minDate: 0, maxDate: "+1M +10D"}).datepicker("setDate",today);

   
   $( ".datePickerRestrMonth" ).datepicker({dateFormat: 'yy-mm-dd',stepMonths:0});

   



