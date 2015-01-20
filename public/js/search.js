var search = {}

/*$(document).ready(function(){
	$('#search').change(function(e){
		search.criteria();
	});
	
});*/

search.indexInit = function (lat, lng)
{
    search.bindWindowScroll();
    
    //search.setWellWidth();
	search.setWellWidth();
	
	$('#mapWell .well').affix();

    if ($('#previewMap').exists())
    { 
        if (lat == 0) lat = undefined;
        if (lng == 0) lng = undefined;
        
        gm.initialize('previewMap', lat, lng, 11, false);
        
        search.loadListingMarkers();

        gm.loadSavedMarkers(false, false, false, '#savedMarkers');
        
        gm.autoCenter();
    }
    
    $('a#searchlink').on('click', function() {
        var location = $('#location').val().replace(/,/g, '');
        location = location.replace(/\s/g, '-').toLowerCase();
        console.log(location)
        $(this).attr('href', location);
        return true;
    });

    $('.sort').on('click', function(e) {
        e.preventDefault();
        var sortObj = $(this).find('i');
        if (sortObj.length == 0)
        {
            $('.sort i').remove();
            $(this).append(' <i class="fa fa-caret-down"></i>');
            $('#listContent .row .listing .listRight').each(function() {
                
            });
        }
        else
        {
            if ($(sortObj).hasClass('fa-caret-down'))
            {
                $(sortObj).removeClass('fa-caret-down').addClass('fa-caret-up');
            }
            else
            {
                $(sortObj).removeClass('fa-caret-up').addClass('fa-caret-down');
            }
        }
    });

    // executes function on resizing of window
    $(window).resize(function(){
        search.setWellWidth();
    });
};


search.setWellWidth = function ()
{
	// gets container width
	
	var cwidth = $('#content-container').width();
	
	//console.log("Container Width: " + cwidth);

	if (cwidth <= 768)
	{
		$('#mapWell .well').css('width', '100%');
	}
	else
	{
		var col8Width = $('.col-md-7').width();
		//console.log("Col-8 Width: " + col8Width);
	
		//var width = $('#mapWell .well').width();
		var width = cwidth - col8Width;
		
		$('#mapWell .well').css('width', width);
	}


}

search.bindWindowScroll = function ()
{
    $(window).scroll(function(){
	   if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
	       $(window).unbind('scroll');
	       //console.log("near bottom!");
	       search.loadMoreListings();
	       
	   }
	});
}

search.criteria = function (q, location)
{
    window.location.href = '/search/index/?&q=' + q + '&location=' + location;
}

search.viewlisting = function (id)
{
    window.location = '/search/info/' + id + '?lat=' + $('#lat').val() + '&lng=' + $('#lng').val() + '&q=' + escape($('#q').val()) + '&location=' + escape($('#location').val());
}

search.infoInit = function (lat, lng)
{
	var src = $('#display-img-src').val();
	
	//$('#displayImg').backstretch(src);
	
    if ($('#previewMap').exists())
    {
        if (lat == 0) lat = undefined;
        if (lng == 0) lng = undefined;

        gm.initialize('previewMap', lat, lng, 12, false);
        gm.loadSavedMarkers(false, false, false, '#savedMarkers', false);
    }
    $('a#uploadsTabButton').on('click', function(e) {
        e.preventDefault();
        $(this).addClass('active');
        global.ajaxLoader('#ajaxSwap');
        $.get('/search/uploads_content', {}, function(data) {
            $('#ajaxSwap').fadeOut('slow', function() {
                $(this).html(data);
                $(this).fadeIn('slow');
                $('#carousel').owlCarousel({
                    'items': 3,
                    'pagination': false
                });
                $('#carousel2').owlCarousel({
                    'items': 3,
                    'pagination': false
                });
                $('#top-left-nav').click(function() {
                    $('#carousel').trigger('owl.prev');
                });
                $('#top-right-nav').click(function() {
                    $('#carousel').trigger('owl.next');
                });
                $('#bottom-left-nav').click(function() {
                    $('#carousel2').trigger('owl.prev');
                });
                $('#bottom-right-nav').click(function() {
                    $('#carousel2').trigger('owl.next');
                });
            });
        });
    });
    $('a#menuButton').on('click', function(e) {
        e.preventDefault();
        $(this).addClass('active');
        global.ajaxLoader('#ajaxSwap');
        $.get('/search/menu_content', {}, function(data) {
            $('#ajaxSwap').fadeOut('slow', function() {
                $(this).html(data);
                $(this).fadeIn('slow');
            });
        });
    });
	if ($('#googleRefreshBtn').exists())
	{
		$('#googleRefreshBtn').click(function(e){
			search.manualUpdateFromGoogle();
		});
	}

    if ($('#claimBtn').exists())
    {
        $('#claimBtn').click(function(e){
            $('#claimModal').modal('show');
        });
    }

    $('#submitClaim').click(function(e){
        search.checkClaimForm();
    });
    
    search.renderLocationImgs();
    
    $(window).resize(function(){
	    search.renderLocationImgs();
    });
};

