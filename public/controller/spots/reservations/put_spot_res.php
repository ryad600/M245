<?php
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;


	$app->put("/Spot_reservation/{spot_res_id}", function (Request $request, Response $response, $args) {
		//Check the client's authentication.
		require "controller/require_authentication.php";

		//Read request body input string.
		$request_body_string = file_get_contents("php://input");

		//Parse the JSON string.
		$request_data = json_decode($request_body_string, true);

		$spot_res_id = intval($args["spot_res_id"]);

		$spot_res = get_one_spot_res($spot_res_id);
		

		if (!$spot_res) {
			error("There is no category with the id '$category_id'.", 404);
		}
		else if (is_string($spot_res)) {
			error($spot_res, 500);
		}

		//check and update the chosen SPOT
		if (isset($request_data["spot"])) {
			$request_data["spot"] = strip_tags(addslashes($request_data["spot"]));
			if (strlen($request_data["spot"]) > 2) {
				error("Choose a valid Parkingspot", 400);
			}
			else {
				$spot = $request_data["spot"];
			}
		}
		else {
			$spot = $spot_res["spot"];
		}

		//check and update the chosen reservation time
		if (isset($request_data["res_from"])) {
			$request_data["res_from"] = strip_tags(addslashes($request_data["res_from"]));
			if (strlen($request_data["res_from"]) > 5) {
				error("Please enter a valid time", 400);
			}
			else {
				$res_from = $request_data["res_from"];
			}
		}
		else {
			$res_from = $spot_res["res_from"];
		}

		//check and update the chosen reservation time
		if (isset($request_data["res_till"])) {
			$request_data["res_till"] = strip_tags(addslashes($request_data["res_till"]));
			if (strlen($request_data["res_till"]) > 5) {
				error("Please enter a valid time", 400);
			}
			else {
				$res_till = $request_data["res_till"];
			}
		}
		else {
			$res_till = $spot_res["res_till"];
		}

		//check and update the chosen reservation date
		if (isset($request_data["date"])) {
			$request_data["date"] = strip_tags(addslashes($request_data["date"]));
			if (strlen($request_data["date"]) > 10) {
				error("Choose a valid reservation date", 400);
			}
			else {
				$date = $request_data["date"];
			}
		}
		else {
			$date = $spot_res["date"];
		}

		//update the category
		if (update_spot_res($spot_res_id, $spot, $res_from, $res_till, $date) === true) {
			http_response_code(201);
			echo "true";
		}
		else {
			error("An error occurred while saving the student data.", 500);
		}

		return $response;
		});

?>
