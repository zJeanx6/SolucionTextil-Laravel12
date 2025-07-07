<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\{Element, Roll, Shopping, ShoppingDetail, Loan, LoanDetail, Supplier, User, RollMovement, LoanReturn, ElementMovement};

// #[Lazy]
class ElementsMov extends Component
{
    use WithPagination, WithFileUploads;

    public $page = 1;

    // ————— Propiedades para los modales —————
    public bool $showIngresoModal  = false;
    public bool $showSalidaModal   = false;
    public bool $showReturnModal   = false;
    public bool $showDetailModal   = false;

    // Detalle de movimiento
    public string $detailTitle = '';
    public array  $detailItems = [];

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
        ['element_code' => null, 'amount' => null],
    ];

    // ————— Variables públicas para “Registrar Salida” —————
    public $salidaGroup            = '';
    public $elementsBySalidaGroup  = [];
    public $salidaInstructorId     = null;
    public $salidaFile             = null;

    public $salidaItems = [
        ['element_code' => null, 'roll_code' => null, 'used_length' => null, 'amount' => null],
    ];

    // ————— Listas auxiliares (proveedores, instructores) —————
    public $suppliers   = [];
    public $instructors = [];

    // ————— Campos para la tabla combinada “Préstamos + Compras” —————
    public string $search        = '';
    public string $typeFilter    = '';
    public string $sortField     = 'date';
    public string $sortDirection = 'desc';

    //Campos para crear un nuevo proveedor
    public $showNewSupplierModal = false; //Controla la visibilidad del modal para crear un nuevo proveedor
    public $newSupplierNit, $newSupplierName, $newSupplierPersonType, $newSupplierEmail, $newSupplierPhone;
    public $newSupplierRepName, $newSupplierRepEmail, $newSupplierRepPhone;
    public $newSupplierShowJuridica = false;
    public $supplier_nit = '';
    public $company_nit = '';
    

    protected $queryString = [
        'search'        => ['except' => ''],
        'typeFilter'    => ['except' => ''],
        'sortField'     => ['except' => 'date'],
        'sortDirection' => ['except' => 'desc'],
        'page'          => ['except' => 1],
    ];

    protected array $genericMessages = [
        'required'        => 'El campo :attribute es obligatorio.',
        'min'             => 'El campo :attribute debe tener al menos :min.',
        'max'             => 'El campo :attribute no puede ser mayor a :max.',
        'integer'         => 'El campo :attribute debe ser un número entero.',
        'numeric'         => 'El campo :attribute debe ser un número.',
        'array'           => 'El campo :attribute debe ser un arreglo.',
        'digits_between'  => 'El campo :attribute debe tener entre :min y :max dígitos.',
        'distinct'        => 'No puedes repetir valores en :attribute.',
        'exists'          => 'El :attribute seleccionado no es válido.',
        'in'              => 'El :attribute seleccionado no es válido.',
        'image'           => 'El archivo de :attribute debe ser una imagen.',
    ];

    public function mount(): void
    {
        // Cargar proveedores e instructores
        $this->suppliers   = [];
        $this->instructors = [];

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
        // Iniciamos la consulta con los movimientos
        $query = ElementMovement::select(['id as movement_id', 'type', 'party', 'user', 'file', 'created_at']);

        // 1. Filtro por tipo
        if ($this->typeFilter === 'Prestamo' || $this->typeFilter === 'Compra') {
            $query->where('type', $this->typeFilter);
        }

        // 2. Búsqueda por ficha o party
        if (strlen($this->search) > 0) {
            $s = strtolower($this->search);
            $query->where(function ($q) use ($s) {
                $q->whereRaw("LOWER(party) LIKE ?", ["%{$s}%"])
                    ->orWhereRaw("CAST(file AS CHAR) LIKE ?", ["%{$s}%"]);
            });
        }

        // 3. Filtrar los movimientos según el company_nit de los elementos relacionados (accediendo a través de los modelos correspondientes)
        $query->where(function ($q) {
            // Para movimientos de tipo Prestamo (Loan)
            $q->orWhere(function ($q) {
                $q->where('movementable_type', 'App\Models\Loan')
                    ->whereIn('movementable_id', function ($subQuery) {
                        // Filtrar préstamos por el company_nit de los elementos relacionados
                        $subQuery->select('loan_details.loan_id')
                                ->from('loan_details')
                                ->join('elements', 'loan_details.element_code', '=', 'elements.code')
                                ->where('elements.company_nit', Auth::user()->company_nit);
                    });
            });

            // Para movimientos de tipo Compra (Shopping)
            $q->orWhere(function ($q) {
                $q->where('movementable_type', 'App\Models\Shopping')
                    ->whereIn('movementable_id', function ($subQuery) {
                        // Filtrar compras por el company_nit de los elementos relacionados
                        $subQuery->select('shopping_details.shopping_id')
                                ->from('shopping_details')
                                ->join('elements', 'shopping_details.element_code', '=', 'elements.code')
                                ->where('elements.company_nit', Auth::user()->company_nit);
                    });
            });
        });

        // 4. Ordenamiento
        $allowed = ['created_at', 'type', 'party', 'user', 'file'];
        $sort = in_array($this->sortField, $allowed) ? $this->sortField : 'created_at';
        $query->orderBy($sort, $this->sortDirection);

        // 5. Paginación
        $movements = $query->paginate(12);

        // 6. Préstamos pendientes (mismo filtro por company_nit)
        $pendingReturns = DB::table('loan_details')
            ->join('loans', 'loan_details.loan_id', '=', 'loans.id')
            ->join('elements', 'loan_details.element_code', '=', 'elements.code')
            ->join('users as instr', 'loans.instructor_id', '=', 'instr.card')
            ->leftJoin('loan_returns', 'loan_details.id', '=', 'loan_returns.loan_detail_id')
            ->whereNull('loan_returns.id')
            ->where('elements.company_nit', Auth::user()->company_nit)  // Filtro por company_nit
            ->whereBetween('elements.element_type_id', [3100, 3999])
            ->select([
                'loan_details.id AS detail_id',
                'elements.name AS element_name',
                'loan_details.amount',
                'instr.name AS instr_name',
                'instr.last_name AS instr_last',
                'loans.file'
            ])
            ->get();

        return view('livewire.elements-mov', ['movements' => $movements, 'pendingReturns' => $pendingReturns]);
    }

    /* ————————————————————————————————————————————————
     | SORT y PAGINACIÓN
     |———————————————————————————————————————————————— */
    public function updatingSearch()     { $this->resetPage(); }
    public function updatingTypeFilter() { $this->resetPage(); }

    public function sortBy(string $field): void
    {
        $this->sortDirection = $this->sortField === $field
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';

        $this->sortField = $field;
        $this->resetPage();
    }

    /* ————————————————————————————————————————————————
     | MODAL DETALLE DE MOVIMIENTO
     |———————————————————————————————————————————————— */
    public function openDetailModal(int $movementId): void
    {
        $mov = ElementMovement::findOrFail($movementId);

        $this->detailTitle = $mov->type . ' – ' . $mov->created_at->format('Y-m-d H:i');
        $this->detailItems = [];

        if ($mov->type === 'Compra') {
            $this->detailItems = ShoppingDetail::where('shopping_id', $mov->movementable_id)
                ->join('elements', 'shopping_details.element_code', '=', 'elements.code')
                ->selectRaw('elements.name as nombre, shopping_details.amount as cantidad')
                ->get()->toArray();
        } else {
            $this->detailItems = LoanDetail::where('loan_id', $mov->movementable_id)
                ->join('elements', 'loan_details.element_code', '=', 'elements.code')
                ->selectRaw('elements.name as nombre, loan_details.amount as cantidad')
                ->get()->toArray();
        }

        $this->showDetailModal = true;
    }

    public function closeDetailModal(): void
    {
        $this->showDetailModal = false;
        $this->detailTitle = '';
        $this->detailItems = [];
    }

    /* ————————————————————————————————————————————————
     | ABRIR / CERRAR MODALES (Ingreso, Salida, Return)
     |———————————————————————————————————————————————— */
    public function openIngresoModal(): void
    {
        $this->resetValidation();
        if (empty($this->suppliers)) {
            $this->suppliers = Supplier::orderBy('name')->get();
        }

        $this->ingresoGroup           = '';
        $this->elementsByIngresoGroup = collect([]);
        $this->ingresoSupplierNit     = null;

        // G-01
        $this->ingresoElementCode = null;
        $this->ingresoBroad       = null;
        $this->ingresoLong        = null;
        $this->ingresoRollCount   = 1;
        $this->ingresoRollCodes   = [];

        // G-02/3/4
        $this->ingresoItems = [
            ['element_code' => null, 'amount' => null],
        ];

        $this->showIngresoModal = true;
    }

    public function closeIngresoModal(): void
    {
        $this->suppliers = [];
        $this->showIngresoModal = false;
    }

    public function openSalidaModal(): void
    {
        $this->resetValidation();
        if (empty($this->instructors)) {
            $this->instructors = User::where('role_id', 4)->where('company_nit', Auth::user()->company_nit)->orderBy('name')->get();
        }

        $this->salidaGroup           = '';
        $this->elementsBySalidaGroup = collect([]);
        $this->salidaInstructorId    = null;
        $this->salidaFile            = null;
        $this->salidaItems = [
            ['element_code' => null, 'roll_code' => null, 'used_length' => null, 'amount' => null],
        ];

        $this->showSalidaModal = true;
    }

    public function closeSalidaModal(): void
    {
        $this->instructors = [];
        $this->showSalidaModal = false;
    }

    public function openReturnModal(): void  { $this->showReturnModal = true;  }
    public function closeReturnModal(): void { $this->showReturnModal = false; }

    /* ————————————————————————————————————————————————
     | MÉTODOS DE APOYO – UpdatedIngresoGroup
     |———————————————————————————————————————————————— */
    public function updatedIngresoGroup($value): void
    {
        $this->resetValidation();
        $this->ingresoGroup           = $value;
        $this->elementsByIngresoGroup = collect([]); // Reiniciar la lista de elementos

        // Filtrar elementos según el grupo de ingreso seleccionado
        switch ($value) {
            case 'G1':
                $this->elementsByIngresoGroup = Element::whereBetween('element_type_id', [1100, 1999])
                    ->where('company_nit', Auth::user()->company_nit) // Filtrar por company_nit del usuario autenticado
                    ->orderBy('name')
                    ->get();
                break;
            case 'G2':
                $this->elementsByIngresoGroup = Element::whereBetween('element_type_id', [2100, 2999])
                    ->where('company_nit', Auth::user()->company_nit) // Filtrar por company_nit del usuario autenticado
                    ->orderBy('name')
                    ->get();
                break;
            case 'G3':
                $this->elementsByIngresoGroup = Element::whereBetween('element_type_id', [3100, 3999])
                    ->where('company_nit', Auth::user()->company_nit) // Filtrar por company_nit del usuario autenticado
                    ->orderBy('name')
                    ->get();
                break;
            case 'G4':
                $this->elementsByIngresoGroup = Element::whereBetween('element_type_id', [4100, 4999])
                    ->where('company_nit', Auth::user()->company_nit) // Filtrar por company_nit del usuario autenticado
                    ->orderBy('name')
                    ->get();
                break;
            default:
                $this->elementsByIngresoGroup = collect([]);
        }

        // Reiniciar los campos de ingreso de elementos
        $this->ingresoElementCode = null;
        $this->ingresoBroad       = null;
        $this->ingresoLong        = null;
        $this->ingresoRollCount   = 1;
        $this->ingresoRollCodes   = [];
        $this->ingresoItems       = [
            ['element_code' => null, 'amount' => null],
        ];
    }

    /* ————————————————————————————————————————————————
     | Ingreso – líneas dinámicas
     |———————————————————————————————————————————————— */
    public function addIngresoLine(): void
    {
        $this->ingresoItems[] = ['element_code' => null, 'amount' => null];
    }

    public function removeIngresoLine(int $idx): void
    {
        if (count($this->ingresoItems) > 1) {
            unset($this->ingresoItems[$idx]);
            $this->ingresoItems = array_values($this->ingresoItems);
        }
    }

    /* ————————————————————————————————————————————————
     | VALIDACIÓN – INGRESO
     |———————————————————————————————————————————————— */
    private function ingresoRules(): array
    {
        $rules = [
            'ingresoGroup'       => ['required', Rule::in(['G1', 'G2', 'G3', 'G4'])],
            'ingresoSupplierNit' => ['required', Rule::exists('suppliers', 'nit')],
        ];

        if ($this->ingresoGroup === 'G1') {
            $rules += [
                'ingresoElementCode' => ['required', 'integer', Rule::exists('elements', 'code')],
                'ingresoBroad'       => ['required', 'numeric', 'min:0.01'],
                'ingresoLong'        => ['required', 'numeric', 'min:0.01'],
                'ingresoRollCount'   => ['required', 'integer', 'min:1', 'max:50'],
                'ingresoRollCodes'   => ['required', 'array', 'size:' . $this->ingresoRollCount],
                'ingresoRollCodes.*' => ['required', 'digits_between:5,10', 'distinct', 'unique:rolls,code'],
            ];
        } else {
            foreach ($this->ingresoItems as $i => $row) {
                $rules["ingresoItems.$i.element_code"] = ['required', 'integer', Rule::exists('elements', 'code')];
                $rules["ingresoItems.$i.amount"]       = ['required', 'integer', 'min:1'];
            }
        }

        return $rules;
    }

    private function ingresoMessages(): array
    {
        return $this->genericMessages + [
            'ingresoRollCount.max'      => 'Solo puedes ingresar hasta 50 rollos a la vez.',
            'ingresoRollCodes.size'     => 'Debes ingresar exactamente :size códigos de rollos.',
            'ingresoRollCodes.*.unique' => 'Ese código de rollo ya existe.',
        ];
    }

    private function ingresoAttributes(): array
    {
        $attrs = [
            'ingresoGroup'       => 'grupo de ingreso',
            'ingresoSupplierNit' => 'proveedor',
            'ingresoElementCode' => 'elemento',
            'ingresoBroad'       => 'ancho',
            'ingresoLong'        => 'largo',
            'ingresoRollCount'   => 'cantidad de rollos',
            'ingresoRollCodes'   => 'códigos de rollos',
            'ingresoRollCodes.*' => 'código de rollo',
        ];

        foreach ($this->ingresoItems as $i => $_) {
            $n = $i + 1;
            $attrs["ingresoItems.$i.element_code"] = "elemento (línea #$n)";
            $attrs["ingresoItems.$i.amount"]       = "cantidad (línea #$n)";
        }

        return $attrs;
    }

    /* ————————————————————————————————————————————————
     | GUARDAR INGRESO
     |———————————————————————————————————————————————— */
    public function saveIngreso(): void
    {
        $this->validate(
            $this->ingresoRules(),
            $this->ingresoMessages(),
            $this->ingresoAttributes()
        );

        DB::transaction(function () {
            $shopping = Shopping::create([
                'supplier_nit' => $this->ingresoSupplierNit,
                'card_id'      => Auth::id(),
            ]);

            if ($this->ingresoGroup === 'G1') {
                $element = Element::lockForUpdate()->findOrFail($this->ingresoElementCode);

                foreach ($this->ingresoRollCodes as $code) {
                    Roll::create([
                        'code'         => $code,
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
            } else {
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

            ElementMovement::create([
                'type'              => 'Compra',
                'movementable_id'   => $shopping->id,
                'movementable_type' => Shopping::class,
                'party'             => optional(collect($this->suppliers)->firstWhere('nit', $this->ingresoSupplierNit))->name,
                'user'              => Auth::user()->name . ' ' . Auth::user()->last_name,
                'file'              => null,
            ]);
        });

        $this->dispatch('event-notify', 'Ingreso registrado con éxito.');
        $this->closeIngresoModal();
    }

    /* ————————————————————————————————————————————————
     | MÉTODOS DE APOYO – UpdatedSalidaGroup
     |———————————————————————————————————————————————— */
    public function updatedSalidaGroup($value): void
    {
        $this->resetValidation();
        $this->salidaGroup           = $value;
        $this->elementsBySalidaGroup = collect([]);

        switch ($value) {
            case 'G1':
                $this->elementsBySalidaGroup = Element::whereBetween('element_type_id', [1100, 1999])
                    ->where('company_nit', Auth::user()->company_nit)
                    ->orderBy('name')
                    ->get();
                break;
            case 'G2':
                $this->elementsBySalidaGroup = Element::whereBetween('element_type_id', [2100, 2999])
                    ->where('company_nit', Auth::user()->company_nit)
                    ->orderBy('name')
                    ->get();
                break;
            case 'G3':
                $this->elementsBySalidaGroup = Element::whereBetween('element_type_id', [3100, 3999])
                    ->where('company_nit', Auth::user()->company_nit)
                    ->orderBy('name')
                    ->get();
                break;
            case 'G4':
                $this->elementsBySalidaGroup = Element::whereBetween('element_type_id', [4100, 4999])
                    ->where('company_nit', Auth::user()->company_nit)
                    ->orderBy('name')
                    ->get();
                break;
            default:
                $this->elementsByIngresoGroup = collect([]);
        }

        $this->salidaItems = [
            ['element_code' => null, 'roll_code' => null, 'used_length' => null, 'amount' => null],
        ];
    }

    /* ————————————————————————————————————————————————
     | Salida – líneas dinámicas
     |———————————————————————————————————————————————— */
    public function addSalidaLine(): void
    {
        $this->salidaItems[] = ['element_code' => null, 'roll_code' => null, 'used_length' => null, 'amount' => null];
    }

    public function removeSalidaLine(int $idx): void
    {
        if (count($this->salidaItems) > 1) {
            unset($this->salidaItems[$idx]);
            $this->salidaItems = array_values($this->salidaItems);
        }
    }

    /* ————————————————————————————————————————————————
     | VALIDACIÓN – SALIDA
     |———————————————————————————————————————————————— */
    private function salidaRules(): array
    {
        $rules = [
            'salidaGroup'        => ['required', Rule::in(['G1', 'G2', 'G3', 'G4'])],
            'salidaInstructorId' => ['required', 'integer', Rule::exists('users', 'card')],
            'salidaFile'         => ['required', 'integer'],
        ];

        foreach ($this->salidaItems as $i => $row) {
            if ($this->salidaGroup === 'G1') {
                $rules["salidaItems.$i.element_code"] = ['required', 'integer', Rule::exists('elements', 'code')];
                $rules["salidaItems.$i.roll_code"]    = ['required', 'integer', Rule::exists('rolls', 'code')];
                $rules["salidaItems.$i.used_length"]  = [
                    'required', 'numeric', 'min:0.01',
                    function ($attr, $val, $fail) use ($row) {
                        if (!isset($row['roll_code'])) return;
                        $roll = Roll::find($row['roll_code']);
                        if ($roll && $roll->long < $val) {
                            $fail("El rollo {$roll->code} solo tiene {$roll->long} m disponibles.");
                        }
                    }
                ];
            } else {
                $rules["salidaItems.$i.element_code"] = ['required', 'integer', Rule::exists('elements', 'code')];
                $rules["salidaItems.$i.amount"]       = [
                    'required', 'integer', 'min:1',
                    function ($attr, $val, $fail) use ($row) {
                        if (!isset($row['element_code'])) return;
                        $el = Element::find($row['element_code']);
                        if ($el && $el->stock < $val) {
                            $fail("Solo hay {$el->stock} unidad(es) disponibles de {$el->name}.");
                        }
                    }
                ];
            }
        }

        return $rules;
    }

    private function salidaMessages(): array
    {
        return $this->genericMessages + [
            'salidaFile.required' => 'Debes ingresar la ficha o ambiente.',
        ];
    }

    private function salidaAttributes(): array
    {
        $attrs = [
            'salidaGroup'        => 'grupo de salida',
            'salidaInstructorId' => 'instructor',
            'salidaFile'         => 'ficha / ambiente',
        ];

        foreach ($this->salidaItems as $i => $row) {
            $n = $i + 1;
            if ($this->salidaGroup === 'G1') {
                $attrs["salidaItems.$i.element_code"] = "elemento (línea #$n)";
                $attrs["salidaItems.$i.roll_code"]    = "rollo (línea #$n)";
                $attrs["salidaItems.$i.used_length"]  = "metros a descontar (línea #$n)";
            } else {
                $label = $this->salidaGroup === 'G3' ? 'herramienta' : 'elemento';
                $attrs["salidaItems.$i.element_code"] = "$label (línea #$n)";
                $attrs["salidaItems.$i.amount"]       = ($this->salidaGroup === 'G3'
                    ? 'cantidad a prestar'
                    : 'cantidad a consumir') . " (línea #$n)";
            }
        }

        return $attrs;
    }

    /* ————————————————————————————————————————————————
     | GUARDAR SALIDA
     |———————————————————————————————————————————————— */
    public function saveSalida(): void
    {
        $this->validate(
            $this->salidaRules(),
            $this->salidaMessages(),
            $this->salidaAttributes()
        );

        DB::transaction(function () {
            $loan = Loan::create([
                'card_id'       => Auth::id(),
                'instructor_id' => $this->salidaInstructorId,
                'file'          => $this->salidaFile,
            ]);

            foreach ($this->salidaItems as $row) {
                if ($this->salidaGroup === 'G1') {
                    // G-01: Consumo de metraje
                    $roll = Roll::lockForUpdate()->findOrFail($row['roll_code']);
                    $roll->decrement('long', $row['used_length']);

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
                } else {
                    // G-02/3/4
                    $el = Element::lockForUpdate()->findOrFail($row['element_code']);
                    $el->decrement('stock', $row['amount']);

                    LoanDetail::create([
                        'loan_id'      => $loan->id,
                        'element_code' => $el->code,
                        'amount'       => $row['amount'],
                    ]);
                }
            }

            $instructor = collect($this->instructors)->firstWhere('card', $this->salidaInstructorId);
            $instName   = $instructor ? $instructor->name . ' ' . $instructor->last_name : '';

            ElementMovement::create([
                'type'              => 'Prestamo',
                'movementable_id'   => $loan->id,
                'movementable_type' => Loan::class,
                'party'             => $instName,
                'user'              => Auth::user()->name . ' ' . Auth::user()->last_name,
                'file'              => $loan->file,
            ]);
        });

        $this->dispatch('event-notify', 'Salida registrada con éxito.');
        $this->closeSalidaModal();
    }

    // ————— Devolver herramienta prestada (solo G-03) —————
    public function returnTool(int $loanDetailId): void
    {
        DB::transaction(function() use ($loanDetailId) {
            $ld = LoanDetail::lockForUpdate()->findOrFail($loanDetailId);
            if (LoanReturn::where('loan_detail_id', $ld->id)->exists()) {
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
    }

    // ————— Crear nuevo proveedor —————//
    public function updatedSupplierNit($value)
    {
        if ($value === 'new_supplier') {
            $this->supplier_nit = '';
            $this->showNewSupplierModal = true;
            return;
        }

        $this->newSupplierShowJuridica = false;
    }

    public function updatedIngresoSupplierNit($value)
    {
        if ($value === 'new_supplier') {
            $this->ingresoSupplierNit = '';
            $this->showNewSupplierModal = true;
        }
    }

    public function updatedNewSupplierPersonType($value)
    {
        $this->newSupplierShowJuridica = ($value === 'Juridica');
    }

    public function saveNewSupplier()
    {
        $rules = [
            'newSupplierNit' => 'required|min:3|max:50|unique:suppliers,nit',
            'newSupplierName' => 'required|min:3|max:50',
            'newSupplierPersonType' => 'required|in:Natural,Juridica',
            'newSupplierEmail' => 'required|email|max:50',
            'newSupplierPhone' => 'required|min:3|max:50',
        ];

        if ($this->newSupplierPersonType === 'Juridica') {
            $rules += [
                'newSupplierRepName' => 'required|min:3|max:50',
                'newSupplierRepEmail' => 'required|email|max:50',
                'newSupplierRepPhone' => 'required|min:3|max:50',
            ];
        }

        $this->validate($rules);
        
        $this->company_nit = Auth::user()->company_nit;

        $data = [
            'nit' => $this->newSupplierNit,
            'name' => $this->newSupplierName,
            'person_type' => $this->newSupplierPersonType,
            'email' => $this->newSupplierEmail,
            'phone' => $this->newSupplierPhone,
            'company_nit' => $this->company_nit,
        ];
        
        $this->company_nit = '';

        if ($this->newSupplierPersonType === 'Juridica') {
            $data += [
                'representative_name' => $this->newSupplierRepName,
                'representative_email' => $this->newSupplierRepEmail,
                'representative_phone' => $this->newSupplierRepPhone,
            ];
        }

        \App\Models\Supplier::create($data);

        $this->dispatch('event-notify', 'Proveedor creado correctamente.');

        $this->suppliers = \App\Models\Supplier::orderBy('name')->get();
        $this->supplier_nit = $this->newSupplierNit;

        // Resetea y cierra modal
        $this->reset([
            'newSupplierNit', 'newSupplierName', 'newSupplierPersonType', 'newSupplierEmail', 'newSupplierPhone',
            'newSupplierRepName', 'newSupplierRepEmail', 'newSupplierRepPhone', 'newSupplierShowJuridica'
        ]);
        $this->showNewSupplierModal = false;
    }

}

