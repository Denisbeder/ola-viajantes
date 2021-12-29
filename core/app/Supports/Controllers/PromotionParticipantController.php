<?php

namespace App\Supports\Controllers;

use Illuminate\Http\Request;
use App\PromotionParticipant;
use App\Notifications\PromotionParticipantNotification;
use Riverskies\Laravel\MobileDetect\Facades\MobileDetect;

class PromotionParticipantController extends Controller
{
    protected $model;

    public function __construct(PromotionParticipant $model)
    {
        $this->model = $model;
    }

    public function save(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'data.*' => 'filled',
        ]);

        $input = $request->merge([
            'promotion_id' => decrypt($request->input('id')),
            'ip' => $request->ip(),
            'device' => $request->userAgent(),
            'is_mobile' => MobileDetect::isMobile(),
            'publish' => 1,
        ])->input();
        
        $create = $this->model->updateOrCreate([
            'promotion_id' => decrypt($request->input('id')),
            'ip' => $request->ip()
        ], $input);

        $create->notify(new PromotionParticipantNotification);

        return response()->json([
            'success' => true,
            'text' => 'Sua participação foi registrada com sucesso. Boa sorte!',
            'data' => $create->toArray()
        ]);
    }
}
