<?php

namespace App\Imports;

use App\Models\team;
use App\Models\team_details_title;
use App\Models\team_datails_data;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');

class TeamsImport implements ToCollection, WithHeadingRow
{
    private $game_id = "";

    public function __construct($game_id){
        $this->game_id = $game_id;
    }

    public function collection(collection $rows){
        $details_id = array();
        $n = 0;
        print_r($rows);
        
        foreach ($rows as $row) {
            $serail_num = 0;
            $report_num = 0;
            $name = "";
            $team = team::create([
                'game_id' => $this->game_id,
                'serial_num' => $row['隊伍編號'],
                'report_num' => $row['報告順序'],
                'name' => $row['隊伍名稱']
            ]);
            $row_n = 0;
            foreach ($row as $key => $value) {
                if($n == 0){
                    if($key != '隊伍編號' && $key != '隊伍名稱' && $key != '報告順序'){
                        $details_title = team_details_title::create([
                            'game_id' => $this->game_id,
                            'name' => $key,
                        ]);
                        array_push($details_id,$details_title->id);
                    }
                }
                if($key != '隊伍編號' && $key != '隊伍名稱' && $key != '報告順序'){
                    $value = empty($value) ? "" : $value;
                    $team->team_details_datas()->create([
                        'content' => $value,
                        'team_details_title_id' => $details_id[$row_n]
                    ]);
                    $row_n+=1;
                }
            }
            $n+=1;
            
        }
    }

    public function getCsvSettings(): array
    {
        # Define your custom import settings for only this class
        return [
            'input_encoding' => 'UTF-8',
            'delimiter' => ";"
        ];
    }

    // public function model(array $row)
    // {
    //     return new team([
    //         'game_id' => $this->game_id,
    //         'serial_num' => $row['serial_num'],
    //         'report_num' => $row['report_num'],
    //         'name' => $row['name']
    //     ]);
    // }
}
