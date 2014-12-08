var profile = {}


profile.indexInit = function (lat, lng)
{
    if ($('#previewMap').exists())
    {
        if (lat == 0) lat = undefined;
        if (lng == 0) lng = undefined;

        gm.initialize('previewMap', lat, lng, 3, false);

        gm.loadSavedMarkers(false, false, false, '#savedMarkers');
    }

    $('#listCreateBtn').removeAttr('disabled', 'disabled');

    $('#listCreateBtn').click(function(e){
        $(this).prepend(global.spinner);
        $(this).attr('disabled', 'disabled');
        window.location = '/profile/locationedit';
    });

    if ($('#connectFBbtn').exists())
    {
        $('#connectFBbtn').click(function(e){
            fb.login($(this), false, true);
        });
    }

    if ($('#unlinkFBbtn').exists())
    {
        $('#unlinkFBbtn').click(function(e){
            profile.unlinkFB();
        });
    }

	$('#saveSettingsBtn').click(function(e){
		profile.checkUserSettingsForm();
	});

	$('#uploadImgBtn').click(function(e){
		profile.checkImgUploaderForm();
	});

    // $('.well').affix();
    
    CKEDITOR.replace('bio');
}


profile.locationedit = function (lat, lng)
{
    if ($('#previewMap').exists())
    {
        if (lat == 0) lat = undefined;
        if (lng == 0) lng = undefined;

        gm.initialize('previewMap', lat, lng, 12, false);

        if ($('#marker').exists())
        {
            gm.loadSavedMarkers(false, false, false, '#savedMarkers');
        }
    }
    
    $('#cancelBtn').click(function(e){
        if (confirm("Are you sure you wish to cancel?"))
        {
            $(this).find('i').removeClass('fa-times-circle');
            $(this).find('i').addClass('fa-spin');
            $(this).find('i').addClass('fa-spinner');
            $(this).attr('disabled', 'disabled');
            window.location = '/profile';
        }
    });

    $('#saveBtn').click(function(e){ 
        profile.checkListingForm();
    });


	$('#closeVideoModalBtn').click(function($e){
		$('#videoPreviewModal').modal('hide');
	});
	
	$('#imgSortable').sortable({
		stop: function (event, ui){
			var sorted = $(this).sortable('serialize');

			profile.saveImgOrder(sorted);
		}
		
	});
	
	$('#deleteLocBtn').click(function(e){
		profile.deleteLocation();
	});

    CKEDITOR.replace('description');
}

profile.deleteLocation = function ()
{
	if (confirm("Are you sure you wish to delete this location?"))
	{
		$.post('/profile/deletelocation', { location: $('#id').val(), karateToken: global.CSRF_hash }, function(data){
			if (data.status == 'SUCCESS')
            {
                window.location = '/profile?site-success=' + escape(data.msg);
            }
            else
            {
                global.renderAlert(data.msg, 'alert-danger');
            }
		}, 'json');
	}
}

profile.checkImgUploaderForm = function ()
{
	if ($('input[type="file"]').val() == '')
	{
		global.renderAlert("Please select a picture to upload!");
		return false;
	}

	$('#uploadImgBtn i').removeClass('fa-cloud-upload');
	$('#uploadImgBtn i').addClass('fa-spinner');
	$('#uploadImgBtn i').removeClass('fa-spin');
	
	$('#avatarUploadForm').submit();
	
	
}

profile.saveImgOrder = function (sorted)
{
	$.post('/profile/saveimgorder', sorted + '&' + $.param({ 'location': $('#id').val(), 'karateToken': global.CSRF_hash }), function(data){
		if (data.status == 'SUCCESS')
		{
			//global.renderAlert(data.msg, 'alert-danger');
		}
		else
		{
			global.renderAlert(data.msg, 'alert-danger');
		}
	}, 'json');
}

profile.addVideo = function (b)
{
    var html = $(b).parent().parent().parent().html();
    $('.videoContainer').prepend("<div class='vc'>" + html + "</div>");

    profile.updateVideoIcons();

};


