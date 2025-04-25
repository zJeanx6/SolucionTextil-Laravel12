<x-layouts.app>
    <div class="h-4 flex justify-between items-center top-8 z-10 px-4 mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.colors.index')">Colores</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button size="sm" variant="primary" :href="route('admin.colors.create')">Nuevo</flux:button>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead
                class="text border-b dark:border-zinc-700 border-gray-200 text-gray-700 uppercase bg-gray-50 dark:bg-zinc-900 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">ID</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">CODIGO</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">NOMBRE</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colors as $color)
                    <tr
                        class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-zinc-800">
                        <th scope="row" class="px-6 py-4 text-center font-medium whitespace-nowrap">
                            {{ $color->id }}</th>
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
