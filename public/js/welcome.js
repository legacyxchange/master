var welcome = {}

jQuery(document).ready(function($){
		
});

welcome.BGadjust = function ()
{
	var winW = $(window).width();
	var winH = $(window).height();
	
	//global.log("Win W: " + winW + " | Win H: " + winH);
	
	var imgOrgW = $('#bgOrgW').val()
	var imgOrgH = $('#bgOrgH').val();
	
	var aspectRatio = imgOrgW / imgOrgH;
		
	// gets main container width & height
	/*
	var mcW = $('.maincontainer').width();
	var mcH = $('.maincontainer').height();
	*/
	
	var mcW = $('.main-content').width();
	var mcH = $('.main-content').height();
	
	//global.log("IMG W: " + imgOrgW + " | IMG H: " + imgOrgH + " | ASPECT Ratio: " + aspectRatio + " | mcW: " + mcW + " | mcH: " + mcH);

	//$('#bgImg').attr('width', mcW);
	

	
	// will adjust background image to proper size
	if (mcW >= mcH)
	{
		//$('#bgImg').removeAttr('height');
		//global.log("New Width: " + (mcW / aspectRatio));	
		
		
		$('#bgImg').attr('width', '100%');
		$('#bgImg').attr('height', mcH);
		//$('.maincontainer').css('background-size', '100%, 100%');	
	}
	else
	{
		$('#bgImg').attr('width', (mcW * aspectRatio));
		$('#bgImg').attr('height', mcH);

	}
	
	
}

welcome.landingInit = function ()
{
	$('#regLink').click(function(e){
	    global.loadSignup(true);
    });
}

welcome.getStarted = function ()
{
	window.location = "/dojos?q=&location=" + escape("Las Vegas, NV");
}




welcome.loadGettingStartingModal = function (b, autoSubmit)
{
	if (autoSubmit == undefined) autoSubmit = true;

	$('#getStartedModal').modal('show');
	
	welcome.getLocationModal(autoSubmit);
}

welcome.styleSelectModal = function (sel)
{
	$('#modalSearch #q').val($(sel).text());
}

welcome.getLocationModal = function (autoSubmit)
{
    if (navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(function(loc){
	        welcome.setLocation(loc, autoSubmit);
        }, welcome.unableToFindLoc);
    }
}

welcome.setLocation = function (loc, autoSubmit)
{
	// if (autoSearch == undefined) autoSearch = false;
	//console.log(JSON.stringify(loc));

    $('#modalSearch #lat').val(loc.coords.latitude);
    $('#modalSearch #lng').val(loc.coords.longitude);
    
    $.getJSON('/welcome/geotargetlocation?lat=' + loc.coords.latitude + '&lng=' + loc.coords.longitude, function(data)
    {
	    if (data.status == 'SUCCESS')
	    {
	    	$('#modalSearch #location').first().val(data.msg);
		    $('#modalSearch .locator').text(data.msg);
		    
		    //$('#modalSearch #location').show();
		    
		    if (autoSubmit == true) $('#modalSearch').submit();
		    
		    //$('#getStartedModal button').removeAttr('disabled');
	    }
    });
    
    //$('#location').val('Current Location');

    // re-enable location btn stop spinning
    $('#locatorLink i, #xs-search #xsLocatorBtn i').removeClass('fa-spin');
    $('#locatorLink, #xs-search #xsLocatorBtn').removeClass('locatorNoCursor');
    
    
    //$('#locatorLink').removeAttr('disabled');
}

welcome.unableToFindLoc = function ()
{
	$('#getStartedModal button').removeAttr('disabled');
	
	$('#modalSearch #unableTxt').show();
	
	$('#modalSearch button').show();
	
	$('#modalSearch #location').last().show();
	$('#modalSearch #location').last().focus();

    //console.log("Unable to find location");
    global.renderAlert('Unable to find your location', undefined, 'getStartedAlert');
    $('#modalSearch #locatorIcon').hide();
}


welcome.bluespaModalSubmit = function (b)
{
	$(b).attr('disabled', 'disabled');
	$('#modalSearch').submit();
}

welcome.modalSubmit = function (submitForm)
{
	if (submitForm == undefined) submitForm = true;

	if ($('#modalSearch #q').val() == '')
	{
		global.renderAlert("Please enter a sport to search for.", undefined, 'getStartedAlert');
		$('#modalSearch #q').focus();
		return false;
	}

	$('#modalSearch .searchBtn').attr('disabled', 'disabled');
	
	$('#modalSearch .searchBtn i').removeClass('fa-search');
	$('#modalSearch .searchBtn i').addClass('fa-spin');
	$('#modalSearch .searchBtn i').addClass('fa-spinner');
	
	if (submitForm == true) $('#modalSearch').submit();

	return true;
}