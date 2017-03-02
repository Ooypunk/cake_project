<?php

namespace App\ORM\Rule;

use Cake\ORM\Rule\ExistsIn;
use Cake\Datasource\EntityInterface;

class ExistsInOrZero extends ExistsIn {

	public function __invoke(EntityInterface $entity, array $options) {
		$value = $entity->get($options['errorField']);
		if ($value === 0) {
			return true;
		}
		return parent::__invoke($entity, $options);
	}

}
