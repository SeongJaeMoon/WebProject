<?php
require_once('INode.php');
require_once('NaverOptionItemQuery.php');

class NaverOptionItem implements INode {

	private $type = null;
	private $label = null;
	private $cases = array();

	public function __construct($type, $label) {
		$this->type = $type;
		$this->label = $label;
	}

	public function addCase($code, $value) {
		$this->cases[] = new NaverOptionItemQuery($code, $value);
	}

	public function getAttribute() {
		$attribute = array(
			"type" => $this->type,
			"name" => $this->label,
		);

		foreach ($this->cases as $idx=>$case) {
			$attribute["value" . $idx] = $case->getAttribute();
		}

		return $attribute;
	}

}