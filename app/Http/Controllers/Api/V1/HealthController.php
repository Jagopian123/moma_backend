<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    public function check(): JsonResponse
    {
        $dbStatus = 'ok';

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            $dbStatus = 'error';
        }

        return response()->json([
            'success' => true,
            'status'  => 'ok',
            'version' => 'v1',
            'app'     => config('app.name'),
            'env'     => config('app.env'),
            'db'      => $dbStatus,
            'time'    => now()->toIso8601String(),
        ]);
    }
}