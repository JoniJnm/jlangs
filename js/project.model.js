/* global app */

(function() {
	'use strict';
	
	var Model = function(bundles) {
		this.bundles = bundles;
		this.view = new app.views.Projects();
		
		this.view.onAdd.attach(this.add, this);
		this.view.onChange.attach(this.onChange, this);
		this.view.onDelete.attach(this.remove, this);
	};
	
	Model.prototype = {
		refresh: function() {
			var self = this;
			$.ajax({
				url: 'rest/project',
				type: 'get',
				success: function(list) {
					self.view.refreshList(list);
					if (list.length === 1) {
						var project = list[0];
						self.view.$select.val(project.id).change();
					}
				}
			});
		},
		getIdProject: function() {
			return this.view.getIdProject();
		},
		add: function(name) {
			var self = this;
			$.ajax({
				url: 'rest/project',
				type: 'post',
				data: {
					name: name
				},
				success: function(id_project) {
					self.view.add(id_project, name, true);
					self.view.clearAdder();
				}
			});
		},
		remove: function(id_project) {
			var self = this;
			$.ajax({
				url: 'rest/project/'+id_project,
				type: 'delete',
				success: function() {
					self.view.remove(id_project);
				}
			});
		},
		onChange: function(id_project) {
			if (id_project > 0) {
				this.view.showDelete();
				this.bundles.refresh(id_project);
			}
			else {
				this.view.hideDelete();
				this.bundles.clear();
			}
		}
	};
	
	app.models.Projects = Model;
})();