<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Config;
use App\Model\User;

class ProfileImage extends Component
{
    /**
     * The user whose profile image is to be generated.
     *
     * @var User
     */
    public $user;

    /**
     * The url of the image to be modified.
     *
     * @var string
     */
    public $imageUrl;

    /**
     * The width and height of the image in pixels.
     *
     * @var int
     */
    public $size;

    /**
     * The border radius of the image in pixels.
     *
     * @var int
     */
    public $borderRadius;

    /**
     * Create a new component instance.
     * @param  User  $user
     * @param  int  $size
     * @return void
     */
    public function __construct(User $user, $size=50)
    {
        $this->user = $user;
        $avatar = $this->user->profile->avatar_url;
        $this->imageUrl = $avatar ? $avatar : asset(Config::get('user.default_profile_avatar'));
        $this->size = $size;
        $this->borderRadius = (int)($this->size / 2);
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
