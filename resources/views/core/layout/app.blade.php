<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ config('app.name') }} :: DASHBOARD</title>
	<meta name="author" content="SaXXites">
    <link href="{{ config('app.url') }}/css/core.css" rel="stylesheet">

    @yield ('html.head')
</head>

<body class="bg-grey-light font-sans leading-normal tracking-normal">

	<nav class="flex items-center justify-between flex-wrap bg-grey-darkest p-6 fixed w-full z-10 pin-t">
		<div class="flex items-center flex-no-shrink text-white mr-6">
			<a class="text-white no-underline hover:text-white hover:no-underline" href="#">
				<span class="text-2xl pl-2">{{ config('app.name') }}</span>
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

        <div class="page-title mx-1 my-6">
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
    
    <script src='https://cloud.tinymce.com/5-testing/tinymce.min.js?apiKey={{ config("custom.tinyMCEAPIkey") }}'></script>
    <script>
        tinymce.init({
            selector: '.tinymce-full',                
            autosave_retention: "4320m",
            autosave_interval: "15s",
            block_formats: 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Quote=blockquote;Preformatted=pre',
            branding: false,
            browser_spellcheck: true,
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            ],
            extended_valid_elements: "img[class|src|border=0|alt|title|hspace|vspace|width|height|align|name|style]",
            image_advtab: true,
            plugins: 'advlist anchor code fullscreen help hr image imagetools insertdatetime link lists media nonbreaking pagebreak preview print searchreplace table template  textpattern toc visualblocks visualchars wordcount',
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