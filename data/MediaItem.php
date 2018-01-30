<?php

class MediaItem {
	public $video;
	public $image;

	public function __construct($video, $image) {
		$this->video = $video;
		$this->image = $image;
	}
}