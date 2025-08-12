<x-filament-panels::page>
    <div class="space-y-6">
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-content p-6">
                <div class="mb-6">
                    <h1 class="fi-section-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                        Auditorías de Socios
                    </h1>
                    <p class="fi-section-header-description mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Registro completo de todas las actividades realizadas en los registros de socios.
                    </p>
                </div>
                
                <div class="fi-table-container rounded-xl bg-white dark:bg-gray-900">
                    {{ $this->table }}
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
