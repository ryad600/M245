<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

	/**
     * @OA\Delete(
     *     path="/Category/{category_id}",
     *     summary="Deletes the category with the same category id.",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="category_id",
     *         in="path",
     *         required=true,
     *         description="Used to identfy which category the client wants to delete.",
     *         @OA\Schema(
     *             type="interger",
     *             example="1"
     *         )
     *     ),
     *     @OA\Response(response="200", description="category was succesfully deleted"),
     * 	   @OA\Response(response="400", description="The client forgot to fill in the text fields"),
     *     @OA\Response(response="404", description="The category that the client was searching for was not found."),
     *     @OA\Response(response="500", description="Internal server error.")
     * )
	 */


	
	$app->delete("/Category/{category_id}", function (Request $request, Response $response, $args) {

		//Check the client's authentication.
		require "controller/require_authentication.php";

		$args["category_id"] = strip_tags(addslashes($args["category_id"]));

		$category = delete_category($args["category_id"]);

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