<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShortLink;
use Illuminate\Http\Request;
use App\Http\Requests\ShortLinksRequest;

class ShortLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userLinks = ShortLink::where('user_id', auth()->user()->id)->select('id', 'user_id', 'original_url', 'code', 'clicks','created_at')->get();
        return response()->json($userLinks);
    }

    public function destroy(ShortLink $shortLink)
    {
        if(auth()->user()->id === $shortLink->user_id)
        {
            $shortLink->delete();
            return response()->noContent();
        }

        return response()->json(['message' => 'Unauthorized access'], 401);
    }


    public function shorten(ShortLinksRequest $request)
    {
        $validatedData = $request->validated();

        if (!array_key_exists("code", $validatedData)) {
            $code = $this->generateRandomCode(10);
        } else {
            $code = $validatedData['code'];
        }

        $shortLink = ShortLink::create([
            'user_id' => $request->user()->id,
            'original_url' => $validatedData['original_url'],
            'code' => $code
        ]);

        return response()->json([
            'id' => $shortLink->id,
            'user_id' => $shortLink->user_id,
            'original_url' => $shortLink->original_url,
            'code' => $shortLink->code,
            'clicks' => 0,
            'created_at' => $shortLink->created_at
        ], 201);

    }

    public function redirectUrl($shortCode)
    {
        $shortLink = ShortLink::where('code', $shortCode)->first();

        if($shortLink && $shortLink->user_id === auth()->user()->id) {
            $shortLink->increment("clicks");

            return redirect($shortLink->original_url, 302);
        }

        return response()->json([
            "error" => "Unauthorized access"
        ], 403);
    }

    public function generateRandomCode($length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz-_';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $index = random_int(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
