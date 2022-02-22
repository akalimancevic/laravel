<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Racun iz biblioteke</title>

    <style>
        .center {
            display: -webkit-box;
            /* wkhtmltopdf uses this one */
            display: flex;
            -webkit-box-pack: center;
            /* wkhtmltopdf uses this one */
            justify-content: center;
        }

    </style>
</head>



<body>

    <div class="center">
        <table style="width: 70%; margin:auto;">
            <tr>
                <th style="width: 50%">Ime i prezime:</th>
                <td>{{ $rent->user->name }}</td>
            </tr>
            <tr>
                <th colspan="2">
                    <hr />
                </th>
            </tr>
            <tr>
                <th style="width: 50%">Email:</th>
                <td>{{ $rent->user->email }}</td>
            </tr>
            <tr>
                <th colspan="2">
                    <hr />
                </th>
            </tr>
            <tr>
                <th style="width: 50%">Knjiga:</th>
                <td>{{ $rent->book->title }}</td>
            </tr>
            <tr>
                <th colspan="2">
                    <hr />
                </th>
            </tr>
            <tr>
                <th style="width: 50%">Autor:</th>
                <td>{{ $rent->book->author->name }}</td>
            </tr>
            <tr>
                <th colspan="2">
                    <hr />
                </th>
            </tr>
            <tr>
                <th style="width: 50%">Cena:</th>
                <td>{{ $rent->book->price }}</td>
            </tr>
            <tr>
                <th colspan="2">
                    <hr />
                </th>
            </tr>
            <tr>
                <th style="width: 50%">Datum:</th>
                <td>{{ $rent->created_at }}</td>
            </tr>
            <tr>
                <th colspan="2">
                    <hr />
                </th>
            </tr>
            <tr>
                <th colspan="2" style="width: 50%"><img
                        src={{ 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . URL::current() }}
                        style="margin: auto" alt=""></th>
            </tr>
            <tr>
                <th colspan="2">
                    <hr />
                </th>
            </tr>
        </table>


    </div>
</body>

</html>
