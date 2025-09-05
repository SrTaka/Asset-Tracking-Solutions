<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\AssetService;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Exports\AssetExports;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AssetImports;


class AssetController extends Controller
{
    /**
     * Show the form for creating a new asset.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = AssetCategory::all();
        return view('admin.assets.create', compact('categories'));
    }

    /**
     * Display a listing of the assets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Asset::with('category');

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->has('purchase_date')) {
            $query->whereDate('purchase_date', $request->input('purchase_date'));
        }

        if ($request->has('purchase_price')) {
            $query->where('purchase_price', $request->input('purchase_price'));
        }

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        $assets = $query->latest()->paginate(10);

        return view('admin.assets.index', compact('assets'));

    }

    /**
     * Display the specified asset.
     */
    public function show(Asset $asset)
    {
        $asset->load('category');
        return view('admin.assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified asset.
     */
    public function edit(Asset $asset)
    {
        $categories = AssetCategory::all();
        return view('admin.assets.edit', compact('asset', 'categories'));
    }

    /**
     * Update the specified asset in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'asset_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        try {
            $asset->name = $validated['name'];
            $asset->description = $validated['description'] ?? null;
            $asset->category_id = $validated['category_id'];
            $asset->purchase_date = $validated['purchase_date'];
            $asset->purchase_price = $validated['purchase_price'];

            if ($request->hasFile('asset_image')) {
                // Remove old image if any
                if (!empty($asset->asset_image_path)) {
                    Storage::delete('public/' . $asset->asset_image_path);
                }

                $image = $request->file('asset_image');
                $imageName = $asset->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'assets/images/' . $imageName;
                Storage::put('public/' . $imagePath, file_get_contents($image));
                $asset->asset_image_path = $imagePath;
            }

            $asset->save();

            return redirect()->route('admin.assets.index')
                ->with('success', 'Asset updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['error' => 'Failed to update asset: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified asset from storage.
     */
    public function destroy(Asset $asset)
    {
        try {
            if (!empty($asset->asset_image_path)) {
                Storage::delete('public/' . $asset->asset_image_path);
            }
            if (!empty($asset->qr_code_path)) {
                Storage::delete('public/' . $asset->qr_code_path);
            }
            $asset->delete();
            return redirect()->route('admin.assets.index')
                ->with('success', 'Asset deleted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete asset: ' . $e->getMessage()]);
        }
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
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'category_id' => 'nullable|integer', // Made optional temporarily
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'asset_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
        ]);

        try {
            $asset = new Asset();
            $asset->name = $validated['name'];
            $asset->description = $validated['description'] ?? null;
            $asset->category_id = $validated['category_id'];
            $asset->purchase_date = $validated['purchase_date'];
            $asset->purchase_price = $validated['purchase_price'];

            // Save the asset first to get the ID
            $asset->save();

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

            // Handle asset image upload if provided
            if ($request->hasFile('asset_image')) {
                $image = $request->file('asset_image');
                $imageName = $asset->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'assets/images/' . $imageName;
                Storage::putFileAs('public/assets/images', $image, $imageName);
                $asset->asset_image_path = $imagePath;
            } else {
                // Set default asset image path
                $asset->asset_image_path = 'assets/images/default_asset.jpg';
            }

            $asset->save();

            return redirect()->route('admin.dashboard')
                           ->with('success', 'Asset created successfully!');

        } catch (\Exception $e) {
            return back()->withInput()
                        ->withErrors(['error' => 'Failed to create asset: ' . $e->getMessage()]);
        }
    }

    public function export(Request $request)
    {
        $filters = $request->all();
        $format = $request->get('format', 'csv');

        $filename = 'assets_export_' . now()->format('Y-m-d_H-i-s') . '.' . $format;
        switch ($format) {
            case 'csv':
                return Excel::download(new AssetExports($filters), $filename);
            case 'xlsx':
                return Excel::download(new AssetExports($filters), $filename);
            case 'pdf':
                return Excel::download(new AssetExports($filters), $filename);
            default:
                return back()->withErrors(['error' => 'Invalid format']);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new AssetImports(), $request->file('file'));
            return redirect()->route('admin.assets.index')
                ->with('success', 'Assets imported successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['error' => 'Failed to import assets: ' . $e->getMessage()]);
        }
    }

    public function importForm()
    {
        return view('admin.assets.import');
    }

    public function downloadImportTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="asset_import_template.csv"',
        ];

        $columns = [
            'name',
            'description',
            'category_id',
            'purchase_date',
            'purchase_price',
            'status',
        ];

        $callback = function () use ($columns) {
            $output = fopen('php://output', 'w');
            // Add BOM for proper UTF-8 encoding
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, $columns);
            
            // Get available categories
            $categories = AssetCategory::all();
            
            // Add example rows with proper data types
            fputcsv($output, ['Laptop X', '15-inch laptop', '1', '2025-08-21', '1200.00', 'available']);
            fputcsv($output, ['Office Chair', 'Ergonomic office chair', '2', '2025-08-22', '250.50', 'available']);
            fputcsv($output, ['', '', '', '', '', '']); // Empty row for user input
            
            // Add available categories section
            fputcsv($output, ['# Available Asset Categories:']);
            foreach ($categories as $category) {
                fputcsv($output, ['# ID: ' . $category->id . ' - ' . $category->name . ($category->description ? ' (' . $category->description . ')' : '')]);
            }
            
            // Add instructions
            fputcsv($output, ['# Instructions:']);
            fputcsv($output, ['# name: Required, max 100 characters']);
            fputcsv($output, ['# description: Optional, text description']);
            fputcsv($output, ['# category_id: Required, use one of the IDs listed above']);
            fputcsv($output, ['# purchase_date: Required, format YYYY-MM-DD']);
            fputcsv($output, ['# purchase_price: Required, decimal number (e.g., 1200.00)']);
            fputcsv($output, ['# status: Required, one of: available, assigned, maintenance']);
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function generateQrCode(Asset $asset)
    {
        $qrData = json_encode([
            'id' => $asset->id,
            'name' => $asset->name,
            'category_id' => $asset->category_id,
            'purchase_date' => $asset->purchase_date,
            'purchase_price' => $asset->purchase_price,
        ]);

        $qrImage = QrCode::format('png')->size(300)->generate($qrData);

        $qrCodePath = 'qr_codes/' . $asset->id . '.png';
        Storage::put('public/' . $qrCodePath, $qrImage);
        $asset->qr_code_path = $qrCodePath;
        $asset->save();

        return redirect()->route('admin.assets.show', $asset->id)
            ->with('success', 'QR code generated successfully!');
    }

    public function streamQrCode(Asset $asset)
    {
        $qrData = $asset->qr_code_data ?: json_encode([
            'id' => $asset->id,
            'name' => $asset->name,
            'category_id' => $asset->category_id,
            'purchase_date' => $asset->purchase_date,
            'purchase_price' => $asset->purchase_price,
        ]);

        $qrImage = QrCode::format('png')->size(300)->generate($qrData);

        return response($qrImage, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'no-store',
        ]);
    }

    public function downloadQr($id)
    {
        $asset = Asset::findOrFail($id);
        $qrData = route('admin.assets.show', $asset->id);
        $qrImage = \QrCode::format('png')->size(300)->generate($qrData);
    
        return response($qrImage)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="asset-'.$asset->id.'-qr.png"');
    }

}