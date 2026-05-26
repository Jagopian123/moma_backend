<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        DeviceToken::updateOrCreate(
            ['token' => $request->token],
            ['user_id' => $request->user()->id, 'platform' => 'android'],
        );

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        DeviceToken::where('user_id', $request->user()->id)
            ->where('token', $request->token ?? '')
            ->delete();

        return response()->json(['success' => true]);
    }
}
