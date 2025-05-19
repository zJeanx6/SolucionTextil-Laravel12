<div>
    <div class="breadcrumbs-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.maintenance.index')">Tipos de mantenimiento</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        @if ($view === 'index')
            <flux:button size="sm" variant="primary" wire:click="create">Nuevo</flux:button>
        @else
            <flux:button size="sm" variant="primary" wire:click="index">Volver</flux:button>
        @endif
    </div>
    <div class="w-full mb-6">
        <flux:input 
            label="Barra de Búsqueda" type="text" wire:model.live="search" class="hover-input w-2/3 mx-auto px-4 py-2 border border-gray-300 rounded-md focus:outline-none  bg-white" name="search" placeholder="Buscar tipo de mantenimiento..." />
    </div>

    @if ($view === 'index')
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="head-table">
                    <tr>
                        <th scope="col" class="px-6 py-2 text-center dark:text-white">NOMBRE</th>
                        <th scope="col" class="px-6 py-2 text-center dark:text-white">DESCRIPCIÓN</th>
                        <th scope="col" class="px-6 py-2 text-center dark:text-white">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($maintenanceTypes as $type)
                        <tr class="table-content">
                            <th scope="row" class="px-6 py-4 text-center font-medium whitespace-nowrap">
                                {{ $type->name }}</th>
                            <td class="px-6 py-4 text-center uppercase">{{ $type->description }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center">
                                    <flux:button size="sm" variant="primary"
                                        wire:click="edit({{ $type->id }})">Editar</flux:button>
                                    <flux:button size="sm" variant="danger"
                                        wire:click="delete({{ $type->id }})">Eliminar</flux:button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>      
        <div class="mx-4 mt-4 mb-4">{{ $maintenanceTypes->links() }}</div>
    @elseif ($view === 'create')
        <div class="card">
            <form wire:submit.prevent="save">
                @csrf
                <div class="mb-4">
                    <flux:input class="hover-input" label="Nombre" wire:model="name" placeholder="Escribe el nombre del tipo de mantenimiento">Nombre</flux:input>
                </div>

                <div class="mb-4">
                    <flux:input class="hover-input" label="Descripción" wire:model="description" placeholder="Escribe la descripción del tipo de mantenimiento">Descripción</flux:input>
                </div>

                <flux:button type="submit" size="sm" variant="primary">Guardar</flux:button>
            </form>
        </div>
    
    @elseif ($view === 'edit')
        <div class="card">
            <form wire:submit.prevent="update">
                @csrf
                <div class="mb-4">
                    <flux:input class="hover-input" label="Nombre" wire:model="name" placeholder="Escribe el nombre del tipo de mantenimiento">Nombre</flux:input>
                </div>

                <div class="mb-4">
                    <flux:input class="hover-input" label="Descripción" wire:model="description" placeholder="Escribe la descripción del tipo de mantenimiento">Descripción</flux:input>
                </div>

                <flux:button type="submit" size="sm" variant="primary">Actualizar</flux:button>
            </form>
        </div>
    @endif
</div>
