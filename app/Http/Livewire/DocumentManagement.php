<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DocumentManagement extends Component
{
    use WithFileUploads, WithPagination;

    public $title;
    public $file;
    public $search = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // max 10MB
    ];

    public function render()
    {
        $documents = Document::where('title', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.document-management', ['documents' => $documents]);
    }

    public function upload()
    {
        $this->validate();

        $filename = Str::random(20) . '.' . $this->file->getClientOriginalExtension();
        $path = $this->file->storeAs('documents', $filename, 'public');

        Document::create([
            'title' => $this->title,
            'file_path' => $path,
            'uploaded_by' => Auth::id(),
        ]);

        session()->flash('message', 'Document uploaded successfully.');

        $this->reset(['title', 'file']);
    }

    public function delete($id)
    {
        $document = Document::findOrFail($id);
        \Storage::disk('public')->delete($document->file_path);
        $document->delete();

        session()->flash('message', 'Document deleted successfully.');
    }
}
