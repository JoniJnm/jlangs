/* global app, _, jstemplate, Event */

(function() {
	'use strict';

	var View = function() {
		this.$filter = $('#filter-project');
		this.$select = this.$filter.find('select');
		this.$btnDelete = this.$filter.find('.delete');

		this.$adder = $('#add-project');
		this.$formAdd = this.$adder.find('form');
		this.$name = this.$formAdd.find('input');

		this.tplOption = jstemplate.parse('<option value="{value}">{text}</option>');

		this.onDelete = new Event();
		this.onAdd = new Event();
		this.onChange = new Event();

		var self = this;

		this.$btnDelete.click(function() {
			var id_project = parseInt(self.$select.val());
			self.onDelete.trigger(id_project);
		});
		this.$formAdd.submit(function(event) {
			event.preventDefault();
			self.onAdd.trigger(self.$name.val());
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
				return option.name;
			});
			_.each(sorted, function(option) {
				self.add(option.id, option.name);
			});
		},
		clearList: function() {
			this.$select.html('');
			this.add(0, '');
		},
		clearAdder: function() {
			this.$name.val('');
		},
		remove: function(id_project) {
			this.setEmptyVal();
			this.$select.find('option[value="'+id_project+'"]').remove();
		},
		setEmptyVal: function() {
			this.$select.val(0);
			this.onChange.trigger(0);
		},
		showDelete: function() {
			this.$btnDelete.show();
		},
		hideDelete: function() {
			this.$btnDelete.hide();
		}
	};

	app.views.Projects = View;
})();
