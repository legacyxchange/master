var events = {}

events.indexInit = function ()
{

	$('#createEventBtn').removeAttr('disabled');

	$('#createEventBtn').click(function(e){
		//$('#createEventModal').modal('show');
		
		window.location = '/events/edit/' + $('#eventLocation').val() + '/' + $('#month').val() + '/' + $('#year').val();
		
		$('#createEventBtn').attr('disabled', 'disabled');
		$('#createEventBtn i').removeClass('fa-plus-circle');
		$('#createEventBtn i').addClass('fa-spin');
		$('#createEventBtn i').addClass('fa-spinner');
	});

	//CKEDITOR.replace('description');
	
	$('#startDate, #endDate').datepicker({
		dateFormat: 'yy-mm-dd'
	});
	
	$('#startTime, #endTime').timeEntry();

	$('#eventLocation').change(function(){
		if ($(this).val() == 'OTHER')
		{
			$('#otherLocRow').show('highlight');
		}
		else
		{
			$('#otherLocRow').hide('highlight');
		}
	});

	$(window).resize(function(){
       events.setEventWidth();
    });
	
	events.setEventWidth();
		
	$('#eventModal').on('shown.bs.modal', function (e) {
    	google.maps.event.trigger(gm.map, "resize");
	});
}

events.editInit = function ()
{
	CKEDITOR.replace('description', {
		toolbar: 'Basic'
	});

	$('#startDate, #endDate').datepicker({
		dateFormat: 'yy-mm-dd'
	});
	
	$('#startTime, #endTime').timeEntry();

	$('#eventLocation').change(function(){
		if ($(this).val() == 'OTHER')
		{
			$('#otherLocRow').show('highlight');
		}
		else
		{
			$('#otherLocRow').hide('highlight');
		}
	});

	$('#videoUploadBtn').click(function(e){
		events.addVideoUpload();
	});
	
	$('#photoUploadBtn, #fileUploadBtn').click(function(e){
		events.addFileUpload();
	});

	// ensures buttons are not disabled on page load
	$('#cancelBtn').removeAttr('disabled');
	$('#saveBtn').removeAttr('disabled');

	$('#saveBtn').click(function(e){
		events.checkEventForm();
	});
	
	$('#cancelBtn').click(function(e){
		if (confirm("Are you sure you wish to cancel?"))
		{
			$('#saveBtn').attr('disabled', 'disabled');
		
			$(this).attr('disabled', 'disabled');
			$(this).find('i').removeClass('fa-times-circle');
			$(this).find('i').addClass('fa-spin');
			$(this).find('i').addClass('fa-spinner');
			
			window.location = '/events/index/' + $('#eventLocation').val() + '/' + $('#month').val() + '/' + $('#year').val();
		}
	});

	$('#repeatEvent').click(function(e){
		if ($(this).prop('checked') == true)
		{
			$('#repeatEventModal').modal('show');
		}
		else
		{
			
		}
		
		events.setRepeatCheck();
	});
	
	//modal init stuff
	$('#startsOn').datepicker({
		dateFormat: 'yy-mm-dd'
	});
	
	$('#repeatCancelBtn').click(function(e){
		$('#repeatEventModal').modal('hide');
		$('#repeatEvent').removeAttr('checked');
		
		events.setRepeatCheck();
	});
	
	$('#repeatDoneBtn').click(function(e){
		events.checkRepeatModal();
	});
	
	$('#repeatType').change(function(e){
		events.changeRepeatTypeTxt($('option:selected', this).val());
	});
	
	$('#occurrences').focus(function(){
		$('#ends_2').attr('checked', 'checked');
	});
	
	$('#endsOnDate').datepicker({
		dateFormat: 'yy-mm-dd'
	});
	
	$('#endsOnDate').focus(function(){
		$('#ends_3').attr('checked', 'checked');
	});
	
	if ($('#deleteBtn').exists())
	{
		$('#deleteBtn').click(function(e){
			events.deleteEvent();
		});	
	}
	
	/*
	$('#eventLocationSel').change(function(){
		if ($(this).val() == 'OTHER')
		{
			$('#otherLocRow').show('highlight');
		}
		else
		{
			$('#otherLocRow').hide('highlight');
		}
	});
	*/
	
	$('#allDay').click(function(e){
		events.allDayEvent();
	});
	
	events.changeRepeatTypeTxt();
	events.setRepeatCheck();
}

