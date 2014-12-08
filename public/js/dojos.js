var dojos = {}

dojos.indexInit = function (lat, lng)
{
	dojos.setWellWidth();

    if ($('#previewMap').exists())
    {
        if (lat == 0) lat = undefined;
        if (lng == 0) lng = undefined;

        gm.initialize('previewMap', lat, lng, 11, false);
        
   
        	dojos.loadListingMarkers();
		
        //gm.loadSavedMarkers(false, false, false, '#savedMarkers');
    }
    
    
    //dojos.getTailID();
    
    dojos.bindWindowScroll();


    // executes function on resizing of window
    $(window).resize(function(){
        dojos.setWellWidth();
    });



	//$('#mapWell').affix();
}


dojos.setWellWidth = function ()
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

dojos.bindWindowScroll = function ()
{
    $(window).scroll(function(){
	   if($(window).scrollTop() + $(window).height() > $(document).height() - 1) {
	       $(window).unbind('scroll');
	       
	       dojos.loadMoreListings();
	       //alert("near bottom!");
	   }
	});
}


/**
* DEPRECATED - gets the ID of the last location loaded
*/
/*
dojos.getTailID = function ()
{
	var latest = 0;

	$('#listContent').find('input').each(function(index, item){
		if ($(item).attr('type') == 'hidden')
		{
			latest = $(item).val();
			//console.log($(item).val());
		}
	});
	
	// updates hidden tail input
	
	$('#tail').val(latest);
}
*/

dojos.loadMoreListings = function ()
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
	$.get('/dojos/listings/?next_page_token=' + escape(next_page_token) + '&lat=' + $('#lat').val() + '&lng=' + $('#lng').val(), function(data){
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
			dojos.bindWindowScroll();
		}
		
		dojos.loadListingMarkers();
	});
}


