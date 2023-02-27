<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

	/**
     * @OA\post(
     *     path="/Category",
     *     summary="Creates new category.",
     *     tags={"Categories"},
     *     requestBody=@OA\RequestBody(
     *         request="/Category",
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
     *     @OA\Response(response="201", description="Category was succesfully created."),
     * 	   @OA\Response(response="400", description="The client forgot to fill in the text fields"),
     *     @OA\Response(response="500", description="Internal server error.")
     * )
     */



	$app->post("/Category", function (Request $request, Response $response, $args) {
		//Check the client's authentication.
		require "controller/require_authentication.php";

		//Read request body input string.
		$request_body_string = file_get_contents("php://input");

		//Parse the JSON string.
		$request_data = json_decode($request_body_string, true);

		//Check if all values are provided.
		if (!isset($request_data["active"])) {
			error("The field active must have a value", 400);
		}
		if (!isset($request_data["name"])) {
			error("The field name musst have a value.", 400);
		}

		if (strlen($request_data["name"]) > 500 ) {
			error("The field name can't have more than 500 characters.", 400);
		}
		if ($request_data["active"] > 1) {
			error("The field active can only be 1 or 0.", 400);
		}

		//Clean up all unnecessary tags and add backslashes to safe your database.
		$active 		= $request_data["active"];
		$name 			= strip_tags(addslashes($request_data["name"]));

		//make sure nothing is empty and make sure that the id category exists.
		if (empty($name)) {
			error("The 'name' field must not be empty.", 400);
		}

		if (create_new_category($active, $name) === true) {
			http_response_code(201);
			echo "true";
		}
		else {
			error("An error occurred while saving the student data.", 500);
		}

		return $response;
		});

?>