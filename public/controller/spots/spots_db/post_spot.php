<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;


	$app->post("/Parking_spot", function (Request $request, Response $response, $args) {
		//Check the client's authentication.
		require "controller/require_authentication.php";

		//Read request body input string.
		$request_body_string = file_get_contents("php://input");

		//Parse the JSON string.
		$request_data = json_decode($request_body_string, true);

		//Check if all values are provided.
		if (!isset($request_data["spot"])) {
			error("The field active must have a value", 400);
		}

		//Clean up all unnecessary tags and add backslashes to safe your database.
		$spot 			= strip_tags(addslashes($request_data["spot"]));

		//make sure nothing is empty and make sure that.
		if (empty($spot)) {
			error("The 'name' field must not be empty.", 400);
		}

		if (create_new_spot($spot) === true) {
			http_response_code(201);
			echo "true";
		}
		else {
			error("An error occurred while saving the parking spot.", 500);
		}

		return $response;
		});

?>