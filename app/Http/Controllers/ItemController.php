<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        

        if($request->ajax()){

            // $item = Item::with('category')
            // ->paginate(1);
            
            // $item->getCollection()->transform(function($item){
            //     return [
            //         'id' => $item->id,
            //         'name' => $item->name,
            //         'category' => $item->category->name,
            //         'description' => $item->description,
            //         'image' => $item->image,
            //         'is_active' => (boolean)$item->is_active,
                    
            //     ];
            // });

            //return $item;

            $item = Item::with(['category'])
            ->paginate(1);

            return Response()->json($item,200);
                
        }

        return view('item-list');


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
        //
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
        // $item = Item::find($id);
        // Storage::delete($this->imagePath . '/' . $item->image);
        // $item->delete();

        return response()->json('Successfully deleted - '."$id",400);

    }
}
