<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Company;
use App\Models\State;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;

class UserManager extends Component
{
    use WithPagination;

    public $name, $last_name, $email, $phone, $password, $company_nit, $state_id, $card, $role_id = 1;
    public $view = 'index';
    public $editCard = null;
    public $search = '';
    public $states, $companies;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->resetPage();
        $this->companies = Company::all();
        $this->states = State::all();
    }

    protected function createRules()
    {
        return [
            'card' => 'required|unique:users,card',
            'name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|numeric',
            'password' => 'required|min:8',
        ];
    }

    protected function updateRules()
    {
        return [
            'card' => 'required|exists:users,card',
            'name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'email' => 'required|email|exists:users,email',
            'phone' => 'nullable|numeric',
            'password' => 'required|min:8',
        ];
    }

    public function create()
    {
        $this->reset('search');
        $this->view = 'create';
    }

    public function index()
    {
        $this->reset();
        $this->view = 'index';
    }

    public function save()
    {
        $this->validate($this->createRules());

        User::create([
            'card' => $this->card,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'role_id' => $this->role_id,
            'company_nit' => $this->company_nit,
            'state_id' => $this->state_id,
        ]);

        $this->reset();
        $this->view = 'index';
        $this->dispatch('event-notify', 'Usuario creado exitosamente.');
    }

    protected function generateCard()
    {
        return User::max('card') + 1;
    }

    public function edit($card)
    {
        $this->reset('search');
        $user = User::findOrFail($card);
        $this->editCard = $user->card;
        $this->card = $user->card;
        $this->name = $user->name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->company_nit = $user->company_nit;
        $this->state_id = $user->state_id;
        $this->view = 'edit';
    }

    public function update()
    {
        $this->validate($this->updateRules());
        $user = User::findOrFail($this->editCard);
        $user->update([
            'card' => $this->card,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'company_nit' => $this->company_nit,
            'state_id' => $this->state_id,
        ]);

        $this->reset();
        $this->view = 'index';
        $this->dispatch('event-notify', 'Usuario actualizado exitosamente.');
    }

    public function delete($card)
    {
        $this->dispatch('event-confirm', $card);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($card)
    {
        User::findOrFail($card)->delete();
        $this->dispatch('event-notify', 'Usuario eliminado exitosamente.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->where('role_id', 1)
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderByDesc('card')
            ->paginate(10);

        return view('livewire.user-manager', compact('users'));
    }
}