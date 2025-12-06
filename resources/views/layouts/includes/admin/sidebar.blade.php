@php
    $user = Auth::user();
    $links = [];
    
    // Dashboard link for everyone
    $links[] = [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
        'icon' => 'fas fa-home',
        'active' => request()->routeIs('admin.dashboard'),
    ];
    
    // Client Menu
    if ($user->hasRole('client')) {
        $links[] = [
            'header' => 'Tickets'
        ];
        
        $links[] = [
            'name' => 'Crear Ticket',
            'href' => route('client.tickets.create'),
            'icon' => 'fas fa-plus-circle',
            'active' => request()->routeIs('client.tickets.create'),
        ];
        
        $links[] = [
            'name' => 'Mis Tickets',
            'href' => route('client.tickets.index'),
            'icon' => 'fas fa-ticket-alt',
            'active' => request()->routeIs('client.tickets.index'),
        ];
    }
    
    // Technician Menu
    if ($user->hasAnyRole(['technician', 'admin'])) {
        $links[] = [
            'header' => 'Gestión de Tickets'
        ];
        
        $links[] = [
            'name' => 'Tickets No Asignados',
            'href' => route('admin.technician.tickets.unassigned'),
            'icon' => 'fas fa-inbox',
            'active' => request()->routeIs('admin.technician.tickets.unassigned'),
        ];
        
        $links[] = [
            'name' => 'Mis Tickets Pendientes',
            'href' => route('admin.technician.tickets.pending'),
            'icon' => 'fas fa-clock',
            'active' => request()->routeIs('admin.technician.tickets.pending'),
        ];
    }
    
    // Admin Menu
    if ($user->hasRole('admin')) {
        $links[] = [
            'header' => 'Administración'
        ];
        
        $links[] = [
            'name' => 'Usuarios',
            'href' => route('admin.users.index'),
            'icon' => 'fas fa-users',
            'active' => request()->routeIs('admin.users.*'),
        ];
        
        $links[] = [
            'name' => 'Roles',
            'href' => route('admin.roles.index'),
            'icon' => 'fas fa-user-shield',
            'active' => request()->routeIs('admin.roles.*'),
        ];
        
        $links[] = [
            'name' => 'Permisos',
            'href' => route('admin.permissions.index'),
            'icon' => 'fas fa-key',
            'active' => request()->routeIs('admin.permissions.*'),
        ];
    }
@endphp

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-theme-dark border-r border-theme-medium sm:translate-x-0 shadow-lg" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-theme-dark">
        <ul class="space-y-2 font-medium">
            @foreach($links as $link)
                <li>
                    @isset($link['header'])
                        <div class="px-2 py-2 text-xs font-semibold text-theme-light uppercase rounded-lg">
                            {{ $link['header'] }}
                        </div>
                    @else
                        <a href="{{ $link['href'] }}" 
                           class="flex items-center p-2 text-theme-light rounded-lg hover:bg-theme-medium hover:text-theme-accent group transition-colors {{ isset($link['active']) && $link['active'] ? 'bg-theme-medium text-theme-accent shadow-md' : '' }}">
                            <span class="w-6 h-6 inline-flex items-center justify-center {{ isset($link['active']) && $link['active'] ? 'text-theme-accent' : 'text-theme-light' }}">
                                <i class="{{ $link['icon'] }}"></i>
                            </span>
                            <span class="ms-3">{{ $link['name'] }}</span>
                        </a>
                    @endisset
                </li>
            @endforeach
        </ul>
    </div>
</aside>