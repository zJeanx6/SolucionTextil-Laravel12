<div>
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.types.index')">Tipos</flux:breadcrumbs.item>
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
                    <flux:select label="Lista de Tipos/Categorias" wire:model.live="modelSelected">
                        <flux:select.option value="element_types">Elementos</flux:select.option>
                        <flux:select.option value="product_types">Productos</flux:select.option>
                        <flux:select.option value="machine_types">Máquinas</flux:select.option>
                    </flux:select>
                </div>
                <div class="w-1/2">
                    <flux:input label="Barra de Búsqueda" type="text" wire:model.live="search" class="hover-input"
                        name="search" placeholder="Buscar por nombre..." />
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="head-table">
                    <tr>
                        <th scope="col" class="px-6 py-2 text-center dark:text-white">NOMBRE</th>
                        <th scope="col" class="px-6 py-2 text-center dark:text-white">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($types as $type)
                        <tr wire:key="type-{{ $type->id }}" class="table-content">
                            <td class="px-6 py-2 text-center">{{ $type->name }}</td>
                            <td class="px-6 py-2 text-center">
                                <div class="flex justify-center gap-2">
                                    <flux:button.group>
                                        <flux:button size="sm" variant="primary" wire:click="edit({{ $type->id }})">
                                            Editar
                                        </flux:button>
                                        <flux:button size="sm" variant="danger" wire:click="delete({{ $type->id }})">
                                            Eliminar
                                        </flux:button>
                                    </flux:button.group>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mx-4 mt-4 mb-4">{{ $types->links() }}</div>
    @elseif ($view === 'create')
        <div class="card">
            <flux:select label="Selecciona un Tipo/Categoria a Crear" class="mb-4" wire:model="modelSelected">
                <flux:select.option value="element_types">Elementos</flux:select.option>
                <flux:select.option value="product_types">Productos</flux:select.option>
                <flux:select.option value="machine_types">Máquinas</flux:select.option>
            </flux:select>

            <flux:input type="text" wire:model="name" class="hover-input mb-4" label="Nombre" name="name"
                placeholder="Nombre del tipo..." />

            <div class="flex justify-end">
                <flux:button wire:click="save" variant="primary" type="submit">Guardar</flux:button>
            </div>
        </div>
    @elseif ($view === 'edit')
        <div class="card">
            <flux:select class="mb-4" wire:model="modelSelected">
                <flux:select.option value="element_types">Elementos</flux:select.option>
                <flux:select.option value="product_types">Productos</flux:select.option>
                <flux:select.option value="machine_types">Máquinas</flux:select.option>
            </flux:select>

            <flux:input type="text" wire:model="name" class="hover-input mb-4" label="Nombre" name="name"
                placeholder="Nombre del tipo..." />

            <div class="flex justify-end">
                <flux:button wire:click="update" variant="primary" type="submit">Actualizar</flux:button>
            </div>
        </div>
    @endif
</div>
