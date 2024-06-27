<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <section class="container my-5">
            <a class="btn btn-success" href="{{ url('/query') }}">История проверок</a>
            <a class="btn btn-success" href="{{ url('/') }}">Проверить еще</a>
            <br>
            <br>

            @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
                @php
                    Session::forget('success');
                @endphp
            </div>
            @endif
        
            <p>Номер запрса: <b>{{ $query->id }}</b><p>
            <table id="reload">
                <tr>
                    <th>ip</th>
                    <th>port</th>
                    <th>type</th>
                    <th>country</th>
                    <th>city</th>
                    <th>status</th>
                    <th>speed</th>
                    <th>timeout</th>
                    <th>externalIp</th>
                </tr>
                @foreach ($query->proxies as $proxy)
                <tr>
                    <td>{{ $proxy->ip }}</td>
                    <td>{{ $proxy->port }}</td>                    
                    <td>{{ $proxy->type ?: 'в ожидании' }}</td>
                    <td>{{ $proxy->country ?: 'в ожидании' }}</td>
                    <td>{{ $proxy->city ?: 'в ожидании' }}</td>
                    <td>{{ $proxy->status === null ? 'в ожидании' : $proxy->status }}</td>
                    <td>{{ $proxy->speed ?: 'в ожидании' }}</td>
                    <td>{{ $proxy->timeout ?: 'в ожидании' }}</td>
                    <td>{{ $proxy->externalIp ?: 'в ожидании' }}</td>
                </tr>
                @endforeach
            </table>
        </section>
    </body>
</html>

<script>

    function loadlink(){
        location.reload();
    }

    setInterval(function(){
        loadlink()
    }, 3000);

</script>
