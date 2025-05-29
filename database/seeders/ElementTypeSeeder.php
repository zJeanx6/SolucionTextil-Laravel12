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
            ['id' => 1101, 'name' => 'Tela de algodón'],
            ['id' => 1102, 'name' => 'Tela de poliéster'],
            ['id' => 1103, 'name' => 'Tela poliéster-algodón'],
            ['id' => 1104, 'name' => 'Denim / mezclilla'],
            ['id' => 1105, 'name' => 'Lona / canvas industrial'],
            ['id' => 1106, 'name' => 'Forro (acetato o poliéster)'],
            ['id' => 1107, 'name' => 'Entretela fusible / cosida'],
            ['id' => 1108, 'name' => 'Elástico plano'],
            ['id' => 1109, 'name' => 'Cordón elástico redondo'],
            ['id' => 1110, 'name' => 'Cinta bies'],
            ['id' => 1111, 'name' => 'Cinta grosgrain'],
            ['id' => 1112, 'name' => 'Cinta reflectiva'],
            ['id' => 1113, 'name' => 'Cremallera de nylon'],
            ['id' => 1114, 'name' => 'Cremallera metálica'],
            ['id' => 1115, 'name' => 'Cierre invisible'],
            ['id' => 1116, 'name' => 'Velcro (gancho + rizo)'],
            ['id' => 1117, 'name' => 'Papel kraft para patronaje'],
            ['id' => 1118, 'name' => 'Papel de calco para transferencia'],

            /*
            |--------------------------------------------------------------
            | G-02  “Accesorio consumible”   →  ID 2100 - 2999
            |--------------------------------------------------------------
            |  nombre · código · stock · imagen · color
            */
            ['id' => 2101, 'name' => 'Hilo de poliéster en cono'],
            ['id' => 2102, 'name' => 'Hilo de algodón mercerizado'],
            ['id' => 2103, 'name' => 'Cono de overlock (poliéster texturizado)'],
            ['id' => 2104, 'name' => 'Botón plástico a presión'],
            ['id' => 2105, 'name' => 'Botón metálico (jeans)'],
            ['id' => 2106, 'name' => 'Broche de presión metálico'],
            ['id' => 2107, 'name' => 'Ojalete para cordones'],
            ['id' => 2108, 'name' => 'Remache / tachuela decorativa'],
            ['id' => 2109, 'name' => 'Etiqueta bordada de marca'],
            ['id' => 2110, 'name' => 'Etiqueta impresa de composición / talla'],
            ['id' => 2111, 'name' => 'Hang tag (etiqueta colgante)'],

            /*
            |--------------------------------------------------------------
            | G-03  “Herramienta No consumible (Prestado)”   →  ID 3100 - 3999
            |--------------------------------------------------------------
            |  nombre · código · stock · imagen
            */
            ['id' => 3101, 'name' => 'Tijeras de corte profesional'],
            ['id' => 3102, 'name' => 'Tijeras dentadas (zig-zag)'],
            ['id' => 3103, 'name' => 'Cortahilos de precisión'],
            ['id' => 3104, 'name' => 'Descosedor / abre-ojales'],
            ['id' => 3105, 'name' => 'Cúter rotatorio'],
            ['id' => 3106, 'name' => 'Tapete de corte autocurativo'],
            ['id' => 3107, 'name' => 'Regla curva francesa'],
            ['id' => 3108, 'name' => 'Cinta métrica de sastre'],
            ['id' => 3109, 'name' => 'Escuadra metálica 60 cm'],
            ['id' => 3110, 'name' => 'Jaboncillo / tiza de sastre'],
            ['id' => 3111, 'name' => 'Marcador borrable para tela'],
            ['id' => 3112, 'name' => 'Canasta plástica / caja organizadora'],

            /*
            |--------------------------------------------------------------
            | G-04  “Consumible mínimo”    →  ID 4100 - 4999
            |--------------------------------------------------------------
            |  nombre · código · stock · imagen 
            */
            ['id' => 4101, 'name' => 'Bobina vacía para canilla'],
            ['id' => 4102, 'name' => 'Aguja universal para máquina'],
            ['id' => 4103, 'name' => 'Aguja para jeans / denim'],
            ['id' => 4104, 'name' => 'Aguja de mano'],
            ['id' => 4105, 'name' => 'Alfiler de sastre'],
            ['id' => 4106, 'name' => 'Clip de sujeción para tela'],
            ['id' => 4107, 'name' => 'Dedal metálico / silicona'],
            ['id' => 4108, 'name' => 'Percha plástica para muestras'],
            ['id' => 4109, 'name' => 'Gancho “J” para rollos de tela'],
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
