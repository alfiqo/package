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
            'customer_attribute.*' =>'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = $errors;
        } else {
            $package = Package::create($request->json()->all());
            if($package) {
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
        ], $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'packages data',
            'data'    => Package::find($id)
        ],200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
