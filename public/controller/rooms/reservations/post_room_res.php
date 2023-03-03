<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

	/**
     * @OA\Post(
     *     path="/Product",
     *     summary="Creates new product.",
     *     tags={"Products"},
     *     requestBody=@OA\RequestBody(
     *         request="/Product",
     *         required=true,
     *         description="The Product information is passed to the server via the request body.",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="sku", type="string", example="banana-bread"),
     *                 @OA\Property(property="active", type="boolean", example="1"),
     * 				   @OA\Property(property="id_category", type="integer", example="2"),
     * 				   @OA\Property(property="name", type="string", example="cheese"),
     *                 @OA\Property(property="image", type="string", example="link"),
     * 				   @OA\Property(property="description", type="string", example="this is cheese"),
     * 				   @OA\Property(property="price", type="float", example="5"),
     * 				   @OA\Property(property="stock", type="integer", example="120")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="201", description="Product was succesfully created."),
     * 	   @OA\Response(response="400", description="The client forgot to fill in the text fields"),
     *     @OA\Response(response="500", description="Internal server error.")
     * )
     */

	$app->post("/Room_reservation/post", function (Request $request, Response $response, $args) {
		//Check the client's authentication.
		require "controller/require_authentication.php";

		//Read request body input string.
		$request_body_string = file_get_contents("php://input");

		//Parse the JSON string.
		$request_data = json_decode($request_body_string, true);

		//Check if all values are provided.
		if (!isset($request_data["sku"])) {
			error("sku", 400);
		}
		if (!isset($request_data["active"]) || !is_bool($request_data["active"])) {
			error("active", 400);
		}
		if (!isset($request_data["id_category"]) || $request_data["id_category"] == false || $request_data["id_category"] == null || $request_data["id_category"] == 0) {
			$request_data["id_category"] = "NULL";
		}
		if (!isset($request_data["name"])) {
			error("name", 400);
		}
		if (!isset($request_data["image"])) {
			error("image", 400);
		}
		if (!isset($request_data["description"])) {
			error("description", 400);
		}
		if (!isset($request_data["price"]) || !is_numeric($request_data["price"])) {
			error("price", 400);
		}
		if (!isset($request_data["stock"]) || !is_numeric($request_data["stock"])) {
			error("stock", 400);
		}


		//Clean up all unnecessary tags and add backslashes to safe your database.
		$sku 			= strip_tags(addslashes($request_data["name"]));
		$active 		= $request_data["active"];
		$id_category	= $request_data["id_category"];
		$name 			= strip_tags(addslashes($request_data["name"]));
		$image 			= strip_tags(addslashes($request_data["image"]));
		$description 	= strip_tags(addslashes($request_data["description"]));
		$price 			= intval($request_data["price"]);
		$stock 			= intval($request_data["stock"]);

		//make sure nothing is empty and make sure that the id category exists.
		if (empty($sku)) {
			error("The 'sku' field must not be empty.", 400);
		}
		if (check_category_id($id_category) === false) {
			echo $id_category;
			error("This category doesn't exist, enter valid category or 0 for no category.", 400);
		}
		if (empty($name)) {
			error("The 'name' field must not be empty.", 400);
		}
		if (empty($image)) {
			error("The 'image' field must not be empty.", 400);
		}
		if (empty($description)) {
			error("The 'description' field must not be empty.", 400);
		}
		if (empty($price)) {
			error("The 'price' field must not be empty.", 400);
		}
		if (create_new_product($sku, $active, $id_category, $name, $image, $description, $price, $stock) === true) {
			http_response_code(201);
			echo "true";
		}
		else {
			error("An error occurred while saving the student data.", 500);
		}

		return $response;
		});

?>