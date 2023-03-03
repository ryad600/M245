<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;


	$app->get("/Parking_spots", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$spots = get_all_spots();

		if (is_string($spots)) {
			error($spots, 500);
		}
		else {
			echo json_encode($spots);
		}
		return $response;
	});
?>