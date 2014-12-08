var wall = {}

wall.refreshInterval = 10000; // miliseconds between checking for wall updates 1000 = 1 sec
wall.refreshTimeout = null;
wall.delBtnTimeout = null;
//wall.checkingForUpdates = false;
wall.refreshCnt = 0; // keeps track of number of times wall has been refreshed

wall.refreshRequest;

wall.load = function ()
{
    var loader = global.ajaxLoader('#stream-display');

    $.get('/wall/view/' + $('#id').val(), function (data) {
        loader.setPercent(100).show();
        $('#stream-display').html(data);
        $('#viewMoreBtn').click(function (e) {
            wall.loadPreviousPosts();
        });
        wall.loadSpinner();
        wall.wallScrollBottom();
        wall.setCommentTextareaAutosize();
        wall.renderImgPreviews();
        wall.setrefreshTimeout();
        wall.renderCommentDelBtns();
        wall.renderPostDelBtns();
    });
};

wall.loadSpinner = function ()
{
    $('#stream-display #spin-container').spin({
        className: 'spinner-index',
        shadow: false,
        color: '#FFF'
    });

}

wall.hideLoader = function (unbindScroll, completeFunction, duration, $node)
{
    if ($node == undefined)
        $node = $('#wall-loader, #viewMoreBtn');

    if (unbindScroll == undefined)
        unbindScroll = true;
    if (duration == undefined)
        duration = 1000;

    if (unbindScroll)
        $(window).unbind('scroll');



    $node.velocity({opacity: 0, height: 0}, {
        duration: duration,
        complete: function () {
            $(this).hide();

            if (completeFunction !== undefined)
            {
                if (typeof completeFunction == 'function')
                    completeFunction(this);
            }

        }
    });

}

// function that checks when user scrolls to bottom
// in which it will load more stuff
wall.wallScrollBottom = function ()
{

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {

            $(window).unbind('scroll');

            wall.loadPreviousPosts();

            //global.log("near bottom!");
        }
    });
}

wall.loadPreviousPosts = function ()
{
    $('#wall-loader').show();
    var minPostID = wall.findMinPostID();

    $('#wall-loader').velocity({opacity: 1, height: 90}, {
        duration: 100,
        complete: function () {
            $.get('/wall/loadpreviousposts/' + $('#id').val() + '/' + minPostID, function (data) {

                if (!data.trim())
                {

                    wall.hideLoader(false, function (el) {
                        $(el).hide();
                    }, 1000);


                }
                else
                {
                    $('#wall-form').append("<div class='tempContent' style='height:0px;'>" + data + "</div>");



                    $node = $('#wall-form .tempContent').last();

                    wall.renderImgPreviews($node);
                    wall.renderPostDelBtns($node);


                    $node.velocity("slideDown", {duration: 1000,
                        complete: function () {

                            $(this).removeAttr('style');

                            wall.setCommentTextareaAutosize($node);

                            wall.hideLoader(false, function (el) {

                                $('#wall-loader').hide();

                                wall.wallScrollBottom();

                            }, 1000, $('#wall-loader'));
                        }
                    });


                }
            });
        }
    });





}

wall.findMinPostID = function ()
{
    var min = 0;

    $("[name='postID\[\]']").each(function (index, item) {
        var postID = parseInt($(item).val());

        if (isNaN(postID))
            return false;

        //global.log(postID, true);

        if (index == 0)
            min = postID;
        else
        {
            if (postID < min)
                min = postID;
        }

    });

    return min;
}

wall.getRefreshCnt = function ()
{
    global.log(wall.refreshCnt);
}

wall.setRefreshing = function (refreshing)
{
    if (refreshing == undefined)
        refreshing = true;

    var r = (refreshing) ? '1' : '0';


    $('#wall-form #refreshing').val(r);


    if (refreshing)
        return true;

    return false;
}

wall.getRefreshing = function ()
{
    var refreshing = $('#wall-form #refreshing').val();

    if (refreshing == '0')
        return false;

    return true;
}

wall.refresh = function (force)
{

    if (!$('#wall-form').exists())
        return false;

    //global.log('checking for updates: ' + wall.checkingForUpdates);
    if (force == undefined)
        force = false;

    if (force)
        wall.stopRefresh();

    // checks if currently in the process of refreshing
    // if so, stops current refresh and starts a new one
    if (wall.getRefreshing() == true)
        wall.stopRefresh();

    //if (wall.refreshTimeout !== null) return false;

    wall.setRefreshing(true);

    //global.log("Refreshing: " + new Date($.now() * 1000));

    var wallData = $('#wall-form').serialize();

    //global.log(wallData);
    //global.log("Getting Refresh data");
    wall.refreshRequest = $.ajax({
        url: '/wall/refresh',
        data: wallData,
        type: 'POST',
        dataType: 'json',
        success: function (data)
        {


            if (data.status == 'SUCCESS')
            {
                wall.applyUpdates(data);
            }


            wall.stopRefresh();

            wall.refreshCnt += 1;
            wall.setrefreshTimeout();
            wall.renderCommentDelBtns();


        },
        error: function (e)
        {
            wall.stopRefresh();

            wall.setrefreshTimeout();
        }
    });

    //global.log(typeof wall.refreshRequest == 'object');
}

