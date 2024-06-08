<?php

use App\Models\Role;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

if (!function_exists('initialize_models')) {
    function initialize_models()
    {
        return [
            'user' => new User(),
            'role' => new Role(),
        ];
    }
}

if (!function_exists('datatable')) {
    function datatable()
    {
        return [
            'datatable' => DataTables::class,
        ];
    }
}

if (!function_exists('db')) {
    function db()
    {
        return app('db');
    }
}

