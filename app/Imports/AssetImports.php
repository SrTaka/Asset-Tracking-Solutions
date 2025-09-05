<?php

namespace App\Imports;

use App\Models\Asset;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AssetImports implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row): void
    {
        $data = $row->toArray();

        // Skip comment rows and empty rows
        if (empty($data['name']) || str_starts_with($data['name'], '#') || empty($data['purchase_date']) || !isset($data['purchase_price'])) {
            return;
        }

        $asset = new Asset();
        $asset->name = (string)($data['name'] ?? '');
        $asset->description = $data['description'] ?? null;
        $asset->category_id = isset($data['category_id']) && $data['category_id'] !== '' ? (int)$data['category_id'] : null;
        $asset->purchase_date = (string)$data['purchase_date'];
        $asset->purchase_price = (float)$data['purchase_price'];
        $asset->status = in_array($data['status'] ?? 'available', ['available', 'assigned', 'maintenance']) ? $data['status'] : 'available';

        $asset->save();

        $qrData = json_encode([
            'id' => $asset->id,
            'name' => $asset->name,
            'category_id' => $asset->category_id,
            'purchase_date' => $asset->purchase_date,
            'purchase_price' => $asset->purchase_price,
        ]);
        $asset->qr_code_data = $qrData;

        $qrImage = QrCode::format('png')->size(300)->generate($qrData);
        $qrCodePath = 'qr_codes/' . $asset->id . '.png';
        Storage::put('public/' . $qrCodePath, $qrImage);
        $asset->qr_code_path = $qrCodePath;
        $asset->qr_code_generated_at = now();

        $asset->save();
    }
}


