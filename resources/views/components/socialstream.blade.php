<div class="flex flex-row items-center justify-between py-4 text-gray-600">
    <hr class="w-full mr-2">
    {{ __('Or') }}
    <hr class="w-full ml-2">
</div>

<div class="flex items-center justify-center">
    <a href="{{ route('oauth.redirect', ['provider' => 'apple']) }}">
        <x-socialstream-icons.apple class="h-6 w-6 mx-2" />
        <span class="sr-only">Apple</span>
    </a>

    <a href="{{ route('oauth.redirect', ['provider' => 'google']) }}">
        <x-socialstream-icons.google class="h-6 w-6 mx-2" />
        <span class="sr-only">Google</span>
    </a>

    <a href="{{ route('oauth.redirect', ['provider' => 'microsoft']) }}">
        <x-socialstream-icons.microsoft class="h-6 w-6 mx-2" />
        <span class="sr-only">Microsoft</span>
    </a>
</div>
