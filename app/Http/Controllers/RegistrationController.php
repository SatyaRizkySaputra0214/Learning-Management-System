<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:registrations,email|unique:users,email',
            'no_telp' => 'required|string|max:20',
            'kursus_pilihan' => 'required|in:eng,kor,th',
            'tingkat_bahasa' => 'required|string|max:50',
            'bukti_bayar' => 'required|image|max:2048',
            'bukti_kemampuan_dasar' => [
                'nullable',
                'image',
                'max:2048',
                function ($attribute, $value, $fail) use ($request) {
                    $kursus = $request->kursus_pilihan;
                    $tingkat = $request->tingkat_bahasa;

                    $wajib = false;
                    if ($kursus === 'eng' && in_array($tingkat, ['A2', 'B1'])) $wajib = true;
                    if ($kursus === 'kor' && $tingkat === 'Intermediate') $wajib = true;
                    if ($kursus === 'th' && $tingkat === 'Intermediate') $wajib = true;

                    if ($wajib && !$request->hasFile('bukti_kemampuan_dasar')) {
                        $fail('Untuk mendaftar pada level ini, Anda wajib mengunggah bukti telah menyelesaikan atau menguasai level dasar.');
                    }
                },
            ],
        ]);

        $buktiPath = $request->file('bukti_bayar')->store('bukti_pembayaran', 'public');

        $buktiKemampuanPath = null;
        if ($request->hasFile('bukti_kemampuan_dasar')) {
            $buktiKemampuanPath = $request->file('bukti_kemampuan_dasar')->store('bukti_kemampuan_dasar', 'public');
        }

        Registration::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_telp' => $validated['no_telp'],
            'kursus_pilihan' => $validated['kursus_pilihan'],
            'tingkat_bahasa' => $validated['tingkat_bahasa'],
            'bukti_bayar_url' => $buktiPath,
            'bukti_kemampuan_dasar' => $buktiKemampuanPath,
            'status' => 'pending',
        ]);

        return redirect()->route('registration.success')->with('success', 'Pendaftaran berhasil! Tunggu verifikasi dari admin.');
    }

    public function success()
    {
        return view('auth.registration-success');
    }
}
