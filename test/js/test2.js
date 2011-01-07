// Cookie Plugin - http://bit.ly/f7ygPt
jQuery.cookie = function(name, value, options) {
	if (typeof value != 'undefined'  ||  (name  &&  typeof name != 'string')) { // name and value given, set cookie
		if (typeof name == 'string') {
			options = options || {};
			if (value === null) {
				value = '';
				options.expires = -1;
			}
			var expires = '';
			if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
				var date;
				if (typeof options.expires == 'number') {
					date = new Date();
					date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
				} else {
					date = options.expires;
				}
				expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
			}
			var path = options.path ? '; path=' + (options.path) : '';
			var domain = options.domain ? '; domain=' + (options.domain) : '';
			var secure = options.secure ? '; secure' : '';
			document.cookie = name + '=' + encodeURIComponent(value) + expires + path + domain + secure;
		} else { // `name` is really an object of multiple cookies to be set.
			for (var n in name) { jQuery.cookie(n, name[n], value||options); }
		}
	} else { // get cookie (or all cookies if name is not provided)
		var returnValue = {};
		if (document.cookie) {
			var cookies = document.cookie.split(';');
			for (var i = 0; i < cookies.length; i++) {
				var cookie = jQuery.trim(cookies[i]);
				// Does this cookie string begin with the name we want?
				if (!name) {
					var nameLength = cookie.indexOf('=');
					returnValue[ cookie.substr(0, nameLength)] = decodeURIComponent(cookie.substr(nameLength+1));
				} else if (cookie.substr(0, name.length + 1) == (name + '=')) {
					returnValue = decodeURIComponent(cookie.substr(name.length + 1));
					break;
				}
			}
		}
		return returnValue;
	}
};