<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PromotionController extends Controller
{
    public function index()
    {
        return Inertia::render('Promotions/Index', [
            'promotions' => Promotion::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'discount_percent' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Promotion::create($request->all());

        return redirect()->back()->with('success', 'Promotion Created!');
    }

    public function destroy($id)
    {
        Promotion::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Promotion Deleted!');
    }
}