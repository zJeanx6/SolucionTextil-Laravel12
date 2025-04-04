<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.brands.index')">Marcas</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button  size="sm" variant="primary" :href="route('admin.brands.create')">Nuevo</flux:button>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead
                class="text border-b dark:border-zinc-700 border-gray-200 text-gray-700 uppercase bg-gray-50 dark:bg-zinc-900 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-white">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-white">
                        NOMBRE
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-white">
                        ACCIONES
                    </th>
                </tr>   
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                    <tr
                        class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-zinc-800">
                        <th scope="row"
                            class="px-6 py-4 text-center font-medium whitespace-nowrap">
                            {{ $brand->id }} 
                        </th>
                        <td class="px-6 py-4 text-center">
                            {{ $brand->name }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center">
                                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button.group>
                                        <flux:button size="sm" variant="primary" :href="route('admin.brands.edit', $brand)">Editar</flux:button>
                                        <flux:button size="sm" variant="danger" type="submit">Eliminar</flux:button>
                                    </flux:button.group>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mx-4 mt-4 mb-4 ">{{ $brands->links() }}</div>


</x-layouts.app>
