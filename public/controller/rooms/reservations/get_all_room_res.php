<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

	/**
     * @OA\Get(
     *     path="/Products",
     *     summary="Get a list of all products",
     *     tags={"Products"},
     *     @OA\Response(response="200", description="Prodcut list was succesfully fetched."),
     *     @OA\Response(response="404", description="There were no Products found."),
     *     @OA\Response(response="500", description="Internal server error.")
     * )	   
 	 */

	$app->get("/Room_reservation", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$rooms = get_all_room_reservation();

		if (is_string($rooms)) {
			error($rooms, 500);
		}
		else {
			echo json_encode($rooms);
		}
		return $response;
	});
?>