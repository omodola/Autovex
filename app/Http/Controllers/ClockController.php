<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ClockActions;
use App\Models\Clock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class ClockController extends Controller
{
    use ClockActions;

    private const CLOCK_NOT_FOUND = 'Preset time not found';

    public function retrieve(Request $request): JsonResponse|Redirector|RedirectResponse|Application
    {
        $clock = $this->getUserClock();
        if($clock){
            return $this->sendClockResponse($clock, 200);
        }

        return $this->sendNotFoundClockResponse($request, self::CLOCK_NOT_FOUND);
    }

    public function create(Request $request): JsonResponse
    {
        $clock = $this->getUserClock();
        if($clock === null){

            $request->validate([
                'time_difference_seconds' => 'required|numeric',
            ]);

            $data = $request->all();
            $data['user_id'] = Auth::guard('api')->id();
            $clock = Clock::create($data);
        }

        return $this->sendClockResponse($clock, 201);
    }

    public function update(Request $request): JsonResponse|Redirector|RedirectResponse|Application
    {
        $clock = $this->getUserClock();
        if($clock){

            $request->validate([
                'time_difference_seconds' => 'required|numeric',
            ]);

            $clock->update($request->all());

            return $this->sendClockResponse($clock, 200);
        }

        return $this->sendNotFoundClockResponse($request, self::CLOCK_NOT_FOUND);
    }

    public function delete(Request $request): JsonResponse|Redirector|RedirectResponse|Application
    {
        $clock = $this->getUserClock();
        if($clock){
            $clock->delete();

            return response()->json(null, 204);
        }

        return $this->sendNotFoundClockResponse($request, self::CLOCK_NOT_FOUND);
    }

    public function display(Request $request): JsonResponse
    {
        $clock = $this->getUserClock();
        $time = $this->getDisplayTime($clock);

        return response()->json(['data' => $time]);
    }
}
