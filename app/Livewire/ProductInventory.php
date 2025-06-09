<?php

namespace App\Livewire;

use App\Livewire\Forms\{ProductCreateForm, ProductEditForm, ProductShowForm};
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\{Product, ProductType, Color, Size};
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\{Lazy, On, Url};

#[Lazy]
class ProductInventory extends Component
{
    use WithPagination, WithFileUploads;

    public $view = 'index';

    #[Url(except: '', keep: false, history: true)]
    public $search = '';

    #[Url(as: 'edit', except: '', keep: false, history: true)]
    public $editId = '';

    public $sortField = 'code';
    public $sortDirection = 'desc';

    public $productTypeFilter = '';
    public $colorFilter       = '';

    public $productTypes = [];
    public $colors      = [];
    public $sizes       = [];

    public ProductShowForm   $productShow;
    public ProductCreateForm $productCreate;
    public ProductEditForm   $productEdit;

    public $change_type_id = '';
    public $editing = null;

    public function mount(): void
    {
        $this->productTypes = ProductType::orderBy('name')->get();
        $this->colors       = Color::orderBy('name')->get();
        $this->sizes        = Size::orderBy('name')->get();

        if ($this->editId) {
            $this->edit($this->editId);
        }
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function index()
    {
        $this->reset('search', 'productTypeFilter', 'colorFilter');
        $this->editId = '';
        $this->view   = 'index';
    }

    public function show($code)
    {
        $this->productShow->show($code);
        $this->view = 'show';
    }

    public function create(): void
    {
        $this->reset('search', 'productTypeFilter', 'colorFilter');
        $this->editId = '';
        $this->productCreate->reset();
        $this->view   = 'create';
    }

    public function edit($code)
    {
        $this->resetValidation();
        $this->editId = $code;
        $this->productEdit->edit($code);
        $this->view = 'edit';
    }

    public function save()
    {
        $this->productCreate->save();
        $this->dispatch('event-notify', 'Producto creado.');
        $this->index();
    }

    public function update()
    {
        $this->productEdit->update();
        $this->dispatch('event-notify', 'Producto actualizado.');
        $this->index();
    }

    public function delete($code)
    {
        $this->dispatch('event-confirm', $code);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($code)
    {
        $product = Product::where('code', $code)->firstOrFail();
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        $this->dispatch('event-notify', 'Producto eliminado.');
    }

    public function render()
    {
        $products = Product::query()
            ->when(
                $this->search,
                fn($q) => $q->where(function ($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%');
                })
            )
            ->when(
                $this->productTypeFilter,
                fn($q) => $q->where('product_type_id', $this->productTypeFilter)
            )
            ->when(
                $this->colorFilter,
                fn($q) => $q->where('color_id', $this->colorFilter)
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        return view('livewire.product-inventory', compact('products'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingProductTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingColorFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField     = $field;
            $this->sortDirection = 'asc';
        }
    }
}
