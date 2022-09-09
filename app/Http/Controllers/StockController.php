<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Stock;
use App\Models\Item;
use Exception;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stockList = Stock::select('stocks.*','items.name')->join('items','items.id','=','stocks.item_id')->paginate(10);
        return view('stock',compact('stockList'));
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
            // $request->validate([
            //     'item_id' => 'required',
            //     'qty' => 'require|integer'
            // ]);
    
            $data = $request->all();
            $data['item_id'] = explode(':',$request->item_id)[0];
            Stock::create($data);
           
            return redirect()->route('stock.index')
            ->with('type','success')
            ->with('message', 'Item added to the stock');

        } catch (Exception $e) {
            return redirect()->route('stock.index')
            ->with('type','error')
            ->with('message', env('APP_DEBUG') == true ? $e->getMessage() : 'Item added to the stock');
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
        //view only
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
            
            $stock = Stock::where('id',$id)->with('item')->first();
            echo json_encode($stock);

        } catch (Exception $e) {
            echo  env('APP_DEBUG') == true ? $e->getMessage() : 'Faild to retrieve the stock';
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
                'qty' => 'required|integer'
            ]);
    
            $stock = Stock::find($id);
            $stock->qty = $request->qty;
            $stock->save();
           
            return redirect()->route('stock.index')
            ->with('type','success')
            ->with('message', 'Stock updated');

        } catch (Exception $e) {
            return redirect()->route('stock.index')
            ->with('type','error')
            ->with('message', env('APP_DEBUG') == true ? $e->getMessage() : 'Faild to update the stock');
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
        try {
            $stock = Stock::find($id);
            $stock->delete();

            return redirect()->route('stock.index')
            ->with('type','success')
            ->with('message', 'Item removed from the stock');
        } catch (Exception $e) {
            return redirect()->route('stock.index')
            ->with('type','error')
            ->with('message', env('APP_DEBUG') == true ? $e->getMessage() : 'Faild to remove item from stock');
        }
    }

    public function searchItem(Request $request) {

        $request->validate([
            'search' => 'required|String'
        ]);

        $items = Item::select('id','name')->where('name','like',$request->search.'%')->where('is_active',1)
        ->get();

         echo json_encode($items);
    }
}
