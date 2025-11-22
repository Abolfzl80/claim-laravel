<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reaction;
use App\Models\Claim;
use App\Http\Requests\ReactionRequest;
use App\Http\Resources\ReactionResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Jobs\sendReactionNot;

class ClaimReactionController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $summary = \DB::table('reactions')
            ->select('claim_id', 'emoji', \DB::raw('count(*) as count'))
            ->groupBy('claim_id', 'emoji')
            ->get();

        return response()->json($summary);
    }

    public function store(ReactionRequest $request, $id)
    {   
        $request->validated();
        $user = $request->user(); 
    
        $existing = Reaction::where('claim_id', $request->claim_id)->where('user_id', $user->id)->where('emoji', $request->emoji)->first();
        if($existing){
            return response()->json(['message' => 'You already reacted with this emoji']);
        }
    
        $reaction = Reaction::create([
            'claim_id' => $id,
            'user_id' => auth()->id(),
            'emoji' => $request->emoji,
        ]);
        dispatch(new sendReactionNot($reaction->id))->onQueue('high');
        return new ReactionResource($reaction);
    }
    
    public function destroy($id)
    {
        try{
            $reaction = Reaction::findOrFail($id);
            $this->authorize('self', $reaction);
            $reaction->delete();
            return response()->json(['message' => 'removed reaction!']);
        }catch(\Exception $e){
            return response()->json(['message' => 'Not reaction found']);
        }
    }
}