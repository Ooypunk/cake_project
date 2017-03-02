$(function () {
	$('#tag_select').select2({
		width: '100%',
		placeholder: "Selecteer een tag",
		allowClear: true,
		allowSearch: true,
		tags: true,
		ajax: {
			url: getBaseUrl() + '/tags/json_get',
			dataType: 'json',
			quietMillis: 100,
//			data: function (term, page) {
//				return {
//					term: term, //search term
//					page_limit: 10 // page size
//				};
//			},
			results: function (data, page) {
				return {results: data.results};
			}
		}
	});
	console.log($('#tag_select'));
});
