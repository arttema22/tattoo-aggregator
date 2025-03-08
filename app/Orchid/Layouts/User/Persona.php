<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Platform\Models\User;
use Illuminate\View\View;
use Orchid\Screen\Layouts\Content;

class Persona extends Content
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.persona';

    /**
     * @param User $user
     * @return View
     */
    public function render( User $user ): View
    {
        return view($this->template, [
            'title'    => $user->name,
            'subTitle' => match ( $user->role ) {
                1 => 'Администратор',
                2 => 'Модератор',
                3 => 'Салон/Мастер',
                default => 'n/a',
            },
            'image'    => $this->image( $user ),
            'url'      => route( 'platform.systems.users.edit', $user->id),
        ]);
    }

    protected function image( User $user ) : string
    {
        $hash = md5(strtolower(trim($user->email)));

        return "https://www.gravatar.com/avatar/$hash?d=mp";
    }
}
