<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FieldRequest;
use App\Models\FieldType;
use App\Models\FutsalField;
use Exception;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FieldController extends Controller
{
    public function index()
    {
        return view('admin.master.field.index');
    }
    public function create()
    {
        $fieldTypes = FieldType::get();
        return view('admin.master.field.create',compact('fieldTypes'));
    }
    public function store(Request $request)
    {
        try{
            $fieldRequest  = new FieldRequest();
            $validator = Validator::make($request->all(),$fieldRequest->rules(),$fieldRequest->messages());
            if($validator->fails()){
                $errors = $validator->errors()->messages();
                $errors = Helpers::setErrors($errors);
                return redirect()->back()->with('errors',$errors)->withInput();
            }
            $data = $validator->validated();
            FutsalField::create($data);
            return redirect(route('admin.field.index'))->withSuccess('Data lapangan berhasil ditambahkan!');
        }catch(Exception $e){
            return redirect()->back()->with('errors',$e->getMessage())->withInput();
        }
    }
}
