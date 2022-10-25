<x-guest-layout>
        <div style="margin-top: 3rem;"></div>
        <x-auth-session-status class="mb-2" :status="session('status')" />

        <!-- Validation Errors -->

            @if(count($errors) > 0 )
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul class="p-0 m-0" style="list-style: none;">
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <form method="POST" action="{{ route('login') }}" style="margin:auto; width:50%;">
            @csrf

            <!-- Nom Utilisateur -->
            <div>
                <div class="row">
                    <i class="fas fa-1x fa-user"></i>
                    <label style="font-size: 15px; font-weight:bolder; margin-left:1rem;" for="login">Nom Utilisateur</label>
                </div>

                <x-input style="width:32rem;" id="login" for="login" class="mt-1" type="text" name="login" :value="old('login')" required autofocus autocomplete="off"/>
            </div>
            

            <!-- Password -->
            <div class="mt-4">
                <div class="row">
                    <i class="fas fa-1x fa-lock"></i>
                    <label style="font-size: 15px; font-weight:bolder; margin-left:1rem;" for="password">Mot De Passe</label>
                </div>
                <x-input style="width:32rem;" id="password" for="password" class="mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span style="font-size: 15px; color:black; font-weight:bolder;" class="ml-2 text-gray-600">{{ __('Se Souvenir De Moi') }}</span>
                </label>
            </div>

            <div style="width:32rem;" class="flex items-center justify-end mt-4">
                <x-button>
                    <i class="fa fa-sign-in-alt fa-2x mr-2"></i>
                    {{ __('Connexion') }}
                </x-button>
            </div>
            <div class="flex items-center justify-start mt-4">
                @if (Route::has('password.request'))
                    <a style="font-weight: bold;" class="underline text-lg text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Mot De Passe Oublier ?') }}
                    </a>
                @endif
            </div>

             <div class="flex items-center justify-start mt-4">
                    <button type="button" style="background-color: black; color:white; width:120px; height:40px; border-radius: 6px;" onclick="window.location='{{ url('/') }}'">
                        <i class="fa fa-reply fa-lg mr-2"></i>
                        <span class="mr-2">{{ __('RETOUR') }}</span>
                    </button>
            </div>
                    <!-- <p>
                        {{ __('Pas De Compte ?') }}
                    </p>
                    <a href="{{ url('register') }}" style="padding: 8px; border-radius:5px; background-color:#374151; color:white;" class="ml-3">
                    {{ __('Créer Un Compte') }}
                    </a> -->
        </form>
</x-guest-layout>