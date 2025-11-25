<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\JobPosting;
use App\Models\FeaturedAlumnus;
use App\Models\Notification;
use App\Models\Gallery;
use Illuminate\Support\Str;

class LandingController extends Controller
{
    // Landing page (home)
    public function index()
    {
        // Latest 3 upcoming events
        $events = Event::latest()->take(3)->get();

        // All announcements
        $announcements = Notification::latest()->get(); 

        // Latest 3 job postings
        $careers = JobPosting::latest()->take(3)->get();

        // Latest 4 featured alumni
        $featuredAlumni = FeaturedAlumnus::latest()->take(4)->get();

        return view('landing', compact(
            'events', 
            'announcements', 
            'careers',
            'featuredAlumni'
        ));
    }

    // Public view: All events for guests
    // All events page for guests
    public function events()
    {
        $events = Event::latest()->paginate(6);
    
        // Map events to ensure proper image path
        $events->getCollection()->transform(function ($event) {
            if ($event->banner_image) {
                $bannerFile = Str::startsWith($event->banner_image, 'event-banners/')
                    ? $event->banner_image
                    : 'event-banners/' . $event->banner_image;
    
                $event->image_path = \Storage::disk('public')->exists($bannerFile)
                    ? asset('storage/' . $bannerFile)
                    : asset('images/default-banner.jpg');
            } else {
                $event->image_path = asset('images/default-banner.jpg');
            }
    
            return $event;
        });
    
        return view('events', compact('events'));
    }

    // Public view: All announcements for guests
    public function announcements()
    {
        $announcements = Notification::latest()->paginate(6);
        return view('announcements', compact('announcements'));
    }

    // Public view: All job postings for guests
    public function careers()
    {
        $careers = JobPosting::latest()->paginate(6);
        return view('careers', compact('careers'));
    }

    // Public view: Gallery page
    public function gallery()
    {
        $galleryItems = Gallery::all();
        return view('gallery', compact('galleryItems'));
    }

    // Public view: Featured Alumni page
    public function featuredAlumni()
    {
        $featuredAlumni = FeaturedAlumnus::latest()->get();
        return view('featured-alumni', compact('featuredAlumni'));
    }

    // Public view: About page
    public function about()
    {
        return view('about');
    }
}
