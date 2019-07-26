<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Url;

class UrlsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        echo 'klk';
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
        //
        if(isset($request->url) && $request->url!=""){
            $url=urldecode($request->url);
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                $slug=$this->GetShortUrl($url);

                    
                echo url('/'.$slug);

            }else{
                echo 'url invalida'.$url;
            }
        }else{
            echo 'url no existe';
        }
    }
    function GetShortUrl($url){
        $result = Url::where('url',$url)->get();
        if (count($result) > 0) {
            return $result[0]->short_code;
        } else {
            $short_code = $this->generateUniqueID();
            $hits=0;

            $urlData = array(
                'url' => $url, 
                'short_code' => $short_code, 
                'hits' => $hits
            );
            URL::create($urlData);
            return $short_code;
        }
    }
    function generateUniqueID(){
        $short_code = substr(md5(uniqid(rand(), true)),0,6); // creates a 6 digit unique short id
        $result = Url::where('short_code',$short_code)->get();
        if (count($result) > 0) {
            $this->generateUniqueID();
        } else {
            return $short_code;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($short_code)
    {
        //
        $result = Url::where('short_code',$short_code)->first();
        if (isset($result->url)) {
            $url=$result->url;
            header("location:".$url);
        } else {
            echo 'url no existe';
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
