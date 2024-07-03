<?php

namespace App\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\Event;

//use Illuminate\Support\Facades\Log;
//Log::debug('filter.status = ' . $filter['status']);
//Log::notice('---App\DB\Events wire-list---');

class Events
{
    public static function wire_list($sortField, $sortDirection, $filter=null)
    {

        $events = Event::orderBy($sortField,$sortDirection);

        return $events;

    }

}
