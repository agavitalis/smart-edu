<?php

namespace App\Exports;

use App\Models\StudentRegExcel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentRegExcelExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return StudentRegExcel::all();
    }

    public function headings(): array
    {
        return [
            'name',
            'username',
            'gender',
            'class',
            'level',
            'session',
            'term',
        ];
    }

}