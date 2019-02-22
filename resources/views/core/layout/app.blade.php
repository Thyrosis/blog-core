<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ config('app.name') }} :: DASHBOARD</title>
    <meta name="author" content="SaXXites">
    <link href="https://fonts.googleapis.com/css?family=Krub:400,700" rel="stylesheet">
    <link href="{{ config('app.url') }}/css/core.css" rel="stylesheet">

    @yield ('html.head')
</head>

<body class="bg-grey-light font-sans leading-normal tracking-normal">

	<nav class="flex items-center justify-between flex-wrap bg-grey-darkest p-6 fixed w-full z-10 pin-t">
		<div class="flex items-center flex-no-shrink text-white mr-6">
			<a class="text-white no-underline hover:text-white hover:no-underline" href="{{ config('app.url') }}/admin">
				<span class="text-2xl pl-2 font">{{ config('app.name') }}</span>
			</a>
		</div>

		<div class="block lg:hidden">
			<button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-grey border-grey-dark hover:text-white hover:border-white">
            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
			</button>
		</div>

        @auth
            @include ('core.layout.menu')
        @endauth
	</nav>

	<!--Container-->
	<div class="container mx-auto mt-32 md:mt-18">
        @include ('core.layout.feedback')

        <div class="page-title mx-1 my-6 font">
            <h1>@yield ('title')</h1>
        </div>

        @yield ('main')
	</div>

	<script>
		//Javascript to toggle the menu
		document.getElementById('nav-toggle').onclick = function(){
			document.getElementById("nav-content").classList.toggle("hidden");
		}
    </script>
    
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey={{ Setting::get('tinyMCE.license') }}"></script>
    <script>
        tinymce.init({
            selector: '.tinymce-full',                
            autosave_retention: "4320m",
            autosave_interval: "15s",
            block_formats: 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Quote=blockquote;Preformatted=pre',
            browser_spellcheck: true,
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            ],
            document_base_url : '{{ config('app.url') }}',
            extended_valid_elements: "img[class|src|border=0|alt|title|hspace|vspace|width|height|align|name|style]",
            image_advtab: true,
            plugins: 'advlist anchor code fullscreen help hr image imagetools insertdatetime link lists media nonbreaking pagebreak preview print searchreplace table template  textpattern toc visualblocks visualchars wordcount',
            relative_urls : true,
            templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script>

    @yield ('html.body.scripts')

</body>
</html>