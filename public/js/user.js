var user = {}

user.uploadedImgs = new Array();
user.showPhotoPost = false;

user.masonryPostActive = false;

user.photoModalMaxHeight = 0;
user.photoModalHeight = 0;

user.indexInit = function ()
{
    //$('body').alerts('Test!');
    //$('body').alerts('Test 2!');	

    CKEDITOR.replace('msg', {
        toolbar: 'Basic'
    });

    $('#post').autosize();

    $('#saveAlbumBtn').click(function () {
        user.checkAlbumForm(this);
    });

    $('#fileUploadContainer')
            .bind('dragenter', user.dragOver)
            .bind('dragover', user.ignoreDrag)
            .bind('drop', user.drop);

    $("#photoFile").change(function () {
        //var fileName = $(this).val();

        //alert(JSON.stringify($(this)[0].files[0].name));

        user.basicFileUpload($(this)[0].files[0]);
    });

    user.setPhotoModalMaxHeight();

    $(window).resize(function () {
        wall.renderImgPreviews();
        user.setPhotoModalMaxHeight();
        user.setPhotoBgHeight();
    });

    $('#photo-modal').on('show.bs.modal', function (e) {
        user.setPhotoModalMaxHeight();
        user.setPhotoBgHeight();
    });

    $('#photo-modal').on('shown.bs.modal', function (e) {
        user.setPhotoModalMaxHeight();

        user.setPhotoBgHeight();
        user.getPhotoInfo();
    });

    $('#photo-modal').on('hidden.bs.modal', function (e) {

        // clears min-height when modal is closed for different image dimensions
        user.resetMaxHeights();
    });

    $('#postBtn').click(function (e) {
        user.checkWallPostForm();
    });

    $('#album-container .nt-container').nailthumb({width: 228, height: 150});

    wall.load();
}

user.viewblog = function (blog)
{
    $('#blog-display').css('opacity', '0');


    $('body').css('overflow-x', 'hidden');

    // scrolls to top of page
    $("html, body").velocity("scroll", 1000);

    $('#blog-preview-display').addClass('animated slideOutRight');

    $('#blog-display').show();


    $('#blog-preview-display').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
        // remove style tag from body
        $('body').removeAttr('style');

        $(this).hide();
        $(this).removeClass('animated slideOutRight');
        global.ajaxLoader('#blog-display');

        $('#blog-display').velocity({opacity: 1});


        $.get('/user/viewblog/' + blog, function (data) {


            //$('#blog-display').addClass('animated');
            //$('#blog-display').addClass('slideInDown');




            $('#blog-display').html(data);
        });
    });


}

user.viewBlogPreviews = function ()
{
    $('body').css('overflow-x', 'hidden');

    $('#blog-display').velocity({opacity: 0}, {
        complete: function () {
            $('#blog-display').hide();

            $('#blog-display').css('opacity', '');

            $('#blog-preview-display').show().addClass('animated slideInRight');

            $('#blog-preview-display').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                // remove style tag from body
                $('body').removeAttr('style');

                $(this).removeClass('animated slideInRight');

                // clears HTML
                $('#blog-display').html('');
            });
        }
    });

    /*
     $('#blog-display').hide('highlight', function(e){
     $('#blog-preview-display').show().addClass('animated slideInRight');
     
     $('#blog-preview-display').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
     // remove style tag from body
     $('body').removeAttr('style');
     
     $(this).removeClass('animated slideInRight');
     
     // clears HTML
     $('#blog-display').html('');
     });
     });
     */
}

user.checkWallPostForm = function ()
{
    if ($('#post').val() == '')
    {
        $('#post').focus();
        $('#post').effect('highlight');
        global.renderAlert("Please enter something to post!", undefined, 'post-alert');

        return false;
    }

    wall.stopRefresh();

    $.post('/wall/savepost', $('#wallPostForm').serialize(), function (data) {
        if (data.status == 'SUCCESS')
        {
            user.resetStreamForm();
            wall.refresh();
        }
        else
        {

        }
    }, 'json');
}

user.checkPhotoPostForm = function ()
{
    wall.stopRefresh();

    $.post('/wall/savepost', $('#photoPostForm').serialize(), function (data) {
        if (data.status == 'SUCCESS')
        {
            user.resetStreamForm();

            wall.refresh();
        }
        else
        {

        }
    }, 'json');
}

user.resetStreamForm = function ()
{
    // clears hidden input
    $('#img-hidden-container').html('');

    $('#photoPost').val('');
    $('#post').val('');

    // clears img
    $('#imgPreviewContainer').html('');

    $('#photo-post-container').hide('highlight');
}

