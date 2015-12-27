/* global app */

(function() {
	'use strict';
	
	var Model = function(keys) {
		this.keys = keys;
		this.view = new app.views.Bundles();
		
		this.view.onAdd.attach(this.add, this);
		this.view.onChange.attach(this.onChange, this);
		this.view.onDelete.attach(this.remove, this);
	};
	
	Model.prototype = {
		refresh: function() {
			var self = this;
			$.get('rest/bundle/get', function(list) {
				self.view.refreshList(list);
			});
		},
		add: function(name) {
			var self = this;
			$.post('rest/bundle/add', {
				name: name
			}).done(function(id_bundle) {
				self.view.add(id_bundle, name, true);
				self.view.clearAdder();
			});
		},
		remove: function(id_bundle) {
			var self = this;
			$.post('rest/bundle/delete', {
				id_bundle: id_bundle
			}).done(function() {
				self.view.remove(id_bundle);
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