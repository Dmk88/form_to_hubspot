@if($posts->count())
    @foreach($posts as $post)
        <article>
            <h2>{{ $post->title }}</h2>
            <p>{{ Str::limit($post->body, 50) }}</p>
            <a href='#'>Читать далее...</a>
        </article>
    @endforeach
@endif