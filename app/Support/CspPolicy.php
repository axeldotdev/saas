<?php

namespace App\Support;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Policy;

class CspPolicy extends Policy
{
    public function configure()
    {
        if (app()->environment('local')) {
            return;
        }

        $this
            ->addGeneralDirectives()
            ->addDirectivesForCarbon()
            ->addDirectivesForGoogleFonts()
            ->addDirectivesForGoogleAnalytics()
            ->addDirectivesForGoogleTagManager()
            ->addDirectivesForYouTube();
    }

    protected function addGeneralDirectives(): self
    {
        $this
            ->addDirective(Directive::BASE, 'self')
            ->addNonceForDirective(Directive::SCRIPT)
            ->addDirective(Directive::SCRIPT, [
                'watcher.com',
                'watcher.test',
                'unsafe-eval',
            ])
            ->addDirective(Directive::STYLE, [
                'watcher.com',
                'watcher.test',
                'unsafe-inline',
            ])
            ->addDirective(Directive::FONT, [
                'watcher.com',
                'watcher.test',
                'unsafe-inline',
                'data:',
            ])
            ->addDirective(Directive::FORM_ACTION, [
                'watcher.com',
                'watcher.test',
            ])
            ->addDirective(Directive::IMG, [
                '*',
                'unsafe-inline',
                'data:',
            ])
            ->addDirective(Directive::OBJECT, 'none');

        return $this;
    }

    protected function addDirectivesForCarbon(): self
    {
        $this->addDirective(Directive::SCRIPT, [
            'srv.carbonads.net',
            'script.carbonads.com',
            'cdn.carbonads.com',
        ]);

        return $this;
    }

    protected function addDirectivesForGoogleFonts(): self
    {
        $this
            ->addDirective(Directive::FONT, 'fonts.gstatic.com')
            ->addDirective(Directive::SCRIPT, 'fonts.googleapis.com')
            ->addDirective(Directive::STYLE, 'fonts.googleapis.com');

        return $this;
    }

    protected function addDirectivesForGoogleAnalytics(): self
    {
        $this->addDirective(Directive::SCRIPT, '*.google-analytics.com');

        return $this;
    }

    protected function addDirectivesForGoogleTagManager(): self
    {
        $this->addDirective(Directive::SCRIPT, '*.googletagmanager.com');

        return $this;
    }

    protected function addDirectivesForYouTube(): self
    {
        $this->addDirective(Directive::FRAME, '*.youtube.com');

        return $this;
    }
}
