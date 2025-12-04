<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $categories = Category::with('parent')->orderBy('sort_order')->get();
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->active()->orderBy('name')->get();
        return view('dashboard.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:20|unique:categories,code',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'color'       => 'required|string|regex:/^#[a-f0-9]{6}$/i',
            'parent_id'   => 'nullable|exists:categories,id',
            'is_active'   => 'sometimes|boolean',
        ]);

        $data = $request->only(['name', 'code', 'description', 'color', 'parent_id']);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category = Category::create($data);

        $this->logActivity('category_created', "تم إنشاء تصنيف جديد: {$category->name} (كود: {$category->code})");

        return redirect()->route('categories.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم إنشاء التصنيف بنجاح'
        ]);
    }

    public function show(Category $category)
    {
        $category->load(['parent', 'children']);
        return view('dashboard.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->active()
            ->orderBy('name')
            ->get();

        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:20|unique:categories,code,' . $category->id,
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'color'       => 'required|string|regex:/^#[a-f0-9]{6}$/i',
            'parent_id'   => 'nullable|exists:categories,id',
            'is_active'   => 'sometimes|boolean',
        ]);

        $oldName = $category->name;

        $data = $request->only(['name', 'code', 'description', 'color', 'parent_id']);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        $this->logActivity('category_updated', "تم تحديث التصنيف: {$oldName} → {$category->name}");

        return redirect()->route('categories.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم تحديث التصنيف بنجاح'
        ]);
    }

    public function destroy(Category $category)
    {
        if ($category->children()->exists() || $category->products()->exists()) {
            return back()->with('toast', [
                'type' => 'error',
                'message' => 'لا يمكن حذف تصنيف به تصنيفات فرعية أو منتجات!'
            ]);
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $name = $category->name;
        $category->delete();

        $this->logActivity('category_deleted', "تم حذف التصنيف: {$name}");

        return redirect()->route('categories.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم حذف التصنيف بنجاح'
        ]);
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order', []);

        foreach ($order as $item) {
            Category::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}