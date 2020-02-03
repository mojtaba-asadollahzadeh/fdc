<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    public function body()
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
}
