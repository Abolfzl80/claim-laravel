<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Challenge;
use App\Models\User;
use App\Http\Requests\ChallenegeRequest;
use Carbon\Carbon;
use App\Policies\challengePolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\NotificationChallenge;

class ChallenegeController extends Controller
{
    use AuthorizesRequests;

    public function store(ChallenegeRequest $request, $id)
    {
        $user = $request->user();
        $request->validated();

        $exi = Challenge::where('user_one_id', $user->id)->where('user_two_id', $request->user_two_id)->where('status', 'waiting')
                        ->orWhere('user_one_id', $request->user_two_id)->where('user_two_id', $user->id)->where('status', 'waiting')->first();

        if($exi){
            return response()->json([
                'message' => 'you have request already before!, wait fore accept or exprie',
            ]);
        }

        $c = Challenge::create([
            'claim_id' => $id,
            'user_one_id' => $user->id,
            'user_two_id' => $request->user_two_id,
        ]);

        $user = User::find($request->user_two_id);
        $user->notify(new NotificationChallenge($c));
        return response()->json(['message' => 'successfuly send request challenge!']);        
    }

    public function accept($id)
    {
        try{
            $c = Challenge::findOrFail($id);
            $this->authorize('theyare', $c);

            if($c->created_at->diffInMinutes(now()) > 5){
                $c->update([
                    'status' => 'expried',
                ]);
                return response()->json(['message' => 'this challenege is expried']);
            }

            $c->update([
                'status' => 'matching',
            ]);
            return response()->json(['message' => 'accepted the challenge, join it!']);
        }catch(\Exception $e){
            return response()->josn(['Error' => '404 Not Found!']);
        }

    }

    public function reject($id)
    {
        try{
            $c = Challenge::findOrFail($id);
            $this->authorize('theyare', $c);

            if($c->created_at->diffInMinutes(now()) > 5){
                $c->update([
                    'status' => 'expried',
                ]);
                return response()->json(['message' => 'this challenege is expried']);
            }

            $c->update([
                'status' => 'canceled',
            ]);
            return response()->json(['message' => 'canceled the challenge!']);
        }catch(\Exception $e){
            return response()->josn(['Error' => '404 Not Found!']);
        }

    }
}
