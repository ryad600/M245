<?php
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

	/**
     * @OA\put(
     *     path="/Category/{category_id}",
     *     summary="Edits an existing category.",
     *     tags={"Categories"},
     *         @OA\Parameter(
     *         name="category_id",
     *         in="path",
     *         required=true,
     *         description="Used to find the specified category.",
     *         @OA\Schema(
     *             type="integer",
     *             example="1"
     *         )
     *     ),
     *     requestBody=@OA\RequestBody(
     *         request="/Category/{category_id}",
     *         required=true,
     *         description="The Category information is passed to the server via the request body.",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="active", type="boolean", example="1"),
     *                 @OA\Property(property="name", type="string", example="electronics")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Category was succesfully updated."),
     * 	   @OA\Response(response="400", description="The client forgot to fill in the text fields"),
     *     @OA\Response(response="500", description="Internal server error.")
     * )
     */

	$app->put("/Category/{category_id}", function (Request $request, Response $response, $args) {
		//Check the client's authentication.
		require "controller/require_authentication.php";

		//Read request body input string.
		$request_body_string = file_get_contents("php://input");

		//Parse the JSON string.
		$request_data = json_decode($request_body_string, true);

		if (!check_category_id($args["category_id"])) {
			error("The category has not been found.", 404);
		}

		$category_id = intval($args["category_id"]);

		$category = get_one_category($category_id);


		if (!$category) {
			error("There is no category with the id '$category_id'.", 404);
		}
		else if (is_string($category)) {
			error($category, 500);
		}

		//check active

		if (isset($request_data["active"])) {
			
			if (!is_numeric($request_data["active"]) || $request_data["active"] > 2) {
				error("Please enter 1 for active or a 0 for not active in the active field.", 400);
			}
			$active = $request_data["active"];
		}
		else {
			$active = $category["active"];
		}

		//check name

		if (isset($request_data["name"])) {
			$name = strip_tags(addslashes($request_data["name"]));

			if (strlen($name) > 500) {
				error("The name is too long. Please use less than 500 characers.", 400);
			}
		}
		else {
			$name = $category["name"];
		}

		
		//update the category

		if (update_category($category["category_id"], $active, $name) === true) {
			http_response_code(201);
			echo "true";
		}
		else {
			error("An error occurred while saving the student data.", 500);
		}

		return $response;
		});

?>
