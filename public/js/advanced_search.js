$(document).ready(function(e){
	
});

advanced_search = {}

advanced_search.hideShow = function(){	
	if ( $( "#advanced_search" ).is( ":hidden" ) ) {
	    $( "#advanced_search" ).slideDown( "slow" );
	    $( "#advanced_search_hide_show_button" ).html('HIDE ADVANCED SEARCH <i class="fa fa-caret-up icon_color"></i>');
	 } else {
	    $( "#advanced_search" ).slideUp('slow');
	    $( "#advanced_search_hide_show_button" ).html('ADVANCED SEARCH <i class="fa fa-caret-down icon_color"></i>');
	 } 
}