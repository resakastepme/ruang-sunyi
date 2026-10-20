<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Reaction;
use Illuminate\Support\Carbon;

class SpecialNoteController extends Controller
{
    /**
     * Catatan khusus (unlisted) — satu catatan yang di-hardcode,
     * di luar linimasa publik. Dilengkapi reaksi & ruang komentar.
     */
    public function index()
    {
        // Nama penerima — hanya tampil jika SHOW_NAME=true di .env,
        // selain itu disamarkan menjadi titik-titik.
        $name = config('special-note.show_name') ? 'Raya' : '.......';
        $realname = config('special-note.show_name') ? 'Laila' : '.......';

        // Isi catatan (hardcoded). Pisah antar-paragraf dengan baris kosong;
        // baris tunggal di dalam paragraf tetap dipertahankan saat dirender.
        $letter = <<<LETTER
        halo {$name}
        sorry to reach you out like this, its like very sudden

        but i wanna talk to you about something, something that drives me crazy lately..

        I LIKE YOU

        i like your voice, such an angel voices, i like the way you talk very silky in my ears, i like your laugh, i like your behavior, and youre such an intelligence women ive ever met

        i know we have very less experience to talk for each other

        i might not known about you that much

        but this is what i felt, the actual

        in these past days, im thinking about this very often, so much stupid thoughts in my mind, so much question, overthinked it..

        and the worse case is, i oftenly changed, im become silence, like im not my self anymore, bet you realized it dont you?

        i cant hold it anymore, i feel like i have to spit it out of my tongue

        and here it is, confessing...

        but i realize something, if i take a further step into you now is considered as a dumb move you know, like i was said we even not talking that much, the point is i know you as {$name} not {$realname} and vice versa you might be know me less as well :)

        its funny how i experienced this based on anime i have watched, rent-a-girlfriend, where Kazuya think he loved Chizuru (the rented girlfriend and Chizuru is her stage name, not real name) and once Kazuya confess to Chizuru, Chizuru said "You might loved me as Chizuru, not Mizuhara" (Mizuhara is her real name)

        pretty similar right hahaha

        otherwise, i have feeling that youre out of my league, youre too smart, too wise, good in socializing, those are things that i never have.. i think you deserved someone better, i mean for real i have to upgrade myself and resolve my internal problems first before taking action to a girl..

        i still remember our first ever encounter, you join to my discord voice, asking me about international payment gateway.. man that time, i was stunned by your voice LMFAO.. i was thinking like "HOLY FUCK THERES ACTUALLY A GIRL WITH SUCH A BEAUTIFUL VOICE?" wkwkwk

        that was really dumb i swear haha, anyhow, you always be my idol, i will take you as JKT48 member(?), which i could idolizing you anytime, but of course i know my place, i know my boundaries, bcs youre like an idol to me, nothing less nothing more..


        these action might make us awkward, but dont worry ill play it cool :>

        maaf tiba tiba, maaf bikin kamu kaget
        jangan jadi beban pikiran ya

        sorry kalau kamu udah ada yg punya, tolong bilang ke partner kamu kalau aku cuma confess, ga bakal lebih, suer dah

        thats it from me, panjang bat ni kaya UUD
        makasi udah baca
        LETTER;

        // Pecah menjadi paragraf (dipisah satu/lebih baris kosong).
        $paragraphs = preg_split('/\n{2,}/', trim($letter));

        // Estimasi waktu baca — selaras rumus App\Models\Note::readingTime().
        $words       = str_word_count(strip_tags($letter));
        $readingTime = max(1, (int) ceil($words / 200));

        // Metadata catatan khusus.
        $publishedAt   = Carbon::parse('2026-10-20');
        $categoryLabel = 'Special Note';
        $tags          = ['confession', 'unsent', 'latenight'];

        // Komentar tersimpan untuk scope 'special' (terbaru dulu).
        $comments = Comment::query()
            ->where('scope', 'special')
            ->latest()
            ->get();

        // Reaksi agregat untuk scope 'special'.
        $reaction = Reaction::firstWhere('scope', 'special');

        return view('special-note.index', compact(
            'paragraphs',
            'readingTime',
            'publishedAt',
            'categoryLabel',
            'tags',
            'comments',
            'reaction',
        ));
    }
}
