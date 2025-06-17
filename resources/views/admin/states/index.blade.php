<x-layouts.app :title="'Estados'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs py-1.5">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.states.index')"> Descripción de Estados </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    {{-- Tabla de contenido --}}
    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item"> Nombre </th>
                    <th class="head-table-item"> Descripción </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($states as $state)
                    <tr wire:key="estado-{{ $state->id }}" class="table-content">
                        <td class="column-item">{{ $state->name }}</td>
                        <td class="column-item">{{ $state->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mx-4 mt-4 mb-4">{{ $states->links() }}</div>
    
</x-layouts.app>
