<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CupSeeder extends Seeder
{
    public function run()
    {
        $cups = [
            ['code' => '898002', 'description' => 'Estudio anatomopatológico básico en líquido corporal o secreción'],
            ['code' => '898003', 'description' => 'Estudio anatomopatológico básico en citología por aspiración con aguja fina (Bacaf) de cualquier tejido u órgano'],
            ['code' => '898004', 'description' => 'Estudio anatomopatológico básico en aspirado de médula ósea (mielograma)'],
            ['code' => '898008', 'description' => 'Estudio anatomopatológico en aspirado de médula ósea (mielograma) por tinción de histoquímica (específico)'],
            ['code' => '898014', 'description' => 'Estudio anatomopatológico en citología de líquido corporal o secreción por inmunofluorescencia'],
            ['code' => '898015', 'description' => 'Estudio anatomopatológico básico en citología cervicovaginal manual'],
            ['code' => '898016', 'description' => 'Estudio anatomopatológico básico en citología cervicovaginal semiautomatizado o automatizado'],
            ['code' => '898017', 'description' => 'Estudio anatomopatológico en citología por tinción de histoquímica (específico)'],
            ['code' => '898018', 'description' => 'Estudio anatomopatológico en citología o mielograma por inmunohistoquímica (marcador específico)'],
            ['code' => '898019', 'description' => 'Estudio anatomopatológico básico en citología de otro espécimen por método manual'],
            ['code' => '898020', 'description' => 'Estudio anatomopatológico básico en citología de otro espécimen por método semiautomatizado o automatizado'],
            ['code' => '898030', 'description' => 'Estudio de biología molecular en citología'],
            ['code' => '898101', 'description' => 'Estudio de coloración básica en biopsia'],
            ['code' => '898112', 'description' => 'Estudio de oncogenes en biopsia'],
            ['code' => '898201', 'description' => 'Estudio de coloración básica en espécimen de reconocimiento'],
            ['code' => '898221', 'description' => 'Estudio de coloración básica en espécimen con múltiple muestreo'],
            ['code' => '898241', 'description' => 'Estudio de coloración básica en espécimen con resección de márgenes'],
            ['code' => '898261', 'description' => 'Estudio de coloración básica en espécimen con mapeo'],
            ['code' => '898301', 'description' => 'Autopsia (necropsia) completa'],
            ['code' => '898302', 'description' => 'Autopsia (necropsia) parcial (viscerotomía)'],
            ['code' => '898303', 'description' => 'Estudios anatomopatológicos post mortem de órganos o tejidos'],
            ['code' => '898304', 'description' => 'Estudios anatomopatológicos post mortem de feto y placenta'],
            ['code' => '898801', 'description' => 'Estudio por congelación'],
            ['code' => '898802', 'description' => 'Estudio anatomopatológico molecular (específico)'],
            ['code' => '898803', 'description' => 'Estudio anatomopatológico de inmunomarcación / citometría de flujo (específico)'],
            ['code' => '898804', 'description' => 'Estudio anatomopatológico de ultraestructura o microscopía electrónica (específico)'],
            ['code' => '898805', 'description' => 'Verificación integral sin preparación de material de rutina'],
            ['code' => '898806', 'description' => 'Verificación integral con preparación de material de rutina'],
            ['code' => '898807', 'description' => 'Estudio anatomopatológico de marcación inmunohistoquímica básica (específico)'],
            ['code' => '898808', 'description' => 'Estudio anatomopatológico en biopsia por tinción histoquímica (específico)'],
            ['code' => '898809', 'description' => 'Estudio anatomopatológico en biopsia por inmunofluorescencia (específico)'],
            ['code' => '898810', 'description' => 'Estudio macroscópico de material biológico o no biológico'],
            ['code' => '898811', 'description' => 'Estudio anatomopatológico de hibridación "in situ" (específico)'],
            ['code' => '898812', 'description' => 'Estudio anatomopatológico de marcación inmunohistoquímica especial (específico)'],
        ];

        foreach ($cups as $cup) {
            DB::table('cups')->updateOrInsert(
                ['code' => $cup['code']],
                ['description' => $cup['description'], 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}
