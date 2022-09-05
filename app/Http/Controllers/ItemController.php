<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    //List all items
    public function index()
    {
        $itemList = $this->listItems();
        $categories = $this->getCategories();
        return view('item-list', ['itemList' => $itemList, 'categories' => $categories]);
    }

    private function listItems()
    {
        return Item::paginate(10);
    }

    private function getCategories()
    {
        return Category::all();
    }

    //Add item
    public function add(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);

        
        if($request->hasFile('image')){
            $newImageName = md5(time()).'.'.$request->image->extension();
            $destination_path = 'storage/images/items';
         //storage/folder/image.png   
            
        }
                    
    
        $data = $request->all();
        //$data['image'] = "";    
        Item::create($data);

        return redirect()->route('item.list')->with('message', 'New Item created successfully');

    }

    //Update item
    public function update(Request $request)
    {
        $item = new Item();
        $item->name = $request->name;
        $item->category = $request->category;
        $item->description = $request->description;
        $item->image = "null";
        $item->isActive = 1;
    }

    //Delete item
    public function delete()
    {
    }

    //Get single item
    public function item()
    {
    }
}