wall.stopRefresh = function ()
{

    if (wall.refreshRequest !== undefined)
    {
        wall.refreshRequest.abort();
    }

    wall.setRefreshing(false);
    //wall.refreshTimeout = null;

    wall.clearTimeout();
    //global.log('STOP TIMEOUT: ' + wall.refreshTimeout);
    return true;
}

wall.setrefreshTimeout = function ()
{
    if (wall.refreshTimeout == null)
    {
        wall.refreshTimeout = setTimeout(function () {
            //wall.refreshTimeout = null;

            wall.refresh();
        }, wall.refreshInterval);

        //global.log(wall.refreshTimeout, true);

        //global.log("timeout is set!");

        return true;
    }

    return false;
}

wall.clearTimeout = function ()
{
    //global.log('CLEAR TIMEOUT: ' + wall.refreshTimeout);

    if (wall.refreshTimeout !== null)
    {
        clearTimeout(wall.refreshTimeout);

        wall.refreshTimeout = null;

    }

    return true;
}


wall.applyUpdates = function (data)
{

    $.each(data, function (postID, el) {
        if (!isNaN(postID))
        {

            var $wpc = $("div[postID='" + postID + "']");

            var $post = $wpc.find('.wallpost');

            //global.log($post.html(), true);

            $post.find('.wallpost-time').html(el.time + ' ago');

            // updates like count
            var likes = parseInt(el.likes);

            //global.log("Likes ("+postID+"): " + likes);

            $likeContainer = $wpc.find('.like-container');

            var $likeBtn = $wpc.find('.wallpost-actions button').first();

            //global.log($likeContainer, true);

            var people = (likes == 1) ? 'person' : 'people';
            var s = (likes == 1) ? 's' : null;

            var likeTxt = "<a href='javascript:void(0);'><i class='fa fa-thumbs-up'></i> <span>" + likes + "</span> " + people + "</a> like" + s + " this";

            $likeContainer.html(likeTxt);

            //global.log($likeContainer.css('display'));
            if (likes == 0)
            {
                if ($likeContainer.css('display') !== 'none')
                    $likeContainer.velocity('fadeOut');
            }
            else
            {
                // fades div back in if there is a like
                if ($likeContainer.css('display') == 'none')
                    $likeContainer.velocity('fadeIn');
            }


            if (el.youLike !== undefined)
            {
                if (el.youLike == true)
                {
                    wall.setLikeThumbDown($likeBtn, postID);
                }
                else
                {
                    wall.setLikeThumbUp($likeBtn, postID);
                }

            }

            wall.commentUpdates(postID, el.comments);

            if (el.new_comments !== undefined)
            {
                wall.addNewDynamicComment(postID, el.new_comments);

            }


        }
    });


    if (data.new_posts !== undefined)
    {
        wall.addNewDynamicPosts(data.new_posts);
    }
}

wall.commentUpdates = function (postID, comments)
{
    // goes through and updates each post comment
    if (comments !== undefined)
    {
        var $wpc = $("div[postID='" + postID + "']");

        $.each(comments, function (commentID, c) {

            if (c.deleted !== undefined)
            {
                if (c.deleted == 1)
                {
                    // if comment is deleted, removes html
                    $wpc.find("div[commentid='" + commentID + "']").velocity({opacity: 0}, {
                        complete: function ()
                        {
                            $(this).remove();
                        }
                    });
                }
            }

            // updates time
            $wpc.find("div[commentid='" + commentID + "'] .wallpost-time").html(c.time + ' ago');

        });

    }
}

wall.addNewDynamicComment = function (postID, new_comments)
{
    var html = $('#commentHtml').html();

    //global.log(new_comments, true);

    $.each(new_comments, function (commentID, c) {
        //global.log('COMMENT ID TO ADD: ' + commentID);
        var $commentID = commentID;

        var el = $.parseHTML(html);

        $('#all_comments_' + postID).append(html);

        var $node = $('#all_comments_' + postID + ' .comment-container:last-child');

        var src = $node.find('.post-img').attr('src');

        $node.attr("commentid", commentID);
        $node.find('input').attr('name', 'commentID[' + postID + '][]');
        $node.find('input').val(commentID);

        $node.find('.comment-body').html(c.body);
        $node.find('.wallpost-time').html(c.time + ' ago');

        $node.find('.wallpost-name a').text(c.name);

        $node.find('.wallpost-name a').attr('href', "/user/index/" + c.postingUser);

        $node.find('.post-img').attr('src', src + c.postingUser);

        if (global.logged_in)
        {
            if (parseInt(global.userid) == parseInt($('#id').val()))
            {
                // they are viewing their own wall.
                wall.renderCommentDelBtns($node);
            }
            else if (parseInt(global.userid) == parseInt(c.postingUser))
            {
                // they are deleteing their own comment
                wall.renderCommentDelBtns($node);
            }
            else
            {
                wall.removeDeleteButton($node);
            }
        }
        else
        {
            wall.removeDeleteButton($node);
        }

    });
}

