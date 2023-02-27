<?php
	require "database.php";
	/**
	 * This funktion is to create a new category.
	 * @param $active shows if category is active or not.
	 * @param $name has the name of the new category.
	 * @returns true if succesfull.
	 */
	function create_new_category($active, $name) {
		global $database;

		$result = $database->query("INSERT INTO category(active, name) VALUES($active, '$name')");

		if (!$result) {
			error("An error occured while saving the product", 500);
		}
		else {
			return true;
		}

	}
	/**
	 * This funktion is to update an existing category.
	 * @param $category_id is to identify which category should be edited.
	 * @param $active shows if category is active or not.
	 * @param $name has the name of the new category.
	 * @returns true if succesfull.
	 * @returns false on fail.
	 */
	function update_category($category_id, $active, $name) {
		global $database;

		$result = $database->query("UPDATE category SET active = $active, name = '$name' WHERE category_id = $category_id");
		if (!$result) {
			return false;
		}
		else {
			return true;
		}
	}
	/**
	 * This funktion is to view a specific category.
	 * @param $category_id is to identify which category should be viewed.
	 * @returns $category the category that was specified.
	 */
	function get_one_category($category_id) {
		global $database;

		$result = $database->query("SELECT * FROM category WHERE category_id = '$category_id'");

		if (!$result) {
			error("An error occured while fetching the category.", 500);
		}
		else if ($result === true || $result->num_rows == 0) {
		return array();
		}

		$category = $result->fetch_assoc();



		return $category;
	}
	/**
	 * This funktion is to view all categories.
	 * @returns $categories all categories. 
	 */
	function get_all_categories() {
		global $database;

		$result = $database->query("SELECT * FROM category");

		if (!$result) {
			error("An error occured while fetching the categories.", 500);
		}
		else if ($result === true || $result->num_rows == 0) {
		return array();
		}

		$categories = array();

		while ($category = $result->fetch_assoc()) {
			$categories[] = $category;
		}

		return $categories;
	}
	/**
	 * This funktion is to delete a specific category.
	 * @param $category_id is to identify which category should be deleted.
	 * @returns true if succesful.
	 * @returns flase if failed.
	 */
	function delete_category($category_id) {
		global $database;



		$result = $database->query("DELETE FROM category WHERE category_id = '$category_id'");

		if (!$result) {
			error("An error occured while deleting the category.", 500);
		}
		else if ($database->affected_rows == 0) {
			return false;
		}	
		else {
			return true;
		}

	}
?>
