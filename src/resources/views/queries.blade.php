<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <section class="container my-5">
            <a class="btn btn-success" href="{{ url('/') }}">Проверить еще</a>
            <br>
            <br>

            {{ $queries->links() }}
            <table>
                <tr>
                    <th>id</th>
                    <th>address</th>
                </tr>
                @foreach ($queries as $query)
                <tr>
                    <td><a href="{{ url('/query/'.$query->id) }}">{{ $query->id }}</a></td>
                    <td>{{ substr($query->addresses, 0, 100); }}..</td>
                </tr>
                @endforeach
            </table>
        </section>
    </body>
</html>