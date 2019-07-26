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
        $result=array();
        $result['error']="";
        $result['error_code']="";
        $result['url']="";
        if(isset($request->url) && $request->url!=""){
            $url =urldecode($request->url);//Clean URL
            $url =strpos($url, 'http') !== 0 ? "http://".$url : $url;//Add http if not exist
            if ($this->validateUrlFormat($url)) {
                $slug=$this->GetShortUrl($url);

                $result['error']="";
                $result['error_code']="000";
                $result['url']=url('/'.$slug);
                echo json_encode($result); 

            }else{
                $result['error']="URL is not in a valid format.";
                $result['error_code']="002";
                echo json_encode($result); 
            }
        }else{
            $result['error']="URL is required";
            $result['error_code']="001";
            echo json_encode($result); 
        }
    }
    function validateUrlFormat($url){
        return filter_var($url, FILTER_VALIDATE_URL);
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
        $short_code = substr(md5(uniqid(rand(), true)),0,6); // 6 digit unique short id
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
            Url::where('id_url',$result->id_url)
                ->update([
                    'hits'=>$result->hits+1
                ]);
            return redirect($result->url);
        } else {
            echo 'URL not found';
        }

    }
    public function top100()
    {
        //
        $result = Url::select('id_url','url','hits')->orderBy('hits','desc')->limit(100)->get();
        if (count($result)>0) {
            foreach ($result as $key=> $row) {
                echo $row->hits.' Times - '.$row->url.'<br>';
            }
        } else {
            echo 'No URL found';
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
