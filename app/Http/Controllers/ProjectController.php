<?php

namespace App\Http\Controllers;

use App\Page;
use App\Sentence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('id-admin');
        
        return view('project.index');
    }

    /**	
     * Store a newly created resource in storage.
     *	
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response	
     */	
    public function store(Request $request)	
    {
        $request->validate(['json_file' => 'required|mimes:json,txt']);

        $pbefore = Page::count();
        $sbefore = Sentence::count();

        // Log::info("Starting process the data...");

        $file = $request->file('json_file');

        if(!$file->isValid() || $file->getClientOriginalExtension() != 'json') {
            return response()
                ->view('project.index', ['response' => "ERROR: The file is not valid!"], 400);
        }

        // Read File
        $jsonString = file_get_contents($file);
        $data = json_decode($jsonString, true);

        foreach ($data as $page) {

            $test_page = Page::where('file_name', $page['file_name'])->first();

            if($test_page)
                continue;
            
            $new_page = new Page();

            $new_page->set_attributes(
                $page['file_name'],
                $page['words_number'],
                $page['wrong_words']);

            foreach ($page['sentences'] as $sentence) {
                $new_sentence = new Sentence();

                $new_sentence->set_attributes(
                    $sentence['sentence'],
                    $sentence['word'],
                    $new_page->id
                );
            }
        }

        $data = array(
            "response" => "Success!",
            "pages" => (Page::count() - $pbefore),
            "sentences" => (Sentence::count() - $sbefore)
        );

        return response()
            ->view('project.index', $data, 200);
    }

    /**	
     * Upload PDF files to the project
     *	
     * @param  \Illuminate\Http\Request  $request	
     * @return \Illuminate\Http\Response	
     */	
    public function upload(Request $request)	
    {
        $request->validate([
            'png_files' => 'required',
            'png_files.*' => 'mimes:png'
        ]);

        $files = $request->file('png_files');

        foreach($files as $file)
            $file->move(public_path("pngs/"), $file->getClientOriginalName());

        $data = array(
            "response" => "Files uploaded successfully!"
        );

        return response()
            ->view('project.index', $data, 200);
    }

    /**	
     * Upload Text file to the project
     *	
     * @param  \Illuminate\Http\Request  $request	
     * @return \Illuminate\Http\Response	
     */	
    public function upload_text(Request $request)	
    {
        $request->validate([
            'text_file' => 'required',
        ]);

        $files = $request->file('text_file');

        foreach($files as $file)
            $file->move(public_path("texts/"), $file->getClientOriginalName());

        $data = array(
            "response" => "Files uploaded successfully!"
        );

        return response()
            ->view('project.index', $data, 200);
    }
}
