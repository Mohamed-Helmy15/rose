<?php

namespace App\Http\Controllers;

use App\Models\SupplierEvaluation;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierEvaluationController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $evaluations = SupplierEvaluation::with(['supplier', 'evaluatedBy'])
            ->latest()
            ->get();

        return view('dashboard.supplier_evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $suppliers = Supplier::active()->get();
        return view('dashboard.supplier_evaluations.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'evaluation_date' => 'required|date',
            'rating' => 'required|numeric|min:0|max:5',
            'comments' => 'nullable|string',
        ]);

        $evaluation = SupplierEvaluation::create([
            'supplier_id' => $request->supplier_id,
            'evaluation_date' => $request->evaluation_date,
            'rating' => $request->rating,
            'comments' => $request->comments,
            'evaluated_by_user_id' => auth()->id(),
        ]);

        $evaluation->supplier->calculateQualityRating();

        $this->logActivity('supplier_evaluation_created', "تم إنشاء تقييم مورد جديد: #{$evaluation->id}");

        return redirect()->route('supplier-evaluations.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم إضافة التقييم بنجاح']);
    }

    public function show(SupplierEvaluation $supplierEvaluation)
    {
        $supplierEvaluation->load(['supplier', 'evaluatedBy']);

        return view('dashboard.supplier_evaluations.show', compact('supplierEvaluation'));
    }

    public function edit(SupplierEvaluation $supplierEvaluation)
    {
        $suppliers = Supplier::active()->get();
        return view('dashboard.supplier_evaluations.edit', compact('supplierEvaluation', 'suppliers'));
    }

    public function update(Request $request, SupplierEvaluation $supplierEvaluation)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'evaluation_date' => 'required|date',
            'rating' => 'required|numeric|min:0|max:5',
            'comments' => 'nullable|string',
        ]);

        $supplierEvaluation->update($validated);

        $supplierEvaluation->supplier->calculateQualityRating();

        $this->logActivity('supplier_evaluation_updated', "تم تحديث تقييم المورد: #{$supplierEvaluation->id}");

        return redirect()->route('supplier-evaluations.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم تحديث التقييم بنجاح']);
    }

    public function destroy(SupplierEvaluation $supplierEvaluation)
    {
        $id = $supplierEvaluation->id;
        $supplier = $supplierEvaluation->supplier;
        $supplierEvaluation->delete();
        $supplier->calculateQualityRating();

        $this->logActivity('supplier_evaluation_deleted', "تم حذف تقييم المورد: #{$id}");

        return redirect()->route('supplier-evaluations.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم حذف التقييم بنجاح']);
    }
}