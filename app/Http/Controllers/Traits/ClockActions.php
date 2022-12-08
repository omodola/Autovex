<?php
declare(strict_types=1);
namespace App\Http\Controllers\Traits;

use App\Models\Clock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ClockActions
{
    public function getUserClock(): ?Clock
    {
        $user = Auth::guard('api')->user();
        $clock = null;
        if($user){
            $userId = Auth::guard('api')->id();
            $clock = Clock::where('user_id', $userId)->first();
        }

        return $clock;
    }

    public function getDisplayTime(?Clock $clock=null): string
    {
        if($clock === null){
            $clock = $this->getUserClock();
        }

        $timeDifference = (string) ($clock->time_difference_seconds ?? 0);
        $sign = str_contains($timeDifference, '-') ? '-': '+';
        $timeDifference = str_replace(['-','+'], '', $timeDifference);

        return gmdate('c', strtotime("$sign $timeDifference seconds"));
    }

    public function sendNotFoundClockResponse(Request $request, string $message): Redirector|Application|RedirectResponse
    {
        if($request->wantsJson()){
            throw new NotFoundHttpException($message);
        }

        return redirect('/home')->with('status', $message);
    }

    public function sendClockResponse(Clock $clock, $statusCode): JsonResponse
    {
        $clock->display_time = $this->getDisplayTime($clock);
        return response()->json(['data' => $clock->toArray()], $statusCode);
    }
}
