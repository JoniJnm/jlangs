/* global _, app, jstemplate */

(function() {
	'use strict';

	var View = function() {
		this.$filter = $('#filter-key');
		this.$select = this.$filter.find('select');
		this.$btnDelete = this.$filter.find('.delete');

		this.tplOption = jstemplate.parse('<option value="{value}">{text}</option>');

		this.onDelete = new Event();
		this.onAdd = new Event();
		this.onChange = new Event();

		var self = this;

		this.$btnDelete.click(function() {
			var id_key = parseInt(self.$select.val());
			self.onDelete.trigger(id_key);
		});
		this.$select.change(function() {
			self.onChange.trigger(this.value);
		});
	};

	View.prototype = {
		add: function(value, text, select) {
			var html = this.tplOption.rende({
				value: value,
				text: text
			});
			this.$select.append(html);
			if (select) {
				this.$select.val(value).change();
			}
		},
		refreshList: function(list) {
			this.clearList();
			var self = this;
			var sorted = _.sortBy(list, function(option) {
				return option.id;
			});
			_.each(sorted, function(option) {
				self.add(option.id, option.default_value);
			});
		},
		clearList: function() {
			this.$select.html('');
			this.add(0, '');
		},
		showDelete: function() {
			this.$btnDelete.show();
		},
		hideDelete: function() {
			this.$btnDelete.hide();
		},
		remove: function(id_key) {
			this.setEmptyVal();
			this.$select.find('option[value="'+id_key+'"]').remove();
		},
		setEmptyVal: function() {
			this.$select.val(0);
			this.onChange.trigger(0);
		}
	};

	app.views.Keys = View;
})();
