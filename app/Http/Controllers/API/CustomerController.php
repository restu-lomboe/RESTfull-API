<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function getData(Request $request)
    {
        $page = $request->get('page');
        $perPage = $request->get('perPage');

        $customer = Customer::get();

        $customers = $customer->map(function($customer){
            $data['id']             = $customer->id;
            $data['customer_name']  = $customer->customer_name;
            $data['customer_phone'] = $customer->customer_phone;
            $data['customer_email'] = $customer->customer_email;
            $data['address']        = $customer->address;
            return $data;
        });

        $dataCustomers = $this->paginate($customers->toArray(), $perPage, $page);

        return response()->json([
                    'title' => 'success',
                    'data'  => $dataCustomers
                ], 200);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage, $page, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
