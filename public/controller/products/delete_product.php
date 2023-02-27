<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;
	

	/**
     * @OA\Delete(
     *     path="/Product/{product_id}",
     *     summary="Deletes the product with the same product id.",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="path",
     *         required=true,
     *         description="Used to identfy which product the client wants to delete.",
     *         @OA\Schema(
     *             type="interger",
     *             example="1"
     *         )
     *     ),
     *     @OA\Response(response="200", description="product was succesfully deleted"),
     * 	   @OA\Response(response="400", description="The client forgot to fill in the text fields"),
     *     @OA\Response(response="404", description="The product that the client was searching for was not found."),
     *     @OA\Response(response="500", description="Internal server error.")
     * )
	 */	


	$app->delete("/Product/{product_id}", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$args["product_id"] = strip_tags(addslashes($args["product_id"]));

		//Delete the product
		$product = delete_product($args["product_id"]);


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