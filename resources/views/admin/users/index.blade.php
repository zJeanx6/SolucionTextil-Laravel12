<x-layouts.app :title="'Usuarios'">
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.users.index')">Usuarios</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button size="sm" variant="primary" :href="route('admin.users.create')">Nuevo</flux:button>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="table">
            <thead
                class="head-table">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">CARD</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">NOMBRE</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">APELLIDO</th>
                    <th scope="col" class="px-6 py-3 text-center dark:text-white">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr
                        class="table-content">
                        <th scope="row" class="px-6 py-4 text-center font-medium whitespace-nowrap">
                            {{ $user->card }}</th>
                        <td class="px-6 py-4 text-center uppercase">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-center uppercase">{{ $user->last_name }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center">
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <flux:button.group>
                                        <flux:button size="sm" variant="primary"
                                            :href="route('admin.users.edit', $user)">Ver</flux:button>
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
    <div class="mx-4 mt-4 mb-4">{{ $users->links() }}</div>
</x-layouts.app>
