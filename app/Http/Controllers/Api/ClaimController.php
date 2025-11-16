<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\ClaimResource;
use App\Http\Requests\ClaimRequest;
use App\Http\Requests\UpdateClaimR;
use App\Policies\ClaimPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class ClaimController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $claims = Claim::query();

        if($request->has('title')){
            $claims->where('title', 'like', '%' . $request->title . '%');
        }
        $key = $request->has('title') ? 'search_claims_' . md5($request->title) : 'all_claims';

        $c = Cache::remember($key, 60 , function () use ($claims){
            return ClaimResource::collection($claims);
        });

        $c = $claims->latest()->paginate(10);
        return ClaimResource::collection($c);
    }    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(ClaimRequest $request)
    {
        $request->validated();
        if($request->hasFile('file_path')){
            $file_path = $request->file('file_path')->store('claims', 'public');
        }else{
            $file_path = null;
        }

        $claim = Claim::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $file_path,
            'user_id' => auth()->id(),
        ]);
        Cache::flush();
        return new ClaimResource($claim);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClaimR $request, $id)
    {
        try{
            $claim = Claim::findOrFail($id);
            $this->authorize('self', $claim);
            $claim->update($request->validated());
            Cache::flush();
            return new ClaimResource($claim);
        }catch(\Exception $e){
            return response()->json(['Error' => '404 Not Found!']);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $claim = Claim::findOrFail($id);
            $this->authorize('self', $claim);
            if($claim->file_path && Storage::disk('public')->exists($claim->file_path)){
                Storage::disk('public')->delete($claim->file_path);
            }
    
            $claim->delete();
            Cache::flush();
            return response()->json(['message' => 'Claim Deleted Successfully!']);
        }catch(\Exception $e){
            return response()->json(['Error' => '404 Not Found!']);
        }
    }    

}
