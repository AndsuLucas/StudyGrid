<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Content;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
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
        $searchPattern = request()->query('search');
        $sections = empty($searchPattern) ?
            Section::join('content', 'section.id', '=', 'content.Section')
                ->select('section.*', DB::raw('count(content.id) as content_count'))
                ->groupBy('section.id')
                ->get()
            : Section::join('content', 'section.id', '=', 'content.Section')
                ->select('section.*', DB::raw('count(content.id) as content_count'))
                ->where('name', 'like', '%' . $searchPattern . '%')
                ->orWhere('content.id', 'like', '%' . $searchPattern . '%')
                ->groupBy('section.id')
                ->get();

        return view('section.index', ['sections' => $sections]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('section.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataToSave = $request->only('name');
        $savedContent = Section::create($dataToSave);
        return redirect()->action([get_called_class(), 'show'], ['section' => $savedContent->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = Section::find($id);
        $sectionData = [
            'id' => $section->id,
            'name' => $section->name,
        ];

        $contentsBindeds = Content::where(['Section' => $section->id])->get();
        if (!$contentsBindeds->isEmpty()) {
            $sectionData['contents'] = $contentsBindeds;
        }
        
        return view('section.show', ['section' => $sectionData]);
    }

    public function contents($id) 
    {
       $contents = Content::where('Section', '=', $id)
        ->get();

        return view('content.index', ['contents' => $contents]);
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
