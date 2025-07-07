<div>
    {{-- migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.suppliers.index')">Proveedores</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        @if ($view === 'index')
            <flux:button size="sm" variant="primary" wire:click="create">Nuevo</flux:button>
        @else
            <flux:button size="sm" variant="primary" wire:click="index">Volver</flux:button>
        @endif        
    </div>
    {{-- vista del listado de los proveedores --}}
    @if ($view === 'index')
        <div class="card mb-6">
            {{-- Barra de busqueda --}}
            <div class="w-full">
                <flux:input label="Barra de Busqueda" type="text" wire:model.live="search" class="hover-input" name="searchByNit" placeholder="Busca algo..." />
            </div>
        </div>
        
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="table">
                <thead
                    class="head-table">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center dark:text-white">TIPO DE PERSONA</th>
                        <th scope="col" class="px-6 py-3 text-center dark:text-white">NIT</th>
                        <th scope="col" class="px-6 py-3 text-center dark:text-white">NOMBRE</th>
                        <th scope="col" class="px-6 py-3 text-center dark:text-white">REPRESENTANTE</th>
                        <th scope="col" class="px-6 py-3 text-center dark:text-white">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                    <tr
                        class="table-content">
                        <td class="px-6 py-4 text-center uppercase">{{ $supplier->person_type }}</td>
                        <th class="px-6 py-4 text-center font-medium whitespace-nowrap">{{ $supplier->nit }}</th>
                        <td class="px-6 py-4 text-center uppercase">{{ $supplier->name }}</td>
                        <td class="px-6 py-4 text-center uppercase">{{ $supplier->representative_name  ?? 'N/A'}}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center">
                                <flux:button.group>
                                    <flux:button icon="document-magnifying-glass" size="sm" variant="primary"
                                        wire:click="show({{ json_encode($supplier->nit) }})"></flux:button>
                                    <flux:button icon="pencil-square" size="sm" variant="primary"
                                        wire:click="edit({{ json_encode($supplier->nit) }})"></flux:button>
                                    <flux:button icon="trash" size="sm" variant="danger"
                                        wire:click="delete({{ $supplier->nit }})"></flux:button>
                                </flux:button.group>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-4 text-center text-gray-500 italic"> No se encontraron proveedores. </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mx-4 mt-4 mb-4">{{ $suppliers->links() }}</div>

    {{-- Vista para crear proveedor --}}
    @elseif ($view === 'create')
    <div class="card p-6">
        <form wire:submit.prevent="save">
            @csrf
            <div class="flex flex-col gap-6">
                <div class="w-full flex flex-col gap-4">
                    <flux:input class="hover-input" label="Nit" wire:model="nit" placeholder="Escribe el nit del proveedor"></flux:input>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de persona</label>
                        <flux:select wire:model.live="person_type">
                        <flux:select.option value="">Seleccione</flux:select.option>
                        <flux:select.option value="Natural">Natural</flux:select.option>
                        <flux:select.option value="Juridica">Jurídica</flux:select.option>
                    </flux:select>
                    </div>

                    <flux:input class="hover-input" label="Nombre" wire:model="name" placeholder="Escribe el nombre del proveedor"></flux:input>
                    <flux:input class="hover-input" label="Email" wire:model="email" placeholder="Escribe el email del proveedor"></flux:input>
                    <flux:input class="hover-input" label="Teléfono" wire:model="phone" placeholder="Escribe el teléfono del proveedor"></flux:input>

                    @if($showJuridica)
                        <flux:input class="hover-input" label="Nombre del representante" wire:model="representative_name" placeholder="Escribe el nombre del representante"></flux:input>
                        <flux:input class="hover-input" label="Correo del representante" wire:model="representative_email" placeholder="Escribe el correo del representante"></flux:input>
                        <flux:input class="hover-input" label="Teléfono del representante" wire:model="representative_phone" placeholder="Escribe el teléfono del representante"></flux:input>
                    @endif

                    <div class="flex justify-end gap-2 mt-2">
                        <flux:button wire:click="save" variant="primary" type="submit">
                            Crear
                        </flux:button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    {{-- Vista para editar el proveedor --}}
    @elseif ($view === 'edit')
    <div class="card p-6">
        <div class="flex flex-col gap-6">
            <div class="w-full flex flex-col gap-4">
                <flux:input class="hover-input" label="Nit" wire:model="nit" readonly></flux:input>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de persona</label>
                    <flux:select wire:model.live="person_type">
                        <flux:select.option value="">Seleccione</flux:select.option>
                        <flux:select.option value="Natural">Natural</flux:select.option>
                        <flux:select.option value="Juridica">Jurídica</flux:select.option>
                    </flux:select>
                </div>

                <flux:input class="hover-input" label="Nombre" wire:model="name" placeholder="Escribe el nombre de la persona"></flux:input>
                <flux:input class="hover-input" label="Email" wire:model="email" placeholder="Escribe el email de la persona"></flux:input>
                <flux:input class="hover-input" label="Teléfono" wire:model="phone" placeholder="Escribe el teléfono de la persona"></flux:input>

                @if($showJuridica)
                    <flux:input class="hover-input" label="Nombre de la empresa" wire:model="representative_name" placeholder="Escribe el nombre de la empresa"></flux:input>
                    <flux:input class="hover-input" label="Correo de la empresa" wire:model="representative_email" placeholder="Escribe el correo de la empresa"></flux:input>
                    <flux:input class="hover-input" label="Teléfono de la empresa" wire:model="representative_phone" placeholder="Escribe el teléfono de la empresa"></flux:input>
                @endif

                <div class="flex justify-end gap-2 mt-2">
                    <flux:button wire:click="update" variant="primary" type="button">
                        Actualizar
                    </flux:button>
                </div>
            </div>
        </div>
    </div>

    {{-- Vista para ver el proveedor --}}
    @elseif ($view === 'show')
    <div class="card p-6">
        <div class="flex flex-col gap-6">
            <div class="w-full flex flex-col gap-4">
                <flux:input class="hover-input" label="Nit" wire:model="nit" placeholder="Escribe el nit del proveedor" readonly></flux:input>

                <flux:input label="Tipo de persona" value="{{ $person_type ?: 'No especificado' }}" readonly class="hover-input"></flux:input>

                <flux:input class="hover-input" label="Nombre" wire:model="name"  readonly></flux:input>
                <flux:input class="hover-input" label="Email" wire:model="email"  readonly></flux:input>
                <flux:input class="hover-input" label="Teléfono" wire:model="phone" readonly></flux:input>

                @if($person_type === 'Juridica')
                    <flux:input class="hover-input" label="Nombre del representante" wire:model="representative_name" placeholder="Escribe el nombre del representante" readonly></flux:input>
                    <flux:input class="hover-input" label="Correo del representante" wire:model="representative_email" placeholder="Escribe el correo del representante" readonly></flux:input>
                    <flux:input class="hover-input" label="Teléfono del representante" wire:model="representative_phone" placeholder="Escribe el teléfono del representante" readonly></flux:input>
                @endif
            </div>
        </div>
    </div>

@endif
    
</div>
