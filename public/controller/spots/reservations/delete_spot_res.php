<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

	
	$app->delete("/Spot_reservation/{spot_res_id}", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$args["spot_res_id"] = strip_tags(addslashes($args["spot_res_id"]));

		$spot_res_id = delete_spot_res($args["spot_res_id"]);

		if (is_string($spot_res_id)) {
			error($spot_res_id, 500);
		}
		else if (!$spot_res_id) {
			error("There exists no category with the id '" . $args["spot_res_id"] . "'.", 404);
		}
		else {
			echo json_encode($category);
		}
		return $response;
	});
?>