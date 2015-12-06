(function() {
	'use strict';

	var Event = function(unique) {
		this.list = [];

		this.unique = unique === undefined ? false : !!unique;
		this.thrown = false;
		this.thrownArgs = [];
	};

	Event.prototype = {
		attach: function(func, scope) {
			if (typeof(func) !== 'function') {
				throw new TypeError('The first argument must be a function');
			}
			if (this.unique && this.thrown) {
				func.apply(scope, this.thrownArgs);
			}
			else {
				this.list.push({
					func: func,
					scope: scope
				});
			}
		},
		trigger: function() {
			if (this.unique) {
				if (this.thrown) {
					throw new Error('Unique event thrown twice');
				}
				this.thrown = true;
				this.thrownArgs = arguments;
			}
			for (var i=0; i<this.list.length; i++) {
				var func = this.list[i].func;
				var scope = this.list[i].scope;
				func.apply(scope, arguments);
			}
		}
	};

	window.Event = Event;
})();
