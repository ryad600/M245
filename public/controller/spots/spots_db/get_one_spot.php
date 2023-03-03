<?php
	
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;


	$app->get("/Parking_spot/{spot_id}", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$spot = get_one_spot($args["spot_id"]);

		if (is_string($spot)) {
			error($spot, 500);
		}
		else if (!$spot) {
			error("There exists no parking spot with the id '" . $args["spot_id"] . "'.", 404);
		}
		else {
			echo json_encode($category);
		}
		return $response;
	});

?>