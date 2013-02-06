/**
 * Clicktraq
 * A simple open source click heatmaping tool
 *
 * @author Carl Saggs
 * @license MIT
 */
(function(){

	//if(typeof clicktraq_settings == 'undefined') return;

	// timer
	var timer_start = new Date().getTime();
	// payload (encoded version of profile, ready to send at any moment)
	var payload = '';
	// profile. Acceible version of data.
	var profile = {
		"webpage": window.location.protocol+'//'+window.location.host+window.location.pathname+(window.location.search ? window.location.search : ""),
		"user_agent": navigator.userAgent,
		"platform": navigator.platform,
		"screen_resolution": screen.width+"x"+screen.height,
		//"tag": clicktraq_settings.tag,
		"total_clicks": 0,
		"visit_duration": 0,
		"clicks": []
	}
	// Create xmlHttpRequest object.
	try {var xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP");}  catch (e) { }

	// Add base.js methods
	var base = {};
	// Add an event listener
	base.addEventListener = function(obj, event, callback){
		if(window.addEventListener){
				//Browsers that don't suck
				obj.addEventListener(event, callback, false);
		}else{
				//IE8/7
				obj.attachEvent('on'+event, callback);
		}
	}
	// get real x/y of click
	base.get_real_position = function(x,y){
		return {
			"x": x + (window.scrollX || document.body.scrollLeft ||  document.body.parentNode.scrollLeft || 0),
			"y": y + (window.scrollY ||  document.body.scrollTop ||  document.body.parentNode.scrollTop || 0)
		}
	}

	// Onclick, update profile & set payloads
	base.addEventListener(document, "click", function(event){
		var p = base.get_real_position(event.pageX, event.pageY);
		var time = get_current_duration();
		// Update profile
		profile.clicks.push({
			"time": time,
			"x": p.x,
			"y": p.y
		});
		profile.total_clicks++;
		profile.visit_duration = time;

		// Store to payload.
		payload = JSON.stringify(profile);

	}, false);

	base.addEventListener(window, "beforeunload", function(){
		// User is closing page, send data to server 
		// This needs to be fast, else the window will close before the information gets sent.
		send_data("/traq/traq/clicktraq.php", payload);
	}, false);

	// Get duration time
	function get_current_duration(){
		return (new Date().getTime())-timer_start;
	}
	//Send
	function send_data(location, data){
		xmlhttp.open("POST", location, false);
		xmlhttp.send(data);
	}


})();


