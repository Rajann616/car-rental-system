<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the premium landing page.
     */
    public function index()
    {
        $featuredCars = Car::available()
            ->orderBy('rental_price_per_day', 'desc')
            ->take(6)
            ->get();

        $brands = Car::select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        return view('home', compact('featuredCars', 'brands'));
    }

    /**
     * Handle contact form submission and send notification to all admins.
     */
    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            $admins = \App\Models\User::where('role', 'admin')->get();
            $senderName = $request->name;
            $senderEmail = $request->email;
            $subject = $request->subject;
            $messageText = $request->message;
            $title = "New Contact Message: {$subject} 📩";
            $message = "From {$senderName} ({$senderEmail}): {$messageText}";

            foreach ($admins as $admin) {
                // Check if identical notification was sent to this admin in the last 15 seconds
                $recentDuplicate = $admin->notifications()
                    ->where('created_at', '>=', now()->subSeconds(15))
                    ->get()
                    ->contains(function ($notif) use ($title, $message) {
                        $data = $notif->data ?? [];
                        return isset($data['title'], $data['message']) 
                            && $data['title'] === $title 
                            && $data['message'] === $message;
                    });

                if (!$recentDuplicate) {
                    $admin->notify(new \App\Notifications\AdminNotification(
                        $title,
                        $message,
                        route('admin.dashboard'),
                        'fa-envelope',
                        'text-info',
                        $senderEmail
                    ));
                }
            }

            return back()->with('success', 'Thank you for reaching out! Your message has been sent to the admin team.');
        } catch (\Exception $e) {
            \Log::error('Contact form submission failed: ' . $e->getMessage());
            return back()->with('error', 'Unable to send message at this time. Please try again later.');
        }
    }
}
