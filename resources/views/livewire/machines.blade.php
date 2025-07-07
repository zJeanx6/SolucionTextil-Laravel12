<div>
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

    @if ($view === 'index')
        <div>
            <div class="card mb-6">
                <div class="flex gap-4 mb-4">
                    <div class="w-1/2">
                        <flux:input label="Busqueda por serial" type="text" wire:model.live="search" name="search" placeholder="Buscar por serial..." />
                    </div>

                    <div class="w-1/2">
                        <flux:select label="Busqueda por tipo de maquina" wire:model.live="modelSelected">
                            <flux:select.option value="">Seleccione tipo de maquina</flux:select.option>
                            @foreach ($machine_types as $machine_type)
                                <flux:select.option value="{{ $machine_type->id }}">{{ $machine_type->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>
            </div>

            <div class="div-table">
                <table class="table">
                    <thead class="head-table">
                        <tr>
                            <th class="head-table-item">SERIAL</th>
                            <th class="head-table-item">ESTADO</th>
                            <th class="head-table-item">TIPO DE MAQUINA</th>
                            <th class="head-table-item w-28 text-center">IMAGEN</th>
                            <th class="head-table-item">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($machines as $machine)
                        <tr wire:key="machine-{{ $machine->serial }}" class="table-content">
                            <th scope="row" class="column-item">{{ $machine->serial }}</th>
                            <td class="column-item">{{ $machine->state->name }}</td>
                            <td class="column-item">{{ $machine->machineType->name}}</td>
                            <td class="column-item">
                                @if ($machine->image && Storage::disk('public')->exists($machine->image))
                                    <flux:modal.trigger name="view-image-{{ $machine->serial }}">
                                        <img src="{{ Storage::url($machine->image) }}" alt="Imagen de la máquina" class="w-16 h-16 cursor-pointer">
                                    </flux:modal.trigger>
                                @else
                                    <flux:modal.trigger name="view-image-{{ $machine->serial }}">
                                        <img src="{{ asset('img/no-image-found.jpg') }}" alt="No hay imagen" class="w-16 h-16 cursor-pointer">
                                    </flux:modal.trigger>
                                @endif
                            </td>

                            <td class="column-item">
                                <div class="two-actions">
                                    <flux:button.group>
                                        @if(auth()->user()->role_id === 1)
                                            <flux:button icon="document-magnifying-glass" size="sm" variant="filled" wire:click="show('{{ $machine->serial }}')"/>
                                        @else
                                            <flux:button icon="document-magnifying-glass" size="sm" variant="filled" wire:click="show('{{ $machine->serial }}')"> Detalle </flux:button>
                                        @endif

                                        @if(auth()->user()->role_id === 1)
                                            <flux:button icon="pencil-square" size="sm" variant="filled" wire:click="edit('{{ $machine->serial }}')" />
                                            <flux:button icon="trash" size="sm" variant="danger" wire:click="delete('{{ $machine->serial }}')" />
                                        @endif
                                    </flux:button.group>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-3 py-4 text-center text-gray-500 italic"> No se encontraron maquinas. </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mx-4 mt-4 mb-4">{{ $machines->links() }}</div>
    @elseif ($view === 'create')
        <div class="card p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <flux:input label="Serial" wire:model="serial" placeholder="Escribe el serial de la máquina" />

                    <div class="relative w-full h-60 bg-gray-100 rounded-md flex items-center justify-center dark:bg-[#2f2f2f]">
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" alt="Imagen de la máquina" class="absolute inset-0 object-cover w-full h-full rounded-md" />
                            <button wire:click="$set('image', null)" class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-500 flex items-center justify-center text-xs font-bold">
                                &times;
                            </button>
                        @else
                            <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false" x-on:livewire-upload-error="uploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress" class="w-full h-full">
                                <label class="flex flex-col items-center justify-center cursor-pointer w-full h-full">
                                    <span wire:loading.class="hidden" class="text-sm text-gray-500 dark:text-gray-400">Cargar imagen</span>
                                    <input type="file" class="hidden" wire:model="image" accept="image/*">
                                </label>
                                <div x-show="uploading" class="absolute bottom-0 left-0 right-0 px-4 py-1">
                                    <progress max="100" x-bind:value="progress" class="w-full"></progress>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="hidden lg:block w-px bg-gray-300"></div>

                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <div>
                        <label>Estado</label>
                        <flux:select wire:model="state_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                            <option value="">Selecciona un estado</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <label>Tipo de máquina</label>
                        <flux:select wire:model.live="machine_type_id">
                            <flux:select.option value="">Selecciona un tipo de máquina</flux:select.option>
                            @foreach ($machine_types as $machine_type)
                                <flux:select.option value="{{ $machine_type->id }}">{{ $machine_type->name }}</flux:select.option>
                            @endforeach
                            <flux:select.option value="new_machine_type">+ Crear nuevo tipo</flux:select.option>
                        </flux:select>
                    </div>

                    <div>
                        <label>Marca</label>
                        <flux:select wire:model.live="brand_id">
                            <flux:select.option value="">Selecciona una marca</flux:select.option>
                            @foreach ($brands as $brand)
                                <flux:select.option value="{{ $brand->id }}">{{ $brand->name }}</flux:select.option>
                            @endforeach
                            <flux:select.option value="new_brand">+ Crear nueva marca</flux:select.option>
                        </flux:select>
                    </div>

                    <div>
                        <label>Proveedor</label>
                        <flux:select wire:model.live="supplier_nit">
                            <flux:select.option value="">Selecciona un proveedor</flux:select.option>
                            @foreach ($suppliers as $supplier)
                                <flux:select.option value="{{ $supplier->nit }}">{{ $supplier->name }}</flux:select.option>
                            @endforeach
                            <flux:select.option value="new_supplier">+ Crear nuevo proveedor</flux:select.option>
                        </flux:select>
                    </div>

                    <div class="flex justify-end">
                        <flux:button wire:click="save" variant="primary" type="submit">Guardar</flux:button>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($view === 'edit')
        <div class="card p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <flux:input label="Serial" wire:model="serial" placeholder="Escribe el serial de la máquina" />

                    <div class="relative w-full h-60 bg-[#2c2c2c] border border-[#383838] rounded-md overflow-hidden">
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" alt="Imagen de la máquina" class="absolute inset-0 object-cover w-full h-full rounded-md" />
                            <button wire:click="$set('image', null)" class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-600 text-black flex items-center justify-center text-xs font-bold">
                                &times;
                            </button>
                        @else
                            <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false" x-on:livewire-upload-error="uploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress" class="flex items-center justify-center w-full h-full text-[#b0b0b0] text-sm cursor-pointer">
                                <label class="flex flex-col items-center justify-center w-full h-full">
                                    <span wire:loading.class="hidden">Cargar imagen</span>
                                    <input type="file" class="hidden" wire:model="image" accept="image/*">
                                </label>
                                <div x-show="uploading" class="absolute bottom-0 left-0 right-0 px-4 py-1 bg-[#1f1f1f]/80">
                                    <progress max="100" x-bind:value="progress" class="w-full h-1 bg-[#333] rounded"></progress>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="hidden lg:block w-px bg-gray-300"></div>

                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <div>
                        <flux:select label="Estado" wire:model="state_id">
                            <option value="">Selecciona un estado</option>
                            @foreach ($states as $state)
                                <flux:select.option value="{{ $state->id }}">{{ $state->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:select label="Tipo de máquina" wire:model="machine_type_id">
                            <option value="">Selecciona un tipo de máquina</option>
                            @foreach ($machine_types as $machine_type)
                                <flux:select.option value="{{ $machine_type->id }}">{{ $machine_type->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:select label="Marca" wire:model="brand_id">
                            <option value="">Selecciona una marca</option>
                            @foreach ($brands as $brand)
                                <flux:select.option value="{{ $brand->id }}">{{ $brand->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:select label="Proveedor" wire:model="supplier_nit">
                            <option value="">Selecciona un proveedor</option>
                            @foreach ($suppliers as $supplier)
                                <flux:select.option value="{{ $supplier->nit }}">{{ $supplier->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div class="flex justify-end">
                        <flux:button wire:click="update" variant="primary" type="button">Actualizar</flux:button>
                    </div>
                </div>
            </div>
        </div>
     @elseif ($view === 'show')
        <div class="card p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <div>
                        <flux:input label="Serial" wire:model="serial" placeholder="Escribe el serial de la máquina" readonly>Serial</flux:input>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Imagen</label>
                        <div class="relative w-full h-60 bg-gray-100 rounded-md flex items-center justify-center dark:bg-[#2f2f2f]">
                            @if ($image && Storage::disk('public')->exists('machines-images/'.basename($image)))
                                <img src="{{ Storage::url('machines-images/'.basename($image)) }}" alt="Imagen de la máquina" class="object-cover w-full h-full rounded-md" />
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
                        <flux:input type="text" value="{{ $last_maintenance ?? 'No Registrado' }}" readonly/>
                    </div>

                    <div>
                        <flux:select label="Estado" wire:model="state_id" disabled>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:select label="Tipo de máquina" wire:model="machine_type_id" disabled>
                            @foreach ($machine_types as $machine_type)
                                <option value="{{ $machine_type->id }}">{{ $machine_type->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:select label="Marca" wire:model="brand_id" disabled>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:select label="Proveedor" wire:model="supplier_nit" disabled>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->nit }}">{{ $supplier->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>
            </div>
        </div>
    @endif

        {{-- NUEVO TIPO DE MAQUINA --}}
    @if ($showNewTypeModal)
        <flux:modal wire:model="showNewTypeModal">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Crear nuevo tipo de máquina</h2>

                <flux:input type="text" wire:model="newMachineTypeName" label="Nombre del tipo" />

                @error('newMachineTypeName')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div class="mt-6 flex justify-end gap-3">
                    <flux:button wire:click="$set('showNewTypeModal', false)" size="sm" variant="outline">Cancelar</flux:button>
                    <flux:button wire:click="saveNewType" size="sm" variant="primary">Crear</flux:button>
                </div>
            </div>
        </flux:modal>
    @endif

    {{-- NUEVA MARCA --}}
    @if ($showNewBrandModal)
        <flux:modal wire:model="showNewBrandModal">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Crear nueva marca</h2>

                <flux:input type="text" wire:model="newBrandName" label="Nombre de la marca" />

                @error('newBrandName')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div class="mt-6 flex justify-end gap-3">
                    <flux:button wire:click="$set('showNewBrandModal', false)" size="sm" variant="outline">Cancelar</flux:button>
                    <flux:button wire:click="saveNewBrand" size="sm" variant="primary">Crear</flux:button>
                </div>
            </div>
        </flux:modal>
    @endif

    {{-- NUEVO PROVEEDOR --}}
    @if ($showNewSupplierModal)
        <flux:modal name="new-supplier-modal" wire:model.live.defer="showNewSupplierModal" class="max-w-3xl">
            <div class="p-6 w-full">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Crear nuevo proveedor</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input label="NIT" type="text" wire:model.live="newSupplierNit" />
                    <flux:input label="Nombre del proveedor" type="text" wire:model.live="newSupplierName" />

                    <flux:select wire:model.live="newSupplierPersonType" label="Tipo de persona">
                        <option value="">Seleccione una opción</option>
                        <option value="Natural">Natural</option>
                        <option value="Juridica">Jurídica</option>
                    </flux:select>
                    <div></div>

                    <flux:input label="Correo electrónico" type="email" wire:model.live="newSupplierEmail" />
                    <flux:input label="Teléfono" type="text" wire:model.live="newSupplierPhone" />
                </div>

                {{-- Campos de representante, solo si es jurídica --}}
                @if ($newSupplierShowJuridica)
                    <hr class="my-4 border-gray-400" />
                    <h3 class="text-md font-semibold text-gray-700 dark:text-white mb-2">Datos del representante</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input label="Nombre del representante" type="text" wire:model.live="newSupplierRepName" />
                        <flux:input label="Correo del representante" type="email" wire:model.live="newSupplierRepEmail" />
                        <flux:input label="Teléfono del representante" type="text" wire:model.live="newSupplierRepPhone" />
                    </div>
                @endif

                <div class="mt-6 flex justify-end gap-3">
                    <flux:button wire:click="$set('showNewSupplierModal', false)" size="sm" variant="outline">Cancelar</flux:button>
                    <flux:button wire:click="saveNewSupplier" size="sm" variant="primary">Crear</flux:button>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
