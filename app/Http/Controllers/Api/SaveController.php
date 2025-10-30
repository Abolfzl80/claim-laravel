<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SaveClaim;
use App\Models\Claim;
use App\Http\Resources\SaveResource;

class SaveController extends Controller
{
    public function index(Request $request)
    {
        try{
            $s = SaveClaim::where('user_id', $request->user()->id)->get();
            return SaveResource::collection($s);
        }catch(\Exception $e){
            return response()->json(['Error' => "$e"]);
        }
    }

    public function store(Request $request, $id)
    {
        $ss = SaveClaim::where('claim_id', $id)->where('user_id', $request->user()->id)->first();
        if($ss){
            return response()->json(['message' => 'you save it before!']);
        }
        $c = Claim::findOrFail($id);
        $u = $request->user();
        SaveClaim::create([
            'claim_id' => $id,
            'user_id' => $u->id,
        ]);
        return response()->json(['message' => 'saved Successfully']);
    }

    public function show(Request $request, $id)
    {
        try{
            $si = SaveClaim::findOrFail($id);
            if($si->user_id == $request->user()->id){
                return new SaveResource($si);
            }
            return response()->json(['Error' => 'NOT FOUND!!']);
        }catch(\Exception $e){
            return response()->json(['Error' => 'NOT FOUND!!']);
        }
    }

    public function destroy(Request $request, $id)
    {
        try{
            $si = SaveClaim::findOrFail($id);
            if($si->user_id == $request->user()->id){
                $si->delete();
                return response()->json(['message' => 'deleted Successfully!']);
            }
        }catch(\Exception $e){
            return response()->json(['Error' => 'NOT FOUND!!']);
        }
    }
}