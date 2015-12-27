/* global app */

(function() {
	'use strict';

	var Model = function(texts) {
		this.id_bundle = 0;
		this.texts = texts;
		this.view = new app.views.Keys();

		this.view.onAdd.attach(this.add, this);
		this.view.onChange.attach(this.onChange, this);
		this.view.onDelete.attach(this.remove, this);
	};

	Model.prototype = {
		refresh: function(id_bundle) {
			this.id_bundle = id_bundle;

			var self = this;
			$.get('rest/key/get', {
				id_bundle: id_bundle
			}).done(function(list) {
				self.texts.clear();
				self.view.refreshList(list);
				self.view.showAdder();
			});
		},
		remove: function(id_key) {
			var self = this;
			$.post('rest/key/delete', {
				id_key: id_key
			}).done(function() {
				self.view.remove(id_key);
			});
		},
		add: function(name) {
			var self = this;
			$.post('rest/key/add', {
				id_bundle: this.id_bundle,
				name: name
			}, function(id_key) {
				self.view.add(id_key, name, true);
				self.view.clearAdder();
			});
		},
		clear: function() {
			this.view.clearList();
			this.view.hideAdder();
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
