<?php

namespace App\Http\Controllers;

use App\Events\DocumentUpdated;
use App\Models\Document;
use App\Models\DocumentVersion;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::latest()->get();

        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function store(Request $request)
{
    try {
        Document::create([
            'user_id' => 1,
            'title' => $request->title,
            'content' => ''
        ]);

        return redirect('/documents');

    } catch (\Exception $e) {
        dd($e->getMessage());
    }
}
    public function update(Request $request, Document $document)
    {
        // SIMPAN VERSI LAMA
        DocumentVersion::create([
    'document_id' => $document->id,
    'content' => $document->content,
    'user_name' => ' refaa'
]);

        // UPDATE DOCUMENT
        $document->update([
            'content' => $request->content
        ]);

        // REALTIME BROADCAST
        broadcast(new DocumentUpdated($document))->toOthers();

        return response()->json([
            'success' => true
        ]);
    }
}