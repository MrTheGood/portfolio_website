<?php

class Project {
	public $type = "project";
	public $title;
	public $images;
	public $shortDescription;
	public $fullDescription;
	public $tags;
	public $date;

	public function __construct($title, $images, $shortDescription, $fullDescription, $tags, $date) {
		$this->title = $title;
		$this->images = $images;
		$this->shortDescription = $shortDescription;
		$this->fullDescription = $fullDescription;
		$this->tags = $tags;
		$this->date = $date;
	}
}