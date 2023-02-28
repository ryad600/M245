<?php
		require "database.php";
		/**
		 * This funktion is to create a new product.
		 * @param $sku is the identifier of the product.
		 * @param $active shows if product is active or not.
		 * @param $id_category shows in what category it belongs.
		 * @param $name shows its name.
		 * @param $image is a ling to an image of the prpduct.
		 * @param $description shows what the product is.
		 * @param $price shows the price of the product.
		 * @param $stock shows how many are left.
		 * @returns true if succesfull.
		 */
		function create_new_room($sku, $active, $id_category, $name, $image, $description, $price, $stock) {
			global $database;

			$result = $database->query("INSERT INTO product(sku, active, id_category, name, image, description, price, stock) VALUES('$sku', $active, $id_category, '$name', '$image', '$description', $price, $stock)");

			if (!$result) {
				error("An error occured while saving the product", 500);
			}
			else {
				return true;
			}

		}
		/**
		 * This funktion is to create a new product.
		 * @param $room is to identify which product should be edited.
		 * @param $story is the identifier of the product.
		 * @returns true if succesfull.
		 * @returns false if failed.
		 */
		function update_room($room, $story) {
			global $database;

			$result = $database->query("UPDATE rooms SET room = '$room', story = $story");
			if (!$result) {
				return false;
			}
			else {
				return true;
			}
		}
		/**
		 * This funktion is to view a specific product.
		 * @param $category_id is to identify which product should be viewed.
		 * @returns $product the product that was specified.
		 */
		function get_one_room($product_id) {
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
		function get_all_rooms() {
			global $database;

			$result = $database->query("SELECT * FROM rooms");

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
		 * @param $product_id is to identify which product should be deleted.
		 * @returns true if succesful.
		 * @returns flase if failed.
		 */
		function delete_room($rooms) {
			global $database;
			$result = $database->query("DELETE FROM rooms WHERE room = '$room'");

			if (!$result) {
				error("An error occured while deleting the product.", 500);
			}
			else if ($database->affected_rows == 0) {
				return false;
			}	
			else {
				return true;
			}
			
		}
?>