user.follow = function ()
{   
    $('#followBtn').attr('disabled', 'disabled');
    
    $.post('/user/follow', {userid: $('#id').val(), karateToken: global.CSRF_hash}, function (data) {
        if (data.status == 'SUCCESS')
        {   console.log('success')
            // changes button to green success
            $('#followBtn').removeClass('btn-default');
            $('#followBtn').addClass('btn-success');

            // updates text
            $('#followBtn').html("<i class='fa fa-check'></i> Following");
            $('#followBtn').attr('onclick', "user.unfollow();");
        }
        else
        {
        	console.log('failed')
            global.renderAlert('There was a problem following this user!', 'alert-danger');
        }

        $('#followBtn').removeAttr('disabled');

    }, 'json');
}

user.unfollow = function ()
{
    $('#followBtn').attr('disabled', 'disabled');

    $.post('/user/unfollow', {userid: $('#id').val(), karateToken: global.CSRF_hash}, function (data) {
        if (data.status == 'SUCCESS')
        {
            // changes button to green success
            $('#followBtn').addClass('btn-default');
            $('#followBtn').removeClass('btn-success');

            // updates text
            $('#followBtn').html("<i class='fa fa-chevron-circle-right'></i> Follow");
            $('#followBtn').attr('onclick', "user.follow();");
        }
        else
        {
            global.renderAlert('There was a problem unfollowing this user!', 'alert-danger');
        }

        $('#followBtn').removeAttr('disabled');
    }, 'json');
}

user.unfollowByUserId = function(userid, button)
{
    var parent = $(button).parent();
    $.post('/user/unfollow', { userid: userid, karateToken: global.CSRF_hash}, function (data) {
        if (data.status == 'SUCCESS')
        {
            $(parent).slideUp('slow');
        }
        else
        {
            global.renderAlert('There was a problem unfollowing this user!', 'alert-danger');
        }
    }, 'json');
};

user.showAlbumModal = function ()
{
    $('#album-modal').modal('show');
}

user.checkAlbumForm = function (b)
{
    if ($('#albumName').val() == '')
    {
        $('#albumName').focus();
        $('#albumName').effect('highlight');
        global.renderAlert("Please enter an album name!", undefined, 'albumAlert');

        return false;
    }

    $(b).attr('disabled', 'disabled');
    $('#cancelAblumBtn').attr('disabled', 'disabled');

    $.post('/user/createalbum', $('#albumForm').serialize(), function (data) {
        if (data.status == 'SUCCESS')
        {
            $('#albumName').val(''); // clears input
            $('#album-modal').modal('hide');
        }
        else
        {
            global.renderAlert("There was a problem creating the album", 'alert-danger', 'albumAlert');
            return false;
        }
        $(b).removeAttr('disabled');
        $('#cancelAblumBtn').removeAttr('disabled');
    }, 'json');
}

user.viewAlbum = function (album)
{
    $('body').css('overflow-x', 'hidden');

    $('#album-container').addClass('animated slideOutRight');

    $('#album-container').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
        // remove style tag from body
        $('body').removeAttr('style');

        $(this).hide();
        $(this).removeClass('animated slideOutRight');
        global.ajaxLoader('#photos-display');


        $.get('/user/viewalbum/' + album + '/' + $('#id').val(), function (data) {
            $('#photos-display').html(data);
            $('#photos-display').show();

            $('#album-photo-container').justifiedGallery({
                rowHeight: 250,
                margins: 15
            }).on('jg.complete', function (e) {
                $('.justified-gallery a img').each(function() {
                    var $current = $(this);
                    var width = parseInt($(this).css('width'));
                    $(this).attr('src', $current.attr('src').replace('/250', '/' + width));
                });
            });
        });
    });



}

user.viewAllAlbums = function ()
{
    $('body').css('overflow-x', 'hidden');


    $('#photos-display').velocity({opacity: 0}, {
        complete: function () {
            $('#photos-display').hide();

            $('#photos-display').css('opacity', '');

            $('#album-container').show().addClass('animated slideInRight');

            $('#album-container').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                // remove style tag from body
                $('body').removeAttr('style');

                $('#album-container').removeClass('animated slideInRight');
            });
        }
    });

    /*
     $('#photos-display').hide('highlight', function(e){
     $('#album-container').show().addClass('animated slideInRight');
     
     $('#album-container').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
     // remove style tag from body
     $('body').removeAttr('style');
     
     $('#album-container').removeClass('animated slideInRight');
     });
     });
     */
}

