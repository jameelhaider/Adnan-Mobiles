<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Stocks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StocksController extends Controller
{

    public function copyAvailableStocks()
    {
        $stocks = Stocks::where('qty', '>', 0)
            ->orderBy('id', 'desc') // DESC order (latest first)
            ->get();

        if ($stocks->isEmpty()) {
            return response()->json([
                'text' => 'No stock available'
            ]);
        }

        $text = '';

        foreach ($stocks as $stock) {
            $text .= $stock->name
                . "        Rs. "
                . $stock->sale_price
                . "\n\n";
        }

        return response()->json([
            'text' => trim($text)
        ]);
    }




    public function index(Request $request)
    {
        if (!Gate::allows('is_admin')) {
            abort(401);
        }
        $stocks = Stocks::where('name', 'LIKE', '%' . $request->name . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(1000);
        if ($request->ajax()) {
            return view('stocks.partials.table', compact('stocks'))->render();
        }
        return view('stocks.index', compact('stocks'));
    }





    public function create()
    {
        if (!Gate::allows('is_admin')) {
            abort(401);
        }

        if (Auth::user()->email !== 'husnainbutt047@gmail.com') {
            abort(401);
        }

        $stock = new Stocks();
        return view('stocks.create', compact('stock'));
    }


    public function edit($id)
    {
        if (!Gate::allows('is_admin')) {
            return abort(401);
        }
        if (Auth::user()->email !== 'husnainbutt047@gmail.com') {
            abort(401);
        }
        $stock = Stocks::find($id);
        if (!$stock)
            return redirect()->back();
        return view("stocks.create", compact('stock'));
    }


    public function submit(Request $request)
    {
        if (Gate::allows('is_admin')) {
            $request->validate([
                'name'      => 'required|string',
                'sale_price'      => 'required|integer|min:1',
                'qty'             => 'required|integer|min:0',
                'action'          => 'nullable|in:save,save_add_new',
            ]);
            $stock = new Stocks();
            $stock->name = $request->name;
            $stock->qty = $request->qty;
            $stock->sale_price = $request->sale_price;
            $stock->save();
            if ($request->action === 'save_add_new') {
                return redirect()->back()->with('success', 'Stock Added! You can add another one.');
            }
            return redirect()->route('stock.index')->with('success', 'Stock Added Successfully!');
        } else {
            return abort(401);
        }
    }


    public function update(Request $request, $id)
    {
        if (Gate::allows('is_admin')) {
            $request->validate([
                'name'      => 'required|string',
                'sale_price'      => 'required|integer|min:1',
                'qty'             => 'required|integer|min:0',
                'action'          => 'nullable|in:save,save_add_new',
            ]);
            $stock = Stocks::find($id);
            $stock->name = $request->name;
            $stock->qty = $request->qty;
            $stock->sale_price = $request->sale_price;
            $stock->save();
            return redirect()->route('stock.index')->with('success', 'Stock updated successfully!');
        } else {
            return abort(401);
        }
    }


    public function delete($id)
    {
        if (Gate::allows('is_admin')) {
            $stock = Stocks::find($id);
            if (!is_null($stock)) {
                $stock->delete();
            }
            return redirect()->back()->with('success', 'Stock Deleted Successfully');
        } else {
            return abort(401);
        }
    }
}
