<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Customer\Customer;
use App\Models\Order\Order;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Customer\CustomerRequest;

class CustomerController extends Controller
{
    public function index(){
        try {
            $customers = Customer::select('id','name', 'email', 'address', 'phone')->paginate(10);
            return Inertia::render('Customer/Index', [
                'customersList' => $customers
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'message' => 'Something went wrong',
            ]);
        }
    }

    public function save(CustomerRequest $request, $customerId = null){
        try {
            $dataToSave = array(
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone
            );
            $res = save($dataToSave, $customerId ? Customer::find($customerId) : new Customer());
            if ($res) {
                Session::flash('message', 'Customer Saved Successfully');
                return Redirect::back();
            }
            return redirect()->back()->withErrors([
                'message' => 'Something went wrong',
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'message' => 'Something went wrong',
            ]);
        }
    }

    public function delete($customerId){
        try {
            $customer = Customer::find($customerId);
            if ($customer) {
                $res = $customer->delete();
                if ($res) {
                    Session::flash('message', 'Customer Deleted Successfully');
                    return Redirect::back();
                }
                return redirect()->back()->withErrors([
                    'message' => 'Customer not deleted. Problem in deleting customer.',
                ]);
            }
            return redirect()->back()->withErrors([
                'message' => 'Customer you are trying to delete is not found',
            ]);

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'message' => 'Something went wrong',
            ]);
        }
    }


}