search.renderLocationImgs = function ($node)
{
	var rowHeight = 300;
	
	if ($(window).width() <= 768) rowHeight = 200
	if ($(window).width() <= 320) rowHeight = 100

	// no element to render images
	if ($('#location-photo-container') == undefined && $node == undefined) return false;

	if ($node == undefined) $node = $('#location-photo-container');
	console.log(rowHeight);
	$node.justifiedGallery({
		rowHeight: rowHeight,
		sizeRangeSuffixes: {
			'lt100':'', 
			'lt240':'', 
			'lt320':'', 
			'lt500':'', 
			'lt640':'', 
			'lt1024':''
		},
		margins:15
	});

}

search.checkReview = function ()
{
    if ($('#reviewName').exists())
    {
        if ($('#reviewName').val() == '')
        {
            global.renderAlert('Please enter your name!', undefined, 'reviewAlert');
            $('#reviewName').focus();
            $('#reviewName').effect('highlight');
            return false;
        }
    }

    if ($('#reviewEmail').exists())
    {
        if ($('#reviewEmail').val() == '')
        {
            global.renderAlert('Please enter your e-mail address!', undefined, 'reviewAlert');
            $('#reviewEmail').focus();
            $('#reviewEmail').effect('highlight');
            return false;
        }
    }

    if (parseInt($('#rating').val()) == 0)
    {
        global.renderAlert('Please select a rating', undefined, 'reviewAlert');
        $('#reviewStars').effect('highlight');
        return false;
    }


    if ($('#reviewDesc').val() == '')
    {
        global.renderAlert('Please enter a review.', undefined, 'reviewAlert');
        $('#reviewDesc').focus();
        $('#reviewDesc').effect('highlight');
        return false;
    }

    $('#reviewBtn').attr('disabled', 'disabled');

    $.post("/search/savereview", $('#reviewForm').serialize(), function(data){

        if (data.status == 'SUCCESS')
        {
            window.location = '/search/info/' + $('#location').val() + '?site-success=' + escape(data.msg);
            
            location.reload();
        }
        else
        {
            global.renderAlert(data.msg, 'alert-danger', 'reviewAlert');
            $('#reviewBtn').removeAttr('disabled');
        }
    }, 'json');

}

search.manualUpdateFromGoogle = function (b)
{
	if (!confirm("Are you sure you wish to update this location from Google Places?"))
	{
		return false;
	}

	$('#googleRefreshBtn i').addClass('fa-spin');
	$('#googleRefreshBtn').attr('disabled', 'disabled');

	$.getJSON('/search/upatefromgoogle/' + $('#id').val(), function(data){
		if (data.status == 'SUCCESS')
		{
			global.renderAlert(data.msg, 'alert-success');
			
			setTimeout(function(){
				location.reload();
			}, 2000);
			
			//$(location).attr('href') + '&site-success=' + data.msg;
		}
		else
		{
			global.renderAlert(data.msg, 'alert-danger');

			// resets button to default state
			$('#googleRefreshBtn i').removeClass('fa-spin');
			$('#googleRefreshBtn').removeAttr('disabled');
		}
	});
}

