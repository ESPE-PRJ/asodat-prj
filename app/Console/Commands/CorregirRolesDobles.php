<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CorregirRolesDobles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:corregir-roles-dobles {--dry-run : Solo mostrar qué cambios se harían sin ejecutarlos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corrige roles de usuarios administrativos para que también tengan el rol de socio';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->info('🔍 MODO DRY-RUN: Solo se mostrarán los cambios sin ejecutarlos');
        }

        $this->info('🔧 Verificando usuarios con roles administrativos...');

        // Buscar usuarios que tienen roles administrativos pero no el rol de socio
        $rolesAdministrativos = ['secretaria', 'tesorero', 'presidente'];
        $usuariosCorregidos = 0;

        foreach ($rolesAdministrativos as $rolAdmin) {
            $this->info("\n📋 Verificando usuarios con rol: {$rolAdmin}");

            $usuarios = User::whereHas('roles', function ($query) use ($rolAdmin) {
                $query->where('name', $rolAdmin);
            })->get();

            foreach ($usuarios as $usuario) {
                $rolesActuales = $usuario->getRoleNames()->toArray();
                $tieneRolSocio = $usuario->hasRole('socio');

                $this->info("👤 Usuario: {$usuario->name} ({$usuario->email})");
                $this->info("   Roles actuales: " . implode(', ', $rolesActuales));

                if (!$tieneRolSocio) {
                    $this->warn("   ⚠️  FALTA rol 'socio'");

                    if (!$dryRun) {
                        // Agregar el rol de socio sin quitar los existentes
                        $usuario->assignRole('socio');
                        $this->info("   ✅ Rol 'socio' agregado");
                        $usuariosCorregidos++;
                    } else {
                        $this->info("   🔄 Se agregaría rol 'socio'");
                        $usuariosCorregidos++;
                    }
                } else {
                    $this->info("   ✅ Ya tiene rol 'socio'");
                }
            }
        }

        if ($usuariosCorregidos > 0) {
            if ($dryRun) {
                $this->info("\n🎯 Se corregirían {$usuariosCorregidos} usuarios");
                $this->info("💡 Ejecuta el comando sin --dry-run para aplicar los cambios");
            } else {
                $this->info("\n🎉 {$usuariosCorregidos} usuarios corregidos exitosamente");
            }
        } else {
            $this->info("\n✅ No se encontraron usuarios que requieran corrección");
        }

        return 0;
    }
}
