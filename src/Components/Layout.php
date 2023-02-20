<?php

namespace Lokalkoder\NotifyMe\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    public ?string $header = null;
    public ?string $contentHeader = null;
    public ?string $contentSummary = null;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('notify-me::layouts.main');
    }
}