events.changeRepeatTypeTxt = function (repeatType)
{
	if (repeatType == undefined) repeatType = $('#repeatType :selected').val();

	if (repeatType == 1)
	{
		$('#repeatTypeTxt').text('Days');
	}
	else if (repeatType == 2)
	{
		$('#repeatTypeTxt').text('Weeks');
	}
	else if (repeatType == 3)
	{
		$('#repeatTypeTxt').text('Months');
	}
	else
	{
		$('#repeatTypeTxt').text('Years');
	}
}

events.addVideoUpload = function ()
{
	var html = $('#videoUploadHtml').html();

	$('#uploadContainer').append(html);
}

events.removeVideoUpload = function (b)
{
	$(b).parent().parent().parent().hide('highlight', function(){
		$(this).html('');
	});
}

events.addFileUpload = function ()
{
	var html = $('#fileUploadHtml').html();

	$('#uploadContainer').append(html);
}

events.removeFileUpload = function (b)
{
	$(b).parent().parent().parent().hide('highlight', function(){
		$(this).html('');
	});
}

events.checkRepeatModal = function ()
{
	if ($('#startsOn').val() == '')
	{
		$('#startsOn').focus();
		$('#startsOn').effect('highlight');
		global.renderAlert("Please enter a day in which this event will start on!", undefined, 'repeatModalAlert');
		return false;
	}
	
	if ($('#ends_2').prop('checked') == true && $('#occurrences').val() == '')
	{
		$('#occurrences').focus();
		$('#occurrences').effect('highlight');
		global.renderAlert("Please enter how many occurrences this event has!", undefined, 'repeatModalAlert');
		return false;
	}

	if ($('#ends_3').prop('checked') == true && $('#endsOnDate').val() == '')
	{
		$('#endsOnDate').focus();
		$('#endsOnDate').effect('highlight');
		global.renderAlert("Please enter which day this event will end on!", undefined, 'repeatModalAlert');
		return false;
	}

	$('#repeatEventModal').modal('hide');
	$('#repeatEvent').attr('checked', 'checked');
	
	//events.setRepeatCheck();
}

events.allDayEvent = function ()
{
	if ($('#allDay').prop('checked') == true)
	{
		$('#startTime').attr('disabled', 'disabled');
		$('#endTime').attr('disabled', 'disabled');
		
		// clears values
		$('#startTime').val('');
		$('#endTime').val('');
	}
	else
	{
		$('#startTime').removeAttr('disabled');
		$('#endTime').removeAttr('disabled');
	}
}


events.showRepeatModal = function ()
{
	$('#repeatEventModal').modal('show');
	events.changeRepeatTypeTxt();
}

events.setRepeatCheck = function ()
{
	if ($('#repeatEvent').prop('checked') == true)
	{
		$('#repeatCheck').html("Repeat [<a href='javascript:events.showRepeatModal();'>Edit</a>]");
	}
	else
	{
		$('#repeatCheck').html("Repeat...");
	}
}

events.checkEventForm = function ()
{
	if ($('#title').val() == '')
	{
		$('#title').focus();
		$('#title').effect('highlight');
		global.renderAlert("Please enter an event title!");
		return false;
	}
	
	if ($('#startDate').val() == '')
	{
		$('#startDate').focus();
		$('#startDate').effect('highlight');
		global.renderAlert("Please enter a start date for this event!");
		return false;
	}
	
	if ($('#allDay').prop('checked') == true)
	{
		
	}
	else
	{
		if ($('#startTime').val() == '')
		{
			$('#startTime').focus();
			$('#startTime').effect('highlight');
			global.renderAlert("Please enter a start time for this event!");
			return false;
		}

		if ($('#endTime').val() == '')
		{
			$('#endTime').focus();
			$('#endTime').effect('highlight');
			global.renderAlert("Please enter a end time for this event!");
			return false;
		}
	}
	
	$('#saveBtn').attr('disabled', 'disabled');
	$('#saveBtn i').removeClass('fa-save');
	
	$('#saveBtn i').addClass('fa-spin');
	$('#saveBtn i').addClass('fa-spinner');
	
	$('#cancelBtn').attr('disabled', 'disabled');
	
	$('#repeatEventForm').submit();
}

events.loadEventModal = function (id)
{
    $.get("/events/event_modal/" + id + '/' + $('#eventLocation').val() + '/' + $('#month').val() + '/' + $('#year').val(), function(data){
        $('#eventModal').html(data);
        $('#eventModal').modal('show');
        
        

		

        var lat = $('#eventModal #lat').val();
        var lng = $('#eventModal #lng').val();

        gm.initialize('eventMap', lat, lng, 14, false);

        var location = new google.maps.LatLng(lat, lng);

        gm.addPoint(location, false);
    });
}

