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
            /* G-01 Metraje (IDs 101-118) – requiere medidas y color */
            ['code'=>10101,'name'=>'Tela de algodon blanca','stock'=>120,'image'=>null,'broad'=>1.5 ,'long'=>50 ,'color_id'=>1 ,'element_type_id'=>101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>10201,'name'=>'Tela de poliester roja','stock'=>80 ,'image'=>null,'broad'=>1.6 ,'long'=>60 ,'color_id'=>6 ,'element_type_id'=>102,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>10301,'name'=>'Tela mixta azul','stock'=>70 ,'image'=>null,'broad'=>1.5 ,'long'=>55 ,'color_id'=>38,'element_type_id'=>103,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>10401,'name'=>'Denim indigo','stock'=>40 ,'image'=>null,'broad'=>1.4 ,'long'=>70 ,'color_id'=>40,'element_type_id'=>104,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>10501,'name'=>'Lona marron','stock'=>35 ,'image'=>null,'broad'=>1.8 ,'long'=>40 ,'color_id'=>22,'element_type_id'=>105,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>10601,'name'=>'Forro beige','stock'=>90 ,'image'=>null,'broad'=>1.4 ,'long'=>90 ,'color_id'=>20,'element_type_id'=>106,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>10701,'name'=>'Entretela blanca','stock'=>150,'image'=>null,'broad'=>1.0 ,'long'=>100,'color_id'=>1 ,'element_type_id'=>107,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>10801,'name'=>'Elastico plano negro','stock'=>300,'image'=>null,'broad'=>0.04,'long'=>200,'color_id'=>2 ,'element_type_id'=>108,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>10901,'name'=>'Cordon elastico turquesa','stock'=>250,'image'=>null,'broad'=>0.006,'long'=>300,'color_id'=>33,'element_type_id'=>109,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>11001,'name'=>'Cinta bies negra','stock'=>400,'image'=>null,'broad'=>0.025,'long'=>200,'color_id'=>2 ,'element_type_id'=>110,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>11101,'name'=>'Cinta grosgrain fucsia','stock'=>350,'image'=>null,'broad'=>0.015,'long'=>250,'color_id'=>11,'element_type_id'=>111,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>11201,'name'=>'Cinta reflectiva plateada','stock'=>220,'image'=>null,'broad'=>0.05,'long'=>100,'color_id'=>49,'element_type_id'=>112,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>11301,'name'=>'Cremallera nylon blanca','stock'=>500,'image'=>null,'broad'=>null,'long'=>0.6,'color_id'=>1 ,'element_type_id'=>113,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>11401,'name'=>'Cremallera metalica plata','stock'=>450,'image'=>null,'broad'=>null,'long'=>0.2,'color_id'=>49,'element_type_id'=>114,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>11501,'name'=>'Cierre invisible blanco','stock'=>300,'image'=>null,'broad'=>null,'long'=>0.4,'color_id'=>1 ,'element_type_id'=>115,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>11601,'name'=>'Velcro negro','stock'=>200,'image'=>null,'broad'=>0.02,'long'=>100,'color_id'=>2 ,'element_type_id'=>116,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>11701,'name'=>'Papel kraft patronaje','stock'=>180,'image'=>null,'broad'=>1.2 ,'long'=>100,'color_id'=>20,'element_type_id'=>117,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>11801,'name'=>'Papel calco marfil','stock'=>160,'image'=>null,'broad'=>1.0 ,'long'=>80 ,'color_id'=>52,'element_type_id'=>118,'created_at'=>$now,'updated_at'=>$now],

            /* G-02 Accesorio con color (IDs 201-211) – solo color */
            ['code'=>20101,'name'=>'Hilo poliester blanco' ,'stock'=>600 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>1 ,'element_type_id'=>201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>20201,'name'=>'Hilo algodon azul marino','stock'=>350 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>39,'element_type_id'=>202,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>20301,'name'=>'Cono overlock cyan'     ,'stock'=>400 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>35,'element_type_id'=>203,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>20401,'name'=>'Boton plastico negro'   ,'stock'=>1200,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>2 ,'element_type_id'=>204,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>20501,'name'=>'Boton metalico cobre'   ,'stock'=>800 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>46,'element_type_id'=>205,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>20601,'name'=>'Broche metalico plata'  ,'stock'=>900 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>49,'element_type_id'=>206,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>20701,'name'=>'Ojalete plata'          ,'stock'=>1500,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>49,'element_type_id'=>207,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>20801,'name'=>'Remache cobre'          ,'stock'=>1100,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>46,'element_type_id'=>208,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>20901,'name'=>'Etiqueta bordada marron','stock'=>2000,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>22,'element_type_id'=>209,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>21001,'name'=>'Etiqueta impresa blanca','stock'=>2500,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>1 ,'element_type_id'=>210,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>21101,'name'=>'Hang tag kraft'         ,'stock'=>1800,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>20,'element_type_id'=>211,'created_at'=>$now,'updated_at'=>$now],

            /* G-03 Herramienta (IDs 301-311) – sin medidas ni color */
            ['code'=>30101,'name'=>'Tijeras corte'          ,'stock'=>20 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>30201,'name'=>'Tijeras zigzag'         ,'stock'=>25 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>302,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>30301,'name'=>'Cortahilos precision'   ,'stock'=>60 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>303,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>30401,'name'=>'Descosedor ergonomico'  ,'stock'=>70 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>304,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>30501,'name'=>'Cuter rotatorio'        ,'stock'=>25 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>305,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>30601,'name'=>'Tapete autocurativo'    ,'stock'=>12 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>306,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>30701,'name'=>'Regla curva francesa'   ,'stock'=>45 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>307,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>30801,'name'=>'Cinta metrica'          ,'stock'=>120,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>308,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>30901,'name'=>'Escuadra metalica'      ,'stock'=>30 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>309,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>31001,'name'=>'Jaboncillo sastre'      ,'stock'=>300,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>310,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>31101,'name'=>'Marcador borrable azul' ,'stock'=>140,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>311,'created_at'=>$now,'updated_at'=>$now],

            /* G-04 Consumible minimo (IDs 401-410) – sin medidas ni color */
            ['code'=>40101,'name'=>'Bobina vacia plastica'  ,'stock'=>1200,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>40201,'name'=>'Aguja universal'       ,'stock'=>600 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>402,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>40301,'name'=>'Aguja jeans'           ,'stock'=>500 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>403,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>40401,'name'=>'Aguja de mano'         ,'stock'=>800 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>404,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>40501,'name'=>'Alfileres'             ,'stock'=>2000,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>405,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>40601,'name'=>'Clips sujecion'        ,'stock'=>350 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>406,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>40701,'name'=>'Dedal metalico'        ,'stock'=>90  ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>407,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>40801,'name'=>'Percha plastica'       ,'stock'=>180 ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>408,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>40901,'name'=>'Gancho J rollos'       ,'stock'=>75  ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>409,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>41001,'name'=>'Canasta plastica'      ,'stock'=>65  ,'image'=>null,'broad'=>null,'long'=>null,'color_id'=>null,'element_type_id'=>410,'created_at'=>$now,'updated_at'=>$now],
        ];

        Element::insert($elements);
    }
}