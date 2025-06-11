<x-guest-layout>

    @section('title', 'Reset Password')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Reset Password</div>
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

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Send Password Reset Link
                            </button>
                        </form>

                        <div class="mt-3">
                            <a href="{{ route('login') }}">Back to login</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>
