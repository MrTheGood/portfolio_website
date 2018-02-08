<?php

class Category {
	public $type = "category";
	public $title;
	public $icon;
	public $items;

	private $id;

	public function __construct($id, $title, $icon) {
		$this->id = $id;
		$this->title = $title;
		$this->icon = $icon;
	}

	public function setItems($items) {
		$this->items = $items;
	}

	public function getId() {
		return $this->id;
	}
}