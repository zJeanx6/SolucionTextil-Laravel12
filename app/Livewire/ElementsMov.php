<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    Element,
    Roll,
    Shopping,
    ShoppingDetail,
    Loan,
    LoanDetail,
    Supplier,
    User,
    RollMovement,
    LoanReturn
};

#[Lazy]
class ElementsMov extends Component
{
    use WithPagination, WithFileUploads;

    // ————— Propiedades para los modales —————
    public bool $showIngresoModal  = false;
    public bool $showSalidaModal   = false;
    public bool $showReturnModal   = false;

    // ————— Variables públicas para “Registrar Ingreso” —————
    public $ingresoGroup           = '';
    public $elementsByIngresoGroup = [];
    public $ingresoSupplierNit     = null;

    // *Solo para G-01 (Metraje)*:
    public $ingresoElementCode = null;
    public $ingresoBroad       = null;
    public $ingresoLong        = null;
    public $ingresoRollCount   = 1;
    public $ingresoRollCodes   = [];

    // *Para G-02, G-03, G-04*:
    public $ingresoItems = [
        [
            'element_code' => null,
            'amount'       => null,
        ]
    ];

    // ————— Variables públicas para “Registrar Salida” —————
    public $salidaGroup            = '';
    public $elementsBySalidaGroup  = [];
    public $salidaInstructorId     = null;
    public $salidaFile             = null;

    public $salidaItems = [
        [
            'element_code' => null,
            'roll_code'    => null,
            'used_length'  => null,
            'amount'       => null,
        ]
    ];

    // ————— Listas auxiliares (proveedores, instructores) —————
    public $suppliers   = [];
    public $instructors = [];

    // ————— Campos para la tabla combinada “Préstamos + Compras” —————
    public string $search        = '';
    public string $typeFilter    = '';
    public string $sortField     = 'date';
    public string $sortDirection = 'desc';

    protected $queryString = [
        'search'        => ['except' => ''],
        'typeFilter'    => ['except' => ''],
        'sortField'     => ['except' => 'date'],
        'sortDirection' => ['except' => 'desc'],
        'page'          => ['except' => 1],
    ];