events.removeFileUploaded = function (b, event, id)
{
	if (confirm("Are you sure wish to delete this file?"))
	{
		$(b).attr('disabled', 'disabled');
	
		$.post('/events/deletefile', { id: id, event:event, karateToken:global.CSRF_hash }, function(data){
			if (data.status == 'SUCCESS')
			{
				events.removeFileUpload(b);
			}
			else
			{
				global.renderAlert("There was an error trying to delete the file!<br><br>" + data.msg, 'alert-error');
				
				$(b).removeAttr('disabled');
				
				return false;
			}
		}, 'json');
	}
}

events.removeVieoUploaded = function (b, id)
{
	if (confirm("Are you sure wish to delete this file?"))
	{
		$(b).attr('disabled', 'disabled');
	
		$.post('/events/deletevideo', { id:id, karateToken:global.CSRF_hash }, function(data){
			if (data.status == 'SUCCESS')
			{
				events.removeVideoUpload(b);
			}
			else
			{
				global.renderAlert("There was an error trying to delete the video!<br><br>" + data.msg, 'alert-error');
				
				$(b).removeAttr('disabled');
				
				return false;
			}
		}, 'json');
	}
}

events.deleteEvent = function ()
{
	if (!confirm("Are you sure you wish to delete this event?"))
	{
		return false;
	}
	
	$('#deleteBtn').attr('disabled', 'disabled');
	$('#saveBtn').attr('disabled', 'disabled');
	$('#cancelBtn').attr('disabled', 'disabled');
	
	$('#deleteBtn i').removeClass('fa-trash-o');
	$('#deleteBtn i').addClass('fa-spin');
	$('#deleteBtn i').addClass('fa-spinner');
	
	
	$.post('/events/deleteevent', { id: $('#id').val(), karateToken:global.CSRF_hash  }, function(data){
			if (data.status == 'SUCCESS')
			{
				window.location = '/events/index/' + $('#eventLocation').val() + '/' + $('#month').val() + '/' + $('#year').val();
			}
			else
			{
				global.renderAlert("There was an error trying to delete the event!<br><br>" + data.msg, 'alert-error');
				
				$('#deleteBtn').removeAttr('disabled');
				$('#saveBtn').removeAttr('disabled');
				$('#saveBtn').removeAttr('disabled');
				
				$('#deleteBtn i').addClass('fa-trash-o');
				$('#deleteBtn i').removeClass('fa-spin');
				$('#deleteBtn i').removeClass('fa-spinner');
				
				return false;
			}
	});
}

events.setEventWidth = function ()
{
    // gets width of dayEvent
    var w = $('.day-container').width();

    //console.log("W:" + w);

    // checks companies
    $('#calendar').find("label").each(function(index, item)
    {
        var days = parseInt($(item).attr('days'));

        //console.log("Days: " + days);
        if (days < 2)
        {
            $(item).width(w - 15);
        }
        else
        {
            //days = days + 1;

            var wdr = parseInt($(item).attr('weekDaysRemaining')) + 1;

            if (wdr < days)
            {
                $(item).width((w * wdr));
            }
            else
            {
                $(item).width((w * days));
            }
        }
    });

	events.setStaggered();
}

events.setStaggered = function ()
{
	var cnt = 1;
	var dow = 0;
	var bufferDays = 0; // holds how many top-margin is required


    // goes through each day and checks the events
    $('#calendar').find(".day-container").each(function(index, item)
    {
    	//console.log("Cnt: " + cnt + " | Dow: " + dow);
    
		var eventCnt = 0;
		
		// before labels checked
		// applys top margin
		if (bufferDays > 0)
		{
			//console.log('ADD BUFFER');
			var mtop = bufferDays * 25;
			$(item).find('.eventContainer').css('margin-top', mtop + 'px');
		}
		
		// will now go through each even int that day to determine buffering
		$(item).find('.label').each(function(subIndex, calEvent){
			eventCnt++;
			
			var days = parseInt($(calEvent).attr('days'));
			var wdr = parseInt($(calEvent).attr('weekdaysremaining'));
			
			if (days >= 2)
			{
				bufferDays += days;
				
			}
			
			//console.log("event!" + eventCnt + "| bufferDays: " + bufferDays);
		});


		if (bufferDays > 0)
		{
			bufferDays -= 1;
		}
			
    
    	cnt++;
    	dow++;
    	
    	
    	if (dow >= 7)
    	{
	    	dow = 0;
	    	bufferDays = 0;
    	}
    	
    });
}