<div>
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.machine.index')">Maquinas</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        @if ($view === 'index')
            <flux:button size="sm" variant="primary" wire:click="create">Nuevo</flux:button>
        @else
            <flux:button size="sm" variant="primary" wire:click="index">Volver</flux:button>
        @endif        
    </div>
    @if ($view === 'index')
    <div class="card mb-6">
        <div class="flex gap-4 mb-4">
            <div class="w-1/2">
                <flux:input label="Busqueda por serial" type="text" wire:model.live="search" class="hover-input"
                    name="search" placeholder="Buscar por serial..." />
            </div>
            <div class="w-1/2">
                <flux:select label="Busqueda por tipo de maquina" wire:model.live="modelSelected">
                    @foreach ($machine_types as $machine_type)
                        <flux:select.option value="{{ $machine_type->id }}">{{ $machine_type->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>
    </div>
    
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="table">
            <thead
                class="head-table">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">SERIAL</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">ESTADO</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($machines as $machine)
                <tr
                    class="table-content">
                    <th scope="row" class="px-6 py-4 text-center font-medium whitespace-nowrap">
                        {{ $machine->serial }}</th>
                    <td class="px-6 py-4 text-center uppercase">{{ $machine->state_id }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center">
                        <flux:button size="sm" variant="primary"
                            wire:click="edit('{{ $machine->serial }}')">Ver/Editar</flux:button>
                        <flux:button size="sm" variant="danger"
                            wire:click="delete({{ $machine->serial }})">Eliminar</flux:button>
                        </div>
                    </td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mx-4 mt-4 mb-4">{{ $machines->links() }}</div>


    @elseif ($view === 'create')
        <div class="card">
               <div class="mb-4">
                    <flux:input class="hover-input" label="Serial" wire:model="serial" placeholder="Escribe el serial de la máquina">Serial</flux:input>
                </div>

                <div class="mb-4">
                    <label>imagen</label>
                    <input type="file" wire:model="image" class="hover-input width: 50% px-2 py-1 border border-gray-300 rounded-md">
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" alt="Imagen de la máquina" class="mt-2">
                        {{--  Mostrar la imagen temporalmente --}}
                    @endif
                </div>
        
                <div class="mb-4">
                    <label>Estado</label>
                    <select wire:model="state_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Selecciona un estado</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label>Tipo de máquina</label>
                    <select wire:model="machine_type_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Selecciona un tipo de máquina</option>
                        @foreach ($machine_types as $machine_type)
                            <option value="{{ $machine_type->id }}">{{ $machine_type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label> Marca</label>
                    <select wire:model="brand_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Selecciona una marca</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
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


    @elseif ($view === 'edit')
        <div class="card">
            <div class="mb-4">
                <flux:input class="hover-input" label="Serial" wire:model="serial" placeholder="Escribe el serial de la máquina">Serial</flux:input>
            </div>

            <div class="mb-4">
                <label>Imagen</label>
            <input type="file" wire:model="image" class="hover-input w-50 px-2 py-1 border border-gray-300 rounded-md">
        
            <!-- Mostrar imagen actual o nueva -->
            @if($currentImagePath && Storage::disk('public')->exists($currentImagePath))
                <div class="mt-2">
                    <p class="text-sm text-gray-500">Imagen actual:</p>
                    <img src="{{ asset('storage/' . $currentImagePath) }}" 
                        alt="Imagen actual" 
                        class="mt-1 max-w-xs">
                </div>
            @else
                <p class="text-sm text-red-500">No se encontró la imagen actual.</p>
            @endif
            </div>
            
            <div class="mb-4">
                <label>Estado</label>
                <select wire:model="state_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Selecciona un estado</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label>Tipo de máquina</label>
                <select wire:model="machine_type_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Selecciona un tipo de máquina</option>
                    @foreach ($machine_types as $machine_type)
                        <option value="{{ $machine_type->id }}">{{ $machine_type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label> Marca</label>
                <select wire:model="brand_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Selecciona una marca</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
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
    @endif
</div>
