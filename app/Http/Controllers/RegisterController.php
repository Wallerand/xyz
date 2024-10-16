<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Code;
use App\Services\CodeService;
use App\Mail\SendInvitationCodes;
use App\Exceptions\RegistrationFailedException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Terms form.
     */
    public function terms(Code $code): View
    {
        return view('auth.signup-terms', [
            'code' => $code,
            'host' => $code->host->loadCount('tracks')
        ]);
    }

    /**
     * Account form.
     */
    public function account(Request $request, Code $code): View
    {
        $request->validate([
            'terms' => 'accepted',
        ]);

        return view('auth.signup-account', [
            'code' => $code,
            'host' => $code->host->loadCount('tracks')
        ]);
    }

    /**
     * Handle account form.
     *
     * @throws RegistrationFailedException
     */
    public function register(Request $request, Code $code, CodeService $codeService): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:4'],
        ]);

        // Using a transaction here ensures all registration steps
        // are correctly executed (ex. code collision/unique constraint failure).
        DB::beginTransaction();

        try {
            // Create user
            $user = new User($validated);
            $user->save();

            // Make code as consumed
            $codeService->markAsConsumed($request->string('code'), $user);

            // Generate user codes
            $codes = $user->codes()->saveMany(
                $codeService->generate(config('app.codes_count'))
            );

            // Send welcome email
            Mail::to($user)->send(new SendInvitationCodes($codes));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            // Rendering of this custom exception is defined within the exception itself
            throw new RegistrationFailedException(previous: $th);
        }

        // Manually login the user
        Auth::loginUsingId($user->id);

        // Generate a new session identifier
        $request->session()->regenerate();

        return redirect()->route('app.home');
    }
}
