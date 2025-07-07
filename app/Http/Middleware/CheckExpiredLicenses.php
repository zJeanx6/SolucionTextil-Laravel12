<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\License;
use Carbon\Carbon;

class CheckExpiredLicenses
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar las licencias expiradas y actualizarlas
        $this->checkExpiredLicenses();

        return $next($request);
    }

    /**
     * Verifica las licencias expiradas y actualiza su estado.
     *
     * @return void
     */
    protected function checkExpiredLicenses()
    {
        // Obtiene todas las licencias cuya fecha de expiración ha pasado y cuyo estado es 1 (activo)
        $expiredLicenses = License::where('end_date', '<', Carbon::now())
            ->where('state_id', 1) // Solo las que aún no están expiradas
            ->get();

        // Recorre las licencias y cambia el estado a 2 (expirada)
        foreach ($expiredLicenses as $license) {
            $license->update(['state_id' => 2]); // 2 sería el estado de "expirada"
        }
    }
}
