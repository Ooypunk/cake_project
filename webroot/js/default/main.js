function getBaseUrl() {
	if (!window.location.origin) {
		var url = window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');
	} else {
		var url = window.location.origin;
	}
	if (url === 'http://localhost:8888') {
		url += '/portalgarden/cake_project/public';
	}
	if (url === 'http://localhost') {
		url += '/cake_project';
	}
	return url;
}

function getTasksTree() {
	var output;

	var url = getBaseUrl() + '/projects/tasks_tree';

	var input = $('input[name="project_id"]');
	if (input.length === 1) {
		url += '/' + input.val();
	} else {
		return;
	}

	$.ajax({
		url: url,
		method: 'get',
		dataType: 'json',
		success: function (response) {
			$('#tasks_tree').empty().treeview({
				data: response
			});
		}
	});
	return output;
}

function getProjectsTree() {
	var output;

	var url = getBaseUrl() + '/projects/tree';

	var input = $('input[name="project_id"]');
	if (input.length === 1) {
		url += '/' + input.val();
	}

	$.ajax({
		url: url,
		method: 'get',
		dataType: 'json',
		success: function (response) {
			$('#projects_tree').empty().treeview({
				data: response
			});
		}
	});
	return output;
}

$(function () {
	getTasksTree();
	getProjectsTree();
});
