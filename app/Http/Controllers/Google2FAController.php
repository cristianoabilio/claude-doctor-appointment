<?php

namespace App\Http\Controllers;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;

class Google2FAController extends Controller
{
    public function showSetupForm()
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        // Gera uma nova chave secreta se o usuário ainda não tiver uma
        if (! $user?->google2fa_secret) {
            $secret = $google2fa->generateSecretKey();
            $user->google2fa_secret = $secret;
            $user->save();
        } else {
            $secret = $user->google2fa_secret;
        }

        // Cria a URL interna que o QR Code representará
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        // Renderiza o QR Code inline usando BaconQrCode
        $renderer = new SvgImageBackEnd();
        $writer = new Writer(new ImageRenderer(
            new RendererStyle(200),
            $renderer
        ));
        $qrCodeSvg = $writer->writeString($qrCodeUrl);

        session(['verification_code' => $secret, 'user_id' => $user->id]);

        return view('auth.google2fa.verify-code', compact('qrCodeSvg', 'secret'));
    }

    public function enable2FA(Request $request)
    {
        $request->validate([
            'verify_code' => 'required|digits:6',
        ]);


        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        try {
            // Valida o código inserido pelo usuário
            $valid = $google2fa->verifyKey($user->google2fa_secret, $request->verify_code);

            if ($valid) {
                $google2fa->login();

                return redirect()->route('profile.edit')->with('success', '2FA ativado!');
            }

            return back()->withErrors(['verify_code' => 'Código de verificação incorreto.']);

        } catch (InvalidCharactersException $e) {
            return back()->withErrors(['verify_code' => 'Código de verificação incorreto.']);
        }
    }
}
