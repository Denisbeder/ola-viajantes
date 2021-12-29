<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;
use App\Supports\Services\EditorJsService;
use App\Supports\Traits\ImagesPresenterTrait;
use App\Supports\Traits\PublishPresenterTrait;
use App\Supports\Traits\PublisedAtPresenterTrait;

class PromotionPresenter extends Presenter
{
    use PublishPresenterTrait, ImagesPresenterTrait, PublisedAtPresenterTrait;

    public function modeLabel()
    {
        switch ($this->mode) {
            case 'form_default':
                return 'Formulário padrão';
                break;

            case 'form_datas':
                return 'Formulário com envio de dados';
                break;
            
            default:
                return 'Sem participação pelo site';
                break;
        }
    }

    public function bodyHtml()
    {
        return (bool) strlen($body = $this->body) ? (new EditorJsService)->outputToHtml($body) : null;
    }

    public function url()
    {
        if (is_null($this->page)) {
            return;
        }
        
        $pageSlug = '/' . trim($this->page->present()->url, '/');
        $slug = '/' . $this->slug;
        return $pageSlug . $slug;
    }

    public function participantsLink()
    {
        return sprintf('<a href="%s" class="btn btn-link" title="Ver participantes">%s</a>', $this->participantsHref(), $this->participantsText());
    }

    public function participantsText()
    {
        $total = $this->participants->count();
        return $total > 1 || $total === 0 ? $total . ' Participantes' : $total . ' Paticipante';
    }

    public function participantsHref()
    {
        return '/admin/promotionsparticipants/?pm=' . $this->id;
    }

    public function participantsButton()
    {        
        return sprintf('<a href="%s" class="btn btn-light border btn-sm rounded" title="Ver participantes">%s</a>', $this->participantsHref(), $this->participantsText());
    }

}
