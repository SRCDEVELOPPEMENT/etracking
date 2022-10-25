
<!DOCTYPE html>
<html>
<head>
    <title></title>
            <style>
                tr{
                    border: 2px solid black;
                }
                th{
                    border: 1px solid black;
                }
                td{
                    border: 1px solid black;
                    width: 150px;
                    padding: 5px;
                }
                table {
                    border-collapse: collapse;
                }
                h1{
                  text-align:center;
                }
                .center{
                    margin-left: auto;
                    margin-right: auto;
                }
            </style>
</head>
<body>
    <h1>Liste Sites</h1>

    <table class="center">
      <thead>
            <tr>
                <th>Site</th>
                <th>Téléphone</th>
                <th>Catégorie</th>
                <th>Région</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sites as $site)
                <tr>
                    <td>{{ $site->intituleSite }}</td>
                    <td>{{ $site->telephoneSite }}</td>
                    <td>{{ $site->categorieSite }}</td>
                    <td>{{ $site->regions->intituleRegion }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Site</th>
                <th>Téléphone</th>
                <th>Catégorie</th>
                <th>Région</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>