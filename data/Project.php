<?php

class Project {
	public $type = "project";
	public $title;
	public $images;
	public $shortDescription;
	public $fullDescription;
	public $tags;
	public $date;

	private $id;

	public function __construct($id, $title, $shortDescription, $fullDescription, $tags, $date) {
		$this->id = $id;
		$this->title = $title;
		$this->shortDescription = $shortDescription;
		$this->fullDescription = $fullDescription;
		$this->tags = $tags;
		$this->date = $date;
	}

	public function setImages($images) {
		$this->images = $images;
	}

	public function getId() {
		return $this->id;
	}
}