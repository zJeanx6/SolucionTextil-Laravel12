<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\ProductType;
use App\Models\Size;
use App\Models\Color;
use App\Models\{Product, Supplier, User, Ticket, TicketDetail, ExitDetail, ProductExit};
use Livewire\WithFileUploads;
use Livewire\Attributes\Lazy;

// #[Lazy]
class ProductsMov extends Component
{
    use WithPagination , WithFileUploads;

    // Modales
    public bool $showIngresoModal = false;
    public bool $showSalidaModal  = false;
    public bool $showCreateModal = false;

    // Datos ingreso
    public $ingresoProductCode = '';
    public $ingresoAmount      = '';
    public $ingresoSupplier    = '';

    // Datos salida
    public $salidaProductCode = '';
    public $salidaAmount      = '';
    public $salidaReceiver    = '';

    // Filtros y búsqueda
    public string $search        = '';
    public string $typeFilter    = '';
    public string $sortField     = 'date';
    public string $sortDirection = 'desc';

    // Catálogos auxiliares
    public $products   = [];
    public $suppliers  = [];
    public $receivers  = [];
    public $productTypes = [];
    public $sizes = [];
    public $colors = [];

    //Campos de creacion de productos
    public $product_type_id, $size_id, $color_id, $code, $name, $stock, $photo;

    // Manejo de parámetros en la URL
    protected $queryString = [
        'search'        => ['except' => ''],
        'typeFilter'    => ['except' => ''],
        'sortField'     => ['except' => 'date'],
        'sortDirection' => ['except' => 'desc'],
        'page'          => ['except' => 1],
    ];

    // Se ejecuta al montar el componente
    public function mount()
    {
        $this->products  = Product::orderBy('name')->get();
        $this->suppliers = Supplier::orderBy('name')->get();
        $this->receivers = User::orderBy('name')->get();
        $this->loadData();
    }

    // Placeholder mientras carga
    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    // Renderiza la tabla combinada de ingresos y salidas
    public function render()
    {
        // Entradas (tickets)
        $ingresos = DB::table('ticket_details')
            ->join('tickets', 'ticket_details.ticket_id', '=', 'tickets.id')
            ->join('products', 'ticket_details.product_code', '=', 'products.code')
            ->join('users as u', 'tickets.card_id', '=', 'u.card')
            ->selectRaw("
                ticket_details.id AS movement_id,
                tickets.created_at AS date,
                'Ingreso' AS type,
                products.code AS product_code,
                products.name AS product_name,
                ticket_details.amount AS amount,
                '' AS party,
                CONCAT(u.name, ' ', u.last_name) AS user
            ");

        // Salidas (exits)
        $salidas = DB::table('exit_details')
            ->join('exits', 'exit_details.exit_id', '=', 'exits.id')
            ->join('products', 'exit_details.product_code', '=', 'products.code')
            ->join('users as u', 'exits.card_id', '=', 'u.card')
            ->selectRaw("
                exit_details.id AS movement_id,
                exits.created_at AS date,
                'Salida' AS type,
                products.code AS product_code,
                products.name AS product_name,
                exit_details.amount AS amount,
                '' AS party,
                CONCAT(u.name, ' ', u.last_name) AS user
            ");

        // Unión de movimientos
        $unionQuery = $ingresos->unionAll($salidas);

        // Subconsulta para aplicar paginación y filtros
        $combined = DB::table(DB::raw("({$unionQuery->toSql()}) as movements"))
            ->mergeBindings($unionQuery);

        // Filtro por tipo de movimiento (Ingreso o Salida)
        if ($this->typeFilter) {
            $combined->where('type', $this->typeFilter);
        }

        // Filtro por búsqueda (nombre, código, usuario, etc.)
        if ($this->search) {
            $s = strtolower($this->search);
            $combined->where(function($q) use ($s) {
                $q->whereRaw('LOWER(product_name) LIKE ?', ["%{$s}%"])
                  ->orWhereRaw('LOWER(user) LIKE ?', ["%{$s}%"])
                  ->orWhere('product_code', 'LIKE', "%{$s}%")
                  ->orWhere('movement_id', 'LIKE', "%{$s}%");
            });
        }

        // Validación del campo por el que se ordena
        $allowed = ['date', 'type', 'product_code', 'product_name', 'amount', 'party', 'user'];
        if (!in_array($this->sortField, $allowed)) $this->sortField = 'date';

        // Aplicar ordenamiento
        $combined->orderBy($this->sortField, $this->sortDirection);

        // Paginación
        $movements = $combined->paginate(12);

        return view('livewire.products-mov', [
            'movements' => $movements,
        ]);
    }

    // Reinicia paginación al cambiar búsqueda o filtro
    public function updatingSearch()    { $this->resetPage(); }
    public function updatingTypeFilter(){ $this->resetPage(); }

    // Alterna orden asc/desc o cambia el campo de orden
    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = ($this->sortDirection === 'asc') ? 'desc' : 'asc';
        } else {
            $this->sortField     = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    // Abre el modal de ingreso
    public function openIngresoModal()
    {
        $this->reset(['ingresoProductCode', 'ingresoAmount', 'ingresoSupplier']);
        $this->showIngresoModal = true;
    }
    public function closeIngresoModal() { $this->showIngresoModal = false; }

    // Abre el modal de salida
    public function openSalidaModal()
    {
        $this->reset(['salidaProductCode', 'salidaAmount', 'salidaReceiver']);
        $this->showSalidaModal = true;
    }
    public function closeSalidaModal() { $this->showSalidaModal = false; }

    // Guarda movimiento de ingreso
    public function saveIngreso()
    {
        $this->validate([
            'ingresoProductCode' => ['required', Rule::exists('products','code')],
            'ingresoAmount'      => ['required','integer','min:1'],
        ], [], [
            'ingresoProductCode' => 'producto',
            'ingresoAmount'      => 'cantidad',
        ]);

        DB::transaction(function () {
            // Crear ticket
            $ticket = Ticket::create([
                'card_id' => Auth::user()->card,
            ]);

            // Crear detalle del ingreso
            TicketDetail::create([
                'ticket_id'    => $ticket->id,
                'product_code' => $this->ingresoProductCode,
                'amount'       => $this->ingresoAmount,
            ]);

            // Actualizar stock del producto
            $product = Product::lockForUpdate()->findOrFail($this->ingresoProductCode);
            $product->increment('stock', $this->ingresoAmount);
        });

        $this->dispatch('event-notify', 'Ingreso registrado con éxito.');
        $this->closeIngresoModal();
    }

    // Guarda movimiento de salida
    public function saveSalida()
    {
        $this->validate([
            'salidaProductCode' => ['required', Rule::exists('products','code')],
            'salidaAmount'      => ['required','integer','min:1'],
        ], [], [
            'salidaProductCode' => 'producto',
            'salidaAmount'      => 'cantidad',
        ]);

        DB::transaction(function () {
            // Crear salida
            $exit = ProductExit::create([
                'card_id' => Auth::user()->card,
            ]);

            // Crear detalle de salida
            ExitDetail::create([
                'exit_id'     => $exit->id,
                'product_code'=> $this->salidaProductCode,
                'amount'      => $this->salidaAmount,
            ]);

            // Verificar stock disponible
            $product = Product::lockForUpdate()->findOrFail($this->salidaProductCode);
            if ($product->stock < $this->salidaAmount) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'salidaAmount' => "Stock insuficiente (actual: {$product->stock})",
                ]);
            }

            // Descontar stock
            $product->decrement('stock', $this->salidaAmount);
        });

