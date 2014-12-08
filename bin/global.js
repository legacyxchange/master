var global = {}


global.CSRF_token = 'token';

global.CSRF_hash = '';

global.showEffect = 'highlight';
global.hideEffect = 'highlight';

global.effect = 'highlight';

global.notTimeoutSeconds = 60000; // millisecond until timeout checks again for msgs, notifcations etc.
global.notificationTimeout;
global.msgNotificationTimeout;
global.subNotificationTimeout;

global.logged_in = false;
global.admin = false;

global.company = 0;

/**
 * Jquery functions
 */

// jquery function to check if element exists;
jQuery.fn.exists = function(){ return this.length>0; }


jQuery.fn.cancelButton = function(location)
{
    this.click(function(e){
        if (confirm("Are you sure you wish to cancel?"))
        {
            window.location = location;
            this.setAttribute('disabled', 'disabled');
        }
    });
}

$(function(){

    // if hidden input exists for CSRF token, gets value
    if ($('#' + global.CSRF_token).exists())
    {
        global.CSRF_hash = $('#' + global.CSRF_token).val();
    }



    if ($('#lockModal').exists())
    {
        $('#lockModal').modal({
            backdrop: 'static',
            keyboard:false,
            show: false
        });

        $('#lockModal').on('shown.bs.modal', function (){
            global.modalBackdropLock();
        });
    }


    if ($('#searchModal').exists())
    {

        // when access model shown event is triggered
        $('#searchModal').on('shown', function () {
            $('#modalSearchForm #q').focus();
        });

        $('body').keypress(function(event){

            // console.log(event.which); // used for testing to find keys

            // shift + ~
            if (event.which == 126)
            {
                $('#searchModal').modal('toggle');
            }

            // alt + l
            if (event.which = 188)
            {
                // global.lockSite();
            }
        });


    }

    if ($('#navLoginBtn').exists())
    {
        $('#navLoginBtn').removeAttr('disabled');

        $('#navLoginBtn').click(function(e){
            $(this).attr('disabled', 'disabled');
            window.location = "/intranet/login";
        });
    }

    
    if ($('#navLoggedInBtn').exists())
    {
        $('#navLoggedInBtn').removeAttr('disabled');

        $('#navLoggedInBtn').click(function(e){
            window.location = '/intranet/landing';

            $(this).attr('disabled', 'disabled');
            $(this).find('i').removeClass('fa-user');
            $(this).find('i').addClass('fa-spinner');
            $(this).find('i').addClass('fa-spin');

        });
    }

    // global.checkRequiredDocs();

    if (global.logged_in == true)
    {
        global.checkNotifications();
        global.checkNewMessages();
        global.checkSubscription();
    }
    // att.init();


    global.adjustNavbar();

    // executes function on resizing of window
    $(window).resize(function(){
        global.adjustNavbar();
    });

    $(window).load(function(){

        // re-adjusts nav bar once page is completely loaded
        global.adjustNavbar();

        global.adjustLogo();
    });

    // makes it so pressing enter on a form does
    // not submit it - problem in chrome
    // $('form').bind("keypress", function (e) {
    //     if (e.keyCode == 13) return false;
    // });


});

global.addCommas = function(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\lengthd+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ','             + '$2');
    }

    return x1 + x2;
}



/*
 * renders a site wide alert
 *
 * @param String msg - msg to be displayed
 * @param String type (optional) - type of message to be displayed, default is blank, alternate types: 'alert-success', 'alert-error' or 'alert-info'
 * @param String id (optional) - specifcy custom div ID to display the error
 */

