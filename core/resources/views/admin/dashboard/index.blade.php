@extends('admin.__admin')

@section('content')

<div class="gap-20 row pos-r">
    @can('comments')
    @inject('comments', 'App\Comment')
    @php 
    $commentsRecents = $comments->when(!auth()->user()->isSuperAdmin, function ($query) {
        $query->whereHasMorph('commentable', '*', function ($query) {
            $allowedPagesId = collect(auth()->user()->permissions['pages'] ?? [])->map(function ($item) {
                return preg_replace('/[a-z]+|[A-Z]+|_/', '', $item);
            });
            $query->whereIn('page_id', $allowedPagesId);
        });
    })->latest('created_at')->limit(20)->get(); 
    @endphp
    @if($commentsRecents->isNotEmpty())
    <div class="col-md-6 col-12">
        <div class="bd bgc-white">
            <div class="layers">
                <div class="p-20 layer w-100">
                    <h6 class="lh-1">Comentários recentes</h6>
                </div>
                <div class="layer w-100">
                    <div class="table-responsive pT-0 pL-20 pR-20 pB-20">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="bdwT-0">Comentário</th>
                                    <th class="bdwT-0" style="width: 120px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($commentsRecents as $item)
                                <tr>
                                    <td class="text-break">
                                        {!! $item->present()->publishLabel !!} <br>
                                        {{ $item->name }} <br>
                                        {!! Str::limit(nl2br($item->text), 150) !!}<br>
                                        <small>
                                            <strong>{{ $item->created_at->diffForHumans() }}</strong>
                                            em <a href="{{ $item->commentable->present()->url }}" target="_blank">{{ $item->commentable->title }}</a>
                                        </small>                                            
                                    </td>
                                    <td class="text-right">
                                        {!! Form::open(['url' => route('comments.update', ['id' => $item->id]), 'method' => 'PUT']) !!}
                                        {!! Form::hidden('publish', $item->publish ? 0 : 1) !!}
                                        <button class="border btn btn-light btn-sm" title="{{ $item->present()->buttonPublishLabel }}">{{ $item->present()->buttonPublishLabel }}</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="p-20 ta-c bdT w-100">
                <a href="/admin/comments">Ir para comentários</a>
            </div>
        </div>
    </div>
    @endif
    @endcan

    @inject('adverts', 'App\Advert')
    @php 
    $advertsRecents = $adverts->when(!auth()->user()->isSuperAdmin, function ($query) {
        $allowedPagesId = collect(auth()->user()->permissions['pages'] ?? [])
        ->map(function ($item) {
            return preg_replace('/[a-z]+|[A-Z]+|_/', '', $item);
        });
        $query->whereIn('page_id', $allowedPagesId);
    })->latest('created_at')->limit(20)->get();    
    @endphp
    @if($advertsRecents->isNotEmpty())
    <div class="col-md-6 col-12">
        <div class="bd bgc-white">
            <div class="layers">
                <div class="p-20 layer w-100">
                    <h6 class="lh-1">Anúncios recentes</h6>
                </div>
                <div class="layer w-100">
                    <div class="table-responsive pT-0 pL-20 pR-20 pB-20">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="bdwT-0">Imagens</th>
                                    <th class="bdwT-0">Anúncio</th>
                                    <th class="bdwT-0" style="width: 120px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($advertsRecents as $item)
                                <tr>
                                    <td>{!! $item->present()->imgs(['width' => 30, 'height' => 30, 'fit' => 'crop', 'class' => 'rounded mr-1'], 3) !!}</td>
                                    <td class="text-break">
                                        {!! $item->present()->publishLabel !!} <br>
                                        <strong>Título:</strong> {{ $item->title }} <br>
                                        {!! Str::limit(nl2br($item->body), 150) !!}<br>
                                        <strong>Telefones:</strong> {{ implode(', ', $item->phones ?? []) }} <br>
                                        <small>
                                            <strong>{{ $item->created_at->diffForHumans() }}</strong>
                                            em <a href="{{ $item->present()->url }}" target="_blank">{{ $item->title }}</a>
                                        </small>                                            
                                    </td>
                                    <td class="text-right">
                                        {!! Form::open(['url' => route('adverts.update', ['id' => $item->id]), 'method' => 'PUT']) !!}
                                        {!! Form::hidden('publish', $item->publish ? 0 : 1) !!}
                                        <button class="border btn btn-light btn-sm" title="{{ $item->present()->buttonPublishLabel }}">{{ $item->present()->buttonPublishLabel }}</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="p-20 ta-c bdT w-100">
                <a href="/admin/adverts">Ir para anúncios</a>
            </div>
        </div>
    </div>
    @endif
    
    @can('statistics')
    @if($analyticsDataResume->isNotEmpty())
    <div class="w-100">
        <div class="gap-20 row">
            <!-- #Toatl Visits ==================== -->
            <div class='col-md-3'>
                <div class="p-20 layers bd bgc-white" data-toggle="tooltip" title="É o número de visitas total de um site, com todas as páginas somadas. Cada vez que alguém entra no site ou atualiza a página, conta uma visita, independente da quantidade de vezes ou ser ou não o mesmo usuário.">
                    <div class="layer w-100 mB-10">
                        <h6 class="mb-0 lh-1">Total de visitas </h6>
                        <small class="c-grey-400">Últimos 30 dias</small>
                    </div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                                <i class="ti-stats-up icon-2x c-green-500"></i>
                            </div>
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">{{ @$analyticsDataResume['ga:sessions'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- #Total Page Views ==================== -->
            <div class='col-md-3'>
                <div class="p-20 layers bd bgc-white" data-toggle="tooltip" title="Quando uma página é carregada ou atualizada no navegador, conta como uma visualização de página.">
                    <div class="layer w-100 mB-10">
                        <h6 class="mb-0 lh-1">Total de visualização de páginas</h6>
                        <small class="c-grey-400">Últimos 30 dias</small>
                    </div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                                <i class="ti-eye icon-2x c-blue-500"></i>
                            </div>
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">{{ @$analyticsDataResume['ga:pageviews'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- #Unique Visitors ==================== -->
            <div class='col-md-3'>
                <div class="p-20 layers bd bgc-white" data-toggle="tooltip" title="Um mesmo usuário pode visitar seu site várias vezes ao dia. Assim, “Visitantes Únicos” se refere a este usuário e reflete um certo nível de fidelização">
                    <div class="layer w-100 mB-10">
                        <h6 class="mb-0 lh-1">Visitas únicas</h6>
                        <small class="c-grey-400">Últimos 30 dias</small>
                    </div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                                <i class="ti-user icon-2x c-purple-500"></i>
                            </div>
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500">{{ @$analyticsDataResume['ga:users'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- #Bounce Rate ==================== -->
            <div class='col-md-3'>
                <div class="p-20 layers bd bgc-white" data-toggle="tooltip" title="Taxa de Rejeição é o percentual de pessoas que acessaram o seu site através da página de entrada e não interagiram com ela, ou seja, acessou seu site leu a informação e não trafegou, não acessou uma outra página.">
                    <div class="layer w-100 mB-10">
                        <h6 class="mb-0 lh-1">Taxa de rejeição</h6>
                        <small class="c-grey-400">Últimos 30 dias</small>
                    </div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                                <i class="ti-hand-point-up icon-2x c-red-500"></i>
                            </div>
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-red-50 c-red-500">{{ @$analyticsDataResume['ga:bounceRate'] }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($analyticsDataPeriod->isNotEmpty())
    <div class="col-md-12">
        <!-- #Monthly Stats ==================== -->
        <div class="bd bgc-white">
            <div class="layers">
                <div class="d-flex justify-content-between w-100">
                    <div class="layer pX-20 pT-20">
                        <h6 class="lh-1">Estatística dos últimos {{ request()->query('period', 7) }} dias</h6>
                    </div>
                    <div class="layer pX-20 pT-20">
                        <div class="dropdown">
                            <a class="bg-white border btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                              Período
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                              <a class="dropdown-item" href="?period=7">Últimos 7 dias</a>
                              <a class="dropdown-item" href="?period=15">Últimos 15 dias</a>
                              <a class="dropdown-item" href="?period=30">Últimos 30 dias</a>
                              <a class="dropdown-item" href="?period=90">Últimos 3 meses</a>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="p-20 layer w-100">
                    <canvas id="line-chart" height="80" data-datas="{{ $analyticsDataPeriod->toJson() }}"></canvas>
                </div>
                {{-- <div class="p-20 layer bdT w-100">
                    <div class="peers ai-c jc-c gapX-20">
                        <div class="peer">
                            <span class="fsz-def fw-600 mR-10 c-grey-800">10% <i class="fa fa-level-up c-green-500"></i></span>
                            <small class="c-grey-500 fw-600">APPL</small>
                        </div>
                        <div class="peer fw-600">
                            <span class="fsz-def fw-600 mR-10 c-grey-800">2% <i class="fa fa-level-down c-red-500"></i></span>
                            <small class="c-grey-500 fw-600">Average</small>
                        </div>
                        <div class="peer fw-600">
                            <span class="fsz-def fw-600 mR-10 c-grey-800">15% <i class="fa fa-level-up c-green-500"></i></span>
                            <small class="c-grey-500 fw-600">Sales</small>
                        </div>
                        <div class="peer fw-600">
                            <span class="fsz-def fw-600 mR-10 c-grey-800">8% <i class="fa fa-level-down c-red-500"></i></span>
                            <small class="c-grey-500 fw-600">Profit</small>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    @endif
    @endcan    
</div>

@endsection