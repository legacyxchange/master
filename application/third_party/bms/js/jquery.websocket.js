

;(function($){
	
	var defaults = 
	{
		userid: 0,
		debug: false,
		connection:
			{
				url: '',
				port: 80,
				autoConnect: true
			}
	};
	
	function websock (el, options)
	{
		this.options = $.extend(true, {}, defaults, options);
		this.$el = $(el);
		
		var $this = this;
		
		
		if (this.options.userid == 0) throw new Error("User ID is empty!");
		
		if (this.options.connection.autoConnect) this.connect();
		
		return this;
	}
	
	var fn = websock.prototype;
	
	
	fn.connect = function ()
	{
	
	
		var o = this.options;
		var this_ = this;
	
	
				
		this_.ws = $.gracefulWebSocket("ws://" + o.connection.url + ':' + o.connection.port);
		
		//this_.ws.onopen = this_.onopenConn;
		this_.ws.onopen = function (e)
		{
			
	
			return true;
		};
		
		this_.ws.onmessage = function (e)
		{
			var d = e.data;
					
			d = jQuery.parseJSON(d);
	
			if (d.resourceId !== undefined) this.resourceId = d.resourceId;
	
			$(window).trigger('chat.onmessage', d);
	
			return d;
		};
			



		
		return true;
	}
	

	
	fn.sendMsg = function (to, msg)
	{
		if (to == undefined) throw new Error("To is empty!");
	
		var data = { to: to, from:this.options.userid, msg: msg };
		
		//console.log(data);
		
		this.ws.send(JSON.stringify(data));
		
		return data;
	}
	
	/*
	fn.onmessage = function (e)
	{
		var d = e.data;
				
		d = jQuery.parseJSON(d);

		if (d.resourceId !== undefined) this.resourceId = d.resourceId;

		$(window).trigger('chat.onmessage', d);

		return d;
	}
	*/
	// jquery adapter
	$.fn.websock = function (options)
	{
		return this.each(function(){
			if (!$(this).data('websock'))
			{
				$(this).data('websock', new websock(this, options));
			}
		});
	};
	
	
	$.websock = fn;

})(jQuery);