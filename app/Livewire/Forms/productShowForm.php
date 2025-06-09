<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Livewire\Form;

class ProductShowForm extends Form
{
    public $code;
    public $name;
    public $stock;
    public $color_id;
    public $size_id;
    public $product_type_id;
    public $image_path;

    public function show($code)
    {
        $product = Product::where('code', $code)->firstOrFail();

        $this->code            = $product->code;
        $this->name            = $product->name;
        $this->stock           = $product->stock;
        $this->color_id        = $product->color_id;
        $this->size_id         = $product->size_id;
        $this->product_type_id = $product->product_type_id;
        $this->image_path      = $product->image;
    }
}
