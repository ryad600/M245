<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

	/**
     * @OA\Get(
     *     path="/Categories",
     *     summary="Get a list of all categories",
     *     tags={"Categories"},
     *     @OA\Response(response="200", description="Category list was succesfully fetched."),
     *     @OA\Response(response="404", description="There were no Categories found."),
     *     @OA\Response(response="500", description="Internal server error.")
     * )	   
 	 */


	$app->get("/Categories", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$categories = get_all_categories();

		if (is_string($categories)) {
			error($categories, 500);
		}
		else {
			echo json_encode($categories);
		}
		return $response;
	});
?>