<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    /**
        * @OA\Put(
        *     path="/Product/{sku}",
        *     summary="Updates or creates and then returns the product object for the given SKU.",
        *     tags={"Product"},
        *     @OA\Parameter(
        *         name="SKU",
        *         in="path",
        *         required=true,
        *         description="The SKU of the product.",
        *         @OA\Schema(
        *             type="string",
        *             example=60003291
        *         )
        *     ),
        *     requestBody=@OA\RequestBody(
        *         request="/Product/{sku}",
        *         required=true,
        *         description="A product object. Must not have an sku property.",
        *         @OA\MediaType(
        *             mediaType="application/json",
        *             @OA\Schema(
        *                 @OA\Property(property="active", type="integer", example="1"),
        *                 @OA\Property(property="id_category", type="integer", example="1"),
        *                 @OA\Property(property="name", type="string", example="Nice Product"),
        *                 @OA\Property(property="product_image", type="string", example="/path/to/image.png"),
        *                 @OA\Property(property="description", type="string", example="This is a very fine product with some awesome features."),
        *                 @OA\Property(property="price", type="decimal", example="9.95"),
        *                 @OA\Property(property="available_stock", type="integer", example="17")
        *             )
        *         )
        *     ),
        *     @OA\Response(response="200", description="Success"),
        *     @OA\Response(response="404", description="Not found")
        * )
        */
        $app->put("/Room/{room}", function (Request $request, Response $response, $args) {
            require "util/authentication.php";
            require "model/rooms_db.php";
            return $response;
        });
?>