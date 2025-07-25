<?php

namespace App\Controllers;

class Activity extends BaseController
{
    public function index(): string
    {
        return view('activity');
    }
}
