/* global app, jstemplate */

(function() {
	'use strict';

	var View = function() {
		this.$langs = $('#langs');

		this.onReady = new Event(true);
		this.onSave = new Event();
		this.onDelete = new Event();

		var self = this;
		$.get('tpls/langs.tpl', function(data) {
			self.tplLang = jstemplate.parse(data);
			self.onReady.trigger();
		}, 'text');

		this.$langs.on('submit', 'form', function(event) {
			event.preventDefault();
			var $parent = $(this).closest('.translation');
			var id_lang = $parent.data('id-lang');
			var text = $parent.find('.text').val();
			self.onSave.trigger(id_lang, text);
		});
		this.$langs.on('click', '.delete', function() {
			var $parent = $(this).closest('.translation');
			var id_lang = $parent.data('id-lang');
			self.onDelete.trigger(id_lang);
		});
		this.$langs.on('keyup', '.text', function() {
			var $elm = $(this);
			$elm.addClass('unsaved');
		});
	};

	View.prototype = {
		refresh: function(langs) {
			var html = this.tplLang.rende(langs);
			this.$langs.html(html);
		},
		clear: function() {
			this.$langs.html('');
		},
		clearLang: function(id_lang) {
			this.$langs.find('.translation[data-id-lang="'+id_lang+'"] .text').val('');
			this.langSaved(id_lang);
		},
		langSaved: function(id_lang) {
			this.$langs.find('.translation[data-id-lang="'+id_lang+'"] .text').removeClass('unsaved');
		}
	};

	app.views.Texts = View;
})();
