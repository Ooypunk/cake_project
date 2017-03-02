<?php

namespace App\View\Helper;

use Cake\View\Helper;

class TreeHelper extends Helper {

	public $default_config = [
		'type' => 'ul',
	];
	public $config;

	const TYPE_UL = 'ul';
	const TYPE_TABLE = 'table';

	public function generate($tree, array $config = []) {
		if (is_object($tree)) {
			$tree = $tree->toArray();
		}
		if (empty($tree)) {
			return '';
		}

		$this->config = $config + $this->default_config;

		switch ($this->getConfig('type')) {
			case self::TYPE_UL:
				return $this->getUlFromTree($tree);
			case self::TYPE_TABLE:
				$table_rows = '';
				$this->getTableRowsFromTree($tree, $table_rows);
				$table = $this->getListStart() . $table_rows . $this->getListEnd();
				return $table;
			default:
				throw new \Exception('Type not found');
		}
	}

	/*
	 * UL
	 */

	private function getUlFromTree(array $tree, $level = 1) {
		$ul = $this->getListStart();
		foreach ($tree as $node) {
			$ul .= '<li class="level-' . $level . '">' . $node->title;
			if (isset($node->children) && is_array($node->children) && count($node->children) > 0) {
				$ul .= $this->getUlFromTree($node->children, ++$level);
			}
		}
		$ul .= $this->getListEnd();
		return $ul;
	}

	private function getListStart() {
		$html = '';
		switch ($this->getConfig('type')) {
			case self::TYPE_UL:
				$html .= '<ul';
				break;
			case self::TYPE_TABLE:
				$html .= '<table';
				break;
		}

		$id = $this->getConfig('id');
		if ($id !== null) {
			$html .= sprintf(' id="%s"', $id);
		}

		$class = $this->getConfig('class');
		if ($class !== null) {
			$html .= sprintf(' class="%s"', $class);
		}

		$html .= '>';
		return $html;
	}

	private function getListEnd() {
		switch ($this->getConfig('type')) {
			case self::TYPE_UL:
				return '</ul>';
			case self::TYPE_TABLE:
				return '</table>';
		}
	}

	/*
	 * TABLE
	 */

	private function getTableRowsFromTree(array $tree, &$rows, $level = 1) {
		foreach ($tree as $node) {
			$has_children = isset($node->children) && is_array($node->children) && count($node->children) > 0;
			$rows .= $this->getTableRowFromNode($node, $level, $has_children);
			if ($has_children) {
				$rows .= $this->getTableRowsFromTree($node->children, $rows, ++$level);
			}
		}
	}

	private function getTableRowFromNode($node, $level, $has_children) {
		$classes = 'level-' . $level;
		if ($has_children) {
			$classes .= ' has_children';
		}
		$row = '';
		$row .= '<tr class="' . $classes . '">';
		$row .= '<td>';
		if ($has_children) {
			$row .= '<span class="glyphicon glyphicon-chevron-down">';
		} else {
			$row .= '<span class="tree_spacer">';
		}
		$row .= '</span>' . $node->title . '</td>';
		$row .= '</tr>';
		return $row;
	}

	/*
	 * Config
	 */

	private function getConfig($key) {
		if (isset($this->config[$key])) {
			return $this->config[$key];
		}
		return null;
	}

}
