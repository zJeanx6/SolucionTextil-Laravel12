<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-2">
        
        {{-- Header con información del software --}}
        <div class="grid auto-rows-min gap-6 md:grid-cols-3">
            
            {{-- Logo y información principal --}}
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900">
                <div class="p-6 text-center">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-lg bg-white dark:bg-zinc-900">
                        <x-app-logo-icon class="h-12 w-12"/>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Solución Textil</h2>
                    <p class="text-sm text-gray-600 dark:text-zinc-400">Sistema de Gestión de Integral</p>
                    <flux:badge class="mt-2" variant="outline">Versión 1.1</flux:badge>
                    
                    <div class="mt-4 space-y-3">
                        <p class="text-sm text-gray-600 dark:text-zinc-400">
                            Sistema para la gestión de inventarios, productos, maquinaria y mantenimiento en la industria textil.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Información del usuario y rol --}}
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900">
                <div class="p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <flux:icon.users class="h-5 w-5 text-blue-600" />
                        <h3 class="font-semibold text-gray-900 dark:text-white">
                            Tu Rol: {{ ucfirst(auth()->user()->role->name) }}
                        </h3>
                    </div>

                    <!-- Información de la empresa y NIT -->
                    <div class="grid grid-cols-2 gap-4 mb-2">
                        <div class="w-1/2">
                            <h4 class="font-medium text-gray-900 dark:text-white">Empresa:</h4>
                            <p class="text-sm text-gray-600 dark:text-zinc-400">
                                {{ auth()->user()->company->name ?? 'No disponible' }}
                            </p>
                        </div>

                        <div class="w-1/2">
                            <h4 class="font-medium text-gray-900 dark:text-white">NIT:</h4>
                            <p class="text-sm text-gray-600 dark:text-zinc-400">
                                {{ auth()->user()->company_nit ?? 'No disponible' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white mb-2">Permisos principales:</h4>
                            <ul class="text-sm text-gray-600 dark:text-zinc-400 space-y-1">
                                @if(auth()->user()->role->name === 'inventario')
                                    <li>• Gestionar elementos y productos</li>
                                    <li>• Registrar movimientos</li>
                                    <li>• Consultar inventarios</li>
                                @elseif(auth()->user()->role->name === 'administrador')
                                    <li>• Acceso completo al sistema</li>
                                    <li>• Gestión de usuarios</li>
                                    <li>• Configuración avanzada</li>
                                    <li>• Todos los reportes</li>
                                @elseif(auth()->user()->role->name === 'mantenimiento')
                                    <li>• Gestión de máquinas</li>
                                    <li>• Control de mantenimiento</li>
                                    <li>• Reportes de mantenimiento</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contacto y ayuda --}}
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900">
                <div class="p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <flux:icon.question-mark-circle class="h-5 w-5 text-blue-600" />
                        <h3 class="font-semibold text-gray-900 dark:text-white">¿Necesitas Ayuda?</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <flux:button variant="outline" class="w-full justify-start" size="sm">
                            <flux:icon.envelope class="mr-2 h-4 w-4" />
                            solucionestextilesapp@gmail.com
                        </flux:button>
                        
                        {{-- <flux:button variant="outline" class="w-full justify-start" size="sm">
                            <flux:icon.phone class="mr-2 h-4 w-4" />
                            +57 (313) 280-0855
                        </flux:button> --}}
                        
                        {{-- <flux:button variant="outline" class="w-full justify-start" size="sm">
                            <flux:icon.book-open class="mr-2 h-4 w-4" />
                            Manual de Usuario
                        </flux:button> --}}
                        
                        <hr class="border-gray-200 dark:border-zinc-700">
                        <p class="text-xs text-gray-500 dark:text-zinc-500">
                            Horario de soporte: Lun-Vie 8:00 AM - 6:00 PM
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección principal con guía y accesos rápidos --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Guía rápida de uso --}}
            <div class="lg:col-span-2 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900">
                <div class="p-6">
                    <div class="mb-6 flex items-center gap-2">
                        <flux:icon.book-open class="h-5 w-5 text-blue-600" />
                        <h3 class="font-semibold text-gray-900 dark:text-white">Guía Rápida de Uso</h3>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-zinc-400 mb-6">Aprende a usar el sistema paso a paso</p>
                    
                    <div class="space-y-6">
                        {{-- Paso 1: Elementos --}}
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white">
                                    1
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="mb-1 flex items-center gap-2">
                                    <flux:icon.archive-box class="h-4 w-4 text-blue-400" />
                                    <h4 class="font-medium text-gray-900 dark:text-white">Elementos</h4>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-zinc-400">
                                    Registra materias primas, telas, hilos y otros insumos básicos
                                </p>
                            </div>
                        </div>

                        {{-- Paso 2: Productos --}}
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white">
                                    2
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="mb-1 flex items-center gap-2">
                                    <flux:icon.shopping-bag class="h-4 w-4 text-blue-400" />
                                    <h4 class="font-medium text-gray-900 dark:text-white">Productos</h4>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-zinc-400">
                                    Gestiona productos terminados y semi-elaborados
                                </p>
                            </div>
                        </div>

                        {{-- Paso 3: Movimientos --}}
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white">
                                    3
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="mb-1 flex items-center gap-2">
                                    <flux:icon.arrow-right class="h-4 w-4 text-blue-400" />
                                    <h4 class="font-medium text-gray-900 dark:text-white">Movimientos</h4>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-zinc-400">
                                    Registra entradas, salidas y transferencias de inventario
                                </p>
                            </div>
                        </div>

                        {{-- Paso 4: Reportes --}}
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white">
                                    4
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="mb-1 flex items-center gap-2">
                                    <flux:icon.document-text class="h-4 w-4 text-blue-400" />
                                    <h4 class="font-medium text-gray-900 dark:text-white">Reportes</h4>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-zinc-400">
                                    Consulta estadísticas y genera informes de inventario
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Consejo --}}
                    <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-4 dark:border-blue-800 dark:bg-blue-900/20">
                        <h4 class="font-medium text-blue-900 dark:text-blue-100 mb-2">💡 Consejo:</h4>
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            Comienza registrando tus elementos básicos (materias primas), luego crea productos y finalmente
                            registra los movimientos de entrada y salida.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Accesos rápidos --}}
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900">
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Accesos Rápidos</h3>
                    <p class="text-sm text-gray-600 dark:text-zinc-400 mb-6">Funciones principales del sistema</p>
                    
                    <div class="space-y-3">
                        {{-- Elementos (visible para inventario y admin) --}}
                        @if(in_array(auth()->user()->role->name, ['administrador', 'inventario']))
                            <flux:button variant="ghost" class="w-full justify-start h-auto p-3 text-left" href="{{ route('admin.elements.index') }}">
                                <div class="mr-3 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded bg-blue-500">
                                    <flux:icon.archive-box class="h-4 w-4 text-white" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Gestionar Elementos</div>
                                    <div class="text-xs text-gray-600 dark:text-zinc-400 truncate">Agregar, editar y consultar elementos del inventario</div>
                                </div>
                                <flux:icon.chevron-right class="h-4 w-4 flex-shrink-0 text-gray-500" />
                            </flux:button>
                        @endif

                        {{-- Productos (visible para inventario y admin) --}}
                        @if(in_array(auth()->user()->role->name, ['administrador', 'inventario']))
                            <flux:button variant="ghost" class="w-full justify-start h-auto p-3 text-left" href="{{ route('admin.products.index') }}">
                                <div class="mr-3 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded bg-green-500">
                                    <flux:icon.shopping-bag class="h-4 w-4 text-white" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Gestionar Productos</div>
                                    <div class="text-xs text-gray-600 dark:text-zinc-400 truncate">Administrar productos terminados y en proceso</div>
                                </div>
                                <flux:icon.chevron-right class="h-4 w-4 flex-shrink-0 text-gray-500" />
                            </flux:button>
                        @endif

                        {{-- Movimientos (visible para inventario y admin) --}}
                        @if(in_array(auth()->user()->role->name, ['administrador', 'inventario']))
                            <flux:button variant="ghost" class="w-full justify-start h-auto p-3 text-left" href="{{ route('admin.elements.movements') }}">
                                <div class="mr-3 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded bg-orange-500">
                                    <flux:icon.arrow-right class="h-4 w-4 text-white" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Movimientos</div>
                                    <div class="text-xs text-gray-600 dark:text-zinc-400 truncate">Registrar entradas y salidas de inventario</div>
                                </div>
                                <flux:icon.chevron-right class="h-4 w-4 flex-shrink-0 text-gray-500" />
                            </flux:button>
                        @endif

                        {{-- Máquinas (visible para mantenimiento y admin) --}}
                        @if(in_array(auth()->user()->role->name, ['administrador', 'mantenimiento']))
                            <flux:button variant="ghost" class="w-full justify-start h-auto p-3 text-left" href="{{ route('admin.machines.index') }}">
                                <div class="mr-3 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded bg-red-500">
                                    <flux:icon.cpu-chip class="h-4 w-4 text-white" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Gestionar Máquinas</div>
                                    <div class="text-xs text-gray-600 dark:text-zinc-400 truncate">Administrar máquinas y equipos</div>
                                </div>
                                <flux:icon.chevron-right class="h-4 w-4 flex-shrink-0 text-gray-500" />
                            </flux:button>
                        @endif

                        {{-- Reportes (visible solo para admin) --}}
                        @if(auth()->user()->role->name === 'administrador')
                            <flux:button variant="ghost" class="w-full justify-start h-auto p-3 text-left" href="{{ route('admin.dashboard-inventory') }}">
                                <div class="mr-3 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded bg-purple-500">
                                    <flux:icon.chart-pie class="h-4 w-4 text-white" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Reportes</div>
                                    <div class="text-xs text-gray-600 dark:text-zinc-400 truncate">Consultar reportes y estadísticas</div>
                                </div>
                                <flux:icon.chevron-right class="h-4 w-4 flex-shrink-0 text-gray-500" />
                            </flux:button>
                        @endif

                        {{-- Mantenimiento (visible para mantenimiento y admin) --}}
                        @if(in_array(auth()->user()->role->name, ['administrador', 'mantenimiento']))
                            <flux:button variant="ghost" class="w-full justify-start h-auto p-3 text-left" href="{{ route('admin.dashboard-maintenance') }}">
                                <div class="mr-3 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded bg-yellow-500">
                                    <flux:icon.wrench class="h-4 w-4 text-white" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Mantenimiento</div>
                                    <div class="text-xs text-gray-600 dark:text-zinc-400 truncate">Gestión de mantenimiento de máquinas</div>
                                </div>
                                <flux:icon.chevron-right class="h-4 w-4 flex-shrink-0 text-gray-500" />
                            </flux:button>
                        @endif
                    </div>

                    <hr class="my-4 border-gray-200 dark:border-zinc-700">

                    <div class="text-center">
                        <p class="mb-2 text-xs text-gray-500 dark:text-zinc-500">¿Necesitas agregar una nueva funcionalidad?</p>
                        <flux:button variant="outline" size="sm" class="w-full">
                            <flux:icon.envelope class="mr-2 h-4 w-4" />
                            Enviar Sugerencia
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer con información adicional --}}
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Estado del Sistema</h4>
                        <div class="flex items-center justify-center gap-2">
                            <div class="h-2 w-2 rounded-full bg-green-500"></div>
                            <span class="text-sm text-gray-600 dark:text-zinc-400">Operativo</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Última Actualización</h4>
                        <p class="text-sm text-gray-600 dark:text-zinc-400">{{ date('d \d\e F, Y') }}</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Próximas Mejoras</h4>
                        <p class="text-sm text-gray-600 dark:text-zinc-400">En desarrollo...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
