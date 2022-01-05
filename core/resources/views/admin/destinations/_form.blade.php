<div class="bgc-white p-20 bd bdrs-3">   
    @empty($lastCreateId = request()->query('lc'))
        <div class="form-row">
            <div class="col-4">
                <div class="form-group">
                    {!! Form::cSelect('parent_id', 'É um parente de', ['' => 'Nenhuma'] + App\Destination::orderby('title')->get()->pluck('title', 'id')->toArray()) !!}
                </div>
            </div>
        </div>
    @else
        <div class="form-group border rounded-lg bg-light p-5">
            <h5 class="m-0">Esse registro será adicionado como parente de <strong>{{ App\Destination::find($lastCreateId)->title }}</strong></h5>
            {!! Form::hidden('parent_id', $lastCreateId) !!}
        </div>
    @endempty

    <div class="form-group mb-0">
        {!! Form::cInput('text', 'title', 'Título') !!}
    </div>
</div>

<div class="bgc-white mT-30 pT-20 pL-20 pR-20 pB-15 bd bdrs-3 clearfix">
    {!! Form::cFileS('images[]', 'Imagens', ['multiple', 'accept' => 'image/*'], $record ?? null) !!}
</div>