<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;


	$app->post("/Spot_res", function (Request $request, Response $response, $args) {
		//Check the client's authentication.
		require "controller/require_authentication.php";

		//Read request body input string.
		$request_body_string = file_get_contents("php://input");

		//Parse the JSON string.
		$request_data = json_decode($request_body_string, true);
		
		//Clean up all unnecessary tags and add backslashes to safe your database.
		$spot 			= strip_tags(addslashes($request_data["spot"]));
		$res_from		= strip_tags(addslashes($request_data["res_from"]));
		$res_till		= strip_tags(addslashes($request_data["res_till"]));
		$date			= strip_tags(addslashes($request_data["date"]));
		$user 			= strip_tags(addslashes($request_data["user"]));

		//Check if all values are provided.
		if (!isset($spot)) {
			error("You have to choose a parking spot.", 400);
		}
		if (!isset($res_from)) {
			error("Choose when your reservation starts.", 400);
		}
		if (!isset($res_till)) {
			error("Choose when your reservation ends.", 400);
		}
		if (!isset($date)) {
			error("Choose your reservation date", 400);
		}
		if (!isset($user)) {
			error("There was an error while fetching your username!", 400);
		}
		//This function checks if the selected parking spot even exists.
		if (!check_spot($spot)) {
			error("This parking spot doas not exist!", 404);
		}
		//create new reservation
		if (create_new_spot_res($spot, $res_from, $res_till, $date, $user) === true) {
			http_response_code(201);
			echo "true";
		}
		else {
			error("An error occurred while saving the student data.", 500);
		}

		return $response;
		});

?>