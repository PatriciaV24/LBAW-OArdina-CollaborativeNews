<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\CommentNotification' => 'App\Policies\CommentNotificationPolicy',
        'App\Models\Comment' => 'App\Policies\CommentPolicy',
        'App\Models\Faq' => 'App\Policies\FaqPolicy',
        'App\Models\FollowNotification' => 'App\Policies\FollowNotificationPolicy',
        'App\Models\News' => 'App\Policies\NewsPolicy',
        'App\Models\ReportContent' => 'App\Policies\ReportContentPolicy',
        'App\Models\ReportUser' => 'App\Policies\ReportUserPolicy',
        'App\Models\Requests' => 'App\Policies\RequestsPolicy',
        'App\Models\UnbanAppeal' => 'App\Policies\UnbanAppealPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\VoteNotification' => 'App\Policies\VoteNotificationPolicy',
        'App\Models\Vote' => 'App\Policies\VotePolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
