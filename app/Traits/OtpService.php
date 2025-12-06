<?php

namespace App\Traits;

use App\Models\Otp;
use App\Models\User;
use App\Notifications\OneTimePassword;
use Illuminate\Validation\ValidationException;

trait OtpService
{
    private $resendInterval = 1; // in minutes
    private $validInterval = 30; // in minutes
    
    private function resend($type, $data)
    {
        $field = $type === Otp::TYPE_EMAIL ? 'email' : 'phone';
        
        $user = User::where($field, $data)->first();
        if (!$user) {
            throw ValidationException::withMessages([
                $field => [
                    'Invalid credential',
                ],
            ]);
        }

        $otp = Otp::where('type', $type)
            ->where('data', $data)
            ->first();

        if ($otp !== null) {
            if (now()->diffInSeconds($otp['created_at']) < $this->resendInterval * 60) {
                throw ValidationException::withMessages([
                    $field => [
                        'Too many attempts sending OTP. Try again later.',
                    ],
                ]);
            }

            if ($otp['created_at']->addMinutes($this->validInterval) > now()) {
                $otp['created_at'] = now();
                $otp->save();
                // Resend Previous OTP
                $this->sendOtpNotification($user, $otp['code'], $type);

                return [
                    'data' => [
                        'type' => $otp['type'],
                        $field => $otp['data'],
                    ]
                ];
            }

            $otp->delete();
        }

        $otpCode = rand(100000, 999999);

        $newOtp = new Otp;
        $newOtp['type'] = $type;
        $newOtp['data'] = $data;
        $newOtp['code'] = $otpCode;
        $newOtp->save();

        $this->sendOtpNotification($user, $newOtp['code'], $type);

        return [
            'data' => [
                'type' => $newOtp['type'],
                $field => $newOtp['data'],
            ]
        ];
    }

    private function sendOtpNotification(User $user, string $code, string $type): void
    {
        $notification = new OneTimePassword($code, $type);
        $user->notify($notification);
    }

    public function verify($type, $data, $code)
    {
        $otp = Otp::where('type', $type)
            ->where('data', $data)
            ->first();

        if (!$otp) {
            return [
                'status' => false,
                'message' => 'OTP not found. Please request a new one.',
            ];
        }

        // Check if OTP is expired
        if ($otp->created_at->addMinutes($this->validInterval) < now()) {
            $otp->delete();
            return [
                'status' => false,
                'message' => 'OTP has expired. Please request a new one.',
            ];
        }

        // Validate the OTP code
        if ((string) $otp->code !== (string) $code) {
            return [
                'status' => false,
                'message' => 'Invalid OTP code.',
            ];
        }

        $otp->verified_at = now();
        $otp->save();

        return [
            'status' => true,
            'data' => $otp->id
        ];
    }
}
