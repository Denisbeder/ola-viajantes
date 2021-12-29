<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class PollOptionPresenter extends Presenter
{
    /* public function percent($totalVotesPoll = null)
    {
        $totalVotesPoll = !is_null($totalVotesPoll) ? $totalVotesPoll : $this->poll->votes_count;
        return round(($this->votes_count / $totalVotesPoll) * 100);
    } */
}
