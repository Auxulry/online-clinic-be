<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Poli\PoliResource;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PoliController extends ApiController
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $sortBy = $request->query('sortBy');
        $sortDesc = $request->query('sortDesc');
        $page = $request->query('page');
        $itemPerPage = $request->query('itemPerPage');

        $query = Poli::query();

        if ($search) {
            $query->where('name', 'LIKE', '%'.$search.'%');
        }

        if ($sortBy && $sortDesc) {
            $query->orderBy($sortBy, $sortDesc);
        } else {
            $query->orderBy('id', 'asc');
        }

        $totalItems = $query->count();

        if ($page && $page != -1) {
            $start = ($page - 1) * $itemPerPage;

            $query->skip($start)->take($itemPerPage);
        }

        $items = $query->get();

        return $this->successResponse(Response::HTTP_OK, 'Get Polis Successfully.', [
            'items' => PoliResource::collection($items),
            'totalItems' => $totalItems
        ]);
    }

    public function create(Request $request)
    {
        if (!$request->user()->is_admin) {
            return $this->errorResponse(Response::HTTP_FORBIDDEN, 'You don not have access for create poli');
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'doctor_name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['name', 'doctor_name', 'image' /* Add other attributes here */]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/poli_images', $imageName);
            $data['image'] = 'poli_images/'. $imageName;
        }

        $poli = Poli::create($data);

        return $this->successResponse(Response::HTTP_CREATED, 'Poli created successfully.', new PoliResource($poli));
    }

}