global.renderAlert = function(msg, type, id)
{
    var header = "Alert!";

    if (id == undefined)
    {
        id = "site-alert";

        $("html, body").animate({ scrollTop: 0 }, "slow");
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


    // patch for bootstrap 3
    if (type == 'alert-error') type = 'alert-danger';

    //$("#" + id).html("<div class='ui-widget'><div class='ui-state-error ui-corner-all' style=\"padding: 0 .7em;\"><p><span class='ui-icon ui-icon-alert' style=\"float: left; margin-right: .3em;\"></span><strong>Alert:</strong> "+msg+"</p></div></div>");

    if (type == 'alert-danger') header = "<i class='fa fa-times-circle-o'></i> Error";
    if (type == 'alert-info') header = "<i class='fa fa-exclamation-circle'></i> Information";
    if (type == 'alert-success') header = "<i class='fa fa-thumbs-up'></i> Success";

    $('#' + id).html("<div class='alert " + type + "'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>" + header + "</h4> " + msg +"</div>");
return true;

}

global.selectAllToggle = function(divId, sel)
{

    if (sel == undefined)
    {
        sel = true;
    }

    $('#' + divId).find("input").each(function(index, item){
        if ($(item).attr('type') == 'checkbox')
        {
            $(item).prop('checked', sel);
        }
    });
}

/**
 * checks if an email address is valid
 */
global.checkEmail = function(inputvalue)
{
    var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;

    if(pattern.test(inputvalue))
    {
        return true;
    }
    else
    {
        return false;
    }
}

global.ajaxLoader = function(divId)
{
    var html = "<div class='row' style=\"margin:50px 0;\">" +
        "<div class='well col-lg-2 col-lg-offset-4 col-m-2 col-m-offset-4 col-s-2 col-s-offset-4 col-xs-2 col-xs-offset-4' align='center' style=\"min-width:150px;\">" +
        "<img src='/public/images/loader.gif'> Loading..." +
        "</div>" +
        "</div>";

    $(divId).html(html);
}


global.containerResize = function (sel, offset)
{
    if (offset == undefined) offset = 400;

    var h = $(window).height() - offset;

    sel.css('min-height', h + 'px');
}


global.clearRightClick = function()
{
    // clears previous right click if showing
    if ($('#right-click-menu').exists())
    {
        $('#right-click-menu').remove();
    }
}

global.slimScroll = function (div, h)
{
    if (h == undefined) h = '100%';

    $(div).slimScroll({
        height: h
    });
}

global.noRightClick = function ()
{
    $(document).bind("contextmenu",function(e){ return false; });
}

global.clearRightClick = function ()
{

    // removes right click context menu
    $('body').click(function(e){

        if ($(e.target)[0].tagName != 'A')
        {
            // clears previous right click if showing
            if ($('#right-click-menu').exists())
            {
                $('#right-click-menu').remove();
            }
        }
    });
}

global.setFileDraggable = function()
{
        $('#fileList').selectable({
            filter: "li",
            selected: function (event, ui)
            {

                global.clearRightClick();

                /*
                // clears previous right click if showing
                if ($('#right-click-menu').exists())
                {
                    $('#right-click-menu').remove();
                }
                */

                    $(ui.selected).draggable({
                    start: function (e, u)
                    {
                        // $(this).addClass('moving');
                    },
                    stop: function (e, u)
                    {
                        // $(this).removeClass('moving');
                    },
                    helper: function(){

                        var selected = $('#fileList').find('.ui-selected');

                        if (selected.length === 0)
                        {
                            selected = $(this);
                        }
                        var container = $('<div/>').attr('id', 'draggingContainer');
                        var clone = selected.clone();
                        clone.addClass('moving');
                        container.append(clone);
                        return container;
                        }

                    });
            },
            unselected: function (event, ui)
            {
                $(ui.unselected).draggable('destroy');
            }
        });

}

/**
 * checks if the user has any documents that are required to sign/view
 *
 */
global.checkRequiredDocs = function ()
{
    // checks if they are already on the newhire page before checking

    // var pattern = "/^newhire/";
    
    var pattern = new RegExp("docs");

    var pathname = window.location.pathname;

    // console.log('path: '+ pathname);

    var check = pattern.test(pathname);

    // console.log('pattern check: ' + String(check));

    if (check == false)
    {

        $.getJSON("/docs/checkrequire", function(data){
            if (data.status == 'SUCCESS')
            {
                if (data.msg == 'TRUE')
                {
                    if (confirm("There are documents that you are required to sign. Do you wish to sign them now?"))
                    {

                    }
                    else
                    {
                        // global.
                    }
                    // window.location = '/newhire';
                }
            }
            else if (data.status == 'ALERT')
            {
                global.renderAlert(data.msg);
                return false;
            }
            else
            {
                global.renderAlert(data.msg, 'alert-danger');
                return false;
            }
        });

    }
}


global.logout = function ()
{
    $.getJSON("/intranet/logout/1", function(data){

        if (data.status == 'CLOCKIN')
        {
            $('#logoutModal').html(data.html);

            global.renderAlert(data.msg, undefined, 'logoutAlert');


            $('#logoutClockOutBtn').click(function(e){
                global.addTimePunch();

                $(this).attr('disabled', 'disabled');
                $('#logoutAnyBtn').attr('disabled', 'disabled');
                $('#logoutCancelBtn').attr('disabled', 'disabled');
            });

            $('#logoutAnyBtn').click(function(e){
                global.forceLogout();

                $(this).attr('disabled', 'disabled');
            });

            $('#logoutModal').modal('show');
        }
        if (data.status == 'SUCCESS')
        {
            // global.forceLogout();
            window.location = '/intranet/login?site-alert=' + escape(data.msg);
        }
        else if (data.status == 'ALERT')
        {
            global.renderAlert(data.msg);
            return false;
        }
        else
        {
            global.renderAlert(data.msg, 'alert-danger');
            return false;
        }
    });
}

/**
 * function used to clock out when logging out
 */

global.addTimePunch = function ()
{
    $.post("/clockinout/addpunch", $('#punchForm').serialize(), function(data){

        $('#punchMsg').html('');

        if (data.status == 'SUCCESS')
        {
            $('#logoutModal').modal('hide');
            $('#logoutModal').html('');

            global.logout();
        }
        else if (data.status == 'ALERT')
        {
            global.renderAlert(data.msg, undefined, 'logoutAlert');
            return false;
        }
        else
        {
            global.renderAlert(data.msg, 'alert-danger', 'logoutAlert');
            return false;
        }

        // closes modal
        // setTimeout(function(){ clockinout.closePunchModal(); }, 5000);

    }, 'json');

}

global.forceLogout = function ()
{
    window.location = '/intranet/logout/0/1';
}


global.lockSite = function ()
{
    $('#lockModal').modal('show');
}

/**
 * used to make backdrop of modal darker to conceal background
 */
global.modalBackdropLock = function ()
{
    var bd = $('.modal-backdrop');

    bd.addClass('modal-hide');
}


global.checkNotifications = function ()
{
    $.getJSON("/intranet/notifications", function(data){

        if (data.status == 'NONE')
        {
            // no messages, remove classes etc.
            $('#notificationLi').addClass('notification');

            // resets HTML
            $('#notificationLi').html(data.html);

        }
        else if (data.status == 'SUCCESS')
        {
            $('#notificationLi').removeClass('notification');
            $('#notificationLi').html(data.html);
        }
        else if (data.status == 'ERROR')
        {
            global.renderAlert(data.msg, 'alert-danger');

            // resets HTML 
            $('#msgNotLi').html("<a href='javascript:void(0);'><i class='fa fa-exclamation-circle'></i></a>");
        }


        global.adjustNavbar(); // readjusts nav bar to ensure eveyrthing fits ok

        // sets a timer to execute the function again after a set amount of time  (check variable above)
        global.notificationTimeout = setTimeout('global.checkNotifications()', global.notTimeoutSeconds);
    });
}

global.checkNewMessages = function ()
{
    $.getJSON("/msg/notifications", function(data){

        if (data.status == 'NOMSG')
        {
            // no messages, remove classes etc.
            $('#msgNotLi').addClass('notification');

            // resets HTML
            // $('#msgNotLi').html("<a href='javascript:void(0);'><i class='fa fa-envelope'></i></a>");
            $('#msgNotLi').html(data.html);

        }
        else if (data.status == 'SUCCESS')
        {
            $('#msgNotLi').removeClass('notification');
            $('#msgNotLi').html(data.html);
        }
        else if (data.status == 'ERROR')
        {
            global.renderAlert(data.msg, 'alert-danger');

            // resets HTML 
            $('#msgNotLi').html("<a href='javascript:void(0);'><i class='fa fa-envelope'></i></a>");
        }


        global.adjustNavbar(); // readjusts nav bar to ensure eveyrthing fits ok

        // sets a timer to execute the function again after a set amount of time  (check variable above)
        // console.log('timer being set for checking new messages'); // unncomment for debugging
        global.msgNotificationTimeout = setTimeout('global.checkNewMessages()', global.notTimeoutSeconds);
    });
}

global.checkSubscription = function (setTimeoutFunc, redirect)
{

    if (setTimeoutFunc == undefined) setTimeoutFunc = true;
    if (redirect == undefined) redirect = true;

    var pathname = window.location.pathname;

    var regex = new RegExp(/\/companysettings/gi);

    var match = regex.test(pathname);

    if (match == false)
    {
        // they are not on the company settings page and must be 
        // re-directed in order to fix their subscirption
        $.getJSON("/intranet/checksubscription", function(data){
            
            // if ($('#BrainTreeSubscriptionID').val(data.status);

            if (data.status == 'EXEMPT')
            {
                // do nothing pretty much
            }
            else if (data.status == 'ALERT')
            {
                if (redirect == true)
                {
                    if (global.admin == true)
                    {
                        window.location = '/companysettings?site-alert=' + escape(data.msg);
                    }
                    else
                    {
                        window.location = '/intranet/login?site-alert=' + escape(data.msg);
                    }
                }
            }
            else
            {
            }

            if(setTimeoutFunc == true) global.subNotificationTimeout = setTimeout('global.checkSubscription()', global.notTimeoutSeconds);
        });
    }
}

global.composeNewMsg = function ()
{
    $.get("/msg/compose/1", function(data){
        //code...
    });
}

global.viewMsg = function (msg)
{
    window.location = '/msg/compose?reply=' + msg;
}

global.adjustNavbar = function ()
{
    if ($('#main-nav').exists())
    {
        var navWidth = $('#main-nav').outerWidth();

        var container = $('#main-nav').parent().parent().innerWidth();

        var brand = $('#main-nav').parent().parent().find('.navbar-brand').outerWidth();

        // console.log($('#main-nav').parent().parent().attr('class'));

        // console.log('navwidth: ' + navWidth);
        // console.log('Brand width: ' + brand);
        // console.log('container Width: ' + container);

        var diff = container - (navWidth + brand);

        $('#q').width(diff - 150);

    }

}

global.adjustLogo = function ()
{
    // first get height of main navbar
    var navH = $('#main-top-nav').height();

    if(!$('#headerLogo').exists())
    {
        // no logo image being displayed (just txt)
        return false;
    }

    var logoH = $('#headerLogo').height();

    // console.log('Navbar height: ' + navH);
    // console.log('Logo height: ' + logoH);

    // now get logo height

    var buffer = (navH - logoH) / 2;

    // console.log("Buffer: "+  buffer);

    $('#headerLogo').css('padding-top', buffer);
}

/**
 * global function used to calculate the final price
 * this will ensure the algorithm is always the same
 */
global.calculatePricing = function (numUsers, moduleTotal)
{

    total = (moduleTotal * numUsers) + 100;

    return total;
}

global.toggleCheckboxBtn = function (b)
{
    if ($(b).hasClass('btn-success'))
    {
        $(b).removeClass('btn-success');
        $(b).addClass('btn-default');
    }
    else
    {
        $(b).removeClass('btn-default');
        $(b).addClass('btn-success');
    }
}

global.viewModKBArticle = function (module)
{
    if (module == undefined || module == 0)
    {
        global.renderAlert("Unable to view Knowledge Base Article as module ID is empty!");
        return false;
    }


    if (confirm("Are sure you wish to view the Knowledge Base Article for this module?"))
    {
        window.location = '/kb/view?module=' + escape(module);
    }
}

global.setCursorWaiting = function ()
{
    $('body').css('cursor', 'wait');

    $('body').hover(function(){
        
        $('body').css('cursor', 'wait');

    });
}

/**
 *  Used for select all checkboxes in a table (or div)
 *
 */
global.tblChkboxSelectAllToggle = function (sel, div)
{
    // get table

    $(div).find("input").each(function(index, item){
        if ($(sel).prop('checked') == true)
        {
            // $(item).attr('checked', 'checked');
            $(item).prop('checked', true);
        }
        else
        {
            // $(item).removeAttr('checked');
            $(item).prop('checked', false);
        }
    });

}
