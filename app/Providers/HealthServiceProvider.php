<?php

namespace App\Providers;

use App\Models\User;
use Encodia\Health\Checks\EnvVars;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck;
use Spatie\Health\Checks\Checks\DatabaseSizeCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\HorizonCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\QueueCheck;
use Spatie\Health\Checks\Checks\RedisCheck;
use Spatie\Health\Checks\Checks\RedisMemoryUsageCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;

class HealthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('viewHealth', function (User $user) {
            return in_array($user->email, [
                'axelcharpentier0@icloud.com',
            ]);
        });

        Health::checks([
            CpuLoadCheck::new()
                ->failWhenLoadIsHigherInTheLast5Minutes(2.0)
                ->failWhenLoadIsHigherInTheLast15Minutes(1.5),
            UsedDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(60)
                ->failWhenUsedSpaceIsAbovePercentage(80),

            DatabaseCheck::new(),
            DatabaseConnectionCountCheck::new()
                ->warnWhenMoreConnectionsThan(50)
                ->failWhenMoreConnectionsThan(100),
            DatabaseSizeCheck::new()
                ->failWhenSizeAboveGb(errorThresholdGb: 5.0),

            QueueCheck::new(),
            RedisCheck::new(),
            RedisMemoryUsageCheck::new()
                ->failWhenAboveMb(1000),
            HorizonCheck::new(),

            CacheCheck::new(),
            OptimizedAppCheck::new(),

            DebugModeCheck::new(),
            EnvironmentCheck::new(),

            ScheduleCheck::new(),

            EnvVars::new()
                ->requireVars([
                    'APPLE_CLIENT_ID',
                    'APPLE_CLIENT_SECRET',
                    'GOOGLE_CLIENT_ID',
                    'GOOGLE_CLIENT_SECRET',
                    'MICROSOFT_CLIENT_ID',
                    'MICROSOFT_CLIENT_SECRET',
                    'GOOGLE_TAG_MANAGER_ID',
                ]),

            SecurityAdvisoriesCheck::new(),
        ]);
    }
}
