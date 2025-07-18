<div>
    {{-- Migaja de pan --}}
        <div class="breadcrumbs">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
                <flux:breadcrumbs.item :href="route('admin.elements.index')"> Elementos </flux:breadcrumbs.item>
            </flux:breadcrumbs>

            @if ($view === 'index')
                <flux:button size="sm" variant="filled" wire:click="create"> Nuevo </flux:button>
            @else
                <flux:button size="sm" variant="primary" wire:click="index"> Volver </flux:button>
            @endif
        </div>

    {{-- Estado del componente: Vista Principal. --}}
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

            {{-- Tabla de contenido --}}
            <div class="div-table">
                <table class="table">
                    <thead class="head-table">
                        <tr>
                            <th class="head-table-item cursor-pointer" wire:click="sortBy('code')">
                                Cod
                                @include('partials.sort-icon', ['field' => 'code'])
                            </th>

                            <th class="head-table-item cursor-pointer" wire:click="sortBy('name')">
                                Nombre
                                @include('partials.sort-icon', ['field' => 'name'])
                            </th>

                            <th class="head-table-item cursor-pointer" wire:click="sortBy('stock')">
                                Stock
                                @include('partials.sort-icon', ['field' => 'stock'])
                            </th>

                            <th class="head-table-item cursor-pointer" wire:click="sortBy('element_type_id')">
                                Tipo
                                @include('partials.sort-icon', ['field' => 'element_type_id'])
                            </th>

                            <th class="head-table-item w-28 text-center">Imagen</th>

                            <th class="head-table-item">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($elements as $element)
                            <tr wire:key="element-{{ $element->code }}" class="table-content">
                                <td class="column-item">{{ $element->code }}</td>
                                <td class="column-item">{{ $element->name }}</td>
                                <td class="column-item">{{ $element->stock }}</td>
                                <td class="column-item">{{ $element->elementType->name ?? '-' }}</td>
                                <td class="column-item">
                                    @if ($element->image && Storage::disk('public')->exists($element->image))
                                        <!-- Disparador para abrir el modal de la imagen -->
                                        <flux:modal.trigger name="view-image-{{ $element->code }}">
                                            <img src="{{ Storage::url($element->image) }}"
                                                alt="Imagen de {{ $element->name }}" class="w-16 h-16 cursor-pointer" />
                                        </flux:modal.trigger>
                                    @else
                                        <!-- Si no hay imagen, mostrar imagen por defecto -->
                                        <flux:modal.trigger name="view-image-{{ $element->code }}">
                                            <img src="{{ asset('img/no-image-found.jpg') }}" alt="Imagen no disponible"
                                                class="w-16 h-16 cursor-pointer" />
                                        </flux:modal.trigger>
                                    @endif

                                    <!-- Modal Flux para mostrar la imagen -->
                                    <flux:modal name="view-image-{{ $element->code }}" class="md:w-96">
                                        <div class="space-y-6">
                                            <div class="flex justify-center">
                                                @if ($element->image && Storage::disk('public')->exists($element->image))
                                                    <img src="{{ Storage::url($element->image) }}"
                                                        alt="Imagen de {{ $element->name }}" class="w-full h-auto" />
                                                @else
                                                    <img src="{{ asset('img/no-image-found.jpg') }}"
                                                        alt="Imagen no disponible" class="w-full h-auto" />
                                                @endif
                                            </div>
                                        </div>
                                    </flux:modal>
                                </td>
                                <td class="column-item">
                                    <div class="two-actions">
                                        <flux:button.group>
                                            @if(auth()->user()->role_id === 1)
                                                <flux:button icon="document-magnifying-glass" size="sm" variant="filled" wire:click="show({{ $element->code }})"/>
                                            @else {{-- Estilo diferente sino es admin - Detalle --}}
                                                <flux:button icon="document-magnifying-glass" size="sm" variant="filled" wire:click="show({{ $element->code }})"> Detalle </flux:button>
                                            @endif

                                            {{-- Solo para role_id = 1 (admin) --}}
                                            @if(auth()->user()->role_id === 1)
                                                <flux:button icon="pencil-square" size="sm" variant="filled" wire:click="edit({{ $element->code }})" />
                                                <flux:button icon="trash" size="sm" variant="danger" wire:click="delete({{ $element->code }})" />
                                            @endif
                                        </flux:button.group>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-4 text-center text-gray-500 italic"> No se encontraron elementos. </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mx-4 mt-4 mb-4">{{ $elements->links(data: ['scrollTo' => false]) }}</div>

    {{-- Estado del componente: Vista Crear Elemento. --}}
        @elseif ($view === 'create')

            <div class="card p-6">
                <div class="flex flex-col lg:flex-row gap-6">
                    {{-- IZQUIERDA: select tipo, imagen, solo para metraje inputs extra --}}
                    <div class="w-full lg:w-1/2 flex flex-col gap-4">
                        {{-- Tipo --}}
                        <flux:select wire:model.live="change_type_id">
                            <flux:select.option value="">Tipo de Elemento</flux:select.option>
                            @foreach ($elementTypes as $type)
                                <flux:select.option value="{{ $type->id }}">{{ $type->id }} {{ $type->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>

                        {{-- Imagen --}}
                        <div
                            class="relative w-full h-60 bg-gray-100 rounded-md flex items-center justify-center dark:bg-[#2f2f2f]">
                            @if ($elementCreate->photo)
                                <img src="{{ $elementCreate->photo->temporaryUrl() }}"
                                    class="absolute inset-0 object-cover w-full h-full rounded-md" />
                                <button wire:click="$set('elementCreate.photo', null)"
                                    class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-500 flex items-center justify-center text-xs font-bold">
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

                        {{-- Para metraje: inputs extra --}}
                        @if ($elementCreate->isMetrajeType())
                            <div class="flex gap-2">
                                <flux:input type="number" step="0.01" wire:model="elementCreate.broad"
                                    label="Ancho (m)" />
                                <flux:input type="number" step="0.01" wire:model="elementCreate.long"
                                    label="Largo (m)" />
                            </div>
                            <flux:input type="number" min="1" max="20"
                                wire:model.live="elementCreate.roll_count" label="Cantidad de rollos" />
                        @endif
                    </div>

                    {{-- DIVISOR --}}
                    <div class="hidden lg:block w-px bg-gray-300"></div>

                    {{-- DERECHA: código, nombre, color (si aplica), stock (si aplica), rollos (si metraje) --}}
                    <div class="w-full lg:w-1/2 flex flex-col gap-4">
                        <flux:input type="number" wire:model="elementCreate.code" label="Código" />
                        <flux:input type="text" wire:model.live="elementCreate.name" label="Nombre" />
                        @if (in_array('color_id', $elementCreate->visibleFields))
                            <flux:select label="Color" wire:model="elementCreate.color_id">
                                <flux:select.option value="" disabled>Selecciona color</flux:select.option>
                                @foreach ($colors as $color)
                                    <flux:select.option value="{{ $color->id }}">{{ $color->name }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        @endif
                        @if (in_array('stock', $elementCreate->visibleFields))
                            <flux:input type="number" wire:model="elementCreate.stock" label="Stock" />
                        @endif

                        {{-- Para metraje: códigos de rollos --}}
                        @if ($elementCreate->isMetrajeType() && $elementCreate->roll_count)
                            <div class="mt-2">
                                <div class="text-sm font-medium mb-1">Códigos de rollos:</div>
                                @for ($i = 0; $i < $elementCreate->roll_count; $i++)
                                    <flux:input type="number" wire:model="elementCreate.roll_codes.{{ $i }}"
                                        label="Código rollo #{{ $i + 1 }}" />
                                @endfor
                            </div>
                        @endif

                        <div class="flex justify-end">
                            <flux:button size="sm" variant="primary" wire:click="save">Guardar</flux:button>
                        </div>
                    </div>
                </div>
            </div>

    {{-- Estado del componente: Vista Editar Elemento. --}}
        @elseif ($view === 'edit')
        
            {{-- =====================================  CARD #1  ===================================== --}}
            <div class="card p-6">
                <div class="flex flex-col lg:flex-row gap-6">
                    {{-- ---------------------------- COLUMNA IZQUIERDA ---------------------------- --}}
                    <div class="w-full lg:w-1/2 flex flex-col gap-4">
                        {{-- Tipo / categoría --}}
                        <flux:select wire:model.live="elementEdit.element_type_id" disabled>
                            <flux:select.option value=""> Tipo de Elemento </flux:select.option>
                            @foreach ($elementTypes as $type)
                                <flux:select.option value="{{ $type->id }}">
                                    {{ $type->id }} — {{ $type->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>

                        {{-- Recuadro de imagen --}}
                        <div
                            class="relative w-full h-60 bg-gray-100 rounded-md flex items-center justify-center dark:bg-[#2f2f2f]">
                            {{-- 1) Foto temporal nueva --}}
                            @if ($elementEdit->photo)
                                <label class="absolute inset-0 w-full h-full cursor-pointer">
                                    <img src="{{ $elementEdit->photo->temporaryUrl() }}"
                                        class="object-cover w-full h-full rounded-md" />
                                    <input type="file" class="hidden" wire:model="elementEdit.photo"
                                        accept="image/*">
                                </label>
                                <button wire:click="$set('elementEdit.photo', null)"
                                    class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-500 flex items-center justify-center text-xs font-bold z-10">
                                    &times;
                                </button>

                                {{-- 2) Foto guardada --}}
                            @elseif ($elementEdit->image_path)
                                <label class="absolute inset-0 w-full h-full cursor-pointer">
                                    <img src="{{ asset('storage/' . $elementEdit->image_path) }}"
                                        class="object-cover w-full h-full rounded-md" />
                                    <input type="file" class="hidden" wire:model="elementEdit.photo"
                                        accept="image/*">
                                </label>
                                <button wire:click="$set('elementEdit.image_path', null); $set('elementEdit.photo', null);"
                                    class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-500 flex items-center justify-center text-xs font-bold z-10">
                                    &times;
                                </button>
                                <span
                                    class="absolute bottom-2 left-1/2 -translate-x-1/2 text-xs text-white bg-black/50 rounded px-2 py-0.5">
                                    Haz clic para cambiar
                                </span>

                                {{-- 3) Sin imagen --}}
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

                    {{-- ---------------------------- COLUMNA DERECHA ---------------------------- --}}
                    <div class="w-full lg:w-1/2 flex flex-col gap-4">
                        <flux:input type="number" wire:model="elementEdit.code" label="Código" disabled />
                        <flux:input type="text" wire:model="elementEdit.name" label="Nombre" />

                        @if (in_array('color_id', $elementEdit->visibleFields))
                            <flux:select label="Color" wire:model="elementEdit.color_id">
                                <flux:select.option value="" disabled>Selecciona color</flux:select.option>
                                @foreach ($colors as $color)
                                    <flux:select.option value="{{ $color->id }}">{{ $color->name }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        @endif

                        @if (in_array('stock', $elementEdit->visibleFields))
                            <flux:input type="number" wire:model="elementEdit.stock" label="Stock" />
                        @endif

                        @if (in_array('broad', $elementEdit->visibleFields))
                            <flux:input type="number" step="0.01" wire:model="elementEdit.broad"
                                label="Ancho (m)" />
                        @endif

                        @if (in_array('long', $elementEdit->visibleFields))
                            <flux:input type="number" step="0.01" wire:model="elementEdit.long" label="Largo (m)" />
                        @endif

                        <div class="flex justify-end">
                            <flux:button variant="primary" wire:click="update">Actualizar</flux:button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- =====================================  CARD #2  ===================================== --}}
            @if ($elementEdit->isMetrajeType())
                <div class="card p-6 mt-6">
                    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 mb-4">Rollos asociados</h3>

                    {{-- Grid 2 columnas en desktop --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse ($elementEdit->rolls as $roll)
                            <div class="flex flex-col gap-2 border border-gray-200 dark:border-gray-700 rounded-md p-4">
                                <div class="font-medium text-gray-700 dark:text-gray-300">
                                    Código:
                                    <span class="text-blue-500 dark:text-blue-400">{{ $roll->code }}</span>
                                </div>

                                {{-- Grid interna para ancho / largo --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <flux:input type="number" label="Ancho (m)" :disabled="true"
                                        value="{{ number_format($roll->broad, 2) }}"
                                        input-class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200" />

                                    <flux:input type="number" step="0.01"
                                        wire:model="elementEdit.rollLongs.{{ $roll->code }}" label="Largo (m)"
                                        input-class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200" />
                                </div>
                            </div>
                        @empty
                            <div class="text-gray-500 italic">No hay rollos asociados a este elemento.</div>
                        @endforelse
                    </div>
                </div>
            @endif
                
    {{-- Estado del componente: Vista Ver Elemento. --}}
        @elseif($view === 'show')
            <div class="card p-6">
                <div class="flex flex-col lg:flex-row gap-6">
                    {{-- ---------------------------- COLUMNA IZQUIERDA ---------------------------- --}}
                    <div class="w-full lg:w-1/2 flex flex-col gap-4">
                        {{-- Tipo / Categoría --}}
                        <flux:select wire:model.live="elementShow.element_type_id" disabled>
                            <flux:select.option value=""> Tipo de Elemento </flux:select.option>
                            @foreach ($elementTypes as $type)
                                <flux:select.option value="{{ $type->id }}">
                                    {{ $type->id }} — {{ $type->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>

                        {{-- Imagen --}}
                        <div
                            class="relative w-full h-60 bg-gray-100 rounded-md flex items-center justify-center dark:bg-[#2f2f2f]">
                            @if ($elementShow->image_path)
                                <img src="{{ asset('storage/' . $elementShow->image_path) }}"
                                    class="object-cover w-full h-full rounded-md" />
                            @else
                                <span class="text-sm text-gray-500">No hay imagen disponible</span>
                            @endif
                        </div>
                    </div>

                    {{-- ---------------------------- DIVISOR ---------------------------- --}}
                    <div class="hidden lg:block w-px bg-gray-300 dark:bg-gray-600"></div>

                    {{-- ---------------------------- COLUMNA DERECHA ---------------------------- --}}
                    <div class="w-full lg:w-1/2 flex flex-col gap-4">
                        {{-- Código --}}
                        <flux:input type="number"
                                    wire:model="elementShow.code"
                                    label="Código"
                                    disabled />

                        {{-- Nombre --}}
                        <flux:input type="text"
                                    wire:model="elementShow.name"
                                    label="Nombre"
                                    disabled />

                        {{-- Color (solo si aplica) --}}
                        @if(in_array('color_id', $elementShow->visibleFields))
                            <flux:select label="Color"
                                        wire:model="elementShow.color_id"
                                        disabled>
                                <flux:select.option value="" disabled> Selecciona color </flux:select.option>
                                @foreach ($colors as $color)
                                    <flux:select.option value="{{ $color->id }}">{{ $color->name }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        @endif

                        {{-- Stock --}}
                        <flux:input type="number"
                                    wire:model="elementShow.stock"
                                    label="Stock"
                                    disabled />
                    </div>
                </div>
            </div>

            {{-- ================================ CARD #2: ROLLOS DISPONIBLES ================================ --}}
            @if($elementShow->isMetrajeType())
                <div class="card p-6 mt-6">
                    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 mb-4">
                        Rollos disponibles
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse ($elementShow->activeRolls as $roll)
                            <div class="flex flex-col gap-2 border border-gray-200 dark:border-gray-700 rounded-md p-4">
                                <div class="font-medium text-gray-700 dark:text-gray-300">
                                    Código:
                                    <span class="text-blue-500 dark:text-blue-400">{{ $roll->code }}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <flux:input
                                        type="number"
                                        label="Ancho (m)"
                                        :disabled="true"
                                        value="{{ number_format($roll->broad, 2) }}"
                                        input-class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                                    />
                                    <flux:input
                                        type="number"
                                        step="0.01"
                                        label="Largo (m)"
                                        :disabled="true"
                                        value="{{ number_format($roll->long, 2) }}"
                                        input-class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                                    />
                                </div>
                            </div>
                        @empty
                            <div class="text-gray-500 italic">No hay rollos disponibles.</div>
                        @endforelse
                    </div>

                    <div class="flex justify-end mt-4">
                        <flux:button size="sm"
                                    variant="outline"
                                    wire:click="toggleInactive">
                            {{ $elementShow->showInactive ? 'Ocultar agotados' : 'Ver agotados' }}
                        </flux:button>
                    </div>
                </div>

                {{-- =============================== CARD #3: ROLLOS AGOTADOS =============================== --}}
                @if ($elementShow->showInactive)
                    <div class="card p-6 mt-6">
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 mb-4">
                            Rollos agotados
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse ($elementShow->inactiveRolls as $roll)
                                <div class="flex flex-col gap-2 border border-red-200 dark:border-red-700 rounded-md p-4 bg-red-50 dark:bg-red-900/20">
                                    <div class="font-medium text-gray-700 dark:text-gray-300">
                                        Código:
                                        <span class="text-red-500 dark:text-red-400">{{ $roll->code }}</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <flux:input
                                            type="number"
                                            label="Ancho (m)"
                                            :disabled="true"
                                            value="{{ number_format($roll->broad, 2) }}"
                                            input-class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                                        />
                                        <flux:input
                                            type="number"
                                            step="0.01"
                                            label="Largo (m)"
                                            :disabled="true"
                                            value="{{ number_format($roll->long, 2) }}"
                                            input-class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                                        />
                                    </div>
                                </div>
                            @empty
                                <div class="text-gray-500 italic">No hay rollos agotados.</div>
                            @endforelse
                        </div>
                    </div>
                @endif
            @endif
        @endif
</div>
