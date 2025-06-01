<?php

namespace App\Livewire\Forms;

use App\Models\Element;
use App\Models\Roll;
use Illuminate\Support\Facades\Storage;
use Livewire\Form;
use Livewire\WithFileUploads;

class ElementEditForm extends Form
{
    use WithFileUploads;

    // ───────────────────────── DATOS DEL ELEMENTO ─────────────────────────
    public $code           = '';   // clave para buscar – NO se edita
    public $code_edit      = '';   // por si un día se desea editar el code
    public $name           = '';
    public $stock          = null;
    public $broad          = null;
    public $long           = null;
    public $color_id       = '';
    public $element_type_id = '';

    // Imagen
    public $photo       = null;   // archivo nuevo (temporal)
    public $image_path  = null;   // ruta actual en BD

    // ───────────────────────── SOLO G-1 (METRAJE) ─────────────────────────
    public $rolls      = [];          // colección Roll (para la vista)
    public $rollLongs  = [];          // [code => long]

    // ───────────────────────── VISIBILIDAD DE CAMPOS ──────────────────────
    public $visibleFields = [];
    protected $groups = [
        'G1' => ['range' => [1100, 1999], 'fields' => ['color_id'],        'is_metraje' => true],
        'G2' => ['range' => [2100, 2999], 'fields' => ['color_id','stock'], 'is_metraje' => false],
        'G3' => ['range' => [3100, 3999], 'fields' => ['stock'],            'is_metraje' => false],
        'G4' => ['range' => [4100, 4999], 'fields' => ['stock'],            'is_metraje' => false],
    ];

    /* ==============================================================
       =================  MÉTODOS AUXILIARES ==========================
       ============================================================== */

    public function updatedElementTypeId($value)
    {
        $this->element_type_id = $value;
        $this->visibleFields   = [];

        foreach ($this->groups as $g) {
            [$min, $max] = $g['range'];
            if ($value >= $min && $value <= $max) {
                $this->visibleFields = $g['fields'];
                break;
            }
        }
    }

    public function isMetrajeType(): bool
    {
        foreach ($this->groups as $g) {
            [$min, $max] = $g['range'];
            if ($this->element_type_id >= $min && $this->element_type_id <= $max) {
                return $g['is_metraje'];
            }
        }
        return false;
    }

    /* ==============================================================
       =================  CARGAR REGISTRO ============================
       ============================================================== */
    public function edit($code)
    {
        $el = Element::where('code', $code)->firstOrFail();

        $this->code            = $el->code;
        $this->code_edit       = $el->code;
        $this->name            = $el->name;
        $this->stock           = $el->stock;
        $this->broad           = $el->broad;
        $this->long            = $el->long;
        $this->color_id        = $el->color_id;
        $this->element_type_id = $el->element_type_id;
        $this->photo           = null;
        $this->image_path      = $el->image;

        $this->updatedElementTypeId($this->element_type_id);

        if ($this->isMetrajeType()) {
            $this->rolls = Roll::where('element_code', $this->code)->where('state_id', 1)->get();
            $this->rollLongs = [];
            foreach ($this->rolls as $r) {
                $this->rollLongs[$r->code] = $r->long;
            }
        } else {
            $this->rolls = [];
            $this->rollLongs = [];
        }
    }

