<div>
    {{-- Migaja de pan --}}
    <div class="breadcrumbs mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.elements.movements')"> Movimiento de Elementos </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:dropdown>
            <flux:button size="sm" variant="filled" icon:trailing="chevron-down"> Acciones </flux:button>
            <flux:menu>
                <flux:menu.group heading="Generar Moivimiento">
                    <flux:menu.item wire:click="openIngresoModal"> Registrar Compra </flux:menu.item>
                    <flux:menu.item wire:click="openSalidaModal"> Registrar Prestamo </flux:menu.item>
                    <flux:menu.item wire:click="openReturnModal"> Devolver Herramienta </flux:menu.item>
                </flux:menu.group>
                <flux:menu.group heading="Filtrar Movimientos">
                    <flux:menu.item wire:click="$set('typeFilter', 'Prestamo')"> Filtrar por Préstamos </flux:menu.item>
                    <flux:menu.item wire:click="$set('typeFilter', 'Compra')"> Filtrar por Compras </flux:menu.item>
                    <flux:menu.item wire:click="$set('typeFilter', '')"> Limpiar Filtro </flux:menu.item>
                </flux:menu.group>
            </flux:menu>
        </flux:dropdown>
    </div>

    {{-- ————————————————— Barra de búsqueda + filtro de tipo ————————————————— --}}
    <div class="card mb-4">
        <div class="flex gap-4">
            <div class="w-full">
                <flux:input type="text" placeholder="Buscar por Ficha o instructor/proveedor..." wire:model.debounce.500ms="search" />
            </div>
        </div>
    </div>

    {{-- ————————————————— Tabla principal de Movimientos ————————————————— --}}
    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item cursor-pointer" wire:click="sortBy('date')">
                        Fecha
                        @include('partials.sort-icon', ['field' => 'date'])
                    </th>
                    <th class="head-table-item cursor-pointer" wire:click="sortBy('type')">
                        Tipo
                        @include('partials.sort-icon', ['field' => 'type'])
                    </th>
                    <th class="head-table-item cursor-pointer" wire:click="sortBy('party')">
                        Instructor / Proveedor
                        @include('partials.sort-icon', ['field' => 'party'])
                    </th>
                    <th class="head-table-item cursor-pointer" wire:click="sortBy('user')">
                        Registrado por
                        @include('partials.sort-icon', ['field' => 'user'])
                    </th>
                    <th class="head-table-item cursor-pointer" wire:click="sortBy('file')">
                        Ficha / Ambiente
                        @include('partials.sort-icon', ['field' => 'file'])
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($movements as $item)
                    <tr wire:key="element-mov-{{$item->movement_id}}" class="table-content">
                        <td class="column-item">{{ $item->created_at->format('Y-m-d H:i') }}</td>
                        <td class="column-item">{{ $item->type }}</td>
                        <td class="column-item">{{ $item->party }}</td>
                        <td class="column-item">{{ $item->user }}</td>
                        <td class="column-item">
                            @if ($item->type === 'Compra')
                                {{ $item->file ? $item->file : 'No aplica' }}
                            @else
                                {{ $item->file }}
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 py-4 text-center text-gray-500 italic"> No se encontraron movimientos. </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginación --}}
        <div class="mx-4 mt-4 mb-4">{{ $movements->links(data: ['scrollTo' => false]) }}</div>
    </div>

    {{-- ——————————————— MODAL «Registrar Ingreso» ——————————————— --}}
    <flux:modal name="ingreso-modal" wire:model.live.defer="showIngresoModal" class="md:w-[700px]">
        <div class="space-y-6 p-4">
            <h3 class="text-lg font-semibold"> Registrar Ingreso de Inventario </h3>

            {{-- 1. Seleccionar Grupo --}}
            <flux:select label="Grupo de Elemento" wire:model.live="ingresoGroup">
                <flux:select.option value="">Seleccione un grupo</flux:select.option>
                <flux:select.option value="G1">G-01: Metraje consumible (1100–1999)</flux:select.option>
                <flux:select.option value="G2">G-02: Accesorio consumible (2100–2999)</flux:select.option>
                <flux:select.option value="G3">G-03: Herramienta no consumible (3100–3999)</flux:select.option>
                <flux:select.option value="G4">G-04: Consumible mínimo (4100–4999)</flux:select.option>
            </flux:select>

            @if ($ingresoGroup)
                {{-- ————— G-01: Metraje (una sola fila de ancho/largo + N rollos) ————— --}}
                @if ($ingresoGroup === 'G1')
                    {{-- 2.1. Seleccionar Elemento Padre --}}
                    <flux:select label="Elemento (Metraje)" wire:model.live="ingresoElementCode">
                        <flux:select.option value=""> Seleccione un elemento </flux:select.option>
                        @foreach ($elementsByIngresoGroup as $el)
                            <flux:select.option value="{{ $el->code }}">
                                [{{ $el->code }}] {{ $el->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>

                    {{-- 2.2. Ancho y Largo (m) --}}
                    <div class="grid grid-cols-2 gap-4">
                        <flux:input type="number" step="0.01" wire:model.live="ingresoBroad" label="Ancho (m)" />
                        <flux:input type="number" step="0.01" wire:model.live="ingresoLong"  label="Largo (m)" />
                    </div>

                    {{-- 2.3. Cantidad de rollos --}}
                    <flux:input type="number" min="1" wire:model.live="ingresoRollCount" label="Cantidad de rollos" />

                    {{-- 2.4. Generar N inputs para los códigos de rollo --}}
                    @if ($ingresoRollCount)
                        <div class="mt-4 border-t pt-4 space-y-3">
                            <div class="text-sm font-medium mb-2"> Códigos de rollos: </div>
                            @for ($i = 0; $i < $ingresoRollCount; $i++)
                                <flux:input type="number" wire:model.live="ingresoRollCodes.{{ $i }}" label="Código rollo #{{ $i + 1 }}" />
                            @endfor
                        </div>
                    @endif
                @else
                    {{-- ————— G-02 / G-03 / G-04: varias líneas “elemento + cantidad” ————— --}}
                    <div class="space-y-4">
                        @foreach ($ingresoItems as $i => $row)
                            <div class="border border-gray-200 rounded p-3 relative">
                                @if (count($ingresoItems) > 1)
                                    <button type="button" wire:click="removeIngresoLine({{ $i }})" class="absolute top-2 right-2 text-red-600 hover:text-red-800">
                                        &times;
                                    </button>
                                @endif

                                {{-- 2.1. Seleccionar Elemento --}}
                                <flux:select label="Elemento" wire:model.live="ingresoItems.{{ $i }}.element_code">
                                    <flux:select.option value=""> Seleccione un elemento </flux:select.option>
                                    @foreach ($elementsByIngresoGroup as $el)
                                        <flux:select.option value="{{ $el->code }}">
                                            [{{ $el->code }}] {{ $el->name }} (Stock: {{ $el->stock }})
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>

                                {{-- 2.2. Cantidad a ingresar --}}
                                <flux:input type="number" wire:model.live="ingresoItems.{{ $i }}.amount" label="Cantidad a ingresar" min="1" />
                            </div>
                        @endforeach

                        {{-- Botón para agregar línea --}}
                        <div class="flex justify-end">
                            <flux:button size="sm" variant="filled" wire:click="addIngresoLine"> + Agregar línea </flux:button>
                        </div>
                    </div>
                @endif

                {{-- 3. Seleccionar Proveedor --}}
                <flux:select label="Proveedor" wire:model.live="ingresoSupplierNit">
                    <flux:select.option value=""> 
                        {{ empty($suppliers) ? 'Cargando proveedores...' : 'Seleccione un proveedor' }}
                    </flux:select.option>
                    @foreach ($suppliers as $sp)
                        <flux:select.option value="{{ $sp->nit }}">
                            {{ $sp->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                {{-- 4. Botones de acción --}}
                <div class="flex justify-end gap-2 pt-4">
                    <flux:button size="sm" variant="filled" wire:click="closeIngresoModal"> Cancelar </flux:button>
                    <flux:button size="sm" variant="filled" wire:click="saveIngreso"> Guardar Ingreso </flux:button>
                </div>
            @endif
        </div>
    </flux:modal>

    {{-- Trigger invisible para abrir el modal de Ingreso --}}
    <flux:modal.trigger name="ingreso-modal" />

    {{-- ——————————————— MODAL «Registrar Salida» ——————————————— --}}
    <flux:modal name="salida-modal" wire:model.live.defer="showSalidaModal" class="md:w-[700px]">
        <div class="space-y-6 p-4">
            <h3 class="text-lg font-semibold">Registrar Salida de Inventario</h3>

            {{-- 1. Seleccionar Grupo --}}
            <flux:select label="Grupo de Elemento" wire:model.live="salidaGroup">
                <flux:select.option value=""> Seleccione un grupo </flux:select.option>
                <flux:select.option value="G1"> G-01: Metraje consumible (1100–1999) </flux:select.option>
                <flux:select.option value="G2"> G-02: Accesorio consumible (2100–2999) </flux:select.option>
                <flux:select.option value="G3"> G-03: Herramienta prestada (3100–3999) </flux:select.option>
                <flux:select.option value="G4"> G-04: Consumible mínimo (4100–4999) </flux:select.option>
            </flux:select>

            @if ($salidaGroup)
                {{-- 2. Dinámicamente: varias líneas de Salida --}}
                <div class="space-y-4">
                    @foreach ($salidaItems as $i => $row)
                        <div class="border border-gray-200 rounded p-3 relative">
                            @if (count($salidaItems) > 1)
                                <button type="button" wire:click="removeSalidaLine({{ $i }})" class="absolute top-2 right-2 text-red-600 hover:text-red-800">
                                    &times; 
                                </button>
                            @endif

                            @if ($salidaGroup === 'G1')
                                {{-- G-01: Consumo de metraje --}}
                                {{-- 2.1. Seleccionar Elemento Padre --}}
                                <flux:select class="mb-4" label="Elemento (Metraje)"
                                    wire:model.live="salidaItems.{{ $i }}.element_code">
                                    <flux:select.option value=""> Seleccione un elemento </flux:select.option>
                                    @foreach ($elementsBySalidaGroup as $el)
                                        <flux:select.option value="{{ $el->code }}">
                                            [{{ $el->code }}] {{ $el->name }}
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>

                                {{-- 2.2. Si ya elegiste elemento, mostrar lista de rollos --}}
                                @if ($row['element_code'])
                                    <flux:select class="mb-4" label="Rollo"
                                        wire:model.live="salidaItems.{{ $i }}.roll_code">
                                        <flux:select.option value=""> Seleccione rollo </flux:select.option>
                                        @foreach (\App\Models\Roll::where('element_code', $row['element_code'])
                                                ->where('state_id', 1)
                                                ->where('long', '>', 0)
                                                ->get() as $r)
                                            <flux:select.option value="{{ $r->code }}">
                                                Rollo {{ $r->code }} – {{ number_format($r->long, 2) }} m
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                @endif

                                {{-- 2.3. Si elegiste rollo, pedir metros a descontar --}}
                                @if ($row['roll_code'])
                                    <flux:input type="number" step="0.01" min="0.01" wire:model="salidaItems.{{ $i }}.used_length" label="¿Cuántos metros descontar?" />
                                @endif
                            @elseif ($salidaGroup === 'G2' || $salidaGroup === 'G4')
                                {{-- G-02 / G-04: Consumo de stock --}}
                                {{-- 2.1. Seleccionar Elemento --}}
                                <flux:select class="mb-2" label="Elemento" wire:model.live="salidaItems.{{ $i }}.element_code">
                                    <flux:select.option value=""> Seleccione un elemento </flux:select.option>
                                    @foreach ($elementsBySalidaGroup as $el)
                                        <flux:select.option value="{{ $el->code }}">
                                            [{{ $el->code }}] {{ $el->name }} (Stock: {{ $el->stock }})
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>

                                {{-- 2.2. Cantidad a consumir --}}
                                <flux:input type="number" wire:model="salidaItems.{{ $i }}.amount" label="Cantidad a consumir" min="1" />
                            @else
                                {{-- G-03: Préstamo de herramienta --}}
                                {{-- 2.1. Seleccionar Herramienta --}}
                                <flux:select class="mb-4" label="Herramienta"
                                    wire:model.live="salidaItems.{{ $i }}.element_code">
                                    <flux:select.option value=""> Seleccione herramienta </flux:select.option>
                                    @foreach ($elementsBySalidaGroup as $el)
                                        <flux:select.option value="{{ $el->code }}">
                                            [{{ $el->code }}] {{ $el->name }} (Stock: {{ $el->stock }})
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>

                                {{-- 2.2. Cantidad a prestar --}}
                                <flux:input type="number" wire:model="salidaItems.{{ $i }}.amount" label="Cantidad a prestar" min="1" />
                            @endif
                        </div>
                    @endforeach

                    {{-- Botón para agregar nueva línea --}}
                    <div class="flex justify-end">
                        <flux:button size="sm" variant="filled" wire:click="addSalidaLine"> + Agregar línea </flux:button>
                    </div>
                </div>

                {{-- 3. Seleccionar Instructor --}}
                <flux:select label="Instructor" wire:model.live="salidaInstructorId">
                    <flux:select.option value="">
                        {{ empty($instructors) ? 'Cargando instructores...' : 'Seleccione Instructor' }}
                    </flux:select.option>
                    @foreach ($instructors as $inst)
                        <flux:select.option value="{{ $inst->card }}">
                            {{ $inst->name }} {{ $inst->last_name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                {{-- 4. Ficha / Ambiente --}}
                <flux:input type="number" wire:model="salidaFile" label="Ficha / Ambiente" />

                {{-- 5. Botones de acción --}}
                <div class="flex justify-end gap-2 pt-4">
                    <flux:button size="sm" variant="filled" wire:click="closeSalidaModal"> Cancelar </flux:button>
                    <flux:button size="sm" variant="filled" wire:click="saveSalida"> Guardar Salida </flux:button>
                </div>
            @endif
        </div>
    </flux:modal>

    {{-- Trigger invisible para abrir el modal de Salida --}}
    <flux:modal.trigger name="salida-modal" />

    {{-- ——————————————— MODAL «Devolver Herramienta» ——————————————— --}}
    <flux:modal name="return-modal" wire:model.live.defer="showReturnModal" class="md:w-[1000px]">
        <div class="p-4">
            <h3 class="text-lg font-semibold mb-4"> Herramientas Prestadas Pendientes de Devolución </h3>

            @if ($pendingReturns->isEmpty())
                <div class="text-gray-500 italic"> No hay préstamos de herramientas pendientes. </div>
            @else
                <div class="div-table">
                    <table class="table">
                        <thead class="head-table">
                            <tr>
                                <th class="head-table-item"> Herramienta </th>
                                <th class="head-table-item"> Cantidad </th>
                                <th class="head-table-item"> Instructor </th>
                                <th class="head-table-item"> Ficha/Ambiente </th>
                                <th class="head-table-item"> Acción </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingReturns as $detail)
                                <tr wire:key="pending-return-{{ $detail->detail_id }}" class="table-content">
                                    <td class="column-item">{{ $detail->element_name }}</td>
                                    <td class="column-item">{{ $detail->amount }}</td>
                                    <td class="column-item">{{ $detail->instr_name }} {{ $detail->instr_last }}</td>
                                    <td class="column-item">{{ $detail->file ?? '—' }}</td>
                                    <td class="column-item">
                                        <flux:button size="xs" variant="filled" wire:click="returnTool({{ $detail->detail_id }})"> Devolver </flux:button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="flex justify-end mt-4">
                <flux:button size="sm" variant="filled" wire:click="closeReturnModal"> Cerrar </flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Trigger invisible para abrir el modal de devolución --}}
    <flux:modal.trigger name="return-modal" />
</div>
