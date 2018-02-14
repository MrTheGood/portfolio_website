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
			$categories = Data::getCategories($mysqli);
			$aboutMe = Data::getAboutMe($mysqli);
			foreach ($categories as $category) {
				$category->setItems(Data::getProjects($mysqli, $category->getId()));
			}

			foreach ($categories as $category) {
				foreach ($category->items as $project) {
					if ($project instanceof Project) {
						$project->setImages(Data::getProjectImages($mysqli, $project->getId()));
					}
				}
			}

			//Print success data
			echo json_encode(array(
				'success' => true,
				'categories' => $categories,
				'about_me' => $aboutMe
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
		$query = "SELECT about_me FROM about_me";

		//Prepare and execute query
		if ($stmt = $mysqli->prepare($query)) {
			if (!$stmt->execute()) {
				throw new Exception("Error: could not execute query. query=$query;stmt->errno=" . $stmt->errno . ";stmt->error=" . $stmt->error);
			}

			//Fetch data
			$stmt->bind_result($about_me);
			$stmt->fetch();
			$stmt->close();

			return $about_me;
		} else {
			throw new Exception("Error: could not prepare query. query=$query,mysqli_error=" . mysqli_error($mysqli));
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
		$query = "SELECT id, title, icon FROM categories ORDER BY position ASC";
		$categories = array();

		//Prepare and execute query
		if ($stmt = $mysqli->prepare($query)) {
			if (!$stmt->execute()) {
				throw new Exception("Error: could not execute query. query=$query;stmt->errno=" . $stmt->errno . ";stmt->error=" . $stmt->error);
			}

			//Fetch data
			$stmt->bind_result($categoryId, $title, $icon);
			while ($stmt->fetch()) {
				$categories[] = new Category($categoryId, $title, $icon);
			}
			$stmt->close();

			return $categories;
		} else {
			throw new Exception("Error: could not prepare query. query=$query,mysqli_error=" . mysqli_error($mysqli));
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
		$query = "SELECT id, title, short_description, full_description, tags, project_date FROM projects RIGHT JOIN projects_categories ON id = project_id WHERE category_id = ? ORDER BY position ASC";
		$projects = array();

		//Prepare and execute query
		if ($stmt = $mysqli->prepare($query)) {
			$stmt->bind_param("i", $categoryId);
			if (!$stmt->execute()) {
				throw new Exception("Error: could not execute query. query=$query;stmt->errno=" . $stmt->errno . ";stmt->error=" . $stmt->error);
			}

			//Fetch data
			$stmt->bind_result($projectId, $title, $shortDescription, $fullDescription, $tags, $date);
			while ($stmt->fetch()) {
				$projects[] = new Project($projectId, $title, $shortDescription, $fullDescription, $tags, $date);
			}
			$stmt->close();

			return $projects;
		} else {
			throw new Exception("Error: could not prepare query. query=$query,mysqli_error=" . mysqli_error($mysqli));
		}
	}

	/**
	 * Gets all media items from a specific project.
	 *
	 * @param mysqli $mysqli Mysqli connection
	 * @param $projectId     Project to get images for
	 * @return array         Images
	 * @throws Exception     If an error occurs while fetching data.
	 */
	private static function getProjectImages(mysqli $mysqli, $projectId) {
		$query = "SELECT image, video FROM project_images WHERE project_id = ? ORDER BY position ASC";
		$images = array();

		//Prepare and execute query
		if ($stmt = $mysqli->prepare($query)) {
			$stmt->bind_param("i", $projectId);
			if (!$stmt->execute()) {
				throw new Exception("Error: could not execute query. query=$query;stmt->errno=" . $stmt->errno . ";stmt->error=" . $stmt->error);
			}

			//Fetch data
			$stmt->bind_result($image, $video);
			while ($stmt->fetch()) {
				if (empty($video)) {
					$images[] = $image;
				} else if (empty($image)) {
					$images[] = new YouTubeItem($video);
				} else {
					$images[] = new MediaItem($video, $image);
				}
			}
			$stmt->close();

			return $images;
		} else {
			throw new Exception("Error: could not prepare query. query=$query,mysqli_error=" . mysqli_error($mysqli));
		}
	}
}