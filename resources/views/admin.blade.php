<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;1,600&display=swap"
        rel="stylesheet" />

    <title>Email Managment System</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' width='256' height='256' viewBox='0 0 256 256' xml:space='preserve'%3E%3Cdefs%3E%3C/defs%3E%3Cg style='stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;' transform='translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)'%3E%3Cpath d='M 2.849 87.151 c -0.801 -0.801 -0.8 -2.099 0 -2.899 l 29.441 -29.441 c 0.8 -0.8 2.098 -0.801 2.899 0 s 0.8 2.099 0 2.899 L 5.748 87.151 C 4.947 87.952 3.649 87.952 2.849 87.151 z' style='stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(80,211,161); fill-rule: nonzero; opacity: 1;' transform=' matrix(1 0 0 1 0 0) ' stroke-linecap='round' /%3E%3Cpath d='M 0.916 65.892 c -0.801 -0.801 -0.8 -2.099 0 -2.899 l 11.08 -11.08 c 0.8 -0.8 2.098 -0.801 2.899 0 c 0.801 0.801 0.8 2.099 0 2.899 l -11.08 11.08 C 3.015 66.692 1.717 66.692 0.916 65.892 z' style='stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(80,211,161); fill-rule: nonzero; opacity: 1;' transform=' matrix(1 0 0 1 0 0) ' stroke-linecap='round' /%3E%3Cpath d='M 24.108 89.084 c -0.8 -0.8 -0.8 -2.099 0 -2.899 l 11.08 -11.08 c 0.8 -0.8 2.099 -0.8 2.899 0 c 0.8 0.8 0.8 2.099 0 2.899 l -11.08 11.08 C 26.207 89.884 24.909 89.884 24.108 89.084 z' style='stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(80,211,161); fill-rule: nonzero; opacity: 1;' transform=' matrix(1 0 0 1 0 0) ' stroke-linecap='round' /%3E%3Cpath d='M 89.399 0.601 c -0.53 -0.53 -1.306 -0.729 -2.025 -0.518 L 1.475 25.207 c -0.778 0.228 -1.348 0.891 -1.457 1.693 c -0.086 0.642 0.136 1.278 0.582 1.724 c 0.11 0.11 0.235 0.21 0.372 0.294 l 25.292 15.628 c 0.436 0.269 0.956 0.365 1.459 0.27 l 21.538 -4.079 C 65.667 32.684 78.597 18.514 89.399 0.601 z' style='stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(80,211,161); fill-rule: nonzero; opacity: 1;' transform=' matrix(1 0 0 1 0 0) ' stroke-linecap='round' /%3E%3Cpath d='M 89.399 0.601 c 0.53 0.53 0.729 1.306 0.518 2.025 L 64.793 88.525 c -0.228 0.778 -0.891 1.348 -1.693 1.457 c -0.642 0.086 -1.278 -0.136 -1.724 -0.582 c -0.11 -0.11 -0.21 -0.235 -0.294 -0.372 L 45.452 63.736 c -0.269 -0.436 -0.365 -0.956 -0.27 -1.459 l 4.079 -21.538 L 89.399 0.601 z' style='stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(60,187,139); fill-rule: nonzero; opacity: 1;' transform=' matrix(1 00 0) ' stroke-linecap='round' /%3E%3C/g%3E%3C/svg%3E">




    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body id="app">


    <div class="bg-gray-100 flex h-screen">
        <aside class="fixed z-50 md:relative">
            <!-- Sidebar -->
            <input type="checkbox" class="peer hidden" id="sidebar-open" />
            <label
                class="peer-checked:rounded-full peer-checked:p-2 peer-checked:right-6 peer-checked:bg-gray-600 peer-checked:text-white absolute top-8 z-20 mx-4 cursor-pointer md:hidden"
                for="sidebar-open">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </label>
            <nav aria-label="Sidebar Navigation"
                class="peer-checked:w-64 left-0 z-10 flex h-screen w-0 flex-col overflow-hidden bg-zinc-900 text-white transition-all md:h-screen md:w-64 lg:w-72">
                <div class="bg-zinc-900 mt-5 py-4 pl-10 md:mt-10">
                    <span class="">
                        <span class="mr-1 inline-flex h-8 w-8 items-center justify-center rounded-full bg-zinc-900 align-bottom text-2xl font-bold"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">

                            <defs>
                            </defs>
                            <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                                <path d="M 2.849 87.151 c -0.801 -0.801 -0.8 -2.099 0 -2.899 l 29.441 -29.441 c 0.8 -0.8 2.098 -0.801 2.899 0 s 0.8 2.099 0 2.899 L 5.748 87.151 C 4.947 87.952 3.649 87.952 2.849 87.151 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(80,211,161); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path d="M 0.916 65.892 c -0.801 -0.801 -0.8 -2.099 0 -2.899 l 11.08 -11.08 c 0.8 -0.8 2.098 -0.801 2.899 0 c 0.801 0.801 0.8 2.099 0 2.899 l -11.08 11.08 C 3.015 66.692 1.717 66.692 0.916 65.892 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(80,211,161); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path d="M 24.108 89.084 c -0.8 -0.8 -0.8 -2.099 0 -2.899 l 11.08 -11.08 c 0.8 -0.8 2.099 -0.8 2.899 0 c 0.8 0.8 0.8 2.099 0 2.899 l -11.08 11.08 C 26.207 89.884 24.909 89.884 24.108 89.084 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(80,211,161); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path d="M 89.399 0.601 c -0.53 -0.53 -1.306 -0.729 -2.025 -0.518 L 1.475 25.207 c -0.778 0.228 -1.348 0.891 -1.457 1.693 c -0.086 0.642 0.136 1.278 0.582 1.724 c 0.11 0.11 0.235 0.21 0.372 0.294 l 25.292 15.628 c 0.436 0.269 0.956 0.365 1.459 0.27 l 21.538 -4.079 C 65.667 32.684 78.597 18.514 89.399 0.601 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(80,211,161); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path d="M 89.399 0.601 c 0.53 0.53 0.729 1.306 0.518 2.025 L 64.793 88.525 c -0.228 0.778 -0.891 1.348 -1.693 1.457 c -0.642 0.086 -1.278 -0.136 -1.724 -0.582 c -0.11 -0.11 -0.21 -0.235 -0.294 -0.372 L 45.452 63.736 c -0.269 -0.436 -0.365 -0.956 -0.27 -1.459 l 4.079 -21.538 L 89.399 0.601 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(60,187,139); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            </g>
                            </svg></span>
                        <span class="text-xl">EMS</span>
                    </span>
                </div>
                <ul class="mt-8 space-y-3 md:mt-20">

                    <li class="relative">

                        <router-link to="/admin"
                            class="focus:bg-slate-600 hover:bg-slate-600 flex w-full space-x-2 rounded-md px-10 py-4 font-semibold focus:outline-none">

                            <span><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>

                            </span>
                            <span class="">Tableau de Bord</span>
                        </router-link>

                    </li>
                    <li class="relative">

                        <router-link to="/admin/create-reciptients"
                            class="focus:bg-slate-600 hover:bg-slate-600 flex w-full space-x-2 rounded-md px-10 py-4 font-semibold focus:outline-none">
                            <span>

                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                  </svg>




                            </span>


                            <span class="">Ajouter Destinataires</span>
                        </router-link>

                    </li>
                    <li class="relative">

                        <router-link to="/admin/reciptients"
                            class="focus:bg-slate-600 hover:bg-slate-600 flex w-full space-x-2 rounded-md px-10 py-4 font-semibold focus:outline-none">

                            <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                              </svg>


                            </span>
                            <span class="">Voir Destinataires</span>
                        </router-link>

                    </li>
                    <li class="relative">

                        <router-link to="/admin/create-emails"
                            class="focus:bg-slate-600 hover:bg-slate-600 flex w-full space-x-2 rounded-md px-10 py-4 text-gray-300 focus:outline-none">


                            <span> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                              </svg>



                            </span>
                            <span class="">Créer Emails</span>
                        </router-link>

                    </li>
                    <li class="relative">

                        <router-link to="/admin/emails-History"
                            class="focus:bg-slate-600 hover:bg-slate-600 flex w-full space-x-2 rounded-md px-10 py-4 font-semibold focus:outline-none">

                            <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                              </svg>

                            </span>
                            <span class="">Voir Emails</span>
                        </router-link>

                    </li>
                    <li class="relative">


                        <router-link to="/admin/departments"
    class="focus:bg-slate-600 hover:bg-slate-600 flex w-full space-x-2 rounded-md px-10 py-4 text-gray-300 focus:outline-none">
    <span>
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z"/></svg>

         </span>
    <span class="font-semibold">Départements</span>
