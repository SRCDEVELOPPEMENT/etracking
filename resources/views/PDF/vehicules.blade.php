
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
    <h1>Liste Véhicules</h1>

    <table class="center">
      <thead>
            <tr>
                <th>Immatriculation</th>
                <th>Numero De Serie</th>
                <th>Model Du Vehicule</th>
                <th>Statut Du Vehicule</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicules as $vehicule)
                <tr>
                    <td>{{ $vehicule->Immatriculation }}</td>
                    <td>{{ $vehicule->NumeroSerie ? $vehicule->NumeroSerie : ''}}</td>
                    <td>{{ $vehicule->ModelVehicule }}</td>
                    <td>{{ $vehicule->StatutVehicule }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Immatriculation</th>
                <th>Numero De Serie</th>
                <th>Model Du Vehicule</th>
                <th>Statut Du Vehicule</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>