<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../config/bootstrap.php';

use Faker\Factory as FakerFactory;
use Faker\ORM\CakePHP\Populator;

$generator = FakerFactory::create('nl_NL');
$populator = new Populator($generator);

/*
 * Tags
 */

$populator->addEntity('Tags', 50, [
	'title' => function() use ($generator) {
		return $generator->unique()->word;
	}
]);

/*
 * Projecten
 */
$populator->addEntity('Projects', 10, [
	'title' => function() use ($generator) {
		$words = $generator->unique()->words(3);
		$words[0] = ucfirst($words[0]);
		return implode(' ', $words);
	},
	'is_archived' => false,
]);

/*
 * Actie
 */
$populator->execute();

/*
 * Taken
 */

function getIsCompleted() {
	usleep(rand(0, 3));
	return rand(0, 10) >= 7;
}

function getTitle($generator) {
	$words = $generator->unique()->words(6);
	$words[0] = ucfirst($words[0]);
	return implode(' ', $words);
}

function getDescription($generator) {
	$sentences = $generator->sentences(rand(1, 4));
	$description = implode("\n\n", $sentences);
	return $description;
}

function getNewTaskData($generator, $project_id, $parent_id) {
	$task = [
		'parent_id' => $parent_id,
		'project_id' => $project_id,
		'title' => getTitle($generator),
		'description' => getDescription($generator),
		'is_completed' => getIsCompleted(),
		'is_archived' => getIsCompleted(),
	];
	return $task;
}


$tasks = \Cake\ORM\TableRegistry::get('Tasks');

for ($project_id = 1; $project_id <= 10; $project_id++) {
	$tasks->behaviors()->Tree->config('scope', ['project_id' => $project_id]);
	$parent_id = 0;

	for ($i = 0; $i <= rand(4, 8); $i++) {
		// Get data for new task
		$new_task_data = getNewTaskData($generator, $project_id, $parent_id);

		// Do insert
		$new_task = $tasks->newEntity();
		$patched_task = $tasks->patchEntity($new_task, $new_task_data);
		$result = $tasks->save($patched_task);

		// Make next task child of newly made task
		if (!getIsCompleted()) {
			$parent_id = $result->id;
		}
		var_dump($parent_id);
	}
}

die('@debug in ' . __FILE__ . ' @' . __LINE__ . "\n");
