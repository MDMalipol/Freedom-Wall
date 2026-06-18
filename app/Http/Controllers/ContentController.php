<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'body' => 'required|string',
            'name' => 'nullable|string|max:255',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:20480',
        ]);

        $mediaPaths = [];

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('uploads', 'public');
                $mediaPaths[] = $path;
            }
        }

        Content::create([
            'title' => $validatedData['title'] ?? null,
            'body' => $validatedData['body'],
            'name' => $validatedData['name'] ?? null,
            'media' => $mediaPaths, // <-- store as array, not json_encode
        ]);

        return redirect()->route('wall')->with('message', 'Content created successfully');
    }

    public function display()
    {
         $nullStatusCount = Content::whereNull('Status')->count();
        $contents = Content::all();
        return view('wall', compact('contents','nullStatusCount'));
    }

    public function accept(Request $request, $id)
    {
        
        $content = Content::findOrFail($id);
        
        $validatedData = $request->validate([
            'Status' => 'required|in:accepted,rejected',
        ]);


        $content->update(['Status' => $validatedData['Status']]);

        return redirect()->back()->with('message', 'Content status updated successfully');
    }

       public function reject(Request $request, $id)
    {
        
        $content = Content::findOrFail($id);
        
        $validatedData = $request->validate([
            'Status' => 'required|in:accepted,rejected',
        ]);


        $content->update(['Status' => $validatedData['Status']]);

        return redirect()->back()->with('message', 'Content status updated successfully');
    }

           public function recover(Request $request, $id)
    {
        
        $content = Content::findOrFail($id);
        
        $validatedData = $request->validate([
            'Status' => 'nullable|in:accepted,rejected',
        ]);


        $content->update(['Status' => $validatedData['Status']]);

        return redirect()->back()->with('message', 'Content status updated successfully');
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();

        return redirect()->back()->with('message', 'Content deleted successfully');
    }

    
    
}
