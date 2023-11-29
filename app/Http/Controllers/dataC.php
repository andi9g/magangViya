<?php

namespace App\Http\Controllers;

use App\Models\dataM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class dataC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;
        $data = dataM::orderBy("iddata", "desc")->where("nama", "like", "%$keyword%")
        ->paginate(15);

        $data->appends($request->only(["limit", "keyword"]));

        return view("pages.data", [
            "keyword" => $keyword,
            "data" => $data,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unduh(Request $request, $iddata)
    {
        $data = dataM::where("iddata", $iddata)->first();
        $nama = $data->nama;
        $namadata = $data->namadata;
        $format = $data->format;
        // dd($namadata);
        $url = public_path("/gambar/").$namadata;

        return response()->download($url, $nama.".".$format);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "data" => 'required',
            "namadata" => 'required',
        ]);

        if ($request->hasFile("data")) {
            $file = $request->data;
            // dd($file);
            $name = $file->getClientOriginalName();
            $ukuran = $file->getSize();
            $ex = $file->getClientOriginalExtension();
            $name = strtotime(date("Y-m-d H:i:s"))."_".uniqid().".".$ex;

            $format = strtolower($ex);
            if($ukuran < 30000000) {
                if($format == "avi" || $format == "mp4" || $format == "mkv" || $format == "mov") {
                    $file->move(public_path("/gambar"), $name);
                    
                    $tambah = new dataM;
                    $tambah->nama = $request->namadata;
                    $tambah->namadata = $name;
                    $tambah->tanggaldata = date("Y-m-d");
                    $tambah->ukuran = $ukuran;
                    $tambah->format = $ex;
                    $tambah->save();

                    return redirect()->back()->with("success", "data berhasil ditambahkan")->withInput();

                } 
            }

            return redirect()->back()->with("error", "Data tiak sesuai")->withInput();
        }else {
            return redirect()->back()->with("maaf data tidak ditemukan")->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\dataM  $dataM
     * @return \Illuminate\Http\Response
     */
    public function show(dataM $dataM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dataM  $dataM
     * @return \Illuminate\Http\Response
     */
    public function edit(dataM $dataM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\dataM  $dataM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dataM $dataM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dataM  $dataM
     * @return \Illuminate\Http\Response
     */
    public function destroy(dataM $dataM, $iddata)
    {
        dataM::destroy($iddata);
        
        return redirect()->back()->with("success", "data berhasil dihapus")->withInput();
    }
}
