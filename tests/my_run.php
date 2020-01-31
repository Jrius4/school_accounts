<?php

$user_array = [
    1 => "super_admin",
    2 => "admin",
    3 => "headteacher",
    4 => "academic",
    5 => "teacher",
    6 => "secretary",
    7 => "Umar Boss",
    17 => "Julius Junior Kazibwe",
    18 => "Paul Male",
    19 => "taylor shift",
];
$roles_array =[
   [
    'id'=>1,
    'name'=>'Boss',
    'user'=>[
        'id'=>1,
        'name'=>"kazibwe"
    ]
    ],

    [
        'id'=>2,
        'name'=>'Big guy',
        'user'=>[
            'id'=>2,
            'name'=>"Junior"
        ]
        ],

];
foreach($roles_array as $item1)
{
    foreach($item1 as $item){

    echo $item->name;
    echo "\n";

  }}
?>
