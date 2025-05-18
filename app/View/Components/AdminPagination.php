<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminPagination extends Component
{
    public $paginator;
    public $resourceName;
    
    /**
     * Create a new component instance.
     *
     * @param mixed $paginator
     * @param string $resourceName
     * @return void
     */
    public function __construct($paginator, $resourceName = 'items')
    {
        $this->paginator = $paginator;
        $this->resourceName = $resourceName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-pagination');
    }
}
