<?php

namespace App\Http\Controllers\Admin;

use App\Promotion;
use Illuminate\Http\Request;

class PromotionsParticipantsController extends Controller
{
    protected $promotion;
    protected $promotionId;

    public function __construct(Request $request, Promotion $promotion)
    {
        parent::__construct();
        
        $this->promotionId = filter_var($request->query('pm', $request->get('promotion_id')));
        $this->promotion = $promotion;
    }

    protected function getPromotion()
    {
        return $this->promotion->with('participants', 'page')->find($this->promotionId);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ((bool) !strlen($this->promotionId)) {
            return back()->with('info', 'Nenhuma promoção selecionada');
        }

        $page = $this->getPromotion()->page;
        $records = $this->getPromotion()->participants->sortByDesc(function ($item) {
            return is_null($item['drawn']) ? $item['id'] : $item['drawn']->timestamp;
        })->paginate();
        $promotion = $this->getPromotion();

        return view('admin.promotionsparticipants.index', compact('page', 'records', 'promotion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ((bool) !strlen($this->promotionId)) {
            return back()->with('info', 'Nenhuma promoção selecionada');
        }

        $participants = $this->getPromotion()->participants;
        $qtd = $request->input('qtd');

        /* if ($participants->whereNotNull('drawn')->isNotEmpty()) {
            return back()->with('info', 'Esse sorteio já foi realizado');
        } */

        if ($qtd > $participants->count()) {
            return back()->with('info', 'A quantidade de participantes a serem sorteados é maior do que a de participantes disponíveis para sorteio');
        }

        // Sorteados
        $drawn = collect([]);

        for ($i = 0; $i < $qtd; $i++) {
            if ($drawn->isNotEmpty()) {
                $drawn->push($participants->whereNotIn('id', $drawn->pluck('id'))->shuffle()->first());
            } else {
                $drawn->push($participants->shuffle()->first());
            }
        }
        
        $drawn->map(function ($item) {
            $item->update(['drawn' => now()]);
        });

        if ($drawn->isNotEmpty()) {
            return back()->with('success', 'Sorteio finalizado com sucesso');
        } else {
            return back()->with('info', 'O sorteio foi finalizado sem nenhum ganhador');
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $record = $this->getPromotion()->participants()->find($id);
        return view('admin.promotionsparticipants.show', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $page = $this->getPromotion()->page;
        $record = $this->getPromotion()->participants()->find($id);

        if (is_null($record)) {
            return redirect()->route($this->className() . '.index')->withInfo(config('app.admin.messages.id_not_found'));
        }
        
        $promotion = $this->getPromotion();
        return view('admin.promotions.form', compact('page', 'record', 'promotion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, string $id)
    {
        $id = explode(',', filter_var($id, FILTER_SANITIZE_STRING));

        $data = $this->getPromotion()->participants()
            ->whereIn('id', $id)
            ->get()
            ->each(function ($item) use ($request) {  
                $item->fill($request->input())->save();
            });

        return $this->redirectRoute($request, $id, false, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $id = explode(',', filter_var($id, FILTER_SANITIZE_STRING));

        $this->getPromotion()->participants()->destroy($id);

        return back()->withSuccess(config('app.admin.messages.success'));
    }
}
