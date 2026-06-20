<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Show the member management page.
     */
    public function page()
    {
        return view('members');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Member::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|string|max:255|unique:members',
            'nama' => 'required|string|max:255',
            'tahun_masuk' => 'required|numeric|digits:4',
            'lulus_madrasah' => 'nullable|numeric|digits:4',
            'kampus' => 'nullable|string|max:255',
            'wali' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'alamat_lengkap' => 'nullable|string',
        ]);

        if (empty($validated['id'])) {
            $maxId = Member::select('id')->get()->filter(function ($m) {
                return is_numeric($m->id);
            })->max(function ($m) {
                return (int) $m->id;
            });
            $validated['id'] = (string) (($maxId ?? 0) + 1);
        }

        $member = Member::create($validated);

        return response()->json([
            'message' => 'Member created successfully',
            'data' => $member
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return $member;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:255|unique:members,id,' . $member->id . ',id',
            'nama' => 'required|string|max:255',
            'tahun_masuk' => 'required|numeric|digits:4',
            'lulus_madrasah' => 'nullable|numeric|digits:4',
            'kampus' => 'nullable|string|max:255',
            'wali' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'alamat_lengkap' => 'nullable|string',
        ]);

        $member->update($validated);

        return response()->json([
            'message' => 'Member updated successfully',
            'data' => $member
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json([
            'message' => 'Member deleted successfully'
        ]);
    }
}
