<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\checkScheduleRequest;
use Carbon\Carbon;
use Exception;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function checkSchedule()
    {
        $request = new checkScheduleRequest();
        $validator = Validator::make(request()->all(), $request->rules(), $request->messages());
        if ($validator->fails()) {
            $errors = Helpers::setErrors($validator->errors()->messages());
            return response()->json(['success' => false, 'error' => true, 'message' => $errors]);
        }
        try {
            $validated = $validator->validated();
            $diff = (new Carbon($validated['start_at']))->diff($validated['end_at']);
            if ($diff->invert > 0) {
                return response()->json(['success' => false, 'error' => true, 'message' => 'Mohon periksa jam mulai dan selesai!']);
            }
            if ($diff->h > 0 && $diff->i == 0) {
                $data = base64_encode(json_encode($validated));
                return response()->json(['success' => true, 'message' => 'Jadwal Tersedia!', 'data' => $data]);
            }
            return response()->json(['success' => false, 'message' => 'Jadwal tidak tersedia!']);
        } catch (Exception $e) {
        }
    }
}
