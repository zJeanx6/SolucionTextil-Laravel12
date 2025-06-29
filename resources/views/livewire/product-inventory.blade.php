<div>
    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.products.index')"> Productos </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        @if ($view === 'index')
            <flux:button size="sm" variant="filled" wire:click="create"> Nuevo </flux:button>
        @else
            <flux:button size="sm" variant="primary" wire:click="index"> Volver </flux:button>
        @endif
    </div>

    {{-- Vista Index --}}
    @if ($view === 'index')
        <div class="card mb-4">
            <div class="flex gap-4">
                <div class="w-1/3">
                    <flux:input type="text" placeholder="Buscar productos..." wire:model.live="search" />
                </div>
                <div class="w-1/3">
                    <flux:select wire:model.live="productTypeFilter">
                        <flux:select.option value="">Filtro por Tipo</flux:select.option>
                        @foreach ($productTypes as $type)
                            <flux:select.option value="{{ $type->id }}">{{ $type->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="w-1/3">
                    <flux:select wire:model.live="colorFilter">
                        <flux:select.option value="">Filtro por Color</flux:select.option>
                        @foreach ($colors as $color)
                            <flux:select.option value="{{ $color->id }}">{{ $color->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>
        </div>

        <div class="div-table">
            <table class="table">
                <thead class="head-table">
                    <tr>
                        <th class="head-table-item cursor-pointer" wire:click="sortBy('code')">
                            Cod @include('partials.sort-icon', ['field' => 'code'])
                        </th>
                        <th class="head-table-item cursor-pointer" wire:click="sortBy('name')">
                            Nombre @include('partials.sort-icon', ['field' => 'name'])
                        </th>
                        <th class="head-table-item cursor-pointer" wire:click="sortBy('stock')">
                            Stock @include('partials.sort-icon', ['field' => 'stock'])
                        </th>
                        <th class="head-table-item cursor-pointer" wire:click="sortBy('product_type_id')">
                            Tipo @include('partials.sort-icon', ['field' => 'product_type_id'])
                        </th>
                        <th class="head-table-item cursor-pointer" wire:click="sortBy('color_id')">
                            Color @include('partials.sort-icon', ['field' => 'color_id'])
                        </th>
                        <th class="head-table-item cursor-pointer" wire:click="sortBy('size_id')">
                            Talla @include('partials.sort-icon', ['field' => 'size_id'])
                        </th>
                        <th class="head-table-item w-28 text-center">Imagen</th>
                        <th class="head-table-item">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr wire:key="product-{{ $product->code }}" class="table-content">
                            <td class="column-item">{{ $product->code }}</td>
                            <td class="column-item">{{ $product->name }}</td>
                            <td class="column-item">{{ $product->stock }}</td>
                            <td class="column-item">{{ $product->productType->name ?? '-' }}</td>
                            <td class="column-item">{{ $product->color->name ?? '-' }}</td>
                            <td class="column-item">{{ $product->size->abbreviation ?? $product->size->name ?? '-' }}</td>
                            <td class="column-item">
                                @if ($product->image && Storage::disk('public')->exists($product->image))
                                    <flux:modal.trigger name="view-image-{{ $product->code }}">
                                        <img src="{{ Storage::url($product->image) }}" alt="Imagen de {{ $product->name }}" class="w-16 h-16 cursor-pointer" />
                                    </flux:modal.trigger>
                                @else
                                    <flux:modal.trigger name="view-image-{{ $product->code }}">
                                        <img src="{{ asset('img/no-image-found.jpg') }}" alt="Imagen no disponible" class="w-16 h-16 cursor-pointer" />
                                    </flux:modal.trigger>
                                @endif

                                <flux:modal name="view-image-{{ $product->code }}" class="md:w-96">
                                    <div class="space-y-6">
                                        <div class="flex justify-center">
                                            @if ($product->image && Storage::disk('public')->exists($product->image))
                                                <img src="{{ Storage::url($product->image) }}" alt="Imagen de {{ $product->name }}" class="w-full h-auto" />
                                            @else
                                                <img src="{{ asset('img/no-image-found.jpg') }}" alt="Imagen no disponible" class="w-full h-auto" />
                                            @endif
                                        </div>
                                    </div>
                                </flux:modal>
                            </td>
                            <td class="column-item">
                                <div class="two-actions">
                                    <flux:button.group>
                                        <flux:button icon="document-magnifying-glass" size="sm" variant="filled"
                                            wire:click="show({{ $product->code }})" />
                                        <flux:button icon="pencil-square" size="sm" variant="filled"
                                            wire:click="edit({{ $product->code }})" />
                                        <flux:button icon="trash" size="sm" variant="danger"
                                            wire:click="delete({{ $product->code }})" />
                                    </flux:button.group>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mx-4 mt-4 mb-4">{{ $products->links(data: ['scrollTo' => false]) }}</div>

    {{-- CREAR PRODUCTO --}}
    @elseif ($view === 'create')
        <div class="card p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <flux:select wire:model.live="product_type_id">
                        <flux:select.option value="">Tipo de Producto</flux:select.option>
                        @foreach ($productTypes as $type)
                            <flux:select.option value="{{ $type->id }}">{{ $type->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select wire:model.live="size_id">
                        <flux:select.option value="">Talla</flux:select.option>
                        @foreach ($sizes as $size)
                            <flux:select.option value="{{ $size->id }}">{{ $size->abbreviation ?? $size->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
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
                                <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
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

                <div class="hidden lg:block w-px bg-gray-300"></div>

                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <flux:input type="number" wire:model="code" label="Código" />
                    <flux:input type="text" wire:model.live="name" label="Nombre" />
                    <flux:input type="number" wire:model="stock" label="Stock" />
                    <div class="flex justify-end">
                        <flux:button size="sm" variant="primary" wire:click="save">Guardar</flux:button>
                    </div>
                </div>
            </div>
        </div>

    {{-- EDITAR PRODUCTO --}}
    @elseif ($view === 'edit')
        <div class="card p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <flux:select wire:model.live="product_type_id">
                        <flux:select.option value="">Tipo de Producto</flux:select.option>
                        @foreach ($productTypes as $type)
                            <flux:select.option value="{{ $type->id }}">{{ $type->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select wire:model.live="size_id">
                        <flux:select.option value="">Talla</flux:select.option>
                        @foreach ($sizes as $size)
                            <flux:select.option value="{{ $size->id }}">{{ $size->abbreviation ?? $size->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select wire:model.live="color_id">
                        <flux:select.option value="">Color</flux:select.option>
                        @foreach ($colors as $color)
                            <flux:select.option value="{{ $color->id }}">{{ $color->name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    {{-- Imagen --}}
                    <div class="relative w-full h-60 bg-gray-100 rounded-md flex items-center justify-center dark:bg-[#2f2f2f]">
                        @if ($photo)
                            <label class="absolute inset-0 w-full h-full cursor-pointer">
                                <img src="{{ $photo->temporaryUrl() }}" class="object-cover w-full h-full rounded-md" />
                                <input type="file" class="hidden" wire:model="photo" accept="image/*">
                            </label>
                            <button wire:click="$set('photo', null)"
                                class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-500 flex items-center justify-center text-xs font-bold z-10">
                                &times;
                            </button>
                        @elseif ($image_path)
                            <label class="absolute inset-0 w-full h-full cursor-pointer">
                                <img src="{{ asset('storage/' . $image_path) }}" class="object-cover w-full h-full rounded-md" />
                                <input type="file" class="hidden" wire:model="photo" accept="image/*">
                            </label>
                            <button wire:click="$set('image_path', null); $set('photo', null);"
                                class="absolute top-1 right-1 w-6 h-6 rounded-full bg-white/70 hover:bg-red-500 flex items-center justify-center text-xs font-bold z-10">
                                &times;
                            </button>
                            <span class="absolute bottom-2 left-1/2 -translate-x-1/2 text-xs text-white bg-black/50 rounded px-2 py-0.5">
                                Haz clic para cambiar
                            </span>
                        @else
                            <label class="flex flex-col items-center justify-center cursor-pointer w-full h-full">
                                <span class="text-sm text-gray-500">Cargar imagen</span>
                                <input type="file" class="hidden" wire:model="photo" accept="image/*">
                            </label>
                        @endif
                    </div>
                    @error('photo')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="hidden lg:block w-px bg-gray-300"></div>

                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <flux:input type="number" wire:model="code" label="Código" disabled />
                    <flux:input type="text" wire:model="name" label="Nombre" />
                    <flux:input type="number" wire:model="stock" label="Stock" />
                    <div class="flex justify-end">
                        <flux:button variant="primary" wire:click="update">Actualizar</flux:button>
                    </div>
                </div>
            </div>
        </div>

    {{-- VER PRODUCTO --}}
    @elseif ($view === 'show')
        <div class="card p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <flux:select wire:model.live="product_type_id" disabled>
                        <flux:select.option value="">Tipo de Producto</flux:select.option>
                        @foreach ($productTypes as $type)
                            <flux:select.option value="{{ $type->id }}">{{ $type->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select wire:model.live="size_id" disabled>
                        <flux:select.option value="">Talla</flux:select.option>
                        @foreach ($sizes as $size)
                            <flux:select.option value="{{ $size->id }}">{{ $size->abbreviation ?? $size->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select wire:model.live="color_id" disabled>
                        <flux:select.option value="">Color</flux:select.option>
                        @foreach ($colors as $color)
                            <flux:select.option value="{{ $color->id }}">{{ $color->name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <div class="relative w-full h-60 bg-gray-100 rounded-md flex items-center justify-center dark:bg-[#2f2f2f]">
                        @if ($image_path)
                            <img src="{{ asset('storage/' . $image_path) }}" class="object-cover w-full h-full rounded-md" />
                        @else
                            <span class="text-sm text-gray-500">No hay imagen disponible</span>
                        @endif
                    </div>
                </div>

                <div class="hidden lg:block w-px bg-gray-300 dark:bg-gray-600"></div>

                <div class="w-full lg:w-1/2 flex flex-col gap-4">
                    <flux:input type="number" wire:model="code" label="Código" disabled />
                    <flux:input type="text" wire:model="name" label="Nombre" disabled />
                    <flux:input type="number" wire:model="stock" label="Stock" disabled />
                </div>
            </div>
        </div>
    @endif
</div>
