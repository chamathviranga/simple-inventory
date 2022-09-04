<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

use Illuminate\Support\Facades\Validator;

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
        return view('itemList', ['itemList' => $itemList, 'categories' => $categories]);
    }

    private function listItems()
    {
        return item::paginate(10);
    }

    private function getCategories()
    {
        return category::all();
    }

    //Add item
    public function add(Request $request)
    {

        $request->validate([
            'category' => 'required',
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image'
        ]);

        $item = new Item;
        $item->name = $request->name;
        $item->category = $request->category;
        $item->description = $request->description;
        $item->image = "null";
        $item->isActive = 1;

        $returnResponse = ['type' => 'error', 'message' => 'Faild to create new item.'];

        if ($item->save()) {
            $returnResponse['type'] = 'success';
            $returnResponse['message'] = 'New item created successfully.';

            return redirect()
                ->back()
                ->with('response', (object)$returnResponse);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('response', (object)$returnResponse);
        }
    }

    //Update item
    public function update() {
        
    }

    //Delete item
    public function delete() {

    }

    //Get single item
    public function item() {
        
    }
}