user.ignoreDrag = function (e)
{
    e.originalEvent.stopPropagation();
    e.originalEvent.preventDefault();
}

user.dragOver = function (e)
{
    user.ignoreDrag(e);

    $('#fileUploadContainer').addClass('highlight');
}

user.dragOut = function (e)
{
    user.ignoreDrag(e);

    //console.log('out');
    //$('#fileUploadContainer').removeClass('highlight');
}


user.drop = function (e)
{
    user.ignoreDrag(e);

    var dt = e.originalEvent.dataTransfer;
    var files = dt.files;
    user.handFileUpload(files, $('#fileUploadContainer'));


    /*
     if(dt.files.length > 0)
     {
     var file = dt.files[0];
     alert(file.name);
     }
     */
}

user.handFileUpload = function (files, obj)
{
    for (var i = 0; i < files.length; i++)
    {
        var fd = new FormData();
        fd.append('file', files[i]);
        fd.append('userid', $('#id').val());
        fd.append('karateToken', global.CSRF_hash);

        var progressbar = user.setProgressBar();

        $(progressbar).find('.fileNameTxt').text(files[i].name);

        user.sendFileToServer(fd, progressbar);

        //user.uploadedImgs.push(files[i].name);
        //console.log('FILE: ' + files[i].name);
    }

    $('#postBtn').removeAttr('disabled');
    $('#fileUploadContainer').removeClass('highlight');
}

user.basicFileUpload = function (file)
{
    var fd = new FormData();
    fd.append('file', file);
    fd.append('userid', $('#id').val());
    fd.append('karateToken', global.CSRF_hash);

    var progressbar = user.setProgressBar();

    $(progressbar).find('.fileNameTxt').text(file.name);

    user.sendFileToServer(fd, progressbar);

    //user.uploadedImgs.push(file.name);

    $('#postBtn').removeAttr('disabled');
    $('#fileUploadContainer').removeClass('highlight');
}

user.sendFileToServer = function (formData, progressbar)
{
    $.post('/user/uploadimgs', { 'karateToken': global.CSRF_hash } , function(data) {
        console.log(data);
    });
    $.ajax({
        url: '/user/uploadimgs',
        /*
         xhrFields: {
         onprogress: function (e) {
         if (e.lengthComputable)
         {
         var per = e.loaded / e.total * 100;
         
         progressbar.find('.progress-bar').attr('aria-valuenow', per);
         progressbar.find('.progress-bar').css('width', per + '%');
         progressbar.find('.progress-bar').text(per + '%');
         //console.log(per + '%');
         
         if (per >= 100)
         {
         user.hideProgressbar(progressbar);
         }
         }
         }
         },
         */
        progress: function (e) {
            //make sure we can compute the length
            if (e.lengthComputable)
            {
                //calculate the percentage loaded
                var pct = (e.loaded / e.total) * 100;

                var pctDisplay = $.number(pct);

                //log percentage loaded
                //console.log(' PERCENT: ' + pct);
                progressbar.find('.progress-bar').attr('aria-valuenow', pct);
                progressbar.find('.progress-bar').css('width', pct + '%');
                progressbar.find('.progress-bar').text(pctDisplay + '%');
                //console.log(per + '%');

                if (pct >= 100)
                {
                    user.hideProgressbar(progressbar);
                }

            }
            //this usually happens when Content-Length isn't set
            else
            {
                console.warn('Content Length not reported!');
            }
        },
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        type: 'POST',
        success: function (data) {
            //alert(data);
            if (data.status == 'SUCCESS')
            {
                user.uploadedImgs.push(data.msg);

                // shows post preview 
                if (user.showPhotoPost == false)
                {
                    $('#photo-post-container').show('highlight');
                    user.showPhotoPost = true;
                }

                user.loadImagePreview();

            }
        }
    });
};



