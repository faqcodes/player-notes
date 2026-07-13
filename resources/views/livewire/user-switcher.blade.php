<div>
    <label>
        Usuario activo:
        <select wire:change="switchTo($event.target.value)">
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected($user->id === auth()->id())>{{ $user->name }}</option>
            @endforeach
        </select>
    </label>
</div>
