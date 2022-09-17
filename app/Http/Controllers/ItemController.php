<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{

    private $imagePath = 'public/images/items';

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

            $items = Item::with(['category'])
            ->paginate(1);

            return Response()->json($items,200);
                
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
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|mimes:jpg,jpeg,png',
        ]);

        $data = $request->all();

        $data['image'] = $this->uploadImage($request);
        Item::create($data);

        return Response()->json('New Item created',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::where('id', $id)->first();
        return Response()->json($item,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
                 
        echo json_encode($request->image);exit;

        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        $item = Item::find($id);
        $item->name = $request->name;
        $item->category_id = $request->category_id;
        $item->description = $request->description;
        if ($request->has('image')) {
            $item->image = $this->uploadImage($request);
        }

        $item->is_active = 1;

        $item->save();

        return Response()->json('Item updated',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        Storage::delete($this->imagePath . '/' . $item->image);
        $item->delete();
        return response()->json('Successfully deleted',200);
    }

    //Other requests
    public function getCategories() {
        $categories = Category::all(['id','name']);
        return response()->json($categories,200);
    }

    //Image upload
    private function uploadImage($request){
        $newImageName = "";
        if ($request->hasFile('image')) {
            $newImageName = md5(time()) . '.' . $request->image->extension();
            Storage::putFileAs($this->imagePath, $request->file('image'), $newImageName, 'public');
        }
        return $newImageName;
    }


}