    public function mount(): void
    {
        // Cargar proveedores e instructores
        $this->suppliers   = Supplier::orderBy('name')->get();
        $this->instructors = User::where('role_id', 4)->orderBy('name')->get();

        // Inicializar colecciones
        $this->elementsByIngresoGroup  = collect([]);
        $this->elementsBySalidaGroup   = collect([]);
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function render()
    {
        //
        // 1) Query para “Préstamos”
        //
        $loans = DB::table('loans')
            ->join('users as u_user', 'loans.card_id', '=', 'u_user.card')
            ->join('users as u_instructor', 'loans.instructor_id', '=', 'u_instructor.card')
            ->selectRaw("
                loans.id AS movement_id,
                loans.created_at AS date,
                'Prestamo' AS type,
                CONCAT(u_instructor.name, ' ', u_instructor.last_name) AS party,
                CONCAT(u_user.name, ' ', u_user.last_name) AS user,
                loans.file AS file
            ");

        //
        // 2) Query para “Compras”
        //
        $shoppings = DB::table('shoppings')
            ->join('users as u_user', 'shoppings.card_id', '=', 'u_user.card')
            ->join('suppliers', 'shoppings.supplier_nit', '=', 'suppliers.nit')
            ->selectRaw("
                shoppings.id AS movement_id,
                shoppings.created_at AS date,
                'Compra' AS type,
                suppliers.name AS party,
                CONCAT(u_user.name, ' ', u_user.last_name) AS user,
                NULL AS file
            ");

        //
        // 3) UNION ALL
        //
        $unionQuery = $loans->unionAll($shoppings);

        //
        // 4) Subconsulta para paginar
        //
        $combined = DB::table(DB::raw("({$unionQuery->toSql()}) AS combined"))
            ->mergeBindings($unionQuery);

        //
        // 5) Filtrar por tipo
        //
        if ($this->typeFilter === 'Prestamo') {
            $combined->where('type', 'Prestamo');
        } elseif ($this->typeFilter === 'Compra') {
            $combined->where('type', 'Compra');
        }

        //
        // 6) Búsqueda libre
        //
        if (strlen($this->search) > 0) {
            $s = strtolower($this->search);
            $combined->where(function($q) use ($s) {
                $q->whereRaw("CAST(movement_id AS CHAR) LIKE ?", ["%{$s}%"])
                  ->orWhereRaw("LOWER(type) LIKE ?", ["%{$s}%"])
                  ->orWhereRaw("LOWER(party) LIKE ?", ["%{$s}%"])
                  ->orWhereRaw("LOWER(user) LIKE ?", ["%{$s}%"])
                  ->orWhereRaw("CAST(file AS CHAR) LIKE ?", ["%{$s}%"]);
            });
        }

        //
        // 7) Ordenamiento dinámico
        //
        $allowed = ['movement_id','date','type','party','user','file'];
        if (! in_array($this->sortField, $allowed)) {
            $this->sortField = 'date';
        }
        $combined->orderBy($this->sortField, $this->sortDirection);

        //
        // 8) Paginación
        //
        $movements = $combined->paginate(12);

        //
        // 9) Obtener préstamos de herramientas pendientes de devolución
        //
        $pendingReturns = DB::table('loan_details')
            ->join('loans', 'loan_details.loan_id', '=', 'loans.id')
            ->join('elements', 'loan_details.element_code', '=', 'elements.code')
            ->join('users as instr', 'loans.instructor_id', '=', 'instr.card')
            ->leftJoin('loan_returns', 'loan_details.id', '=', 'loan_returns.loan_detail_id')
            ->whereNull('loan_returns.id')
            ->whereBetween('elements.element_type_id', [3100, 3999])
            ->select([
                'loan_details.id AS detail_id',
                'loan_details.loan_id',
                'elements.name AS element_name',
                'loan_details.amount',
                'instr.name AS instr_name',
                'instr.last_name AS instr_last',
                'loans.file'
            ])
            ->get();

        return view('livewire.elements-mov', [
            'movements'      => $movements,
            'pendingReturns' => $pendingReturns,
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

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

    // ————— Abrir/Cerrar modales —————
    public function openIngresoModal(): void
    {
        $this->ingresoGroup           = '';
        $this->elementsByIngresoGroup = collect([]);
        $this->ingresoSupplierNit     = null;

        // Para G-01
        $this->ingresoElementCode = null;
        $this->ingresoBroad       = null;
        $this->ingresoLong        = null;
        $this->ingresoRollCount   = 1;
        $this->ingresoRollCodes   = [];

        // Para G-02/3/4
        $this->ingresoItems = [
            [
                'element_code' => null,
                'amount'       => null,
            ]
        ];

        $this->showIngresoModal = true;
    }

    public function closeIngresoModal(): void
    {
        $this->showIngresoModal = false;
    }

    public function openSalidaModal(): void
    {
        $this->salidaGroup           = '';
        $this->elementsBySalidaGroup = collect([]);
        $this->salidaInstructorId    = null;
        $this->salidaFile            = null;
        $this->salidaItems           = [
            [
                'element_code' => null,
                'roll_code'    => null,
                'used_length'  => null,
                'amount'       => null,
            ]
        ];

        $this->showSalidaModal = true;
    }

    public function closeSalidaModal(): void
    {
        $this->showSalidaModal = false;
    }

    public function openReturnModal(): void
    {
        $this->showReturnModal = true;
    }

    public function closeReturnModal(): void
    {
        $this->showReturnModal = false;
    }

    // ————— Cuando cambian “ingresoGroup” —————
    public function updatedIngresoGroup($value): void
    {
        $this->ingresoGroup           = $value;
        $this->elementsByIngresoGroup = collect([]);

        switch ($value) {
            case 'G1':
                $this->elementsByIngresoGroup = Element::whereBetween('element_type_id', [1100, 1999])
                                                       ->orderBy('name')
                                                       ->get();
                break;
            case 'G2':
                $this->elementsByIngresoGroup = Element::whereBetween('element_type_id', [2100, 2999])
                                                       ->orderBy('name')
                                                       ->get();
                break;
            case 'G3':
                $this->elementsByIngresoGroup = Element::whereBetween('element_type_id', [3100, 3999])
                                                       ->orderBy('name')
                                                       ->get();
                break;
            case 'G4':
                $this->elementsByIngresoGroup = Element::whereBetween('element_type_id', [4100, 4999])
                                                       ->orderBy('name')
                                                       ->get();
                break;
            default:
                $this->elementsByIngresoGroup = collect([]);
                break;
        }

        // Restablecer datos
        $this->ingresoElementCode = null;
        $this->ingresoBroad       = null;
        $this->ingresoLong        = null;
        $this->ingresoRollCount   = 1;
        $this->ingresoRollCodes   = [];
        $this->ingresoItems       = [
            [
                'element_code' => null,
                'amount'       => null,
            ]
        ];
    }

    // ————— Agregar/Quitar líneas en “Ingreso” (G-02/3/4) —————
    public function addIngresoLine(): void
    {
        $this->ingresoItems[] = [
            'element_code' => null,
            'amount'       => null,
        ];
    }
    public function removeIngresoLine(int $index): void
    {
        if (count($this->ingresoItems) > 1) {
            unset($this->ingresoItems[$index]);
            $this->ingresoItems = array_values($this->ingresoItems);
        }
    }

    // ————— Guardar Ingreso —————
    public function saveIngreso(): void
    {
        // 1) Reglas base
        $rules = [
            'ingresoGroup'       => ['required', Rule::in(['G1','G2','G3','G4'])],
            'ingresoSupplierNit' => ['required', Rule::exists('suppliers','nit')],
        ];

        // 2) Si G-01: validar ancho, largo, roll_count y cada roll_code
        if ($this->ingresoGroup === 'G1') {
            $rules['ingresoElementCode'] = ['required','integer', Rule::exists('elements','code')];
            $rules['ingresoBroad']       = ['required','numeric','min:0.01'];
            $rules['ingresoLong']        = ['required','numeric','min:0.01'];
            $rules['ingresoRollCount']   = ['required','integer','min:1','max:50'];
            $rules['ingresoRollCodes']   = ['required','array','size:'.$this->ingresoRollCount];

            foreach ($this->ingresoRollCodes as $i => $code) {
                $rules["ingresoRollCodes.$i"] = [
                    'required',
                    'digits_between:5,10',
                    Rule::unique('rolls','code'),
                ];
            }
        }
        // 3) Si G-02/3/4: validar cada “línea” ingresada
        else {
            foreach ($this->ingresoItems as $i => $row) {
                $rules["ingresoItems.$i.element_code"] = ['required','integer', Rule::exists('elements','code')];
                $rules["ingresoItems.$i.amount"]       = ['required','integer','min:1'];
            }
        }

        // 4) Validar
        $this->validate($rules);

        // 5) Transacción
        DB::transaction(function() {
            $shopping = Shopping::create([
                'supplier_nit' => $this->ingresoSupplierNit,
                'card_id'      => Auth::id(),
            ]);

            // G-01: crear rollos
            if ($this->ingresoGroup === 'G1') {
                $element = Element::lockForUpdate()->findOrFail($this->ingresoElementCode);
                foreach ($this->ingresoRollCodes as $rollCode) {
                    Roll::create([
                        'code'         => $rollCode,
                        'broad'        => $this->ingresoBroad,
                        'long'         => $this->ingresoLong,
                        'element_code' => $element->code,
                        'state_id'     => 1,
                    ]);
                    ShoppingDetail::create([
                        'shopping_id'  => $shopping->id,
                        'element_code' => $element->code,
                        'amount'       => 1,
                    ]);
                }
            }
            // G-02/3/4: incrementar stock
            else {
                foreach ($this->ingresoItems as $row) {
                    $el = Element::lockForUpdate()->findOrFail($row['element_code']);
                    $el->increment('stock', $row['amount']);
                    ShoppingDetail::create([
                        'shopping_id'  => $shopping->id,
                        'element_code' => $el->code,
                        'amount'       => $row['amount'],
                    ]);
                }
            }
        });

        // 6) Notificación por evento
        $this->dispatch('event-notify', 'Ingreso registrado con éxito.');
        $this->closeIngresoModal();
    }

    // ————— Cuando cambian “salidaGroup” —————
    public function updatedSalidaGroup($value): void
    {
        $this->salidaGroup           = $value;
        $this->elementsBySalidaGroup = collect([]);

        switch ($value) {
            case 'G1':
                $this->elementsBySalidaGroup = Element::whereBetween('element_type_id', [1100, 1999])
                                                      ->orderBy('name')
                                                      ->get();
                break;
            case 'G2':
                $this->elementsBySalidaGroup = Element::whereBetween('element_type_id', [2100, 2999])
                                                      ->orderBy('name')
                                                      ->get();
                break;
            case 'G3':
                $this->elementsBySalidaGroup = Element::whereBetween('element_type_id', [3100, 3999])
                                                      ->orderBy('name')
                                                      ->get();
                break;
            case 'G4':
                $this->elementsBySalidaGroup = Element::whereBetween('element_type_id', [4100, 4999])
                                                      ->orderBy('name')
                                                      ->get();
                break;
            default:
                $this->elementsBySalidaGroup = collect([]);
                break;
        }

        // Restablecer líneas
        $this->salidaItems = [
            [
                'element_code' => null,
                'roll_code'    => null,
                'used_length'  => null,
                'amount'       => null,
            ]
        ];
    }

    // ————— Agregar/Quitar líneas en “Salida” —————
    public function addSalidaLine(): void
    {
        $this->salidaItems[] = [
            'element_code' => null,
            'roll_code'    => null,
            'used_length'  => null,
            'amount'       => null,
        ];
    }
    public function removeSalidaLine(int $index): void
    {
        if (count($this->salidaItems) > 1) {
            unset($this->salidaItems[$index]);
            $this->salidaItems = array_values($this->salidaItems);
        }
    }

    // ————— Guardar Salida —————
    public function saveSalida(): void
    {
        // 1) Reglas base
        $rules = [
            'salidaGroup'        => ['required', Rule::in(['G1','G2','G3','G4'])],
            'salidaInstructorId' => ['required','integer', Rule::exists('users','card')],
            'salidaFile'         => ['required','integer'],
        ];

        $attributes = [];

        // 2) Validar cada línea
        foreach ($this->salidaItems as $i => $row) {
            if ($this->salidaGroup === 'G1') {
                $rules["salidaItems.$i.element_code"] = ['required','integer', Rule::exists('elements','code')];
                $attributes["salidaItems.$i.element_code"] = "Elemento (línea #".($i+1).")";

                $rules["salidaItems.$i.roll_code"] = ['required','integer', Rule::exists('rolls','code')];
                $attributes["salidaItems.$i.roll_code"] = "Rollo (línea #".($i+1).")";

                $rules["salidaItems.$i.used_length"] = [
                    'required','numeric','min:0.01',
                    function($attribute, $value, $fail) use ($row) {
                        if (! isset($row['roll_code'])) return;
                        $roll = Roll::find($row['roll_code']);
                        if (! $roll) return;
                        if ($roll->long < $value) {
                            $fail("El rollo {$roll->code} solo tiene {$roll->long} m disponibles.");
                        }
                    }
                ];
                $attributes["salidaItems.$i.used_length"] = "Metros a descontar (línea #".($i+1).")";
            }
            elseif ($this->salidaGroup === 'G2' || $this->salidaGroup === 'G4') {
                $rules["salidaItems.$i.element_code"] = ['required','integer', Rule::exists('elements','code')];
                $attributes["salidaItems.$i.element_code"] = "Elemento (línea #".($i+1).")";

                $rules["salidaItems.$i.amount"] = [
                    'required','integer','min:1',
                    function($attr, $val, $fail) use ($row) {
                        if (! isset($row['element_code'])) return;
                        $el = Element::find($row['element_code']);
                        if (! $el) return;
                        if ($el->stock < $val) {
                            $fail("Solo hay {$el->stock} unidad(es) disponibles de {$el->name}.");
                        }
                    }
                ];
                $attributes["salidaItems.$i.amount"] = "Cantidad a consumir (línea #".($i+1).")";
            }
            else {
                // G-03: herramienta prestada
                $rules["salidaItems.$i.element_code"] = ['required','integer', Rule::exists('elements','code')];
                $attributes["salidaItems.$i.element_code"] = "Herramienta (línea #".($i+1).")";

                $rules["salidaItems.$i.amount"] = [
                    'required','integer','min:1',
                    function($attr, $val, $fail) use ($row) {
                        if (! isset($row['element_code'])) return;
                        $el = Element::find($row['element_code']);
                        if (! $el) return;
                        if ($el->stock < $val) {
                            $fail("Solo hay {$el->stock} unidad(es) disponibles de {$el->name} para préstamo.");
                        }
                    }
                ];
                $attributes["salidaItems.$i.amount"] = "Cantidad a prestar (línea #".($i+1).")";
            }
        }

        // 3) Validar
        $this->validate($rules, [], $attributes);

        // 4) Transacción
        DB::transaction(function() {
            $loan = Loan::create([
                'card_id'       => Auth::id(),
                'instructor_id' => $this->salidaInstructorId,
                'file'          => $this->salidaFile,
            ]);

            foreach ($this->salidaItems as $row) {
                if ($this->salidaGroup === 'G1') {
                    // Consumo de metraje (G-01)
                    $roll = Roll::lockForUpdate()->findOrFail($row['roll_code']);
                    $roll->decrement('long', $row['used_length']);

                    // Si se agotó el rollo, cambiar state_id a 2
                    if ($roll->long <= 0) {
                        $roll->state_id = 2;
                        $roll->save();
                    }

                    RollMovement::create([
                        'roll_code'     => $roll->code,
                        'used_length'   => $row['used_length'],
                        'instructor_id' => $this->salidaInstructorId,
                        'user_id'       => Auth::id(),
                        'loan_id'       => $loan->id,
                    ]);

                    LoanDetail::create([
                        'loan_id'      => $loan->id,
                        'element_code' => $row['element_code'],
                        'amount'       => $row['used_length'],
                    ]);
                }
                elseif ($this->salidaGroup === 'G2' || $this->salidaGroup === 'G4') {
                    // Consumo de stock
                    $el = Element::lockForUpdate()->findOrFail($row['element_code']);
                    $el->decrement('stock', $row['amount']);

                    LoanDetail::create([
                        'loan_id'      => $loan->id,
                        'element_code' => $el->code,
                        'amount'       => $row['amount'],
                    ]);
                }
                else {
                    // Préstamo de herramienta (G-03)
                    $el = Element::lockForUpdate()->findOrFail($row['element_code']);
                    $el->decrement('stock', $row['amount']);

                    LoanDetail::create([
                        'loan_id'      => $loan->id,
                        'element_code' => $el->code,
                        'amount'       => $row['amount'],
                    ]);
                }
            }
        });

        // 5) Notificación por evento
        $this->dispatch('event-notify', 'Salida registrada con éxito.');
        $this->closeSalidaModal();
    }

    // ————— Devolver herramienta prestada (solo G-03) —————
    public function returnTool(int $loanDetailId): void
    {
        DB::transaction(function() use ($loanDetailId) {
            $ld = LoanDetail::lockForUpdate()->findOrFail($loanDetailId);
            $alreadyReturned = LoanReturn::where('loan_detail_id', $ld->id)->exists();
            if ($alreadyReturned) {
                // Ya existe una devolución; simplemente retornamos sin cambio
                return;
            }

            LoanReturn::create([
                'loan_detail_id' => $ld->id,
                'returned_by'    => Auth::id(),
                'return_date'    => now(),
            ]);

            $el = Element::lockForUpdate()->findOrFail($ld->element_code);
            $el->increment('stock', $ld->amount);
        });

        $this->dispatch('event-notify', 'Herramienta devuelta y stock repuesto.');
        // Mantener abierta la lista de devoluciones para múltiples acciones
    }
}
