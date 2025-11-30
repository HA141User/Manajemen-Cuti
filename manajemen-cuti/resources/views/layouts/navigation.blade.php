<nav x-data="{ open: false }" class="bg-primary border-b border-secondary/30 sticky top-0 z-50 transition-all duration-300 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="group flex items-center gap-2">
                        <div class="w-9 h-9 bg-accent rounded-lg flex items-center justify-center text-white shadow-lg group-hover:scale-105 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-cream group-hover:text-white transition">Talent<span class="text-accent">Flow</span></span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="text-gray-300 hover:text-white border-transparent hover:border-accent focus:text-white focus:border-accent transition font-medium">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('divisions.index')" :active="request()->routeIs('divisions.*')"
                            class="text-gray-300 hover:text-white border-transparent hover:border-accent focus:text-white focus:border-accent transition font-medium">
                            {{ __('Divisi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')"
                            class="text-gray-300 hover:text-white border-transparent hover:border-accent focus:text-white focus:border-accent transition font-medium">
                            {{ __('User') }}
                        </x-nav-link>
                        <x-nav-link :href="route('holidays.index')" :active="request()->routeIs('holidays.*')"
                            class="text-gray-300 hover:text-white border-transparent hover:border-accent focus:text-white focus:border-accent transition font-medium">
                            {{ __('Hari Libur') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'employee')
                        <x-nav-link :href="route('leaves.index')" :active="request()->routeIs('leaves.*')"
                            class="text-gray-300 hover:text-white border-transparent hover:border-accent focus:text-white focus:border-accent transition font-medium">
                            {{ __('Cuti Saya') }}
                        </x-nav-link>
                    @endif

                    @if(in_array(Auth::user()->role, ['division_manager', 'hr']))
                        <x-nav-link :href="route('approvals.index')" :active="request()->routeIs('approvals.*')"
                            class="text-gray-300 hover:text-white border-transparent hover:border-accent focus:text-white focus:border-accent transition font-medium relative">
                            {{ __('Persetujuan') }}
                            
                            @php
                                $pendingCount = 0;
                                if(Auth::user()->role == 'division_manager' && Auth::user()->managedDivision) {
                                    $pendingCount = \App\Models\LeaveRequest::where('status', 'pending')
                                        ->whereHas('user', function($q){ $q->where('division_id', Auth::user()->managedDivision->id)->where('role', 'employee'); })->count();
                                } elseif(Auth::user()->role == 'hr') {
                                    $pendingCount = \App\Models\LeaveRequest::where('status', 'approved_by_leader')
                                        ->orWhere(function($query) { $query->where('status', 'pending')->whereHas('user', function($q) { $q->where('role', 'division_manager'); }); })->count();
                                }
                            @endphp
                            
                            @if($pendingCount > 0)
                                <span class="absolute -top-1 -right-3 flex h-5 w-5 items-center justify-center rounded-full bg-accent text-[10px] font-bold text-white shadow-sm ring-2 ring-primary">
                                    {{ $pendingCount }}
                                </span>
                            @endif
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-secondary/50 text-sm leading-4 font-medium rounded-full text-cream bg-secondary/30 hover:bg-secondary/60 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex flex-col items-end mr-2">
                                <span class="font-bold text-white">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] uppercase tracking-wider text-accent">{{ str_replace('_', ' ', Auth::user()->role) }}</span>
                            </div>

                            <div class="ml-1 text-cream">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-paper border border-cream">
                            <x-dropdown-link :href="route('profile.edit')" class="text-primary hover:bg-cream hover:text-accent font-medium">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="text-red-600 hover:bg-red-50 font-medium">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-cream hover:text-white hover:bg-secondary/50 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-secondary border-t border-secondary/50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-cream hover:bg-primary hover:text-white">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('divisions.index')" :active="request()->routeIs('divisions.*')" class="text-cream hover:bg-primary hover:text-white">
                    {{ __('Divisi') }}
                </x-responsive-nav-link>
                @endif
        </div>
    </div>
</nav>