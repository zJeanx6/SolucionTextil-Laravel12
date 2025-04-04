<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.roles.index')">Roles</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button size="sm" variant="primary" :href="route('admin.roles.create')">Nuevo</flux:button>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead
                class="text border-b dark:border-gray-800 border-gray-200 text-gray-700 uppercase bg-gray-50 dark:bg-black dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-center w-1/6">
                        NOMBRE
                    </th>
                    <th scope="col" class="px-6 py-3 text-center w-4/6">
                        DESCRIPCION
                    </th>
                    <th scope="col" class="px-6 py-3 text-center w-1/6">
                        ACCIONES
                    </th>
                </tr>   
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr
                        class="bg-white border-b dark:bg-black dark:border-gray-800 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <th scope="row"
                            class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $role->id }} 
                        </th>
                        <td class="px-6 py-4 text-center">
                            {{ $role->name }}
                        </td>
                        <td class="px-10 py-4 break-words max-w-[300px]">
                            {{ $role->description }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center">
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button.group>
                                        <flux:button size="sm" variant="primary" :href="route('admin.roles.edit', $role)">Editar</flux:button>
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
    <div class="mx-4 mt-4 mb-4">{{ $roles->links() }}</div>
</x-layouts.app>
