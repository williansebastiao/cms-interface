<?php

namespace App\Http\Middleware;

use Closure;
use App\Entities\Device;

class CheckDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($request['device_id'])) {
            $device = Device::find($request['device_id']);
            if (!$device) {
                $device = Device::create(['id' => $request['device_id']]);
            }
        }
        return $next($request);
    }
}
