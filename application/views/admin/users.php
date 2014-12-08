<!--container start-->
        <div class="container">
        <?php if($this->session->flashdata('SUCCESS')): ?>
        <div class='row'>
        <h3 class="alert alert-success"><?php echo $this->session->flashdata('SUCCESS'); ?></h3>
        </div>
        <?php elseif($this->session->flashdata('FAILURE')): ?>
        <div class='row'>
        <h3 class="alert alert-danger"><?php echo $this->session->flashdata('FAILURE'); ?></h3>
        </div>
        <?php elseif($this->session->flashdata('NOTICE')): ?>
        <div class='row'>
        <h3 class="alert alert-notice"><?php echo $this->session->flashdata('NOTICE'); ?></h3>
        </div>
        <?php endif; ?> 
        <div class="add_new_butt">
			<a href="#" class="big-link" data-reveal-id="myModa2"><span class="add_new_plus">+</span> add new</a>
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
                        <td class="rec-text"><?php echo $user->id;?></td>
                        <td class="rec-text"><?php echo $user->firstName;?></td>
                        <td class="rec-text"><?php echo $user->lastName;?></td>
                        <td class="rec-text"><?php echo $user->email;?></td>
                        <td class="rec-text"><img src="/user/profileimg/100/<?php echo $user->id;?>/<?php echo $user->profileimg;?>" /></td>
                        <td valign="middle" align="right" class="icon">                                            
						<a href="#" id="<?=$user->id;?>" class="big-link edit_button" data-reveal-id="myModa2"><img src="/public/images/edit-admin.png" /> </a> 
						<a href="/administrator/users/delete/<?php echo $user->id;?>" onclick="return confirm('Are you sure you want to delete this user?');"><img src="/public/images/delete.png" /> </a> 
						</td>
                    </tr>                                       
                <?php endforeach;?> 
                </table>              
                <?php else: ?>
                <h3 class="alert alert-warning">There are no users.</h3>
                <?php endif; ?>
            </div>
        </div>
     <!--container end--> 
     
	 <div id="myModa2" class="reveal-modal medium">
         <?php echo $users_form;?>
     </div>    
         