<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    {{ dd($posts) }}
    @foreach ($posts as $post)
        @if ($post->status == 1)
            <h3>{{ $post->title }}</h3>
            <small>{{ $post->date }}</small> <span>{{ $post->author }}</span>
            <div>
                <p>{{ $post->body }}</p>
            </div>
        @endif
    @endforeach


    <div>
        <form action="/external" method="POST">
            <label for="title">title</label>
            <input type="text" name="title">

            <br>

            <label for="url">Url</label>
            <input type="text" name="url">

            <button type="submit">Suggest</button>
        </form>
    </div>
</body>

</html>
