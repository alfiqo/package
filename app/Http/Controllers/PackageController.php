<?php

namespace App\Http\Controllers;

use App\Http\Resources\PackageCollection;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        return new PackageCollection($packages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = "error";
        $message = "";
        $code = 500;

        $validator = Validator::make($request->json()->all(), [
            'transaction_id' => 'required|unique:packages',
            'customer_name' => 'required|max:50',
            'customer_code' => 'required|min:5',
            'transaction_order' => 'required|numeric|digits:3',
            'customer_attribute.*' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = $errors;
        } else {
            $package = Package::create($request->json()->all());
            if ($package) {
                $status = "success";
                $message = "insert successfully";
                $code = 200;
            } else {
                $message = 'insert failed';
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $package
        ], $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'packages data',
            'data'    => $package
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $status = "error";
        $message = "";
        $code = 500;

        $validator = Validator::make($request->json()->all(), [
            'transaction_id' => 'required|unique:packages,transaction_id,' . $request->json()->get('transaction_id') . ',transaction_id',
            'customer_name' => 'required|max:50',
            'customer_code' => 'required|min:5',
            'transaction_order' => 'required|numeric|digits:3',
            'customer_attribute.*' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = $errors;
        } else {
            $data = $request->json()->all();
            unset($data['_id']);
            unset($data['transaction_id']);
            
            if ($request->method() === "PUT") {
                $package->update($data);
            } else {
                $package->fill($data);
                $package->save();
            }

            if ($package) {
                $status = "success";
                $message = "update successfully";
                $code = 200;
            } else {
                $status = "error";
                $message = "update failed";
                $code = 409;
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $package
        ], $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $status = "error";
        $message = "delete failed";
        $code = 409;

        if ($package->delete()) {
            $status = "success";
            $message = "delete successfuly";
            $code = 200;
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ], $code);
    }
}