    /* ==============================================================
       ======================  VALIDACIÓN  ===========================
       ============================================================== */
    public function rules(): array
    {
        $rules = [
            'code_edit'       => 'required|integer|exists:elements,code',
            'name'            => 'required|string|min:3|max:255',
            'element_type_id' => 'required|integer|exists:element_types,id',
            'photo'           => 'nullable|image|max:2048',
        ];

        if (in_array('color_id', $this->visibleFields)) {
            $rules['color_id'] = 'required|exists:colors,id';
        }

        if (in_array('stock', $this->visibleFields)) {
            $rules['stock'] = 'required|numeric|min:0';
        }

        // G1: metraje (rollos)
        if ($this->isMetrajeType()) {
            $rules['broad'] = 'nullable|numeric|min:0.01';
            $rules['long']  = 'nullable|numeric|min:0.01';

            foreach ($this->rollLongs as $code => $value) {
                $rules["rollLongs.$code"] = 'required|numeric|min:0.01';
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            // → Genéricos
            'required' => 'El campo :attribute es obligatorio.',
            'min'      => 'El campo :attribute debe tener al menos :min.',
            'max'      => 'El campo :attribute no puede ser mayor a :max.',
            'integer'  => 'El campo :attribute debe ser un número entero.',
            'numeric'  => 'El campo :attribute debe ser un número.',
            'image'    => 'El archivo de :attribute debe ser una imagen.',
            
            // → Código
            'code_edit.required' => 'Debes ingresar el código del elemento.',
            'code_edit.integer'  => 'El código debe ser un número entero.',
            'code_edit.exists'   => 'El código ingresado no existe en la base de datos.',

            // → Nombre
            'name.required' => 'Debes ingresar el nombre del elemento.',
            'name.min'      => 'El nombre debe tener al menos :min caracteres.',
            'name.max'      => 'El nombre no debe superar los :max caracteres.',

            // → Tipo de elemento
            'element_type_id.required' => 'Selecciona un tipo de elemento.',
            'element_type_id.exists'   => 'El tipo de elemento seleccionado no es válido.',

            // → Color
            'color_id.required' => 'Selecciona un color.',
            'color_id.exists'   => 'El color seleccionado no existe.',

            // → Stock
            'stock.required' => 'Debes ingresar la cantidad en stock.',
            'stock.integer'  => 'El stock debe ser un número entero.',
            'stock.min'      => 'El stock no puede ser negativo.',

            // → Ancho/largo (metraje)
            'broad.required' => 'Debes indicar el ancho del metraje.',
            'broad.numeric'  => 'El ancho debe ser un número.',
            'broad.min'      => 'El ancho debe ser mayor a 0.',

            'long.required' => 'Debes indicar el largo del metraje.',
            'long.numeric'  => 'El largo debe ser un número.',
            'long.min'      => 'El largo debe ser mayor a 0.',

            // → Rollos
            'rollLongs.*.required' => 'Debes indicar el largo de cada rollo.',
            'rollLongs.*.numeric'  => 'El largo del rollo debe ser un número.',
            'rollLongs.*.min'      => 'El largo del rollo debe ser mayor a 0.',
        ];
    }

    public function attributes(): array
    {
        return [
            'code_edit'        => 'código',
            'name'             => 'nombre',
            'stock'            => 'stock',
            'broad'            => 'ancho',
            'long'             => 'largo',
            'color_id'         => 'color',
            'element_type_id'  => 'tipo de elemento',
            'photo'            => 'imagen',
            'rollLongs.*'      => 'largo de rollo',
        ];
    }

    /* ==============================================================
       ======================  ACTUALIZAR  ===========================
       ============================================================== */
    public function update()
    {
        $this->validate();
        $element = Element::where('code', $this->code)->firstOrFail();
        
        /* ------------------------------------------------------------------
        1. NUEVA FOTO → borrar la vieja (si existe) y asignar la nueva
        ------------------------------------------------------------------ */
        if ($this->photo) {
            if ($element->image && Storage::disk('public')->exists($element->image)) {
                Storage::disk('public')->delete($element->image);
            }
            $element->image = $this->photo->store('elements', 'public');
        }
        
        /* ------------------------------------------------------------------
        2. SIN NUEVA FOTO, PERO EL USUARIO QUITÓ LA ACTUAL (image_path = null)
        ------------------------------------------------------------------ */
        if (!$this->photo && is_null($this->image_path) && $element->image) {
            if (Storage::disk('public')->exists($element->image)) {
                Storage::disk('public')->delete($element->image);
            }
            $element->image = null;   // quedará NULL en BD
        }
        
        /* ------------------------------------------------------------------
        3. ACTUALIZAR DEMÁS CAMPOS
        ------------------------------------------------------------------ */
        $element->update([
            'name'             => $this->name,
            'stock'            => $this->stock,
            'broad'            => $this->broad,
            'long'             => $this->long,
            'color_id'         => $this->color_id,
            'element_type_id'  => $this->element_type_id,
            'image'            => $element->image,
        ]);
        
        /* ------------------------------------------------------------------
        4. ACTUALIZAR LARGOS DE ROLLOS (si aplica)
        ------------------------------------------------------------------ */
        if ($this->isMetrajeType()) {
            foreach ($this->rollLongs as $rollCode => $newLong) {
                Roll::where('code', $rollCode)->update(['long' => $newLong]);
            }
        }

        $this->reset();
    }
}
