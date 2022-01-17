<?php

namespace App\Http\Livewire\Faculty;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PerformanceTask extends Component
{
    public function render(Request $request)
    {
        return view('livewire.faculty.performance-task')->extends('layouts.app');
    }
}
