<div>
    <div class="breadcrumbs mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item> Movimientos de Productos </flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:dropdown>
            <flux:button size="sm" variant="filled" icon:trailing="chevron-down"> Acciones </flux:button>
            <flux:menu>
                <flux:menu.group heading="Registrar Movimiento">
                    <flux:menu.item wire:click="openIngresoModal">Registrar Productos</flux:menu.item>
                    <flux:menu.item wire:click="openSalidaModal">Registrar Salida</flux:menu.item>
                </flux:menu.group>
                <flux:menu.group heading="Filtrar">
                    <flux:menu.item wire:click="$set('typeFilter', 'Ingreso')">Solo Ingresos</flux:menu.item>
                    <flux:menu.item wire:click="$set('typeFilter', 'Salida')">Solo Salidas</flux:menu.item>
                    <flux:menu.item wire:click="$set('typeFilter', '')">Todos</flux:menu.item>
                </flux:menu.group>
            </flux:menu>
        </flux:dropdown>
    </div>

    <div class="card mb-4">
        <div class="flex gap-4">
            <div class="w-full">
                <flux:input type="text" placeholder="Buscar por producto o usuario..." wire:model.live="search" />
            </div>
        </div>
    </div>

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
                    <th class="head-table-item">Producto</th>
                    <th class="head-table-item">Cantidad</th>
                    <th class="head-table-item">Usuario</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($movements as $m)
                    <tr wire:key="product-mov-{{$m->movement_id}}" class="table-content">
                        <td class="column-item">{{ \Carbon\Carbon::parse($m->date)->format('Y-m-d H:i') }}</td>
                        <td class="column-item">{{ $m->type }}</td>
                        <td class="column-item">{{ $m->product_name ?? '-' }}</td>
                        <td class="column-item">{{ $m->amount }}</td>
                        <td class="column-item">{{ $m->user ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-3 py-4 text-center text-gray-500 italic">No se encontraron movimientos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mx-4 mt-4 mb-4">{{ $movements->links(data: ['scrollTo' => false]) }}</div>
    </div>

    {{-- MODAL Ingreso --}}
    <flux:modal name="ingreso-modal" wire:model.live.defer="showIngresoModal" class="md:w-[500px]">
        <div class="space-y-6 p-4">
            <h3 class="text-lg font-semibold">Registrar Ingreso de Producto</h3>
            <flux:select label="Producto" wire:model.live="ingresoProductCode">
                <flux:select.option value="">Seleccione producto</flux:select.option>
                @foreach ($products as $p)
                    <flux:select.option value="{{ $p->code }}"> {{ $p->name }}</flux:select.option>
                @endforeach
                <flux:select.option value="new_product">+ Crear nuevo producto</flux:select.option>
            </flux:select>
            <flux:input type="number" wire:model.live="ingresoAmount" label="Cantidad" min="1" />
            <div class="flex justify-end gap-2 pt-4">
                <flux:button size="sm" variant="primary" wire:click="closeIngresoModal">Cancelar</flux:button>
                <flux:button size="sm" variant="primary" wire:click="saveIngreso">Guardar Ingreso</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal.trigger name="ingreso-modal" />

    {{-- MODAL Salida --}}
    <flux:modal name="salida-modal" wire:model.live.defer="showSalidaModal" class="md:w-[500px]">
        <div class="space-y-6 p-4">
            <h3 class="text-lg font-semibold">Registrar Salida de Producto</h3>
            <flux:select label="Producto" wire:model.live="salidaProductCode">
                <flux:select.option value="">Seleccione producto</flux:select.option>
                @foreach ($products as $p)
                    <flux:select.option value="{{ $p->code }}">[{{ $p->code }}] {{ $p->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:input type="number" wire:model.live="salidaAmount" label="Cantidad" min="1" />
            <div class="flex justify-end gap-2 pt-4">
                <flux:button size="sm" variant="primary" wire:click="closeSalidaModal">Cancelar</flux:button>
                <flux:button size="sm" variant="primary" wire:click="saveSalida">Guardar Salida</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal.trigger name="salida-modal" />
    {{-- MODAL Nuevo Producto --}}
    @if ($showCreateModal)
        <flux:modal name="create-product-modal" wire:model.live.defer="showCreateModal" class="max-w-5xl">
            <div class="p-6 w-full">
                <h2 class="text-lg font-semibold mb-6 text-gray-800 dark:text-white">Crear nuevo producto</h2>

                <div class="flex flex-col lg:flex-row gap-6">
                    {{-- COLUMNA IZQUIERDA --}}
                    <div class="w-full lg:w-1/2 flex flex-col gap-4">
                        {{-- Tipo --}}
                        <flux:select wire:model.live="product_type_id">
                            <flux:select.option value="">Tipo de Producto</flux:select.option>
                            @foreach ($productTypes as $type)
                                <flux:select.option value="{{ $type->id }}">{{ $type->name }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        {{-- Talla --}}
                        <flux:select wire:model.live="size_id">
                            <flux:select.option value="">Talla</flux:select.option>
                            @foreach ($sizes as $size)
                                <flux:select.option value="{{ $size->id }}">{{ $size->abbreviation ?? $size->name }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        {{-- Color --}}
                        <flux:select wire:model.live="color_id">
                            <flux:select.option value="">Color</flux:select.option>
                            @foreach ($colors as $color)
                                <flux:select.option value="{{ $color->id }}">{{ $color->name }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        {{-- Imagen --}}
                        <div class="relative w-full h-60 bg-gray-100 rounded-md flex items-center justify-center dark:bg-[#2f2f2f]">
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="absolute inset-0 object-cover w-full h-full rounded-md" />
                                <button wire:click="$set('photo', null)"
                                    class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-500 flex items-center justify-center text-xs font-bold">
                                    &times;
                                </button>
                            @else
                                <div class="mb-4">
                                    <div x-data="{ uploading: false, progress: 0 }"
                                        x-on:livewire-upload-start="uploading = true"
                                        x-on:livewire-upload-finish="uploading = false"
                                        x-on:livewire-upload-cancel="uploading = false"
                                        x-on:livewire-upload-error="uploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <label class="flex flex-col items-center justify-center cursor-pointer w-full h-full">
                                            <span wire:loading.class="hidden" class="text-sm text-gray-500">Cargar imagen</span>
                                            <input type="file" class="hidden" wire:model="photo" accept="image/*">
                                        </label>
                                        <div x-show="uploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @error('photo')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- DIVISOR --}}
                    <div class="hidden lg:block w-px bg-gray-300"></div>

                    {{-- COLUMNA DERECHA --}}
                    <div class="w-full lg:w-1/2 flex flex-col gap-4">
                        <flux:input type="number" wire:model="code" label="Código" />
                        <flux:input type="text" wire:model.live="name" label="Nombre" />
                        <flux:input type="number" wire:model="stock" label="Stock" />
                    </div>
                </div>

                {{-- BOTONES DE ACCIÓN --}}
                <div class="mt-6 flex justify-end gap-3">
                    <flux:button wire:click="$set('showCreateModal', false)" size="sm" variant="outline">Cancelar</flux:button>
                    <flux:button wire:click="save" size="sm" variant="primary">Guardar</flux:button>
                </div>
            </div>
        </flux:modal>
    @endif

</div>
