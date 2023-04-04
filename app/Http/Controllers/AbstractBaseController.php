<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class AbstractBaseController extends Controller
{
    public int $parePage = 1000;
}
