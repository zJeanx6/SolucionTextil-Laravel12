<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Form;
use Livewire\WithFileUploads;

class ProductEditForm extends Form
{
    use WithFileUploads;

    public $code = '';
    public $code_edit = '';
    public $name = '';
    public $stock = '';
    public $color_id = '';
    public $size_id = '';
    public $product_type_id = '';
    public $photo = null;
    public $image_path = null;

    public function edit($code)
    {
        $product = Product::where('code', $code)->firstOrFail();

        $this->code            = $product->code;
        $this->code_edit       = $product->code;
        $this->name            = $product->name;
        $this->stock           = $product->stock;
        $this->color_id        = $product->color_id;
        $this->size_id         = $product->size_id;
        $this->product_type_id = $product->product_type_id;
        $this->photo           = null;
        $this->image_path      = $product->image;
    }

    public function rules()
    {
        return [
            'code_edit'        => 'required|integer|exists:products,code',
            'name'             => 'required|string|min:3|max:255',
            'stock'            => 'required|integer|min:0',
            'color_id'         => 'required|exists:colors,id',
            'size_id'          => 'required|exists:sizes,id',
            'product_type_id'  => 'required|exists:product_types,id',
            'photo'            => 'nullable|image|max:2048',
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
            'exists'   => 'El valor seleccionado no existe.',
        ];
    }

    public function attributes()
    {
        return [
            'code_edit'        => 'código',
            'name'             => 'nombre',
            'stock'            => 'stock',
            'color_id'         => 'color',
            'size_id'          => 'talla',
            'product_type_id'  => 'tipo de producto',
            'photo'            => 'imagen',
        ];
    }

    public function update()
    {
        $this->validate();
        $product = Product::where('code', $this->code)->firstOrFail();

        // Nueva foto
        if ($this->photo) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $this->photo->store('products', 'public');
        }

        // Sin nueva foto, pero usuario quitó la actual
        if (!$this->photo && is_null($this->image_path) && $product->image) {
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = null;
        }

        $product->update([
            'name'             => $this->name,
            'stock'            => $this->stock,
            'color_id'         => $this->color_id,
            'size_id'          => $this->size_id,
            'product_type_id'  => $this->product_type_id,
            'image'            => $product->image,
        ]);

        $this->reset();
    }
}
