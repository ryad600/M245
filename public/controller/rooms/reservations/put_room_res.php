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

	$app->put("/Room_reservation/put/{room_res_ID}", function (Request $request, Response $response, $args) {
		//Check the client's authentication.
		require "controller/require_authentication.php";

		//Read request body input string.
		$request_body_string = file_get_contents("php://input");

		//Parse the JSON string.
		$request_data = json_decode($request_body_string, true);

		if (!check_room_res_ID($args["room_res_ID"])) {
			error("The Room-Reservation has not been found.", 404);
		}
		$room_res = intval($args["room_res_ID"]);
		$room_res = get_one_room_res($room_res);

		if (!$room_res) {
			error("There is no Room-Reservation with the id '$room_res'.", 404);
		}
		else if (is_string($room_res)) {
			error($room_res, 500);
		}

		//check reserved

		if (isset($request_data["reserverd"])) {
			$reserved = strip_tags(addslashes($request_data["reserved"]));
			
			// Überprüfen, ob es sich bei dem Wert um eine boolsche oder eine ganze Zahl handelt
			if (filter_var($request_data["reserved"], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null && filter_var($request_data["reserved"], FILTER_VALIDATE_INT) === false) {
			error("Invalid value for 'reserved'. Please use 0, 1, true, or false.", 400);
			}

			// Falls der Wert eine boolsche Zahl ist, konvertieren Sie ihn in eine ganze Zahl.
			$reserved = filter_var($request_data["reserved"], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
			if ($reserved === null) {
				$reserved = (int) $request_data["reserved"];
			}
		} else {
			$reserved = $room_res["reserved"];
		}

		//check date (res_from)
		if (isset($request_data["res_from"])) {
			$res_from = strip_tags(addslashes($request_data["res_from"]));
		
			// Überprüfen, ob der Wert eine gültige Zeitdarstellung ist.
			if (strtotime($res_from) === false) {
				error("Invalid value for \"Reservation von\". Please use a valid time value.", 400);
			}
		} else {
			$res_from = $room_res["res_from"];
		}

		//check date (res_till)
		if (isset($request_data["res_till"])) {
			$res_till = strip_tags(addslashes($request_data["res_till"]));
		
			// Überprüfen, ob der Wert eine gültige Zeitdarstellung ist.
			if (strtotime($res_till) === false) {
				error("Invalid value for \"Reservation bis\". Please use a valid time value.", 400);
			}
		} else {
			$res_till = $room_res["res_till"];
		}
		
		// check date (date)
		if (isset($room_res["date"])) {
			// Überprüfen, ob der Wert ein gültiges Datum ist.
			if (!DateTime::createFromFormat('Y-m-d', $room_res["date"])) {
				error("Invalid value for \"date\". Please use a valid date value in the format YYYY-MM-DD.", 400);
			}
		} else {
			$date = $room_res["date"];
		}

		//check user
		if (isset($room_res["user"])) {
			$user = $room_res["user"];
			if (!is_string($user)) {
				error("Invalid value for \"user\". Please use a string value.", 400);
			}
		} else {
			$user = $room_res["user"];
		}

		//update the room_res

		if (update_room_res($room_res["room_res_ID"], $reseverd, $res_from, $res_till, $date, $user) === true) {
			http_response_code(201);
			echo "true";
		}
		else {
			error("An error occurred while saving the student data.", 500);
		}

		return $response;
		});
