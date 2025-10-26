<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div id="spinner" style="width:100px;position: absolute;top: calc(50% - 50px);left: calc(50% - 50px);">
    <img src="/public/assets/img/others/location.gif" alt="">
</div>
    <div id="table" style="max-width: 500px;margin: auto;margin-top: 50px;display:none;">
        <table class="table table-borderedbordered">
            <tbody>
                <tr>
                    <th>Your ip</th>
                    <td>{{ $array->ip }}</td>
                </tr>
                <tr>
                    <th>Country Code</th>
                    <td>{{ $array->iso_code }}</td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{ $array->country }}</td>
                </tr>
                <tr>
                    <th>City</th>
                    <td>{{ $array->city }}</td>
                </tr>
                <tr>
                    <th>State Name</th>
                    <td>{{ $array->state_name }}</td>
                </tr>
                <tr>
                    <th>Time Zone</th>
                    <td>{{ $array->timezone }}</td>
                </tr>
                <tr>
                    <th>Currency</th>
                    <td>{{ $array->currency }}</td>
                </tr>
            </tbody>
        </table>
        <hr>
        <h5 class="text-center">Mahbub Alam</h5>
    </div>
    <script>
    setTimeout(() => {
        $('#spinner').hide();
        $('#table').show();
    }, 4000);
</script>
</body>
</html>