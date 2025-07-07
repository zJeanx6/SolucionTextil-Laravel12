<div>
    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.sa.type-sa')"> Gestión de Tipos de Licencia </flux:breadcrumbs.item>
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
            <div class="w-full flex gap-4">
                <flux:input type="text" wire:model.live.debounce.500ms="search" class="hover-input" name="search" placeholder="Buscar por nombre..." />
            </div>
        </div>

        @if ($licenseTypes->isEmpty())
            <div class="p-4 text-gray-600">
                No hay tipos de licencia registrados.
            </div>
        @else
            {{-- Tabla de contenido para tipos de licencia --}}
            <div class="div-table">
                <table class="table">
                    <thead class="head-table">
                        <tr>
                            <th class="head-table-item"> Nombre </th>
                            <th class="head-table-item"> Duración </th>
                            <th class="head-table-item"> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($licenseTypes as $licenseType)
                            <tr wire:key="license-type-{{ $licenseType->id }}" class="table-content">
                                <td class="column-item">{{ $licenseType->name }}</td>
                                <td class="column-item">{{ $licenseType->duration }} días</td>
                                <td class="column-item">
                                    <div class="two-actions">
                                        <flux:button.group>
                                            <flux:button icon="pencil-square" size="sm" variant="primary" wire:click="edit('{{ $licenseType->id }}')" />
                                            <flux:button icon="trash" size="sm" variant="danger" wire:click="delete('{{ $licenseType->id }}')" />
                                        </flux:button.group>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="mx-4 mt-4 mb-4">{{ $licenseTypes->links() }}</div>
        @endif

    {{-- Estado del componente: Vista Crear nuevo Tipo de Licencia --}}
    @elseif ($view === 'create')

        <div class="card">
            <div class="w-full flex flex-col gap-4 mb-4">
                <flux:input type="text" wire:model="name" label="Nombre" name="name" placeholder="Nombre del tipo de licencia..." />
                <flux:input type="number" wire:model="duration" label="Duración (en días)" name="duration" placeholder="Duración de la licencia..." />
            </div>
            <div class="flex justify-end">
                <flux:button size="sm" wire:click="save" variant="primary" type="submit"> Guardar </flux:button>
            </div>
        </div>

    {{-- Estado del componente: Vista editar Tipo de Licencia --}}
    @elseif ($view === 'edit')

        <div class="card">
                <flux:input class="mb-4" type="text" wire:model="name" label="Nombre" name="name" placeholder="Nombre del tipo de licencia..." />
                <flux:input class="mb-4" type="number" wire:model="duration" label="Duración (en días)" name="duration" placeholder="Duración de la licencia..." />

            <div class="flex justify-end">
                <flux:button size="sm" variant="primary" wire:click="update">Actualizar</flux:button>
            </div>
        </div>

    @endif
</div>
