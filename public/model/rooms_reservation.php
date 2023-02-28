<?php
		require "database.php";
		/**
		 * This funktion is to create a new product.
		 * 
		 * @returns true if succesfull.
		 */
		function create_new_room_res($room, $res_from, $res_till, $date, $user ) {
			global $database;

			$result = $database->query("INSERT INTO product(room, reserved, res_from, res_till, date, user) VALUES('$room', 'TRUE', $res_from, '$res_till', '$date', '$user')");

			if (!$result) {
				error("An error occured while saving the room reservation", 500);
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
		function update_room_res($product_id, $sku, $active, $id_category, $name, $image, $description, $price, $stock) {
			global $database;

			$result = $database->query("UPDATE product SET sku = '$sku', active = $active, id_category = $id_category, name = '$name', image = '$image', description =  '$description', price = $price, stock = $stock WHERE product_id = $product_id");
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
		function get_one_room_res($product_id) {
			global $database;

			$result = $database->query("SELECT * FROM product WHERE product_id = '$product_id'");

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
		function get_all_rooms_res() {
			global $database;

			$result = $database->query("SELECT * FROM product");

			if (!$result) {
				error("An error occured while fetching the products.", 500);
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
		function delete_room_res($product_id) {
			global $database;



			$result = $database->query("DELETE FROM product WHERE product_id = '$product_id'");

			if (!$result) {
				error("An error occured while deleting the product.", 500);
			}
			else if ($database->affected_rows == 0) {
				error("This reservation has not been found", 404);
			}	
			else {
				return true;
			}
			
		}
?>
