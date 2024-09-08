<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Year;
use Illuminate\Http\Request;

class YearSectionController extends Controller
{
    public function index()
    {
        $year = Year::get();
        $sections = Section::get();
        return view('admin.year-section.index', compact('year', 'sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required|string|max:255',
        ]);

        Section::create([
            'section' => $request->section,
        ]);

        return redirect()->route('year-sections.index')->with('success', 'New Section created successfully.');
    }


    public function create_year(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:255',
        ]);

        Year::create([
            'year' => $request->year,
        ]);

        return redirect()->route('year-sections.index')->with('success', 'Year created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'section' => 'required|string|max:255',
        ]);

        $section = Section::findOrFail($id);
        $section->update([
            'section' => $request->section,
        ]);

        return redirect()->route('year-sections.index')->with('success', 'Section updated successfully.');
    }


    public function update_year(Request $request, $id)
    {
        $request->validate([
            'year' => 'required|string|max:255',
        ]);

        $year = Year::findOrFail($id);
        $year->update([
            'year' => $request->year,
        ]);

        return redirect()->route('year-sections.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified section from storage.
     */
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->route('year-sections.index')->with('success', 'Section deleted successfully.');
    }


    public function destroy_year($id)
    {
        $year = Year::findOrFail($id);
        $year->delete();

        return redirect()->route('year-sections.index')->with('success', 'Section deleted successfully.');
    }
}
