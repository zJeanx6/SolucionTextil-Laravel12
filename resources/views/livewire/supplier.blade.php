<div>
    <div class="breadcrumbs-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.suppliers.index')">Proveedores</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        @if ($view === 'index')
            <flux:button size="sm" variant="primary" wire:click="create">Nuevo</flux:button>
        @else
            <flux:button size="sm" variant="primary" wire:click="index">Volver</flux:button>
        @endif        
    </div>
    @if ($view === 'index')
    
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="table">
            <thead
                class="head-table">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">NIT</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">NOMBRE</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">REPRESENTANTE</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                <tr
                    class="table-content">
                    <th scope="row" class="px-6 py-4 text-center font-medium whitespace-nowrap">
                        {{ $supplier->nit }}</th>
                    <td class="px-6 py-4 text-center uppercase">{{ $supplier->name }}</td>
                    <td class="px-6 py-4 text-center uppercase">{{ $supplier->representative_name }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center">
                        <flux:button size="sm" variant="primary"
                            wire:click="edit({{ $supplier->nit }})">Editar</flux:button>
                        <flux:button size="sm" variant="danger"
                            wire:click="delete({{ $supplier->nit }})">Eliminar</flux:button>
                        </div>
                    </td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mx-4 mt-4 mb-4">{{ $suppliers->links() }}</div>


    @elseif ($view === 'create')
        <div class="card">
            <form wire:submit.prevent="save">
                @csrf
                <div class="mb-4">
                    <flux:input class="hover-input" label="Nit" wire:model="nit" placeholder="Escribe el nit del proveedor">Nit</flux:input>
                </div>
        
                <div class="mb-4">
                    <label>Tipo de persona</label>
                        <select class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md" wire:model="person_type">
                            <option value="">Seleccione</option>
                            <option value="Natural">Natural</option>
                            <option value="Juridica">Jurídica</option>
                        </select>
                </div>
        
                <div class="mb-4">
                    <flux:input class="hover-input" label="Nombre"  wire:model="name" placeholder="Escribe el nombre de este proveedor"></flux:input>
                </div>
        
                <div class="mb-4">
                    <flux:input class="hover-input" label="Email"  wire:model="email" placeholder="Escribe el email del nuevo proveedor"></flux:input>
                </div>
        
                <div class="mb-4">
                    <flux:input class="hover-input" label="Teléfono" wire:model="phone" placeholder="Escribe el teléfono del nuevo proveedor"></flux:input>
                </div>

                <div class="mb-4">
                    <flux:input class="hover-input" label="Nombre del representante" wire:model="representative_name"  placeholder="Escribe el nombre del representante"></flux:input>
                </div>

                <div class="mb-4">
                    <flux:input class="hover-input" label="Correo del representante" wire:model="representative_email" placeholder="Escribe el correo del representante"></flux:input>
                </div>

                <div class="mb-4">
                    <flux:input class="hover-input" label="Telefono del representante" wire:model="representative_phone"  placeholder="Escribe el telefono del representante"></flux:input>
                </div>

                <div class="flex justify-end">
                    <flux:button wire:click="save" variant="primary" type="submit">
                        Crear
                    </flux:button>
                </div>
        </div>


    @elseif ($view === 'edit')
        <div class="card">
            <div class="mb-4">
                <flux:input class="hover-input" label="Nit" wire:model="nit" placeholder="Escribe el nit del proveedor">Nit</flux:input>
            </div>
    
            <div class="mb-4">
                <label>Tipo de persona</label>
                    <select class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md" wire:model="person_type">
                        <option value="">Seleccione</option>
                        <option value="Natural">Natural</option>
                        <option value="Juridica">Jurídica</option>
                    </select>
            </div>
    
            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre"  wire:model="name" placeholder="Escribe el nombre de este proveedor"></flux:input>
            </div>
    
            <div class="mb-4">
                <flux:input class="hover-input" label="Email"  wire:model="email" placeholder="Escribe el email del nuevo proveedor"></flux:input>
            </div>
    
            <div class="mb-4">
                <flux:input class="hover-input" label="Teléfono" wire:model="phone" placeholder="Escribe el teléfono del nuevo proveedor"></flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre del representante" wire:model="representative_name"  placeholder="Escribe el nombre del representante"></flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Correo del representante" wire:model="representative_email" placeholder="Escribe el correo del representante"></flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Telefono del representante" wire:model="representative_phone"  placeholder="Escribe el telefono del representante"></flux:input>
            </div>
            <div class="flex justify-end">
                <flux:button wire:click="update" variant="primary" type="submit">
                    Actualizar
                </flux:button>
        </div>
    @endif
    
</div>
