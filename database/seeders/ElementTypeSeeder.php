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
            | G-01  “Metraje”   →  ID 101 - 118
            |------------------------------------------------------------------
            |  nombre · código · stock · imagen · ancho · largo · color
            */
            ['id' => 101, 'name' => 'Tela de algodón'],
            ['id' => 102, 'name' => 'Tela de poliéster'],
            ['id' => 103, 'name' => 'Tela poliéster-algodón'],
            ['id' => 104, 'name' => 'Denim / mezclilla'],
            ['id' => 105, 'name' => 'Lona / canvas industrial'],
            ['id' => 106, 'name' => 'Forro (acetato o poliéster)'],
            ['id' => 107, 'name' => 'Entretela fusible / cosida'],
            ['id' => 108, 'name' => 'Elástico plano'],
            ['id' => 109, 'name' => 'Cordón elástico redondo'],
            ['id' => 110, 'name' => 'Cinta bies'],
            ['id' => 111, 'name' => 'Cinta grosgrain'],
            ['id' => 112, 'name' => 'Cinta reflectiva'],
            ['id' => 113, 'name' => 'Cremallera de nylon'],
            ['id' => 114, 'name' => 'Cremallera metálica'],
            ['id' => 115, 'name' => 'Cierre invisible'],
            ['id' => 116, 'name' => 'Velcro (gancho + rizo)'],
            ['id' => 117, 'name' => 'Papel kraft para patronaje'],
            ['id' => 118, 'name' => 'Papel de calco para transferencia'],

            /*
            |--------------------------------------------------------------
            | G-02  “Accesorio con color”   →  ID 201 - 211
            |--------------------------------------------------------------
            |  nombre · código · stock · imagen · color
            */
            ['id' => 201, 'name' => 'Hilo de poliéster en cono'],
            ['id' => 202, 'name' => 'Hilo de algodón mercerizado'],
            ['id' => 203, 'name' => 'Cono de overlock (poliéster texturizado)'],
            ['id' => 204, 'name' => 'Botón plástico a presión'],
            ['id' => 205, 'name' => 'Botón metálico (jeans)'],
            ['id' => 206, 'name' => 'Broche de presión metálico'],
            ['id' => 207, 'name' => 'Ojalete para cordones'],
            ['id' => 208, 'name' => 'Remache / tachuela decorativa'],
            ['id' => 209, 'name' => 'Etiqueta bordada de marca'],
            ['id' => 210, 'name' => 'Etiqueta impresa de composición / talla'],
            ['id' => 211, 'name' => 'Hang tag (etiqueta colgante)'],

            /*
            |--------------------------------------------------------------
            | G-03  “Herramienta”          →  ID 301 - 311
            |--------------------------------------------------------------
            |  nombre · código · stock · imagen
            */
            ['id' => 301, 'name' => 'Tijeras de corte profesional'],
            ['id' => 302, 'name' => 'Tijeras dentadas (zig-zag)'],
            ['id' => 303, 'name' => 'Cortahilos de precisión'],
            ['id' => 304, 'name' => 'Descosedor / abre-ojales'],
            ['id' => 305, 'name' => 'Cúter rotatorio'],
            ['id' => 306, 'name' => 'Tapete de corte autocurativo'],
            ['id' => 307, 'name' => 'Regla curva francesa'],
            ['id' => 308, 'name' => 'Cinta métrica de sastre'],
            ['id' => 309, 'name' => 'Escuadra metálica 60 cm'],
            ['id' => 310, 'name' => 'Jaboncillo / tiza de sastre'],
            ['id' => 311, 'name' => 'Marcador borrable para tela'],

            /*
            |--------------------------------------------------------------
            | G-04  “Consumible mínimo”    →  ID 401 - 410
            |--------------------------------------------------------------
            |  nombre · código · stock
            */
            ['id' => 401, 'name' => 'Bobina vacía para canilla'],
            ['id' => 402, 'name' => 'Aguja universal para máquina'],
            ['id' => 403, 'name' => 'Aguja para jeans / denim'],
            ['id' => 404, 'name' => 'Aguja de mano'],
            ['id' => 405, 'name' => 'Alfiler de sastre'],
            ['id' => 406, 'name' => 'Clip de sujeción para tela'],
            ['id' => 407, 'name' => 'Dedal metálico / silicona'],
            ['id' => 408, 'name' => 'Percha plástica para muestras'],
            ['id' => 409, 'name' => 'Gancho “J” para rollos de tela'],
            ['id' => 410, 'name' => 'Canasta plástica / caja organizadora'],
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