search.setRating = function (rating)
{

    if (rating == undefined) rating = $('#rating').val();

    for (var i = 1; i <= 5; i++)
    {

        if (i > rating)
        {
            $('#rating_star_' + i).removeClass('setRating');
        }
        else
        {
            $('#rating_star_' + i).addClass('setRating');
        }
    };

}

search.loadListingMarkers = function ()
{    
	$('#listContent').find('input').each(function(index, item){
		if ($(item).attr('type') == 'hidden' && $(item).attr('class') == 'gmMarker' && $(item).attr('loaded') == '0')
		{   
			//console.log(index)
			// loads point
			gm.addPoint(new google.maps.LatLng($(item).attr('lat'),$(item).attr('lng')), false, $(item).attr('radius'), false, false, $(item).attr('color'), $(item).attr('opacity'), $(item).attr('title'), $(item).attr('contentString'));
			
			// sets loaded to true
			$(item).attr('loaded', '1');
			//next_page_token = $(item).val();
			//console.log($(item).val());
		}
	});
	
	gm.autoCenter();
}

search.loadMoreListings = function ()
{
	var next_page_token;
	// show loading panel
	$('#loadingPanel').show('highlight');
	
	$('#listContent').find('input').each(function(index, item){
		if ($(item).attr('type') == 'hidden' && $(item).attr('id') == 'next_page_token')
		{
			next_page_token = $(item).val();
			//console.log($(item).val());
		}
	});
	
	//$.get('/dojos/listings/'+ $('#tail').val() + '?lat=' + $('#lat').val() + '&lng=' + $('#lng').val() + '&q=' + escape($('#q').val()), function(data){
	$.get('/search/listings/?next_page_token=' + escape(next_page_token) + '&lat=' + $('#lat').val() + '&lng=' + $('#lng').val(), function(data){
		$('#listContent').append(data);
		
		// calculates last hidden ID
		//dojos.getTailID();
	
		// hide loading panel
		$('#loadingPanel').hide('highlight');
		
		// check if there is a next_page_token, if so re-enable scroll functionality
		$('#listContent').find('input').each(function(index, item){
			if ($(item).attr('type') == 'hidden' && $(item).attr('id') == 'next_page_token')
			{
				next_page_token = $(item).val();
				//console.log($(item).val());
			}
		});
		
		if (next_page_token !== '')
		{
			search.bindWindowScroll();
		}
		
		search.loadListingMarkers();
	});
}


search.deactivate = function (b, location)
{
	if (confirm("Are you sure wish to deactive this listing?"))
	{
	
		$(b).attr('disabled', 'disabled');
	
		$.post('/search/deactiveLocation', { location:location, sportsToken:global.CSRF_hash }, function(data){
			if (data.status == 'SUCCESS')
			{
				global.renderAlert(data.msg, 'alert-success');
				
				// hide HTML element
				
				//alert($(b).parent().parent().parent().html());
				
				$(b).parent().parent().parent().addClass('animated fadeOut');
				
				$(b).parent().parent().parent().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(e)
				{
					$(this).removeAttr('class'); // clears all classes
					$(this).empty();
				});
			}
			else
			{
				$(b).removeAttr('disabled');
				global.renderAlert(data.msg, 'alert-danger');
			}
		}, 'json');
	}
}

