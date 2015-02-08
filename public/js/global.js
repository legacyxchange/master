var global = {}

global.CSRF_token = 'token';
global.CSRF_hash = '';

global.bmsUrl;

global.spinner = "<i class='fa fa-spinner fa-spin'></i> ";


global.alertTimeoutSeconds = 3000; // milliseconds until alerts clear
global.alertTimeout;

global.userid = 0;
global.logged_in = false;


global.footerHeight = 50; // number of pixels high footer should be
global.mainContainerHeightType = 'min-height';

global.debug = true;

// global onload
$(function () {

    // if hidden input exists for CSRF token, gets value
	/*
    if ($('#' + global.CSRF_token).exists())
    {
        global.CSRF_hash = $('#' + global.CSRF_token).val();
    }

    if ($('#bmsUrl').exists())
    {
        global.bmsUrl = $('#bmsUrl').val();
    }
    */
    $('#headerLoginBtn, #loginXSBtn, #loginBigButton, #loginChatButton').click(function (e) {
        $('#loginModal').modal('show');
        setTimeout(function () { $('#user_email').focus(); }, 1000);
    });
	
    $('.menu_custom_item').click(function(){
		var val=$(this).text();
		var html='';
			html=val;
			html +=' <span class="caret"></span>';
		$('#dropdownMenu1').html(html);
	});
	$('#origional_item').hover(function(){
		$('.origional_item_container').show();
		//$('.page-item .dropdown-menu').show();
	});
	
	$('.origional_item_close .fa').click(function(event){
	event.stopPropagation();
		$('.origional_item_container').hide();
	});
	
	$("div.origional_item_container_main").mouseleave(function() {
		$('.origional_item_container').hide();
	});
<<<<<<< HEAD
		
	$('.child_thumb').click(function(){
		var link=$(this).attr('src');
		$('.thumbnail_image img').attr('src',link);
=======
	$('#secondary_item').hover(function(){
		$('.secondary_item_container').show();
		//$('.page-item .dropdown-menu').show();
>>>>>>> 3c7b7d59da0307e3520f486d26b13595a3d419b9
	});
	
	$('.secondary_item_close .fa').click(function(event){
	event.stopPropagation();
		$('.secondary_item_container').hide();
	});
	
	$("div.secondary_item_container_main").mouseleave(function() {
		$('.secondary_item_container').hide();
	});
	$('#store_item').hover(function(){
		$('.store_item_container').show();
		//$('.page-item .dropdown-menu').show();
	});
	
	$('.store_item_close .fa').click(function(event){
	event.stopPropagation();
		$('.store_item_container').hide();
	});
	
	$("div.store_item_container_main").mouseleave(function() {
		$('.store_item_container').hide(); 
	});
	$('#flash_item').hover(function(){
		$('.flash_item_container').show();
		//$('.page-item .dropdown-menu').show();
	});
	
	$('.flash_item_close .fa').click(function(event){
	event.stopPropagation();
		$('.flash_item_container').hide();
	});
	
	$("div.flash_item_container_main").mouseleave(function() {
		$('.flash_item_container').hide(); 
	});
	
	$('.child_thumb').click(function(){
		var link=$(this).attr('src');
		$('.thumbnail_image img').attr('src',link);
	});
	
    $('#forgotPasswordButton').click(function (e) {
    	e.preventDefault();
    	$('#loginModal').modal('hide');
        $('#forgotPasswordModal').modal('show');
        setTimeout(function () { $('#user_email').focus(); }, 1000);
    });
    
    $('#modalFBbtn, #bigFBbtn').click(function (e) { 
    	fb.login($(this), true);
    });

    $('#submitLoginBtn').click(function (e) {
        global.userlogin();
    });
    
    $('#loginform').submit(function (e) {
        global.userlogin();
        setTimeout(function () { $('#user_email').focus(); }, 1000);
    });

    $('.big-link').click(function (e) {
        global.loadSignup();
        setTimeout(function () { $('#firstName').focus(); }, 1000);
    });

    $('.large-img').click(function (e) {
        global.showLargeImage($(this).prev());
        $('.modal-title').html($(this).attr('product_name'))
    });
    
    $('#submitSignupBtn').click(function (e) {
    	
        global.checkRegisterForm();
    });
    
    $('#logoutXSBtn').click(function (e) {
        $(this).attr('disabled', 'disabled');
        $(this).find('i').removeClass('fa-sign-out');
        $(this).find('i').addClass('fa-spinner');
        $(this).find('i').removeClass('fa-spin');

        window.location = '/welcome/logout';
    });

    $('#accountXSBtn').click(function (e) {
        $(this).attr('disabled', 'disabled');
        $(this).find('i').removeClass('fa-sign-out');
        $(this).find('i').addClass('fa-spinner');
        $(this).find('i').removeClass('fa-spin');

        window.location = '/profile';
    });

    $('#profileXSBtn').click(function (e) {
        $(this).attr('disabled', 'disabled');
        $(this).find('i').removeClass('fa-sign-out');
        $(this).find('i').addClass('fa-spinner');
        $(this).find('i').removeClass('fa-spin');

        window.location = '/user/index/' + global.userid;
    });

    $('#main-search #q, #main-search #location, #xs-search #q, #xs-search #location').focus(function () {
        $(this).select();

    }).mouseup(function (e) {
        e.preventDefault();
    });

    //console.log(window.location.pathname);


    global.adjustLayout();

    $(window).resize(function () {
        global.adjustLayout();
    });

    global.setClearAlertTimeout();
});

$.fn.preload = function () {
    this.each(function () {
        $('<img/>')[0].src = this;
    });
}

/**
 * functions dynamically adjust elements on page
 */
global.adjustLayout = function ()
{
    var winH = $(window).outerHeight();
    var fh = $('.footer').outerHeight(); // footer height

    var nh = $('#fixedTopNav').outerHeight(); // nav height

    var winL = $(window).width();

    var newH = (winH - (fh + nh));

    var $node = $('.contentbg .container:first-child');

    if (global.mainContainerHeightType == 'max-height')
    {
        $node.attr("style", global.mainContainerHeightType + ": " + newH + "px;min-height:" + newH + "px;");
    }
    else
    {
        $node.attr("style", global.mainContainerHeightType + ": " + newH + "px");
    }
}



global.smSearch = function ()
{
    $('.main-content').hover(function (e) {
        $('#smAccountInfo').hide();
        $('#navUserIcon').removeClass('navHovered');

        $('#smSearch').hide();
        $('#navSearchIcon').removeClass('navHovered');

        if ($('.indexElements').exists())
        {
            $('.indexElements').removeAttr('style');
        }

    });


    $('#navSearchIcon').click(function (e) {
        $('#smSearch').show();


        if ($('.indexElements').exists())
        {
            $('.indexElements').css('margin-top', '130px');
        }

        $('#smAccountInfo').hide();

        $('#navSearchIcon').addClass('navHovered');
        $('#navUserIcon').removeClass('navHovered');

        $("html, body").animate({scrollTop: 0}, "slow");
    });

    $('#navSearchIcon').mouseover(function () {
        $('#smSearch').show();

        if ($('.indexElements').exists())
        {
            $('.indexElements').css('margin-top', '130px');
        }

        $('#smAccountInfo').hide();

        $('#navSearchIcon').addClass('navHovered');
        $('#navUserIcon').removeClass('navHovered');

        $("html, body").animate({scrollTop: 0}, "slow");
    });

    $('#navUserIcon').click(function (e) {
        $('#smAccountInfo').show();

        if ($('.indexElements').exists())
        {
            $('.indexElements').css('margin-top', '100px');
        }

        $('#smSearch').hide();

        $('#navSearchIcon').removeClass('navHovered');
        $('#navUserIcon').addClass('navHovered');

        $("html, body").animate({scrollTop: 0}, "slow");
    });

    $('#navUserIcon').mouseover(function () {
        $('#smAccountInfo').show();

        if ($('.indexElements').exists())
        {
            $('.indexElements').css('margin-top', '100px');
        }

        $('#smSearch').hide();

        $('#navSearchIcon').removeClass('navHovered');
        $('#navUserIcon').addClass('navHovered');

        $("html, body").animate({scrollTop: 0}, "slow");
    });

}

global.getLocation = function (autoSearch)
{
    if (autoSearch == undefined)
    {
        autoSearch = false;
    }

    /*
     * For mobile users, we will use browser location
     * Desktop users, we will use GeoIP
     */

    if (global.detectmob())
    {
        if (navigator.geolocation)
        {
            // disable location btn and make it spin
            //$('#locatorLink').attr('disabled', 'disabled');
            $('#locatorLink i, #xs-search #xsLocatorBtn i').addClass('fa-spin');
            $('#locatorLink, #xs-search #xsLocatorBtn').addClass('locatorNoCursor');

            navigator.geolocation.getCurrentPosition(function (loc) {
                global.setLocation(loc, autoSearch);
            }, global.unableToFindLoc);
        }
    }
    else
    {
        $('#locatorLink i, #xs-search #xsLocatorBtn i').addClass('fa-spin');
        $('#locatorLink, #xs-search #xsLocatorBtn').addClass('locatorNoCursor');
        $.get('/search/getGeoIP/true', {}, function(data) {
            var location = JSON.parse(data);
            $("#location").val(location.city + ', ' + location.region_code + ' ' + location.zipcode + ', ' + location.country_code);
            $('#locatorLink i, #xs-search #xsLocatorBtn i').removeClass('fa-spin');
            $('#locatorLink, #xs-search #xsLocatorBtn').removeClass('locatorNoCursor');
        });
    }
};

global.detectmob = function() { 
    if (navigator.userAgent.match(/Android/i)
        || navigator.userAgent.match(/webOS/i)
        || navigator.userAgent.match(/iPhone/i)
        || navigator.userAgent.match(/iPad/i)
        || navigator.userAgent.match(/iPod/i)
        || navigator.userAgent.match(/BlackBerry/i)
        || navigator.userAgent.match(/Windows Phone/i)
        )
    {
        return true;
    }
    else
    {
        return false;
    }
}

global.setLocation = function (loc, autoSearch)
{
    if (autoSearch == undefined)
        autoSearch = false;
    //console.log(JSON.stringify(loc));

    $('#lat').val(loc.coords.latitude);
    $('#lng').val(loc.coords.longitude);

    $.getJSON('/welcome/geotargetlocation?lat=' + loc.coords.latitude + '&lng=' + loc.coords.longitude, function (data)
    {
        if (data.status == 'SUCCESS')
        {
            $('#main-search #location, #xs-search #location').val(data.msg);

            if (autoSearch == true)
            {
                window.location = "/search?q=&location=" + escape(data.msg);
                //$('#main-search').submit();
            }
        }
    });

    //$('#location').val('Current Location');

    // re-enable location btn stop spinning
    $('#locatorLink i, #xs-search #xsLocatorBtn i').removeClass('fa-spin');
    $('#locatorLink, #xs-search #xsLocatorBtn').removeClass('locatorNoCursor');


    //$('#locatorLink').removeAttr('disabled');
}

global.unableToFindLoc = function ()
{
    //console.log("Unable to find location");
    global.renderAlert('Unable to find location');
    $('#locatorLink i').removeClass('fa-spin');
    $('#locatorLink').removeClass('locatorNoCursor');
}

/*
 * renders a site wide alert
 *
 * @param String msg - msg to be displayed
 * @param String type (optional) - type of message to be displayed, default is blank, alternate types: 'alert-success', 'alert-error' or 'alert-info'
 * @param String id (optional) - specifcy custom div ID to display the error
 */

global.renderAlert = function (msg, type, id)
{
    clearTimeout(global.alertTimeout);

    var header = "Alert!";

    if (id == undefined)
    {
        id = "site-alert";

        $("html, body").animate({scrollTop: 0}, "slow");
    }

    if (msg == '' || msg == undefined)
    {
        $("#" + id).html('');
        return;
    }

    if (type == undefined)
    {
        type = 'alert-warning';
    }

    if (type == 'alert-error')
        type = 'alert-danger';
   
    if (type == 'alert-danger')
        header = "<i class='fa fa-times-circle-o'></i> Error";
    if (type == 'alert-info')
        header = "<i class='fa fa-exclamation-circle'></i> Information";
    if (type == 'alert-success')
        header = "<i class='fa fa-thumbs-up'></i> Success";

    $('#' + id).html("<div class='alert " + type + " animated fadeIn'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>" + header + "</h4> " + msg + "</div>");

    global.setClearAlertTimeout();

    return true;
}

global.setClearAlertTimeout = function ()
{
    global.alertTimeout = setTimeout(global.clearAlerts, global.alertTimeoutSeconds);
}

global.clearAlerts = function ()
{
    global.setClearAlertTimeout();
}

global.userlogin = function ()
{
    if ($('#user_email').val() == '')
    {
        global.renderAlert('Please enter your E-mail Address!', undefined, 'loginAlert');
        $('#user_email').focus();
        $('#user_email').effect('highlight');
        return false;
    }

    if ($('#user_pass').val() == '')
    {
        global.renderAlert('Please enter your password!', undefined, 'loginAlert');
        $('#user_pass').focus();
        $('#user_pass').effect('highlight');
        return false;
    }
    
    $.post("/welcome/login", $('#loginform').serialize(), function (data) { 
    	if (data.status == 'SUCCESS' && data.permissions > 0){ 
        	window.location.href = data.redirect;
        }else if(data.status == 'SUCCESS' && (data.permissions < 1 || data.permissions == undefined)){ 
        	if(data.redirect != null){
        		window.location.href = data.redirect;
        	}else{
        		window.location.href = '/admin/dashboard';
        	}       
        }
        else{
            global.renderAlert(data.msg, undefined, 'loginAlert');
        }
    }, 'json'); 
}

global.setRedirectUri = function(_uri){
	
	$.post("/welcome/setRedirectUri", {uri:_uri,karateToken:'549dd4d3b74fff6275a92d0cebea6990'}, function (data) { 
		$('#myLegacy').modal('show');
		$('#myLegacy .alerts').html('<div class="row"><h3 class="alert alert-notice" style="text-align:center;">You must login first.</h3></div>');
		
    }, 'json');
}
/*global.loadSignup = function (loadModal)
{
    if (loadModal == undefined)
    {
        loadModal = false;
    }

    $('#loginModal').modal('hide');
    $('#signupModal .login-options').html('').effect('highlight');

    $('#signupModal .modal-title').html("SIGN UP WITH EMAIL");

    //unbind save click
    $('#submitSignupBtn').unbind("click");

    $('#submitSignupBtn').html('SAVE');

    $('#submitSignupBtn').click(function (e) {
    	
        global.checkRegisterForm();
    });

    global.setRegEnter();

    $.get("/welcome/signup", function (data) {
        $('#signupModal .modal-body').html('').effect('highlight').html(data).addClass('animated fadeIn');
        loadModal = true;
        if (loadModal == true)
        {
            $('#signupModal').modal('show');
        }
    });
}*/

global.setLoginEnter = function ()
{
    // sets email textfield to focus so they can start typing right away
    $('#loginModal #user_email').focus();

    $(window).bind('keypress', function (e) {
        var code = e.keyCode || e.which;

        if (code == 13)
        {
            //console.log('ENTER PRESSED');
            global.userlogin();
        }
    });
}

global.setForgotPasswordEnter = function ()
{
    $(window).unbind('keypress');

    // sets email textfield to focus so they can start typing right away
    $('#loginModal #user_email').focus();

    $(window).bind('keypress', function (e) {
        var code = e.keyCode || e.which;

        if (code == 13)
        {
            //console.log("FORGOT ENTER!");
            global.checkForgotPasswordForm();
        }
    });
}

global.setRegEnter = function ()
{
    $(window).unbind('keypress');

    $(window).bind('keypress', function (e) {
        var code = e.keyCode || e.which;

        if (code == 13)
        {
            //console.log("FORGOT ENTER!");
            global.checkRegisterForm();
        }
    });
}

global.styleSelect = function (sel)
{
    $('#main-search #q').val($(sel).text());
}

global.loadForgotPassword = function ()
{
	
    $('#ForgotPasswordModal .modal-title').html("FORGOT PASSWORD");
    //$('#passwordFormGroup, #fbLoginFormGroup, #loginModal a').addClass('animated fadeOut');

    $('#ForgotPasswordModal #submitLoginBtn').text('Submit');

    $('#forgotPWText').show().addClass('animated fadeIn');

    $('#passwordFormGroup, #fbLoginFormGroup, #loginModal a').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function (e)
    {
        $(this).removeAttr('class'); // clears all classes
        $(this).empty();
    });

    //unbind save click
    $('#submitLoginBtn').unbind("click");

    $('#submitLoginBtn').click(function (e) {
        global.checkForgotPasswordForm();
    });

    global.setForgotPasswordEnter();
}

global.checkForgotPasswordForm = function ()
{
    if ($('#user_email').val() == '')
    {
        global.renderAlert('Please enter your e-mail address!', undefined, 'loginAlert');
        $('#user_email').focus();
        $('#user_email').css('background','yellow');
        return false;
    }

    $.post('/welcome/forgotpassword', {email: $('#user_email').val(), karateToken: global.CSRF_hash}, function (data) {
        if (data.status == 'SUCCESS')
        {
            $('#loginModal #user_email').val(''); // clears e-mail field

            global.renderAlert(data.msg, 'alert-success', 'loginAlert');
        }
        else
        {
            global.renderAlert(data.msg, 'alert-error', 'loginAlert');
        }
    }, 'json');

}

global.setError = function(id, msg){	
    $(id).focus();
    $(id).css('background', 'rgb(252, 252, 170)');
    $(id).css('color', '#000');
    $(id).next().html(msg);
    $(id).next().show();
    return false;
}

global.resetError = function(id){
	$(id).css('background', 'white');
	$(id).css('color', '#555');
    $(id).next().html('');
    $(id).next().hide();
    //global.checkRegisterForm();
}
global.checkFirstName = function(){
	if($('#firstName').val().length < 3)
        global.setError($('#firstName'), 'First Name must be at least 3 characters.');
	else
		global.resetError($('#firstName'));
}
global.checkLastName = function(){
	if($('#lastName').val().length < 3)
        global.setError($('#lastName'), 'Last Name must be at least 3 characters.');
	else
		global.resetError($('#lastName'));
}
global.checkUsername = function(){	
	if($('#username').val().length < 6)
        global.setError($('#username'), 'Username must be at least 6 characters.');
	else if($('#username').val().length >= 4){ 
		$.post("/welcome/checkUsername", $('#signupform').serialize(), function (data) { console.log(data)
	    	if (data.status == 'FAILURE')
	        { 
	            global.setError($('#'+data.id), data.msg);
	        }
	    	else if (data.status == 'SUCCESS'){  
	    		global.resetError($('#username'));
	    	}
	    }, 'json');
	}
	else
		global.resetError($('#username'));
}
global.checkEmail = function(){	
	if($('#email').val().length < 4)
        global.setError($('#email'), 'Email must be at least 4 characters.');
	else if($('#email').val().length >= 4){
		$.post("/welcome/checkEmail", $('#signupform').serialize(), function (data) { //console.log(data)
	    	if (data.status == 'FAILURE')
	        { 
	            global.setError($('#'+data.id), data.msg);
	        }
	    	else if (data.status == 'SUCCESS'){  
	    		global.resetError($('#email'));
	    	}
	    }, 'json');
	}
	else
		global.resetError($('#email'));
}
global.checkPassword = function(){
	if($('#passwd').val().length < 4)
        global.setError($('#passwd'), 'Password must be at least 4 characters.');
	else
		global.resetError($('#passwd'));
}
global.checkPasswordConfirm = function(){
	if($('#passwd_confirm').val().length < 4)
        global.setError($('#passwd_confirm'), 'Password Confirmation must be at least 4 characters.');
	else if($('#passwd_confirm').val() != $('#passwd').val()){
		global.setError($('#passwd_confirm'), 'Passwords donot match.');
	}
	else
		global.resetError($('#passwd_confirm'));
}
global.checkRegisterForm = function ()
{ 
	global.checkFirstName();
	
	global.checkLastName();
	
	global.checkUsername();
	
    global.checkEmail();
    
	global.checkPassword();
	
	global.checkPasswordConfirm();
	
	$formData = $('#signupform').serialize();
	var count = 0;
	$.each( $('.alert-danger'), function( key, value ) {
		if($(value).html() != ''){
			count++;
		}		  
	});
	
	if(count < 1){
		$('.modal-body').css('height', '400px');
		$('.modal-body').html('<img height="100" style="margin: auto;position: absolute;top: 0; left: 0; bottom: 0; right: 0;" src="/public/images/download.gif" />');
	}
	
	$.post("/welcome/register", $formData, function (data) { //console.log(data)
    	
		if (data.status == 'SUCCESS')
		{   
			location.href = '/profile';
		}
        else if (data.status == 'FAILURE')
        {
            global.setError($('#'+data.id), data.msg);
        }
        else
        {
            //global.renderAlert('Please enter your password!', 'alert-danger', 'loginAlert');
        }
    }, 'json');
}

global.ajaxLoader = function (divId, size)
{

    if (size == undefined)
        size = 80;

    var html = "<canvas id='dyn-ajax-loader'></canvas>";

    //global.log($node, true);

    $(divId).html(html);

    $node = $(divId).find('canvas#dyn-ajax-loader');

    $node.ClassyLoader({
        animate: true,
        percentage: 99,
        width: size,
        diameter: 30,
        fontFamily: 'Open Sans',
        fontSize: '16px',
        height: size
    });

    $node.setPercent(99);

    return $node;
};

global.log = function (msg, jsonStringify)
{
    if (jsonStringify == undefined)
        jsonStringify = false;

    if (global.debug)
    {
        var m = (jsonStringify) ? JSON.stringify(msg) : msg;

        console.log(m);
    }
}

global.showLargeImage = function(obj){
	//console.log($(obj).find('img').attr('src'))
	var uri = $(obj).find('img').attr('src');
	//console.log(uri)
	uri = uri.replace('160', '500');
	
	$('#largeImageModal .modal-body').html('<img src="'+uri+'" />'); 
    $('#largeImageModal').modal('show');
}

$(document).ready(function(){
	$.ajax( "/shoppingcart/checkForItems")
    .done(function( data ) { //console.log()
        if(data.indexOf('0 item') < 0)
            $('#cart-items').html(data);
    })
    .fail(function() {
        alert( "error" );
    });
	
	$('#header-explore').change(function(e){
		location.href='/listings/index/'+$(this).val();
	});
});