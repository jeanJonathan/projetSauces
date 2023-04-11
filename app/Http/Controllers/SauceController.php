<?php

namespace App\Http\Controllers;

use App\Models\Sauce;
use Illuminate\Http\Request;

class SauceController extends Controller
{
    public function index()
    {
        $sauces = Sauce::orderBy('created_at', 'desc')->paginate(10);

        return view('sauces.index', compact('sauces'));
    }

    public function show(Sauce $sauce)
    {
        return view('sauces.show', compact('sauce'));
    }

    public function edit(Sauce $sauce)
    {
        return view('sauces.edit', compact('sauce'));
    }

    public function update(Request $request, Sauce $sauce)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'heat' => 'required|integer|between:1,10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('images/sauces/' . $filename);
            Image::make($image->getRealPath())->fit(800, 800)->save($path);
            $sauce->image = 'images/sauces/' . $filename;
        }

        $sauce->name = $request->input('name');
        $sauce->description = $request->input('description');
        $sauce->heat = $request->input('heat');
        $sauce->save();

        return redirect()->route('sauces.show', $sauce->id)->with('success', 'Sauce successfully updated!');
    }

    public function create()
    {
        return view('sauces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'heat' => 'required|integer|between:1,10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $sauce = new Sauce;
        $sauce->name = $request->input('name');
        $sauce->description = $request->input('description');
        $sauce->heat = $request->input('heat');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('images/sauces/' . $filename);
            Image::make($image->getRealPath())->fit(800, 800)->save($path);
            $sauce->image = 'images/sauces/' . $filename;
        }

        $sauce->user_id = auth()->user()->id;
        $sauce->save();

        return redirect()->route('sauces.show', $sauce->id)->with('success', 'Sauce successfully created!');
    }

    public function destroy(Sauce $sauce)
    {
        $sauce->delete();
        return redirect()->route('sauces.index')->with('success', 'Sauce successfully deleted!');
    }

    public function like(Sauce $sauce)
    {
        $sauce->likes++;
        $sauce->save();
        return redirect()->back()->with('success', 'You liked the sauce!');
    }
    public function dislike(Sauce $sauce)
    {
        $sauce->likes--;
        $sauce->save();
        return redirect()->back()->with('success', 'You disliked the sauce!');
    }

}
