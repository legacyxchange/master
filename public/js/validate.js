var validate = {}

$(document).ready(function(e){ 
	$('#userform').submit(function(e){
		e.preventDefault();
		validate.checkForm();
	});
	
});

validate.notEmpty = function(obj){ console.log('notempty')
	if($(obj).val().length < 1)
        validate.setError($(obj), 'Please Enter a Valid Amount.');
	else
		validate.resetError($(obj));
}
validate.setError = function(id, msg){	
    $(id).focus();
    $(id).css('background', 'rgb(252, 252, 170)');
    $(id).css('color', '#000');
    $(id).next().html(msg);
    $(id).next().show();
    return false;
}

validate.resetError = function(id){
	$(id).css('background', 'white');
	$(id).css('color', '#555');
    $(id).next().html('');
    $(id).next().hide();
    //validate.checkRegisterForm();
}
validate.checkFirstName = function(obj){
	if($(obj).val().length < 3)
        validate.setError($(obj), 'First Name must be at least 3 characters.');
	else
		validate.resetError($(obj));
}
validate.checkLastName = function(obj){
	if($(obj).val().length < 3)
        validate.setError($(obj), 'Last Name must be at least 3 characters.');
	else
		validate.resetError($(obj));
} 
validate.checkUsername = function(obj){	
	if($(obj).val().length < 6)
        validate.setError($(obj), 'Username must be at least 6 characters.');
	else
		validate.resetError($(obj));
}
validate.checkAddress = function(obj){
	if($(obj).val().length < 3)
        validate.setError($(obj), 'Please provide a valid address.');
	else
		validate.resetError($(obj));
}
validate.checkEmail = function(obj){	
	if($(obj).val().length < 4)
        validate.setError($(obj), 'Please provide a valid email address.');
	else if($(obj).val().length >= 4){
		$.post("/welcome/checkEmail", $('#signupform').serialize(), function (data) { console.log(data)
	    	if (data.status == 'FAILURE')
	        { 
	            validate.setError($('#'+data.id), data.msg);
	        }
	    	else if (data.status == 'SUCCESS'){  
	    		validate.resetError($(obj));
	    	}
	    }, 'json');
	}
	else
		validate.resetError($(obj));
}
validate.checkPassword = function(obj){
	if($(obj).val().length < 4)
        validate.setError($(obj), 'Password must be at least 4 characters.');
	else
		validate.resetError($(obj));
}
validate.checkPasswordConfirm = function(obj){
	if($(obj).val().length < 4)
        validate.setError($(obj), 'Password Confirmation must be at least 4 characters.');
	else if($(obj).val() != $('#passwd').val()){
		validate.setError($(obj), 'Passwords donot match.');
	}
	else
		validate.resetError($(obj));
}
validate.checkForm = function ()
{  
	validate.checkFirstName($('#firstName'));
	
	validate.checkLastName($('#lastName'));
	
	validate.checkUsername($('#username'));
	
    validate.checkEmail($('#email')); 
    
	validate.checkPassword($('#passwd'));
	
	validate.checkPasswordConfirm($('#passwd_confirm'));
	
	$formData = $('#userform').serialize();
	
	var count = 0;
	$.each( $('.alert-danger'), function( key, value ) {
		//console.log(value)
		if($(value).html() != ''){ 
			count++;
		}		  
	});
	
	if(count < 1){ 
		$.post("/admin/settings/save", $formData, function (data) { console.log(data)
    	
			if (data.status == 'SUCCESS')
			{   
				location.href = '/admin/settings';
			}
        	else if (data.status == 'FAILURE')
        	{
        		//location.href = '/admin/settings';           	
        	}       	
    	}, 'html');
    }
}

validate.originalPasscode = function(obj){
	console.log($(obj).val().length)
	if($(obj).val().length < 4)
        validate.setError($(obj), 'Passcode must be atleast 4 characters.');
	else if($(obj).val().length >= 4){
		validate.resetError($(obj));
		$.get("/admin/products/checkoriginalpasscode/"+$('#original_passcode').val(), null, function (data) { console.log(data)
	    	if (data.status == 'FAILURE')
	        { 
	    		validate.setError($(obj), data.message);
	        }
	    	else if (data.status == 'SUCCESS'){  
	    		validate.resetError($(obj));
	    	}
	    }, 'html');
	}
	else
		validate.resetError($(obj));
}
validate.legacyNumber = function(obj){
	console.log($(obj).val().length)
	if($(obj).val().length < 4)
        validate.setError($(obj), 'Legacy Number must be atleast 4 characters.');
	else if($(obj).val().length >= 4){
		validate.resetError($(obj));
		$.get("/admin/products/checklegacynumber/"+$('#legacy_number').val(), null, function (data) { console.log(data)
	    	if (data.status == 'FAILURE')
	        { 
	    		validate.setError($(obj), data.message);
	        }
	    	else if (data.status == 'SUCCESS'){  
	    		validate.resetError($(obj));
	    	}
	    }, 'html');
	}
	else
		validate.resetError($(obj));
}