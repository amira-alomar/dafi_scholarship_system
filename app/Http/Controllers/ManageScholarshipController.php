<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Scholarship;
use App\Models\Partner;
use App\Models\Criteria;
use App\Models\Benefit;
use App\Models\ApplicationStage;

class ManageScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::with(['criteria', 'benefits', 'partners'])->get();
        $allPartners = Partner::all();
        return view('admin.scholarship', compact('scholarships', 'allPartners'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'funding_organization' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
            'status' => 'required|in:open,closed',
            'target_group' => 'required|in:Bachelor,Master,PHD',
            'idUni' => 'required|exists:universities,universityID',
        ]);

        Scholarship::create($data);
        return back()->with('success', 'Scholarship added successfully!');
    }

    public function destroy($id)
    {
        Scholarship::findOrFail($id)->delete();
        return back()->with('success', 'Scholarship deleted.');
    }


    public function update(Request $request, $id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string',
            'funding_organization' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
            'status' => 'required|in:open,closed',
            'target_group' => 'required|in:Bachelor,Master,PHD',
            'idUni' => 'required|exists:universities,universityID',
        ]);
        $scholarship->update($data);
        return redirect()
        ->to(route('scholarships.index') . '#modal-' . $id)
        ->with('success','Scholarship updated successfully!');
    }

    // ------------------- CRITERIA -------------------
    public function addCriteria(Request $request, $id)
    {
        $request->validate(['text' => 'required|string']);
        Criteria::create([
            'criteria_text' => $request->text,
            'idScholarship' => $id
        ]);
        return back();
    }

    public function deleteCriteria($id)
    {
        Criteria::findOrFail($id)->delete();
        return back();
    }

    // ------------------- BENEFIT -------------------
    public function addBenefit(Request $request, $id)
    {
        $request->validate(['text' => 'required|string']);
        Benefit::create([
            'Benefit_text' => $request->text,
            'idScholarship' => $id
        ]);
        return back();
    }

    public function deleteBenefit($id)
    {
        Benefit::findOrFail($id)->delete();
        return back();
    }

    // ------------------- PARTNER -------------------
    public function addPartner(Request $request, $id)
    {
        $request->validate(['partner_id' => 'required|exists:partners,partnerID']);

        $scholarship = Scholarship::findOrFail($id);
        $scholarship->partners()->syncWithoutDetaching([$request->partner_id]);

        return back();
    }


    public function deletePartner($scholarshipID, $partnerID)
    {
        $scholarship = Scholarship::findOrFail($scholarshipID);
        $scholarship->partners()->detach($partnerID);
        return back();
    }

    // ------------------- STAGES -------------------
    public function AddStage(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $stage = new ApplicationStage();
        $stage->idScholarship = $id;
        $stage->name = $request->name;
        $stage->description = $request->description;
        $stage->order = $request->order;
        $stage->start_date = $request->start_date;
        $stage->end_date = $request->end_date;
        $stage->save();

        return back()->with('success', 'Stage added successfully!');
    }

    public function DeleteStage($id)
    {
        $stage = ApplicationStage::findOrFail($id);
        $stage->delete();

        return back()->with('success', 'Stage deleted successfully!');
    }
}
