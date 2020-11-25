<?php
namespace App\Http\Controllers\Core;

use Illuminate\Routing\Controller;

class MenuController extends Controller
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
                    'text' => 'Home',
                    'icon' => 'fa fa-home',
                    'url' => '/vlife',
                ],
                [
                    'text' => 'My Contact',
                    'icon' => 'fas fa-address-book',
                    'url' => '/vlife/my_contact',
                ],
            ],
        ],
        [
            'text' => 'Contact Information',
            'icon' => 'fa fa-2x fa-address-book',
            'submenu' => [
                [
                    'text' => 'Home',
                    'icon' => 'fa fa-home',
                    'url' => '/contactinformation',
                ],
                [
                    'text' => 'All Contact',
                    'icon' => 'fa fa-address-card',
                    'url' => '/contactinformation/all',
                ],
                [
                    'text' => 'Support Worker',
                    'icon' => 'fa fa-user-nurse ',
                    'url' => '/contactinformation/support_worker',
                ],
                [
                    'text' => 'Client',
                    'icon' => 'fa fa-house-user ',
                    'url' => '/contactinformation/client',
                ],
            ],
        ],
        [
            'text' => 'Service',
            'icon' => 'fa fa-2x fa-calendar-alt',
            'submenu' => [
                [
                    'text' => 'Home',
                    'icon' => 'fa fa-home',
                    'url' => '/service',
                ],
                [
                    'text' => 'Agreement',
                    'icon' => 'fa fa-file-signature',
                    'url' => '/service/service_agreement',
                ],
                // [
                //     'text' => 'Budget Plan',
                //     'icon' => 'fa fa-file-signature',
                //     'url'  => '/service/budget_plan',
                // ],
                [
                    'text' => 'Service Planning',
                    'icon' => 'fa fa-calendar',
                    'url' => '/service/service_planning',
                ],
                [
                    'text' => 'Assignment',
                    'icon' => 'fa fa-calendar-check',
                    'url' => '/service/service_assignment',
                ],
            ],
        ],
        [
            'text' => 'Centre',
            'icon' => 'fa fa-2x fa-hospital-alt',
            'submenu' => [
                [
                    'text' => 'Home',
                    'icon' => 'fa fa-home',
                    'url' => '/centre',
                ],
                [
                    'text' => 'Attendance',
                    'icon' => 'fa fa-check',
                    'url' => '/centre/attendance',
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
                    'url' => '/contactinformation/all',
                ],
                [
                    'text' => 'Assignment Check',
                    'icon' => 'fa fa-check ',
                    'url' => '/contactinformation/support_worker',
                ],
                [
                    'text' => 'Acitivity Check',
                    'icon' => 'fa fa-check',
                    'url' => '/contactinformation/client',
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
                    'url' => '/contactinformation/all',
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
                    'url' => '/admin',
                ],
                [
                    'text' => 'Users',
                    'icon' => 'fa fa-user-lock',
                    'url' => '/admin/user_management',
                ],
                [
                    'text' => 'Permission',
                    'icon' => 'fa fa-shield-alt',
                    'url' => '/admin/permission_management',
                ],
                [
                    'text' => 'History',
                    'icon' => 'fa fa-list-alt',
                    'url' => '/admin/history',
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
                    'url' => '/setting',
                ],
                [
                    'text' => 'Services',
                    'icon' => 'fa fa-cogs',
                    'url' => '/setting/services',
                ],
            ],
        ],
        [
            'text' => 'Data Adapter',
            'icon' => 'fa fa-2x fa-plug',
            'submenu' => [
                [
                    'text' => 'Home',
                    'icon' => 'fa fa-home',
                    'url' => '/data_adapter',
                ],
                [
                    'text' => 'Contact Data',
                    'icon' => 'fa fa-sync',
                    'url' => '/data_adapter/contactinformation',
                ],
                [
                    'text' => 'Service Data',
                    'icon' => 'fa fa-sync',
                    'url' => '/data_adapter/services',
                ],
            ],
        ],

    ]; // END OF MENU

}
