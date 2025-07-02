<div>
    {{-- Migaja de pan --}}
        <div class="breadcrumbs">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
                <flux:breadcrumbs.item :href="route('admin.machines.index')">Maquinas</flux:breadcrumbs.item>
            </flux:breadcrumbs>

            @if ($view === 'index')
                <flux:button size="sm" variant="primary" wire:click="create">Nuevo</flux:button>
            @else
                <flux:button size="sm" variant="primary" wire:click="index">Volver</flux:button>
            @endif        
        </div>
    {{-- Estado de busqueda --}}
    @if ($view === 'index')
    <div>
        <div class="card mb-6">
            <div class="flex gap-4 mb-4">
                {{-- Barra de busqueda por serial de maquina --}}
                    <div class="w-1/2">
                        <flux:input label="Busqueda por serial" type="text" wire:model.live="search" class="hover-input"
                            name="search" placeholder="Buscar por serial..." />
                    </div>
                {{-- Barra de busqueda por tipo de maquina --}}
                    <div class="w-1/2">
                        <flux:select label="Busqueda por tipo de maquina" wire:model.live="modelSelected">
                            @foreach ($machine_types as $machine_type)
                                <flux:select.option value="{{ $machine_type->id }}">{{ $machine_type->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
            </div>
        </div>
    
    {{-- Tabla de contenido --}}
        <div class="div-table">
            <table class="table">
                <thead class="head-table">
                    <tr>
                        <th class="head-table-item">SERIAL</th>
                        <th class="head-table-item">ESTADO</th>
                        <th class="head-table-item w-28 text-center">IMAGEN</th>
                        <th class="head-table-item">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($machines as $machine)
                    <tr class="table-content">
                        <th scope="row" class="column-item">
                            {{ $machine->serial }}</th>
                        <td class="column-item">{{ $machine->state_id }}</td>
                        <td class="column-item">
                            @if ($machine->image && Storage::disk('public')->exists($machine->image))
                                <flux:modal.trigger name="view-image-{{ $machine->serial }}">
                                    <img src="{{ Storage::url($machine->image) }}" alt="Imagen de la máquina" class="w-16 h-16 cursor-pointer">
                                </flux:modal.trigger>
                            @else
                                {{-- si no hay imagen --}}
                                <flux:modal.trigger name="view-image-{{ $machine->serial }}">
                                    <img src="{{ asset('img/no-image-found.jpg') }}" alt="No hay imagen" class="w-16 h-16 cursor-pointer">
                                </flux:modal.trigger>
                            @endif

                            {{-- Modal para mostrar la imagen --}}
                            <flux:modal name="view-image-{{ $machine->serial }}" class="md:w-96">
                                <div class="space-y-6">
                                    <div class="flex justify-center">
                                        @if ($machine->image && Storage::disk('public')->exists($machine->image))
                                            <img src="{{ Storage::url($machine->image) }}" alt="Imagen de la máquina" class="w-full h-auto">
                                        @else
                                            <img src="{{ asset('img/no-image-found.jpg') }}" alt="No hay imagen" class="w-full h-auto">
                                        @endif
                                    </div>
                                </div>
                            </flux:modal>
                        </td>
                            
                        <td class="column-item">
                            <div class="two-actions">
                                <flux:button.group>
                                    @if(auth()->user()->role_id === 1)
                                        <flux:button icon="document-magnifying-glass" size="sm" variant="filled" wire:click="show({{ $machine->code }})"/>
                                    @else {{-- Estilo diferente sino es admin - Detalle --}}
                                        <flux:button icon="document-magnifying-glass" size="sm" variant="filled" wire:click="show({{ $machine->code }})"> Detalle </flux:button>
                                    @endif

                                    {{-- Solo para role_id = 1 (admin) --}}
                                    @if(auth()->user()->role_id === 1)
                                        <flux:button icon="pencil-square" size="sm" variant="filled" wire:click="edit({{ $machine->code }})" />
                                        <flux:button icon="trash" size="sm" variant="danger" wire:click="delete({{ $machine->code }})" />
                                    @endif
                                </flux:button.group>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mx-4 mt-4 mb-4">{{ $machines->links() }}</div>

    {{-- vista para crear maquina --}}
    @elseif ($view === 'create')
        <div class="card p-6">
            <div class="card p-6">
                <div class="flex flex-col lg:flex-row gap-6">
        
        {{-- Columna izquierda--}}
        <div class="w-full lg:w-1/2 flex flex-col gap-4">
            <div>
                <flux:input class="hover-input" label="Serial" wire:model="serial" placeholder="Escribe el serial de la máquina">Serial</flux:input>
            </div>

           <div class="relative w-full h-60 bg-gray-100 rounded-md flex items-center justify-center dark:bg-[#2f2f2f]">
            @if ($image)
                {{-- Muestra la imagen seleccionada --}}
                <img src="{{ $image->temporaryUrl() }}" alt="Imagen de la máquina" class="absolute inset-0 object-cover w-full h-full rounded-md" />
                <button wire:click="$set('image', null)"
                    class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-500 flex items-center justify-center text-xs font-bold">
                    &times;
                </button>
            @else
                {{-- Área de carga --}}
                <div x-data="{ uploading: false, progress: 0 }"
                    x-on:livewire-upload-start="uploading = true"
                    x-on:livewire-upload-finish="uploading = false"
                    x-on:livewire-upload-cancel="uploading = false"
                    x-on:livewire-upload-error="uploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                    class="w-full h-full">
                    
                    <label class="flex flex-col items-center justify-center cursor-pointer w-full h-full">
                        <span wire:loading.class="hidden" class="text-sm text-gray-500 dark:text-gray-400">Cargar imagen</span>
                        <input type="file" class="hidden" wire:model="image" accept="image/*">
                    </label>

                    {{-- Barra de progreso de carga --}}
                    <div x-show="uploading" class="absolute bottom-0 left-0 right-0 px-4 py-1">
                        <progress max="100" x-bind:value="progress" class="w-full"></progress>
                    </div>
                </div>
            @endif
        </div>
    

        </div>
        {{-- Division --}}
        <div class="hidden lg:block w-px bg-gray-300"></div>

        {{-- Columna derecha --}}
        <div class="w-full lg:w-1/2 flex flex-col gap-4">
            <div>
                <label>Estado</label>
                <select wire:model="state_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Selecciona un estado</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Tipo de máquina</label>
                <select wire:model="machine_type_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Selecciona un tipo de máquina</option>
                    @foreach ($machine_types as $machine_type)
                        <option value="{{ $machine_type->id }}">{{ $machine_type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Marca</label>
                <select wire:model="brand_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Selecciona una marca</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Proveedor</label>
                <select wire:model="supplier_nit" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Selecciona un proveedor</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->nit }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <flux:button wire:click="save" variant="primary" type="submit">
                    Guardar
                </flux:button>
            </div>
        </div>

    </div>


    {{-- vista para editar una maquina --}}
    @elseif ($view === 'edit')
        <div class="card p-6">
            <div class="flex flex-col lg:flex-row gap-6">

            {{--  Columna izquierda --}}
            <div class="w-full lg:w-1/2 flex flex-col gap-4">

                <div>
                    <flux:input class="hover-input" label="Serial" wire:model="serial" placeholder="Escribe el serial de la máquina">Serial</flux:input>
                </div>

                <div class="relative w-full h-60 bg-[#2c2c2c] border border-[#383838] rounded-md overflow-hidden">
                @if ($image)
                    <!-- Imagen cargada -->
                    <img src="{{ $image->temporaryUrl() }}" alt="Imagen de la máquina" class="absolute inset-0 object-cover w-full h-full rounded-md" />
                    <!-- Botón para eliminar imagen -->
                    <button wire:click="$set('image', null)"
                        class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-600 text-black flex items-center justify-center text-xs font-bold">
                        &times;
                    </button>
                @else
                    <!-- Zona de carga de imagen -->
                    <div x-data="{ uploading: false, progress: 0 }"
                        x-on:livewire-upload-start="uploading = true"
                        x-on:livewire-upload-finish="uploading = false"
                        x-on:livewire-upload-cancel="uploading = false"
                        x-on:livewire-upload-error="uploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                        class="flex items-center justify-center w-full h-full text-[#b0b0b0] text-sm cursor-pointer">
                        
                        <label class="flex flex-col items-center justify-center w-full h-full">
                            <span wire:loading.class="hidden">Cargar imagen</span>
                            <input type="file" class="hidden" wire:model="image" accept="image/*">
                        </label>

                        <!-- Barra de progreso -->
                        <div x-show="uploading" class="absolute bottom-0 left-0 right-0 px-4 py-1 bg-[#1f1f1f]/80">
                            <progress max="100" x-bind:value="progress" class="w-full h-1 bg-[#333] rounded"></progress>
                        </div>
                    </div>
                @endif
            </div>


            </div>
            {{-- Division --}}
            <div class="hidden lg:block w-px bg-gray-300"></div>

            {{-- Columna derecha --}}
            <div class="w-full lg:w-1/2 flex flex-col gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Último mantenimiento</label>
                    <input type="date" value="{{ $last_maintenance ?? 'No Registrado' }}" class="w-full px-3 py-2 bg-gray-800 text-white border border-gray-700 rounded-md shadow-sm " readonly>

                <div>
                    <label>Estado</label>
                    <select wire:model="state_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Selecciona un estado</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Tipo de máquina</label>
                    <select wire:model="machine_type_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Selecciona un tipo de máquina</option>
                        @foreach ($machine_types as $machine_type)
                            <option value="{{ $machine_type->id }}">{{ $machine_type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Marca</label>
                    <select wire:model="brand_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Selecciona una marca</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Proveedor</label>
                    <select wire:model="supplier_nit" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Selecciona un proveedor</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->nit }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <flux:button wire:click="update" variant="primary" type="button">
                        Actualizar
                    </flux:button>
                </div>

            </div>
        </div>

        {{-- vista para ver la maquina --}}
    @elseif ($view === 'show')
        <div class="card p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <div>
                        <flux:input class="hover-input" label="Serial" wire:model="serial" placeholder="Escribe el serial de la máquina" readonly>Serial</flux:input>
                    </div>

                    <div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Imagen</label>
    
    <div class="relative w-full h-60 bg-gray-100 rounded-md flex items-center justify-center dark:bg-[#2f2f2f]">
        @if ($image && Storage::disk('public')->exists('machines-images/'.basename($image)))
            <img src="{{ Storage::url('machines-images/'.basename($image)) }}" 
                 alt="Imagen de la máquina" 
                 class="object-cover w-full h-full rounded-md" />
        @else
            <span class="text-sm text-gray-500 dark:text-gray-400">No hay imagen disponible</span>
        @endif
    </div>
</div>
                </div>
                
                {{-- Division --}}
                <div class="hidden lg:block w-px bg-gray-300"></div>

                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Último mantenimiento</label>
                            <input type="text" value="{{ $last_maintenance ?? 'No Registrado' }}" class="w-full px-3 py-2 bg-gray-800 text-white border border-gray-700 rounded-md shadow-sm " readonly>
                    </div>

                    <div>
                        <flux:select label="Estado" wire:model="state_id" class="hover-input" disabled>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:select label="Tipo de máquina" wire:model="machine_type_id" class="hover-input" disabled>
                            @foreach ($machine_types as $machine_type)
                                <option value="{{ $machine_type->id }}">{{ $machine_type->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:select label="Marca" wire:model="brand_id" class="hover-input" disabled>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:select label="Proveedor" wire:model="supplier_nit" class="hover-input" disabled>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->nit }}">{{ $supplier->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>
            </div>
    </div>
    @endif
</div>