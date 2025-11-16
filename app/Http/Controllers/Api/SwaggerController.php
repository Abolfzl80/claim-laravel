<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="My Laravel API Documentation",
 *      description="This is the Swagger/OpenAPI documentation for my Laravel app",
 *      @OA\Contact(
 *          email="you@example.com"
 *      ),
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Main API Server"
 * )
 */

class SwaggerController extends Controller
{
    //
}
