<div>
    {{-- Migaja de pan --}}
        <div class="breadcrumbs">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
                <flux:breadcrumbs.item :href="route('admin.maintenance.index')"> Tipos de mantenimiento </flux:breadcrumbs.item>
            </flux:breadcrumbs>

            @if ($view === 'index')
                <flux:button size="sm" variant="primary" wire:click="create"> Nuevo </flux:button>
            @else
                <flux:button size="sm" variant="primary" wire:click="index"> Volver </flux:button>
            @endif
        </div>

    {{-- Estado del componente: Vista Principal. --}}
        @if ($view === 'index')
            <div class="card mb-4">
                <div class="flex gap-4">
                    <div class="w-full">
                        <flux:input type="text" wire:model.live="search" class="hover-input w-2/3 mx-auto px-4 py-2 "
                            placeholder="Buscar tipo de mantenimiento..." />
                    </div>
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="head-table">
                        <tr>
                            <th scope="col" class="px-6 py-2 text-center dark:text-white">NOMBRE</th>
                            <th scope="col" class="px-6 py-2 text-center dark:text-white">TIPO DE MANTENIMIENTO</th>
                            <th scope="col" class="px-6 py-2 text-center dark:text-white">DESCRIPCIÓN</th>
                            <th scope="col" class="px-6 py-2 text-center dark:text-white">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($maintenanceTypes as $type)
                            <tr wire:key="typeMaintenance-{{ $type->id }}" class="table-content">
                                <th scope="row" class="px-6 py-4 text-center font-medium whitespace-nowrap">
                                    {{ $type->name }}</th>
                                <td class="px-6 py-4 text-center">{{ $type->type }}</td> 
                                <td class="px-6 py-4 text-center uppercase">{{ $type->description }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="two-actions">
                                        <flux:button.group>
                                            <flux:button size="sm" icon="pencil-square" variant="primary" wire:click="edit({{ $type->id }})"/>
                                            <flux:button size="sm" icon="trash" variant="danger" wire:click="delete({{ $type->id }})"/>
                                        </flux:button.group>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-4 text-center text-gray-500 italic"> No se encontraron tipos de mantenimiento. </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mx-4 mt-4 mb-4">{{ $maintenanceTypes->links() }}</div>

    {{-- Estado del componente: Vista Formulario para crear Tipo de mantenimiento. --}}
            @elseif ($view === 'create')

            <div class="card">
                <form wire:submit.prevent="save">
                    @csrf
                    <div class="mb-4">
                        <flux:input class="hover-input" label="Nombre" wire:model="name"
                            placeholder="Escribe el nombre del tipo de mantenimiento">Nombre</flux:input>
                    </div>

                    <div class="mb-4">
                        <flux:input class="hover-input" label="Descripción" wire:model="description"
                            placeholder="Escribe la descripción del tipo de mantenimiento">Descripción</flux:input>
                    </div>

                    <div class="mb-4">
                        <flux:radio.group wire:model="maintenance_type" label="Tipo de mantenimiento">
                            <flux:radio value="Preventivo" label="Preventivo" checked />
                            <flux:radio value="Correctivo" label="Correctivo" />
                        </flux:radio.group>
                    </div>

                    <flux:button size="sm" type="submit" variant="primary"> Guardar </flux:button>
                </form>
            </div>

    {{-- Estado del componente: Vista Formulario de editar Tipo de mantenimiento. --}}
        @elseif ($view === 'edit')

        <div class="card">
            <form wire:submit.prevent="update">
                @csrf

                <div class="mb-4">
                    <flux:input class="hover-input" label="Nombre" wire:model="name"
                                placeholder="Escribe el nombre del tipo de mantenimiento">Nombre</flux:input>
                </div>

                <div class="mb-4">
                    <flux:input class="hover-input" label="Descripción" wire:model="description"
                                placeholder="Escribe la descripción del tipo de mantenimiento">Descripción</flux:input>
                </div>

                <div class="mb-4">
                    <flux:radio.group wire:model="maintenance_type" label="Tipo de mantenimiento">
                        <flux:radio value="Preventivo" label="Preventivo" :checked="$maintenance_type === 'Preventivo'" />
                        <flux:radio value="Correctivo" label="Correctivo" :checked="$maintenance_type === 'Correctivo'" />
                    </flux:radio.group>
                </div>

                <flux:button size="sm" variant="primary" wire:click="update">Actualizar</flux:button>

            </form>
        </div>

        @endif
</div>
