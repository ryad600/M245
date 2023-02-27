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

	$app->get("/Product/{product_id}", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$product = get_one_product($args["product_id"]);

		if (is_string($product)) {
			error($products, 500);
		}
		else if (!$product) {
			error("There exists no product with the id '" . $args["product_id"] . "'.", 404);
		}
		else {
			echo json_encode($product);
		}
		return $response;
	});
?>