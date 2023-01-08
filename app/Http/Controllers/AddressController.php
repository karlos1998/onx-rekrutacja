<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Address;
use App\Http\Resources\AddressResource;

use Symfony\Component\HttpKernel\Exception\HttpException;

use App\Events\NewAddress;

class AddressController extends Controller
{
    public function store(Request $request)
    {

        $this->authorize('create', Address::class);

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
            event(new NewAddress($model));
            return new AddressResource($model);
        }
        else
        {
            throw new HttpException(403, "Error");
        }
    }

    public function index(Request $request)
    {
        $addresses = Address::all()->where(function (Address $address) use($request) {
            return $request->user()->can('view', $address);
        });

        return AddressResource::collection($addresses);
    }

    public function delete(Request $request, Address $address)
    {
        $this->authorize('delete', $address);
        
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
            $addresses = $request->user()->addresses()->whereIn('id', $ids);
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
    
    public function update(Request $request, Address $address)
    {

        $this->authorize('update', $address);

        $post_data = $request->validate([
            'friendly_name' =>  'string|nullable',
        ]);
        
        $address->friendly_name = $post_data['friendly_name'];

        if($address->save())
        {
            return new AddressResource($address);
        }
        else
        {
            throw new HttpException(403);
        }
    }
}
