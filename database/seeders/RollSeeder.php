<?php

namespace Database\Seeders;

use App\Models\Roll;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RollSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rolls = [
            // Rolls para element 10101
            ['code'=>101011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101016,'broad'=>3.0,'long'=>100.00,'element_code'=>10101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101017,'broad'=>3.0,'long'=>100.00,'element_code'=>10101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101018,'broad'=>3.0,'long'=>100.00,'element_code'=>10101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101019,'broad'=>3.0,'long'=>100.00,'element_code'=>10101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101020,'broad'=>3.0,'long'=>100.00,'element_code'=>10101,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10201
            ['code'=>102011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102016,'broad'=>3.0,'long'=>100.00,'element_code'=>10201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102017,'broad'=>3.0,'long'=>100.00,'element_code'=>10201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102018,'broad'=>3.0,'long'=>100.00,'element_code'=>10201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102019,'broad'=>3.0,'long'=>100.00,'element_code'=>10201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102020,'broad'=>3.0,'long'=>100.00,'element_code'=>10201,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10301
            ['code'=>103011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103016,'broad'=>3.0,'long'=>100.00,'element_code'=>10301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103017,'broad'=>3.0,'long'=>100.00,'element_code'=>10301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103018,'broad'=>3.0,'long'=>100.00,'element_code'=>10301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103019,'broad'=>3.0,'long'=>100.00,'element_code'=>10301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103020,'broad'=>3.0,'long'=>100.00,'element_code'=>10301,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10401
            ['code'=>104011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104016,'broad'=>3.0,'long'=>100.00,'element_code'=>10401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104017,'broad'=>3.0,'long'=>100.00,'element_code'=>10401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104018,'broad'=>3.0,'long'=>100.00,'element_code'=>10401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104019,'broad'=>3.0,'long'=>100.00,'element_code'=>10401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104020,'broad'=>3.0,'long'=>100.00,'element_code'=>10401,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10501
            ['code'=>105011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105016,'broad'=>3.0,'long'=>100.00,'element_code'=>10501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105017,'broad'=>3.0,'long'=>100.00,'element_code'=>10501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105018,'broad'=>3.0,'long'=>100.00,'element_code'=>10501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105019,'broad'=>3.0,'long'=>100.00,'element_code'=>10501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105020,'broad'=>3.0,'long'=>100.00,'element_code'=>10501,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10601
            ['code'=>106011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106016,'broad'=>3.0,'long'=>100.00,'element_code'=>10601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106017,'broad'=>3.0,'long'=>100.00,'element_code'=>10601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106018,'broad'=>3.0,'long'=>100.00,'element_code'=>10601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106019,'broad'=>3.0,'long'=>100.00,'element_code'=>10601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106020,'broad'=>3.0,'long'=>100.00,'element_code'=>10601,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10701
            ['code'=>107011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107016,'broad'=>3.0,'long'=>100.00,'element_code'=>10701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107017,'broad'=>3.0,'long'=>100.00,'element_code'=>10701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107018,'broad'=>3.0,'long'=>100.00,'element_code'=>10701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107019,'broad'=>3.0,'long'=>100.00,'element_code'=>10701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107020,'broad'=>3.0,'long'=>100.00,'element_code'=>10701,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10801
            ['code'=>108011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108016,'broad'=>3.0,'long'=>100.00,'element_code'=>10801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108017,'broad'=>3.0,'long'=>100.00,'element_code'=>10801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108018,'broad'=>3.0,'long'=>100.00,'element_code'=>10801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108019,'broad'=>3.0,'long'=>100.00,'element_code'=>10801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108020,'broad'=>3.0,'long'=>100.00,'element_code'=>10801,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10901
            ['code'=>109011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10901,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10901,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10901,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10901,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10901,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109016,'broad'=>3.0,'long'=>100.00,'element_code'=>10901,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109017,'broad'=>3.0,'long'=>100.00,'element_code'=>10901,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109018,'broad'=>3.0,'long'=>100.00,'element_code'=>10901,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109019,'broad'=>3.0,'long'=>100.00,'element_code'=>10901,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109020,'broad'=>3.0,'long'=>100.00,'element_code'=>10901,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11001
            ['code'=>110011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11001,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11001,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11001,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11001,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11001,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110016,'broad'=>3.0,'long'=>100.00,'element_code'=>11001,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110017,'broad'=>3.0,'long'=>100.00,'element_code'=>11001,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110018,'broad'=>3.0,'long'=>100.00,'element_code'=>11001,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110019,'broad'=>3.0,'long'=>100.00,'element_code'=>11001,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110020,'broad'=>3.0,'long'=>100.00,'element_code'=>11001,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11101
            ['code'=>111011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111016,'broad'=>3.0,'long'=>100.00,'element_code'=>11101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111017,'broad'=>3.0,'long'=>100.00,'element_code'=>11101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111018,'broad'=>3.0,'long'=>100.00,'element_code'=>11101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111019,'broad'=>3.0,'long'=>100.00,'element_code'=>11101,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111020,'broad'=>3.0,'long'=>100.00,'element_code'=>11101,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11201
            ['code'=>112011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112016,'broad'=>3.0,'long'=>100.00,'element_code'=>11201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112017,'broad'=>3.0,'long'=>100.00,'element_code'=>11201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112018,'broad'=>3.0,'long'=>100.00,'element_code'=>11201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112019,'broad'=>3.0,'long'=>100.00,'element_code'=>11201,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112020,'broad'=>3.0,'long'=>100.00,'element_code'=>11201,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11301
            ['code'=>113011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113016,'broad'=>3.0,'long'=>100.00,'element_code'=>11301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113017,'broad'=>3.0,'long'=>100.00,'element_code'=>11301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113018,'broad'=>3.0,'long'=>100.00,'element_code'=>11301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113019,'broad'=>3.0,'long'=>100.00,'element_code'=>11301,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113020,'broad'=>3.0,'long'=>100.00,'element_code'=>11301,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11401
            ['code'=>114011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114016,'broad'=>3.0,'long'=>100.00,'element_code'=>11401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114017,'broad'=>3.0,'long'=>100.00,'element_code'=>11401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114018,'broad'=>3.0,'long'=>100.00,'element_code'=>11401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114019,'broad'=>3.0,'long'=>100.00,'element_code'=>11401,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114020,'broad'=>3.0,'long'=>100.00,'element_code'=>11401,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11501
            ['code'=>115011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115016,'broad'=>3.0,'long'=>100.00,'element_code'=>11501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115017,'broad'=>3.0,'long'=>100.00,'element_code'=>11501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115018,'broad'=>3.0,'long'=>100.00,'element_code'=>11501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115019,'broad'=>3.0,'long'=>100.00,'element_code'=>11501,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115020,'broad'=>3.0,'long'=>100.00,'element_code'=>11501,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11601
            ['code'=>116011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116016,'broad'=>3.0,'long'=>100.00,'element_code'=>11601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116017,'broad'=>3.0,'long'=>100.00,'element_code'=>11601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116018,'broad'=>3.0,'long'=>100.00,'element_code'=>11601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116019,'broad'=>3.0,'long'=>100.00,'element_code'=>11601,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116020,'broad'=>3.0,'long'=>100.00,'element_code'=>11601,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11701
            ['code'=>117011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117016,'broad'=>3.0,'long'=>100.00,'element_code'=>11701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117017,'broad'=>3.0,'long'=>100.00,'element_code'=>11701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117018,'broad'=>3.0,'long'=>100.00,'element_code'=>11701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117019,'broad'=>3.0,'long'=>100.00,'element_code'=>11701,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117020,'broad'=>3.0,'long'=>100.00,'element_code'=>11701,'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11801
            ['code'=>118011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118016,'broad'=>3.0,'long'=>100.00,'element_code'=>11801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118017,'broad'=>3.0,'long'=>100.00,'element_code'=>11801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118018,'broad'=>3.0,'long'=>100.00,'element_code'=>11801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118019,'broad'=>3.0,'long'=>100.00,'element_code'=>11801,'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118020,'broad'=>3.0,'long'=>100.00,'element_code'=>11801,'created_at'=>$now,'updated_at'=>$now],
        ];

        Roll::insert($rolls);
    }
}
