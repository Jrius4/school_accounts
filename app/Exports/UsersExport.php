<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class UsersExport implements FromCollection, WithCustomCsvSettings
// class UsersExport implements FromCollection, WithDrawings, WithCustomCsvSettings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('Logo');
    //     $drawing->setDescription('This is my logo');
    //     $drawing->setPath(public_path('/schools/logos/logo-white-one.jpg'));
    //     $drawing->setHeight(50);
    //     $drawing->setCoordinates('B2');

    //     $drawing2 = new Drawing();
    //     $drawing2->setName('Other image');
    //     $drawing2->setDescription('This is a second image');
    //     $drawing2->setPath(public_path('/schools/logos/logo-white-one.jpg'));
    //     $drawing2->setHeight(120);
    //     $drawing2->setCoordinates('G2');

    //     return [$drawing];
    // }
    public function collection()
    {
        return User::select('first_name', 'last_name', 'given_name', 'username', 'email')->get();
    }
    public function getCsvSettings(): array
    {

        return [
            'delimiter' => ';'
        ];
    }
}
