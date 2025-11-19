<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{
    public function index()
    {
        $documentTypes = DocumentType::orderBy('name','asc')->get();
        return view('documents.index', compact('documentTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'title' => 'required|max:255',
            'event_date' => 'required|date',
            'document_type_id' => 'required|exists:document_types,id',
            'notes' => 'nullable|max:1000',
        ]);

        // Simpan file
        $path = $request->file('document_file')->store('user_documents', 'public');

        Document::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'event_date' => $request->event_date,
            'document_type_id' => $request->document_type_id,
            'notes' => $request->notes,
            'file_path' => $path,
        ]);

        return redirect()->route('documents.index')
                         ->with('success', 'Dokumen berhasil di-upload!');
    }
}
