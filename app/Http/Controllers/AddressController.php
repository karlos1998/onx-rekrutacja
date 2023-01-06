<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Address;
use App\Http\Resources\AddressResource;

use Symfony\Component\HttpKernel\Exception\HttpException;

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

        if($model->save())
        {
            return new AddressResource($model);
        }
        else
        {
            throw new HttpException(403, "Error");
        }
    }

    public function index(Request $request)
    {

        if($request->user()->hasPermission('all-addresses-read'))
        {
            $addresses = Address::all();
        }
        else if($request->user()->hasPermission('own-addresses-read'))
        {
            $addresses = $request->user()->addresses;
        }
        else
        {
            throw new HttpException(403, "You are not authorized to read any addresses");
        }

        return AddressResource::collection($addresses);
    }

    public function delete(Request $request, Address $address)
    {

        if(!$request->user()->hasPermission('all-addresses-delete'))
        {
            $request->user()->firstOrFail($address->id);
        }
        
        if($address->delete())
        {
            return response(null, 204);
        }
        else
        {
            throw new HttpException(403);
        }
    }

    public function deleteMany(Request $request)
    {
        $post_data = $request->validate([
            'ids.*' =>  'int',
        ]);

        $ids = $post_data['ids'];

        if($request->user()->hasPermission('all-addresses-delete'))
        {
            $addresses = Address::whereIn('id', $ids);
        }
        else if($request->user()->hasPermission('own-addresses-delete'))
        {
            $addresses = $request->user()->whereIn('id', $ids);
        }
        else
        {
            throw new HttpException(403);
        }
        
        if($addresses->delete())
        {
            return response(null, 204);
        }
        else
        {
            throw new HttpException(403);
        }
    }
}
