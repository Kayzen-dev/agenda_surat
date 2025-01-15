<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Agenda Surat</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_Dis.png') }}">
    <!-- Fonts -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>
    <section class="bg-white dark:bg-gray-900">
        <nav x-data="{ isOpen: false }" class="container p-6 mx-auto lg:flex lg:justify-between lg:items-center">
            <div class="flex items-center justify-between">
                
                <img src="{{ asset('images/logo_Dis.png') }}" class="w-20 h-20" alt="" srcset="">

                {{-- <a href="/" class="text-gray-500 text-lg dark:text-gray-200 hover:text-gray-600">
                    Agenda Surat
                </a> --}}
    
                <!-- Mobile menu button -->
                <div class="flex lg:hidden">
                    <button x-cloak @click="isOpen = !isOpen" type="button" class="text-gray-500 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-400 focus:outline-none focus:text-gray-600 dark:focus:text-gray-400" aria-label="toggle menu">
                        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                        </svg>
                
                        <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
    
            <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
            <div x-cloak :class="[isOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']" class="absolute inset-x-0 z-20 w-full px-6 py-4 transition-all duration-300 ease-in-out bg-white shadow-md lg:bg-transparent lg:dark:bg-transparent lg:shadow-none dark:bg-gray-900 lg:mt-0 lg:p-0 lg:top-0 lg:relative lg:w-auto lg:opacity-100 lg:translate-x-0 lg:flex lg:items-center">
                <div class="flex flex-col space-y-4 lg:mt-0 lg:flex-row lg:-px-8 lg:space-y-0">
                    <a href="/" class="text-gray-800 transition-colors duration-300 transform dark:text-gray-200 border-b-2 border-blue-500 mx-1.5 sm:mx-6">Beranda</a>
                    <a class="text-gray-700 transition-colors duration-300 transform lg:mx-8 dark:text-gray-200 dark:hover:text-blue-400 hover:text-blue-500" href="#fitur">Fitur</a>
                </div>
    
            </div>
        </nav>
    

        <section class="dark:bg-gray-900 lg:py-12 lg:flex lg:justify-center">
            <div
                class="overflow-hidden bg-white dark:bg-gray-800 lg:mx-8 lg:flex lg:max-w-6xl lg:w-full lg:shadow-md lg:rounded-xl">
                <div class="lg:w-1/2">
                    <div class="h-64 bg-cover lg:h-full" style="background-image:url('{{ asset('images/hero.png') }}')"></div>
                </div>
        
                <div class="max-w-xl px-6 py-12 lg:max-w-5xl lg:w-1/2">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white md:text-3xl">
                        Agenda Surat <span class="text-blue-500">App</span>
                    </h2>
        
                    <p class="mt-4 text-gray-500 dark:text-gray-300">
                        Kelola seluruh kebutuhan surat-menyurat Anda dengan mudah dan efisien melalui fitur Agenda Surat. Solusi ini dirancang untuk mencatat setiap detail surat masuk dan keluar, memastikan tidak ada informasi penting yang terlewatkan.
                    </p>
        
                    <div class="inline-flex w-full mt-6 sm:w-auto">
                        <a href="/login" class="inline-flex items-center justify-center w-full px-6 py-2 text-sm text-white duration-300 bg-gray-900 rounded-lg hover:bg-gray-700 focus:ring focus:ring-gray-300 focus:ring-opacity-80">
                            Mulai Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>



    </section>

    <section class="bg-white dark:bg-gray-900">
        <div class="container flex flex-col items-center px-4 py-12 mx-auto text-center">
            <h2 class="text-2xl font-bold tracking-tight text-gray-800 xl:text-3xl dark:text-white">
                Mengapa Agenda Surat Penting?.
            </h2>
    
            <p class="block max-w-4xl mt-4 text-gray-500 dark:text-gray-300">
                Dengan Agenda Surat, Anda tidak hanya mengelola dokumen dengan lebih baik tetapi juga meningkatkan efisiensi kerja. Tidak ada lagi kekhawatiran kehilangan arsip atau melupakan surat penting.


            </p>
        </div>
    </section>


    <section class="bg-white dark:bg-gray-900" id="fitur">
        <div class="container px-6 py-10 mx-auto">
            <h1 class="text-2xl font-semibold text-gray-800 capitalize lg:text-3xl dark:text-white">Jelajahi <br> Fitur <span class="underline decoration-blue-500">Agenda Surat</span> App</h1>
    
            <p class="mt-4 text-gray-500 xl:mt-6 dark:text-gray-300">
                Temukan berbagai fitur menarik yang dirancang untuk kemudahan Anda.
            </p>
    
            <div class="grid grid-cols-1 gap-8 mt-8 xl:mt-12 xl:gap-12 md:grid-cols-2 xl:grid-cols-3">
                <div class="p-8 space-y-3 border-2 border-blue-400 dark:border-blue-300 rounded-xl">
                    <span class="inline-block text-blue-500 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a3 3 0 003.22 0L22 8m-9 9H5a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5m-6 0v2a2 2 0 11-4 0v-2h4z" />
                        </svg>
                        
                    </span>
    
                    <h1 class="text-xl font-semibold text-gray-700 capitalize dark:text-white">Pencatatan Surat Masuk</h1>
    
                    <p class="text-gray-500 dark:text-gray-300">
                        Kelola semua surat yang diterima, lengkap dengan informasi penting seperti pengirim, tanggal masuk, dan isi singkat surat.
                    </p>
    
                </div>
    
                <div class="p-8 space-y-3 border-2 border-blue-400 dark:border-blue-300 rounded-xl">
                    <span class="inline-block text-blue-500 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 8l-9-5-9 5v10a2 2 0 002 2h14a2 2 0 002-2V8z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9 5 9-5" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v6m-3-3h6" />
                        </svg>
                        
                        
                    </span>
    
                    <h1 class="text-xl font-semibold text-gray-700 capitalize dark:text-white">Pencatatan Surat Keluar</h1>
    
                    <p class="text-gray-500 dark:text-gray-300">
                        Dokumentasikan setiap surat yang dikirim, mulai dari tujuan, isi surat dan .
    
                    
                </div>
    
                <div class="p-8 space-y-3 border-2 border-blue-400 dark:border-blue-300 rounded-xl">
                    <span class="inline-block text-blue-500 dark:text-blue-400">
                        <svg class="w-8 h-8" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M696.2 411.6C498.7 368.3 660.6 94.4 390 117.1s-527.2 645.8-46.8 791.7 727.9-414.9 353-497.2z" fill="#464BD8" /><path d="M391.4 235.6l-98.6 501.9V235.6zM407 235.6L303.8 761l-11-2.2v-21.3l98.6-501.9z" fill="#2E2E42" /><path d="M421.1 235.6l1.4 0.3L318.8 764l-15-3L407 235.6z" fill="#2D2D41" /><path d="M318.831263 764.004291l103.752737-528.002821 15.012903 2.95004L333.844166 766.954332z" fill="#2D2D40" /><path d="M333.78964 766.951693l103.752737-528.002821L452.55528 241.898912 348.802543 769.901734z" fill="#2C2C3F" /><path d="M348.846315 769.916588l103.752736-528.002821L467.611954 244.863807 363.859218 772.866629z" fill="#2B2B3E" /><path d="M363.805673 772.863183l103.752736-528.002821 15.012903 2.95004L378.818576 775.813224z" fill="#2A2A3D" /><path d="M378.862174 775.829867l103.752736-528.002822 15.012903 2.950041L393.875077 778.779907z" fill="#2A2A3C" /><path d="M393.820725 778.77548l103.752736-528.002821 15.012903 2.95004L408.833628 781.725521z" fill="#29293B" /><path d="M408.780083 781.722075l103.752736-528.002822 15.012903 2.950041L423.792986 784.672116z" fill="#28283A" /><path d="M423.855057 784.589654l103.752737-528.002822 15.012903 2.950041L438.86796 787.539694z" fill="#282839" /><path d="M438.814416 787.536248l103.752736-528.002821 15.012903 2.95004L453.827319 790.486289z" fill="#272738" /><path d="M453.871897 790.502125l103.752737-528.002822 15.012903 2.950041L468.8848 793.452165z" fill="#262637" /><path d="M468.828486 793.449353l103.752736-528.002822 15.012903 2.950041L483.841389 796.399393z" fill="#252536" /><path d="M483.885968 796.415229l103.752736-528.002822 15.012903 2.950041L498.898871 799.365269z" fill="#252534" /><path d="M498.844519 799.360842l103.752736-528.002821 15.012903 2.95004L513.857422 802.310883z" fill="#242433" /><path d="M513.902 802.326719l103.752737-528.002822 15.012903 2.950041L528.914903 805.276759z" fill="#232332" /><path d="M528.860377 805.274121l103.752737-528.002822 15.012903 2.950041L543.87328 808.224161z" fill="#222231" /><path d="M543.917052 808.239016l103.752736-528.002822 15.012903 2.950041L558.929955 811.189056z" fill="#222230" /><path d="M558.875429 811.186418l103.752736-528.002822 15.012903 2.950041L573.888332 814.136458z" fill="#21212F" /><path d="M573.932911 814.152294l103.752736-528.002822 15.012903 2.950041L588.945814 817.102334z" fill="#20202E" /><path d="M588.891462 817.097907l103.752736-528.002821 15.012903 2.95004L603.904365 820.047948z" fill="#20202D" /><path d="M603.947962 820.064591l103.752736-528.002822 15.012903 2.950041L618.960865 823.014631z" fill="#1F1F2C" /><path d="M618.90732 823.011186l103.752737-528.002822L737.67296 297.958405 633.920223 825.961226z" fill="#1E1E2B" /><path d="M633.964802 825.977062l103.752736-528.002822L752.730441 300.924281 648.977705 828.927102z" fill="#1D1D2A" /><path d="M752.7 300.8l15 2.9-103.2 525.4h-14.1l-1.5-0.3z" fill="#1D1D29" /><path d="M767.7 303.7l11 2.2v21.3l-98.6 501.9h-15.6zM680.1 829.1l98.6-501.9v501.9z" fill="#1C1C28" /><path d="M646 807.5c-1.6 0-3.2-0.2-4.8-0.5l-307-60.3c-6.4-1.3-12-4.9-15.6-10.4-3.6-5.4-5-12-3.7-18.4l86.6-441c2.3-11.5 12.3-19.8 24-19.8 1.6 0 3.2 0.2 4.8 0.5l307 60.3c13.3 2.6 21.9 15.5 19.3 28.7l-86.6 441c-2.3 11.6-12.4 19.9-24 19.9z" fill="#FFFFFF" /><path d="M646 807.5c-1.6 0-3.2-0.2-4.8-0.5l-307-60.3c-6.4-1.3-12-4.9-15.6-10.4-3.6-5.4-5-12-3.7-18.4l86.6-441c2.3-11.5 12.3-19.8 24-19.8 1.6 0 3.2 0.2 4.8 0.5l307 60.3c13.3 2.6 21.9 15.5 19.3 28.7l-86.6 441c-2.3 11.6-12.4 19.9-24 19.9z" fill="#FFFFFF" /><path d="M640.2 793.7c-1.4 0-2.8-0.1-4.2-0.4l-269.8-53c-5.6-1.1-10.5-4.3-13.7-9.1-3.2-4.8-4.4-10.5-3.2-16.2l76.1-387.5c2-10.1 10.8-17.4 21.1-17.4 1.4 0 2.8 0.1 4.2 0.4l269.8 53c11.6 2.3 19.3 13.6 17 25.3l-76.1 387.5c-2.1 10.1-10.9 17.4-21.2 17.4z" fill="#2AEFC8" /><path d="M674.4 274.5c1.4-2.7 2.6-5.6 3.2-8.8 3.6-17.8-8.1-35.1-25.9-38.6l-90.4-17.8c-17.8-3.5-35.1 8.1-38.6 25.9-0.6 3.1-0.6 6.1-0.4 9.1-24.4-3-45.2 4.5-48.4 21.2l234.2 47.6c3.2-16-11.6-31.6-33.7-38.6z" fill="#514DDF" /><path d="M708.1 322.1c-0.6 0-1.2-0.1-1.8-0.2l-234.1-47.6c-4.8-1-7.9-5.7-7-10.5 3.6-18.6 22.6-30 48.6-29.1 0.1-0.4 0.1-0.8 0.2-1.3 4.4-22.6 26.5-37.4 49.1-33l90.4 17.8c11 2.2 20.5 8.5 26.7 17.8 6.2 9.3 8.4 20.4 6.2 31.3-0.1 0.6-0.3 1.2-0.4 1.9 21.9 9.9 34.4 27.8 30.9 45.6-0.5 2.3-1.8 4.4-3.8 5.7-1.5 1.1-3.3 1.6-5 1.6z m-220.4-62.8L697.9 302c-3.7-7.7-13.3-14.9-26.2-19-2.5-0.8-4.5-2.7-5.6-5.1-1-2.4-0.9-5.2 0.3-7.5 1.2-2.4 2-4.4 2.4-6.3 1.3-6.3 0-12.6-3.6-17.9-3.6-5.3-9-9-15.3-10.2l-90.4-17.8c-13-2.5-25.5 5.9-28.1 18.9-0.4 1.9-0.4 4-0.2 6.6 0.2 2.7-0.8 5.3-2.7 7.2-1.9 1.9-4.6 2.7-7.3 2.4-14.5-1.9-26.8 0.5-33.5 6z" fill="#29293A" /><path d="M602 269.5c-8.3-1.6-13.6-9.6-12-17.9 1.6-8.3 9.6-13.6 17.9-12 8.3 1.6 13.6 9.6 12 17.9-1.7 8.3-9.7 13.6-17.9 12z" fill="#FFFFFF" /><path d="M550.515 420.205l150.843 31.03-2.62 12.734-150.843-31.03zM428.579 445.695l262.8 54.062-2.62 12.734-262.8-54.063zM418.577 494.19l262.8 54.063-2.62 12.734-262.8-54.063zM408.596 542.589l262.8 54.062-2.62 12.734-262.8-54.063zM398.595 591.085l262.8 54.062-2.62 12.734-262.8-54.063zM388.009 642.725l188.651 38.81-2.62 12.733-188.65-38.81z" fill="#514DDF" /></svg>
                        
                    </span>
    
                    <h1 class="text-xl font-semibold text-gray-700 capitalize dark:text-white">Organisasi yang Sistematis</h1>
    
                    <p class="text-gray-500 dark:text-gray-300">
                        Semua data surat tersimpan dalam format yang terstruktur, memudahkan pencarian dan pengelolaan dokumen kapan saja diperlukan.
                    </p>
    
                </div>
            </div>
        </div>
    </section>
    

    <footer class="bg-white dark:bg-gray-900">
        <div class="container flex flex-col items-center justify-between p-6 mx-auto space-y-4 sm:space-y-0 sm:flex-row">
            <p class="text-sm text-gray-600 dark:text-gray-300">Dispunsip © Copyright 2025. All Rights Reserved.</p>
        </div>
    </footer>

    @livewireScripts

</body>





</html>