profile.updateVideoIcons = function ()
{
    $('.videoContainer button i').removeClass('fa-plus');
    $('.videoContainer button').removeClass('btn-info').addClass('btn-danger');
    $('.videoContainer button').attr('onclick', "profile.delVideo(this);");
    $('.videoContainer button i').addClass('fa-trash-o');
    $('.videoContainer button i').first().addClass('fa-plus');
    $('.videoContainer button').first().removeClass('btn-danger').addClass('btn-info');
    $('.videoContainer button').first().attr('onclick', 'profile.addVideo(this)');
    $('.videoContainer input').first().attr('placeholder', '');
};


profile.delVideo = function (b)
{
    $(b).parent().parent().parent().html('');
}

profile.addImg = function (b)
{
    var html = $(b).parent().parent().parent().html();

    $('#imageUploadContainer').prepend("<div class='imgContainer'>" + html + "</div>");

    profile.updateImgBtn();

}


profile.updateImgBtn = function ()
{
    $('#imageUploadContainer button i').removeClass('fa-plus');
    
    $('#imageUploadContainer button').removeClass('btn-info').addClass('btn-danger');

    $('#imageUploadContainer button').attr('onclick', "profile.delImg(this);");

    $('#imageUploadContainer button i').addClass('fa-trash-o');
    
    $('#imageUploadContainer button i').last().addClass('fa-plus');
    $('#imageUploadContainer button').last().removeClass('btn-danger').addClass('btn-info');
    $('#imageUploadContainer button').last().attr('onclick', 'profile.addImg(this)');
}


profile.delImg = function (b)
{
    $(b).parent().parent().parent().html('');
}

