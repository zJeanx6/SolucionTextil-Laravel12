<div class=" mt-16 flex justify-center items-center gap-6 p-8 max-w-6xl mx-auto bg-gray-100 dark:bg-zinc-900 rounded-xl shadow-lg">
    <!-- Total Empresas -->
    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800">
        <div class="p-6 text-center">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Total Empresas</h2>
            <p class="text-3xl font-extrabold mt-2 text-gray-900 dark:text-white">{{ $totalCompanies }}</p>
        </div>
    </div>

    <!-- Total Licencias -->
    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800">
        <div class="p-6 text-center">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Total Licencias</h2>
            <p class="text-3xl font-extrabold mt-2 text-gray-900 dark:text-white">{{ $totalLicenses }}</p>
        </div>
    </div>

    <!-- Licencias Activas -->
    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800">
        <div class="p-6 text-center">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Licencias Activas</h2>
            <p class="text-3xl font-extrabold mt-2 text-green-600 dark:text-green-400">{{ $activeLicenses }}</p>
        </div>
    </div>

    <!-- Licencias Expiradas -->
    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800">
        <div class="p-6 text-center">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Licencias Expiradas</h2>
            <p class="text-3xl font-extrabold mt-2 text-red-600 dark:text-red-400">{{ $expiredLicenses }}</p>
        </div>
    </div>
</div>
