<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Transaction;
use App\Models\Package;
use App\Models\UserPremium;

class WebhookController extends Controller
{
    public function handler(Request $request)
    {
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        $notif = new \Midtrans\Notification();

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraudStatus = $notif->fraud_status;

        $status = '';

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challange') {
                $status = 'challange';
            } else if ($fraudStatus == 'accept') {
                $status = 'success';
            }
        } else if ($transactionStatus == 'settlement') {
            $status = 'success';
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $status = 'failure';
        } else if ($transactionStatus == 'pending') {
            $status = 'pending';
        }

        $transaction = Transaction::with('package')->where('transaction_code', $orderId)->first();
        // $package = Package::find($transaction->package_id);

        if ($status == 'success') {
            $userPremium = UserPremium::where('user_id', $transaction->user_id)->first();

            if ($userPremium) {
                # renewal subscription
                $endOfSubscription = $userPremium->end_of_subscription;
                $date = Carbon::createFromFormat('Y-m-d', $endOfSubscription);
                $newEndOfSubsctiption = $date->addDays($transaction->package->max_days)->format('Y-m-d');

                $userPremium->update([
                    'packaged_id' => $transaction->package_id,
                    'end_of_subscription' => $newEndOfSubsctiption
                ]);
            } else {
                // new subscriber
                UserPremium::create([
                    'package_id' => $transaction->package->id,
                    'user_id' => $transaction->user_id,
                    'end_of_subscription' => now()->addDays($transaction->package->max_days),
                ]);
            }
        }
        $transaction->update(['status' => $status]);
        return response()->json(null);
    }
}
