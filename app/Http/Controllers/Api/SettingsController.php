<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Http\Resources\SettingResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $data = Setting::get();
        return $this->returnData(SettingResource::collection($data));
    }
}