profile.addItem = function(b)
{
    var html = $(b).parent().parent().html();
    var id = parseInt($(b).parent().parent().find(".input-group.col-md-6 :first").attr('name').split('[')[1].slice(3, -1));
    $(b).parent().parent().parent().prepend('<div>' + html.replace(/menu\[new\d{1,10}/g, 'menu[new' + (parseInt(id) + 1)) + '</div>');
    $(b).replaceWith("<button type='button' class='btn btn-danger pull-right' onclick=\"profile.delItem(this);\"><i class='fa fa-trash-o'></i></button>");
};

profile.delItem = function(b)
{
    var parent = $(b).parent().parent();
    var html = $(parent).html();
    var isNew = (html.search(/menu\[new\d{1,10}/g) >= 0) ? true : false;
    if (isNew)
    {
        $(parent).remove();
    }
    else
    {
        $(parent).find("input[name*='active']").val(0);
        $(parent).slideUp('slow');
    }
};

profile.checkListingForm = function ()
{
    if ($('#name').val() == '')
    {
        global.renderAlert('Please enter the business name!');
        $('#name').focus();
        $('#name').effect('highlight');
        return false;
    }

    if ($('#address').val() == '')
    {
        global.renderAlert('Please enter the address!');
        $('#address').focus();
        $('#address').effect('highlight');
        return false;
    }

    if ($('#city').val() == '')
    {
        global.renderAlert('Please enter the city!');
        $('#city').focus();
        $('#city').effect('highlight');
        return false;
    }
    
    if ($('#state :selected').val() == '')
    {
        global.renderAlert('Please select a state!');
        $('#state').focus();
        $('#state').effect('highlight');
        return false;
    }
    
    if ($('#postalCode').val() == '')
    {
        global.renderAlert('Please enter the postal code!');
        $('#postalCode').focus();
        $('#postalCode').effect('highlight');
        return false;
    }

    $('#cancelBtn').attr('disabled', 'disabled');

    //$('#saveBtn').prepend(global.spinner);
    
    $('#saveBtn').find('i').removeClass('fa-save');
    $('#saveBtn').find('i').addClass('fa-spin');
    $('#saveBtn').find('i').addClass('fa-spinner');
    
    $('#saveBtn').attr('disabled', 'disabled');

    $('#locationForm').submit();
}


profile.unlinkFB = function ()
{
    if (confirm("Are you sure you wish to unlink your Facebook account?"))
    {
        $('#unlinkFBbtn').attr('disabled', 'disabled');

        $.getJSON("/profile/disconnectfb", function(data){
            if (data.msg == 'SUCCESS')
            {
                window.location = '/profile?site-success=' + data.msg;
            }
            else
            {
                global.renderAlert(data.msg, 'alert-danger');
                $('#unlinkFBbtn').removeAttr('disabled');
            }
        });
    }
}

profile.editlisting = function (id)
{
    window.location = '/profile/locationedit/' + id;
}

profile.viewListing = function (id)
{
	window.location = '/search/info/' + id;
}

profile.previewVideo = function (location, id, title, videoID)
{
	// unbinds delete button
	$('#deleteVideoBtn').unbind('click');

	// assigns new onclick
	$('#deleteVideoBtn').click(function($e){
		if (confirm("Are you sure you wish to delete this video?"))
		{
			$(this).prepend(global.spinner);
			$(this).attr('disabled', 'disabled');
			// $('#videoPreviewModal').modal('hide');
			profile.deleteVideo(location, id);
			
			$('#closeVideoModalBtn').attr('disabled', 'disabled');
		}
	});

	// changes title
	$('#videoPreviewModal h3.video-title').text(title);
	
	$('#videoPreviewModal iframe').attr('src', "https://www.youtube.com/v/" + videoID + "?version=3&f=videos&app=youtube_gdata");

	$('#videoPreviewModal').modal('show');
}

profile.deleteVideo = function (location, id)
{
	$.post('/profile/deletevideo', { location:location, id:id, karateToken:global.CSRF_hash }, function(data){
		if (data.status == 'SUCCESS')
		{
			$('#videoPreviewModal').modal('hide');
			global.renderAlert(data.msg, 'alert-success');
			$('#videoThumb_' + id).empty();
			
			$('#deleteVideoBtn').html("<i class='fa fa-trash-o'></i>");
			$('#deleteVideoBtn').removeAttr('disabled');
			$('#closeVideoModalBtn').removeAttr('disabled');
		}
		else
		{
			global.renderAlert(data.msg, 'alert-danger', 'videoAlert');
		}
	}, 'json');
}

profile.deleteImage = function (b, location, id)
{
	
	if (confirm("Are you sure wish to delete this image?"))
	{
		$.post('/profile/deleteimg', { location:location, id:id, karateToken:global.CSRF_hash }, function(data){
			if (data.status == 'SUCCESS')
			{
				global.renderAlert(data.msg, 'alert-success');
				
				$(b).parent().empty();
			}
			else
			{
				global.renderAlert(data.msg, 'alert-danger', 'videoAlert');
			}
		}, 'json');
	}
}

profile.checkUserSettingsForm = function ()
{
	if ($('#firstName').val() == '')
	{
		$('#firstName').effect('highlight');
		$('#firstName').focus();
		global.renderAlert("Please enter your first name!");
		return false;
	}
	
	if ($('#lastName').val() == '')
	{
		$('#lastName').effect('highlight');
		$('#lastName').focus();
		global.renderAlert("Please enter your last name!");
		return false;
	}
	
	if ($('#email').val() == '')
	{
		$('#email').effect('highlight');
		$('#email').focus();
		global.renderAlert("Please enter your e-mail address!");
		return false;
	}
	
	if ($('#timezone :selected').val() == '')
	{
		$('#timezone').effect('highlight');
		$('#timezone').focus();
		global.renderAlert("Please select which timezone you are located in!");
		return false;
	}
	
	/*
	if (NaN($('#heightFeet').val()))
	{
		$('#heightFeet').effect('highlight');
		$('#heightFeet').focus();
		global.renderAlert("Please enter only a number for heignt in feet!");
		return false;
	}
	*/
	
    // updates textarea with latest content from CKeditor before saving
    var str = CKEDITOR.instances['bio'].getData();
    $('#bio').val(str);
	
	$.post('/profile/saveusersettings', $('#userForm').serialize(), function(data){
		console.log(data)
		if (data.status == 'SUCCESS')
		{
			global.renderAlert(data.msg, 'alert-success');
		}
		else if (data.status == 'ALERT')
		{
			global.renderAlert(data.msg);
		}
		else
		{
			global.renderAlert(data.msg, 'alert-danger');
		}
	}, 'json');
}

profile.editEvents = function (location)
{
	window.location = "/events/index/" + location;
}
