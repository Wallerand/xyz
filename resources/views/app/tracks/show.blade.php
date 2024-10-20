<x-app :title='"Contribution n°{$track->id}"'>

    <main class="container-wide two-cols space-y-8">

        <section>
            <h1>
                Contribution <small>n°{{ $track->id }}</small>
            </h1>

            <dl>
                <dt>Artiste</dt>
                <dd>{{ $track->artist }}</dd>

                <dt>Titre</dt>
                <dd>{{ $track->title }}</dd>

                <dt>Catégorie</dt>
                <dd>
                    <a href="{{ route('app.categories.show', ['category' => $track->category->id]) }}" class="link">{{ $track->category->name }}</a>
                </dd>

                <dt>Contributeur</dt>
                <dd class="flex-center">
                    <x-avatar size="medium" :src="$track->user->avatar" /> {{ $track->user->username }}
                </dd>

                <dt>Lecteur</dt>
                <dd>
                    {!! $embed !!}
                </dd>
            </dl>
        </section>

        <div>
            <div class="block block-content space-y-8">
                <div class="title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 0 1-1.875-1.875V8.625ZM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 0 1 3 19.875v-6.75Z" />
                    </svg>
                    <div>
                        <h1>Classement</h1>
                    </div>
                </div>

                <div class="space-y-2">
                    <dl>
                        <dt>Semaine</dt>
                        <dd>{{ $week->name }}</dd>
                    </dl>

                    <dl>
                        <dt>Position</dt>
                        <dd>{{ $position }} / {{ trans_choice('tracks.count', $tracks_count) }}</dd>
                    </dl>

                    <dl>
                        <dt>Réactions</dt>
                        <dd>{{ trans_choice('tracks.likes', $track->likes_count) }}</dd>
                    </dl>

                    <form action="{{ route('app.tracks.like', ['week' => $week->uri, 'track' => $track]) }}" method="post">
                        @csrf
                        @if ($liked)
                        <button class="secondary w-full">Je n'aime pas ce titre</button>
                        @else
                        <button class="primary w-full">J'aime ce titre</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </main>

</x-app>