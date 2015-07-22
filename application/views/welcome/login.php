<script>
$(document).ready(function(){
	$('#signup-modal').modal('show');

	setTimeout(function(){		
		$('input[name=user_email]').focus();
	}, 1000);
});
</script>