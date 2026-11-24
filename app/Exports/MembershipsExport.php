<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;

class MembershipsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        return User::members()
            ->get([
                'name',
                'email',
                'membership_id',
                'contact_number',
                'membership_status',
                'membership_date',
                'expiry_date',
            ]);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Membership ID',
            'Contact Number',
            'Status',
            'Membership Date',
            'Expiry Date',
        ];
    }
}