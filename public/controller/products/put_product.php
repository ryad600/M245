<?php
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

    /**
     * @OA\put(
     *     path="/Product/{product_id}",
     *     summary="Edits an existing product.",
     *     tags={"Products"},
     *         @OA\Parameter(
     *         name="product_id",
     *         in="path",
     *         required=true,
     *         description="Used to find the specified product.",
     *         @OA\Schema(
     *             type="integer",
     *             example="1"
     *         )
     *     ),
     *     requestBody=@OA\RequestBody(
     *         request="/Product/{product_id}",
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
     *     @OA\Response(response="200", description="Product was succesfully updated."),
     * 	   @OA\Response(response="400", description="The client forgot to fill in the text fields"),
     *     @OA\Response(response="500", description="Internal server error.")
     * )
     */

	$app->put("/Product/{product_id}", function (Request $request, Response $response, $args) {
		//Check the client's authentication.
		require "controller/require_authentication.php";

		//Read request body input string.
		$request_body_string = file_get_contents("php://input");

		//Parse the JSON string.
		$request_data = json_decode($request_body_string, true);

		if (!check_product_id($args["product_id"])) {
			error("The category has not been found.", 404);
		}


		$product_id = intval($args["product_id"]);

		$product = get_one_product($product_id);


		if (!$product) {
			error("There is no product with the id '$product_id'.", 404);
		}
		else if (is_string($product)) {
			error($product, 500);
		}

		//check sku

		if (isset($request_data["sku"])) {
			$sku = strip_tags(addslashes($request_data["sku"]));

			if (strlen($request_data["sku"]) > 100) {
				error("The SKU is too long. Please use less than 100 characers.", 400);
			}
		}
		else {
			$sku = $product["sku"];
		}

		//check active

		if (isset($request_data["active"])) {
			
			if (!is_numeric($request_data["active"]) || $request_data["active"] > 2) {
				error("Please enter 1 for active or a 0 for not active in the active field.", 400);
			}
			$active = $request_data["active"];
		}
		else {
			$active = $product["active"];
		}

		//check id_category

		if (isset($request_data["id_category"])) {

			if (!is_numeric($request_data["id_category"])) {
				error("Please enter a number in the id category field.", 400);
			}

			if ($request_data["id_category"] == 0) {
				$request_data["id_category"] = "NULL";
			}
			else if (!check_category_id($request_data["id_category"])) {
				error("This category doesn't exist", 404);
			}
			$id_category = $request_data["id_category"];
		}
		else {
			$id_category = $product["id_category"] ?? "NULL";
		}

		//check name

		if (isset($request_data["name"])) {
			$name = strip_tags(addslashes($request_data["name"]));

			if (strlen($name) > 500) {
				error("The name is too long. Please use less than 500 characers.", 400);
			}
		}
		else {
			$name = $product["name"];
		}

		//check image

		if (isset($request_data["image"])) {
			$image = strip_tags(addslashes($request_data["image"]));

			if (strlen($image) > 1000) {
				error("The image link is too long. Please use less than 1000 characers.", 400);
			}
		}
		else {
			$image = $product["image"];
		}

		//check description

		if (isset($request_data["description"])) {
			$description = strip_tags(addslashes($request_data["description"]));
		}
		else {
			$description = $product["description"];
		}

		//check price

		if (isset($request_data["price"])) {

			if (!is_numeric($request_data["price"])) {
				error("Please enter a nummber in the price field.", 400);
			}
			if (strlen($request_data["price"]) > 65) {
				error("Please enter a nummber with less than 65 characters", 400);
			}

			$price = $request_data["price"];
		}
		else {
			$price = $product["price"];
		}

		//check stock

		if (isset($request_data["stock"])) {
			if (!is_numeric($request_data["stock"])) {
				error("Please enter a nummber in the stock field.", 400);
			}
			$stock = $request_data["stock"];
		}
		else {
			$stock = $product["stock"];
		}

		//update the product

		if (update_product($product["product_id"], $sku, $active, $id_category, $name, $image, $description, $price, $stock) === true) {
			http_response_code(201);
			echo "true";
		}
		else {
			error("An error occurred while saving the student data.", 500);
		}

		return $response;
		});

?>
