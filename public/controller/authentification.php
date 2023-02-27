<?php

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;
	use ReallySimpleJWT\Token;

/**
     * @OA\Post(
     *     path="/Login",
     *     summary="Client can authenticate themself with username and password and get a token.",
     *     tags={"Authentication"},
     *     requestBody=@OA\RequestBody(
     *         request="/Login",
     *         required=true,
     *         description="username and password are needed.",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="username", type="string", example="root"),
     *                 @OA\Property(property="password", type="string", example="sec!ReT423*&")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Authentication succesful."),
     * 	   @OA\Response(response="401", description="invalid Credentials."))
     * )
	*/


	$app->post("/Login", function (Request $request, Response $response, $args) {
		global $api_username;
		global $api_password;

		//Read request body input string.
		$request_body_string = file_get_contents("php://input");

		//Parse the JSON string.
		$request_data = json_decode($request_body_string, true);

		$username = $request_data["username"];
		$password = $request_data["password"];

		//If either the username or the password is incorrect, return a 401 error.
		if ($username != $api_username || $password != $api_password) {
			error("Invalid credentials.", 401);
		}

		//Generate the access token and store it in the cookies.
		$token = Token::create($username, $password, time() + 3600, "localhost");

		setcookie("token", $token);

		//Echo true for a successful response.
		echo "true";

		return $response;
	});
?>
