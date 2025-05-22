<x-layouts.app :title="'Colores'">
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.colors.index')">Colores</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button size="sm" variant="primary" :href="route('admin.colors.create')">Nuevo</flux:button>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="table">
            <thead
                class="head-table">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">CODIGO</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">NOMBRE</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colors as $color)
                    <tr
                        class="table-content">
                        <td class="px-6 py-4 text-center uppercase">#{{ $color->code }}</td>
                        <td class="px-6 py-4 text-center uppercase">{{ $color->name }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center">
                                <form action="{{ route('admin.colors.destroy', $color) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <flux:button.group>
                                        <flux:button size="sm" variant="primary"
                                            :href="route('admin.colors.edit', $color)">Editar</flux:button>
                                        <flux:button size="sm" variant="danger" onclick="confirmDelete(this)">
                                            Eliminar</flux:button>
                                    </flux:button.group>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mx-4 mt-4 mb-4">{{ $colors->links() }}</div>
</x-layouts.app>
