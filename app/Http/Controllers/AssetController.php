<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\AssetService;
use App\Models\Asset;
class AssetController extends Controller
{
   
    public function create()

    {
        return view('admin.assets.create-assets');
    }

        /**
         * Store a newly created asset in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
        ]);

        try {
            $asset = new Asset();
            $asset->name = $validated['name'];
            $asset->description = $validated['description'] ?? null;
            $asset->category_id = $validated['category_id'];
            $asset->purchase_date = $validated['purchase_date'];
            $asset->purchase_price = $validated['purchase_price'];
            // Generate QR code data from asset fields
            $qrData = json_encode([
                'id' => $asset->id,
                'name' => $asset->name,
                'category_id' => $asset->category_id,
                'purchase_date' => $asset->purchase_date,
                'purchase_price' => $asset->purchase_price,
            ]);
            $asset->qr_code_data = $qrData;

            // Generate QR code image
            $qrImage = QrCode::format('png')->size(300)->generate($qrData);

            // Store QR code image and set path
            $qrCodePath = 'qr_codes/' . $asset->id . '.png';
            Storage::put('public/' . $qrCodePath, $qrImage);
            $asset->qr_code_path = $qrCodePath;

            // Set QR code generated timestamp
            $asset->qr_code_generated_at = now();

            // Optionally set asset image path if you handle asset images
            $assetImagePath = 'assets/images/' . $asset->id . '_photo.jpg';
            // Example: Storage::put('public/' . $assetImagePath, $imageData); // $imageData should be the image binary
            $asset->asset_image_path = $assetImagePath;

            $asset->save();

            return response()->json(['message' => 'Asset created successfully', 'asset' => $asset], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create asset', 'details' => $e->getMessage()], 500);
        }
    }
}