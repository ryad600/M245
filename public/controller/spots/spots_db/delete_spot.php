<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;


	
	$app->delete("/Parking_spots/{spot}", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$args["spot"] = strip_tags(addslashes($args["spot"]));

		$spot = delete_spot($args["spot"]);

		if (is_string($spot)) {
			error($spot, 500);
		}
		else if (!$spot) {
			error("There exists no spot with the ID '" . $args["spot"] . "'.", 404);
		}
		else {
			echo json_encode($spot);
		}
		return $response;
	});
?>