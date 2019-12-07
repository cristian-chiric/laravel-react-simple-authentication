<p>See below the list of all clients</p>

<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
    </tr>
    @foreach($list as $client)
        <tr>
            <td>$client->name</td>
            <td>$client->email</td>
        </tr>
    @endforeach
</table>
