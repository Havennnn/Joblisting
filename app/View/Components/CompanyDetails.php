<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CompanyDetails extends Component
{
    /**
     * Company model
     */
    public $company;

    /**
     * Employer model
     */
    public $employer;

    /**
     * Create a new component instance.
     *
     * @param  mixed  $company
     * @param  mixed  $employer
     * @return void
     */
    public function __construct($company = null, $employer = null)
    {
        $this->company = $company;
        $this->employer = $employer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.company-details');
    }
}
