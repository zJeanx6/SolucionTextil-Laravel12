<div >
    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.sa.company-sa')"> Gestión de Empresas </flux:breadcrumbs.item>
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

        @if ($companies->isEmpty())
            <div class="p-4 text-gray-600">
                No hay empresas registradas.
            </div>
        @else
            {{-- Tabla de contenido para empresas --}}
            <div class="div-table">
                <table class="table">
                    <thead class="head-table">
                        <tr>
                            <th class="head-table-item"> NIT </th>
                            <th class="head-table-item"> Nombre </th>
                            <th class="head-table-item"> Correo </th>
                            <th class="head-table-item"> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                            <tr wire:key="company-{{ $company->nit }}" class="table-content">
                                <td class="column-item">{{ $company->nit }}</td>
                                <td class="column-item">{{ $company->name }}</td>
                                <td class="column-item">{{ $company->email }}</td>
                                <td class="column-item">
                                    <div class="two-actions">
                                        <flux:button.group>
                                            <flux:button icon="pencil-square" size="sm" variant="primary" wire:click="edit('{{ $company->nit }}')" />
                                            <flux:button icon="trash" size="sm" variant="danger" wire:click="delete('{{ $company->nit }}')" />
                                        </flux:button.group>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="mx-4 mt-4 mb-4">{{ $companies->links() }}</div>
        @endif

    {{-- Estado del componente: Vista Crear nueva Empresa --}}
    @elseif ($view === 'create')

        <div class="card">
            <div class="w-full flex flex-col gap-4 mb-4">
                <flux:input type="text" wire:model="nit" label="NIT" name="nit" placeholder="NIT de la empresa..." />
                <flux:input type="text" wire:model="name" label="Nombre" name="name" placeholder="Nombre de la empresa..." />
                <flux:input type="email" wire:model="email" label="Correo electrónico" name="email" placeholder="Correo electrónico de la empresa..." />
            </div>
            <div class="flex justify-end">
                <flux:button size="sm" wire:click="save" variant="primary" type="submit"> Guardar </flux:button>
            </div>
        </div>

    {{-- Estado del componente: Vista editar Empresa --}}
    @elseif ($view === 'edit')

        <div class="card">
            <flux:input type="text" wire:model="nit" class="hover-input mb-4" label="NIT" name="nit" disabled />
            <flux:input type="text" wire:model="name" class="hover-input mb-4" label="Nombre" name="name" placeholder="Nombre de la empresa..." />
            <flux:input type="email" wire:model="email" class="hover-input mb-4" label="Correo electrónico" name="email" placeholder="Correo electrónico de la empresa..." />

            <div class="flex justify-end">
                <flux:button size="sm" variant="primary" wire:click="update">Actualizar</flux:button>
            </div>
        </div>

    @endif
</div>
