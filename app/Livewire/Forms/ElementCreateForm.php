<?php

namespace App\Livewire\Forms;

use App\Models\{Element, Roll};
use Livewire\Form;
use Livewire\WithFileUploads;

class ElementCreateForm extends Form
{
    use WithFileUploads;

    //Para datos del formulario
    public $code, $name, $stock, $broad, $long, $photo;
    public $element_type_id = '', $color_id = '';

    // Solo G-01
    public $roll_count = 1, $roll_codes = [];

    // Para campos visibles según tipo de elemento
    public $visibleFields = [];
    protected $groups = [
        'G1' => ['range' => [1100, 1999], 'fields' => ['color_id'], 'is_metraje' => true],
        'G2' => ['range' => [2100, 2999], 'fields' => ['color_id', 'stock'], 'is_metraje' => false],
        'G3' => ['range' => [3100, 3999], 'fields' => ['stock'], 'is_metraje' => false],
        'G4' => ['range' => [4100, 4999], 'fields' => ['stock'], 'is_metraje' => false],
    ];


    // ------------ VISIBILIDAD Y GRUPO ------------ //

    public function updatedElementTypeId($value)
    {
        $this->element_type_id = $value;
        $this->visibleFields = [];
        foreach ($this->groups as $g) {
            [$min, $max] = $g['range'];
            if ($value >= $min && $value <= $max) {
                $this->visibleFields = $g['fields'];
                break;
            }
        }
    }

    public function isMetrajeType()
    {
        foreach ($this->groups as $g) {
            [$min, $max] = $g['range'];
            if ($this->element_type_id >= $min && $this->element_type_id <= $max) {
                return $g['is_metraje'];
            }
        }
        return false;
    }

    
    // ------------ VALIDACIÓN DINÁMICA ------------ //

    public function rules()
    {
        $rules = [
            'code'             => 'required|digits_between:5,10|unique:elements,code',
            'name'             => 'required|string|min:3|max:255',
            'element_type_id'  => 'required|integer|exists:element_types,id',
            'photo'            => 'nullable|image|max:2048',
        ];

        if (in_array('color_id', $this->visibleFields)) {
            $rules['color_id'] = 'required|exists:colors,id';
        }

        if (in_array('stock', $this->visibleFields)) {
            $rules['stock'] = 'required|integer|min:0';
        }

        // G-01: metraje (rollos)
        if ($this->isMetrajeType()) {
            $rules['broad'] = 'required|numeric|min:0.01';
            $rules['long']  = 'required|numeric|min:0.01';
            $rules['roll_count'] = 'required|integer|min:1|max:20';
            $rules['roll_codes'] = 'required|array|size:' . $this->roll_count;
            foreach ($this->roll_codes as $k => $code) {
                $rules["roll_codes.$k"] = 'required|digits_between:5,10|unique:rolls,code';
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            // General
            'required' => 'El campo :attribute es obligatorio.',
            'min' => 'El campo :attribute debe tener al menos :min.',
            'max' => 'El campo :attribute no puede ser mayor a :max.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'image' => 'El archivo de :attribute debe ser una imagen.',
            'array' => 'El campo :attribute debe ser un arreglo.',

            // Código de elemento
            'code.required' => 'Debes ingresar un código para el elemento.',
            'code.digits_between' => 'El código debe tener entre :min y :max dígitos.',
            'code.unique' => 'Ya existe un elemento con ese código.',

            // Nombre
            'name.required' => 'Debes ingresar el nombre del elemento.',
            'name.string' => 'El nombre debe ser texto.',
            'name.min' => 'El nombre debe tener al menos :min caracteres.',
            'name.max' => 'El nombre no debe superar los :max caracteres.',

            // Tipo de elemento
            'element_type_id.required' => 'Selecciona el tipo de elemento.',
            'element_type_id.exists' => 'El tipo de elemento seleccionado no es válido.',

            // Color
            'color_id.required' => 'Selecciona un color.',
            'color_id.exists' => 'El color seleccionado no existe.',

            // Stock
            'stock.required' => 'Debes ingresar la cantidad en stock.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',

            // Imagen
            'photo.image' => 'El archivo debe ser una imagen.',
            'photo.max' => 'La imagen no debe pesar más de 2MB.',

            // Ancho y largo (metraje)
            'broad.required' => 'Debes indicar el ancho.',
            'broad.numeric' => 'El ancho debe ser un número.',
            'broad.min' => 'El ancho debe ser mayor a 0.',
            'long.required' => 'Debes indicar el largo.',
            'long.numeric' => 'El largo debe ser un número.',
            'long.min' => 'El largo debe ser mayor a 0.',

            // Rollos
            'roll_count.required' => 'Indica cuántos rollos deseas ingresar.',
            'roll_count.integer' => 'La cantidad de rollos debe ser un número entero.',
            'roll_count.min' => 'Debes ingresar al menos 1 rollo.',
            'roll_count.max' => 'Solo puedes ingresar hasta 20 rollos a la vez.',
            'roll_codes.required' => 'Debes ingresar los códigos de los rollos.',
            'roll_codes.array' => 'Debes ingresar todos los códigos de rollos.',
            'roll_codes.size' => 'Debes ingresar exactamente :size códigos de rollos.',

            // Cada código de rollo
            'roll_codes.*.required' => 'Debes ingresar el código para cada rollo.',
            'roll_codes.*.digits_between' => 'Cada código de rollo debe tener entre :min y :max dígitos.',
            'roll_codes.*.unique' => 'Ese código de rollo ya existe.',
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'código',
            'name' => 'nombre',
            'stock' => 'stock',
            'broad' => 'ancho',
            'long' => 'largo',
            'color_id' => 'color',
            'element_type_id' => 'tipo de elemento',
            'photo' => 'imagen',
            'roll_count' => 'cantidad de rollos',
            'roll_codes' => 'códigos de rollos',
            'roll_codes.*' => 'código de rollo',
        ];
    }

    // ------------ GUARDADO ------------ //

    public function save()
    {
        $this->validate();

        $path = $this->photo ? $this->photo->store('elements', 'public') : null;

        if ($this->isMetrajeType()) {
            $element = Element::create([
                'code'            => $this->code,
                'name'            => $this->name,
                'stock'           => 0, // metraje no usa stock aquí
                'color_id'        => $this->color_id,
                'element_type_id' => $this->element_type_id,
                'image'           => $path,
            ]);
            // Crear N rollos
            foreach ($this->roll_codes as $roll_code) {
                Roll::create([
                    'code'         => $roll_code,
                    'broad'        => $this->broad,
                    'long'         => $this->long,
                    'element_code' => $element->code,
                ]);
            }
        } else {
            Element::create([
                'code'            => $this->code,
                'name'            => $this->name,
                'stock'           => $this->stock,
                'color_id'        => in_array('color_id', $this->visibleFields) ? $this->color_id : null,
                'element_type_id' => $this->element_type_id,
                'image'           => $path,
            ]);
        }

        $this->reset([
            'code',
            'name',
            'stock',
            'broad',
            'long',
            'color_id',
            'element_type_id',
            'photo',
            'roll_count',
            'roll_codes',
            'visibleFields'
        ]);
    }
}
