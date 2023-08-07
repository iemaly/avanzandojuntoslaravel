<?php

namespace App\Http\Middleware;

use Closure;

class CheckOwnership
{
    public function handle($request, Closure $next, $model, $ownershipField)
    {
        $authenticatedUserId = auth()->id();
        $modelClass = "App\\Models\\" . str_replace(' ', '', ucwords(str_replace('_', ' ', $model)));
        $modelInstance = $modelClass::findOrFail($request->route($model));
        if ($modelInstance->$ownershipField !== $authenticatedUserId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        return $next($request);
    }
}


