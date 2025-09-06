<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Interfaces\ActiveInterface;

class ActiveInterfaceRepository implements ActiveInterface
{
    public function index()
    {
        return DB::table('sessions')
            ->whereNotNull('user_id')->where(function ($q) {
                if (request('user_id')) {
                    $q->where('user_id', request('user_id'));
                }
            })
            ->paginate(20);
    }
    public function delete($id)
    {
        DB::table('sessions')->where('id', $id)->delete();
    }
}
