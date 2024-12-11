<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('frontend.layouts.master', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|max:10',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'pdf' => 'nullable|file|mimes:pdf',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);
        

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if(request()->file('pdf')){
          $user->pdf =  pdforelse($request->file('pdf'), 'uploads', 400);
        }
        if(request()->file('image')){
          $user->image =  pdforelse($request->file('image'), 'uploads', 400);
        }
        $user->save();
    
        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function update(Request $request, User $contact)
    {
        $request->validate([
            'name' => 'nullable|max:10',
            'email' => 'required|email|unique:users,email,' . $contact->id,
            'phone' => 'required',
            'pdf' => 'nullable|file|mimes:pdf',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->file('pdf')) {
            $pdfPath = $request->file('pdf')->store('pdfs', 'public');
            $contact->pdf = $pdfPath;
        }

        if ($request->file('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $contact->image = $imagePath;
        }

        $contact->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('/')->with('success', 'Item updated successfully.');
    }

    public function destroy(User $contact)
    {
        $contact->delete();
        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
