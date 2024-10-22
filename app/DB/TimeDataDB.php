<?php

namespace App\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\TimeData;
use App\Events\TimeDataCreate;

//use Illuminate\Support\Facades\Log;
//Log::debug('filter.status = ' . $filter['status']);
//Log::notice('---App\DB\Events wire-list---');

class TimeDataDB
{
    public static function wire_list($sortField, $sortDirection, $filter=null)
    {

        $timeData = TimeData::orderBy($sortField,$sortDirection);

        return $timeData;

    }

    public static function create($data)
    {
        $timeData = TimeData::create($data);
        TimeDataCreate::dispatch($timeData);
    }

}
