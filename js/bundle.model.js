/* global app */

(function() {
	'use strict';
	
	var Model = function(keys) {
		this.id_project = 0;
		this.keys = keys;
		this.view = new app.views.Bundles();
		
		this.view.onAdd.attach(this.add, this);
		this.view.onChange.attach(this.onChange, this);
		this.view.onDelete.attach(this.remove, this);
	};
	
	Model.prototype = {
		refresh: function(id_project) {
			this.id_project = id_project;
			
			var self = this;
			$.ajax({
				url: 'rest/bundle',
				type: 'get',
				data: {
					id_project: id_project
				},
				success: function(list) {
					self.keys.clear();
					self.view.refreshList(list);
					self.view.showAdder();
				}
			});
		},
		add: function(name) {
			var self = this;
			$.ajax({
				url: 'rest/bundle',
				type: 'post',
				data: {
					id_project: this.id_project,
					name: name
				},
				success: function(id_bundle) {
					self.view.add(id_bundle, name, true);
					self.view.clearAdder();
				}
			});
		},
		clear: function() {
			this.view.clearList();
			this.view.hideAdder();
			this.view.hideDelete();
			this.keys.clear();
		},
		remove: function(id_bundle) {
			var self = this;
			$.ajax({
				url: 'rest/bundle',
				type: 'delete',
				data: {
					id_bundle: id_bundle
				},
				success: function() {
					self.view.remove(id_bundle);
				}
			});
		},
		onChange: function(id_bundle) {
			if (id_bundle > 0) {
				this.view.showDelete();
				this.keys.refresh(id_bundle);
			}
			else {
				this.view.hideDelete();
				this.keys.clear();
			}
		}
	};
	
	app.models.Bundles = Model;
})();