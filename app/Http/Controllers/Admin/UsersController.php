<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Role, State};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Class UsersController
 *
 * Gestiona las operaciones CRUD para el modelo User.
 * Nota: la PK de users es el campo 'card' (cédula colombiana).
 */
class UsersController extends Controller
{
    /**
     * Muestra una lista paginada de usuarios ordenada por 'card' descendente.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::where('company_nit', Auth::user()->company_nit)
                    ->where('role_id', '!=', 9)
                    ->orderBy('card', 'desc')
                    ->paginate(12);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra la vista para crear un nuevo usuario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create', [
            'roles'  => Role::where('id', '!=', 9)->get(),
            'states' => State::whereIn('id', [1, 2])->get(),
        ]);
    }

    /**
     * Valida y guarda un nuevo usuario en la base de datos.
     * - 'card':       obligatorio, entre 6 y 11 dígitos (cédula colombiana), único en users.card.
     * - 'name':       obligatorio, entre 3 y 255 caracteres.
     * - 'last_name':  obligatorio, entre 3 y 255 caracteres.
     * - 'email':      obligatorio, email válido, único en users.email.
     * - 'phone':      obligatorio, entre 10 y 15 caracteres.
     * - 'password':   obligatorio, mínimo 6 caracteres, debe confirmarse.
     * - 'role_id':    existe en roles.id.
     * - 'state_id':   existe en states.id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'card'        => 'required|digits_between:6,11|unique:users,card',
            'name'        => 'required|string|min:3|max:255',
            'last_name'   => 'required|string|min:3|max:255',
            'email'       => 'required|email|unique:users,email',
            'phone'       => 'required|string|min:10|max:15',
            'password'    => 'required|string|min:6|confirmed',
            'role_id'     => 'required|exists:roles,id',
            'state_id'    => 'required|exists:states,id',
        ]);
        $data['company_nit'] = Auth::user()->company_nit;

        // Hashear contraseña antes de guardar
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra la vista de edición para el usuario dado.
     *
     * @param  User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles  = Role::where('id', '!=', 9)->get();
        $states = State::whereIn('id', [1, 2])->get();

        return view('admin.users.edit', compact('user', 'roles', 'states'));
    }

    /**
     * Valida y actualiza el usuario existente en la base de datos.
     * - 'card':       obligatorio, entre 6 y 11 dígitos, único en users.card (ignora la PK actual).
     * - 'name':       obligatorio, entre 3 y 255 caracteres.
     * - 'last_name':  obligatorio, entre 3 y 255 caracteres.
     * - 'email':      obligatorio, email válido, único en users.email (ignora la PK actual).
     * - 'phone':      obligatorio, entre 10 y 15 caracteres.
     * - 'password':   opcional, mínimo 6 caracteres, debe confirmarse; si no se envía, queda la existente.
     * - 'role_id':    existe en roles.id.
     * - 'state_id':   existe en states.id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User                        $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'card'        => [
                'required',
                'digits_between:6,11',
                Rule::unique('users', 'card')->ignore($user->card, 'card'),
            ],
            'name'        => 'required|string|min:3|max:255',
            'last_name'   => 'required|string|min:3|max:255',
            'email'       => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->card, 'card'),
            ],
            'phone'       => 'required|string|min:10|max:15',
            'password'    => 'nullable|string|min:6|confirmed',
            'role_id'     => 'required|exists:roles,id',
            'state_id'    => 'required|exists:states,id',
        ]);

        // Hashear nueva contraseña o descartar si no se proporcionó
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.edit', $user)
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Verifica si el usuario tiene registros relacionados en otras tablas
     *
     * @param  User  $user
     * @return bool
     */
    private function hasRelatedData(User $user)
    {
        // Verificamos si el usuario tiene registros en las tablas relacionadas
        $hasLoans = DB::table('loans')->where('card_id', $user->card)->exists();
        $hasTickets = DB::table('tickets')->where('card_id', $user->card)->exists();
        $hasShoppings = DB::table('shoppings')->where('card_id', $user->card)->exists();
        $hasExits = DB::table('exits')->where('card_id', $user->card)->exists();
        $hasMaintenances = DB::table('maintenances')->where('card_id', $user->card)->exists();

        // Si alguno de los registros existe, retornamos true
        return $hasLoans || $hasTickets || $hasShoppings || $hasExits || $hasMaintenances;
    }

    /**
     * Elimina el usuario de la base de datos.
     *
     * @param  User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Verificamos si el usuario está intentando eliminarse a sí mismo
        if ($user->card == Auth::user()->card) {
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'No te puedes eliminar a ti mismo.');
        }

        // Verificamos si el usuario tiene registros relacionados
        $hasRelatedData = $this->hasRelatedData($user);

        if ($hasRelatedData) {
            // Si tiene registros relacionados, mostramos un mensaje amigable
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'No se puede eliminar el usuario porque está relacionado con otros registros.');
        }

        // Si no tiene datos relacionados, proceder con la eliminación
        $user->delete();

        // Redirigir y mostrar mensaje de éxito
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