search.checkClaimForm = function ()
{
    if ($('#name').val() == '')
    {
        global.renderAlert('Please enter your full name!', undefined, 'claimAlert');
        $('#name').focus();
        $('#name').effect('highlight');
        return false;
    }

    if ($('#phone').val() == '')
    {
        global.renderAlert('Please enter a contact number!', undefined, 'claimAlert');
        $('#phone').focus();
        $('#phone').effect('highlight');
        return false;
    }

    if ($('#position').val() == '')
    {
        global.renderAlert('Please enter your position in the business!', undefined, 'claimAlert');
        $('#position').focus();
        $('#position').effect('highlight');
        return false;
    }

    $('#submitClaim').attr('disabled', 'disabled');

    $.post("/search/saveclaim", $('#claimForm').serialize(), function(data){
        if (data.status == 'SUCCESS')
        {
            $('#claimModal').modal('hide');
            global.renderAlert(data.msg, 'alert-success');
            $('#claimForm')[0].reset();
        }
        else
        {
            global.renderAlert(data.msg, 'alert-danger', 'claimAlert');
        }

        $('#submitClaim').removeAttr('disabled');
    }, 'json');
}

search.writeReview = function ()
{
	// goes to first tab
	$('#infoTabs li:eq(0) a').tab('show');
	window.location = '#write_review';
}

search.photoAdjust = function (size)
{
	if (size == undefined) size = 235;
	
	$('#photos').find('img').each(function(index, item){
		$(item).attr('height', size);
		$(item).attr('width', size);
	});
	
}

search.loadGettingStartedModal = function ()
{
	$('#getStartedModal').modal('show');
}

$(document).ready(function(){
	$('.hover-img').hover(
	        function(){ 
	        	$(this).find('.hover-info').slideDown(250); //.fadeIn(250)
	        },
	        function(){
	        	$(this).find('.hover-info').slideUp(250); //.fadeOut(205)
	        }
	    ); 
	$('.item-img').hover(
        function(){ 
        	$(this).find('.hover-info').slideDown(250); //.fadeIn(250)
        },
        function(){
        	$(this).find('.hover-info').slideUp(250); //.fadeOut(205)
        }
    ); 
    $('.hover-info').click(function(e){ 
        location.href='/listings/product/'+$(this).attr('hover-info-id');
    });
	$('#dealsBtn').on('click', function(e){
		e.preventDefault();
		var url = $(this).attr('rel');
		doAjax(url);
	});
	$('#reviewsBtn').on('click', function(e){
		e.preventDefault();
		var url = $(this).attr('rel');
		doAjax(url);
	});	
	$('#revBtn').on('click', function(e){ 
		e.preventDefault();
		var url = $(this).attr('rel');
		console.log(url)
		doAjax(url);
	});
	$('#reviewBtn').on('click', function(e){ 
		e.preventDefault();
		var url = $(this).attr('rel');
		doAjax(url, true);
	});
	$('#uploadsBtn').on('click', function(e){ 
		e.preventDefault();
		var url = $(this).attr('rel');
		doAjax(url);
	});
    function doAjax(url){
    	$(this).addClass('active');
        global.ajaxLoader('#ajaxSwap');
        $.get(url, {}, function(data) {
            $('#ajaxSwap').fadeOut('slow', function() {
                $(this).html(data);
                $('#reviewBtn').click(function(e){
                    search.checkReview();
                });
                $('#reviewStars i').hover(function(e){
                    // console.log($(this).attr('value'));
                    search.setRating($(this).attr('value'));
                });
                $('#reviewStars').mouseout(function(){
                    search.setRating();
                });
                $('#reviewStars i').click(function(e){

                    var rating = parseInt($(this).attr('value'));

                    $('#rating').val(rating);

                    for (var i = 1; i <= 5; i++)
                    {
                        if (i > $(this).attr('value'))
                        {
                            $('#rating_star_' + i).removeClass('setRating');
                        }
                        else
                        {
                            $('#rating_star_' + i).addClass('setRating');
                        }
                    };
                });
                $(this).fadeIn('slow');
                $('#carousel6').owlCarousel({
                    'items': 3,
                    'pagination': false
                });
                $('#carousel7').owlCarousel({
                    'items': 3,
                    'pagination': false
                });
                $('#carousel8').owlCarousel({
                    'items': 3,
                    'pagination': false
                });
            });
        });
    }  
});
