var deals = {}

deals.content = function(page, page_class){
	
	$('#'+page_class).attr('rel', 'active');
	
	var jqxhr = $.ajax( page )
	  .done(function(data) {
		  console.log(page)
	    $('#ajax-container').html(data);
	  })
	  .fail(function() {
		  console.log( "error" );
	  })
}  
$(document).ready(function(){	
	
	$('.left_list ul li a').click(function(e){
		e.preventDefault();
		//console.log($(this).attr('id') == 'profile')
		if($(this).attr('id') == 'profile'){
			location.href=$(this).attr('href');
		}
		
		$.each($('.left_list ul li a'), function(index, value){
			value.removeAttribute('class');
		});
		$(this).attr('class', 'active');
			
		var jqxhr = $.ajax( $(this).attr('href') )
		  .done(function(data) {
		    $('#ajax-container').html(data);
		  })
		  .fail(function() {
			  console.log( "error" );
		  })
	});
	
	$('.featured').click(function(e){ 
		e.preventDefault();
		var dealid = $(this).attr('id');
		//console.log(dealid)
		var request = $.ajax({
			url: "/admin/deals/setfeatured/"+dealid,
			type: "GET",
			//data: { dealid : dealid },
			dataType: "html"
		});
			 
		request.done(function( msg ) {
			console.log( msg );
			$('.featured').css('color', '#000');
			$('#'+dealid).css('color', 'gold');
		});
			 
		request.fail(function( jqXHR, textStatus ) {
			console.log( "Request failed: " + textStatus );
		});
	});
	
	$('.check-all').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
	
	$('.edit').click(function(e){
		e.preventDefault();
		
		var link = $(this).attr('href');
		
		$(function ()    {
		    $('<div>').dialog({
		        modal: true,
		        open: function ()
		        {
		            $(this).load(link);
		        },         
		        height: 600,
		        width: 400,
		        //title: 'Edit Deals',
		        show: { effect: "slideDown", duration: 800 }
		        
		    });
		});
		
	});
	
	$('.addw').click(function(e){
		e.preventDefault();
		
		var link = e.currentTarget.href;
		//console.log($(e).attr('href').val())
		$(function ()    {
		    $('<div>').dialog({
		        modal: true,
		        open: function ()
		        {
		            $(this).load(link);
		        },         
		        height: 600,
		        width: 400,
		        //title: 'Add A New Deal',
		        show: { effect: "slideDown", duration: 800 }
		        
		    });
		});
		
	});
});

