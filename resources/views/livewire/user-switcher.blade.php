<div>
    <label class="flex items-center gap-2 text-sm text-muted-foreground">
        <span class="hidden sm:inline">Usuario activo</span>
        <select
            wire:change="switchTo($event.target.value)"
            class="h-9 rounded-md border border-input bg-background px-3 py-1 text-sm text-foreground shadow-xs transition-colors focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/50 focus-visible:outline-none"
        >
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected($user->id === auth()->id())>{{ $user->name }}</option>
            @endforeach
        </select>
    </label>
</div>
