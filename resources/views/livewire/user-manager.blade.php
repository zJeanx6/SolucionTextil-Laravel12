<div>
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.users.index')"> Gestión de Usuarios </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        @if ($view === 'index')
            <flux:button size="sm" variant="primary" wire:click="create"> Crear nuevo usuario </flux:button>
        @else
            <flux:button size="sm" variant="primary" wire:click="index"> Volver </flux:button>
        @endif
    </div>

    @if ($view === 'index')
        <div class="card mb-4">
            <div class="w-full flex gap-4">
                <flux:input type="text" wire:model.live.debounce.500ms="search" class="hover-input" name="search" placeholder="Buscar por nombre..." />
            </div>
        </div>

        @if ($users->isEmpty())
            <div class="p-4 text-gray-600">
                No hay usuarios registrados.
            </div>
        @else
            <div class="div-table">
                <table class="table">
                    <thead class="head-table">
                        <tr>
                            <th class="head-table-item"> Card </th>
                            <th class="head-table-item"> Nombre </th>
                            <th class="head-table-item"> Correo </th>
                            <th class="head-table-item"> Teléfono </th>
                            <th class="head-table-item"> Empresa </th>
                            <th class="head-table-item"> Estado </th>
                            <th class="head-table-item"> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr wire:key="user-{{ $user->card }}" class="table-content">
                                <td class="column-item">{{ $user->card }}</td>
                                <td class="column-item">{{ $user->name }} {{ $user->last_name }}</td>
                                <td class="column-item">{{ $user->email }}</td>
                                <td class="column-item">{{ $user->phone }}</td>
                                <td class="column-item">{{ $user->company->name }}</td>
                                <td class="column-item">{{ $user->state->name }}</td>
                                <td class="column-item">
                                    <div class="two-actions">
                                        <flux:button.group>
                                            <flux:button icon="pencil-square" size="sm" variant="primary" wire:click="edit('{{ $user->card }}')" />
                                            <flux:button icon="trash" size="sm" variant="danger" wire:click="delete('{{ $user->card }}')" />
                                        </flux:button.group>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mx-4 mt-4 mb-4">{{ $users->links() }}</div>
        @endif

    @elseif ($view === 'create')
        <div class="card">
            <div class="w-full grid grid-cols-2 gap-4 mb-4">
                <div class="flex flex-col">
                    <flux:input type="text" wire:model="card" label="Card (Documento de Identidad)" name="card" placeholder="Número de documento..." class="mb-4" />
                    <flux:input type="text" wire:model="name" label="Nombre" name="name" placeholder="Nombre del usuario..." class="mb-4" />
                    <flux:input type="text" wire:model="last_name" label="Apellido" name="last_name" placeholder="Apellido del usuario..." class="mb-4" />
                    <flux:input type="email" wire:model="email" label="Correo electrónico" name="email" placeholder="Correo del usuario..." class="mb-4" />
                    <flux:input type="text" wire:model="phone" label="Teléfono" name="phone" placeholder="Teléfono del usuario..." class="mb-4" />
                    <flux:input type="password" wire:model="password" label="Contraseña" name="password" placeholder="Contraseña..." class="mb-4" />
                </div>
                <div class="flex flex-col">
                    <flux:select wire:model="company_nit" label="Empresa" name="company_nit" class="mb-4">
                        <flux:select.option value="">Seleccione una empresa</flux:select.option>
                        @foreach(App\Models\Company::all() as $company)
                            <flux:select.option value="{{ $company->nit }}">{{ $company->name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select wire:model="state_id" label="Estado" name="state_id" class="mb-4">
                        <flux:select.option value="">Seleccione un estado</flux:select.option>
                        @foreach(App\Models\State::all() as $state)
                            <flux:select.option value="{{ $state->id }}">{{ $state->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <div class="flex justify-end">
                <flux:button size="sm" wire:click="save" variant="primary" type="submit"> Guardar Usuario </flux:button>
            </div>
        </div>

    @elseif ($view === 'edit')
        <div class="card">
            <div class="w-full grid grid-cols-2 gap-4 mb-4">
                <div class="flex flex-col">
                    <flux:input type="text" wire:model="card" label="Card (Documento de Identidad)" name="card" disabled class="mb-4" />
                    <flux:input type="text" wire:model="name" label="Nombre" name="name" placeholder="Nombre del usuario..." class="mb-4" />
                    <flux:input type="text" wire:model="last_name" label="Apellido" name="last_name" placeholder="Apellido del usuario..." class="mb-4" />
                    <flux:input type="email" wire:model="email" label="Correo electrónico" name="email" placeholder="Correo del usuario..." class="mb-4" />
                    <flux:input type="text" wire:model="phone" label="Teléfono" name="phone" placeholder="Teléfono del usuario..." class="mb-4" />
                </div>
                <div class="flex flex-col">
                    <flux:select wire:model="company_nit" label="Empresa" name="company_nit" class="mb-4">
                        @foreach(App\Models\Company::all() as $company)
                            <flux:select.option value="{{ $company->nit }}">{{ $company->name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select wire:model="state_id" label="Estado" name="state_id" class="mb-4">
                        @foreach(App\Models\State::all() as $state)
                            <flux:select.option value="{{ $state->id }}">{{ $state->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <div class="flex justify-end">
                <flux:button size="sm" wire:click="update" variant="primary">Actualizar Usuario</flux:button>
            </div>
        </div>
    @endif
</div>