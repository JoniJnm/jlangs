/* global app */

$(document).ready(function() {
	'use strict';
	
	var texts = new app.models.Texts();
	texts.onReady.attach(function() {
		var keys = new app.models.Keys(texts);
		var bundles = new app.models.Bundles(keys);
		var projects = new app.models.Projects(bundles);
		projects.refresh();
	});
	
	$('#navbar .export').click(function() {
		var type = $(this).data('type');
		if (type === 'php_class') {
			var url = "rest/export/"+type;
			var namespace = prompt("namespace (optional)");
			if (namespace) {
				url += '?namespace='+encodeURIComponent(namespace);
			}
			location.href = url;
		}
		else {
			location.href = "rest/export/"+type;
		}
	});
});
