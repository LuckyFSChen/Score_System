<?php

namespace App\Imports;

use App\Models\team;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\HeadingRowImport;


class TeamsImport implements ToModel, WithHeadingRow
{
    private $game_id = "";

    public function __construct($game_id){
        $this->game_id = $game_id;
    }

    public function model(array $row)
    {
        return new team([
            'game_id' => $this->game_id,
            'serial_num' => $row['serial_num'],
            'report_num' => $row['report_num'],
            'name' => $row['name']
        ]);
    }
}
