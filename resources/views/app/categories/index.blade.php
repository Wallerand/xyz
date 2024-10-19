<x-app title="Accueil">

    <main class="container-wide space-y-8">
        <section>
            <h1>Toutes les catégories</h1>

            <div class="grid">
                @foreach($categories as $category)
                <a href="{{ route('app.categories.show', ['category' => $category->id]) }}" class="block image">
                    <div class="description">
                        <div>
                            {{--  --}}
                        </div>
                        <div>
                            <h2>{{ $category->name }}</h2>
                            <h3>{{ trans_choice('tracks.count', $category->tracks_count) }}</h3>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
    </main>
</x-app>