<?php

namespace App\Classes;

use Illuminate\Routing\Controller;

class Menu
{
    public $menu = [
        [
            'text' => 'Dashboard',
            'url' => '/dashboard',
            'icon' => 'fas fa-2x  fa-tachometer-alt',
        ],
        [
            'text' => 'SAC',
            'icon' => 'fas fa-2x fa-heartbeat',
            'submenu' => [
                [
                    'text' => 'My Contact',
                    'icon' => 'fas fa-address-book',
                    'url' => '/vlife/my_contact',
                ],
            ],
        ],

        [
            'text' => 'Admin',
            'icon' => 'fa fa-2x fa-user-shield',
            'submenu' => [
                [
                    'text' => 'Users',
                    'icon' => 'fa fa-user-lock',
                    'url' => '/admin/user_management',
                ],
            ],
        ],



    ]; // END OF MENU

}
