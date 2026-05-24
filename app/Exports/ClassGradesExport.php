<?php

namespace App\Exports;

use App\Models\ClassModel;
use App\Models\Skill;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClassGradesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $class;
    protected $studentGrades;
    protected $skills;

    public function __construct(ClassModel $class, array $studentGrades)
    {
        $this->class = $class;
        $this->studentGrades = $studentGrades;
        $this->skills = Skill::all();
    }

    public function collection()
    {
        return collect($this->studentGrades);
    }

    public function headings(): array
    {
        $headings = ['No', 'Nama Murid', 'Email'];
        
        foreach ($this->skills as $skill) {
            $headings[] = strtoupper($skill->nama_skill);
        }
        
        $headings[] = 'RATA-RATA';
        $headings[] = 'Kuis Dikerjakan';
        $headings[] = 'Tugas Dinilai';

        return $headings;
    }

    public function map($item): array
    {
        static $no = 0;
        $no++;

        $row = [
            $no,
            $item['student']->nama_lengkap,
            $item['student']->email,
        ];

        foreach ($this->skills as $skill) {
            $score = $item['skill_scores'][$skill->kode] ?? null;
            $row[] = $score !== null ? round($score, 1) : '-';
        }

        $row[] = $item['average'] !== null ? round($item['average'], 1) : '-';
        $row[] = $item['quiz_count'];
        $row[] = $item['assignment_count'];

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function title(): string
    {
        return 'Rekap Nilai';
    }
}
