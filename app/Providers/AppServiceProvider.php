<?php

namespace App\Providers;

use App\Entities\Event;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Contracts\Events\Dispatcher $events)
    {
        Schema::defaultStringLength(191);

            $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

                if(Auth::guard('admin')->check() || Auth::guard('collaborator')->check()){

                    $eventos_pendentes = Event::with(['*'])->where('state_id', Event::PENDENTE)->count();
                    $eventos_processado = Event::with(['*'])->where('state_id', Event::PROCESSADO)->count();
                    $eventos_concluido = Event::with(['*'])->where('state_id', Event::CONCULIDO)->count();
                    $eventos_arquivado = Event::with(['*'])->where('state_id', Event::ARQUIVADO)->count();
                    $eventos_cancelado = Event::with(['*'])->where('state_id', Event::CANCELADO)->count();

                }elseif(Auth::guard('client')->check()){
                    $eventos_pendentes = Event::with(['*'])->where('state_id', Event::PENDENTE)->where('client_id', Auth::guard('client')->user()->id)->count();
                    $eventos_processado = Event::with(['*'])->where('state_id', Event::PROCESSADO)->where('client_id', Auth::guard('client')->user()->id)->count();
                    $eventos_concluido = Event::with(['*'])->where('state_id', Event::CONCULIDO)->where('client_id', Auth::guard('client')->user()->id)->count();
                    $eventos_arquivado = Event::with(['*'])->where('state_id', Event::ARQUIVADO)->where('client_id', Auth::guard('client')->user()->id)->count();
                    $eventos_cancelado = Event::with(['*'])->where('state_id', Event::CANCELADO)->where('client_id', Auth::guard('client')->user()->id)->count();
                }

                //ADMIN
                if(Auth::guard('admin')->check()){
                    $event->menu->add(
                        [
                            'header' => 'MENU',
                            'can' => 'admin-menu'
                        ]
                    );

                    $event->menu->add(
                        [
                            'text' => 'Configurações',
                            'icon' => 'cogs',
                            'can' => ['admin-menu', 'su', 'gestor'],
                            'submenu' => [
                                [
                                    'text' => 'Feriados',
                                    'url' => 'admin/configs/hollidays',
                                    'can' => 'admin-menu',
                                ],
                                [
                                    'text' => 'Listar Administradores',
                                    'url' => 'admin/configs/list_admin',
                                    'can' => 'admin-menu',
                                ],
                            ],

                        ]
                    );
                    //dd(\auth()->user()->getPermissionsViaRoles());
                    $event->menu->add(
                        [
                            'text' => 'Eventos',
                            'icon' => 'share',
                            'can' => 'admin-menu',
                            'submenu' => [
                                [
                                    'text' => 'Eventos Pendentes',
                                    'url' => 'admin/events/list/pending/admin',
                                    'can' => ['admin-menu','su','gestor', 'gestor_agenda','gestor_financeiro'],
                                    'label' => $eventos_pendentes,
                                    'label_color' => 'danger'
                                ],
                                [
                                    'text' => 'Eventos Aprovados',
                                    'url' => 'admin/events/list/approved/admin',
                                    'can' => 'admin-menu',
                                    'label' => $eventos_processado,
                                    'label_color' => 'danger'
                                ],
                                [
                                    'text' => 'Eventos Concluídos',
                                    'url' => 'admin/events/list/completed/admin',
                                    'can' => 'admin-menu',
                                    'label' => $eventos_concluido,
                                    'label_color' => 'danger'
                                ],
                                [
                                    'text' => 'Eventos Arquivados',
                                    'url' => 'admin/events/list/filled/admin',
                                    'can' => ['admin-menu'],
                                    'label' => $eventos_arquivado,
                                    'label_color' => 'danger'
                                ],
                                [
                                    'text' => 'Eventos Cancelados',
                                    'url' => 'admin/events/list/canceled/admin',
                                    'can' => ['admin-menu','su','gestor'],
                                    'label' => $eventos_cancelado,
                                    'label_color' => 'danger'
                                ],
                            ],
                        ]
                    );
                    $event->menu->add(
                        [
                            'text' => 'Colaboradores',
                            'icon' => 'users',
                            'can' => ['admin-menu','su','gestor','gestor_tecnico'],
                            'submenu' => [
                                [
                                    'text' => 'Lista de colaboradores',
                                    'url' => 'admin/collaborators/listActive',
                                    'can' => 'admin-menu',
                                ],
                                [
                                    'text' => 'Criar novo colaborador',
                                    'url' => 'admin/collaborators/create',
                                    'can' => 'admin-menu',
                                ],
                                [
                                    'text' => 'Email Dinâmico',
                                    'url' => 'admin/collaborators/dynamic-email',
                                    'can' => 'admin-menu',
                                ],
                            ],
                        ]
                    );
                    $event->menu->add(
                        [
                            'header' => 'FINANÇAS',
                            'can' => ['admin-menu', 'su', 'gestor', 'gestor_financeiro']
                        ]
                    );
                    $event->menu->add(
                        [
                            'text' => 'Dados Financeiros',
                            'icon' => 'euro',
                            'can' => ['admin-menu','su','gestor', 'gestor_financeiro'],
                            'submenu' => [
                                [
                                    'text' => 'Colaboradores',
                                    'can' => ['admin-menu','su','gestor', 'gestor_financeiro'],
                                    'submenu' => [

                                        [
                                            'text' => 'Pagamentos',
                                            'url' => 'admin/financial/payments',
                                            'can' => 'admin-menu',
                                        ],
                                        [
                                            'text' => 'Histórico Pagamentos',
                                            'url' => 'admin/financial/list',
                                            'can' => 'admin-menu',
                                        ],
                                    ],
                                ],
                                [
                                'text' => 'Eventos',
                                'can' => ['admin-menu','su','gestor', 'gestor_financeiro'],
                                'submenu' => [
                                    [
                                        'text' => Carbon::now()->format('Y'),
                                        'url' => 'admin/financial/current_balance',
                                        'can' => 'admin-menu',
                                    ],
                                    [
                                        'text' => 'Histórico',
                                        'url' => 'admin/financial/current_balance',
                                        'can' => 'admin-menu',
                                    ],
                                ],
                            ]

                            ],
                        ]
                    );
                }

                //CLIENT
                if(Auth::guard('client')->check()){
                    $event->menu->add(
                        [
                            'text'    => 'Eventos',
                            'icon'    => 'users',
                            'can'      => 'client-menu',
                            'submenu' => [
                                [
                                    'text' => 'Eventos Pendentes',
                                    'url'  => 'client/events/list/pending/client',
                                    'can'  => 'client-menu',
                                    'label' => $eventos_pendentes,
                                    'label_color' => 'danger'
                                ],
                                [
                                    'text' => 'Eventos Aprovados',
                                    'url'  => 'client/events/list/approved/client',
                                    'can'  => 'client-menu',
                                    'label' => $eventos_processado,
                                    'label_color' => 'danger'
                                ],
                                [
                                    'text' => 'Eventos Concluídos',
                                    'url'  => 'client/events/list/completed/client',
                                    'can'  => 'client-menu',
                                    'label' => $eventos_concluido,
                                    'label_color' => 'danger'
                                ],
                                [
                                    'text' => 'Eventos Arquivados',
                                    'url'  => 'client/events/list/filled/client',
                                    'can'  => 'client-menu',
                                    'label' => $eventos_arquivado,
                                    'label_color' => 'danger'
                                ],
                                [
                                    'text' => 'Eventos Cancelados',
                                    'url'  => 'client/events/list/canceled/client',
                                    'can'  => 'client-menu',
                                    'label' => $eventos_cancelado,
                                    'label_color' => 'danger'
                                ],
                            ],
                        ]
                    );
                }

                //COLLABORATORS
                if(Auth::guard('collaborator')->check()){
                    $event->menu->add(
                        [
                            'header' => 'PERFIL',
                            'can' => 'collaborator-menu'
                        ]
                    );
                    $event->menu->add(
                        [
                            'text' => 'Perfil',
                            'url'  => 'collaborator/settings/perfil/'.\auth()->user()->id,
                            'icon' => 'users',
                            'can'  => 'collaborator-menu'
                        ]
                    );
                    $event->menu->add(
                        [
                            'header' => 'SECÇÃO DE EVENTOS',
                            'can' => 'collaborator-menu'
                        ]
                    );
                    $event->menu->add(
                        [
                            'text'    => 'Eventos',
                            'icon'    => 'users',
                            'can'      => 'collaborator-menu',
                            'submenu' => [
                                [
                                    'text' => 'Eventos Aprovados',
                                    'url'  => 'collaborator/events/list/approved/collaborator',
                                    'can'  => 'collaborator-menu',
                                    'label' => $eventos_processado,
                                    'label_color' => 'danger'
                                ],
                                [
                                    'text' => 'Eventos Concluídos',
                                    'url'  => 'collaborator/events/list/completed/collaborator',
                                    'can'  => 'collaborator-menu',
                                    'label' => $eventos_concluido,
                                    'label_color' => 'danger'
                                ],
                                [
                                    'text' => 'Eventos Arquivados',
                                    'url'  => 'collaborator/events/list/filed/collaborator',
                                    'can'  => 'collaborator-menu',
                                    'label' => $eventos_arquivado,
                                    'label_color' => 'danger'
                                ],
                                [
                                    'text' => 'Eventos Cancelados',
                                    'url'  => 'collaborator/events/list/canceled/collaborator',
                                    'can'  => 'collaborator-menu',
                                    'label' => $eventos_cancelado,
                                    'label_color' => 'danger'
                                ],
                            ],
                        ]
                    );
                }

            });
        }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }
    }
}
