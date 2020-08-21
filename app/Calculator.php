<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Calculator
{

    public $inputs;
    public $level;
    public $termID;
    public $setID;

    public function set_inputs($input, $level, $termID, $setID)
    {
        $this->inputs = [...$input];
        $this->level = $level;
        $this->termID = $termID;
        $this->setID = $setID;
    }
    public function get_inputs()
    {
        $inputs = $this->inputs;
        $level = $this->level;
        $termID = $this->termID;
        $setID = $this->setID;
        $agg = [];
        $subpapers = [];
        $botpapers = [];
        $motpapers = [];
        $eotpapers = [];
        $subpoints = [];
        $oAgg = "";
        $oSubpoints = "";
        $oAvg = "";
        $grade = "";
        $point = "";
        $subsidarypoint = "";

        $exmsets = new Exmset();
        if ($level == 'Advanced Level') {
            foreach ($this->inputs as $key => $value) {
                if ($this->setID == 1) array_push($botpapers, ['paper' => ($key + 1), 'score' => (($value * $exmsets->find(1)->set_percentage) / 100)]);
                if ($this->setID == 2) array_push($motpapers, ['paper' => ($key + 1), 'score' => (($value * $exmsets->find(2)->set_percentage) / 100)]);
                if ($this->setID == 3) array_push($eotpapers, ['paper' => ($key + 1), 'score' => (($value * $exmsets->find(3)->set_percentage) / 100)]);
                if ($value >= 90 && $value <= 100) {
                    array_push($agg, 'D1');
                    array_push($subpoints, '1');
                    array_push($subpapers, ['paper' => ($key + 1), 'score' => $value, 'grade' => 'D1', 'points' => 1]);
                } elseif ($value >= 80 && $value < 90) {
                    array_push($agg, 'D2');
                    array_push($subpoints, '2');
                    array_push($subpapers, ['paper' => ($key + 1), 'score' => $value, 'grade' => 'D2', 'points' => 2]);
                } elseif ($value >= 75 && $value < 80) {
                    array_push($agg, 'C3');
                    array_push($subpoints, '3');
                    array_push($subpapers, ['paper' => ($key + 1), 'score' => $value, 'grade' => 'C3', 'points' => 3]);
                } elseif ($value >= 70 && $value < 75) {
                    array_push($agg, 'C4');
                    array_push($subpoints, '4');
                    array_push($subpapers, ['paper' => ($key + 1), 'score' => $value, 'grade' => 'C4', 'points' => 4]);
                } elseif ($value >= 65 && $value < 70) {
                    array_push($agg, 'C5');
                    array_push($subpoints, '5');
                    array_push($subpapers, ['paper' => ($key + 1), 'score' => $value, 'grade' => 'C5', 'points' => 5]);
                } elseif ($value >= 60 && $value < 65) {
                    array_push($agg, 'C6');
                    array_push($subpoints, '6');
                    array_push($subpapers, ['paper' => ($key + 1), 'score' => $value, 'grade' => 'C6', 'points' => 6]);
                } elseif ($value >= 55 && $value < 60) {
                    array_push($agg, 'P7');
                    array_push($subpoints, '7');
                    array_push($subpapers, ['paper' => ($key + 1), 'score' => $value, 'grade' => 'P7', 'points' => 7]);
                } elseif ($value >= 50 && $value < 55) {
                    array_push($agg, 'P8');
                    array_push($subpoints, '8');
                    array_push($subpapers, ['paper' => ($key + 1), 'score' => $value, 'grade' => 'P8', 'points' => 8]);
                } elseif ($value >= 45 && $value < 50) {
                    array_push($agg, 'F9');
                    array_push($subpoints, '9');
                    array_push($subpapers, ['paper' => ($key + 1), 'score' => $value, 'grade' => 'F9', 'points' => 9]);
                } elseif ($value >= 0 && $value < 45) {
                    array_push($agg, 'F9');
                    array_push($subpoints, '9');
                    array_push($subpapers, ['paper' => ($key + 1), 'score' => $value, 'grade' => 'F9', 'points' => 9]);
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
            } elseif ($count == 1) {

                if ($totalpoints >= 90 && $totalpoints <= 100) {
                    $grade .= 'D1';
                    $oSubpoints .= '1';
                    $point += 1;
                } elseif ($totalpoints >= 80 && $totalpoints < 90) {
                    $grade .= 'D2';
                    $oSubpoints .= '2';
                    $point += 1;
                } elseif ($totalpoints >= 75 && $totalpoints < 80) {
                    $grade .= 'C3';
                    $oSubpoints .= '3';
                    $point += 1;
                } elseif ($totalpoints >= 70 && $totalpoints < 75) {
                    $grade .= 'C4';
                    $oSubpoints .= '4';
                    $point += 1;
                } elseif ($totalpoints >= 65 && $totalpoints < 70) {
                    $grade .= 'C5';
                    $oSubpoints .= '5';
                    $point += 1;
                } elseif ($totalpoints >= 60 && $totalpoints < 65) {
                    $grade .= 'C6';
                    $oSubpoints .= '6';
                    $point += 1;
                } elseif ($totalpoints >= 55 && $totalpoints < 60) {
                    $grade .= 'P7';
                    $oSubpoints .= '7';
                    $point += 0;
                } elseif ($totalpoints >= 50 && $totalpoints < 55) {
                    $grade .= 'P8';
                    $oSubpoints .= '8';
                    $point += 0;
                } elseif ($totalpoints >= 45 && $totalpoints < 50) {
                    $grade .= 'F9';
                    $oSubpoints .= '9';
                    $point += 0;
                } elseif ($totalpoints >= 0 && $totalpoints < 45) {
                    $grade .= 'F9';
                    $oSubpoints .= '9';
                    $point += 0;
                }
            }
        } else if ($level == 'Ordinary Level') {
            $oAgg = "";
            $oSubpoints = "";
            $oAvg = array_sum($this->inputs) / count($this->inputs);



            if ($oAvg >= 90 && $oAvg <= 100) {
                $oAgg .= 'D1';
                $oSubpoints .= '1';
            } elseif ($oAvg >= 80 && $oAvg < 90) {
                $oAgg .= 'D2';
                $oSubpoints .= '2';
            } elseif ($oAvg >= 75 && $oAvg < 80) {
                $oAgg .= 'C3';
                $oSubpoints .= '3';
            } elseif ($oAvg >= 70 && $oAvg < 75) {
                $oAgg .= 'C4';
                $oSubpoints .= '4';
            } elseif ($oAvg >= 65 && $oAvg < 70) {
                $oAgg .= 'C5';
                $oSubpoints .= '5';
            } elseif ($oAvg >= 60 && $oAvg < 65) {
                $oAgg .= 'C6';
                $oSubpoints .= '6';
            } elseif ($oAvg >= 55 && $oAvg < 60) {
                $oAgg .= 'P7';
                $oSubpoints .= '7';
            } elseif ($oAvg >= 50 && $oAvg < 55) {
                $oAgg .= 'P8';
                $oSubpoints .= '8';
            } elseif ($oAvg >= 45 && $oAvg < 50) {
                $oAgg .= 'F9';
                $oSubpoints .= '9';
            } elseif ($oAvg >= 0 && $oAvg < 45) {
                $oAgg .= 'F9';
                $oSubpoints .= '9';
            }

            if ($this->setID == 1) array_push($botpapers, ['score' => round((($oAvg * $exmsets->find(1)->set_percentage) / 100), 2)]);
            if ($this->setID == 2) array_push($motpapers, ['score' => round((($oAvg * $exmsets->find(2)->set_percentage) / 100), 2)]);
            if ($this->setID == 3) array_push($eotpapers, ['score' => round((($oAvg * $exmsets->find(3)->set_percentage) / 100), 2)]);
            $oAvg = round($oAvg, 2);
            array_push($subpapers, ['score' => $oAvg, 'grade' => $oAgg, 'points' => $oSubpoints]);
        }

        return compact('inputs', 'agg', 'subpoints', 'grade', 'point', 'level', 'oAvg', 'oSubpoints', 'oAgg', 'termID', 'setID', 'subpapers', 'botpapers', 'motpapers', 'eotpapers');
    }
}
