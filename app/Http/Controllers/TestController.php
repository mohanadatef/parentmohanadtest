<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jsonString = file_get_contents(base_path("public/DataProviderX.json"));
        $data = json_decode($jsonString, true);
        if (isset($request->provider)) {
            $data = $data[$request->provider];
            return response($data);
        }
        if(count($request->all()) > 0)
        foreach ($data as $keys => $d) {
            foreach ($d as $key => $value) {
                if (isset($request->statusCode)) {
                    if ($request->statusCode == "authorised") {
                        $code = [100, 1];
                    } elseif ($request->statusCode == "decline") {
                        $code = [200, 2];
                    } elseif ($request->statusCode == "refunded") {
                        $code = [300, 3];
                    } else {
                        $code = [0];
                    }
                    if (strpos(strtolower($key), 'status') !== false) {
                        if (!in_array($value, $code)) {
                            unset($data[$keys]);
                        }
                    }
                }
                if (isset($request->currency) && !empty($request->currency)) {
                    if (strpos(strtolower($key), 'currency') !== false) {
                        if ($value != $request->currency) {
                            unset($data[$keys]);
                        }
                    }
                }
                if (isset($request->balanceMin) && isset($request->balanceMax) && !empty($request->balanceMin) && !empty($request->balanceMax)) {
                    if (strpos(strtolower($key), 'amount') !== false || strpos(strtolower($key), 'balance') !== false) {
                        if ($value >= $request->balanceMin && $value <= $request->balanceMax) {
                            continue;
                        } else {
                            unset($data[$keys]);
                        }
                    }
                }
            }
        }
        return response($data);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
