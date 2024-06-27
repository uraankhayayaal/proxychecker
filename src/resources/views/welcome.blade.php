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
            <a class="btn btn-success" href="{{ url('/query') }}">История проверок</a>
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
        
            <!-- Way 1: Display All Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Есть ошибки:<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="/query/store">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="inputName">Адресса прокси:</label>
                    <textarea 
                        type="text" 
                        name="addresses" 
                        id="inputName"
                        class="form-control @error('addresses') is-invalid @enderror" 
                        placeholder="Адресса прокси"
                    ></textarea>
    
                    @error('addresses')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Проверить</button>
            </form>
        </section>
    </body>
</html>
