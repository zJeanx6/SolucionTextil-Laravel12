<x-layouts.app :title="'Roles'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs py-1.5">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.roles.index')"> Descripción de Roles </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    {{-- Tabla de contenido --}}
    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item"> Nombre </th>
                    <th class="head-table-item "> Descripción </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr wire:key="rol-{{ $role->id }}" class="table-content">
                        <td class="column-item">{{ $role->name }}</td>
                        <td class="column-item">{{ $role->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.app>
