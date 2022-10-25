
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
                                                                        <span  style="color:black; font-size: 20px;">CODE</span>
                                                                        </td>
                                                                        <td style="color:black; font-size: 20px;">
                                                                        {{ $courrier->code }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                        <span  style="color:black;">Type De Courrier</span>
                                                                        </td>
                                                                        <td>
                                                                        {{ $courrier->TypeCourrier }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>
                                                                            <span  style="color:black;">Type D'Envoie</span>
                                                                        </td>
                                                                        <td>
                                                                        {{ $courrier->TypeEnvoie }}
                                                                      </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>
                                                                            <span  style="color:black;">Objet</span>
                                                                        </td>
                                                                        <td>
                                                                        {{ $courrier->objet }}
                                                                      </td>
                                                                    </tr>

                                                                    @if($destinateur)
                                                                    <tr>
                                                                        <td>
                                                                        <span style="color:black;">Destinateur Courrier</span>
                                                                        </td>
                                                                        <td>
                                                                        {{ $destinateur }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                        <span style="color:black;">Téléphone Destinateur</span>
                                                                        </td>
                                                                        <td>
                                                                        {{ $phone_destinateur }}
                                                                        </td>
                                                                    </tr>
                                                                    @endif

                                                                    <tr>
                                                                        <td>
                                                                        <span style="color:black;">Expéditeur Courrier</span>
                                                                        </td>
                                                                        <td>
                                                                        {{ $expediteur }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span style="color:black;">Téléphone Expéditeur Courrier</span>
                                                                        </td>
                                                                        <td>
                                                                          {{ $telephone_expediteur }}
                                                                      </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>
                                                                            <span style="color:black;">Récepteur Courrier</span>
                                                                        </td>
                                                                        <td>
                                                                          {{ $expeditaire }}
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span style="color:black;">Téléphone Récepteur Courrier</span>
                                                                        </td>
                                                                        <td>
                                                                          {{ $telephone_expeditaire }}
                                                                      </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>
                                                                            <span style="color:black;">Statut Courrier</span>
                                                                        </td>
                                                                        <td>
                                                                          {{ $courrier->status }}
                                                                      </td>
                                                                    </tr>

                                                                    @if($site_expediteur)
                                                                    <tr>
                                                                        <td>
                                                                            <span style="color:black;">Site Expéditeur Courrier</span>
                                                                        </td>
                                                                        <td>
                                                                          {{ $site_expediteur->intituleSite }}
                                                                      </td>
                                                                    </tr>
                                                                    @endif

                                                                    @if($site_reception)
                                                                    <tr>
                                                                        <td>
                                                                            <span style="color:black;">Site Réception Courrier</span>
                                                                        </td>
                                                                        <td>
                                                                          {{ $site_reception->intituleSite }}
                                                                      </td>
                                                                    </tr>
                                                                    @endif

                                                                    @if($courrier->Transitoire)
                                                                    <tr>
                                                                        <td>
                                                                            <span style="color:black;">Transitoire Courrier</span>
                                                                        </td>
                                                                        <td>
                                                                          {{ $courrier->Transitoire }}
                                                                      </td>
                                                                    </tr>
                                                                    @endif

                                                                </tbody>
                                                            </table>

</body>
</html>