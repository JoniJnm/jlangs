/* global app */

(function() {
	'use strict';

	var Model = function() {
		this.id_key = 0;
		this.onReady = new Event(true);
		this.view = new app.views.Texts();

		this.view.onReady.attach(this.onReady.trigger, this.onReady);
		this.view.onSave.attach(this.save, this);
		this.view.onDelete.attach(this.remove, this);
	};

	Model.prototype = {
		refresh: function(id_key) {
			this.id_key = id_key;
			var self = this;
			$.get('rest/text/get', {
				id_key: id_key
			}, function(langs) {
				self.view.refresh(langs);
			});
		},
		clear: function() {
			this.view.clear();
		},
		save: function(id_lang, text) {
			var self = this;
			$.post('rest/text/save', {
				id_key: this.id_key,
				id_lang: id_lang,
				text: text
			}).done(function() {
				self.view.langSaved(id_lang);
			});
		},
		remove: function(id_lang) {
			var self = this;
			$.post('rest/text/delete', {
				id_key: this.id_key,
				id_lang: id_lang
			}).done(function() {
				self.view.clearLang(id_lang);
			});
		}
	};

	app.models.Texts = Model;
})();
