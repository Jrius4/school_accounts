<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Calculator
{

    public $inputs;

    public function set_inputs($input)
    {
        $this->inputs = [...$input];
    }
    public function get_inputs()
    {
        $inputs = $this->inputs;
        $agg = [];
        $subpoints = [];

        foreach ($this->inputs as $key => $value) {
            if ($value >= 90 && $value <= 100) {
                array_push($agg, 'D1');
                array_push($subpoints, '1');
            } elseif ($value >= 80 && $value < 90) {
                array_push($agg, 'D2');
                array_push($subpoints, '2');
            } elseif ($value >= 75 && $value < 80) {
                array_push($agg, 'C3');
                array_push($subpoints, '3');
            } elseif ($value >= 70 && $value < 75) {
                array_push($agg, 'C4');
                array_push($subpoints, '4');
            } elseif ($value >= 65 && $value < 70) {
                array_push($agg, 'C5');
                array_push($subpoints, '5');
            } elseif ($value >= 60 && $value < 65) {
                array_push($agg, 'C6');
                array_push($subpoints, '6');
            } elseif ($value >= 55 && $value < 60) {
                array_push($agg, 'P7');
                array_push($subpoints, '7');
            } elseif ($value >= 50 && $value < 55) {
                array_push($agg, 'P8');
                array_push($subpoints, '8');
            } elseif ($value >= 45 && $value < 50) {
                array_push($agg, 'F9');
                array_push($subpoints, '9');
            } elseif ($value >= 0 && $value < 45) {
                array_push($agg, 'F9');
                array_push($subpoints, '9');
            }
        }
        $totalpoints = array_sum($subpoints);
        $count = count($subpoints);
        $grade = "";
        $point = 0;
        if ($count == 2) {
            if ($totalpoints <= 4) {
                if (!in_array(3, $subpoints)) {
                    $grade .= "A";
                    $point += 6;
                } elseif (in_array(3, $subpoints)) {
                    $grade .= "B";
                    $point += 5;
                }
            } elseif ($totalpoints > 4 && $totalpoints <= 7) {
                $grade .= "B";
                $point += 5;
            } elseif ($totalpoints > 7 && $totalpoints <= 9) {
                $grade .= "C";
                $point += 4;
            } elseif ($totalpoints > 9 && $totalpoints <= 11) {
                $grade .= "D";
                $point += 3;
            } elseif ($totalpoints > 11 && $totalpoints <= 13) {
                $grade .= "E";
                $point += 2;
            } elseif ($totalpoints > 13 && $totalpoints <= 16) {
                $grade .= "0";
                $point += 1;
            } elseif ($totalpoints > 16 && $totalpoints <= 18) {
                $grade .= "F";
                $point += 0;
            }
        } elseif ($count == 3) {
            if ($totalpoints <= 7) {
                if (!in_array(5, $subpoints)) {
                    $grade .= "A";
                    $point += 6;
                } elseif (in_array(5, $subpoints)) {
                    $grade .= "B";
                    $point += 5;
                }
            } elseif ($totalpoints > 7 && $totalpoints <= 10) {
                $grade .= "B";
                $point += 5;
            } elseif ($totalpoints > 10 && $totalpoints <= 13) {
                $grade .= "C";
                $point += 4;
            } elseif ($totalpoints > 13 && $totalpoints <= 16) {
                $grade .= "D";
                $point += 3;
            } elseif ($totalpoints > 16 && $totalpoints <= 19) {
                $grade .= "E";
                $point += 2;
            } elseif ($totalpoints > 19 && $totalpoints <= 24) {
                $grade .= "0";
                $point += 1;
            } elseif ($totalpoints > 24 && $totalpoints <= 27) {
                $grade .= "F";
                $point += 0;
            }
        }
        return compact('inputs', 'agg', 'subpoints', 'grade', 'point');
    }
}
