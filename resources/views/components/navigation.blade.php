<nav class="container-wide">
    <ul>
        <li @class(['current' => request()->routeIs('app.home')])>
            <a href="{{ route('app.home') }}"><span class="logo"><h1>XYZ</h1></span></a>
        </li>

        @auth
        <li @class(['current' => request()->routeIs('app.weeks.*', 'app.tracks.show')])>
            @if (request()->routeIs('app.tracks.show'))
            <a href="{{ route('app.weeks.show', ['week' => $week->uri]) }}">Classement</a>
            @else
            <a href="{{ route('app.weeks.index') }}">Classement</a>
            @endif
        </li>
        <li @class(['current' => request()->routeIs('app.tracks.create')])>
            <a href="{{ route('app.tracks.create') }}">+ Contribuer</a>
        </li>
        @endauth
    </ul>

    @auth
    <ul class="nav-right">
        <li @class(['current' => request()->routeIs('app.profile.*')])>
            <a href="{{ route('app.profile.edit') }}">Profil</a>
        </li>
        <li>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit">Se déconnecter</button>
            </form>
        </li>
    </ul>
    @endauth
</nav>