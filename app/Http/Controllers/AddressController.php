<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Address;

class AddressController extends Controller
{
    public function store(Request $request)
    {

        $post_data = $request->validate([
            'city' =>  'string',
            'cityDistricted' =>  'string|nullable',
            'county' =>  'string|nullable',
            'houseNumber' =>  'string|nullable',
            'location.latitude' =>  'numeric|nullable',
            'location.longitude' =>  'numeric|nullable',
            'location.xyClass' =>  'integer|nullable',
            'municipality' =>  'string|nullable',
            'name' =>  'string',
            'state' =>  'string',
            'street' =>  'string|nullable',
            'street1' =>  'string|nullable',
            'streetPrefix' =>  'string|nullable',
            'streetTeryt' =>  'string|nullable',
            'uuid' =>  'string|nullable',
            'zip' =>  'string|nullable',
        ]);

        $model = new Address($post_data);
        $model->location_latitude = $post_data['location']['latitude'];
        $model->location_longitude = $post_data['location']['longitude'];
        $model->location_xyClass = $post_data['location']['xyClass'];

        $model->user_id = $request->user()->id;

        return $model->save();
    }

    public function index(Request $request)
    {
        //all-addresses-read
        //if($this->hasPermission)       
    }
}
