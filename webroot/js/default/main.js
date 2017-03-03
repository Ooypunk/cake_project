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

			$.contextMenu({
				selector: '#tasks_tree .node-tasks_tree',
				items: {
					edit: {name: "Wijzigen", icon: "edit"}
				},
				callback: function (itemKey, opt) {
					switch (itemKey) {
						case 'edit':
							var trigger = opt.$trigger;
							var task_id = trigger.context.dataset.id;
							var url = getBaseUrl() + '/tasks/edit/' + task_id;
							window.location.href = url;
							return false;
						default:
							alert("Clicked on " + itemKey + " on element " + opt.$trigger.attr("id"));
					}

					// Do not close the menu after clicking an item
					return false;
				}
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

			$.contextMenu({
				selector: '#projects_tree .node-projects_tree',
				items: {
					edit: {name: "Wijzigen", icon: "edit"}
				},
				callback: function (itemKey, opt) {
					switch (itemKey) {
						case 'edit':
							var trigger = opt.$trigger;
							var project_id = trigger.context.dataset.id;
							var url = getBaseUrl() + '/projects/edit/' + project_id;
							window.location.href = url;
							return false;
						default:
							alert("Clicked on " + itemKey + " on element " + opt.$trigger.attr("id"));
					}

					// Do not close the menu after clicking an item
					return false;
				}
			});
		}
	});
	return output;
}

$(function () {
	getTasksTree();
	getProjectsTree();
});
