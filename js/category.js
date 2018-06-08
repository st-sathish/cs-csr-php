var category = new (function() {
	var self = this;

	self.getCategories = function(callback) {
		$.ajax({
			  url: '../../api/v1/category/get_categories.php',
			  success: function(data) {
			  	callback(JSON.parse(data));
			  }
		});
	}

	self.init = function() {
		
	}

	return this;
})();