<!DOCTPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <title>View Student Records</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body>
        <table>
            <tr>
                <td>Id</td>
            </tr>
            @foreach ($posts as $post)
            <tr>
                <td>{{ $post->post_content }}</td>
            </tr>
            @endforeach
        </table>
    </body>

    </html>