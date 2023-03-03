<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;


	$app->get("/Spot_reservations", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$spots_res = get_all_spots_res();

		if (is_string($spots_res)) {
			error($spots_res, 500);
		}
		else {
			echo json_encode($spots_res);
		}
		return $response;
	});
?>