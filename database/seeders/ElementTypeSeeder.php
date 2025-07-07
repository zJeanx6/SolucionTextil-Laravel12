<?php

namespace Database\Seeders;

use App\Models\ElementType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElementTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            /*
            |------------------------------------------------------------------
            | G-01  “Metraje consumible”   →  ID 1100 - 1999
            |------------------------------------------------------------------
            |  nombre · código · imagen · rollos ancho y largo · color
            */
            ['id' => 1101, 'name' => 'Tela de algodón', 'company_nit'=>'12345678-1'],
            ['id' => 1102, 'name' => 'Tela de poliéster', 'company_nit'=>'12345678-1'],
            ['id' => 1103, 'name' => 'Tela poliéster-algodón', 'company_nit'=>'12345678-1'],
            ['id' => 1104, 'name' => 'Denim / mezclilla', 'company_nit'=>'12345678-1'],
            ['id' => 1105, 'name' => 'Lona / canvas industrial', 'company_nit'=>'12345678-1'],
            ['id' => 1106, 'name' => 'Forro (acetato o poliéster)', 'company_nit'=>'12345678-1'],
            ['id' => 1107, 'name' => 'Entretela fusible / cosida', 'company_nit'=>'12345678-1'],
            ['id' => 1108, 'name' => 'Elástico plano', 'company_nit'=>'12345678-1'],
            ['id' => 1109, 'name' => 'Cordón elástico redondo', 'company_nit'=>'12345678-1'],
            ['id' => 1110, 'name' => 'Cinta bies', 'company_nit'=>'12345678-2'],
            ['id' => 1111, 'name' => 'Cinta grosgrain', 'company_nit'=>'12345678-2'],
            ['id' => 1112, 'name' => 'Cinta reflectiva', 'company_nit'=>'12345678-2'],
            ['id' => 1113, 'name' => 'Cremallera de nylon', 'company_nit'=>'12345678-2'],
            ['id' => 1114, 'name' => 'Cremallera metálica', 'company_nit'=>'12345678-2'],
            ['id' => 1115, 'name' => 'Cierre invisible', 'company_nit'=>'12345678-2'],
            ['id' => 1116, 'name' => 'Velcro (gancho + rizo)', 'company_nit'=>'12345678-2'],
            ['id' => 1117, 'name' => 'Papel kraft para patronaje', 'company_nit'=>'12345678-2'],
            ['id' => 1118, 'name' => 'Papel de calco para transferencia', 'company_nit'=>'12345678-2'],

            /*
            |--------------------------------------------------------------
            | G-02  “Accesorio consumible”   →  ID 2100 - 2999
            |--------------------------------------------------------------
            |  nombre · código · stock · imagen · color
            */
            ['id' => 2101, 'name' => 'Hilo de poliéster en cono', 'company_nit'=>'12345678-1'],
            ['id' => 2102, 'name' => 'Hilo de algodón mercerizado', 'company_nit'=>'12345678-1'],
            ['id' => 2103, 'name' => 'Cono de overlock (poliéster texturizado)', 'company_nit'=>'12345678-1'],
            ['id' => 2104, 'name' => 'Botón plástico a presión', 'company_nit'=>'12345678-1'],
            ['id' => 2105, 'name' => 'Botón metálico (jeans)', 'company_nit'=>'12345678-1'],
            ['id' => 2106, 'name' => 'Broche de presión metálico', 'company_nit'=>'12345678-2'],
            ['id' => 2107, 'name' => 'Ojalete para cordones', 'company_nit'=>'12345678-2'],
            ['id' => 2108, 'name' => 'Remache / tachuela decorativa', 'company_nit'=>'12345678-2'],
            ['id' => 2109, 'name' => 'Etiqueta bordada de marca', 'company_nit'=>'12345678-2'],
            ['id' => 2110, 'name' => 'Etiqueta impresa de composición / talla', 'company_nit'=>'12345678-2'],
            ['id' => 2111, 'name' => 'Hang tag (etiqueta colgante)', 'company_nit'=>'12345678-2'],

            /*
            |--------------------------------------------------------------
            | G-03  “Herramienta No consumible (Prestado)”   →  ID 3100 - 3999
            |--------------------------------------------------------------
            |  nombre · código · stock · imagen
            */
            ['id' => 3101, 'name' => 'Tijeras de corte profesional', 'company_nit'=>'12345678-1'],
            ['id' => 3102, 'name' => 'Tijeras dentadas (zig-zag)', 'company_nit'=>'12345678-1'],
            ['id' => 3103, 'name' => 'Cortahilos de precisión', 'company_nit'=>'12345678-1'],
            ['id' => 3104, 'name' => 'Descosedor / abre-ojales', 'company_nit'=>'12345678-1'],
            ['id' => 3105, 'name' => 'Cúter rotatorio', 'company_nit'=>'12345678-1'],
            ['id' => 3106, 'name' => 'Tapete de corte autocurativo', 'company_nit'=>'12345678-2'],
            ['id' => 3107, 'name' => 'Regla curva francesa', 'company_nit'=>'12345678-2'],
            ['id' => 3108, 'name' => 'Cinta métrica de sastre', 'company_nit'=>'12345678-2'],
            ['id' => 3109, 'name' => 'Escuadra metálica 60 cm', 'company_nit'=>'12345678-2'],
            ['id' => 3110, 'name' => 'Jaboncillo / tiza de sastre', 'company_nit'=>'12345678-2'],
            ['id' => 3111, 'name' => 'Marcador borrable para tela', 'company_nit'=>'12345678-2'],
            
            /*
            |--------------------------------------------------------------
            | G-04  “Consumible mínimo”    →  ID 4100 - 4999
            |--------------------------------------------------------------
            |  nombre · código · stock · imagen 
            */
            ['id' => 4101, 'name' => 'Bobina vacía para canilla', 'company_nit'=>'12345678-1'],
            ['id' => 4102, 'name' => 'Aguja universal para máquina', 'company_nit'=>'12345678-1'],
            ['id' => 4103, 'name' => 'Aguja para jeans / denim', 'company_nit'=>'12345678-1'],
            ['id' => 4104, 'name' => 'Aguja de mano', 'company_nit'=>'12345678-1'],
            ['id' => 4105, 'name' => 'Alfiler de sastre', 'company_nit'=>'12345678-1'],
            ['id' => 4106, 'name' => 'Clip de sujeción para tela', 'company_nit'=>'12345678-2'],
            ['id' => 4107, 'name' => 'Dedal metálico / silicona', 'company_nit'=>'12345678-2'],
            ['id' => 4108, 'name' => 'Percha plástica para muestras', 'company_nit'=>'12345678-2'],
            ['id' => 4109, 'name' => 'Gancho “J” para rollos de tela', 'company_nit'=>'12345678-2'],
            ['id' => 4110, 'name' => 'Canasta plástica / caja organizadora', 'company_nit'=>'12345678-2'],
        ];

        /*
        |------------------------------------------------------------------
        | insert() es rápido,                     ──►  NO usa timestamps
        | pero si prefieres updateOrCreate()
        | cámbialo por un foreach.
        |------------------------------------------------------------------
        */
        ElementType::insert($types);
    }
}
