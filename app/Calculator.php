<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Student;
use App\Exam;

class Calculator
{

    public $inputs;
    public $level;
    public $termID;
    public $setID;
    public $studentID;

    public function set_inputs($input, $level, $termID, $setID)
    {
        $this->inputs = [...$input];
        $this->level = $level;
        $this->termID = $termID;
        $this->setID = $setID;
    }

    public function set_student($student, $term, $level)
    {
        $this->studentID = $student;
        $this->termID = $term;
        $this->level = $level;
    }
    public function get_mark($score, $level)
    {
        $score = $score;
        $level = $level;
        $subpoints = [];
        $agg = "";
        $subpapers = [];

        if ($level == 'Advanced Level') {
            $agg = [];
            foreach ($score as $key => $value) {


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
                $subpoints = "";
                if ($totalpoints == 1) {
                    $grade .= 'D1';
                    $subpoints .= '1';
                    $point += 1;
                } elseif ($totalpoints == 2) {
                    $grade .= 'D2';
                    $subpoints .= '2';
                    $point += 1;
                } elseif ($totalpoints == 3) {
                    $grade .= 'C3';
                    $subpoints .= '3';
                    $point += 1;
                } elseif ($totalpoints == 4) {
                    $grade .= 'C4';
                    $subpoints .= '4';
                    $point += 1;
                } elseif ($totalpoints == 5) {
                    $grade .= 'C5';
                    $subpoints .= '5';
                    $point += 1;
                } elseif ($totalpoints == 6) {
                    $grade .= 'C6';
                    $subpoints .= '6';
                    $point += 1;
                } elseif ($totalpoints == 7) {
                    $grade .= 'P7';
                    $subpoints .= '7';
                    $point += 0;
                } elseif ($totalpoints == 8) {
                    $grade .= 'P8';
                    $subpoints .= '8';
                    $point += 0;
                } elseif ($totalpoints == 9) {
                    $grade .= 'F9';
                    $subpoints .= '9';
                    $point += 0;
                }
            }
            $score = ['scores' => $score, 'grade' => $grade, 'subgrades' => $agg, 'subpoints' => $subpoints, 'count' => $count, 'points' => $point];
            return $score;
        } else if ($level == 'Ordinary Level') {
            $oAgg = "";
            $oSubpoints = "";
            $oAvg = $score;

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

            $oAvg = round($oAvg, 2);
            $score = ['score' => $oAvg, 'grade' => $oAgg, 'points' => $oSubpoints];
            return $score;
        }
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

                $subpoints = "";
                if ($totalpoints == 1) {
                    $grade .= 'D1';
                    $subpoints .= '1';
                    $point += 1;
                } elseif ($totalpoints == 2) {
                    $grade .= 'D2';
                    $subpoints .= '2';
                    $point += 1;
                } elseif ($totalpoints == 3) {
                    $grade .= 'C3';
                    $subpoints .= '3';
                    $point += 1;
                } elseif ($totalpoints == 4) {
                    $grade .= 'C4';
                    $subpoints .= '4';
                    $point += 1;
                } elseif ($totalpoints == 5) {
                    $grade .= 'C5';
                    $subpoints .= '5';
                    $point += 1;
                } elseif ($totalpoints == 6) {
                    $grade .= 'C6';
                    $subpoints .= '6';
                    $point += 1;
                } elseif ($totalpoints == 7) {
                    $grade .= 'P7';
                    $subpoints .= '7';
                    $point += 0;
                } elseif ($totalpoints == 8) {
                    $grade .= 'P8';
                    $subpoints .= '8';
                    $point += 0;
                } elseif ($totalpoints == 9) {
                    $grade .= 'F9';
                    $subpoints .= '9';
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

    public function get_overallTerm()
    {
        $students = new Student();
        $exams = new Exam();
        if ($students->where('id', $this->studentID)->exists()) {
            if ($exams->where('year', date('Y'))->where('term_id', $this->termID)->where('student_id', $this->studentID)->exists()) {
                if ($exams->where('year', date('Y'))->where('term_id', $this->termID)->where('student_id', $this->studentID)->where('termBrief', 'true')->exists()) {
                    $exam = $exams->where('year', date('Y'))->where('term_id', $this->termID)->where('student_id', $this->studentID)->where('termCompact', 'true')->first();
                    $message = "Update termBrief score";
                } elseif ($exams->where('year', date('Y'))->where('term_id', $this->termID)->where('student_id', $this->studentID)->where('termBrief', 'true')->count() == 0) {
                    $message = "New termBrief Score";

                    $results = $exams->where('year', date('Y'))->where('term_id', $this->termID)->where('student_id', $this->studentID)->get();


                    if ($this->level == 'Ordinary Level') {
                        foreach ($results as $key => $result) {
                            $all = [];
                            $result->b_o_t ? array_push($all, json_decode($result->b_o_t, true)['computed'][0]['score']) : array_push($all, 0);
                            $result->m_o_t ?  array_push($all, json_decode($result->m_o_t, true)['computed'][0]['score']) : array_push($all, 0);
                            $result->e_o_t ? array_push($all, json_decode($result->e_o_t, true)['computed'][0]['score']) : array_push($all, 0);
                            $result->total = $this->get_mark(array_sum($all), $this->level)['score'];
                            $result->grade = $this->get_mark(array_sum($all), $this->level)['grade'];
                            $result->point = $this->get_mark(array_sum($all), $this->level)['points'];
                            $result->save();
                        }
                    } elseif ($this->level == 'Advanced Level') {
                        foreach ($results as $key => $result) {
                            $bot = $result->b_o_t ? json_decode($result->b_o_t, true)['computed'] : [];
                            $mot = $result->m_o_t ? json_decode($result->m_o_t, true)['computed'] : [];
                            $eot = $result->e_o_t ? json_decode($result->e_o_t, true)['computed'] : [];

                            $length = max([count($bot), count($mot), count($eot)]);
                            $papers = [];
                            for ($i = 0; $i < $length; $i++) {
                                if (array_key_exists(
                                    $i,
                                    $bot
                                ) || (array_key_exists($i, $mot)) || (array_key_exists($i, $eot))) {
                                    $papers['papers'][] = 1 + $i;
                                    $papers['scores'][] = array_sum([
                                        (array_key_exists($i, $bot) ? $bot[$i]['score'] : 0),
                                        (array_key_exists($i, $mot) ? $mot[$i]['score'] : 0),
                                        (array_key_exists($i, $eot) ? $eot[$i]['score'] : 0)
                                    ]);
                                }
                            }


                            $scores = $this->get_mark($papers['scores'], $this->level);
                            $result->total = json_encode($scores['scores'], true);
                            $result->grade = json_encode($scores['grade'], true);
                            $result->papers = json_encode($scores['subgrades'], true);
                            $result->point = json_encode($scores['points'], true);
                            $result->save();
                        }
                    }
                }
            } else {
                $message = "Student Not In any Results";
            }
        } else {
            $message = "Student Not Found";

            // return response()->json(compact('message'));
        }
    }
}
