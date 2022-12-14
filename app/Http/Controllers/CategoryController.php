<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryList = Category::paginate(10);
        return view('category-list', compact('categoryList'));
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

        try {
            $request->validate([
                'name' => 'required|min:3|max:50',
                'description' => 'required|max:255'
            ]);

            $data = $request->all();
            Category::create($data);

            return redirect()->route('categories.index')
                ->with('type', 'success')
                ->with('message', 'New Category created successfully');
        } catch (Exception $e) {
            return redirect()->route('categories.index')
                ->with('type', 'error')
                ->with('message', env('APP_DEBUG') == true ? $e->getMessage() : 'Faild to create new category');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // view only
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $category = Category::where('id', $id)->first();
            echo json_encode($category);
        } catch (Exception $e) {
            echo  env('APP_DEBUG') == true ? $e->getMessage() : 'Faild to retrieve the category';
        }
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

        try {
            $request->validate([
                'name' => 'required|min:3|max:50',
                'description' => 'required|max:255'
            ]);

            $category = Category::find($id);
            $category->name = $request->name;
            $category->description = $request->description;

            $category->save();

            return redirect()->route('categories.index')
                ->with('type', 'success')
                ->with('message', 'Category updated successfully');
        } catch (Exception $e) {
            return redirect()->route('categories.index')
                ->with('type', 'error')
                ->with('message', env('APP_DEBUG') == true ? $e->getMessage() : 'Faild to update category');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete category
        try {
            $category = Category::find($id);
            $category->delete();

            return redirect()->route('categories.index')
            ->with('type','success')
            ->with('message', 'Category deleted successfully');
        } catch (Exception $e) {
            return redirect()->route('categories.index')
            ->with('type','error')
            ->with('message', env('APP_DEBUG') == true ? $e->getMessage() : 'Faild to delete category');
        }

    }
}
