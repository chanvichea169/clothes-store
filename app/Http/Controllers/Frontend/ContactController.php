<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function index(){
        return view('frontend.contact.index');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:100',
        'email' => 'required|email',
        'phone' => 'required|numeric',
        'message' => 'required',
    ]);

    // Store in Laravel Database
    $contact = new Contact();
    $contact->name = $request->name;
    $contact->email = $request->email;
    $contact->phone = $request->phone;
    $contact->message = $request->message;
    $contact->save();

    Http::withOptions([
        'verify' => false,
    ])->post('https://getform.io/f/bkkyrpgb', [
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'message' => $request->message,
    ]);


    return redirect()->route('contact.index')->with('success', 'Your message has been sent successfully.');
}
}
