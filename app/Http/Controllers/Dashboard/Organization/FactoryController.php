<?php

namespace App\Http\Controllers\Dashboard\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\Factory;
use App\Models\Organization\FactoryType;


class FactoryController extends Controller
{

    public function getAllPaginate()
    {
        $factories = Factory::paginate(15);
        //  dd($factories->all());
        return view('dashboard.factories.list')->with('factories', $factories);
    }
    public function delete(Request $request)
    {
        $request->validate([
            'factory_type_id' => 'required|exists:factories,id'
        ]);
        Factory::find($request->factory_type_id)->delete();

        return redirect()->route('factory.list');
    }

    public function getFactoryTypeById(Request $request)
    {
        $request->validate([
            'factory_type_id' => 'required|exists:factory_types,id'
        ]);
        $type = FactoryType::where('id', $request->factory_type_id)->first();
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'phone' => 'min:11',
            'address' => 'max:100',
            'factory_type_id' => 'required|exists:factory_types,id'
        ]);
        Factory::create($request->all());

        return redirect()->route('factory.list');
    }

    public function getById($id)
    {
        $factories = Factory::where('factory_type_id', $id)->get();
        return response()->json($factories, 200);
    }
    public function createPage()
    {
        $type = FactoryType::select('id', 'name')->get();
        return view('dashboard.factories.create')->with('types', $type);
    }

    public function editPage($fact_id)
    {
        $data = [];
        $data['factory'] = Factory::where('id', $fact_id)->first();
        $data['type'] = FactoryType::select('id', 'name')->get();
        // dd($data);
        return view('dashboard.factories.edit')->with('data', $data);
    }

    public function getFactoryByCuttingOrder($id)
    {
        $factory = Factory::whereHas('cuttingOrder', function ($q) use ($id) {
            $q->where('id', $id);
        })->first();

        return response()->json($factory, 200);
    }

    public function getAll()
    {
        return response()->json(Factory::select('id', 'name')->get(), 200);
    }

    public function getByType($factory_type_id)
    {
        return response()->json(Factory::where('factory_type_id', $factory_type_id)->get(), 200);
    }
}
