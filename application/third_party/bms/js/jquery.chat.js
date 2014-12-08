/*
var chat = {}


chat.checkWrapper = function ()
{
	if (!$('#chat-wrapper').exists())
	{
		var wrapperHtml = "<div id='chat-wrapper'></div>";
		$('body').prepend(wrapperHtml);
	}
}
*/

;(function($){
	//'use strict';
	
	var defaults = 
	{
		userid: 0, // user ID of user sending the messages
		debug: false,
		velocity: true,
		namespace: 'user',
		CSRF:{
			enabled: false,
			key: '',
			val: '',
			expires: 3600000 // 1 hour
		}
	};

	//var users = [];
	
	//var chatCnt = 0;
	
	
	function chat (el, options)
	{
		this.options = $.extend(true, {}, defaults, options);
		this.$el = $(el);
		
		var this_ = this;
		
		// checks if the velocity plugin is enabled
		var vel = (jQuery().velocity) ? true : false;
		
		
		this.getUsersName(this.options.userid, function (usersname){
			this_.myname = usersname;
		});
	
		if (!vel)
		{
			options.velocity = false;	
		}
		
		this.nodes = []
		
		//this.socket = $.gracefulWebSocket("ws://wdev.karate.com:8080");
		
		this.socket = $(this).websock({
			userid: this_.options.userid,
			debug: this_.options.debug,
			connection:
			{
				url: "greenstandardtechnologies.com",
				port: 8080
			}
		}).data('websock');
		
		
		$(window).on('chat.onmessage', function (e, d){
			//console.log(d);
			if (d !== undefined)
			{
				if (d.resourceId !== undefined) this_.resourceId = d.resourceId;
			}
			
			if (d.from !== undefined && d.from > 0)
			{
			
				var fromUser = false;
				
				if (d.type !== undefined)
				{
					if (d.type == 'ping') fromUser = true;
				}
			
				var f = (fromUser == true) ? d.to : d.from;
			
				var $node = this_.getUsersChatNode(f);

			
				if ($node == undefined)
				{
					this_.getUsersName(f, function(usersname){
					
						$node = this_.startChatting(f, usersname);
						
						this_.addChatLine($node, usersname, d.msg, fromUser);
					});					
				}
				else
				{
					var name = $node.data('name');
					
					this_.addChatLine($node, name, d.msg, fromUser);
				} 

			
				
			}
			

		});


		this.minimized = false;
		this.debug = options.debug;
		this.velocity = options.velocity;
		

		
		//if (this.debug) console.log("Velocity Plugin Enabled: " + this.velocity);
		
		//users.push(userid);
		
		
	
		this.checkWrapper();
	
		

		
		// sets initial position
		//this.setPosition();
		
		//this.setChatSession();

		// gets CSRF token if enabled
		if (this.options.CSRF.enabled) this.getCSRFToken();
		

		
		
		
		//this.scrollToBottom();
		
		/*
		this.node.draggable({ 
			handle: '.chat-header',
			scroll: true,
			containment: this.container
			});
		*/
		//console.log('NODE H: ' + nodeH);
		//this.node.css('top', windowHeight - nodeH);
		//this.node.css('position', 'absolute');
		
		// gets original placement of node
		
		//this.orgPos = $node.position();
	
		//console.log(JSON.stringify(orgPos));
	
		
		return this;
	
	}
	
	chat.nodes = [];
	
	var fn = chat.prototype;
	
	
	fn.createWindow = function ()
	{
		//var $container = $("<div>", {id: "temp-container", class:'container'});
		var html = $('#chat-html').find('.chat-container').html();
		
		
		var $node = $("<div>", { class:'chat-container' });

		$node.append(html);
				
	//	var node = $(html);
	
		//var $node = $(node);
		
		$node.css('opacity', 0);
		
		$('#chat-wrapper').append($node);
		
		$node.data('minimized', false); // minimized flag is set to false
					
		this.setPosition($node);
		
		$node.find('.chat-body').slimScroll({
			height:250
		});
		
		//this.showNodes($node);
		
		this.bindEvents($node);
		
		
				
		return $node;
	}
	
	fn.getUsersName = function (userid, successCB)
	{
		var name;
		var this_ = this;
	
		$.getJSON('/' + this_.options.namespace + '/getusersname/' + userid, function(data){
			if (data.status == 'SUCCESS')
			{
				if (successCB !== undefined && typeof successCB == 'function') successCB(data.msg)
			}
		});
		
		return true;
	}

	fn.showNodes = function ($nodes)
	{
		if ($nodes == undefined) this.error ("Node is not defined!");
		var this_ = this;
		
		$nodes.each(function(index, n){
			if (this_.velocity)
			{
				$(n).velocity('fadeIn', { duration: 200 });
			}
			else
			{
				$(n).css('opacity', 1);
			}
		});

	}

	fn.bindEvents = function ($nodes)
	{
		if ($nodes == undefined) this.error("Node is undefined!");
				
		//var $node = $(this.node);
		var options = this.options;
		var this_ = this;
		
		$nodes.each(function(index, n){
			var $n = $(n);		
		
			// binds close button
			$(n).find('button.close:nth-child(1)').click(function(e){
				
				this_.close($n);
			});
			
			$(n).find('button.close:nth-child(2)').click(function(e){
		
				if (options.debug) console.log('Reset bind has been triggered');
		
				this_.resetOrgPos();
			});
		
			$(n).find('button.close:nth-child(3)').click(function(e){
				this_.minimize($n);
			});
			
			$(n).find('#msg').focus(function(){
				
				var $m = $(this);
				
				$(this).unbind('keypress');
				
				$(this).bind('keypress', function(e){

					
					var code = e.keyCode || e.which;
					
					if (code == 13 && !e.shiftKey)
					{
							
						e.preventDefault();
					
						if ($m.val().trim() !== '') this_.sendMsg($n);
					}
				});
			});
		});
			
		
	}

	fn.checkWrapper = function ()
	{
		if ($('#chat-wrapper').length <= 0)
		{
			var h = $(window).height() - 51;
			var w = $(window).outerWidth();
		
			var $wrapper = $("<div id='chat-wrapper'></div>")
			.attr('id', 'chat-wrapper')
			.css('position', 'fixed')
			.css('bottom', 0)
			.css('width', '100%')
			.css('z-index', 9999)
			.css('overflow', 'visible');
			
			this.$el.prepend($wrapper);
			
			return $wrapper;
		}
		
		return true;
	}
	
	fn.error = function (msg)
	{
		var errorMsg = arguments.callee.caller + ' '+ msg;
		
		$.log(errorMsg);
	}
	
	// run to set session variable
	fn.setChatSession = function (userid)
	{
		if (userid == undefined) this.error("User ID is not defined!");
		
		var namespace = this.options.namespace;
				
		var this_ = this;
		
		$.getJSON('/' + namespace + '/set_chat_user_session/' + userid, function(data){
			
		});
		
		return true;
	}
	
	fn.endChat = function (userid)
	{
		if (userid == undefined) this.error("User ID is not defined!");
		
		var namespace = this.options.namespace;
		var this_ = this;
				
		$.getJSON('/' + namespace + '/end_chat_session/'	+ userid, function(data){
			
		});
		
		return true;
	}
	
	fn.startChatting = function (userid, name)
	{
		this.setChatSession(userid);
		
		var $node = this.createWindow();
		
		$node.data('userid', userid);
		$node.data('name', name);
		
		$node.find('#msg').focus();
		
		this.setName($node, name);
		
		this.nodes.push($node);
		
		this.showNodes($node);
		
		return $node;
	}
	
	fn.setName = function ($node, name)
	{
		$node.find('.chat-header span').html(name);
			
		return true;
	}
	
	// fetches a new key
	fn.getCSRFToken = function ()
	{
		var csrf = this.options.CSRF;
		var namespace = this.options.namespace;
		var this_ = this;
		
		if (csrf.enabled)
		{
			$.getJSON('/' + namespace + '/get_csrf_token', function(data){
				if (data.status == 'SUCCESS')
				{
					var token = data.msg;
					
					csrf.val = token;
					
					// gets a new key before it expires
					setTimeout(function(){
					
						this_.getCSRFToken();
						
					}, csrf.expires);
					
					return token;
				}
			});
		}
		else
		{
			return true;
		}
		
		return false;
	}
	
	fn.sendMsg = function ($node)
	{
		if ($node == undefined) this.error("Node is undefined!")
		
		var msg = $node.find('#msg').val();
		var namespace = this.options.namespace;
		
		
		var postData = { msg: msg, userid: $node.data('userid') };
		

		this.socket.sendMsg($node.data('userid'), msg);
		
		msg = msg.nl2br();		
		
		this.addChatLine($node, this.myname, msg, true);
		

		

		
		
		$node.find('#msg').val('');
		/*	
		postData = this.addCSRFToken(postData);
	
		$.post('/' + namespace + '/read_chat_stream', postData, function(data){
			global.log(data);	
		});
		*/
	}
	
	fn.refresh = function ($nodes)
	{
		var this_ = this;
		var namespace = this.options.namespace;
			
		var updates = [];
		
		// gets all the userIDs from each chat window
		$nodes.each(function(index, n){
			var $n = $(n);
			
			var userid = $n.data('userid');
			
			updates.push(userid);

		});
		
		var postData = { users: updates };
		
		postData = this.addCSRFToken(postData);
					
		$.post('/' + namespace + '/get_chat_content', postData, function(data){

			$nodes.each(function(index, n){
				var $n = $(n);
				
				this_.updateDisplay($n, data);
			});
			
		});
		
	}
	
	fn.updateDisplay = function ($node, html)
	{
		$node.find('.chat-body').html(html);
		
		return true;
	}
	
	fn.addCSRFToken = function (dataObj)
	{
		
		if (this.options.CSRF.enabled)
		{
			if (dataObj == undefined) dataObj = {};
			
			var key = this.options.CSRF.key;
			var val = this.options.CSRF.val;
			
			dataObj[key] = val;
			
		}
		
		return dataObj;
	}
	
	fn.setPosition = function ($nodes)
	{
		if ($nodes == undefined) this.error("Node is undefined!");
		
		var cnt = this.nodes.length;
		
		$nodes.each(function(index, n){
	
			var w = $(n).outerWidth();
	
			var pos = 15;
			
			if (cnt > 0) var pos = ((w + 15) * cnt) + 15;
	
	
			$(n).css('right', pos + 'px');
		})
	
	}
	
	fn.close = function ($nodes)
	{
		if ($nodes == undefined) this.error("Node is undefined!");

		var this_ = this;
		
		$nodes.each(function(index, n){
			
			var $n = $(n);
			
			var userid = $n.data('userid');
			
			if (this_.velocity)
			{
		
				$n.velocity('fadeOut', {
					duration:100,
					complete: function()
					{
						$n.remove();
	
						this_.endChat(userid);
					}
				});
			}
			else
			{
				$n.css('opacity', 0).remove();
	
				this.endChat(userid);
			}	
						
		});


		return true;
	}
	
	
	fn.resetOrgPos = function()
	{
		var t = this.orgPos.top;
	
		//if (this.minimized) t = this.orgPos.top + 320;
	
		if (this.velocity) $(this.node).velocity({ top: t, left:this.orgPos.left });
		else
		{
			$(this.node).css('top', t).css('left', this.orgPos.left);
		}
		
		//if (this.minimized) this.maximize();
	}
	
	
	fn.minimize = function ($nodes)
	{
		if ($nodes == undefined) this.error("Node is undefined!");
			
		var this_ = this;
		
		$nodes.each(function(index, n){
			var $n = $(n);
			
			var currentPos = $(n).position();
		
			if (this_.debug) console.log(JSON.stringify(currentPos));
		
			$n.find('.chat-min-container').velocity("slideUp", {
				complete:function(){
					$n.css('height', 30);
				}
			});
			
			
			var ch = currentPos.top + $n.find('.chat-min-container').height();
			
			if (this_.velocity) $(n).velocity({ top: ch });
			else $n.css('top', ch);
			
			
			$n.data('minimized', true);
			//this.minimized = true;
			
			$n.find('button.close:nth-child(3)').unbind('click').html('&plus;').click(function(e){
				this_.maximize($n);
			});
		});

		return true;
		
	}
	
	fn.addChatLine = function ($node, name, msg, fromUser)
	{
	
		if (fromUser == undefined) fromUser = false;
		
		var nameClass = (fromUser) ? 'chat-line-me' : 'chat-line-from';
	
		var $container = $("<div>", { class:'chat-line-container' });
	
		//var name = $node.data('name', name);
		
		/*
		var html = "<div class='" + nameClass + "'>" + name + "</div>" +
		"<div class='chat-line-msg'>" + msg + "</div>";
		*/
		
		var html = "<div class='" + nameClass + "'>" + msg + "</div>";
			
		$container.append(html);
		
		var $body = $node.find('.chat-body');
		
		//console.log(msg);
		
		$body.append($container);
		
		return true;
	}
	
	fn.maximize = function ($nodes)
	{
		if ($nodes == undefined) this.error("Node is undefined!");
			
		var this_ = this;
		
		$nodes.each(function(index, n){
			var $n = $(n);
			var h = $n.height() - 350;

			var currentPos = $n.position();
		
			var t = currentPos.top - 320;
		
			if (this_.velocity) $n.velocity({ top: t });
			else $n.css('top', t);
		
			$n.find('.chat-min-container').velocity("slideDown", {
				complete:function(){
					$n.css('height', 350);
				}
			});
			
			$n.data('minimized', false);
			//this.minimized = false;
			
		
			$n.find('button.close:nth-child(3)').unbind('click').html('&dash;').click(function(e){
				this_.minimize();
			});
		});
				

	}
	
	fn.getUsersChatNode = function (userid)
	{
		if (userid == undefined) this.error("User ID is empty!");
		
		var node;
		
		$(this.nodes).each(function(i, n){
			var $n = $(n);
			
			var uid = $n.data('userid');
			//console.log("USERID: " + uid);
			
			if (uid == undefined) return false;
			if (uid == 0) return false;
			
			if (userid == uid)
			{
				node = $n;
				return true;
			}
		});
		
		//console.log("NODE!");
		//console.log(node);
		
		if (node == undefined) return undefined;
		
		return $(node);
		
	}
	
	fn.scrollToBottom = function ()
	{
		if (this.debug) console.log("About to scroll to bottom");
		
		var scrollTo_val = $(this.node).find('.chat-body').prop('scrollHeight') + 'px';
		
		if (this.debug) console.log("Scroll TO Val: " + scrollTo_val);
		
		$(this.node).find('.chat-body').slimScroll({ scrollTo : '100' });
	};
	
	// jquery adapter
	$.fn.chat = function (options)
	{
		return this.each(function(){
			if (!$(this).data('chat'))
			{
				$(this).data('chat', new chat(this, options));
			}
		});
	};
	
	
	$.chat = fn;

})(jQuery);