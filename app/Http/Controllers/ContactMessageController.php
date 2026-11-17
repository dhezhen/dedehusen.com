<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ContactMessageController extends Controller
{
    public function __invoke(Request $request): JsonResponse|RedirectResponse
    {
        if (filled($request->input('website'))) {
            return $this->success($request);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:254'],
            'topic' => ['required', 'in:Bimbingan tugas akhir,Kolaborasi penelitian,Pengabdian masyarakat,Lainnya'],
            'message' => ['required', 'string', 'min:10', 'max:6000'],
            'consent' => ['accepted'],
        ]);

        if ($validator->fails()) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Periksa kembali data yang diisi.', 'errors' => $validator->errors()], 422)
                : back()->withErrors($validator)->withInput();
        }

        $attributes = $validator->safe()->except(['consent']);
        ContactMessage::create($attributes + ['read_at' => null]);

        $notificationSent = false;
        if (config('mail.default') !== 'log') {
            try {
                Mail::raw(
                    "Nama: {$attributes['name']}\nEmail: {$attributes['email']}\nTopik: {$attributes['topic']}\n\nPesan:\n{$attributes['message']}",
                    function ($mail) use ($attributes): void {
                        $mail->to(config('mail.contact_to'))
                            ->replyTo($attributes['email'], $attributes['name'])
                            ->subject('Pesan baru dari formulir situs: '.$attributes['topic']);
                    }
                );
                $notificationSent = true;
            } catch (Throwable $error) {
                report($error);
            }
        }

        $successMessage = $notificationSent
            ? 'Pesan berhasil tersimpan dan dikirim ke email Dede Husen. Terima kasih sudah menghubungi saya.'
            : 'Pesan tersimpan di inbox situs, tetapi notifikasi email belum terkirim. Silakan coba lagi nanti atau hubungi saya melalui email.';

        return $request->expectsJson()
            ? response()->json(['message' => $successMessage, 'email_sent' => $notificationSent], 201)
            : back()->with('contact_success', $successMessage);
    }

    private function success(Request $request): JsonResponse|RedirectResponse
    {
        return $request->expectsJson()
            ? response()->json(['message' => 'Pesan diterima.'], 202)
            : back()->with('contact_success', 'Pesan diterima.');
    }
}
