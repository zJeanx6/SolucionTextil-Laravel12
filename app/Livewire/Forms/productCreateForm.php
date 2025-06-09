<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Livewire\Form;
use Livewire\WithFileUploads;

class ProductCreateForm extends Form
{
    use WithFileUploads;

    public $code, $name, $stock, $photo;
    public $color_id = '', $size_id = '', $product_type_id = '';

    public function rules()
    {
        return [
            'code'            => 'required|digits_between:5,10|unique:products,code',
            'name'            => 'required|string|min:3|max:255',
            'stock'           => 'required|integer|min:0',
            'color_id'        => 'required|exists:colors,id',
            'size_id'         => 'required|exists:sizes,id',
            'product_type_id' => 'required|exists:product_types,id',
            'photo'           => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'min'      => 'El campo :attribute debe tener al menos :min.',
            'max'      => 'El campo :attribute no puede ser mayor a :max.',
            'integer'  => 'El campo :attribute debe ser un número entero.',
            'numeric'  => 'El campo :attribute debe ser un número.',
            'image'    => 'El archivo debe ser una imagen.',
            'unique'   => 'Ese código ya está registrado.',
            'exists'   => 'El valor seleccionado no existe.',
            'digits_between' => 'El código debe tener entre :min y :max dígitos.',
        ];
    }

    public function attributes()
    {
        return [
            'code'            => 'código',
            'name'            => 'nombre',
            'stock'           => 'stock',
            'color_id'        => 'color',
            'size_id'         => 'talla',
            'product_type_id' => 'tipo de producto',
            'photo'           => 'imagen',
        ];
    }

    public function save()
    {
        $this->validate();

        $path = $this->photo ? $this->photo->store('products', 'public') : null;

        Product::create([
            'code'            => $this->code,
            'name'            => $this->name,
            'stock'           => $this->stock,
            'color_id'        => $this->color_id,
            'size_id'         => $this->size_id,
            'product_type_id' => $this->product_type_id,
            'image'           => $path,
        ]);

        $this->reset([
            'code',
            'name',
            'stock',
            'color_id',
            'size_id',
            'product_type_id',
            'photo'
        ]);
    }
}
