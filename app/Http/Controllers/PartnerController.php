<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index(Request $request) {
        $partners = Partner::all();
        $editPartner = null;
    
        if ($request->has('edit')) {
            $editPartner = Partner::find($request->edit);
        }
    
        return view('admin.partners', compact('partners', 'editPartner'));
    }
    

    public function create() {
        return view('partners.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'Partner_name' => 'required|string',
            'Partner_description' => 'required|string',
            'picture' => 'nullable|image|max:2048',
        ]);

       
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('partners');
            $data['picture'] = $path;
        }
        

        Partner::create($data);
        return redirect()->route('admin.partners')->with('success', 'Partner added successfully!');
    }

    public function edit($id) {
        $partner = Partner::findOrFail($id);
        return view('partners.edit', compact('partner'));
    }

    public function update(Request $request, $id) {
        $partner = Partner::findOrFail($id);

        $data = $request->validate([
            'Partner_name' => 'required|string',
            'Partner_description' => 'required|string',
            'picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('partners'); // Default private
            $data['picture'] = $path;
        }
        

        $partner->update($data);
        return redirect()->route('admin.partners')->with('success', 'Partner updated successfully!');
    }

    public function destroy($id) {
        $partner = Partner::findOrFail($id);
        if ($partner->picture) {
            Storage::disk('public')->delete($partner->picture);
        }
        $partner->delete();
        return redirect()->route('admin.partners')->with('success', 'Partner deleted!');
    }
}
