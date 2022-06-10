<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Validator;
use App\Product;
use App\Category;
use App\Order;
use App\OrderTotal;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $response = array();
        $response['ordertotals'] = OrderTotal::orderBy('id', 'DESC')->paginate(10);
        return view('backend.orders.index', $response);
    }

    public function create()
    {
        $response = array();
        $response['categories'] = Category::get();
        return view('backend.orders.create', $response);
    }

    public function fetchProducts(Request $request)
    {
        $response = array();
        $products = Product::where('category_id', $request->category_id)->get();
        if (!$products->isEmpty()) {
            $option = "";
            $option .= '<option value="">Choose Product</option>';
            foreach ($products as $product) {
                $option .= '<option value="' . $product->id . '">' . $product->name . '</option>';
            }
        } else {
            $option = "";
            $option .= '<option>Choose Product</option>';
        }
        if ($option) {
            $response['options'] = $option;
            $response['message'] = 'Request successful send.';
            $response['statusCode'] = 200;
        } else {
            $response['message'] = 'Error in data saving.';
            $response['statusCode'] = 404;
        }
        return response()->json($response);
    }
    
    public function productDetail(Request $request)
    {
        $response = array();
        $product = Product::where('id', $request->product_id)->first();
        if ($product) {
            $response['product'] = $product;
            $response['message'] = 'Request successful send.';
            $response['statusCode'] = 200;
        } else {
            $response['message'] = 'Error in data saving.';
            $response['statusCode'] = 404;
        }
        return response()->json($response);
    }

    public function fetchOrderNumber()
    {
        $response = array();
        $order_total = OrderTotal::latest()->first();
        if ($order_total) {
            $response['orderNo'] = $order_total->order_number;
            $response['message'] = 'Request successful send';
            $response['statusCode'] = 200;
        } else {
            $response['message'] = 'Data not found';
            $response['statusCode'] = 404;
        }
        return response()->json($response);
    }

    public function saveOrderList(Request $request)
    {
        // dd($request->all());
        $response = array();
        $itemsList = json_decode($request->items);
        $totalCals = json_decode($request->total);

        if ($itemsList && isset($itemsList) && $totalCals && isset($totalCals)) {

            $new_order_no = 1;
            $last_order = OrderTotal::latest()->first();
            if ($last_order) {
                $new_order_no = $last_order->order_number + 1;
            }


            DB::beginTransaction();

            $orderStatus = true;
            // DB::insert();
            foreach ($itemsList as $key => $item) {
                $order = new Order;
                $order->slug = $item->slug;
                $order->order_number = $new_order_no;
                $order->category_id = $item->category_id;
                $order->product_id = $item->product_id;
                $order->product_quantity = $item->qty;
                $order->purchase_price = $item->purchase_price;
                $order->sale_price = $item->sale_price;
                $order->sub_total = $item->sub_total;
                if ($item->status == 'profit') {
                    $order->status = 'P';
                } else if ($item->status == 'loss') {
                    $order->status = 'L';
                }
                $order->expense = $item->expense;
                $order->expense_detail = $item->expense_detail;
                $order->order_date = Carbon::now()->format('Y-m-d');
                if (!$order->save()) {
                    $orderStatus = false;
                    break;
                } else if ($order->save()) {

                    $fetchProduct = Product::where('id', $item->product_id)->first();
                    if ($fetchProduct->quantity !== NULL && (int)$fetchProduct->quantity > 0) {
                        (int)$fetchProduct->quantity = (int)$fetchProduct->quantity - (int) $item->qty;
                        $fetchProduct->save();
                    }
                }
            }
            if ($orderStatus == false) {
                $response['message'] = 'Error in order saving';
                $response['statusCode'] = 404;
                DB::rollback();
                return response()->json($response);

            } else {
                $order_total = new OrderTotal;
                $order_total->slug = $totalCals->slug;
                $order_total->order_number = $new_order_no;
                $order_total->total_product_quantity = $totalCals->total_product_quantity;
                $order_total->total_purchase_price = $totalCals->total_purchase_price;
                $order_total->total_sale_price = $totalCals->total_sale_price;
                $order_total->total_sub_total = $totalCals->total_sub_total;
                if ($totalCals->sale_status == 'profit') {
                    $order_total->sale_status = 'P';
                } else if ($totalCals->sale_status == 'loss') {
                    $order_total->sale_status = 'L';
                }
                $order_total->total_expense = $totalCals->total_expense;
                $order_total->net_total = $totalCals->net_total;
                $order_total->order_date = Carbon::now()->format('Y-m-d');
                if ($order_total->save()) {
                    $response['message'] = 'Order & Order total saved';
                    $response['statusCode'] = 200;
                    DB::commit();
                } else {
                    $response['message'] = 'Error in order total saving';
                    $response['statusCode'] = 404;
                    DB::rollback();
                    return response()->json($response);
                }
            }
        } else {
            $response['message'] = 'Data not found';
            $response['statusCode'] = 404;
        }
        
        return response()->json($response);
    }

    public function deleteReport($slug)
    {
        $order_total = OrderTotal::where('slug', $slug)->first();
        if ($order_total) {

            DB::beginTransaction();

            $orders = Order::where('order_number', $order_total->order_number)->get();
            if (!$orders->isEmpty()) {
                
                $orderStatus = true;
                foreach ($orders as $key => $item) {
                    $single_item = Order::where('id', $item->id)->first();
                    if(!$single_item->delete()) {
                        $orderStatus = false;
                        break;
                    }
                }
                
                if ($orderStatus == false) {
                    DB::rollback();
                    return redirect()->back()->with(['errorMessage'=>'Error in orders deletion']);

                } else {
                    if($order_total->delete()) {
                        DB::commit();
                        return redirect()->back()->with(['successMessage'=>'Report deleted successfully']);
                    } else {
                        DB::rollback();
                        return redirect()->back()->with(['errorMessage'=>'Error in Report deletion']);
                    }
                }
            }
        } else {
            return redirect()->back()->with(['errorMessage'=>'Category not exists']);
        }
    }

    public function getOrdersList(Request $request)
    {
        $response = array();
        $table = ''; $count = 0; $sub_total_sign = ''; $report_date = '';
        $orders = Order::where('order_number', $request->order_no)->get();
        if (!$orders->isEmpty()) {

            foreach($orders as $key => $order) {
                $count = $key + 1;
                $report_date = $order->order_date;
                $expense = $order->expense=='' ? '-':$order->expense;
                $expense_detail = $order->expense_detail=='' ? '-':$order->expense_detail;
                if ($order->status == 'P') {
                    $sub_total_sign = '+';
                } else if ($order->status == 'L') {
                    $sub_total_sign = '-';
                }
                $table .= '<tr><td>'.$count.'</td>';
                $table .= '<td>'.$order->product_id.'</td>';
                $table .= '<td>'.$order->product_quantity.'</td>';
                $table .= '<td>'.$order->purchase_price.'</td>';
                $table .= '<td>'.$order->sale_price.'</td>';
                $table .= '<td class="bg-light">'.$sub_total_sign.$order->sub_total.'</td>';
                $table .= '<td>'.$order->status.'</td>';
                $table .= '<td>-'.$expense.'</td>';
                $table .= '<td>'.$expense_detail.'</td></tr>';
            }

        }
        if ($table) {
            $response['table'] = $table;
            $response['report_date'] = $report_date;
            $response['message'] = 'Request successful send';
            $response['statusCode'] = 200;
        } else {
            $response['message'] = 'Data not found';
            $response['statusCode'] = 404;
        }
        return response()->json($response);
    }

    public function searchReport(Request $request)
    {
        if ($request->from_date || $request->to_date) {

            if ($request->from_date && $request->to_date) {

                if ($request->from_date > $request->to_date) {

                    return redirect('order/search')->with(['errorMessage'=>'Enter valid dates.']);
                } else {
                    
                    $startDate = $request->from_date;
                    $endDate = $request->to_date;
                    $reports = DB::table('order_totals')->whereBetween('order_date', [$startDate, $endDate])->get();
                }

            } else if ($request->from_date) {

                $response = array();
                $reports = OrderTotal::where('order_date', $request->from_date)->orderBy('id', 'DESC')->get();

            } else if ($request->to_date) {

                return redirect('order/search')->with(['errorMessage'=>'From date is required.']);
            } 

            // fetch records //
            if(!$reports->isEmpty()) {

                $response['fromdate'] = $request->from_date;
                $response['todate'] = $request->to_date;

                $returnArr = $this->calculateTotal($reports);
                $twoArrs = array_merge($response, $returnArr);
                return view('backend.orders.search', $twoArrs);

            } else {
                return redirect('order/search')->with(['errorMessage'=>'Reports not found.']);
            }

        } else {
            return view('backend.orders.search');
        }
    }
    
    public function monthReport(Request $request)
    {
        if ($request->month) {
            $response = array();
            $date = Carbon::createFromFormat('Y-m', $request->month);

            $reports = OrderTotal::whereMonth('order_date', $date->month)->whereYear('order_date', $date->year)->orderBy('id', 'DESC')->get();

            // fetch records //
            if(!$reports->isEmpty()) {

                $response['month'] = $request->month;

                $returnArr = $this->calculateTotal($reports);
                $twoArrs = array_merge($response, $returnArr);
                return view('backend.orders.month', $twoArrs);

            } else {
                return redirect('order/month')->with(['errorMessage'=>'Reports not found.']);
            }

        } else {
            return view('backend.orders.month');
        }
    }

    public function yearReport(Request $request)
    {
        if ($request->year) {
            $response = array();

            $reports = OrderTotal::whereYear('order_date', $request->year)->orderBy('id', 'DESC')->get();

            // fetch records //
            if(!$reports->isEmpty()) {

                $response['year'] = $request->year;

                $returnArr = $this->calculateTotal($reports);
                $twoArrs = array_merge($response, $returnArr);
                return view('backend.orders.year', $twoArrs);

            } else {
                return redirect('order/year')->with(['errorMessage'=>'Reports not found.']);
            }

        } else {
            return view('backend.orders.year');
        }
    }

    public function calculateTotal($reports)
    {
        $response = array();
        $sale_status = '';
        $total_product_quantity = $total_purchase_price = $total_sale_price = $total_sub_total =  $total_expense = $gross_total = $net_total = 0;

        foreach($reports as $key => $report) {
            
            // get total quantity of products //
            if ($report->total_product_quantity && (int)$report->total_product_quantity > 0) {
                $total_product_quantity = (int)$total_product_quantity + (int)$report->total_product_quantity;
            }

            // get total purchase price of products //
            if ($report->total_purchase_price && (float)$report->total_purchase_price > 0) {
                $total_purchase_price = (float)$total_purchase_price + (float)$report->total_purchase_price;
            }

            // get total sale price of products //
            if ($report->total_sale_price && (float)$report->total_sale_price > 0) {
                $total_sale_price = (float)$total_sale_price + (float)$report->total_sale_price;
            }

            // get total expense of products //
            if ($report->total_expense && (float)$report->total_expense > 0) {
                $total_expense = (float)$total_expense + (float)$report->total_expense;
            }
        }

        if ((float)$total_sale_price > (float)$total_purchase_price) {
            $sale_status = 'P';
            $gross_total = (float)$total_sale_price - (float)$total_purchase_price;

            if ($total_expense && (float)$total_expense > 0) {
                $net_total = $gross_total - $total_expense;
            } else {
                $net_total = $gross_total;
            }

        } else if ((float)$total_purchase_price > (float)$total_sale_price) {
            $sale_status = 'L';
            $gross_total = (float)$total_purchase_price - (float)$total_sale_price;

            if ($total_expense && (float)$total_expense > 0) {
                $net_total = $gross_total + $total_expense;
            } else {
                $net_total = $gross_total;
            }
        }

        $response['total_reports'] = count($reports);
        $response['total_product_quantity'] = $total_product_quantity;
        $response['total_purchase_price'] = $total_purchase_price;
        $response['total_sale_price'] = $total_sale_price;
        $response['gross_total'] = $gross_total;
        $response['sale_status'] = $sale_status;
        $response['total_expense'] = $total_expense;
        $response['net_total'] = $net_total;

        return $response;
    }
}
