<x-guest-layout>

@section('title','Register')
    

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">

                    @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" name="firstname" id="firstname" class="form-control" value="{{ old('firstname') }}">
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ old('lastname') }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            </div>
                            <div class="mb-3">
                                <label for="mobile_no" class="form-label">Mobile No</label>
                                <input type="text" name="mobile_no" id="mobile_no" class="form-control" value="{{ old('mobile_no') }}">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" >
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>

                            <a href="{{ route('login') }}">alredy have an account?login here</a>
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