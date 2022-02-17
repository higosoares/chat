<?php

namespace App\View\Components\Messages\Users;

use App\Models\User as ModelsUser;
use Illuminate\View\Component;

class User extends Component
{
    public $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ModelsUser $user)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.messages.users.user');
    }
}
