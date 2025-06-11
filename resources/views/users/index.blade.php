<x-user-layout>
    @section('title','Users_list')

    <style>
        table,th,td{
            border: 1px solid black;
            padding: 5px;
        }
    </style>

    <h1>List of Users</h1>
    <table>
        <tr>
            <th>Id</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Mobile_no</th>
            <th>Email_Verified_at</th>
        </tr>
        @foreach ($users as $user )
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->full_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->mobile_no }}</td>
            <td>{{ $user->email_verified_at }}</td>
        </tr>
        @endforeach


    </table>

</x-user-layout>