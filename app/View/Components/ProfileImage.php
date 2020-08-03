<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\User;

class ProfileImage extends Component
{
    /**
     * The user whose profile image is to be generated.
     *
     * @var User
     */
    public $user;

    /**
     * The width and height of the image in pixels.
     *
     * @var int
     */
    public $size;

    /**
     * Create a new component instance.
     * @param  User  $user
     * @param  int  $size
     * @return void
     */
    public function __construct(User $user, $size=50)
    {
        $this->user = $user;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.profile-image');
    }
}