dojos.loadListingMarkers = function ()
{
	$('#listContent').find('input').each(function(index, item){
		if ($(item).attr('type') == 'hidden' && $(item).attr('class') == 'gmMarker' && $(item).attr('loaded') == '0')
		{
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

dojos.deactivate = function (b, location)
{
	if (confirm("Are you sure wish to deactive this listing?"))
	{
	
		$(b).attr('disabled', 'disabled');
	
		$.post('/dojos/deactiveLocation', { location:location, karateToken:global.CSRF_hash }, function(data){
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


dojos.infoInit = function (lat, lng)
{
	var src = $('#display-img-src').val();
	
	$('#displayImg').backstretch(src);
	
	$('#tabs li:eq(' + parseInt($('#tab').val()) + ') a').tab('show') // Select third tab (0-indexed)

    if ($('#previewMap').exists())
    {
        if (lat == 0) lat = undefined;
        if (lng == 0) lng = undefined;

        gm.initialize('previewMap', lat, lng, 12, false);
        gm.loadSavedMarkers(false, false, false, '#savedMarkers', false);
    }


    $('#reviewBtn').click(function(e){
        dojos.checkReview();
    });

    $('#reviewStars i').hover(function(e){
        // console.log($(this).attr('value'));
        dojos.setRating($(this).attr('value'));
    });

    $('#reviewStars').mouseout(function(){
        dojos.setRating();
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

    if ($('#claimBtn').exists())
    {
        $('#claimBtn').click(function(e){
            $('#claimModal').modal('show');
        });
    }

    $('#submitClaim').click(function(e){
        dojos.checkClaimForm();
    });
    
    $('#closeVideoModalBtn').click(function($e){
		$('#videoPreviewModal').modal('hide');
	})
	
	if ($('#googleRefreshBtn').exists())
	{
		$('#googleRefreshBtn').click(function(e){
			dojos.manualUpdateFromGoogle();
		});
	}
	
	
    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
    event.preventDefault();
    return $(this).ekkoLightbox({
        onShown: function() {
            if (window.console) {
                return console.log('lightbox shown');
            }
        }
    });
});

//Programatically call
$('#open-image').click(function (e) {
    e.preventDefault();
    $(this).ekkoLightbox();
});
$('#open-youtube').click(function (e) {
    e.preventDefault();
    $(this).ekkoLightbox();
});


	/*
	$('#imgSortable').find('img').each(function(index, item){
		$(item).click(function(e){
			lightbox.showLightbox($('#id').val(), $(this).attr('file'));
		});
		//console.log($(item).attr('file'));
	});
	*/
	
	/*
	$('#imgSortable').find('li').each(function(index, item){
		$(item).click(function(e){
		
			$('#displayImg').attr('src', '/public/uploads/locationImages/' + $('#id').val() + '/' + $(this).attr('file'));
		});
		
	});
	*/
}

dojos.adjustPhotos = function ()
{
	$('#photos').find('img').each(function(index, item){
		$(item).attr('width', '235');
		$(item).attr('height', '235');
	});
}

dojos.setRating = function (rating)
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

dojos.viewlisting = function (id)
{
    window.location = '/dojos/info/' + id + '?lat=' + $('#lat').val() + '&lng=' + $('#lng').val() + '&q=' + escape($('#q').val()) + '&location=' + escape($('#location').val());
}

dojos.checkReview = function ()
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

    $.post("/dojos/savereview", $('#reviewForm').serialize(), function(data){

        if (data.status == 'SUCCESS')
        {
            window.location = '/dojos/info/' + $('#location').val() + '?site-success=' + escape(data.msg);
            location.reload();
        }
        else
        {
            global.renderAlert(data.msg, 'alert-danger', 'reviewAlert');
            $('#reviewBtn').removeAttr('disabled');
        }
    }, 'json');

}

dojos.checkClaimForm = function ()
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

    $.post("/dojos/saveclaim", $('#claimForm').serialize(), function(data){
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

dojos.previewVideo = function (title, videoID)
{
	// changes title
	$('#videoPreviewModal h3.video-title').text(title);
	
	$('#videoPreviewModal iframe').attr('src', "https://www.youtube.com/v/" + videoID + "?version=3&f=videos&app=youtube_gdata");

	$('#videoPreviewModal').modal('show');
}

dojos.manualUpdateFromGoogle = function (b)
{
	if (!confirm("Are you sure you wish to update this location from Google Places?"))
	{
		return false;
	}

	$('#googleRefreshBtn i').addClass('fa-spin');
	$('#googleRefreshBtn').attr('disabled', 'disabled');

	$.getJSON('/dojos/upatefromgoogle/' + $('#id').val(), function(data){
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

dojos.loadEventModal = function (event, time)
{
	time = time.replace('&dash;', '-');

    $.get("/dojos/event_modal/" + event + '/' + $('#eventLocation').val() + '/' + $('#month').val() + '/' + $('#year').val() + "?time=" + escape(time), function(data){
        $('#eventModal').html(data);
        $('#eventModal').modal('show');
        
        
        var lat = $('#eventModal #lat').val();
        var lng = $('#eventModal #lng').val();

        gm.initialize('eventMap', lat, lng, 14, false);

        var location = new google.maps.LatLng(lat, lng);

        gm.addPoint(location, false);
    });
}

dojos.attendEvent = function (b, event, eventTime, displayCnt)
{
	
	$(b).attr('disabled', 'disabled');
	$(b).find('i').removeClass('fa-plus');
	$(b).find('i').addClass('fa-spin');
	$(b).find('i').addClass('fa-spinner');
	
	// gets current num attending
	var attendCnt = parseInt($('#attendCnt_' + displayCnt).val());
	

	$.post('/dojos/attendevent', { event: event, eventTime: eventTime, karateToken:global.CSRF_hash }, function(data){

	    if (data.status == 'SUCCESS')
        {
            global.renderAlert(data.msg, 'alert-success', 'eventAlert' + displayCnt);
            
			$(b).removeAttr('disabled', 'disabled');
			$(b).find('i').removeClass('fa-spin');
			$(b).find('i').removeClass('fa-spinner');
			
			// changes button type
			$(b).removeClass('btn-default');
			$(b).addClass('btn-danger');
			
			$(b).html("<i class='fa fa-minus'></i> Unattend Event");
			
			// change onclick function
			$(b).attr('onclick', "dojos.unattendEvent(this, " + event + ", '" + eventTime +"', " + displayCnt + ");");
			
			// updates number attending
			$('#attendCntDisplay_' + displayCnt).text((attendCnt + 1) + " Attending");
			
			// updates hidden input
			$('#attendCnt_' + displayCnt).val(attendCnt + 1);
        }
        else
        {
            global.renderAlert(data.msg, 'alert-danger', 'eventAlert' + displayCnt);
            
            // resets button
			$(b).removeAttr('disabled', 'disabled');
			$(b).find('i').addClass('fa-plus');
			$(b).find('i').removeClass('fa-spin');
			$(b).find('i').removeClass('fa-spinner');
        }
	}, 'json');
}


dojos.unattendEvent = function (b, event, eventTime, displayCnt)
{
	$(b).attr('disabled', 'disabled');
	$(b).find('i').removeClass('fa-plus');
	$(b).find('i').addClass('fa-spin');
	$(b).find('i').addClass('fa-spinner');
	
	// gets current num attending
	var attendCnt = parseInt($('#attendCnt_' + displayCnt).val());
	
	$.post('/dojos/unattendevent', { event: event, eventTime: eventTime, karateToken:global.CSRF_hash }, function(data){
		    if (data.status == 'SUCCESS')
        {
            global.renderAlert(data.msg, 'alert-success', 'eventAlert' + displayCnt);
            
			$(b).removeAttr('disabled', 'disabled');
			$(b).find('i').removeClass('fa-spin');
			$(b).find('i').removeClass('fa-spinner');
			
			// changes button type
			$(b).removeClass('btn-danger');
			$(b).addClass('btn-default');
			
			$(b).html("<i class='fa fa-plus'></i> Attend Event");
			
			// change onclick function
			$(b).attr('onclick', "dojos.attendEvent(this, " + event + ", '" + eventTime +"', " + displayCnt + ");");
			
			// updates number attending
			$('#attendCntDisplay_' + displayCnt).text((attendCnt - 1) + " Attending");
			
			// updates hidden input
			$('#attendCnt_' + displayCnt).val(attendCnt - 1);
        }
        else
        {
            global.renderAlert(data.msg, 'alert-danger', 'eventAlert' + displayCnt);
            
            // resets button
			$(b).removeAttr('disabled', 'disabled');
			$(b).find('i').addClass('fa-minus');
			$(b).find('i').removeClass('fa-spin');
			$(b).find('i').removeClass('fa-spinner');
        }
	}, 'json');
}
