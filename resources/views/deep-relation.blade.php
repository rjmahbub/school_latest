<table>
    <tr>
        <td>shop name</td>
        <td>Shop</td>
    </tr>

    @foreach($shops as $shop)
    <tr>
        <td>{{ $shop->name }}</td>
        <td>{{ $shop->city->country->name }}</td>
    </tr>
    @endforeach
</table>