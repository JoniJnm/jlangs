/* global app */

(function() {
	'use strict';

	var Model = function(texts) {
		this.id_project = 0;
		this.texts = texts;
		this.view = new app.views.Keys();

		this.view.onChange.attach(this.onChange, this);
		this.view.onDelete.attach(this.remove, this);
	};

	Model.prototype = {
		refresh: function(id_project) {
			this.id_project = id_project;

			var self = this;
			$.ajax({
				url: 'rest/key',
				type: 'get',
				data: {
					id_project: id_project
				},
				success: function(list) {
					self.texts.clear();
					self.view.refreshList(list);
				}
			});
		},
		remove: function(id_key) {
			var self = this;
			$.ajax({
				url: 'rest/key/'+id_key,
				type: 'delete',
				success: function() {
					self.view.remove(id_key);
				}
			});
		},
		clear: function() {
			this.view.clearList();
			this.view.hideDelete();
			this.texts.clear();
		},
		onChange: function(id_key) {
			if (id_key > 0) {
				this.view.showDelete();
				this.texts.refresh(id_key);
			}
			else {
				this.view.hideDelete();
				this.texts.clear();
			}
		}
	};

	app.models.Keys = Model;
})();
