<ul class="users">
    @foreach ($users as $user)
        <x-messages.users.user :user="$user" />
    @endforeach
</ul>
