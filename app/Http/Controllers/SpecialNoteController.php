<?php

namespace App\Http\Controllers;

use App\Models\Comment;
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

        in these past days, im thinking about you very often, so much stupid thoughts in my mind, so much question, overthinked it..

        and the worse case is, i oftenly changed, im become silence, like im not my self anymore, bet you realized it dont you?

        i cant hold it anymore, i feel like i have to spit it out of my tongue

        and here it is


        these action might make us awkward, but dont worry ill play it cool :>

        maaf tiba tiba, maaf bikin kamu kaget
        jangan jadi beban pikiran ya

        sorry kalau kamu udah ada yg punya, tolong bilang ke partner kamu kalau aku cuma confess, ga bakal lebih, suer dah

        thats it from me, panjang bat ni chat kaya UUD
        makasi udah baca
        LETTER;

        // Pecah menjadi paragraf (dipisah satu/lebih baris kosong).
        $paragraphs = preg_split('/\n{2,}/', trim($letter));

        // Estimasi waktu baca — selaras rumus App\Models\Note::readingTime().
        $words       = str_word_count(strip_tags($letter));
        $readingTime = max(1, (int) ceil($words / 200));

        // Metadata catatan khusus.
        $publishedAt   = Carbon::parse('2026-10-01');
        $categoryLabel = 'Special Note';
        $tags          = ['confession', 'unsent', 'latenight'];

        // Komentar tersimpan untuk scope 'special' (terbaru dulu).
        $comments = Comment::query()
            ->where('scope', 'special')
            ->latest()
            ->get();

        return view('special-note.index', compact(
            'paragraphs',
            'readingTime',
            'publishedAt',
            'categoryLabel',
            'tags',
            'comments',
        ));
    }
}
