<?php

namespace App\Providers;

use Mail;
use View;
use App\Models\User;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $unsoldProducts = Product::whereDoesntHave('orderdetails')
            ->whereDate('created_at', '<', now()->subDays(30))
            ->get();

        // Notify admins about unsold products
        foreach ($unsoldProducts as $product) {
        $admins = User::where('u_enabled', 1)->admins()->get();
            foreach ($admins as $admin) {
                // Check if a notification already exists for this product and admin
                $existingNotification = Notification::where('prod_id', $product->prod_id)
                    ->where('not_type_id', 1)
                    ->where('admin_id', $admin->id)
                    ->first();

                if (!$existingNotification) {
                    // Create a new notification
                    $notification = new Notification([
                        'not_message' => 'Product ' . $product->prod_description . ' is unsold for more than 30 days.',
                        'not_type_id' => 1,
                        'prod_id' => $product->prod_id,
                        'admin_id' => $admin->id,
                    ]);
                    $notification->save();

                    // Send an email to the admin
                    Mail::send('emails.unsold_product_notification', ['product' => $product], function ($message) use ($admin) {
                    $message
                        ->to($admin->u_email)
                        ->subject('Unsold Product Notification');
                    });
                }
            }
        }

        View::composer('layouts.navbars.navs.auth', function ($view) {
            $notifications = Notification::where('admin_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
    
            $view->with('notifications', $notifications);
        });

    }
}
