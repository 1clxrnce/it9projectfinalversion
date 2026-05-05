<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->orderBy('brand_name')->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function archived()
    {
        $brands = Brand::onlyTrashed()->withCount('products')->orderBy('brand_name')->get();
        return view('admin.brands.archived', compact('brands'));
    }

    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore();
        
        return redirect()->route('admin.brands.archived')
            ->with('success', 'Brand restored successfully');
    }

    public function forceDelete($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        
        // Delete image if exists
        if ($brand->image && \Storage::disk('public')->exists($brand->image)) {
            \Storage::disk('public')->delete($brand->image);
        }
        
        $brand->forceDelete();
        
        return redirect()->route('admin.brands.archived')
            ->with('success', 'Brand permanently deleted');
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('brands', 'brand_name')->whereNull('deleted_at')
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('brands', 'public');
            
            // Automatically copy to public directory
            $this->copyStorageToPublic();
        }

        Brand::create($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand created successfully');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'brand_name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('brands', 'brand_name')
                    ->ignore($brand->brand_id, 'brand_id')
                    ->whereNull('deleted_at')
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($brand->image && \Storage::disk('public')->exists($brand->image)) {
                \Storage::disk('public')->delete($brand->image);
            }
            $validated['image'] = $request->file('image')->store('brands', 'public');
            
            // Automatically copy to public directory
            $this->copyStorageToPublic();
        }

        $brand->update($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand updated successfully');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete(); // Soft delete
        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand moved to archive');
    }

    /**
     * Copy storage files to public directory for web access
     */
    private function copyStorageToPublic()
    {
        $sourceDir = storage_path('app/public');
        $destDir = public_path('storage');

        // Ensure destination directory exists
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        // Copy all files from storage to public
        $this->recursiveCopy($sourceDir, $destDir);
    }

    /**
     * Recursively copy directory contents
     */
    private function recursiveCopy($source, $dest)
    {
        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $destPath = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
            if ($item->isDir()) {
                if (!is_dir($destPath)) {
                    mkdir($destPath, 0755, true);
                }
            } else {
                copy($item, $destPath);
            }
        }
    }
}
