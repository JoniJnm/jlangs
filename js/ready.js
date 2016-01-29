/* global app */

$(document).ready(function() {
	'use strict';
	
	var texts = new app.models.Texts();
	var projects;
	texts.onReady.attach(function() {
		var keys = new app.models.Keys(texts);
		var bundles = new app.models.Bundles(keys);
		projects = new app.models.Projects(bundles);
		
		projects.view.onChange.attach(function(id_project) {
			$('.export-btn').toggleClass('hidden', id_project == 0);
		});
		
		projects.refresh();
	});
	
	$('#navbar .export').click(function() {
		var id_project = projects.getIdProject();
		var type = $(this).data('type');
		var url = "rest/export/"+type+'?id_project='+id_project;
		if (type === 'php_class') {
			var namespace = prompt("namespace (optional)");
			if (namespace) {
				url += '&namespace='+encodeURIComponent(namespace);
			}
			location.href = url;
		}
		else if (type === 'json_var') {
			var varname = prompt("Var name", 'lang');
			if (varname) {
				url += '&varname='+encodeURIComponent(varname);
			}
			location.href = url;
		}
		else {
			location.href = url;
		}
	});
});
