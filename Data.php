<?php

require 'config.php';

require 'data/Category.php';
require 'data/Project.php';
require 'data/MediaItem.php';

class Data {

	/**
	 * Prints json data.
	 */
	public static function printJson() {
		$mysqli = getMysqli();

		try {
			//Print success data
			echo json_encode(array(
				'success' => true,
				'categories' => Data::getCategories($mysqli),
				'about_me' => Data::getAboutMe($mysqli)
			));
		} catch (Exception $e) {
			//Print failure data
			echo json_encode(array(
				'success' => false,
				'categories' => array(),
				'about_me' => "",
				'error' => $e->getMessage()
			));
		}

		$mysqli->close();
	}

	/**
	 * Returns about_me text.
	 *
	 * @param mysqli $mysqli Mysqli connection
	 * @return mixed         About me text
	 * @throws Exception     If an error occurs while fetching data.
	 */
	private static function getAboutMe(mysqli $mysqli) {
		$query = "SELECT 'about_me' FROM portfolio_about_me";

		//Prepare and execute query
		if ($stmt = $mysqli->prepare($query)) {
			$stmt->execute();

			//Error?
			if (!$stmt->errno) {
				throw new Exception("Error: could not execute query. " . $stmt->error);
			}

			//Fetch data
			$stmt->bind_result($about_me);
			$stmt->fetch();
			$stmt->close();

			return $about_me;
		} else {
			throw new Exception("Error: could not prepare query. " . $mysqli->error);
		}
	}

	/**
	 * Returns an array with all categories.
	 *
	 * @param mysqli $mysqli Mysqli connection
	 * @return array         Categories
	 * @throws Exception     If an error occurs while fetching data.
	 */
	private static function getCategories(mysqli $mysqli) {
		$query = "SELECT id, 'title', 'icon' FROM portfolio_categories";
		$categories = array();

		//Prepare and execute query
		if ($stmt = $mysqli->prepare($query)) {
			$stmt->execute();

			//Error?
			if (!$stmt->errno) {
				throw new Exception("Error: could not execute query. " . $stmt->error);
			}

			//Fetch data
			$stmt->bind_result($categoryId, $title, $icon);
			while ($stmt->fetch()) {
				$projects = Data::getProjects($mysqli, $categoryId);
				$categories[] = new Category($title, $icon, $projects);
			}
			$stmt->close();

			return $categories;
		} else {
			throw new Exception("Error: could not prepare query. " . $mysqli->error);
		}
	}

	/**
	 * Returns an array of projects for a specified category.
	 *
	 * @param mysqli $mysqli Mysqli connection
	 * @param $categoryId    Category ID.
	 * @return array         Projects for the category
	 * @throws Exception     If an error occurs while fetching data.
	 */
	private static function getProjects(mysqli $mysqli, $categoryId) {
		$query = "
		  	SELECT id, 'title', 'short_description', 'full_description', 'tags', 'project_date' 
			FROM portfolio_projects
			WHERE category_id = ?
		";
		$projects = array();

		//Prepare and execute query
		if ($stmt = $mysqli->prepare($query)) {
			$stmt->bind_param("i", $categoryId);
			$stmt->execute();

			//Error?
			if (!$stmt->errno) {
				throw new Exception("Error: could not execute query. " . $stmt->error);
			}

			//Fetch data
			$stmt->bind_result($projectId, $title, $shortDescription, $fullDescription, $tags, $date);
			while ($stmt->fetch()) {
				$images = Data::getProjectImages($mysqli, $projectId);
				$projects[] = new Project($title, $images, $shortDescription, $fullDescription, $tags, $date);
			}
			$stmt->close();

			return $projects;
		} else {
			throw new Exception("Error: could not prepare query. " . $mysqli->error);
		}
	}

	/**
	 * TODO: Get images and videos for project.
	 *
	 * @param mysqli $mysqli
	 * @param $projectId
	 * @return array
	 */
	private static function getProjectImages(mysqli $mysqli, $projectId) {
		return array();
	}
}