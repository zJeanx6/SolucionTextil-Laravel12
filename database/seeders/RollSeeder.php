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
            ['code'=>101011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10101, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10101, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10101, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10101, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>101015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10101, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10201
            ['code'=>102016,'broad'=>3.0,'long'=>100.00,'element_code'=>10201, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102017,'broad'=>3.0,'long'=>100.00,'element_code'=>10201, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102018,'broad'=>3.0,'long'=>100.00,'element_code'=>10201, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102019,'broad'=>3.0,'long'=>100.00,'element_code'=>10201, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>102020,'broad'=>3.0,'long'=>100.00,'element_code'=>10201, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10301
            ['code'=>103011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10301, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10301, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10301, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10301, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>103015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10301, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10401
            ['code'=>104016,'broad'=>3.0,'long'=>100.00,'element_code'=>10401, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104017,'broad'=>3.0,'long'=>100.00,'element_code'=>10401, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104018,'broad'=>3.0,'long'=>100.00,'element_code'=>10401, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104019,'broad'=>3.0,'long'=>100.00,'element_code'=>10401, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>104020,'broad'=>3.0,'long'=>100.00,'element_code'=>10401, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10501
            ['code'=>105011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10501, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10501, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10501, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10501, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>105015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10501, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10601
            ['code'=>106016,'broad'=>3.0,'long'=>100.00,'element_code'=>10601, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106017,'broad'=>3.0,'long'=>100.00,'element_code'=>10601, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106018,'broad'=>3.0,'long'=>100.00,'element_code'=>10601, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106019,'broad'=>3.0,'long'=>100.00,'element_code'=>10601, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>106020,'broad'=>3.0,'long'=>100.00,'element_code'=>10601, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10701
            ['code'=>107011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10701, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10701, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10701, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10701, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>107015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10701, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10801
            ['code'=>108016,'broad'=>3.0,'long'=>100.00,'element_code'=>10801, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108017,'broad'=>3.0,'long'=>100.00,'element_code'=>10801, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108018,'broad'=>3.0,'long'=>100.00,'element_code'=>10801, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108019,'broad'=>3.0,'long'=>100.00,'element_code'=>10801, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>108020,'broad'=>3.0,'long'=>100.00,'element_code'=>10801, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 10901
            ['code'=>109011,'broad'=>2.5,'long'=>10.00, 'element_code'=>10901, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109012,'broad'=>2.5,'long'=>10.00, 'element_code'=>10901, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109013,'broad'=>2.5,'long'=>10.00, 'element_code'=>10901, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109014,'broad'=>2.5,'long'=>10.00, 'element_code'=>10901, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>109015,'broad'=>2.5,'long'=>10.00, 'element_code'=>10901, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11001
            ['code'=>110016,'broad'=>3.0,'long'=>100.00,'element_code'=>11001, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110017,'broad'=>3.0,'long'=>100.00,'element_code'=>11001, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110018,'broad'=>3.0,'long'=>100.00,'element_code'=>11001, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110019,'broad'=>3.0,'long'=>100.00,'element_code'=>11001, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>110020,'broad'=>3.0,'long'=>100.00,'element_code'=>11001, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11101
            ['code'=>111011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11101, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11101, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11101, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11101, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>111015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11101, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11201
            ['code'=>112016,'broad'=>3.0,'long'=>100.00,'element_code'=>11201, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112017,'broad'=>3.0,'long'=>100.00,'element_code'=>11201, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112018,'broad'=>3.0,'long'=>100.00,'element_code'=>11201, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112019,'broad'=>3.0,'long'=>100.00,'element_code'=>11201, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>112020,'broad'=>3.0,'long'=>100.00,'element_code'=>11201, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11301
            ['code'=>113011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11301, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11301, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11301, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11301, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>113015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11301, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11401
            ['code'=>114016,'broad'=>3.0,'long'=>100.00,'element_code'=>11401, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114017,'broad'=>3.0,'long'=>100.00,'element_code'=>11401, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114018,'broad'=>3.0,'long'=>100.00,'element_code'=>11401, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114019,'broad'=>3.0,'long'=>100.00,'element_code'=>11401, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>114020,'broad'=>3.0,'long'=>100.00,'element_code'=>11401, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11501
            ['code'=>115011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11501, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11501, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11501, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11501, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>115015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11501, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11601
            ['code'=>116016,'broad'=>3.0,'long'=>100.00,'element_code'=>11601, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116017,'broad'=>3.0,'long'=>100.00,'element_code'=>11601, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116018,'broad'=>3.0,'long'=>100.00,'element_code'=>11601, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116019,'broad'=>3.0,'long'=>100.00,'element_code'=>11601, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>116020,'broad'=>3.0,'long'=>100.00,'element_code'=>11601, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11701
            ['code'=>117011,'broad'=>2.5,'long'=>10.00, 'element_code'=>11701, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117012,'broad'=>2.5,'long'=>10.00, 'element_code'=>11701, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117013,'broad'=>2.5,'long'=>10.00, 'element_code'=>11701, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117014,'broad'=>2.5,'long'=>10.00, 'element_code'=>11701, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>117015,'broad'=>2.5,'long'=>10.00, 'element_code'=>11701, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],

            // Rolls para element 11801
            ['code'=>118016,'broad'=>3.0,'long'=>100.00,'element_code'=>11801, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118017,'broad'=>3.0,'long'=>100.00,'element_code'=>11801, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118018,'broad'=>3.0,'long'=>100.00,'element_code'=>11801, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118019,'broad'=>3.0,'long'=>100.00,'element_code'=>11801, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
            ['code'=>118020,'broad'=>3.0,'long'=>100.00,'element_code'=>11801, 'state_id'=>1, 'created_at'=>$now,'updated_at'=>$now],
        ];

        Roll::insert($rolls);
    }
}
