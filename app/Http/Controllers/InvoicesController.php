<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InvoiceItems;
use App\Models\Invoices;
use App\Models\ReturnItems;
use App\Models\Stocks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class InvoicesController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::allows('is_admin')) {
            $query = Invoices::query()
                ->select('invoices.total_bill as total_bill', 'invoices.total_items as total_items', 'invoices.id as id', 'invoices.status as status', 'invoices.created_at as created_at');
            if ($request->date) {
                $query->whereDate('invoices.created_at', $request->date);
            }
            if ($request->invoice_no) {
                $query->where('invoices.id', $request->invoice_no);
            }
            $invoices = $query
                ->orderBy('invoices.created_at', 'desc')
                ->paginate(500);
            return view('invoices.index', compact('invoices'));
        } else {
            return abort(401);
        }
    }







    public function make(Request $request)
    {
        if (Gate::allows('is_admin')) {
            if (Auth::user()->email == 'husnainbutt047@gmail.com') {
                abort(401);
            }
            $query = Stocks::query();
            if ($request->name) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            }
            $stocks = $query
                ->orderBy('created_at', 'desc')
                ->get();
            return view('invoices.make', compact('stocks'));
        } else {
            return abort(401);
        }
    }


    public function view($id)
    {
        if (Gate::allows('is_admin')) {
            $invoice = DB::table('invoices')->where('id', $id)->first();
            $invoice_items = DB::table('invoice_items')->where('invoice_id', $id)->get();
            return view('invoices.view', compact('invoice', 'invoice_items'));
        } else {
            return abort(401);
        }
    }


    public function salehistory(Request $request)
    {
        if (!Gate::allows('is_admin')) {
            abort(403);
        }
        $query = InvoiceItems::query()
            ->where(function ($q) {
                $q->whereNull('status')
                    ->orWhere('status', '!=', 'Returned');
            });
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        $invoice_items = $query
            ->orderBy('created_at', 'desc')
            ->paginate(500);

        return view('salehistory', compact('invoice_items'));
    }


    public function returnhistory(Request $request)
    {
        if (!Gate::allows('is_admin')) {
            abort(403);
        }
        $query = ReturnItems::query();
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        $return_items = $query
            ->orderBy('created_at', 'desc')
            ->paginate(500);

        return view('returnhistory', compact('return_items'));
    }




    public function returnitem(Request $request)
    {
        if (!Gate::allows('is_admin')) {
            abort(403);
        }
        // return $request;
        $request->validate([
            'item_id'      => 'required|exists:invoice_items,id',
            'return_qty'   => 'required|numeric|min:1',
            'return_price' => 'required|numeric|min:0',
            'action'       => 'required|string',
        ]);
        $item  = InvoiceItems::findOrFail($request->item_id);
        $stock = Stocks::findOrFail($item->stock_id);
        if ($request->action === 'Return Complete Item') {
            ReturnItems::create([
                'name'    => $item->name,
                'qty'     => $request->return_qty,
                'price'   => $request->return_price,
                'total'   => $request->return_qty * $request->return_price,
                'item_id' => $item->id,
                'stock_id' => $stock->id,
            ]);
            $item->update([
                'status' => 'Returned'
            ]);
            $stock->increment('qty', $request->return_qty);
        } elseif ($request->action == 'Return Some Qty' && $item->status == 'Not Returned') {
            ReturnItems::create([
                'name'    => $item->name,
                'qty'     => $request->return_qty,
                'price'   => $request->return_price,
                'total'   => $request->return_qty * $request->return_price,
                'item_id' => $item->id,
                'stock_id' => $stock->id,
            ]);
            $item->update([
                'status' => 'Partial Returned',
                'partial_qty' => $request->return_qty
            ]);
            $stock->increment('qty', $request->return_qty);
        } else {
            $already_returned = ReturnItems::where('item_id', $item->id)->first();
            $stock->increment('qty', $request->return_qty);
            $item->increment('partial_qty', $request->return_qty);
            $already_returned->update([
                'qty'   => $already_returned->qty + $request->return_qty,
                'total' => $already_returned->total +
                    ($request->return_qty * $already_returned->price),
            ]);
        }

        return redirect()->back()->with('success', 'Item returned successfully.');
    }











    // public function save(Request $request)
    // {
    //     if (!Gate::allows('is_admin')) {
    //         return abort(401);
    //     }
    //     $request->validate([
    //         'stock_id' => 'required|array',
    //         'stock_id.*' => 'exists:stocks,id',
    //         'qty' => 'required|array',
    //         'qty.*' => 'integer|min:1',
    //         'sale_price' => 'required|array',
    //         'sale_price.*' => 'numeric|min:0',
    //     ]);
    //     $stockIds = $request->stock_id;
    //     $qtys = $request->qty;
    //     $prices = $request->sale_price;
    //     $totalBill = 0;
    //     $totalItems = count($stockIds);
    //     DB::beginTransaction();

    //     try {
    //         $invoice = Invoices::create([
    //             'total_bill' => 0,
    //             'total_items' => $totalItems,
    //             'status' => 'Paid',
    //         ]);

    //         foreach ($stockIds as $index => $stockId) {
    //             $qty = $qtys[$index];
    //             $price = $prices[$index];
    //             $total = $qty * $price;
    //             $stock = Stocks::findOrFail($stockId);
    //             $name = $stock->name;
    //             InvoiceItems::create([
    //                 'invoice_id' => $invoice->id,
    //                 'stock_id' => $stockId,
    //                 'name' => $name,
    //                 'qty' => $qty,
    //                 'price' => $price,
    //                 'total' => $total,
    //             ]);
    //             if ($stock->qty >= $qty) {
    //                 $stock->decrement('qty', $qty);
    //             } else {
    //                 throw new \Exception("Not enough stock for item: {$name}");
    //             }

    //             $totalBill += $total;
    //         }
    //         $invoice->update([
    //             'total_bill' => $totalBill,
    //         ]);
    //         DB::commit();
    //         return redirect()->route('invoice.view', ['id' => $invoice->id])->with('success', 'Invoice created successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
    //     }
    // }

    public function save(Request $request)
    {
        if (!Gate::allows('is_admin')) {
            abort(401);
        }

        $request->validate([
            'stock_id' => 'required|array',
            'stock_id.*' => 'required|exists:stocks,id',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'sale_price' => 'required|array',
            'sale_price.*' => 'required|numeric|min:0',
        ]);

        $stockIds = $request->stock_id;
        $qtys = $request->qty;
        $prices = $request->sale_price;

        // ✅ Ensure all arrays match
        if (count($stockIds) !== count($qtys) || count($stockIds) !== count($prices)) {
            return back()->withErrors('Invalid input: mismatch between items, quantities, and prices.');
        }

        DB::beginTransaction();

        try {
            $totalBill = 0;
            $itemsData = [];

            // 🔒 Lock all stocks first (prevents race conditions)
            $stocks = Stocks::whereIn('id', $stockIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // ❌ Check missing stocks
            foreach ($stockIds as $stockId) {
                if (!isset($stocks[$stockId])) {
                    throw new \Exception("Stock not found for ID: {$stockId}");
                }
            }

            // ✅ Validate all items BEFORE writing anything
            foreach ($stockIds as $index => $stockId) {
                $qty = (int) $qtys[$index];
                $price = (float) $prices[$index];

                $stock = $stocks[$stockId];

                if ($stock->qty < $qty) {
                    throw new \Exception("Not enough stock for item: {$stock->name}");
                }

                $total = $qty * $price;

                $itemsData[] = [
                    'stock' => $stock,
                    'stock_id' => $stockId,
                    'name' => $stock->name,
                    'qty' => $qty,
                    'price' => $price,
                    'total' => $total,
                ];

                $totalBill += $total;
            }

            // ❌ Prevent empty invoice
            if ($totalBill <= 0) {
                throw new \Exception("Invoice total must be greater than zero.");
            }

            // ✅ Now create invoice AFTER validation
            $invoice = Invoices::create([
                'total_bill' => $totalBill,
                'total_items' => count($itemsData),
                'status' => 'Paid',
            ]);

            // ✅ Insert items & update stock
            foreach ($itemsData as $item) {
                InvoiceItems::create([
                    'invoice_id' => $invoice->id,
                    'stock_id' => $item['stock_id'],
                    'name' => $item['name'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'total' => $item['total'],
                ]);

                // Deduct stock safely
                $item['stock']->decrement('qty', $item['qty']);
            }

            DB::commit();

            return redirect()
                ->route('invoice.view', ['id' => $invoice->id])
                ->with('success', 'Invoice created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors('Error: ' . $e->getMessage());
        }
    }
}
