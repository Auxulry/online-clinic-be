<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Queue\QueueRequest;
use App\Models\Poli;
use App\Models\UserPoli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QueueController extends ApiController
{
    public function createQueue(QueueRequest $request)
    {
        $poli = Poli::where('id', $request->poli_id)->first();

        if (!$poli) {
            throw new NotFoundHttpException(json_encode([
                'message' => 'Poli not found',
            ]));
        }

        $count = UserPoli::where('poli_id', $poli->id)->count();

        $userPoli = UserPoli::where('user_id', $request->user()->id)->where('poli_id', $poli->id)->whereDate('date', Carbon::parse($request->date)->format('Y-m-d'))->first();

        if ($userPoli) {
            throw new NotFoundHttpException(json_encode([
                'message' => 'Antrian di tanggal ' . Carbon::parse($request->date)->format('Y-m-d') . ' untuk ' . $poli->name . ' mencapai maksimum.',
            ]));
        }

        UserPoli::create([
            'user_id' => $request->user()->id,
            'poli_id' => $poli->id,
            'date' => Carbon::parse($request->date)->format('Y-m-d'),
            'number' => $count + 1
        ]);

        return $this->successResponse(Response::HTTP_CREATED, 'Queue Successfully Created',[]);
    }

    public function getQueue(Request $request)
    {
        $queue = UserPoli::where('user_id', $request->user()->id)->orderBy('created_at', 'asc')->with(['poli'])->first();

        if (!$queue) {
            return $this->successResponse(Response::HTTP_OK, 'Get Queue Successfully',[]);
        }

        return $this->successResponse(Response::HTTP_OK, 'Get Queue Successfully', $queue);
    }
}
