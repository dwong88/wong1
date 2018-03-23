var Karlwei = {
	config: {
		datepicker_format: 'dd/mm/yy',
	},
	helper: {
		number: {
			addCommas: function(nStr) {
				nStr += '';
			    var x = nStr.split('.');
			    var x1 = x[0];
			    var x2 = x.length > 1 ? ((!isNaN(x[1]) && parseInt(x[1]) > 0)? '.' + x[1] : '') : '';
			    var rgx = /(\d+)(\d{3})/;
			    while (rgx.test(x1)) {
			        x1 = x1.replace(rgx, '$1' + ',' + '$2');
			    }
			    return x1 + x2;
			},
			removeCommas: function(nStr) {
				nStr += '';
			    var x = nStr.split('.');
			    var x1 = x[0];
			    var x2 = x.length > 1 ? '.' + x[1] : '';
			    return x1.replace(/,/g,'') + x2;
			}
		},
		date: {
			registerTableDetailDateField: function(jSelector) {
				jSelector.removeAttr('id').removeClass('hasDatepicker').datepicker({'appendText':'','changeMonth':true,'changeYear':true,'dateFormat':Karlwei.config.datepicker_format,'yearRange':'1950:2025'});
			}
		}
	}
};