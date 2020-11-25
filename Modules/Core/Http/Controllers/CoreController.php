<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CoreController extends Controller
{
    public $menu = [
        [
            'text' => 'Dashboard',
            'url'  => '/dashboard',
            'icon' => 'fas fa-2x  fa-tachometer-alt',
        ],
        [
            'text' => 'Contact Information',
            'icon' => 'fa fa-2x fa-address-book',
            'submenu' => [
                [
                    'text' => 'Home',
                    'icon' => 'fa fa-home',
                    'url'  => '/contactinformation',
                ],
                [
                    'text' => 'All Contact',
                    'icon' => 'fa fa-address-card',
                    'url'  => '/contactinformation/all',
                ],
                [
                    'text' => 'Support Worker',
                    'icon' => 'fa fa-user-nurse ',
                    'url'  => '/contactinformation/support_worker',
                ],
                [
                    'text' => 'Client',
                    'icon' => 'fa fa-house-user ',
                    'url'  => '/contactinformation/client',
                ],
            ],
        ],
        [
            'text' => 'Scheduler',
            'icon' => 'fa fa-2x fa-calendar-alt',
            'submenu' => [
                [
                    'text' => 'Home',
                    'icon' => 'fa fa-home',
                    'url'  => '/contactinformation/all',
                ],
                [
                    'text' => 'Agreement',
                    'icon' => 'fa fa-file-signature',
                    'url'  => '/contactinformation/support_worker',
                ],
                [
                    'text' => 'Service Planning',
                    'icon' => 'fa fa-calendar',
                    'url'  => '/contactinformation/client',
                ],
                [
                    'text' => 'Assignment',
                    'icon' => 'fa fa-calendar-check',
                    'url'  => '/contactinformation/client',
                ],
            ],
        ],
        [
            'text' => 'Data Entry',
            'icon' => 'fa fa-2x fa-check-double',
            'submenu' => [
                [
                    'text' => 'Home',
                    'icon' => 'fa fa-home',
                    'url'  => '/contactinformation/all',
                ],
                [
                    'text' => 'Assignment Check',
                    'icon' => 'fa fa-check ',
                    'url'  => '/contactinformation/support_worker',
                ],
                [
                    'text' => 'Acitivity Check',
                    'icon' => 'fa fa-check',
                    'url'  => '/contactinformation/client',
                ],
            ],
        ],
        [
            'text' => 'Accounting',
            'icon' => 'fa fa-2x fa-chart-line',
            'submenu' => [
                [
                    'text' => 'Home',
                    'icon' => 'fa fa-home',
                    'url'  => '/contactinformation/all',
                ],
            ],
        ],
        [
            'text' => 'Admin',
            'icon' => 'fa fa-2x fa-user-shield',
            'submenu' => [
                [
                    'text' => 'Home',
                    'icon' => 'fa fa-home',
                    'url'  => '/admin',
                ],
                [
                    'text' => 'Users',
                    'icon' => 'fa fa-user-lock',
                    'url'  => '/admin/user_management',
                ],
                [
                    'text' => 'Permission',
                    'icon' => 'fa fa-shield-alt',
                    'url'  => '/admin/permission_management',
                ],
                [
                    'text' => 'History',
                    'icon' => 'fa fa-list-alt',
                    'url'  => '/admin/history',
                ],
            ],
        ],
        [
            'text' => 'Setting',
            'icon' => 'fa fa-2x fa-cog',
            'submenu' => [
                [
                    'text' => 'Home',
                    'icon' => 'fa fa-home',
                    'url'  => '/setting',
                ],
                [
                    'text' => 'Services',
                    'icon' => 'fa fa-cogs',
                    'url'  => '/setting/services',
                ],
            ],
        ],

    ]; // END OF MENU


}
