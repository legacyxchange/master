var fb = {}

window.fbAsyncInit = function() {
  FB.init({
    appId      : '1419205961664233',
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
  });

  // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
  // for any authentication related change, such as login, logout or session refresh. This means that
  // whenever someone who was previously logged out tries to log in again, the correct case below 
  // will be handled. 
  FB.Event.subscribe('auth.authResponseChange', function(response) {
    // Here we specify what we do with the response anytime this event occurs. 
    if (response.status === 'connected') {
      // The response object is returned with a status field that lets the app know the current
      // login status of the person. In this case, we're handling the situation where they 
      // have logged in to the app.
      // testAPI();
    } else if (response.status === 'not_authorized') {
      // In this case, the person is logged into Facebook, but not into the app, so we call
      // FB.login() to prompt them to do so. 
      // In real-life usage, you wouldn't want to immediately prompt someone to login 
      // like this, for two reasons:
      // (1) JavaScript created popup windows are blocked by most browsers unless they 
      // result from direct interaction from people using the app (such as a mouse click)
      // (2) it is a bad experience to be continually prompted to login upon page load.
      FB.login();
    } else {
      // In this case, the person is not logged into Facebook, so we call the login() 
      // function to prompt them to do so. Note that at this stage there is no indication
      // of whether they are logged into the app. If they aren't then they'll see the Login
      // dialog right after they log in to Facebook. 
      // The same caveats as above apply to the FB.login() call here.
      FB.login();
    }
  });
  };

  // Load the SDK asynchronously
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
  }(document));

// Here we run a very simple test of the Graph API after login is successful. 
// This testAPI() function is only called in those cases. 
function testAPI() {
    // console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      // console.log('Good to see you, ' + response.name + '.');
    });
}

fb.login = function (b, register, connect)
{
    if (register == undefined) register = false;
    if (connect == undefined) connect = false;

    $(b).attr('disabled', 'disabled');

    // console.log('Connect: ' + connect);
    // console.log('Register: ' + register);


    FB.login(function(response){
        if (response.authResponse)
        {

            // get their FB info, and attempt to log them in
            FB.api('/me', function(response){
                if (connect == true)
                {
                    $.post("/profile/connectfb", { facebookID: response.id, karateToken:global.CSRF_hash }, function(data){
                        if (data.status == 'SUCCESS')
                        {
                            window.location = '/profile?site-success=' + data.msg;
                        }
                        else
                        {
                            global.renderAlert(data.msg, 'alert-danger');
                            $(b).removeAttr('disabled');
                            return false;
                        }
                    }, 'json');
                }
                else if(register == true)
                {

                    $.post("/welcome/fbreg", { data: response, karateToken:global.CSRF_hash }, function(data){
                        if (data.status == 'SUCCESS')
                        {
                            window.location = '/profile?site-success=' + data.msg;
                            return true;
                        }
                        else if (data.status == 'ALERT')
                        {
                            global.renderAlert(data.msg);
                            $(b).removeAttr('disabled');
                            return false;
                        }
                        else
                        {
                            global.renderAlert(data.msg, 'alert-danger');
                            $(b).removeAttr('disabled');
                            return false;
                        }
                    }, 'json');
                }
                else
                {
                    $.post("/welcome/fblogin", { facebookID: response.id, karateToken:global.CSRF_hash }, function(data){
                        if (data.status == 'SUCCESS')
                        {

                            // fb.getPhoto(true);

                            window.location = '/profile';
                            return true;
                        }
                        else if (data.status == 'ALERT')
                        {
                            global.renderAlert(data.msg);
                            $(b).removeAttr('disabled');
                            return false;
                        }
                        else
                        {
                            global.renderAlert(data.msg, 'alert-danger');
                            $(b).removeAttr('disabled');
                            return false;
                        }
                    }, 'json');
                }

            });

            // fb.getUserInfo();
        }
        else
        {
            global.renderAlert('Facebook Authorization Failed!', 'alert-danger');
            // console.log('Authorization Failed');
        }
    }, { scope: 'email, publish_actions, publish_stream, user_birthday'});
}

fb.logout = function ()
{
    FB.logout(function(){ document.location.reload(); });
}

/*
fb.getUserInfo = function ()
{
    FB.api('/me', function(response){
        console.log(response.id);
        console.log(response.name);
        console.log(response.link);
        console.log(response.username);
        console.log(response.email);
    });
}
*/
/**
 * Gets users facebook profile image
 */
fb.getPhoto = function (save)
{
    if (save == undefined) save = false;

    FB.api('/me/picture?type=large&height=300&width=300', function (r){

        //console.log(JSON.stringify(r));

        var url = r.data.url;

        if (save == true)
        {
            $.post("/profile/savefbphoto", { url:url, karateToken:global.CSRF_hash }, function(data){
                if (data.status == 'SUCCESS')
                {
                    // do nothing job really
                }
                else
                {
                    global.renderAlert(data.msg, 'alert-danger');
                }
            }, 'json');
        }

        // console.log("Photo URL: " + response.data.url);
        return url;
    });
}

fb.unlink = function (b, user)
{
    if (confirm("Are you sure you wish to unlink your Facebook account?"))
    {
        $(b).attr('disabled', 'disabled');

        $.post("/user/fbunlink", { user:user, karateToken:global.CSRF_hash }, function(data){
            if (data.status == 'SUCCESS')
            {
                window.location = '/users/edit/' + user + '/2?site-success=' + escape(data.msg);
                return true;
            }
            else
            {
                global.renderAlert(data.msg, 'alert-danger');
                $(b).removeAttr('disabled');
                return false;
            }
        }, 'json');
    }
}

fb.syncPhoto = function (b)
{

    $(b).attr('disabled', 'disabled');
    $(b).find('i').first().addClass('fa-spin');
    
    FB.api('/me/picture?type=normal', function (r){
        if (r.data.is_silhouette == true)
        {

            global.renderAlert("You have not uploaded a picture on the associated Facebook profile!");
            $(b).removeAttr('disabled');
        }
        else
        {
            // console.log(JSON.stringify(r));

            $.post("/profile/savefbphoto", { url:r.data.url, karateToken:global.CSRF_hash }, function(data){
                if (data.status == 'SUCCESS')
                {
                    global.renderAlert(data.msg, 'alert-success');
                    $(b).find('i').first().removeClass('fa-spin');
                    $(b).removeAttr('disabled');
                    return true;
                }
                else if (data.status == 'ALERT')
                {
                    global.renderAlert(data.msg);
                    $(b).find('i').first().removeClass('fa-spin');
                    $(b).removeAttr('disabled');
                    return false;
                }
                else
                {
                    global.renderAlert(data.msg, 'alert-danger');
                    $(b).find('i').first().removeClass('fa-spin');
                    $(b).removeAttr('disabled');
                    return false;
                }
            }, 'json');

        }
    });

}
