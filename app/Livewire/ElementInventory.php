<?php

namespace App\Livewire;

use App\Livewire\Forms\{ElementCreateForm, ElementEditForm, ElementShowForm};
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\{Element, ElementType, Color};
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\{Lazy, On, Url};

#[Lazy]
class ElementInventory extends Component
{
    use WithPagination, WithFileUploads;

    public $view = 'index';

    #[Url(except: '', keep: false, history: true)]
    public $search = '';

    #[Url(as: 'edit', except: '', keep: false, history: true)]
    public $editId = '';

    public $sortField = 'code';
    public $sortDirection = 'desc';

    public $elementTypeFilter = '';
    public $colorFilter       = '';

    public $elementTypes = [];
    public $colors       = [];

    public ElementShowForm $elementShow;
    public ElementCreateForm $elementCreate;
    public ElementEditForm $elementEdit;

    public $change_type_id = '';
    public $editing = null;

    public function mount(): void
    {
        $this->elementTypes = ElementType::orderBy('name')->get();
        $this->colors = Color::orderBy('name')->get();

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
        $this->reset('search', 'elementTypeFilter', 'colorFilter');
        $this->editId = '';
        $this->view   = 'index';
    }

    public function show($code)
    {
        $this->elementShow->show($code);
        $this->view = 'show';
    }

    public function toggleInactive()
    {
        $this->elementShow->toggleInactive();
    }

    public function create(): void
    {
        $this->reset('search', 'elementTypeFilter', 'colorFilter');
        $this->editId = '';
        $this->elementCreate->reset();
        $this->view   = 'create';
    }

    public function edit($code)
    {
        $this->resetValidation();
        $this->editId = $code;
        $this->elementEdit->edit($code);
        $this->view = 'edit';
    }

    public function save()
    {
        $this->elementCreate->save();
        $this->dispatch('event-notify', 'Elemento creado');
        $this->index();
    }

    public function update()
    {
        $this->elementEdit->update();
        $this->dispatch('event-notify', 'Elemento actualizado.');
        $this->index();
    }

    public function delete($code)
    {
        $this->dispatch('event-confirm', $code);
    }

    #[On('deleteConfirmed')] 
    public function deleteConfirmed($code)
    {
        $element = Element::where('code', $code)->firstOrFail();
        if ($element->image && Storage::disk('public')->exists($element->image)) {
            Storage::disk('public')->delete($element->image);
        }
        $element->delete();
        $this->dispatch('event-notify', 'Elemento eliminado.');
    }

    public function updatedChangeTypeId($value)
    {  
        $this->elementCreate->updatedElementTypeId($value);
    }

    public function render()
    {
        $elements = Element::query()
            ->when(
                $this->search,
                fn($q) => $q->where(function ($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%');
                })
            )
            ->when(
                $this->elementTypeFilter,
                fn($q) => $q->where('element_type_id', $this->elementTypeFilter)
            )
            ->when(
                $this->colorFilter,
                fn($q) => $q->where('color_id', $this->colorFilter)
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        return view('livewire.element-inventory', compact('elements'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingElementTypeFilter()
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