wall.removeDeleteButton = function ($node)
{
    $node.find('div.deleteBtn').html('');
}

wall.addNewDynamicPosts = function (new_posts)
{
    //global.log(new_posts, true);

    var html = $('#postHtml').html();

    var newCommentHtml = $('#newCommentHtml').html();

    $.each(new_posts, function (postID, p) {
        var $postID = postID;

        var postHtml = "<div class='wallpost-container' postID='" + postID + "'>" + html + "<div id='all_comments_" + postID + "'>" +
                "</div>" + newCommentHtml + "</div> <!-- /.wallpost-container -->";

        var el = $.parseHTML(postHtml);

        $('#wall-form').prepend(el);

        var $node = $('#stream-display .wallpost-container:first-child');

        var $likeContainer = $node.find('.like-container');

        var $likeBtn = $node.find('.wallpost-actions button:first-child');

        $likeContainer.find('span').text(p.likes);

        if (p.likes > 0)
            $likeContainer.css('display', '');

        var src = $node.find('.post-img').attr('src');

        $node.find('.post-img').attr('src', src + p.postingUser);

        if (p.photo_html !== false)
        {
            $(p.photo_html).insertAfter($node.find('.post-body'));
        }

        $node.find("input[name='postID\[\]']").val(postID);

        $node.find('.post-body').html(p.body);

        $node.find('.wallpost-time').html(p.time + ' ago');

        $node.find('.wallpost-name a').text(p.name);

        // prepares textarea
        $node.find('textarea').attr('postID', postID).autosize().css('height', '40px').focus(function (e) {
            wall.commentEnter(this);
        });



        $node.find('.wallpost-name a').attr('href', "/user/index/" + p.postingUser);


        if (p.youLike !== undefined)
        {
            if (p.youLike == true)
            {
                wall.setLikeThumbDown($likeBtn, postID);
            }
            else
            {
                wall.setLikeThumbUp($likeBtn, postID);
            }

        }

        if (global.logged_in)
        {
            if (parseInt(global.userid) == parseInt($('#id').val()))
            {
                // they are viewing their own wall.
                wall.renderPostDelBtns($node);
            }
            else if (parseInt(global.userid) == parseInt(p.postingUser))
            {
                // they are deleteing their own comment
                wall.renderPostDelBtns($node);
            }
            else
            {
                wall.removeDeleteButton($node);
            }
        }
        else
        {
            wall.removeDeleteButton($node);
        }

        // adds comments if necessary
        if (p.comments !== undefined)
        {
            // post does have comments
            wall.addNewDynamicComment(postID, p.comments);
        }
    });
}


wall.like = function (b, postID)
{

    //wall.stopRefresh();

    $(b).attr('disabled', 'disabled');

    $.post('/wall/like', {postID: postID, karateToken: global.CSRF_hash}, function (data) {

        $(b).removeAttr('disabled');

        if (data.status == 'SUCCESS')
        {
            wall.setLikeThumbDown(b, postID);

            wall.updateDynamicLikeCnt(postID, 1);

            if (wall.refreshTimeout !== null)
            {
                wall.stopRefresh();
            }

            var r = wall.refresh();
            //global.log(r, true);
        }
        else
        {

        }
    }, 'json');
}


wall.unlike = function (b, postID)
{


    $(b).attr('disabled', 'disabled');

    $.post('/wall/unlike', {postID: postID, karateToken: global.CSRF_hash}, function (data) {

        $(b).removeAttr('disabled');

        if (data.status == 'SUCCESS')
        {

            wall.setLikeThumbUp(b, postID);

            wall.updateDynamicLikeCnt(postID, -1);

            if (wall.refreshTimeout !== null)
            {
                wall.stopRefresh();
            }

            var r = wall.refresh();
            //global.log(r, true);
        }
        else
        {

        }
    }, 'json');
}

wall.setLikeThumbUp = function (b, postID)
{
    $(b).html("<i class='fa fa-thumbs-o-up'></i>");
    $(b).attr('onclick', "wall.like(this, " + postID + ");");
}

