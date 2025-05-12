<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        /*
        | Nota: los códigos hexadecimales se guardan SIN el “#”.
        | Se usan minúsculas o mayúsculas, En el Software ya son mostradas en MAYUS siempre.
        */
        $colors = [
            ['id'=>1 , 'code'=>'ffffff', 'name'=>'Blanco'],
            ['id'=>2 , 'code'=>'000000', 'name'=>'Negro'],
            ['id'=>3 , 'code'=>'808080', 'name'=>'Gris'],
            ['id'=>4 , 'code'=>'d3d3d3', 'name'=>'Gris claro'],
            ['id'=>5 , 'code'=>'505050', 'name'=>'Gris oscuro'],
            ['id'=>6 , 'code'=>'ff0000', 'name'=>'Rojo'],
            ['id'=>7 , 'code'=>'b22222', 'name'=>'Rojo ladrillo'],
            ['id'=>8 , 'code'=>'800020', 'name'=>'Granate / vino'],
            ['id'=>9 , 'code'=>'ff7f50', 'name'=>'Coral'],
            ['id'=>10, 'code'=>'fa8072', 'name'=>'Salmón'],
            ['id'=>11, 'code'=>'ff00ff', 'name'=>'Fucsia'],
            ['id'=>12, 'code'=>'e4007c', 'name'=>'Magenta'],
            ['id'=>13, 'code'=>'ffc0cb', 'name'=>'Rosa pastel'],
            ['id'=>14, 'code'=>'ff1493', 'name'=>'Rosa fuerte'],
            ['id'=>15, 'code'=>'ff8c00', 'name'=>'Naranja'],
            ['id'=>16, 'code'=>'cc5500', 'name'=>'Naranja quemado'],
            ['id'=>17, 'code'=>'ffbf00', 'name'=>'Ámbar'],
            ['id'=>18, 'code'=>'d4af37', 'name'=>'Mostaza'],
            ['id'=>19, 'code'=>'ffff00', 'name'=>'Amarillo'],
            ['id'=>20, 'code'=>'f5f5dc', 'name'=>'Beige / crema'],
            ['id'=>21, 'code'=>'d2b48c', 'name'=>'Arena'],
            ['id'=>22, 'code'=>'8b4513', 'name'=>'Marrón'],
            ['id'=>23, 'code'=>'7b3f00', 'name'=>'Chocolate'],
            ['id'=>24, 'code'=>'e2725b', 'name'=>'Terracota'],
            ['id'=>25, 'code'=>'c8a165', 'name'=>'Ocre'],
            ['id'=>26, 'code'=>'556b2f', 'name'=>'Oliva'],
            ['id'=>27, 'code'=>'bfff00', 'name'=>'Verde lima'],
            ['id'=>28, 'code'=>'7fff00', 'name'=>'Chartreuse'],
            ['id'=>29, 'code'=>'93c572', 'name'=>'Verde pistacho'],
            ['id'=>30, 'code'=>'98ff98', 'name'=>'Verde menta'],
            ['id'=>31, 'code'=>'50c878', 'name'=>'Verde esmeralda'],
            ['id'=>32, 'code'=>'228b22', 'name'=>'Verde bosque'],
            ['id'=>33, 'code'=>'40e0d0', 'name'=>'Turquesa'],
            ['id'=>34, 'code'=>'7fffd4', 'name'=>'Aguamarina'],
            ['id'=>35, 'code'=>'00ffff', 'name'=>'Cyan'],
            ['id'=>36, 'code'=>'87ceeb', 'name'=>'Azul cielo'],
            ['id'=>37, 'code'=>'00bfff', 'name'=>'Azul eléctrico'],
            ['id'=>38, 'code'=>'0000ff', 'name'=>'Azul'],
            ['id'=>39, 'code'=>'000080', 'name'=>'Azul marino'],
            ['id'=>40, 'code'=>'4b0082', 'name'=>'Índigo'],
            ['id'=>41, 'code'=>'e6e6fa', 'name'=>'Lavanda'],
            ['id'=>42, 'code'=>'c8a2c8', 'name'=>'Lila'],
            ['id'=>43, 'code'=>'800080', 'name'=>'Púrpura'],
            ['id'=>44, 'code'=>'8e82fe', 'name'=>'Periwinkle'],
            ['id'=>45, 'code'=>'301934', 'name'=>'Morado oscuro'],
            ['id'=>46, 'code'=>'b87333', 'name'=>'Cobre'],
            ['id'=>47, 'code'=>'cd7f32', 'name'=>'Bronce'],
            ['id'=>48, 'code'=>'ffd700', 'name'=>'Dorado'],
            ['id'=>49, 'code'=>'c0c0c0', 'name'=>'Plateado'],
            ['id'=>50, 'code'=>'3a3a3a', 'name'=>'Plomo'],
            ['id'=>51, 'code'=>'36454f', 'name'=>'Carbón'],
            ['id'=>52, 'code'=>'fffff0', 'name'=>'Marfil'],
            ['id'=>53, 'code'=>'f0ead6', 'name'=>'Perla'],
            ['id'=>54, 'code'=>'00a86b', 'name'=>'Jade'],
            ['id'=>55, 'code'=>'ffc87c', 'name'=>'Topacio'],
            ['id'=>56, 'code'=>'e0115f', 'name'=>'Rubí'],
            ['id'=>57, 'code'=>'0f52ba', 'name'=>'Zafiro'],
            ['id'=>58, 'code'=>'f7cac9', 'name'=>'Cuarzo rosa'],
            ['id'=>59, 'code'=>'a68b5b', 'name'=>'Arena oscura'],
            ['id'=>60, 'code'=>'c3b091', 'name'=>'Caqui'],
        ];

        Color::insert($colors);
    }
}