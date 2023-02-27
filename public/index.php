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

	$files = array("rooms/get_all_rooms",
				   "spots/get_all_spots",
				   "rooms/get_all_room_res",
				   "spots/get_all_spot_res",

				   "rooms/get_one_room",
				   "spots/get_one_spot",
				   "rooms/get_one_room_res",
				   "spots/get_one_spot_res",

				   "rooms/post_room",
				   "spots/post_spot",
				   "rooms/post_room_res",
				   "spots/post_spot_res",

				   "rooms/put_room",
				   "spots/put_spot",
				   "rooms/put_room_res",
				   "spots/put_spot_res",

				   "rooms/delete_room",
				   "spots/delete_spot",
				   "rooms/delete_room_res",
				   "spots/delete_spot_res",
				
				   "authentification.php");

	

	for ($i = 1; $i < count($files); $i++) { 
		require "controller/" . $files[($i - 1)] . ".php";
	}


	$app->run();
?>