//[Data Table Javascript]


//all courses search and pagination 

$(function () {
    "use strict";
  
  ///user user-courses search and pagination 
   	$('#user-courses').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
    'paging': true,
  'scrollX': true,
	'lengthChange': true,
	'searching'   : true,
	'ordering'    : true,
	'info'        : true,
	'autoWidth'   : false,
		
	} );
	
	
   ///user rejectPayments search and pagination 
   	$('#example').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
    'paging': true,
  'scrollX': true,
	'lengthChange': true,
	'searching'   : true,
	'ordering'    : true,
	'info'        : true,
	'autoWidth'   : false,
		
	} );
    ///user rejectPayments search and pagination 
    	$('#rejectPayments').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
    'paging': true,
  'scrollX': true,
	'lengthChange': true,
	'searching'   : true,
	'ordering'    : true,
	'info'        : true,
	'autoWidth'   : false,
		
	} );
	
    ///user requestPayment search and pagination 
    	$('#paidPayments').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
    'paging': true,
  'scrollX': true,
	'lengthChange': true,
	'searching'   : true,
	'ordering'    : true,
	'info'        : true,
	'autoWidth'   : false,
		
	} );
	
///user requestPayment search and pagination 
		$('#requestPayment').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
    'paging': true,
  'scrollX': true,
	'lengthChange': true,
	'searching'   : true,
	'ordering'    : true,
	'info'        : true,
	'autoWidth'   : false,
		
	} );
	
	
	
	
	$('#example1').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
    'paging': true,
  'scrollX': true,
	'lengthChange': true,
	'searching'   : true,
	'ordering'    : true,
	'info'        : true,
	'autoWidth'   : false,
		
	} );
		///user account search and pagination 

	$('#userAccount').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
    'paging': true,
  'scrollX': true,
	'lengthChange': true,
	'searching'   : true,
	'ordering'    : true,
	'info'        : true,
	'autoWidth'   : false,
		
	} );
	

 }); // End of use strict