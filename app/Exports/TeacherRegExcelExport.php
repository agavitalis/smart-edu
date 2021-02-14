<?php

namespace App\Exports;

use App\Models\TeacherRegExcel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeacherRegExcelExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return TeacherRegExcel::all();
    }

    public function headings(): array
    {
        return [
            'name',
            'username',
            'gender',
        ];
    }

}
  