<x-layout>
    <div class="w-full max-w-md space-y-8">
        <div class="flex flex-col items-center text-center">
            <h1 class="text-3xl font-bold tracking-tight">Register an account</h1>
            <p class="text-muted-foreground mt-1">Start tracking your ideas today.</p>
        </div>
        <form action="{{ route('register') }}" method="post" class="space-y-4">
            @csrf

            <div class="space-y-2">
                <label for="name" class="label">Name</label>
                <input id="name" name="name" type="text" class="input" />
                @error("name")
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

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

            <div class="space-y-2">
                <label for="password_confirmation" class="label">Password Again</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="input" autocomplete="off" />
                @error("password_confirmation")
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="button h-10">Create Account</button>
        </form>
    </div>
</x-layout>
