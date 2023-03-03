<?php
		require "database.php";
		/**
		 * This funktion is to create a new product.
		 * @returns true if succesfull.
		 */
		function create_new_spot_res($spot, $res_from, $res_till, $date, $user) {
			global $database;

			$result = $database->query("INSERT INTO reserved_parking(spot, res_from, res_till, date, user) VALUES('$spot', $res_from, $res_till, '$date', '$user')");

			if (!$result) {
				error("An error occured while saving the product", 500);
			}
			else {
				return true;
			}

		}
		/**
		 * This funktion is to create a new product.
		 * @returns true if succesfull.
		 * @returns false if failed.
		 */
		function update_spot_res($spot_res_id, $spot, $res_from, $res_till, $date) {
			global $database;

			$result = $database->query("UPDATE reserved_parkin SET spot = '$spot', res_from = $res_from, res_till = $res_till, date = '$date' WHERE spot_res_id = $spot_res_id");
			if (!$result) {
				return false;
			}
			else {
				return true;
			}
		}
		/**
		 * This funktion is to view a specific product.
		 * @returns $product the product that was specified.
		 */
		function get_one_spot_res($spot_res_id) {
			global $database;

			$result = $database->query("SELECT * FROM reserved_parking WHERE ID = '$spot_res_id'");

			if (!$result) {
				error("An error occured while fetching the product.", 500);
			}
			else if ($result === true || $result->num_rows == 0) {
			return array();
			}

			$product = $result->fetch_assoc();
				
			

			return $product;
		}
		/**
		 * This funktion is to view all products.
		 * @returns $products all products. 
		 */
		function get_all_spots_res() {
			global $database;

			$result = $database->query("SELECT * FROM reserved_parking");

			if (!$result) {
				error("An error occured while fetching the reserved Parking spots.", 500);
			}
			else if ($result === true || $result->num_rows == 0) {
			return array();
			}

			$products = array();

			while ($product = $result->fetch_assoc()) {
				$products[] = $product;
			}

			return $products;
		}
		/**
		 * This funktion is to delete a specific product.
		 * @returns true if succesful.
		 * @returns flase if failed.
		 */
		function delete_spot_res($spot_res_id) {
			global $database;



			$result = $database->query("DELETE FROM reserved_parking WHERE spot_res_id = '$spot_res_id'");

			if (!$result) {
				error("An error occured while deleting the reservation.", 500);
			}
			else if ($database->affected_rows == 0) {
				return false;
			}	
			else {
				return true;
			}
			
		}
?>
