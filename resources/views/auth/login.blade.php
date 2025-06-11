<x-guest-layout>

    @section('title','Login')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">

                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('auth_login') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            </div>
                            <div class="mb-3">

                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>

                            <a href="{{ route('register') }}">not having account?register here</a>

                        </form>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                document.getElementById("email").setAttribute("autocomplete", "off");
                                document.getElementById("password").setAttribute("autocomplete", "new-password");
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>