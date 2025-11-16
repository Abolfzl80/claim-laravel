<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\NotifResource;

class NotifController extends Controller
{
    public function index(Request $request)
    {
        $not = $request->user()->notifications()->paginate(10);
        return NotifResource::collection($not);
    }
}
