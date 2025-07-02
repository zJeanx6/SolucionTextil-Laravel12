<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\{Product, Supplier, User, Ticket, TicketDetail, ExitDetail, ProductExit};
use Livewire\Attributes\Lazy;

// #[Lazy]
class ProductsMov extends Component
{
    use WithPagination;

    // Modales
    public bool $showIngresoModal = false;
    public bool $showSalidaModal  = false;

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

    protected $queryString = [
        'search'        => ['except' => ''],
        'typeFilter'    => ['except' => ''],
        'sortField'     => ['except' => 'date'],
        'sortDirection' => ['except' => 'desc'],
        'page'          => ['except' => 1],
    ];

    public function mount()
    {
        $this->products  = Product::orderBy('name')->get();
        $this->suppliers = Supplier::orderBy('name')->get();
        $this->receivers = User::orderBy('name')->get();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

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
                '' AS party, -- Si quieres mostrar proveedor, ajusta esto
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
                '' AS party, -- Si tienes destinatario, ajústalo aquí
                CONCAT(u.name, ' ', u.last_name) AS user
            ");

        // Unión
        $unionQuery = $ingresos->unionAll($salidas);

        // Subconsulta para paginación
        $combined = DB::table(DB::raw("({$unionQuery->toSql()}) as movements"))
            ->mergeBindings($unionQuery);

        // Filtros
        if ($this->typeFilter) {
            $combined->where('type', $this->typeFilter);
        }
        if ($this->search) {
            $s = strtolower($this->search);
            $combined->where(function($q) use ($s) {
                $q->whereRaw('LOWER(product_name) LIKE ?', ["%{$s}%"])
                  ->orWhereRaw('LOWER(user) LIKE ?', ["%{$s}%"])
                  ->orWhere('product_code', 'LIKE', "%{$s}%")
                  ->orWhere('movement_id', 'LIKE', "%{$s}%");
            });
        }

        // Orden
        $allowed = ['date', 'type', 'product_code', 'product_name', 'amount', 'party', 'user'];
        if (!in_array($this->sortField, $allowed)) $this->sortField = 'date';
        $combined->orderBy($this->sortField, $this->sortDirection);

        $movements = $combined->paginate(12);

        return view('livewire.products-mov', [
            'movements' => $movements,
        ]);
    }

    public function updatingSearch()    { $this->resetPage(); }
    public function updatingTypeFilter(){ $this->resetPage(); }

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

    // Modales
    public function openIngresoModal()
    {
        $this->reset(['ingresoProductCode', 'ingresoAmount', 'ingresoSupplier']);
        $this->showIngresoModal = true;
    }
    public function closeIngresoModal() { $this->showIngresoModal = false; }

    public function openSalidaModal()
    {
        $this->reset(['salidaProductCode', 'salidaAmount', 'salidaReceiver']);
        $this->showSalidaModal = true;
    }
    public function closeSalidaModal() { $this->showSalidaModal = false; }

    // Guardar Ingreso
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
            $ticket = Ticket::create([
                'card_id' => Auth::user()->card,
            ]);
            TicketDetail::create([
                'ticket_id'    => $ticket->id,
                'product_code' => $this->ingresoProductCode,
                'amount'       => $this->ingresoAmount,
            ]);
            $product = Product::lockForUpdate()->findOrFail($this->ingresoProductCode);
            $product->increment('stock', $this->ingresoAmount);
        });

        $this->dispatch('event-notify', 'Ingreso registrado con éxito.');
        $this->closeIngresoModal();
    }

    // Guardar Salida
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
            $exit = ProductExit::create([
                'card_id' => Auth::user()->card,
            ]);
            ExitDetail::create([
                'exit_id'     => $exit->id,
                'product_code'=> $this->salidaProductCode,
                'amount'      => $this->salidaAmount,
            ]);
            $product = Product::lockForUpdate()->findOrFail($this->salidaProductCode);
            if ($product->stock < $this->salidaAmount) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'salidaAmount' => "Stock insuficiente (actual: {$product->stock})",
                ]);
            }
            $product->decrement('stock', $this->salidaAmount);
        });

        $this->dispatch('event-notify', 'Salida registrada con éxito.');
        $this->closeSalidaModal();
    }
}
