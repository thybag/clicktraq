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
		"webpage": window.location.href.replace(window.location.hash,''),
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

	// Onclick, update profile & set payloads
	document.addEventListener("click", function(e){

		var p = get_real_position(e.x,e.y);
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

	window.addEventListener("beforeunload", function(){
		// User is closing page, send data to server 
		// This needs to be fast, else the window will close before the information gets sent.
		send_data("/traq/traq/clicktraq.php", payload);
	}, false);

	// get real x/y of click
	function get_real_position(x,y){
		return {
			"x": x + (window.scrollX || document.body.scrollLeft ||  document.body.parentNode.scrollLeft || 0),
			"y": y + (window.scrollY ||  document.body.scrollTop ||  document.body.parentNode.scrollTop || 0)
		}
	}
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