user.loadImagePreview = function ()
{
    var display = true;

    $.each(user.uploadedImgs, function (i, val) {
        display = true;

        //console.log(val);

        // goes through each image loaded and check if it has been added already

        $('#imgPreviewContainer').find('img').each(function (index, img) {

            //console.log('IMG IN CONTAINER: ' + $(img).attr('src'));

            var src = $(img).attr('src');

            //console.log("SRC: " + src);

            // removes extra tags from plugin to ensure its checking regular file names not dynamic
            src = src.replace('_t.', '.');
            src = src.replace('_m.', '.');
            src = src.replace('_n.', '.');
            src = src.replace('_z.', '.');
            src = src.replace('_c.', '.');
            src = src.replace('_b.', '.');

            //console.log("FINAL SRC: " + src);

            var n = src.indexOf(val);

            if (n > 0)
            {
                display = false;
            }
        });

        if (display == true)
        {
            // /user/albumphoto/1/25b15dc59bbbeb9e8536e9d4ff934576.jpg
            //$('#imgPreviewContainer').append("<div class='item'><img src='" + global.bmsUrl + "user/albumphoto/" + $('#id').val() + "/" + val + "'></div>");.
            $('#imgPreviewContainer').append("<a href='#'><img src='" + global.bmsUrl + "user/albumphoto/" + $('#id').val() + "/" + val + "/250'></a>");

            // adds hidden input to track which files are uploaded
            $('#img-hidden-container').append("<input type='hidden' name='img[]' value='" + val + "'>");
        }
    });

    //user.createMasonry();
    user.createGallery();
}


user.createGallery = function ()
{
    $("#imgPreviewContainer").justifiedGallery({
    })
            .on('jg.complete', function (e) {
                user.stretchPhotoCaption();
            })
            .on('jg.resize', function (e) {
                user.stretchPhotoCaption();
            });
}

user.stretchPhotoCaption = function ()
{
    var h = $('#imgPreviewContainer').height();

    $('#photoPost').height(h);
}

/*
 user.createMasonry = function ()
 {
 // if already loaded for img preview, destorys and reloads it
 if (user.masonryPostActive == true)
 {
 $('#imgPreviewContainer').masonry('destroy');
 }
 
 $('#imgPreviewContainer').masonry({
 itemSelector: '.item'
 });
 
 user.masonryPostActive = true;
 
 return true;
 }
 */

user.setProgressBar = function ()
{
    var phtml = $('#fileUploadProgressHtml').html();

    $('#uploadProgressContainer').append(phtml).effect('highlight');

    return $('#uploadProgressContainer .fileProgressBar').last();
}

user.hideProgressbar = function (progressbar)
{
    window.setTimeout(function () {
        progressbar.hide('highlight');
    }, 2000);

}

user.prepareStatus = function ()
{
    $('#postBtn').removeAttr('disabled');

    // copy content from photo textarea
    $('#post').val($('#photoPost').val());

    // clears on click function
    $('#postBtn').attr('onclick', '').unbind('click');


    $('#postBtn').click(function (e) {
        user.checkWallPostForm();
    });
}

user.preparePhoto = function ()
{
    $('#postBtn').attr('disabled', 'disabled');

    // copy content from Status textarea
    $('#photoPost').val($('#post').val());

    // clears on click function
    $('#postBtn').attr('onclick', '').unbind('click');

    $('#postBtn').click(function (e) {
        user.checkPhotoPostForm();
    });
}

user.viewPhoto = function (photoID, userid, fileName, setDimensions)
{
    if (setDimensions == undefined)
        setDimensions = false;

    var src = global.bmsUrl + "public/uploads/userimgs/" + userid + "/" + fileName;

    // sets hidden input in modal for photoID
    $('#photo-modal #modalPhotoID').val(photoID);

    $('#photo-modal #photo-img').attr('src', src);

    // get img width and height
    var w = $('#img-preview-' + photoID).width();
    var h = $('#img-preview-' + photoID).height();

    // sets width and height of anchor link to keep dimensions
    if (setDimensions)
    {
        $('#img-preview-link-' + photoID).width(w);
        $('#img-preview-link-' + photoID).height(h);

        $('#img-preview-link-' + photoID).css('display', 'inline-block');
    }


    var bgsize = w + 'px ' + h + 'px';


    $('#img-preview-link-' + photoID).css('background-image', 'url(' + src + ')');
    $('#img-preview-link-' + photoID).css('background-size', bgsize);


    var l = $('#img-preview-link-' + photoID).html();

    $('#img-preview-link-' + photoID).effect('highlight');


    var loader = global.ajaxLoader('#img-preview-link-' + photoID);

    $('#photo-modal #photo-img').load(function (e) {
        loader.setPercent(100).show();

        $('#img-preview-link-' + photoID).html(l);


        $('#photo-modal').modal('show');
    });
}

