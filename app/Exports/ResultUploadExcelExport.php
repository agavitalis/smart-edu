<?php

namespace App\Exports;

use App\Models\ResultUploadExcel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResultUploadExcelExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return ResultUploadExcel::all();
    }

    public function headings(): array
    {
        return [
            'name',
            'regno',
            'class',
            'term',
            'level',
            'session',
            'subject',

            'continous_accessment',
            'test',
            'exam',

            'subject_teacher',
            'teacher_username',

        ];
    }

}
