/* global app */

$(document).ready(function() {
	'use strict';
	
	var texts = new app.models.Texts();
	texts.onReady.attach(function() {
		var keys = new app.models.Keys(texts);
		var bundles = new app.models.Bundles(keys);
		bundles.refresh();
	});
	
	$('#navbar .export').click(function() {
		location.href = 'rest/export/getAll';
	});
});
