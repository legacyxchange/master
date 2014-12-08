var blog = {}

blog.indexInit = function ()
{
	blog.setSideWidth();
	   
	// executes function on resizing of window
    $(window).resize(function(){
        blog.setSideWidth();
    });

	$('#blogSideContainer').affix();
}

blog.viewInit = function ()
{
	blog.setSideWidth();
	   
	// executes function on resizing of window
    $(window).resize(function(){
        blog.setSideWidth();
    });

	$('#blogSideContainer').affix();

    $('#reviewBtn').click(function(e){
        blog.checkReview();
    });


	/*
    $('#reviewStars i').hover(function(e){
        // console.log($(this).attr('value'));
        blog.setRating($(this).attr('value'));
    });

    $('#reviewStars').mouseout(function(){
        blog.setRating();
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
    */
}

blog.view = function (id)
{
	window.location = '/blog/view/' + id
}

/*
blog.setRating = function (rating)
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
*/

blog.checkReview = function ()
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

	/*
    if (parseInt($('#rating').val()) == 0)
    {
        global.renderAlert('Please select a rating', undefined, 'reviewAlert');
        $('#reviewStars').effect('highlight');
        return false;
    }
	*/

    if ($('#reviewDesc').val() == '')
    {
        global.renderAlert('Please enter a comment.', undefined, 'reviewAlert');
        $('#reviewDesc').focus();
        $('#reviewDesc').effect('highlight');
        return false;
    }

    $('#reviewBtn').attr('disabled', 'disabled');

    $.post("/blog/savecomment", $('#commentForm').serialize(), function(data){

        if (data.status == 'SUCCESS')
        {
            window.location = '/blog/view/' + $('#id').val() + '?site-success=' + escape(data.msg);
            
            //location.reload();
        }
        else
        {
            global.renderAlert(data.msg, 'alert-danger', 'reviewAlert');
            $('#reviewBtn').removeAttr('disabled');
        }
    }, 'json');

}

blog.hideComments = function (b)
{
	//$('#reviews-container').addClass('animated fadeOut');
	
	$(b).attr('onclick', "blog.showComments(this);");
	
	$(b).html("<i class='fa fa-caret-down'></i> Show Comments");
	
	$('#reviews-container').hide();
	
}

blog.showComments = function (b)
{
	$(b).attr('onclick', "blog.hideComments(this);");
	
	$(b).html("<i class='fa fa-caret-up'></i> Hide Comments");
	
	$('#reviews-container').show();
}

blog.viewCategoryBlogs = function (category, tblRow)
{
	window.location = "/blog?category=" + escape(category);
	
	$(tblRow).find('td').first().prepend("<i class='fa fa-spin fa-spinner'></i> ");
	
	$(tblRow).addClass('text-muted');
}

blog.setSideWidth = function ()
{
	// gets container width
	
	var cwidth = $('.page-content').width();
	
	//console.log("Container Width: " + cwidth);

	if (cwidth <= 750)
	{
		$('#blogSideContainer').css('width', cwidth);
	}
	else
	{
		var col8Width = $('#blogContentCol').width();
		//console.log("Col-8 Width: " + col8Width);
	
		//var width = $('#mapWell .well').width();
		var width = cwidth - col8Width;
		
		$('#blogSideContainer').css('width', width);
	}


}