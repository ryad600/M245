<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

	/**
     * @OA\Post(
     *     path="/Room",
     *     summary="Creates new Room.",
     *     tags={"Rooms"},
     *     requestBody=@OA\RequestBody(
     *         request="/Room",
     *         required=true,
     *         description="The Room information is passed to the server via the request body.",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="room", type="string", example="banana-bread"),
     *                 @OA\Property(property="story", type="int", example="1"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="201", description="Room was succesfully created."),
     * 	   @OA\Response(response="400", description="The client forgot to fill in the text fields"),
     *     @OA\Response(response="500", description="Internal server error.")
     * )
     */

	$app->post("/Room", function (Request $request, Response $response, $args) {
		//Check the client's authentication.
		require "controller/require_authentication.php";

		//Read request body input string.
		$request_body_string = file_get_contents("php://input");

		//Parse the JSON string.
		$request_data = json_decode($request_body_string, true);

		//Check if all values are provided.
		if (!isset($request_data["room"])) {
			error("room", 400);
		}
		if (!isset($request_data["story"]) || !is_numeric($request_data["story"])) {
			error("story", 400);
		}


		//Clean up all unnecessary tags and add backslashes to safe your database.
		$room	= strip_tags(addslashes($request_data["room"]));
		$story	= $request_data["story"];

		//make sure nothing is empty and make sure that the id category exists.
		if (empty($room) === false) {
			echo $room;
			error("The 'room' field must not be empty.", 400);
		}
		if (empty($story)) {
			error("The 'story' field must not be empty.", 400);
		}
		if (create_new_room($room, $story) === true) {
			http_response_code(201);
			echo "true";
		}
		else {
			error("An error occurred while saving the student data.", 500);
		}

		return $response;
		});

?>