<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\item;
use Illuminate\Http\Request;

class AjaxControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = item::all();
        return view('list')->with('table', $table);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $item = new item;
        $item->item = $request->item;
        $item->save();
        return 'DONE';
        // return $request -> all();
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
    public function delete(Request $request)
    {
        item::where("id", $request->id)->delete();
        return $request->all;
    }
    public function aupdate(Request $request)
    {
        $item = item::find($request->id);
        $item->item = $request->item;
        $item->save();
        return $request->all();
    }
    public function search(Request $request)
    {
        $searchTerm = $request->term;
        $items = item::where('item','LIKE', '%' . $searchTerm . '%') ->get();
        if(count($items) == 0) {
            $searchResult[] = 'No Thing Found';
        } else {
            foreach($items as $item) {
                $searchResult[] = $item->item;
            }
            return $searchResult;
        }
    }
}