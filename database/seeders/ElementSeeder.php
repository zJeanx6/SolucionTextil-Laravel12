<?php

namespace Database\Seeders;

use App\Models\Element;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElementSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $elements = [
            /* G-01 Metraje (IDs 1100-1999): stock a 0, medidas movidas a rolls */
            ['code'=>10201,'name'=>'Tela de poliester roja',    'stock'=>0,'image'=>null,'color_id'=>6, 'element_type_id'=>1102,  'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>10101,'name'=>'Tela de algodon blanca',    'stock'=>0,'image'=>null,'color_id'=>1, 'element_type_id'=>1101,  'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>10301,'name'=>'Tela mixta azul',           'stock'=>0,'image'=>null,'color_id'=>38,'element_type_id'=>1103,  'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>10401,'name'=>'Denim indigo',              'stock'=>0,'image'=>null,'color_id'=>40,'element_type_id'=>1104,  'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>10501,'name'=>'Lona marron',               'stock'=>0,'image'=>null,'color_id'=>22,'element_type_id'=>1105,  'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>10601,'name'=>'Forro beige',               'stock'=>0,'image'=>null,'color_id'=>20,'element_type_id'=>1106,  'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>10701,'name'=>'Entretela blanca',          'stock'=>0,'image'=>null,'color_id'=>1, 'element_type_id'=>1107,  'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>10801,'name'=>'Elastico plano negro',      'stock'=>0,'image'=>null,'color_id'=>2, 'element_type_id'=>1108,  'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>10901,'name'=>'Cordon elastico turquesa',  'stock'=>0,'image'=>null,'color_id'=>33,'element_type_id'=>1109,  'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>11001,'name'=>'Cinta bies negra',          'stock'=>0,'image'=>null,'color_id'=>2, 'element_type_id'=>1110,  'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>11101,'name'=>'Cinta grosgrain fucsia',    'stock'=>0,'image'=>null,'color_id'=>11,'element_type_id'=>1111,  'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>11201,'name'=>'Cinta reflectiva plateada', 'stock'=>0,'image'=>null,'color_id'=>49,'element_type_id'=>1112,  'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>11301,'name'=>'Cremallera nylon blanca',   'stock'=>0,'image'=>null,'color_id'=>1, 'element_type_id'=>1113,  'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>11401,'name'=>'Cremallera metalica plata', 'stock'=>0,'image'=>null,'color_id'=>49,'element_type_id'=>1114,  'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>11501,'name'=>'Cierre invisible blanco',   'stock'=>0,'image'=>null,'color_id'=>1, 'element_type_id'=>1115,  'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>11601,'name'=>'Velcro negro',              'stock'=>0,'image'=>null,'color_id'=>2, 'element_type_id'=>1116,  'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>11701,'name'=>'Papel kraft patronaje',     'stock'=>0,'image'=>null,'color_id'=>20,'element_type_id'=>1117,  'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>11801,'name'=>'Papel calco marfil',        'stock'=>0,'image'=>null,'color_id'=>52,'element_type_id'=>1118,  'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],

            /* G-02 Accesorio con color (IDs 2100-2999) – sólo color, stock original */
            ['code'=>20101,'name'=>'Hilo poliester blanco',      'stock'=>600, 'image'=>null,'color_id'=>1, 'element_type_id'=>2101, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>20201,'name'=>'Hilo algodon azul marino',   'stock'=>350, 'image'=>null,'color_id'=>39,'element_type_id'=>2102, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>20301,'name'=>'Cono overlock cyan',         'stock'=>400, 'image'=>null,'color_id'=>35,'element_type_id'=>2103, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>20401,'name'=>'Boton plastico negro',       'stock'=>1200,'image'=>null,'color_id'=>2, 'element_type_id'=>2104, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>20501,'name'=>'Boton metalico cobre',       'stock'=>800, 'image'=>null,'color_id'=>46,'element_type_id'=>2105, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>20601,'name'=>'Broche metalico plata',      'stock'=>900, 'image'=>null,'color_id'=>49,'element_type_id'=>2106, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>20701,'name'=>'Ojalete plata',              'stock'=>1500,'image'=>null,'color_id'=>49,'element_type_id'=>2107, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>20801,'name'=>'Remache cobre',              'stock'=>1100,'image'=>null,'color_id'=>46,'element_type_id'=>2108, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>20901,'name'=>'Etiqueta bordada marron',    'stock'=>2000,'image'=>null,'color_id'=>22,'element_type_id'=>2109, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>21001,'name'=>'Etiqueta impresa blanca',    'stock'=>2500,'image'=>null,'color_id'=>1, 'element_type_id'=>2110, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>21101,'name'=>'Hang tag kraft',             'stock'=>1800,'image'=>null,'color_id'=>20,'element_type_id'=>2111, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],

            /* G-03 Herramienta (IDs 3100-3999) – sin medidas ni color */
            ['code'=>30101,'name'=>'Tijeras corte',             'stock'=>20,  'image'=>null,'color_id'=>null,'element_type_id'=>3101, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>30201,'name'=>'Tijeras zigzag',            'stock'=>25,  'image'=>null,'color_id'=>null,'element_type_id'=>3102, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>30301,'name'=>'Cortahilos precision',      'stock'=>60,  'image'=>null,'color_id'=>null,'element_type_id'=>3103, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>30401,'name'=>'Descosedor ergonomico',     'stock'=>70,  'image'=>null,'color_id'=>null,'element_type_id'=>3104, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>30501,'name'=>'Cuter rotatorio',           'stock'=>25,  'image'=>null,'color_id'=>null,'element_type_id'=>3105, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>30601,'name'=>'Tapete autocurativo',       'stock'=>12,  'image'=>null,'color_id'=>null,'element_type_id'=>3106, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>30701,'name'=>'Regla curva francesa',      'stock'=>45,  'image'=>null,'color_id'=>null,'element_type_id'=>3107, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>30801,'name'=>'Cinta metrica',             'stock'=>120, 'image'=>null,'color_id'=>null,'element_type_id'=>3108, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>30901,'name'=>'Escuadra metalica',         'stock'=>30,  'image'=>null,'color_id'=>null,'element_type_id'=>3109, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>31001,'name'=>'Jaboncillo sastre',         'stock'=>300, 'image'=>null,'color_id'=>null,'element_type_id'=>3110, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>31101,'name'=>'Marcador borrable azul',    'stock'=>140, 'image'=>null,'color_id'=>null,'element_type_id'=>3111, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],

            /* G-04 Consumible minimo (IDs 4100-4999) – sin medidas ni color */
            ['code'=>40101,'name'=>'Bobina vacia plastica',     'stock'=>1200,'image'=>null,'color_id'=>null,'element_type_id'=>4101, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>40201,'name'=>'Aguja universal',           'stock'=>600, 'image'=>null,'color_id'=>null,'element_type_id'=>4102, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>40301,'name'=>'Aguja jeans',               'stock'=>500, 'image'=>null,'color_id'=>null,'element_type_id'=>4103, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>40401,'name'=>'Aguja de mano',             'stock'=>800, 'image'=>null,'color_id'=>null,'element_type_id'=>4104, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>40501,'name'=>'Alfileres',                 'stock'=>2000,'image'=>null,'color_id'=>null,'element_type_id'=>4105, 'company_nit'=>'12345678-1','created_at'=>$now,'updated_at'=>$now],
            ['code'=>40601,'name'=>'Clips sujecion',           'stock'=>350, 'image'=>null,'color_id'=>null,'element_type_id'=>4106, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>40701,'name'=>'Dedal metalico',           'stock'=>90,  'image'=>null,'color_id'=>null,'element_type_id'=>4107, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>40801,'name'=>'Percha plastica',           'stock'=>180, 'image'=>null,'color_id'=>null,'element_type_id'=>4108, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>40901,'name'=>'Gancho J rollos',           'stock'=>75,  'image'=>null,'color_id'=>null,'element_type_id'=>4109, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
            ['code'=>41001,'name'=>'Canasta plastica',          'stock'=>65,  'image'=>null,'color_id'=>null,'element_type_id'=>4110, 'company_nit'=>'12345678-2','created_at'=>$now,'updated_at'=>$now],
        ];

        Element::insert($elements);
    }
}