wall.setLikeThumbDown = function (b, postID)
{
    $(b).html("<i class='fa fa-thumbs-o-down'></i>");
    $(b).attr('onclick', "wall.unlike(this, " + postID + ");");
}

// db may be cached and like/unlike may not be counted when user hits it
wall.updateDynamicLikeCnt = function (postID, offset)
{
    $likeContainer = $("div[postID='" + postID + "']").find('.like-container');

    var current_likes = parseInt($likeContainer.find('span').text());

    current_likes += offset;

    if (current_likes == 0)
        $likeContainer.velocity('fadeOut', {
            duration: 200,
            complete: function () {
                $likeContainer.find('span').text(current_likes);
            }
        });




    if (current_likes == 1)
    {
        $likeContainer.find('span').text(current_likes);
        $likeContainer.velocity('fadeIn', {
            duration: 200
        });
    }
}

wall.setCommentTextareaAutosize = function ($node)
{
    if ($node == undefined)
        $node = $('#stream-display');

    $node.find('textarea').each(function (index, item) {
        $(item).autosize();

        $(item).css('height', '40px');

        $(item).focus(function (e) {
            wall.commentEnter(this);
        });
    });
}

wall.commentEnter = function (comment)
{
    $(window).unbind('keypress');

    $(window).bind('keypress', function (e) {
        var code = e.keyCode || e.which;

        if (code == 13)
        {
            wall.saveComment(comment);
        }
    });
}

wall.saveComment = function (comment)
{
    if ($(comment).val() == '')
    {
        return false;
    }

    var post = $(comment).val();

    $(comment).attr('disabled', 'disabled');

    $.post('/wall/savepost', {post: post, userid: $('#id').val(), parentPost: $(comment).attr('postID'), karateToken: global.CSRF_hash}, function (data) {
        $(comment).removeAttr('disabled');

        if (data.status == 'SUCCESS')
        {
            // clears comment value and height
            $(comment).val('').css('height', 40);

            wall.refresh();
        }
        else
        {

        }
    }, 'json');
}

wall.renderImgPreviews = function ($node)
{
    if ($node == undefined)
        $node = $('#stream-display');

    $node.find('.post-photo-container').each(function (index, item) {
        $(item).justifiedGallery({
            cssAnimation: true
        });
    });
}


wall.renderCommentDelBtns = function ($node)
{
    if ($node == undefined)
        $node = $('.comment-container');


    $node.each(function (index, el) {

        $(el).unbind('mouseenter mouseleave');

        var delBtn = $(this).find('button.close');

        $(el).on('mouseenter', function () {

            if (delBtn !== undefined)
            {
                delBtn.velocity({opacity: 1});
            }

        });

        $(el).on('mouseleave', function (index, el) {

            if (delBtn !== undefined)
            {
                delBtn.velocity({opacity: 0});
            }
        });
    });
}


wall.renderPostDelBtns = function ($node)
{
    if ($node == undefined)
        $node = $('.wallpost-actions');


    $node.each(function (index, el) {

        $(el).unbind('mouseenter mouseleave');

        var delBtn = $(this).find('.deleteBtn button');

        $(el).on('mouseenter', function () {

            if (delBtn !== undefined)
            {
                delBtn.velocity({opacity: 1});
            }

        });

        $(el).on('mouseleave', function (index, el) {

            if (delBtn !== undefined)
            {
                delBtn.velocity({opacity: 0}, {delay: 1000});
            }
        });
    });
}

wall.deleteComment = function (b)
{
    var $cc = $(b).parent().parent();

    var w = $cc.outerWidth();



    $cc.width(w);

    var commentID = parseInt($cc.attr('commentID'));

    $('body').css('overflow-x', 'hidden');

    $cc.velocity({marginLeft: '300%', height: 0, paddingBottom: 0, paddingTop: 0}, {
        complete: function ()
        {
            $(this).remove();
            $('body').css('overflow-x', '');

            $.post('/wall/deletepost/0/0', {postID: commentID, karateToken: global.CSRF_hash}, function (data) {
                if (data.status == 'ERROR')
                {
                    // there was a problem deleteing the comment
                }
            }, 'json');
        }
    });
}

wall.deletePost = function (b)
{
    var $pc = $(b).parent().parent().parent().parent();
    var w = $pc.outerWidth();

    $pc.width(w);

    var postID = parseInt($pc.attr('postID'));

    $('body').css('overflow-x', 'hidden');

    $pc.velocity('slideUp', {
        complete: function () {
            $(this).remove();

            $.post('/wall/deletepost', {postID: postID, karateToken: global.CSRF_hash}, function (data) {
                if (data.status == 'ERROR')
                {
                    // there was a problem deleteing the comment
                }
            }, 'json');
        }
    });

    return true;
}