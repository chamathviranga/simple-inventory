<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{

    private $imagePath = 'public/images/items';


    //List all items
    public function index()
    {
        $itemList = $this->listItems();
        $categories = $this->getCategories();
        return view('item-list', ['itemList' => $itemList, 'categories' => $categories]);
    }

    private function listItems()
    {
        //return Item::paginate(10);
        //return Item::with('category')->paginate(10);
        return Item::select('items.*','categories.name as cat_name')->join('categories','categories.id','=','items.category')->paginate(10);
    }

    private function getCategories()
    {
        return Category::all();
    }


    private function uploadImage($request) {
        $newImageName = "";
        if ($request->hasFile('image')) {
            $newImageName = md5(time()) . '.' . $request->image->extension();
            Storage::putFileAs($this->imagePath, $request->file('image'), $newImageName, 'public');
        }
        return $newImageName;
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

        $data = $request->all();
        $data['image'] = $this->uploadImage($request);
        Item::create($data);

        return redirect()->route('item.list')->with('message', 'New Item created successfully');
    }

    //Update item
    public function update(Request $request,$id)
    {

        $request->validate([
            'category' => 'required',
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);

        $item = Item::find($id);
        $item->name = $request->name;
        $item->category = $request->category;
        $item->description = $request->description;
        $item->image = $this->uploadImage($request);
        $item->isActive = 1;

        $item->save();

        return redirect()->route('item.list')->with('message', 'Item updated successfully');
    }

    //Delete item
    public function delete($id)
    {
        $item = Item::find($id);
        Storage::delete($this->imagePath.'/'.$item->image);
        $item->delete();

        return redirect()->route('item.list')->with('message', 'Item deleted successfully');
    }

    //Get single item
    public function item($id)
    {
        $item = Item::where('id',$id)->first();
        echo json_encode($item);
    }
}
