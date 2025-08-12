<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    Panel de Gestión - Presidente
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Card: Crear Nueva Noticia -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-700">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-heroicon-o-plus-circle class="h-8 w-8 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">Nueva Noticia</h4>
                                <p class="text-sm text-blue-700 dark:text-blue-300">Crear y publicar noticia</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="/sys/noticias/create" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">
                                Crear Noticia →
                            </a>
                        </div>
                    </div>

                    <!-- Card: Gestionar Noticias -->
                    <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-700">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-heroicon-o-newspaper class="h-8 w-8 text-green-600 dark:text-green-400" />
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-green-900 dark:text-green-100">Gestionar Noticias</h4>
                                <p class="text-sm text-green-700 dark:text-green-300">Ver y editar noticias existentes</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="/sys/noticias" class="text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-500">
                                Ver Noticias →
                            </a>
                        </div>
                    </div>

                    <!-- Card: Mi Perfil -->
                    <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg border border-purple-200 dark:border-purple-700">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-heroicon-o-user class="h-8 w-8 text-purple-600 dark:text-purple-400" />
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-purple-900 dark:text-purple-100">Mi Perfil</h4>
                                <p class="text-sm text-purple-700 dark:text-purple-300">Ver y editar información personal</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('filament.admin.pages.mi-perfil') }}" class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-500">
                                Ir a Mi Perfil →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-heroicon-o-information-circle class="h-5 w-5 text-gray-400" />
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200">
                        Resumen de Actividad
                    </h3>
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                            <div class="text-center p-3 bg-white dark:bg-gray-700 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                    {{ \App\Models\Noticia::count() }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    Total de Noticias
                                </div>
                            </div>
                            <div class="text-center p-3 bg-white dark:bg-gray-700 rounded-lg">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                    {{ \App\Models\Noticia::where('publicar_desde', '<=', now())->where(function($q) { $q->whereNull('publicar_hasta')->orWhere('publicar_hasta', '>=', now()); })->count() }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    Noticias Activas
                                </div>
                            </div>
                            <div class="text-center p-3 bg-white dark:bg-gray-700 rounded-lg">
                                <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                                    {{ \App\Models\Noticia::where('publicar_desde', '>', now())->count() }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    Noticias Programadas
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Rol -->
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-heroicon-o-star class="h-5 w-5 text-amber-400" />
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-amber-800 dark:text-amber-200">
                        Permisos de Presidente
                    </h3>
                    <div class="mt-2 text-sm text-amber-700 dark:text-amber-300">
                        <p>Como Presidente de ASODAT tienes acceso a:</p>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>Crear y gestionar noticias y comunicados</li>
                            <li>Programar publicaciones de noticias</li>
                            <li>Editar y eliminar noticias existentes</li>
                            <li>Acceso a tu perfil personal</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
