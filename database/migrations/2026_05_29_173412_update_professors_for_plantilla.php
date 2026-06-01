<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('professors', function (Blueprint $table) {
            $table->string('primer_nombre')->nullable()->after('name');
            $table->json('secciones')->nullable()->after('photo');
        });

        // Migrate existing formacion/experiencia into secciones
        DB::table('professors')->orderBy('id')->chunk(100, function ($professors) {
            foreach ($professors as $prof) {
                $secciones = [];

                $formacion = is_string($prof->formacion) ? json_decode($prof->formacion, true) : ($prof->formacion ?? []);
                if (is_array($formacion) && count($formacion) > 0) {
                    $elementos = [];
                    foreach ($formacion as $f) {
                        $parts = array_filter([$f['titulo'] ?? '', $f['institucion'] ?? '', $f['anio'] ?? '']);
                        if (!empty($parts)) {
                            $elementos[] = implode(' - ', $parts);
                        }
                    }
                    if (!empty($elementos)) {
                        $secciones[] = ['titulo' => 'Formación Profesional', 'elementos' => $elementos];
                    }
                }

                $experiencia = is_string($prof->experiencia) ? json_decode($prof->experiencia, true) : ($prof->experiencia ?? []);
                if (is_array($experiencia) && count($experiencia) > 0) {
                    $elementos = [];
                    foreach ($experiencia as $e) {
                        $parts = array_filter([$e['rol'] ?? '', $e['empresa'] ?? '', $e['periodo'] ?? '']);
                        if (!empty($parts)) {
                            $elementos[] = implode(' - ', $parts);
                        }
                    }
                    if (!empty($elementos)) {
                        $secciones[] = ['titulo' => 'Experiencia Profesional', 'elementos' => $elementos];
                    }
                }

                // Extract primer nombre from existing name
                $primerNombre = '';
                if (!empty($prof->name)) {
                    $names = explode(' ', trim($prof->name));
                    // Skip title prefixes
                    $skip = ['DR.', 'DR', 'MG.', 'MG', 'MAG.', 'MAG', 'LIC.', 'LIC', 'ING.', 'ING', 'BACH.', 'BACH', 'ABOG.', 'ABOG', 'CPA', 'CPC', 'CPCC.', 'CPCC', 'MTRO.', 'MTRO', 'PROF.', 'PROF', 'DOC.', 'DOC'];
                    foreach ($names as $n) {
                        if (!in_array(strtoupper($n), $skip) && !preg_match('/^[A-Z]\.$/', $n)) {
                            $primerNombre = $n;
                            break;
                        }
                    }
                }

                DB::table('professors')
                    ->where('id', $prof->id)
                    ->update([
                        'secciones' => json_encode($secciones),
                        'primer_nombre' => $primerNombre ?: explode(' ', trim($prof->name))[0] ?? '',
                    ]);
            }
        });

        Schema::table('professors', function (Blueprint $table) {
            $table->dropColumn(['formacion', 'experiencia']);
        });
    }

    public function down(): void
    {
        Schema::table('professors', function (Blueprint $table) {
            $table->json('formacion')->nullable()->after('photo');
            $table->json('experiencia')->nullable()->after('formacion');
        });

        // Reverse migration: convert secciones back to formacion/experiencia
        DB::table('professors')->orderBy('id')->chunk(100, function ($professors) {
            foreach ($professors as $prof) {
                $secciones = is_string($prof->secciones) ? json_decode($prof->secciones, true) : ($prof->secciones ?? []);
                $formacion = [];
                $experiencia = [];

                if (is_array($secciones)) {
                    foreach ($secciones as $sec) {
                        $titulo = strtolower($sec['titulo'] ?? '');
                        $elementos = $sec['elementos'] ?? [];
                        if (str_contains($titulo, 'formacion') || str_contains($titulo, 'formación')) {
                            foreach ($elementos as $elem) {
                                $formacion[] = ['titulo' => $elem, 'institucion' => '', 'anio' => ''];
                            }
                        } elseif (str_contains($titulo, 'experiencia')) {
                            foreach ($elementos as $elem) {
                                $experiencia[] = ['rol' => $elem, 'empresa' => '', 'periodo' => ''];
                            }
                        }
                    }
                }

                DB::table('professors')
                    ->where('id', $prof->id)
                    ->update([
                        'formacion' => json_encode($formacion),
                        'experiencia' => json_encode($experiencia),
                    ]);
            }
        });

        Schema::table('professors', function (Blueprint $table) {
            $table->dropColumn(['primer_nombre', 'secciones']);
        });
    }
};
