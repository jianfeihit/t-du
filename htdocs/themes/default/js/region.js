var Region = function() {
};

Region.prototype = {
	loadCities : function(province_id, city_sel_id, district_sel_id,
			default_city_id) {
		if (city_sel_id != null && district_sel_id != null) {
			if (default_city_id == undefined)
				default_city_id = 0;
			var city = $("#" + city_sel_id);
			city.hide();
			city.children().each(function() {
				if ($(this).val() != 0)
					$(this).remove();
			});
			var district = $("#" + district_sel_id);
			district.hide();
			district.children().each(function() {
				if ($(this).val() != 0){
					$(this).remove();
				}
			});
			$.ajax({
				url : "/region.php?type=2&parent=" + province_id,
				dataType : 'json',
				success : function(data) {
					for (var reg in data.regions) {
						city.append("<option value='" + data.regions[reg].region_id + "'>" + data.regions[reg].region_name + "</option>");
					}
					city.val(default_city_id);
					city.show();
				},
				error : function(jqXHR, textStatus, errorThrown) {
				},
				async : false
			});
		}
	},

	loadDistricts : function(city_id, district_sel_id, default_district_id,
			callback) {
		if (district_sel_id != null) {
			if (default_district_id == undefined)
				default_district_id = 0;
			var district = $("#" + district_sel_id);
			district.hide();
			district.children().each(function() {
				if ($(this).val() != 0)
					$(this).remove();
			});
			$.ajax({
				url : "/region.php?type=3&parent=" + city_id,
				dataType : 'json',
				success : function(data) {
					for(dic in data.regions){
						district.append("<option value='" + data.regions[dic].region_id + "'>" + data.regions[dic].region_name + "</option>");
					}
					district.val(default_district_id);
					district.show();
					if (callback != undefined) {
						district.unbind(callback.trigger);
						district.bind(callback.trigger, callback.func);
					}
				},
				async : false
			});
		}
	}
};
