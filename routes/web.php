<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\StocksController;
use App\Mail\DatabaseBackupMail;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/













Route::get('/send-database-backup', function () {
    $date = Carbon::now()->format('d_M_y_h_i_A');
    $filename = "Backup_Adnan_Mobiles_$date.sql";
    $tables = DB::select('SHOW TABLES');
    $tableNames = array_map('current', $tables);
    $sql = '';

    foreach ($tableNames as $table) {
        $createTableQuery = DB::select("SHOW CREATE TABLE `$table`");
        $sql .= $createTableQuery[0]->{'Create Table'} . ";\n\n";
        $rows = DB::table($table)->get();
        foreach ($rows as $row) {
            $values = array_map(function ($value) {
                return DB::connection()->getPdo()->quote($value);
            }, (array) $row);

            $sql .= "INSERT INTO `$table` VALUES (" . implode(', ', $values) . ");\n";
        }
        $sql .= "\n\n";
    }
    Mail::to(['jameelhaider047@gmail.com', 'husnainbutt047@gmail.com', 'loyalfreebird@gmail.com'])
        ->send(new DatabaseBackupMail($sql, $filename));
    return redirect()->back()->with('success', 'Database backup sent to email successfully.');
})->name('send.database.backup');




Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect('/admin');
    });
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/admin');
    });


    Route::get('/export-database', function () {
        $date = Carbon::now()->format('d_M_y_h_i_A');
        $filename = "Backup_Adnan_Mobiles_$date.sql";
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);
        $sql = '';

        foreach ($tableNames as $table) {
            $createTableQuery = DB::select("SHOW CREATE TABLE `$table`");
            $sql .= $createTableQuery[0]->{'Create Table'} . ";\n\n";
            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    return DB::connection()->getPdo()->quote($value);
                }, (array) $row);

                $sql .= "INSERT INTO `$table` VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n\n";
        }

        return Response::make($sql, 200, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    })->name('export.database');








    Route::group(['prefix' => 'admin'], function () {
        Route::get('/change-password', [HomeController::class, 'changepassword'])->name("change.password");
        Route::post('/update-password', [HomeController::class, 'updatepassword'])->name("update.password");
        Route::get('/', function () {
            if (Gate::allows('is_admin')) {
                $totalrass = DB::table('stocks')
                    ->select(DB::raw('SUM(qty * sale_price) as total'))
                    ->value('total');
                //  $todaysale =1200;
                $today = Carbon::today();
                $startOfWeek = Carbon::now()->startOfWeek();
                $startOfMonth = Carbon::now()->startOfMonth();
                $endOfMonth = Carbon::now()->endOfMonth();
                $endOfWeek = Carbon::now()->endOfWeek();
                $startOfYear = Carbon::now()->startOfYear();
                $endOfYear = Carbon::now()->endOfYear();

                $todaysale = DB::table('invoice_items')
                    ->whereDate('created_at', $today)
                    ->where('status', '!=', 'Returned')
                    ->sum('total');
                     $thisweeksale = DB::table('invoice_items')
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->where('status', '!=', 'Returned')
                    ->sum('total');
                      $thismonthsale = DB::table('invoice_items')
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->where('status', '!=', 'Returned')
                    ->sum('total');
                return view('admin', compact('totalrass', 'todaysale', 'thisweeksale', 'thismonthsale'));
            } else {
                return abort(401);
            }
        })->name('admin');

        //Stocks
        Route::group(['prefix' => 'stocks'], function () {
            //CRUD
            Route::post('/submit', [StocksController::class, 'submit'])->name("submit.stock");
            Route::get('/edit/{id}', [StocksController::class, 'edit'])->name("stock.edit");
            Route::get('/create', [StocksController::class, 'create'])->name("create.stock");
            Route::post('/update/{id}', [StocksController::class, 'update'])->name("update.stock");
            Route::get('/delete/{id}', [StocksController::class, 'delete'])->name("stock.delete");
            Route::get('/', [StocksController::class, 'index'])->name("stock.index");
        });


        Route::get('/sale-history', [InvoicesController::class, 'salehistory'])->name("salehistory");
        Route::get('/return-history', [InvoicesController::class, 'returnhistory'])->name("returnhistory");


        Route::post('/return/item', [InvoicesController::class, 'returnitem'])->name("return.invoice.item");
        //Invoices
        Route::group(['prefix' => 'invoices'], function () {
            //CRUD
            Route::get('/list', [InvoicesController::class, 'index'])->name("invoices.list");
            Route::get('/make', [InvoicesController::class, 'make'])->name("invoices.make");
            Route::post('/make/save', [InvoicesController::class, 'save'])->name("invoice.store");
            Route::get('/view/{id}', [InvoicesController::class, 'view'])->name("invoice.view");
        });
    });
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
