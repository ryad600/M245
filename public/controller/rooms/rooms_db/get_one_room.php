<?php
	
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;


	/**
     * @OA\get(
     *     path="/Product/{room}",
     *     summary="Gets you the specified product.",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="room",
     *         in="path",
     *         required=true,
     *         description="Used for when the client needs to see info to one product.",
     *         @OA\Schema(
     *             type="interger",
     *             example="1"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Product was succesfully fetched"),
     *     @OA\Response(response="404", description="The product with the specified ID was not found."),
     *     @OA\Response(response="500", description="Internal server error.")
     * )
	 */

	$app->get("/Room/{room}", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$room = get_one_room($args["room"]);

		if (is_string($room)) {
			error($rooms, 500);
		}
		else if (!$room) {
			error("There exists no room with the id '" . $args["room"] . "'.", 404);
		}
		else {
			echo json_encode($room);
		}
		return $response;
	});
?>