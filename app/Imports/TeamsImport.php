<?php

namespace App\Imports;

use App\Models\team;
use App\Models\team_details_title;
use App\Models\team_datails_data;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeamsImport implements ToCollection, WithHeadingRow
{
    private $game_id = "";

    public function __construct($game_id){
        $this->game_id = $game_id;
    }

    public function collection(collection $rows){
        $details_id = array();
        $n = 0;
        foreach ($rows as $row) {
            $serail_num = 0;
            $report_num = 0;
            $name = "";
            $team = team::create([
                'game_id' => $this->game_id,
                'serial_num' => $row['serial_num'],
                'report_num' => $row['report_num'],
                'name' => $row['name']
            ]);
            $row_n = 0;
            foreach ($row as $key => $value) {
                if($n == 0){
                    if($key != 'serial_num' && $key != 'name' && $key != 'report_num'){
                        $details_title = team_details_title::create([
                            'game_id' => $this->game_id,
                            'name' => $key,
                        ]);
                        array_push($details_id,$details_title->id);
                    }
                }
                if($key != 'serial_num' && $key != 'name' && $key != 'report_num'){
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
