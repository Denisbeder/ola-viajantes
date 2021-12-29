<?php

namespace App\Supports\Controllers;

use App\PollVote;
use App\PollOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Supports\Services\PurgeNginxCacheService;
use Riverskies\Laravel\MobileDetect\Facades\MobileDetect;

class PollsController extends Controller
{
    protected $model;

    public function save(Request $request, int $id)
    {
        $optionId = filter_var($request->input('option'));
        $visitorId = filter_var($request->input('visitor_id'));

        if (!(bool) strlen($optionId) || !(bool) strlen($visitorId)) {
            return response()->json([
                'success' => false,
                'text' => 'Não conseguimos validar o voto. Atualize a página e tente novamente.',
                'data' => []
            ]);
        }

        $dataOption = PollOption::with(['poll', 'poll.options'])->find($optionId);
        $pollId = $dataOption->poll->id;
        $dataVote = PollVote::doNotCache()->firstOrNew([
            //'ip' => $request->ip(),
            'visitor_id' => $visitorId,
            'poll_id' => $pollId,
        ]);

        if ($dataVote->exists) {
            return response()->json([
                'success' => false,
                'text' => 'Você já participou dessa enquete.',
                'data' => [
                    'options' => $dataOption->poll->options,
                    'votes_total' => $dataOption->poll->votes_count
                ]
            ]);
        }

        $save = $dataOption->votes()->create([
            'poll_id' => $pollId,
            'ip' => $request->ip(),
            'visitor_id' => $visitorId,
            'device' => $request->userAgent(),
            'is_mobile' => MobileDetect::isMobile(),
        ]);

        $this->flushCache();

        return response()->json([
            'success' => true,
            'text' => 'Seu voto foi salvo com sucesso. Agradecemos sua participação.',
            'data' => [
                'options' => $save->poll->options,
                'votes_total' => $save->poll->votes_count
            ]
        ]);
    }

    protected function flushCache()
    {
        Artisan::call('page-cache:clear');
        (new PurgeNginxCacheService)->purgeAll();
    }
}
