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
			$.ajax({
				url: 'rest/text',
				type: 'get',
				data: {
					id_key: id_key
				},
				success: function(langs) {
					self.view.refresh(langs);
				}
			});
		},
		clear: function() {
			this.view.clear();
		},
		save: function(id_lang, text) {
			var self = this;
			$.ajax({
				url: 'rest/text',
				type: 'post',
				data: {
					id_key: this.id_key,
					id_lang: id_lang,
					text: text
				},
				success: function() {
					self.view.langSaved(id_lang);
				}
			});
		},
		remove: function(id_lang) {
			var self = this;
			$.ajax({
				url: 'rest/delete',
				type: 'post',
				data: {
					id_key: this.id_key,
					id_lang: id_lang
				},
				success: function() {
					self.view.clearLang(id_lang);
				}
			});
		}
	};

	app.models.Texts = Model;
})();
