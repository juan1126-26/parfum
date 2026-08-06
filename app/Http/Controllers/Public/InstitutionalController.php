<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class InstitutionalController extends Controller
{
    public function about(): View
    {
        return view('public.about', [
            'activeRoute' => 'about',
            'content' => config('parfum.institutional.about'),
            'title' => 'Nosotros',
            'description' => config('parfum.institutional.about.hero.description'),
            'canonical' => route('about'),
        ]);
    }

    public function contact(): View
    {
        return view('public.contact', [
            'activeRoute' => 'contact',
            'content' => config('parfum.institutional.contact'),
            'contact' => config('parfum.contact'),
            'socials' => config('parfum.socials'),
            'instagramPosts' => config('parfum.instagram_posts'),
            'title' => 'Contacto',
            'description' => config('parfum.institutional.contact.hero.description'),
            'canonical' => route('contact'),
        ]);
    }
}