user.getPhotoInfo = function (photoID)
{
    // if modal is being used
    if ($('#photo-modal #modalPhotoID').exists())
    {
        // if photoID is not passed, checks for one in hidden input in modal
        if (photoID == undefined)
            photoID = $('#photo-modal #modalPhotoID').val();
    }

    var loader = global.ajaxLoader('#photo-info-display');

    $.get('/user/photoinfo/' + photoID, function (data) {
        loader.setPercent(100).show();


        $('#photo-info-display').html(data);

        //user.setPhotoBgHeight(); // readjusts bg

        // sets autogrow for textarea
        $('#photo-modal #caption').autosize({
            callback: function ()
            {
                user.sizeCommentsScroll(true);
            }
        });

        $('#photo-modal #caption').css('height', '40px');

        $('#photo-modal #caption').focus(function (e) {
            user.photoCommentEnter();
        });

        var finalh = user.sizeCommentsScroll();

        // sets slimscroll on container element
        $('#photo-scroll').slimScroll({
            height: finalh + 'px'
        });
    });

}

user.sizeCommentsScroll = function (updateScroll)
{
    if (updateScroll == undefined)
        updateScroll = false;

    var sth = $('#photo-modal .static-content').height();

    sth += 15; // adds 30 for margins

    //console.log("STH: " + sth);
    //console.log("Modal Height: " + user.photoModalHeight);

    var finalh = user.photoModalHeight - sth;

    if (updateScroll == true)
    {
        //finalh += 15;
        $('.slimScrollDiv, #photo-scroll').css('height', finalh + 'px');
    }

    return finalh;
}

user.setPhotoModalMaxHeight = function ()
{
    var h = parseInt($(window).height());

    h -= 60; // removes 60 pixels to compensate for padding/margins

    user.photoModalHeight = h;

    $('#photo-modal .modal-content').css('max-height', h + 'px');
    $('#photo-modal #photo-img').css('max-height', h + 'px');

    $('#photo-modal .info-col').css('max-height', (h + 30) + 'px');

    //$('#photo-modal .slimScrollDiv').html('');	
    //$('#photo-modal .slimScrollDiv').removeAttr('style');

}

user.resetMaxHeights = function ()
{
    user.photoModalMaxHeight = 0;
    user.photoModalHeight = 0;

    $('#photo-modal #photo-img').attr('src', '');

    $('#photo-modal .modal-content').css('max-height', '');
    $('#photo-modal #photo-img').css('max-height', '');

    $('#photo-modal .img-bg').css('min-height', '');
    $('#photo-modal .info-col').css('max-height', '');

    $('#photo-modal #photo-info-display').html('');

    $('#photo-modal #photo-info-display').css('height', '');
}

user.setPhotoBgHeight = function ()
{
    var h = $('#photo-modal').find('.modal-dialog').height();

    user.photoModalHeight = h;
    //console.log("H: " + h);

    //$('#photo-modal .img-bg').height(h);
    $('#photo-modal .img-bg').css('min-height', h + 'px');
    $('#photo-modal #photo-info-display').css('height', h + 'px');


}

user.photoCommentEnter = function ()
{
    $(window).unbind('keypress');

    $(window).bind('keypress', function (e) {
        var code = e.keyCode || e.which;

        if (code == 13)
        {
            user.savePhotoComment();
        }
    });
}

user.savePhotoComment = function ()
{
    if ($('#photo-modal #caption').val() == '')
    {
        $('#photo-modal #caption').focus();
        $('#photo-modal #caption').effect('highlight');
        global.renderAlert("Please enter something to post!", undefined, 'photo-alert');

        return false;
    }

    $.post('/user/savephotocomment', $('#photoCommentForm').serialize(), function (data) {
        if (data.status == 'SUCCESS')
        {
            // refresh comments
            user.getPhotoInfo();
        }
        else
        {
            global.renderAlert("There was an problem saving your comment!", 'alert-danger', 'photo-alert');
            return false;
        }
    }, 'json');
}

$(document).ready(function(){
	$('.edit_button').click(function(e){
		e.preventDefault();
		var user_id = $(this).attr('id');
		
	    $.ajax("/administrator/users/userform/"+user_id)
	    .done(function( data ) { console.log(data)
	      $('#usersModal .modal-content').html(data);
	    })
	    .fail(function() {
	        alert( "error" );
	    })
	});
	$('.add_new_butt').click(function(e){
		e.preventDefault();
		
	    $.ajax("/administrator/users/userform")
	    .done(function( data ) { //console.log(data)
	      $('#usersModal .modal-content').html(data);
	    })
	    .fail(function() {
	        alert( "error" );
	    })
	});
});