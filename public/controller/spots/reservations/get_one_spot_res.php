<?php
	
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

	/**
     * @OA\get(
     *     path="/Category/{category_id}",
     *     summary="Gets you the specified category.",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="category_id",
     *         in="path",
     *         required=true,
     *         description="Used to find the specified category..",
     *         @OA\Schema(
     *             type="interger",
     *             example="1"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Category was succesfully fetched"),
     *     @OA\Response(response="404", description="The category with the specified ID was not found."),
     *     @OA\Response(response="500", description="Internal server error.")
     * )
	 */


	$app->get("/Category/{category_id}", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$category = get_one_category($args["category_id"]);

		if (is_string($category)) {
			error($categorys, 500);
		}
		else if (!$category) {
			error("There exists no category with the id '" . $args["category_id"] . "'.", 404);
		}
		else {
			echo json_encode($category);
		}
		return $response;
	});

?>