</router-link>

                    </li>
                    <li class="relative">


                        <router-link to="/admin/expediteurs"
    class="focus:bg-slate-600 hover:bg-slate-600 flex w-full space-x-2 rounded-md px-10 py-4 text-gray-300 focus:outline-none">
    <span> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
      </svg>



    </span>
    <span class="font-semibold">Expediteurs</span>
</router-link>

                    </li>

                    <li class="relative">


                        <router-link to="/admin/roles"
    class="focus:bg-slate-600 hover:bg-slate-600 flex w-full space-x-2 rounded-md px-10 py-4 text-gray-300 focus:outline-none">
    <span>
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z"/></svg>

         </span>
    <span class="font-semibold">Roles</span>
</router-link>

                    </li>



                </ul>

                <div class="my-6 mt-auto ml-10 flex cursor-pointer">
                    <div>


                    </div>
                    <div class="ml-3">
                        <p class="font-medium">{{ $user->name }}</p>
                        <p class="text-sm text-gray-300">{{ $user->email }}</p>
                    </div>
                </div>
            </nav>
        </aside>
        <!-- /Sidebar -->

        <div class="flex h-full w-full flex-col">
            <!-- Navbar -->



<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <span class="flex items-center space-x-3 rtl:space-x-reverse">

    </span>
    <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
          <span class="sr-only">Open user menu</span>
          <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="user photo">
        </button>
        <!-- Dropdown menu -->
        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
          <div class="px-4 py-3">
            <span class="block text-sm text-gray-900 dark:text-white">{{ $user->name }}</span>
            <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ $user->email }}</span>
          </div>
          <ul class="py-2" aria-labelledby="user-menu-button">

            <li>
                <router-link to="/admin/parametres" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Parametres</router-link>

            </li>

            <li>
              <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
            </li>
          </ul>
        </div>

    </div>

    </div>
  </nav>

            <!-- /Navbar -->

            <!-- Main -->
            <div class="h-full overflow-hidden pl-10">
                <main id="dashboard-main" class="h-[calc(100vh-10rem)] overflow-auto px-4 py-10">
                    <!-- Put your content inside of the <main/> tag -->
                    <router-view></router-view>
                </main>
            </div>
            <!-- /Main -->
        </div>
    </div>



</body>

</html>
