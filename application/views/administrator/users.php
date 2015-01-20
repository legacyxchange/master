<!--container start-->
<div class="container">
	<div class="add_new_butt">
    	<a href="#" class="users-big-link"  data-toggle="modal" data-target="#usersModal"><span class="add_new_plus">+</span> add new</a>
	</div>
	<div class="war">
        <h2>USERS</h2>                   
        <table class="table table-condensed">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Profile Image</th>
                <th>&nbsp;</th>
            </tr>                        
            <?php if($users):?>
        	<?php foreach($users as $user):?>                                            
            <tr>
                <td class="rec-text"><?php echo $user->user_id;?></td>
                <td class="rec-text"><?php echo $user->firstName;?></td>
                <td class="rec-text"><?php echo $user->lastName;?></td>
                <td class="rec-text"><?php echo $user->email;?></td>
                <td class="rec-text"><img src="/user/profileimg/100/<?php echo $user->user_id;?>/<?php echo $user->profileimg;?>" /></td>
                <td valign="middle" align="right" class="icon">                                            
			        <a href="#" id="<?=$user->user_id;?>" class="edit_button" data-toggle="modal" data-target="#usersModal"><img src="/public/images/edit-admin.png" /></a> 
					<a class="delete_button" data-toggle="modal" data-target="#modalConfirm" href="/administrator/users/delete/<?php echo $user->user_id;?>"><img src="/public/images/delete.png" /> </a> 
				</td>
            </tr>                                       
            <?php endforeach;?> 
        </table>
        <div class="pagination">
            <?php echo $this->pagination->create_links(); ?>
        </div>              
        <?php else: ?>
        	<h3 class="alert alert-warning">There are no users.</h3>
        <?php endif; ?>
    </div>
</div>
<!--container end--> 
<div id="usersModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="usersModal" aria-hidden="true"> 
         <div class="modal-dialog">
            <div class="modal-header" style="text-align: right;">
                <button type="button" data-dismiss="modal">&times;</button>           
        	</div> <!-- modal-header -->         
        	<div class="modal-content">
            
        	</div><!-- /.modal-content -->
     	</div>    
     </div>    
     
     <div id="modalConfirm" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="modalConfirm" aria-hidden="true">
        <div class="modal-dialog" style="background: #fff;">
     		<div class="modal-header" style="text-align: right;">
                <button type="button" data-dismiss="modal">&times;</button>           
        	</div> <!-- modal-header -->       
         	<div class="content" style="background: #fff;">                      
            	<h4>Are you sure you want to delete this listing?</h4>
            	<a id="confirm_yes" class="btn btn-default" style="font-size: 14px; font-weight: normal; position:relative; top:0; left:0;color:#fff;padding:13px;" data-dismiss="modal" aria-hidden="true">Yes</a>  <a class="btn btn-default close-reveal-modal" style="font-size: 14px; font-weight: normal; position:relative; top:0; left:0;color:#fff;padding:13px;" data-dismiss="modal" aria-hidden="true" id="confirm_no">No</a>           
            	<div class="modal-footer">
                	<div class='row'>             	    
                    	<div class='col-xs-3 col-sm-6'>
                        	<!-- <button type="button" class="btn btn-red" id='submitSignupBtn'>SAVE</button> -->
                    	</div>
                	</div>
            	</div> <!-- modal-footer -->
        	</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>    