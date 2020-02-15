<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    public function body()
    {
    	return  Body::where('doc_id',$this->id)->get();
    }

    public function bodies()
    {
        return  Body::where('doc_id',$this->id)->get();
    }

    public function headers()
    {
    	return  Header::where('doc_id',$this->id)->get();
    }

    public function messages()
    {
    	return  Message::where('doc_id',$this->id)->get();
    }

    // public function responses()
    // {
    //     $responses = [];
    //     $reses = Response::where('doc_id',$this->id)->get();
    //     foreach ($reses as $res) {
    //         $responses[$res->name] = $res->sample;
    //     }

    //     return $responses;
    // }

    public function responses()
    {
        return Response::where('doc_id',$this->id)->get();
    }

    public function paths()
    {
        return  Path::where('doc_id',$this->id)->get();
    }
}
