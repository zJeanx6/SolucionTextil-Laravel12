<div>
    <div class="flex justify-between items-center -mt-4 mb-3">
        {{-- h-6 top-8 z-10 px-4 mb-6 --}}
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.elements.index')">Elementos</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        @if ($view === 'index')
            <flux:button size="sm" variant="primary" wire:click="create">Nuevo</flux:button>
        @else
            <flux:button size="sm" variant="primary" wire:click="index">Volver</flux:button>
        @endif
    </div>

    @if ($view === 'index')

        {{-- Barra de búsqueda --}}
        <div class="card mb-4">
            <div class="flex gap-4">
                <div class="w-1/3">
                    <flux:input type="text" placeholder="Buscar elementos..." wire:model.live="search" />
                </div>

                {{-- Filtro por tipo de elemento --}}
                <div class="w-1/3">
                    <flux:select wire:model.live="elementTypeFilter" class="border rounded px-2 py-1">
                        <flux:select.option value="">Filtro por Tipo</flux:select.option>
                        @foreach ($this->elementTypes as $t)
                            <flux:select.option value="{{ $t->id }}">{{ $t->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                {{-- Filtro por color --}}
                <div class="w-1/3">
                    <flux:select wire:model.live="colorFilter" class="border rounded px-2 py-1">
                        <flux:select.option value="">Filtro por Color</flux:select.option>
                        @foreach ($this->colors as $c)
                            <flux:select.option value="{{ $c->id }}">{{ $c->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>
        </div>


        {{-- Tabla --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="table">
                <thead class="head-table">
                    <tr>
                        {{-- Cada <th> ordena al hacer clic --}}
                        <th class="head-table-item cursor-pointer" wire:click="sortBy('code')">
                            Codigo
                            @include('partials.sort-icon', ['field' => 'code'])
                        </th>

                        <th class="head-table-item cursor-pointer" wire:click="sortBy('name')">
                            Nombre
                            @include('partials.sort-icon', ['field' => 'name'])
                        </th>

                        <th class="head-table-item cursor-pointer" wire:click="sortBy('stock')">
                            Stock Actual
                            @include('partials.sort-icon', ['field' => 'stock'])
                        </th>

                        <th class="head-table-item cursor-pointer" wire:click="sortBy('element_type_id')">
                            Tipo/Categoria
                            @include('partials.sort-icon', ['field' => 'element_type_id'])
                        </th>

                        <th class="head-table-item">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($elements as $element)
                        <tr wire:key="element-{{ $element->code }}" class="table-content">
                            <td class="column-item">{{ $element->code }}</td>
                            <td class="column-item">{{ $element->name }}</td>
                            <td class="column-item">{{ $element->stock }}</td>
                            <td class="column-item">{{ $element->type->name ?? '-' }}</td>

                            <td class="column-item">
                                <div class="two-actions">
                                    <flux:button.group>
                                        {{-- <flux:button size="sm" variant="filled">Detalle</flux:button> --}}
                                        <flux:button size="xs" variant="primary"
                                            wire:click="edit({{ $element->code }})">Editar</flux:button>
                                        <flux:button size="xs" variant="danger"
                                            wire:click="delete({{ $element->code }})">Eliminar</flux:button>
                                    </flux:button.group>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mx-4 mt-4 mb-4">{{ $elements->links(data: ['scrollTo' => false]) }}</div>
    @elseif ($view === 'create')
        <div class="card p-6">
            <div class="flex flex-col lg:flex-row gap-6">

                {{-- COLUMNA IZQUIERDA --}}
                <div class="w-full lg:w-1/2 flex flex-col gap-4">

                    {{-- tipo / categoría --}}
                    <flux:select wire:model.live="elementCreate.element_type_id">
                        <flux:select.option value=""> Tipo de Elemento </flux:select.option>
                        @foreach ($elementTypes as $type)
                            <flux:select.option value="{{ $type->id }}">{{ $type->id }} {{ $type->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>

                    {{-- recuadro de imagen --}}
                    <div
                        class="relative w-full h-60 bg-gray-100 rounded-md flex items-center justify-center dark:bg-[#2f2f2f]">
                        @if ($elementCreate->photo)
                            <img src="{{ $elementCreate->photo->temporaryUrl() }}"
                                class="absolute inset-0 object-cover w-full h-full rounded-md" />
                            <button wire:click="$set('elementCreate.photo', null)"
                                class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-500
                                   flex items-center justify-center text-xs font-bold">
                                &times;
                            </button>
                        @else
                            <div class="mb-4">
                                <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                                    x-on:livewire-upload-finish="uploading = false"
                                    x-on:livewire-upload-cancel="uploading = false"
                                    x-on:livewire-upload-error="uploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <label
                                        class="flex flex-col items-center justify-center cursor-pointer w-full h-full">
                                        <span wire:loading.class="hidden" class="text-sm text-gray-500">Cargar
                                            imagen</span>
                                        <input type="file" class="hidden" wire:model="elementCreate.photo"
                                            accept="image/*">
                                    </label>
                                    <div x-show="uploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @error('elementCreate.photo')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- divisor --}}
                <div class="hidden lg:block w-px bg-gray-300"></div>

                {{-- COLUMNA DERECHA --}}
                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <flux:input type="number" wire:model="elementCreate.code" label="Código" />
                    <flux:input type="text" wire:model.live="elementCreate.name" label="Nombre" />
                    @if (in_array('broad', $visibleFields))
                        <flux:input type="number" step="0.01" wire:model="elementCreate.broad" label="Ancho (m)" />
                    @endif
                    @if (in_array('long', $visibleFields))
                        <flux:input type="number" step="0.01" wire:model="elementCreate.long" label="Largo (m)" />
                    @endif
                    @if (in_array('color_id', $visibleFields))
                        <flux:select label="Color" wire:model="elementCreate.color_id">
                            <flux:select.option value="" disabled> Selecciona color </flux:select.option>
                            @foreach ($colors as $color)
                                <flux:select.option value="{{ $color->id }}">{{ $color->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                    @endif
                    <flux:input type="number" wire:model="elementCreate.stock" label="Stock" />
                    <div class="flex justify-end">
                        <flux:button variant="primary" wire:click="save">Guardar</flux:button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== FORMULARIO EDIT ===================== --}}
    @elseif ($view === 'edit')
        <div class="card p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                {{-- COLUMNA IZQUIERDA --}}
                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <flux:select wire:model.live="elementEdit.element_type_id">
                        <flux:select.option value=""> Tipo de Elemento </flux:select.option>
                        @foreach ($elementTypes as $type)
                            <flux:select.option value="{{ $type->id }}">
                                {{ $type->id }} — {{ $type->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <div
                        class="relative w-full h-60 bg-gray-100 rounded-md flex items-center justify-center dark:bg-[#2f2f2f]">
                        {{-- Si hay imagen temporal cargada --}}
                        @if ($elementEdit->photo)
                            <label class="absolute inset-0 w-full h-full cursor-pointer">
                                <img src="{{ $elementEdit->photo->temporaryUrl() }}"
                                    class="object-cover w-full h-full rounded-md" />
                                <input type="file" class="hidden" wire:model="elementEdit.photo"
                                    accept="image/*">
                            </label>
                            {{-- Botón equis para quitar la temporal --}}
                            <button wire:click="$set('elementEdit.photo', null)"
                                class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-500 flex items-center justify-center text-xs font-bold z-10">
                                &times;
                            </button>
                            {{-- Si hay imagen guardada --}}
                        @elseif ($elementEdit->image_path)
                            <label class="absolute inset-0 w-full h-full cursor-pointer">
                                <img src="{{ asset('storage/' . $elementEdit->image_path) }}"
                                    class="object-cover w-full h-full rounded-md" />
                                <input type="file" class="hidden" wire:model="elementEdit.photo"
                                    accept="image/*">
                            </label>
                            {{-- Botón equis para quitar la imagen de BD (opcional: solo resetea el input) --}}
                            <button
                                wire:click="$set('elementEdit.image_path', null); $set('elementEdit.photo', null);"
                                class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-500 flex items-center justify-center text-xs font-bold z-10">
                                &times;
                            </button>
                            {{-- Tooltip o texto --}}
                            <span
                                class="absolute bottom-2 left-1/2 -translate-x-1/2 text-xs text-white bg-black/50 rounded px-2 py-0.5">Haz
                                clic para cambiar</span>
                            {{-- Si no hay imagen --}}
                        @else
                            <label class="flex flex-col items-center justify-center cursor-pointer w-full h-full">
                                <span class="text-sm text-gray-500">Cargar imagen</span>
                                <input type="file" class="hidden" wire:model="elementEdit.photo"
                                    accept="image/*">
                            </label>
                        @endif
                    </div>

                    @error('elementEdit.photo')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="hidden lg:block w-px bg-gray-300"></div>
                {{-- COLUMNA DERECHA --}}
                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <flux:input type="number" wire:model="elementEdit.code" label="Código" disabled />
                    <flux:input type="text" wire:model="elementEdit.name" label="Nombre" />
                    @if (in_array('broad', $visibleFields))
                        <flux:input type="number" step="0.01" wire:model="elementEdit.broad"
                            label="Ancho (m)" />
                    @endif
                    @if (in_array('long', $visibleFields))
                        <flux:input type="number" step="0.01" wire:model="elementEdit.long" label="Largo (m)" />
                    @endif
                    @if (in_array('color_id', $visibleFields))
                        <flux:select label="Color" wire:model="elementEdit.color_id">
                            <flux:select.option value="" disabled> Selecciona color </flux:select.option>
                            @foreach ($colors as $color)
                                <flux:select.option value="{{ $color->id }}">{{ $color->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                    @endif
                    <flux:input type="number" wire:model="elementEdit.stock" label="Stock" />
                    <div class="flex justify-end gap-2 mt-2">
                        <flux:button variant="primary" wire:click="index">Cancelar</flux:button>
                        <flux:button variant="primary" wire:click="update">Actualizar</flux:button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @script
        <script>
            Livewire.on('notification', function(notification) {
                var isDarkMode = document.documentElement.classList.contains('dark');
                var toastBackgroundColor = isDarkMode ?
                    'linear-gradient(to right, #444444, #666666)' // modo oscuro
                    :
                    'linear-gradient(to right, #333333, #666666)'; // modo claro
                Toastify({
                    text: notification[0],
                    duration: 2000,
                    // close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: toastBackgroundColor,
                    className: "toast-notification",
                    style: {
                        borderRadius: "10px",
                    }
                }).showToast();
            });
        </script>
    @endscript
</div>
