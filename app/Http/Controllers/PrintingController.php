<?php

namespace App\Http\Controllers;

use App\Printing;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PrintingController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'folder' => 'required|string|max:255|unique:printings',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $printings = Printing::with('user')->orderBy("updated_at", "desc")->paginate(15);

        return view("printings.index", ["printings" => $printings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("printings.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();


        $printing = $user->printings()->save(new Printing($request->all()));
        try {
            $path = Storage::disk("public")->makeDirectory(Printing::$discPathName . "/" . $printing->folder);
            Storage::disk('public')->put(Printing::$discPathName . "/" . $printing->folder . "/logs/logs.txt", "");
        }catch (\Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
        return redirect()->route("printings.edit", $printing->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $printing = Printing::findOrFail($id);
        try {
            $documents = Storage::disk("public")->files(Printing::$discPathName . "/" . $printing->folder);
            $files = Storage::disk("local")->allFiles("files");
            $logs = Storage::disk("public")->get(Printing::$discPathName . "/" . $printing->folder . "/logs/logs.txt");
        }catch (\Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return view("printings.edit", [
            "printing" => $printing,
            "documents" => $documents,
            "files" => $files,
            "logs" => $logs
        ]);
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

        $printing = Printing::findOrFail($id);

      //  dump($request->get("document"));
       // dd($printing->folder."/text.jpg");
        try{
            Storage::copy($request->get("document"), "public/prints/".$printing->folder."/".basename($request->get("document")));
        }catch (\Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
        return redirect()->back()->with("message", "File success copied");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $printing = Printing::findOrFail($id);
        try{
            Storage::deleteDirectory("public/prints/".$printing->folder);
        }catch (\Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
       $printing->delete();

        return redirect()->back()->with("message", "Files success deleted");
    }


    public function addlog(Request $request, $id){
        $printing = Printing::findOrFail($id);

        try{
            Storage::disk('public')->put(Printing::$discPathName."/".$printing->folder."/logs/logs.txt", $request->get("logs"));
        }catch (\Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->back()->with("message", "Logs success Saved");
    }


    public function deletefile(Request $request, $id){
        $printing = Printing::findOrFail($id);

        try{

            Storage::disk('public')->delete($request->get("file"));
        }catch (\Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
        return redirect()->back()->with("message", "File success deleted");
    }
}
