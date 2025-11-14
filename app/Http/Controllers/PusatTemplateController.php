<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PusatTemplateController extends Controller
{
    public function index()
    {
        return view('pusat-template.index');
    }
}