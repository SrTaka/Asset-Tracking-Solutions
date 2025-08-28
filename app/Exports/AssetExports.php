<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetExports implements FromCollection, WithHeadings, WithStyles, WithTitle, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Asset::query();

        if (!empty($this->filters['name'])) {
            $query->where('name', 'like', '%' . $this->filters['name'] . '%');
        }
        
        if (!empty($this->filters['category_id'])) {
            $query->where('category_id', $this->filters['category_id']);
        }

        if (!empty($this->filters['purchase_date'])) {
            $query->where('purchase_date', $this->filters['purchase_date']);
        }

        if (!empty($this->filters['purchase_price'])) {
            $query->where('purchase_price', $this->filters['purchase_price']);
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->with('category')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Description', 'Category', 'Purchase Date', 'Purchase Price', 'Status', 'Created At', 'Updated At'];
    }

    public function map($asset): array{
        return [
            $asset->id,
            $asset->name,
            $asset->description,
            optional($asset->category)->name,
            $asset->purchase_date,
            $asset->purchase_price,
            $asset->status,
            $asset->created_at,
            $asset->updated_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Assets';
    }
    
}
