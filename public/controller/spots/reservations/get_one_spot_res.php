<?php
	
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;


	$app->get("/Spot_reservation/{spot_res_id}", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$spot_res_id = get_one_spot_res($args["spot_res_id"]);

		if (is_string($spot_res_id)) {
			error($spot_res_id, 500);
		}
		else if (!$spot_res_id) {
			error("There exists no category with the id '" . $args["spot_res_id"] . "'.", 404);
		}
		else {
			echo json_encode($spot_res_id);
		}
		return $response;
	});
?>