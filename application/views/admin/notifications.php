<div class="animate-panel">
    <div class="content">
       <div class="row">
            <button type="button" style="max-width:300px;margin-left:30px;text-align:center;" id="quick-compose" class="btn btn-danger light btn-block compose-btn">Quick Compose</button>
            <div class="col-md-3 animated-panel zoomIn" style="animation-delay: 0.8s;">
                <div class="hpanel">
                    <div class="panel-body">
                        
                        <ul class="mailbox-list">
                            <li<?php echo $active_menu == 'inbox' ? " class='active' " : null;?>>
                                <a href="/ecommerce/notifications">
                                    <span class="pull-right"><?php echo $counted_inbox_notifications;?></span>
                                    <i class="fa fa-envelope"></i> Inbox
                                </a>
                            </li>
                            <li<?php echo $active_menu == 'sent' ? " class='active' " : null;?>>
                                <span class="pull-right"><?php echo $counted_sent_notifications;?></span>
                                <a href="/ecommerce/notifications/sent">
                                	<i class="fa fa-paper-plane"></i> Sent
                                </a>
                            </li>
                            <li<?php echo $active_menu == 'draft' ? " class='active' " : null;?>>
                            	<span class="pull-right"><?php echo $counted_draft_notifications;?></span>
                                <a href="/ecommerce/notifications/draft">
                                	<i class="fa fa-pencil"></i> Draft
                                </a>
                            </li>
                            <li<?php echo $active_menu == 'trash' ? " class='active' " : null;?>>
                            	<span class="pull-right"><?php echo $counted_trash_notifications;?></span>
                                <a href="/ecommerce/notifications/trash">
                                	<i class="fa fa-trash"></i> Trash
                                </a>
                            </li>
                        </ul>
                        <hr>
                        <ul class="mailbox-list">
                            <li>
                                <a href="#"><i class="fa fa-plane text-danger"></i> Travel</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart text-warning"></i> Finance</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-users text-info"></i> Social</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tag text-success"></i> Promos</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-flag text-primary"></i> Updates</a>
                            </li>
                        </ul>
                        <hr>
                        <ul class="mailbox-list">
                            <li>
                                <a href="#"><i class="fa fa-gears"></i> Settings</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-info-circle"></i> Support</a>
                            </li>
                        </ul>


                    </div>

                </div>
            </div>
            <script>
            $(document).ready(function() {
                $('#checkall').click(function(e){
                    e.preventDefault();
                	$('.checkbox1').each(function(){
                    	if(!this.checked){
                        	this.checked = true;
                    	}else{                        	
                    		this.checked = ""; 
                    	}
                	}); 
                });             
            });
            </script>
            
            <div class="col-md-9 animated-panel zoomIn" style="animation-delay: 1.0s;">
                <div class="hpanel">
                    <div class="panel-heading hbuilt">
                        <div class="text-center p-xs font-normal">
                            <div class="input-group">
                            	<input type="text" class="form-control input-sm" placeholder="Search email in your inbox..."> 
                            	<span class="input-group-btn"> 
                            		<button type="button" class="btn btn-sm btn-default">
                            			Search
                            		</button> 
                            	</span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 m-b-md animated-panel zoomIn" style="animation-delay: 0.2s;">
                                <div class="btn-group">
                                    <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
                                    <a href="" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
                                    <a href="" class="btn btn-default btn-sm"><i class="fa fa-exclamation"></i></a>
                                    <a href="/admin/notification/trash" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></a>
                                    <a class="btn btn-default btn-sm"><i class="fa fa-check" id="checkall"></i></a>
                                    <a href="" class="btn btn-default btn-sm"><i class="fa fa-tag"></i></a>
                                </div>
                            </div>
                            <div class="col-md-6 mailbox-pagination m-b-md animated-panel zoomIn" style="animation-delay: 0.3s;">
                                <div class="btn-group">
                                    <button class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i></button>
                                    <button class="btn btn-default btn-sm"><i class="fa fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-mailbox">
                                <tbody>
                                <?php foreach($notifications as $n):?>
                                <tr class="unread">
                                    <td class="">
                                        <div class="checkbox checkbox-single checkbox-success">
                                            <input class="checkbox1" type="checkbox">
                                            <label></label>
                                        </div>
                                    </td>
                                    <td><a href="#"><?php echo $n->to_user->firstName;?></a></td>
                                    <td><a href="#"><?php echo $n->notification;?></a>
                                    </td>
                                    <td>
                                    <?php if($n->attachment)?>
                                    	<i class="fa fa-paperclip"></i>
                                    </td>
                                    <td class="text-right mail-date"><?php echo date('Y-m-d', strtotime($n->created));?></td>
                                </tr>
                                <?php endforeach;?>                        
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                    <?php $c = 'counted_'.$active_menu.'_notifications';?>
                        <i class="fa fa-eye"> </i> <?php echo ucfirst($active_menu).' Messages '.$$c;?>
                    </div>
                </div>
            </div>
        </div>

    </div>  
    </div>
  <link href="http://admindesigns.com/demos/absolute/1.1/vendor/plugins/summernote/summernote.css" rel="stylesheet"></link>
  <link rel="stylesheet" type="text/css" href="http://admindesigns.com/demos/absolute/1.1/vendor/plugins/summernote/summernote.css">
  <link rel="stylesheet" type="text/css" href="http://admindesigns.com/demos/absolute/1.1/assets/admin-tools/admin-forms/css/admin-forms.css">
  <link rel="stylesheet" type="text/css" href="http://admindesigns.com/demos/absolute/1.1/vendor/plugins/summernote/summernote.css">
  
