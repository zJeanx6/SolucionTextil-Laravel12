<div>
    {{-- Migaja de pan --}}

        <div class="breadcrumbs">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
                <flux:breadcrumbs.item :href="route('admin.types.index')"> Tipos </flux:breadcrumbs.item>
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
                        <flux:select label="Filtro" wire:model.live="modelSelected">
                            <flux:select.option value="element_types"> Tipos de Elementos </flux:select.option>
                            <flux:select.option value="product_types"> Tipos de Productos </flux:select.option>
                            <flux:select.option value="machine_types"> Tipos de Máquinas </flux:select.option>
                        </flux:select>
                    </div>
                    <div class="w-1/2">
                        <flux:input label="Barra de Búsqueda" type="text" wire:model.live="search" class="hover-input"
                            name="search" placeholder="Buscar por nombre..." />
                    </div>
                </div>
            </div>

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

    {{-- Estado del componente: Vista Crear nuevo Tipo/Categoria. --}}
        @elseif ($view === 'create')

            <div class="card">
                <flux:select label="Selecciona un Tipo/Categoria a Crear" class="mb-4" wire:model="modelSelected">
                    <flux:select.option value="element_types"> Tipos de Elementos </flux:select.option>
                    <flux:select.option value="product_types"> Tipos de Productos </flux:select.option>
                    <flux:select.option value="machine_types"> Tipos de Máquinas </flux:select.option>
                </flux:select>

                <flux:input type="text" wire:model="name" class="hover-input mb-4" label="Nombre" name="name"
                    placeholder="Nombre del tipo..." />

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
