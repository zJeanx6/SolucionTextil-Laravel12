<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('products')->insert([
            // Camisas
            ['code'=>100000001,'name'=>'Camisa blanca formal','stock'=>50,'image'=>null,'color_id'=>1,'size_id'=>3,'product_type_id'=>1, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000002,'name'=>'Camisa azul claro','stock'=>40,'image'=>null,'color_id'=>36,'size_id'=>4,'product_type_id'=>1, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000003,'name'=>'Camisa negra slim','stock'=>30,'image'=>null,'color_id'=>2,'size_id'=>2,'product_type_id'=>1, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000004,'name'=>'Camisa roja casual','stock'=>20,'image'=>null,'color_id'=>6,'size_id'=>5,'product_type_id'=>1, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000005,'name'=>'Camisa gris manga corta','stock'=>25,'image'=>null,'color_id'=>3,'size_id'=>3,'product_type_id'=>1, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            // Camisetas
            ['code'=>100000006,'name'=>'Camiseta básica blanca','stock'=>60,'image'=>null,'color_id'=>1,'size_id'=>4,'product_type_id'=>2, 'company_nit'=>'12345678-1',  'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000007,'name'=>'Camiseta negra oversize','stock'=>38,'image'=>null,'color_id'=>2,'size_id'=>5,'product_type_id'=>2, 'company_nit'=>'12345678-1',  'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000008,'name'=>'Camiseta azul','stock'=>42,'image'=>null,'color_id'=>38,'size_id'=>2,'product_type_id'=>2, 'company_nit'=>'12345678-2',  'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000009,'name'=>'Camiseta roja cuello V','stock'=>33,'image'=>null,'color_id'=>6,'size_id'=>3,'product_type_id'=>2, 'company_nit'=>'12345678-1',  'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000010,'name'=>'Camiseta gris deportiva','stock'=>47,'image'=>null,'color_id'=>3,'size_id'=>6,'product_type_id'=>2,'company_nit'=>'12345678-1',  'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            // Pantalones
            ['code'=>100000011,'name'=>'Pantalón jean azul','stock'=>55,'image'=>null,'color_id'=>38,'size_id'=>4,'product_type_id'=>3, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000012,'name'=>'Pantalón de vestir negro','stock'=>22,'image'=>null,'color_id'=>2,'size_id'=>5,'product_type_id'=>3, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000013,'name'=>'Pantalón beige','stock'=>35,'image'=>null,'color_id'=>20,'size_id'=>3,'product_type_id'=>3, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000014,'name'=>'Pantalón deportivo gris','stock'=>31,'image'=>null,'color_id'=>3,'size_id'=>6,'product_type_id'=>3, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000015,'name'=>'Pantalón verde oliva','stock'=>16,'image'=>null,'color_id'=>26,'size_id'=>2,'product_type_id'=>3, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            // Faldas
            ['code'=>100000016,'name'=>'Falda corta roja','stock'=>20,'image'=>null,'color_id'=>6,'size_id'=>2,'product_type_id'=>4, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000017,'name'=>'Falda larga negra','stock'=>24,'image'=>null,'color_id'=>2,'size_id'=>4,'product_type_id'=>4, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000018,'name'=>'Falda azul','stock'=>22,'image'=>null,'color_id'=>38,'size_id'=>3,'product_type_id'=>4, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000019,'name'=>'Falda mostaza','stock'=>19,'image'=>null,'color_id'=>18,'size_id'=>5,'product_type_id'=>4, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000020,'name'=>'Falda blanca plisada','stock'=>18,'image'=>null,'color_id'=>1,'size_id'=>6,'product_type_id'=>4, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            // Vestidos
            ['code'=>100000021,'name'=>'Vestido azul cielo','stock'=>13,'image'=>null,'color_id'=>36,'size_id'=>5,'product_type_id'=>5, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000022,'name'=>'Vestido negro elegante','stock'=>10,'image'=>null,'color_id'=>2,'size_id'=>3,'product_type_id'=>5, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000023,'name'=>'Vestido rojo fiesta','stock'=>15,'image'=>null,'color_id'=>6,'size_id'=>4,'product_type_id'=>5, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000024,'name'=>'Vestido floral','stock'=>17,'image'=>null,'color_id'=>13,'size_id'=>2,'product_type_id'=>5, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000025,'name'=>'Vestido verde menta','stock'=>12,'image'=>null,'color_id'=>30,'size_id'=>6,'product_type_id'=>5, 'company_nit'=>'12345678-1', 'created_at'=>$now,'updated_at'=>$now],
            // Shorts
            ['code'=>100000026,'name'=>'Short azul marino','stock'=>19,'image'=>null,'color_id'=>39,'size_id'=>3,'product_type_id'=>6, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000027,'name'=>'Short blanco','stock'=>17,'image'=>null,'color_id'=>1,'size_id'=>2,'product_type_id'=>6, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000028,'name'=>'Short negro deportivo','stock'=>25,'image'=>null,'color_id'=>2,'size_id'=>4,'product_type_id'=>6, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000029,'name'=>'Short rojo coral','stock'=>11,'image'=>null,'color_id'=>9,'size_id'=>5,'product_type_id'=>6, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000030,'name'=>'Short gris claro','stock'=>10,'image'=>null,'color_id'=>4,'size_id'=>6,'product_type_id'=>6, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            // Chaquetas
            ['code'=>100000031,'name'=>'Chaqueta jean','stock'=>28,'image'=>null,'color_id'=>38,'size_id'=>4,'product_type_id'=>7, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000032,'name'=>'Chaqueta negra','stock'=>24,'image'=>null,'color_id'=>2,'size_id'=>5,'product_type_id'=>7, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000033,'name'=>'Chaqueta azul marino','stock'=>22,'image'=>null,'color_id'=>39,'size_id'=>6,'product_type_id'=>7, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000034,'name'=>'Chaqueta beige','stock'=>14,'image'=>null,'color_id'=>20,'size_id'=>3,'product_type_id'=>7, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000035,'name'=>'Chaqueta gris oscuro','stock'=>15,'image'=>null,'color_id'=>5,'size_id'=>2,'product_type_id'=>7, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            // Sudaderas
            ['code'=>100000036,'name'=>'Sudadera gris','stock'=>29,'image'=>null,'color_id'=>3,'size_id'=>4,'product_type_id'=>8, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000037,'name'=>'Sudadera azul eléctrico','stock'=>31,'image'=>null,'color_id'=>37,'size_id'=>5,'product_type_id'=>8, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000038,'name'=>'Sudadera negra','stock'=>27,'image'=>null,'color_id'=>2,'size_id'=>6,'product_type_id'=>8, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000039,'name'=>'Sudadera roja','stock'=>24,'image'=>null,'color_id'=>6,'size_id'=>3,'product_type_id'=>8, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000040,'name'=>'Sudadera verde lima','stock'=>15,'image'=>null,'color_id'=>27,'size_id'=>2,'product_type_id'=>8, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            // Blusas
            ['code'=>100000041,'name'=>'Blusa blanca','stock'=>22,'image'=>null,'color_id'=>1,'size_id'=>3,'product_type_id'=>9, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000042,'name'=>'Blusa azul cielo','stock'=>19,'image'=>null,'color_id'=>36,'size_id'=>4,'product_type_id'=>9, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000043,'name'=>'Blusa rosa pastel','stock'=>25,'image'=>null,'color_id'=>13,'size_id'=>2,'product_type_id'=>9, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000044,'name'=>'Blusa negra','stock'=>16,'image'=>null,'color_id'=>2,'size_id'=>5,'product_type_id'=>9, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000045,'name'=>'Blusa lila','stock'=>14,'image'=>null,'color_id'=>42,'size_id'=>6,'product_type_id'=>9, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            // Sacos
            ['code'=>100000046,'name'=>'Saco gris','stock'=>10,'image'=>null,'color_id'=>3,'size_id'=>2,'product_type_id'=>10, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000047,'name'=>'Saco negro','stock'=>12,'image'=>null,'color_id'=>2,'size_id'=>3,'product_type_id'=>10, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000048,'name'=>'Saco azul marino','stock'=>9,'image'=>null,'color_id'=>39,'size_id'=>4,'product_type_id'=>10, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000049,'name'=>'Saco rojo','stock'=>8,'image'=>null,'color_id'=>6,'size_id'=>5,'product_type_id'=>10, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>100000050,'name'=>'Saco blanco','stock'=>7,'image'=>null,'color_id'=>1,'size_id'=>6,'product_type_id'=>10, 'company_nit'=>'12345678-2', 'created_at'=>$now,'updated_at'=>$now],
        ]);
    }
}