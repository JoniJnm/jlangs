/* global app, jstemplate */

(function() {
	'use strict';

	var View = function() {
		this.$root = $('#langs');
		this.$langs = this.$root.find('.list');
		this.$saveAllBtn = this.$root.find('.save-all');
		this.$toggleInputs = this.$root.find('.toggle-inputs');

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
			var text = $parent.find('.text.enabled').val();
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
		
		this.$saveAllBtn.click(function() {
			$('.translation .save', this.$langs).each(function() {
				$(this).click();
			});
		});
		this.$toggleInputs.click(function() {
			self.toggleInputs();
		});
	};

	View.prototype = {
		refresh: function(langs) {
			var html = this.tplLang.rende(langs);
			this.$langs.html(html);
			this.$root.removeClass('hidden');
		},
		clear: function() {
			this.$root.addClass('hidden');
			this.$langs.html('');
		},
		clearLang: function(id_lang) {
			this.$langs.find('.translation[data-id-lang="'+id_lang+'"] .text').val('');
			this.langSaved(id_lang);
		},
		langSaved: function(id_lang) {
			this.$langs.find('.translation[data-id-lang="'+id_lang+'"] .text').removeClass('unsaved');
		},
		toggleInputs: function() {
			$('.translation', this.$langs).each(function() {
				var $inputVisible = $('.text.enabled', this);
				var $inputHidden = $('.text.disabled', this);
				var value = $inputVisible.val();
				$inputVisible
					.prop('required', false)
					.addClass('disabled')
					.removeClass('enabled');
				$inputHidden
					.prop('required', true)
					.val(value)
					.addClass('enabled')
					.removeClass('disabled');
			});
		}
	};

	app.views.Texts = View;
})();
