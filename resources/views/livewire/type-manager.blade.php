<div>
    <div class="h-4 flex justify-between items-center top-8 z-10 px-4 mb-6">
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
        {{-- Vista de listado --}}
        <div class="flex gap-4 mb-4">
            <div class="w-1/2">
                <flux:select wire:model.live="modelSelected">
                    <flux:select.option value="element_types">Tipos de Elementos</flux:select.option>
                    <flux:select.option value="product_types">Tipos de Productos</flux:select.option>
                    <flux:select.option value="machine_types">Tipos de Máquinas</flux:select.option>
                </flux:select>
            </div>
            <div class="w-1/2">
                <flux:input type="text" wire:model.live="search" class="hover-input" name="search"
                    placeholder="Buscar por nombre..." />
            </div>
        </div>


        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead
                    class="text border-b dark:border-zinc-700 border-gray-200 text-gray-700 uppercase bg-gray-50 dark:bg-zinc-900 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center dark:text-white">NOMBRE</th>
                        <th scope="col" class="px-6 py-3 text-center dark:text-white">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($types as $type)
                        <tr
                            class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-zinc-800">
                            <td class="px-6 py-4 text-center">{{ $type->name }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <flux:button.group>
                                        <flux:button size="sm" variant="primary"
                                            wire:click="edit({{ $type->id }})">Editar</flux:button>
                                        <flux:button size="sm" variant="danger"
                                            wire:click="delete({{ $type->id }})">Eliminar</flux:button>
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
        {{-- Formulario de creación --}}
        <flux:select class="mb-4" wire:model="modelSelected">
            <flux:select.option value="element_types">Tipos de Elementos</flux:select.option>
            <flux:select.option value="product_types">Tipos de Productos</flux:select.option>
            <flux:select.option value="machine_types">Tipos de Máquinas</flux:select.option>
        </flux:select>

        <flux:input type="text" wire:model="name" class="hover-input mb-4" label="Nombre" name="name"
            placeholder="Nombre del tipo..." />

        <div class="flex justify-end">
            <flux:button wire:click="save" variant="primary" type="submit">Guardar</flux:button>
        </div>
    @elseif ($view === 'edit')
        {{-- Formulario de edición --}}
        <flux:select class="mb-4" wire:model="modelSelected">
            <flux:select.option value="element_types">Tipos de Elementos</flux:select.option>
            <flux:select.option value="product_types">Tipos de Productos</flux:select.option>
            <flux:select.option value="machine_types">Tipos de Máquinas</flux:select.option>
        </flux:select>

        <flux:input type="text" wire:model="name" class="hover-input mb-4" label="Nombre" name="name"
            placeholder="Nombre del tipo..." />

        <div class="flex justify-end">
            <flux:button wire:click="update" variant="primary" type="submit">Actualizar</flux:button>
        </div>
    @endif
</div>