<!-- Admin Dock Quick Compose Message -->
  <div class="quick-compose-form">
    <form id="">
      <input type="email" class="form-control" id="inputEmail" placeholder="Email">
      <input type="text" class="form-control" id="inputSubject" placeholder="Subject">
      <div class="summernote-quick">Compose your message here...</div>
    </form>
  </div>

  <style>
  /* PNotify Demo Style - Alert Position */
  .ui-pnotify.stack_bottom_right {
    bottom: 0;
    right: 20px;
  }
  </style>

  <!-- BEGIN: PAGE SCRIPTS -->

  <!-- jQuery -->
  <script src="vendor/jquery/jquery-1.11.1.min.js"></script>
  <script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>

  <!-- Summernote Plugin -->
  <script src="vendor/plugins/summernote/summernote.min.js"></script>

  <!-- PNotify -->
  <script src="vendor/plugins/pnotify/pnotify.js"></script>

  <!-- Theme Javascript -->
  <script src="assets/js/utility/utility.js"></script>
  <script src="assets/js/demo/demo.js"></script>
  <script src="assets/js/main.js"></script>
  <script type="text/javascript">
  jQuery(document).ready(function() {

    "use strict";

    // Init Theme Core    
    Core.init();

    // Init Demo JS    
    Demo.init();

    var msgListing = $('#message-table > tbody > tr > td');
    var msgCheckbox = $('#message-table > tbody > tr input[type=checkbox]');

    // on message table checkbox click, toggle highlighted class
    msgCheckbox.on('click', function() {
      $(this).parents('tr').toggleClass('highlight');
    });

    // on message table row click, redirect page. Unless target was a checkbox
    msgListing.not(":first-child").on('click', function(e) {

      // stop event bubble if clicked item is not a checkbox
      e.stopPropagation();
      e.preventDefault();

      // Redirect to message compose page if clicked item is not a checkbox
      window.location = "pages_compose.html";
    });

    // On button click display quick compose message form
    $('#quick-compose').on('click', function() {

      // Admin Dock Plugin
      $('.quick-compose-form').dockmodal({
        minimizedWidth: 260,
        width: 470,
        height: 480,
        title: 'Compose Message',
        initialState: "docked",
        buttons: [{
          html: "Send",
          buttonClass: "btn btn-primary btn-sm",
          click: function(e, dialog) {
            // do something when the button is clicked
            dialog.dockmodal("close");

            // after dialog closes fire a success notification
            setTimeout(function() {
              msgCallback();
            }, 600);
          }
        }]
      });
    });

    // A "stack" controls the direction and position
    // of a notification. Here we create an array w
    // with several custom stacks that we use later
    var Stacks = {
      stack_bottom_right: {
        "dir1": "left",
        "dir2": "up",
        "push": "top",
        "spacing1": 10,
        "spacing2": 10
      },
    }

    // example email compose success notification
    function msgCallback() {
      (new PNotify({
        title: 'Message Success!',
        text: 'Your message has been <b>Sent.</b>',
        type: 'success',
        addclass: 'stack_bottom_right',
        stack: Stacks['stack_bottom_right'],
        delay: 2500,
        opacity: 0.9,
      }));
    };
    // Init Summernote
    $('.summernote-quick').summernote({
      height: 275, //set editable area's height
      focus: false, //set focus editable area after Initialize summernote
      toolbar: [
        ['style', ['bold', 'italic', 'underline', ]],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
      ]
    });

  });
  </script>
  <!-- END: PAGE SCRIPTS -->
