<x-layout>
    <div class="w-full max-w-md space-y-8">
        <div class="flex flex-col items-center text-center">
            <h1 class="text-3xl font-bold tracking-tight">Login to your account</h1>
            <p class="text-muted-foreground mt-1">Sign in for accessing ideas.</p>
        </div>
        <form action="{{ route('login') }}" method="post" class="space-y-4">
            @csrf

            <div class="space-y-2">
                <label for="email" class="label">Email</label>
                <input id="email" name="email" type="email" class="input" autocomplete="off" />
                @error("email")
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="password" class="label">Password</label>
                <input id="password" name="password" type="password" class="input" autocomplete="off" />
                @error("password")
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="button h-10">Login !@#</button>
        </form>
    </div>
</x-layout>
