<?php

class Category {
	public $type = "category";
	public $title;
	public $icon;
	public $items;

	private $id;
	private $cssId;

	public function __construct($id, $title, $icon) {
		$this->id = $id;
		$this->title = $title;
		$this->icon = $icon;
		$this->cssId = str_replace(" ", "_", $title);
	}

	public function setItems($items) {
		$this->items = $items;
	}

	public function getId() {
		return $this->id;
	}

	public function getCssId() {
		return $this->cssId;
	}
}