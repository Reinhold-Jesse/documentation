<?php

namespace Reinholdjesse\Documentation\Controllers;

use App\Http\Controllers\Controller;

class DocumentationController extends Controller
{
    public function index()
    {
        return view('documentation::docs');
    }
}
