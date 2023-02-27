<?php
	header("Content-Type: application/json");

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

	require __DIR__ . "/../vendor/autoload.php";
	require_once "config/config.php";
	require "model/product.php";
	require "model/category.php";
	require "model/id_check.php";


	$app = AppFactory::create();

	/**
     * @OA\Info(title="M295 Webshop API", version="1.0")
 	 */


	/**
	 * Returns an error to the client with the given message and status code.
	 * This will immediately return the response and end all scripts.
	 * @param $message The error message string.
	 * @param $code The response code to set for the response.
	 */
	function error($message, $code) {
		//Write the error as a JSON object.
		$error = array("Error message" => $message);
		echo json_encode($error);

		//Set the response code.
		http_response_code($code);

		//End all scripts.
		die();
	}

	$files = array("rooms/room_db/get_all_rooms",
				   "spots/spots_db/get_all_spots",
				   "rooms/reservations/get_all_room_res",
				   "spots/reservations/get_all_spot_res",

				   "rooms/room_db/get_one_room",
				   "spots/spots_db/get_one_spot",
				   "rooms/reservations/get_one_room_res",
				   "spots/reservations/get_one_spot_res",

				   "rooms/room_db/post_room",
				   "spots/spots_db/post_spot",
				   "rooms/reservations/post_room_res",
				   "spots/reservations/post_spot_res",

				   "rooms/room_db/put_room",
				   "spots/spots_db/put_spot",
				   "rooms/reservations/put_room_res",
				   "spots/reservations/put_spot_res",

				   "rooms/room_db/delete_room",
				   "spots/spots_db/delete_spot",
				   "rooms/reservations/delete_room_res",
				   "spots/reservations/delete_spot_res",
				
				   "authentification.php");

	foreach ($file as $file) {
		require "controller/" . $files . ".php";
	}

	$app->run();
?>