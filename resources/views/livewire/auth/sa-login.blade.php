<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\Models\User;

new #[Layout('components.layouts.sa-auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login()
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        $user = User::where('email', $this->email)->first();

        //Si el usuario existe y si tiene rol diferente de id 9
            if ($user && $user->role_id != 9) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages(['email' => __('No tienes acceso a esta plataforma.')]);
            }

        // Login normal
            if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                RateLimiter::hit($this->throttleKey());
                if (!$user) {
                    throw ValidationException::withMessages(['email' => __('El correo electrónico no está registrado.')]);
                }
                throw ValidationException::withMessages(['password' => __('La contraseña es incorrecta.')]);
            }


        //Si el usuario existe y tiene estado activo
            $user = Auth::user();
            if ($user->state_id !== 1) {
                Auth::logout();
                throw ValidationException::withMessages(['email' => __('La cuenta está registrada, pero se encuentra desactivada. Por favor, contacte al administrador para más información.')]);
            }

            RateLimiter::clear($this->throttleKey());
            Session::regenerate();

        //Si cumplió con todo y verificamos que tenga rol id 9, redirigir a dashboard admin sino a home
            if ($user->role_id == 9) {
                $this->redirect(route('admin.sa.dashboard-sa'), navigate: true);
            } else {
                $this->redirect(route('home'), navigate: true);
            }
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Bienvenido a Super Admin')" :description="__('Como medida de seguridad ingrese su correo y contraseña para iniciar sesión')" />
    <form wire:submit="login" class="flex flex-col gap-6">
        <flux:input wire:model="email" :label="__('Email address')" type="email" required autofocus autocomplete="email" placeholder="email@example.com"/>
        <flux:input wire:model="password" :label="__('Password')" type="password" required autocomplete="current-password" :placeholder="__('Password')"/>
        <flux:checkbox wire:model="remember" :label="__('Remember me')" />
        <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
    </form>
</div>
