<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $alumni = Alumni::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                      ->orWhere('middle_initial', 'like', '%' . $search . '%')  
                      ->orWhere('last_name', 'like', '%' . $search . '%')
                      ->orWhere('current_job', 'like', '%' . $search . '%')
                      ->orWhere('degree_program', 'like', '%' . $search . '%')
                      ->orWhere('graduation_year', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10);

        return view('directory.index', compact('alumni', 'search'));
    }
}
