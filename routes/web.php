<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {
    return view('home');
});

// Index
Route::get('/jobs', function () {
    $job = job::with('employer')->latest()->simplePaginate(3);
    return view('jobs.index', [
        'jobs'=> $job
    ]);
});

// Create
Route::get('/jobs/create', function ()
{
    return view ('jobs.create');
});

// Show
Route::get('/jobs/{id}', function ($id) {
    $job = Job::find($id);

    return view ('jobs.show', ['job' => $job] );
});

// Store
Route::post('/jobs', function(){

    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);

    Job::create([
        'title'=> request('title'),
        'salary'=> request('salary'),
        'employer_id'=> 1
    ]);

    return redirect('/jobs');
});

// Edit
Route::get('/jobs/{id}/edit', function ($id) {
    $job = Job::find($id);

    return view ('jobs.edit', ['job' => $job] );
});

// Update
Route::patch('/jobs/{id}', function ($id) {
    //Validate
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);
    //Authorize (On hold)

    //update the job (Laravel route model binding - Forma automatica de atualizar no banco)
    $job = Job::findOrFail($id); // null

    $job->update([
        'title'=>request('title'),
        'salary'=>request('salary')
    ]);

    //redirect to the job page
    return redirect('/jobs/' . $job->id);
});

// Destroy
Route::delete('/jobs/{id}', function ($id) {
    // authorize (on hold)

    // delete the job
    Job::findOrFail($id)->delete();

    // redirect
    return redirect('/jobs');

});

Route::get('/contact', function () {
    return view ('contact');
});