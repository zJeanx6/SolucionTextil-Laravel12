<div>
    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.sa.license-sa')"> Gestión de Licencias </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        @if ($view === 'index')
            <flux:button size="sm" variant="primary" wire:click="create"> Crear nueva licencia </flux:button>
        @else
            <flux:button size="sm" variant="primary" wire:click="index"> Volver </flux:button>
        @endif
    </div>

    {{-- Estado del componente: Vista principal. --}}
    @if ($view === 'index')
        <div class="card mb-4">
            <div class="w-full flex gap-4">
                <flux:input type="text" wire:model.live.debounce.500ms="search" class="hover-input" name="search" placeholder="Buscar por licencia..." />
            </div>
        </div>

        @if ($licenses->isEmpty())
            <div class="p-4 text-gray-600">
                No hay licencias registradas.
            </div>
        @else
            <div class="div-table">
                <table class="table">
                    <thead class="head-table">
                        <tr>
                            <th class="head-table-item"> Licencia </th>
                            <th class="head-table-item"> Empresa </th>
                            <th class="head-table-item"> Fecha Compra </th>
                            <th class="head-table-item"> Fecha Fin </th>
                            <th class="head-table-item"> Tipo </th>
                            <th class="head-table-item"> Estado </th>
                            <th class="head-table-item"> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($licenses as $license)
                            <tr wire:key="license-{{ $license->license }}" class="table-content">
                                <td class="column-item">{{ $license->license }}</td>
                                <td class="column-item">{{ $license->company->name }}</td>
                                <td class="column-item">{{ $license->purchase_date }}</td>
                                <td class="column-item">{{ $license->end_date }}</td>
                                <td class="column-item">{{ $license->licenseType->name }}</td>
                                <td class="column-item">{{ $license->state->name ?? 'Desconocido' }}</td>
                                <td class="column-item">
                                    <div class="two-actions">
                                        <flux:button.group>
                                            <flux:button icon="pencil-square" size="sm" variant="primary" wire:click="edit('{{ $license->license }}')" />
                                            <flux:button icon="trash" size="sm" variant="danger" wire:click="delete('{{ $license->license }}')" />
                                        </flux:button.group>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mx-4 mt-4 mb-4">{{ $licenses->links() }}</div>
        @endif
    @elseif ($view === 'create')
        <div class="card">
            <div class="w-full grid grid-cols-2 gap-4 mb-4">
                <div class="flex flex-col">
                    <flux:input type="text" wire:model="license" label="Licencia" name="license" placeholder="Generar o escribir licencia..." class="mb-4" />
                    <flux:button size="sm" wire:click="generateLicense" variant="primary" class="mb-4">Generar</flux:button>

                    <flux:select wire:model="company_nit" label="Empresa" name="company_nit" class="mb-4">
                        <flux:select.option value="">Seleccione una empresa</flux:select.option>
                        @foreach(App\Models\Company::all() as $company)
                            <flux:select.option value="{{ $company->nit }}">{{ $company->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="flex flex-col">
                    <flux:select wire:model.live="license_type_id" label="Tipo de Licencia" name="license_type_id" class="mb-4">
                        <flux:select.option value="">Seleccione un tipo de licencia</flux:select.option>
                        @foreach(App\Models\LicenseType::all() as $type)
                            <flux:select.option value="{{ $type->id }}">{{ $type->name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <!-- Fecha de compra (solo visible, no editable) -->
                    <flux:input type="date" wire:model="purchase_date" label="Fecha de Compra" name="purchase_date" class="mb-4" disabled />

                    <!-- Fecha de fin calculada automáticamente -->
                    <flux:input type="date" wire:model="end_date" label="Fecha de Fin" name="end_date" class="mb-4" disabled />
                </div>
            </div>
            <div class="flex justify-end">
                <flux:button size="sm" wire:click="save" variant="primary" type="submit">Guardar Licencia</flux:button>
            </div>
        </div>
    @elseif ($view === 'edit')
        <div class="card">
            <div class="w-full grid grid-cols-2 gap-4 mb-4">
                <div class="flex flex-col">
                    <flux:input type="text" wire:model="license" label="Licencia" name="license" disabled class="mb-4" />

                    <flux:select wire:model="company_nit" label="Empresa" name="company_nit" class="mb-4">
                        @foreach(App\Models\Company::all() as $company)
                            <flux:select.option value="{{ $company->nit }}">{{ $company->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="flex flex-col">
                    <flux:select wire:model="license_type_id" label="Tipo de Licencia" name="license_type_id" class="mb-4">
                        @foreach(App\Models\LicenseType::all() as $type)
                            <flux:select.option value="{{ $type->id }}">{{ $type->name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input type="date" wire:model="purchase_date" label="Fecha de Compra" name="purchase_date" class="mb-4" />
                    <flux:input type="date" wire:model="end_date" label="Fecha de Fin" name="end_date" class="mb-4" />
                </div>
            </div>
            <div class="flex justify-end">
                <flux:button size="sm" wire:click="update" variant="primary">Guardar Cambios</flux:button>
            </div>
        </div>
    @endif
</div>
