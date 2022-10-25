<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ url('fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('css/sb-admin-2.min.css') }}" rel="stylesheet">
        <link href="{{ url('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

        <title>GESTION LIVRAISON</title>
        <style>
            footer{
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
                background-color:#F0F2F5;
            }
        </style>
    </head>
    <body style="background-color: #FFFFFF;">
            <div class="row" style="margin: auto; width: 57%;">
                <div >
                    <img style="height:800px;" src="{{ asset('img/assurer.jpg') }}" alt="">
                </div>
                <div style="margin-top:-650px; margin-left:-8rem;">
                    <h4 style="color: #166FE5; font-weight:bold;">
                        <img style="margin-bottom:2rem;" src="{{ asset('img/sorepco.jpg') }}" alt=""></br>
                        <span style="color:#1F541D; font-size:40px;">SOREPCO. SA</span> </br></br> GESTION LIVRAISON
                    </h4>
                    <h7 style="color:#1C1E21; font-size:20px;">Avec Gestion Livraison, Manager </br> et suivez l'état de la  </br> livraison de vos marchandises.</h7></br></br>
                    <a class="btn btn-block btn-outline-primary  margin-top: 3rem;" href="{{ url('login') }}">Suivant
                    <i class="fas fa-lg fa-arrow-right ml-5"></i>
                    </a>
                </div>
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-light">
                <div>
                    <div style="font-size:13px;" class="text-center text-gray-600">
                        <span class="mr-3">
                            <i class="fas fa-eye mr-1"></i>
                            <a target="_blank" href="https://groupesorepco.com/">Site Web</a>
                        </span>
                        <span class="mr-3">
                            <i class="fas fa-crosshairs mr-1"></i>
                            Address: Salle des fêtes, Douala Cameroun
                        </span>
                        <span class="mr-3">
                            <i class="fas fa-envelope mr-1"></i>
                            Email: info@groupesorepco.com
                        </span>
                        <span class="mr-3">
                            <i class="fas fa-phone mr-1"></i>
                            Phone: (237) 6 999 66 000
                        </span>
                        <span >
                        <i class="fas fa-thin fa-clock mr-1"></i>
                            Working Days/Hours: Mon - Fri/7:30 AM - 6:00 PM Sam/7:30 AM - 2:00 PM
                        </span>
                    </div>
                    <hr>
                    <div style="font-size:13px;" class="text-center text-gray-600 mr-3">
                        <span class="mr-3"><span class="mr-3">Copyright &copy; SOREPCO SA 2022</span>| Nous Suivre sur les réseaux sociaux</span>
                        <a target="_blank" href="https://www.facebook.com/sorepcogroup"><i class="fab fa-1x fa-facebook mr-1"></i></a>
                        <a target="_blank" href="https://www.youtube.com/channel/UCAyBoJnJxN1fx0QoKNCkd4w"><i class="fab fa-1x fa-youtube mr-1"></i></a>
                        <a target="_blank" href="https://www.instagram.com/sorepcogroup/"><i class="fab fa-1x fa-instagram"></i></a>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
    </body>
</html>
