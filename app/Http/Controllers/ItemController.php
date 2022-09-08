<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{

    private $imagePath = 'public/images/items';


    //List all items
    public function index()
    {
        $itemList = $this->listItems();
        $categories = $this->getCategories();
        return view('item-list', compact('itemList', 'categories'));
    }

    private function listItems()
    {
        //return Item::paginate(10);
        //return Item::select('items.*','categories.name as cat_name')->join('categories','categories.id','=','items.category')->paginate(10);
        return Item::with('category')->paginate(10);

    }

    private function getCategories()
    {
        return Category::all();
    }


    private function uploadImage($request)
    {
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
        try {
            $request->validate([
                'category_id' => 'required',
                'name' => 'required|string',
                'description' => 'required|string',
                'image' => 'required|mimes:jpg,jpeg,png'
            ]);
    
            $data = $request->all();
            
            $data['image'] = $this->uploadImage($request);
            Item::create($data);
    
            return redirect()->route('item.list')
            ->with('type','success')
            ->with('message', 'New Item created successfully');
          
        } catch (Exception $e) {
            return redirect()->route('item.list')
            ->with('type','error')
            ->with('message', env('APP_DEBUG') == true ? $e->getMessage() : 'Faild to create new item');
        }
    }

    //Update item
    public function update(Request $request, $id)
    {

        try {
            $request->validate([
                'category_id' => 'required',
                'name' => 'required|string',
                'description' => 'required|string',
                'image' => 'required|mimes:jpg,jpeg,png'
            ]);
    
            $item = Item::find($id);
            $item->name = $request->name;
            $item->category_id = $request->category_id;
            $item->description = $request->description;
            $item->image = $this->uploadImage($request);
            $item->isActive = 1;
    
            $item->save();
    
            return redirect()->route('item.list')
            ->with('type','success')
            ->with('message', 'Item updated successfully');

        } catch (Exception $e) {
            return redirect()->route('item.list')
            ->with('type','error')
            ->with('message', env('APP_DEBUG') == true ? $e->getMessage() : 'Faild to update item');
        }

    }

    //Delete item
    public function delete($id)
    {

        try {
            $item = Item::find($id);
            Storage::delete($this->imagePath . '/' . $item->image);
            $item->delete();
    
            return redirect()->route('item.list')
            ->with('type','success')
            ->with('message', 'Item deleted successfully');

        } catch (Exception $e) {
            return redirect()->route('item.list')
            ->with('type','error')
            ->with('message', env('APP_DEBUG') == true ? $e->getMessage() : 'Faild to delete item');
        }

    }

    //Get single item
    public function item($id)
    {
        try {
            $item = Item::where('id', $id)->first();
            echo json_encode($item);
        } catch (Exception $e) {
            echo  env('APP_DEBUG') == true ? $e->getMessage() : 'Faild to retrieve the item';
        }
    }
}
