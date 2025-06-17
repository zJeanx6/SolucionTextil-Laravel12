<div>
    {{-- Migaja de pan --}}
        <div class="breadcrumbs">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
                <flux:breadcrumbs.item :href="route('admin.types.index')"> Gestión de Categorías </flux:breadcrumbs.item>
            </flux:breadcrumbs>

            @if ($view === 'index')
                <flux:button size="sm" variant="primary" wire:click="create"> Nuevo </flux:button>
            @else
                <flux:button size="sm" variant="primary" wire:click="index"> Volver </flux:button>
            @endif
        </div>

    {{-- Estado del componente: Vista principal. --}}
        @if ($view === 'index')
        
        {{-- Barra de acciones de la vista principal. --}}
            <div class="card mb-4">
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <flux:select wire:model.live="modelSelected">
                            <flux:select.option value="" disabled> Seleccione Categoría </flux:select.option>
                            <flux:select.option value="element_types"> Elementos </flux:select.option>
                            <flux:select.option value="product_types"> Productos </flux:select.option>
                            <flux:select.option value="machine_types"> Máquinas </flux:select.option>
                        </flux:select>
                    </div>
                    <div class="w-1/2">
                        <flux:input type="text" wire:model.live.debounce.500ms="search" 
                            class="hover-input" name="search" placeholder="Buscar por nombre..." />
                    </div>
                </div>
            </div>

        @if (! $modelSelected)
            <div class="p-4 text-gray-600">
                Por favor selecciona un filtro para ver la tabla.
            </div>
        @else
            {{-- Tabla de contenido para tipos/categorias. --}}
            <div class="div-table">
                <table class="table">
                    <thead class="head-table">
                        <tr>
                            <th class="head-table-item"> Nombre </th>
                            <th class="head-table-item"> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($types as $type)
                            <tr wire:key="type-{{ $type->id }}" class="table-content">
                                <td class="column-item">{{ $type->name }}</td>
                                <td class="column-item">
                                    <div class="two-actions">
                                        <flux:button.group>
                                            <flux:button icon="pencil-square" size="sm" variant="primary"
                                                wire:click="edit({{ $type->id }})" />
                                            <flux:button icon="trash" size="sm" variant="danger"
                                                wire:click="delete({{ $type->id }})" />
                                        </flux:button.group>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="mx-4 mt-4 mb-4">{{ $types->links() }}</div>
        @endif

    {{-- Estado del componente: Vista Crear nuevo Tipo/Categoría. --}}
        @elseif ($view === 'create')

            <div class="card">
                <flux:select label="Vas a crear una categoria de..." class="mb-4" wire:model.live="modelSelected" disabled>
                    <flux:select.option value="element_types"> Elementos </flux:select.option>
                    <flux:select.option value="product_types"> Productos </flux:select.option>
                    <flux:select.option value="machine_types"> Máquinas </flux:select.option>
                </flux:select>

                <flux:input type="text" wire:model="name" class="hover-input mb-4" label="Nombre" name="name"
                    placeholder="Nombre del tipo..." />
                    
                @if ($modelSelected === 'element_types')
                    <flux:radio.group label="Seleccione el Grupo del Tipo de Elemento" wire:model="elementGroup" class="mb-4">
                        <flux:radio name="elementGroup" value="G-01" label="G-01: Metraje consumible" description="p. ej. metrajes, telas, cintas…" />
                        <flux:radio name="elementGroup" value="G-02" label="G-02: Accesorio consumible" description="p. ej. hilos, botones, etiquetas…" />
                        <flux:radio name="elementGroup" value="G-03" label="G-03: Herramienta prestada" description="p. ej. tijeras, cortahilos, reglas…" />
                        <flux:radio name="elementGroup" value="G-04" label="G-04: Consumible mínimo" description="p. ej. agujas, alfileres, dedales…" />
                    </flux:radio.group>
                @endif

                <div class="flex justify-end">
                    <flux:button size="sm" wire:click="save" variant="primary" type="submit"> Guardar </flux:button>
                </div>
            </div>

    {{-- Estado del componente: Vista editar Tipo/Categoria. --}}
        @elseif ($view === 'edit')

            <div class="card">
                <flux:input type="text" wire:model="name" class="hover-input mb-4" label="Nombre" name="name"
                    placeholder="Nombre del tipo..." />

                <div class="flex justify-end">
                    <flux:button size="sm" variant="primary" wire:click="update">Actualizar</flux:button>
                </div>
            </div>

        @endif
</div>
