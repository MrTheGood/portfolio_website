<?php

class Category {
	public $type = "category";
	public $title;
	public $icon;
	public $items;

	public function __construct($title, $icon, $items) {
		$this->title = $title;
		$this->icon = $icon;
		$this->items = $items;
	}
}