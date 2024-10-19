<x-app title="Contribuer">

    <main class="container-wide space-y-8">
        <section>
            <h1>
                Contribuer <small>{{ $week->name }}</small>
            </h1>

            @can('create', App\Models\Track::class)
            <form method="post" action="{{ route('app.tracks.store') }}" class="track-form space-y-4">
                <div>
                    <label for="title">Titre</label>
                    <input name="title" id="title" class="w-large" type="text" value="{{ old('title') }}" placeholder="nom du titre" autocomplete="off" autofocus>
                </div>

                @error('title')
                <p class="error-message">{{ $message }}</p>
                @enderror

                <div>
                    <label for="artist">Artiste</label>
                    <input name="artist" id="artist" class="w-medium" type="text" value="{{ old('artist') }}" placeholder="nom de l'artiste" autocomplete="off">
                </div>

                @error('artist')
                <p class="error-message">{{ $message }}</p>
                @enderror

                <div>
                    <label for="url">Lien d'écoute</label>
                    <input name="url" id="url" class="w-medium" type="text" value="{{ old('url') }}" placeholder="lien youtube ou soundcloud" autocomplete="off">
                </div>

                @error('url')
                <p class="error-message">{{ $message }}</p>
                @enderror

                <div>
                    <label for="category_id">Catégorie</label>
                    <select name="category_id" id="category_id">
                        <option value="" selected disabled>Sélectionner une catégorie</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                @error('category_id')
                <p class="error-message">{{ $message }}</p>
                @enderror

                <div class="submit">
                    @csrf
                    <button type="submit" class="primary">Envoyer</button>
                    <div>{{ trans_choice('tracks.remaining', $remaining_tracks_count) }}</div>
                </div>
            </form>
            @else
            <div>
                <p>Vous ne pouvez plus contribuer pour cette semaine.</p>
            </div>
            @endcan
        </section>
    </main>

</x-app>