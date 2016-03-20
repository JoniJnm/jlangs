/* global app */

$(document).ready(function() {
	'use strict';
	
	var texts = new app.models.Texts();
	var projects;
	texts.onReady.attach(function() {
		var keys = new app.models.Keys(texts);
		projects = new app.models.Projects(keys);
		
		projects.view.onChange.attach(function(id_project) {
			$('.export-btn').toggleClass('hidden', !id_project);
		});
		
		projects.refresh();
	});
	
	$('#navbar .export').click(function() {
		var id_project = projects.getIdProject();
		var type = $(this).data('type');
		var url = "rest/export/"+type+'?id_project='+id_project;
		if (type === 'json_var') {
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
