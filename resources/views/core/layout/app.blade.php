<html>
    <head>
        <link href="{{ config('app.url') }}/css/core.css" rel="stylesheet">
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.13/jquery.tinymce.min.js" integrity="sha256-nws9gG0l3dJYDL46Oc93epZ4MuxrIUBeeK8YiDPU6Cg=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.13/tinymce.min.js" integrity="sha256-t4dpNoDZ4N2yIKa2i9CJhjzQKEwpO7C33fZ1XdN+gTU=" crossorigin="anonymous"></script>        
        <script>
        tinymce.init({
            selector: '.tinymce',
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
        </script>

        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace()
        </script>
    </body>
</html>