<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 class="admin-heading">My Store</h2>	
</div>
<!--container start-->
<div class="container content">          
    <div class="admin_add_new_butt">
		<a href="/admin/store/add" class="stores-add-link" data-toggle="modal" data-target="#storeModal"><span class="add_new_plus">+</span> Add New Store</a>
	</div>
    <div>
            	
    </div>
</div>
<!--container end--> 
     
<div id="addStoreModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addStoreModal" aria-hidden="true"> 
    <div class="modal-dialog">
              
        <div class="modal-content">          
        </div>
    </div>    
</div>    
     
<div id="modalConfirm" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="modalConfirm" aria-hidden="true">
	<div class="modal-dialog" style="background: #fff;">
     	<div class="modal-header" style="text-align: right;">
            <button type="button" data-dismiss="modal">&times;</button>           
        </div>     
        <div class="content" style="background: #fff;">                      
            <h4>Are you sure you want to delete this listing?</h4>
            <a id="confirm_yes" class="btn btn-default" style="font-size: 14px; font-weight: normal; position:relative; top:0; left:0;color:#fff;padding:13px;" data-dismiss="modal" aria-hidden="true">Yes</a>  <a class="btn btn-default close-reveal-modal" style="font-size: 14px; font-weight: normal; position:relative; top:0; left:0;color:#fff;padding:13px;" data-dismiss="modal" aria-hidden="true" id="confirm_no">No</a>           
            <div class="modal-footer">
                <div class='row'>             	    
                    <div class='col-xs-3 col-sm-6'>
                        <!-- <button type="button" class="btn btn-red" id='submitSignupBtn'>SAVE</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    