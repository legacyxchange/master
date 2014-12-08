
<div style="border:1px solid #aaa;float:right;clear:left;">
    <?php if($this->session->userdata['user_id']): ?>
    <?php echo form_open('#', array('name' => 'chat_form', 'method' => 'post', 'onsubmit' => 'chat.doAjax(); return false;'));?>
        <input type="hidden" id="user_id" name="user_id" value="<?php echo $this->session->userdata['user_id'];?>" />
        <input type="hidden" id="username" name="username" value="<?php echo $this->session->userdata['username'];?>" />
    	<textarea cols="16" rows="2" id="chat_send" name="chat_send" style="float:left;clear:left;width:187px"></textarea>
    	<button style="float:left;height:46px;" id="submitBtn" onclick="chat.doAjax(); return false;">Send</button>
    <?php echo form_close();?>
    <?php else:?>
    <h4 style="text-align:center;clear:left;width:240px">You must <a href="#" onclick="$('#loginModal').modal('show');setTimeout(function () { $('#user_email').focus(); }, 1000);">login</a> to chat.</h4>
    <?php endif;?>
</div> 

<div id="inner_chat" style="border:3px solid #aaa;border-bottom:0px;overflow-y:scroll;height:200px;width:242px;float:right;clear:right;">

<table class="table table-striped table-condensed">
    
<?php foreach($chat as $c): ?>
<tr>
<td><strong style="color:undefined;"><?php echo $c->username; ?>:</strong> <?php echo $c->message; ?></td>
</tr>
<?php endforeach;?>
    
</table>

</div>