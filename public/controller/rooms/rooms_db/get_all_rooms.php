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

	$app->get("/Products", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$products = get_all_products();

		if (is_string($products)) {
			error($products, 500);
		}
		else {
			echo json_encode($products);
		}
		return $response;
	});
?>