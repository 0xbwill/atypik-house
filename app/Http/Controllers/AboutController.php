<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use App\Models\Logement;
use App\Models\Avis;
use App\Models\User;

class AboutController extends Controller
{
    // public function edit()
    // {
    //     $about = About::firstOrCreate([], [
    //         'section1_title' => 'Séjours insolites en pleine nature',
    //         'section1_subtitle' => 'Découvrez AtypikHouse',
    //         'section1_description' => 'AtypikHouse vous propose des hébergements uniques comme des cabanes dans les arbres et des yourtes pour des expériences inoubliables en pleine nature. Vivez un séjour authentique et respectueux de l\'environnement, en France.',
    //         'section1_button_text' => 'Découvrir nos hébergements',
    //         'section1_button_link' => '/logements',
    //         'section1_image' => 'images/2yDN96bTUllI8Hd7XSPw9Ionu2JnG0jIs0fCXN1F.png',

    //         'section2_title' => 'Voyagez autrement',
    //         'section2_subtitle' => 'Explorez AtypikHouse',
    //         'section2_description' => 'Reconnectez-vous avec la nature grâce à nos cabanes perchées et yourtes. AtypikHouse, c\'est l\'alliance de l\'écologie et du confort pour un tourisme durable en France.',
    //         'section2_button_text' => 'Nous contacter',
    //         'section2_button_link' => '/contact',
    //         'section2_image' => 'images/logement_example.jpg',
    //     ]);

    //     return view('about.about-edit', compact('about'));
    // }

    // public function update(Request $request)
    // {
    //     $about = About::first();

    //     $data = $request->except('_token');

    //     if ($request->hasFile('section1_image')) {
    //         $data['section1_image'] = $request->file('section1_image')->store('images', 'public');
    //     }
    //     if ($request->hasFile('section2_image')) {
    //         $data['section2_image'] = $request->file('section2_image')->store('images', 'public');
    //     }

    //     $about->update($data);

    //     return redirect()->route('about.edit')->with('success', 'About page updated successfully.');
    // }

    public function show()
    {
        $about = About::first();

        $totalLogements = Logement::where('published', 1)->count();
        $totalUsersWithHostRole = User::role('hôte')->count();
        $totalAvis = Avis::count();
        $averageRating = Avis::avg('rating');

        return view('about.about-show', compact('about', 'totalLogements', 'totalUsersWithHostRole', 'totalAvis', 'averageRating'));
    }
}
