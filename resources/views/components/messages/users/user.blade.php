<li class="user" id="user-{{ $user->id }}">

    <span class="pending {{ $user->sentMessages->count() == 0 ? 'hidden' : '' }}">
        {{ $user->sentMessages->count() }}
    </span>

    <div class="media">
        <div class="media-left">
            <img src="{{ $user->image }}" alt="user-image" class="media-object">
        </div>

        <div class="media-body">
            <p class="name">{{ $user->name }}</p>
            <p class="email">{{ $user->email }}</p>
        </div>
    </div>
</li>
