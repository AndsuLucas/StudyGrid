<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Section;

class ContentController extends Controller
{

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
        $contents = Content::all();
        return view('content.index', ['contents' => $contents]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $availableSections = Section::all();
        return view('content.create', ['available_sections' => $availableSections]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->only(['title', 'notes', 'links', 'Section']);
        $dataToSave['status'] = "Not started";
        $dataToSave['notes'] = $data['notes'];
        $dataToSave['Section'] = $data['Section'];
        $dataToSave['title'] = $data['title'];

        $links = explode("\n", str_replace(["\r"], '', $data['links']));

        $parsedLinks = [];
        foreach ($links as $linkData){
            if (empty($linkData)) {
                continue;
            }

            $explodedData =  explode('->', $linkData);
            
            $hasCorrectExplodedData = isset($explodedData[0]) && isset($explodedData[1]);
            if (!$hasCorrectExplodedData) {
                continue;
            }

            list($key, $value) = $explodedData;

            $parsedLinks[trim($key)] = trim($value);
        }

        $dataToSave['links'] = json_encode($parsedLinks);

        $savedContent = Content::create($dataToSave);
        if (empty($savedContent)) {
            return redirect()->action([get_called_class(), 'create']);
            
        }

        return redirect()->action([get_called_class(), 'show'], ['content' => $savedContent->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = Content::select('title', 'notes', 'links', 'status')
            ->where(['id' => $id])
            ->get()
            ->first();

        $contentData = [
            'title' => $content->title,
            'notes' => $content->notes,
            'status' => $content->status
        ];

        $decodedLinks = json_decode($content->links, true);
        if (!empty($decodedLinks)) {
            $contentData['links'] = $decodedLinks;
        }

        return view('content.show', ['content' => $contentData]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = Content::find($id);
        $contentData = [
            'id' => $content->id,
            'title' => $content->title,
            'notes' => $content->notes,
            'selected_section_id' => $content->Section,
            'links' => (function($links) {

                $parsedLinks = json_decode($links, true);
                $linkString = '';
                
                foreach ($parsedLinks as $key => $content) {
                    $linkString .= "\n" . $key . '->' . $content . "\n";
                }

                return $linkString;

            })($content->links),
            'sections' => Section::all(),
            'status' => [
                'Not started',
                'In progress',
                'Finished'
            ],
            'current_status' => $content->status
        ];
        
        return view('content.edit', ['content' => $contentData]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dataToSave = $request->only('title', 'status', 'notes', 'links', 'Section');
        $links = explode("\n", str_replace(["\r"], '', $dataToSave['links']));

        $parsedLinks = [];
        foreach ($links as $linkData){
            if (empty($linkData)) {
                continue;
            }

            $explodedData =  explode('->', $linkData);
            
            $hasCorrectExplodedData = isset($explodedData[0]) && isset($explodedData[1]);
            if (!$hasCorrectExplodedData) {
                continue;
            }

            list($key, $value) = $explodedData;

            $parsedLinks[trim($key)] = trim($value);
        }
        $dataToSave['links'] = json_encode($parsedLinks);

        Content::where(['id' => $id])
            ->update($dataToSave);

        return redirect()->action([get_called_class(), 'edit'], ['content' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content = Content::find($id);
        $content->delete();
        return redirect()->action([get_called_class(), 'index']);
    }
}