        $this->dispatch('event-notify', 'Salida registrada con éxito.');
        $this->closeSalidaModal();
    }

    // Carga catálogos auxiliares
    public function loadData()
    {
        $this->productTypes = ProductType::orderBy('name')->get();
        $this->sizes = Size::orderBy('name')->get();
        $this->colors = Color::orderBy('name')->get();
    }

    // Maneja opción para crear nuevo tipo desde select
    public function updatedProductTypeId($value)
    {
        if ($value === 'new_type') {
            $this->dispatch('open-new-type-modal');
            $this->product_type_id = '';
        }
    }

    // Maneja opción para crear nueva talla desde select
    public function updatedSizeId($value)
    {
        if ($value === 'new_size') {
            $this->dispatch('open-new-size-modal');
            $this->size_id = '';
        }
    }

    // Maneja opción para crear nuevo color desde select
    public function updatedColorId($value)
    {
        if ($value === 'new_color') {
            $this->dispatch('open-new-color-modal');
            $this->color_id = '';
        }
    }

    // Guarda nuevo producto desde el modal de creación rápida
    public function save()
    {
        $this->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'size_id' => 'required|exists:sizes,id',
            'color_id' => 'required|exists:colors,id',
            'code' => 'required|numeric|unique:products,code',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'photo' => 'nullable|image|max:2048'
        ]);

        $photoPath = $this->photo ? $this->photo->store('products', 'public') : null;

        Product::create([
            'product_type_id' => $this->product_type_id,
            'size_id' => $this->size_id,
            'color_id' => $this->color_id,
            'code' => $this->code,
            'name' => $this->name,
            'stock' => $this->stock,
            'photo_path' => $photoPath,
        ]);

        // Resetear campos y cerrar modal
        $this->reset(['product_type_id', 'size_id', 'color_id', 'code', 'name', 'stock', 'photo', 'showCreateModal']);

        $this->dispatch('event-notify', 'Producto creado correctamente.');
        $this->dispatch('productCreated');
    }

    // Detecta si se eligió "nuevo producto" para abrir el modal de creación
    public function updatedIngresoProductCode($value)
    {
        if ($value === 'new_product') {
            $this->ingresoProductCode = '';
            $this->showCreateModal = true;
        }
    }
}
