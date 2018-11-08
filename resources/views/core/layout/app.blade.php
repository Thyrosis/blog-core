<html>
    <head>
        <link href="{{ config('app.url') }}/css/core.css" rel="stylesheet">

        @yield ('html.head')
    </head>

    <body class="bg-grey-lighter min-h-screen">
        <div class="mx-auto bg-grey-lightest">
            <div class="lg:min-h-screen flex flex-col">
                <header class="p-5 bg-teal">
                    <div class="container mx-auto text-center">
                        <h1>{{ config('app.name') }}</h1>
                    </div>
                </header>
                
                @auth
                <nav class="mb-5 border-b-2 bg-white">
                    <div class="container mx-auto flex flex-col md:flex-row md:justify-around">
                        <a class="no-underline p-2 md:p-5 hover:border-b-2 hover:border-teal" href="{{ route('home') }}" target="_blank">Blog</a>
                        <a class="no-underline p-2 md:p-5 hover:border-b-2 hover:border-teal" href="{{ route('admin.post.index') }}">Posts</a>
                        <a class="no-underline p-2 md:p-5 hover:border-b-2 hover:border-teal" href="{{ route('admin.comment.index') }}">Comments</a>
                        <a class="no-underline p-2 md:p-5 hover:border-b-2 hover:border-teal" href="{{ route('admin.subscription.index') }}">Subscriptions</a>
                        <a class="no-underline p-2 md:p-5 hover:border-b-2 hover:border-teal" href="{{ route('admin.category.index') }}">Categories</a>
                        <a class="no-underline p-2 md:p-5 hover:border-b-2 hover:border-teal" href="{{ route('admin.tag.index') }}">Tags</a>
                        <a class="no-underline p-2 md:p-5 hover:border-b-2 hover:border-teal" href="{{ route('admin.menu.edit') }}">Menu</a>
                        <a class="no-underline p-2 md:p-5 hover:border-b-2 hover:border-teal" href="{{ route('feeds.main') }}" target="_blank">RSS-feed</a>
                        <a class="no-underline p-2 md:p-5 hover:border-b-2 hover:border-teal" href="{{ route('logout') }}">Logout</a>
                    </div>
                </nav>
                @endauth
                
                @if (session()->has('error'))
                <div class="m-5">
                    <div class="container mx-auto text-center border-2 border-red-lighter bg-red-lightest rounded p-3 shadow">
                        {{ session('error') }}
                    </div>
                </div>
                @endif

                @if (session()->has('warning'))
                <div class="m-5">
                    <div class="container mx-auto text-center border-2 border-orange-lighter bg-orange-lightest rounded p-3 shadow">
                        {{ session('warning') }}
                    </div>
                </div>
                @endif

                @if (session()->has('success'))
                <div class="m-5">
                    <div class="container mx-auto text-center border-2 border-green-lighter bg-green-lightest rounded p-3 shadow">
                        {{ session('success') }}
                    </div>
                </div>
                @endif

                @if (session()->has('info'))
                <div class="m-5">
                    <div class="container mx-auto text-center border-2 border-blue-lighter bg-blue-lightest rounded p-3 shadow">
                        {{ session('info') }}
                    </div>
                </div>
                @endif

                @if (session()->has('status'))
                <div class="m-5">
                    <div class="container mx-auto text-center border-2 border-blue-lighter bg-blue-lightest rounded p-3 shadow">
                        {{ session('status') }}
                    </div>
                </div>
                @endif

                <div class="mb-5 py-3 text-teal-dark">
                    <div class="container mx-auto text-center">
                        <h1>@yield ('title')</h1>
                    </div>
                </div>

                <div class="mb-5 flex-1 container mx-auto">
                    <main>
                        @yield ('main')
                    </main>
                </div>

                <footer class="px-2 py-5 border-t-2 bg-white">
                    <div class="container mx-auto">
                        Copyright 2018 - Maarten
                    </div>
                </footer>
            </div>
        </div>

        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.5/jquery.tinymce.min.js" integrity="sha256-nws9gG0l3dJYDL46Oc93epZ4MuxrIUBeeK8YiDPU6Cg=" crossorigin="anonymous"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.5/tinymce.min.js" integrity="sha256-BWGlECOM0f4OdMtyz5KsxTeW4S+FPuDvva6yNDjWBJo=" crossorigin="anonymous"></script>        
        <script>
        tinymce.init({
            selector: '.tinymce-full',
            theme: 'modern',
            plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,
            templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            ]
        });
        </script>
        <script>
        tinymce.init({
            selector: '.tinymce-regular',
            menubar: false,
            browser_spellcheck: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen autosave',
                'media table paste help wordcount'
            ],
            toolbar: 'undo redo restoredraft | styleselect | code fullscreen | bold italic backcolor | bullist numlist outdent indent | removeformat | link insert',
            autosave_retention: "4320m",
            autosave_interval: "15s"
        });

        tinymce.init({
            selector: '.tinymce-slim',
            menubar: false,
            browser_spellcheck: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks paste help wordcount'
            ],
            toolbar: 'undo redo | styleselect | bold italic backcolor | bullist numlist | removeformat | link insert',
        });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace()
        </script>

        @yield ('html.body.scripts')
    </body>
</html>