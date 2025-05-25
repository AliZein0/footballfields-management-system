<?php

namespace App\View\Components\Teams\Partials;

use Illuminate\View\Component;

class MatchCard extends Component
{
    public $match;
    public $team;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($match, $team)
    {
        $this->match = $match;
        $this->team = $team;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.teams.partials.match-card');
    }
}