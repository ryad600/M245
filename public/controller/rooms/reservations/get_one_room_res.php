<?php
	
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;


	/**
     * @OA\get(
     *     path="/Product/{product_id}",
     *     summary="Gets you the specified product.",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="product_id",
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

	$app->get("/Room_reservation/{room_res_ID}", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$room_res = get_one_room($args["room_res_ID"]);

		if (is_string($room_res)) {
			error($room_res, 500);
		}
		else if (!$room_res) {
			error("There exists no product with the id '" . $args["room_res_ID"] . "'.", 404);
		}
		else {
			echo json_encode($product);
		}
		return $response;
	});
?>