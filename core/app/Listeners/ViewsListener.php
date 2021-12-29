<?php

namespace App\Listeners;

use App\View;
use App\Events\ViewsEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Riverskies\Laravel\MobileDetect\Facades\MobileDetect;

class ViewsListener
{
    public $model;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(View $model)
    {
        $this->model = $model;
    }

    /**
     * Handle the event.
     *
     * @param  ViewsEvent  $event
     * @return void
     */
    public function handle(ViewsEvent $event)
    {
        $request = request();
        $id = $event->data->id;
        $class = get_class($event->data);

        $this->model->viewable_id = $id;
        $this->model->viewable_type = $class;
        $this->model->ip = $request->ip();
        $this->model->device = $request->userAgent() ?? 'undefined';
        $this->model->is_mobile = MobileDetect::isMobile();
        $this->model->created_at = $event->data->created_at;
        $this->model->save();
    }
}
