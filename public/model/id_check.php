<?php 
	/**
	 * This funktion is to check if the given category exists.
	 * @param $id is to identify which category has to be checked.
	 * @returns true if succesfull.
	 * @returns false if failed.
	 */
	function check_category_id($id) {
		global $database;

		$result = $database->query("SELECT * FROM category WHERE category_id = $id");

		if ($result->num_rows == 0) {
			return false;
		}
		else {
			return true;
			
		}
	}
	/**
	 * This funktion is to check if the given product exists.
	 * @param $id is to identify which product has to be checked.
	 * @returns true if succesfull.
	 * @returns false if failed.
	 */
	function check_product_id($id) {
		global $database;

		$result = $database->query("SELECT * FROM product WHERE product_id = $id");

		if ($result->num_rows == 0) {
			return false;
		}
		else {
			return true;
			
		}
	}

?>
