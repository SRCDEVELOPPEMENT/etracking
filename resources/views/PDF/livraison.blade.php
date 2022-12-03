
<!DOCTYPE html>
<html>
<head>
    <title></title>
            <style>
                #sous{
                    margin-bottom: 10rem;
                }
                tr{
                    border: 2px solid black;
                }
                th{
                    border: 1px solid black;
                }
                td{
                    border: 1px solid black;
                    width: 200px;
                    padding: 5px;
                }
                table {
                    border-collapse: collapse;
                    margin:auto;
                }
                h1{
                  text-align:center;
                }
            </style>
</head>
<body>
                                                            <div id="sous" style="font-size: 30px;"><span style="float:left; color:#008AD3;">SOREPCO SA</span><span style="float:right; color:#008AD3;">SOREPCO SA</span></div>
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                        <span  style="color:black; font-size: 20px;">NUMERO BON</span>
                                                                        </td>
                                                                        <td style="color:black; font-size: 20px;">
                                                                        {{ $livraison->order_number }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                        <span  style="color:black;">Date De Livraison</span>
                                                                        </td>
                                                                        <td>
                                                                        {{ $livraison->delivery_date }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>
                                                                            <span  style="color:black;">Tonnage De La Cargaison</span>
                                                                        </td>
                                                                        <td>
                                                                        {{ $livraison->tonnage }}
                                                                      </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>
                                                                            <span  style="color:black;">Frais De Livraison</span>
                                                                        </td>
                                                                        <td>
                                                                        {{ $livraison->delivery_amount }}
                                                                      </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>
                                                                        <span style="color:black;">Client</span>
                                                                        </td>
                                                                        <td>
                                                                        {{ $livraison->nom_client }} - {{ $livraison->phone_client }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span style="color:black;">Destination</span>
                                                                        </td>
                                                                        <td>
                                                                          {{ $livraison->destination }}
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span style="color:black;">Itinéraire</span>
                                                                        </td>
                                                                        <td>
                                                                          {{ $livraison->itinerary }}
                                                                      </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

</body>
</html>