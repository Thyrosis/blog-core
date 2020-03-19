<!DOCTYPE html>
<html lang="en">
    <head>
        @google

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name') }} :: Dashboard</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link href="{{ config('app.url') }}/css/core.css" rel="stylesheet">

        @yield ('html.head')
    </head>

    <body class="bg-gray-100 tracking-wider tracking-normal">
        <nav id="header" class="fixed w-full z-10 top-0 bg-white border-b border-gray-400">
            <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-4">
                <div class="pl-4 flex items-center">
                    <span class="text-2xl pl-2 font">{{ config('app.name') }}</span>
                </div>
                <div class="block lg:hidden pr-4">
                <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-900 hover:border-purple-500 appearance-none focus:outline-none">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                    </svg>
                </button>
                </div>
                <div class="w-full flex-grow lg:flex  lg:content-center lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 z-20" id="nav-content">
                <div class="flex-1 w-full mx-auto max-w-sm content-center py-4 lg:py-0">
                    <div class="relative pull-right pl-4 pr-4 md:pr-0">
                        <!-- <input type="search" placeholder="Search" class="w-full bg-gray-100 text-sm text-gray-800 transition border focus:outline-none focus:border-purple-500 rounded py-1 px-2 pl-10 appearance-none leading-normal">
                        <div class="absolute search-icon" style="top: 0.375rem;left: 1.75rem;">
                            <svg class="fill-current pointer-events-none text-gray-800 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
                            </svg>
                        </div> -->
                    </div>
                </div>
                <ul class="list-reset lg:flex justify-end items-center">
                    @auth
                    <li class="mr-3 py-2 lg:py-0">
                        <a class="inline-block py-2 px-4 text-gray-900 font-bold no-underline" href="{{ route('profile.show', auth()->user()) }}">@lang('Profile')</a>
                    </li>
                    <li class="mr-3 py-2 lg:py-0">
                        <a class="inline-block text-gray-600 no-underline hover:text-gray-900 hover:underline py-2 px-4" href="{{ route('logout') }}">@lang('Logout')</a>
                    </li>
                    @endauth
                    <li class="mr-3 py-2 lg:py-0">
                        <a class="inline-block text-gray-600 no-underline hover:text-gray-900 hover:underline py-2 px-4" href="/" target="_blank">Website</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        <!--Container-->
        <div class="container w-full flex flex-wrap mx-auto px-2 pt-8 lg:pt-16 mt-16">
            <div class="w-full lg:w-1/5 lg:px-6 text-xl text-gray-800 leading-normal">
            @auth
                <p class="text-base font-bold py-2 lg:pb-6 text-gray-700">Menu</p>
                <div class="block lg:hidden sticky inset-0">
                <button id="menu-toggle" class="flex w-full justify-end px-3 py-3 bg-white lg:bg-transparent border rounded border-gray-600 hover:border-purple-500 appearance-none focus:outline-none">
                    <svg class="fill-current h-3 float-right" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </button>
                </div>
                <div class="w-full sticky inset-0 hidden h-64 lg:h-auto overflow-x-hidden overflow-y-auto lg:overflow-y-hidden lg:block mt-0 border border-gray-400 lg:border-transparent bg-white shadow lg:shadow-none lg:bg-transparent z-20" style="top:5em;" id="menu-content">
                
                <ul class="list-reset">
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a href="{{ route('admin.post.index') }}" class="admin-menu-link {{ is_current_url(route('admin.post.index')) ? 'admin-menu-selected' : '' }}">
                        <span class="pb-1 md:pb-0 text-sm text-gray-900">@lang('Posts')</span>
                        </a>
                    </li>
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a href="{{ route('admin.comment.index') }}" class="admin-menu-link {{ is_current_url(route('admin.comment.index')) ? 'admin-menu-selected' : '' }}">
                        <span class="pb-1 md:pb-0 text-sm">@lang('Comments')</span>
                        </a>
                    </li>
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a href="{{ route('admin.subscription.index') }}" class="admin-menu-link {{ is_current_url(route('admin.subscription.index')) ? 'admin-menu-selected' : '' }}">
                        <span class="pb-1 md:pb-0 text-sm">@lang('Subscriptions')</span>
                        </a>
                    </li>
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a href="{{ route('admin.setting.edit') }}" class="admin-menu-link {{ is_current_url(route('admin.setting.edit')) ? 'admin-menu-selected' : '' }}">
                        <span class="pb-1 md:pb-0 text-sm">@lang('Settings')</span>
                        </a>
                    </li>
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a href="{{ route('admin.category.index') }}" class="admin-menu-link {{ is_current_url(route('admin.category.index')) ? 'admin-menu-selected' : '' }}">
                        <span class="pb-1 md:pb-0 text-sm">@lang('Categories')</span>
                        </a>
                    </li>
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a href="{{ route('admin.tag.index') }}" class="admin-menu-link {{ is_current_url(route('admin.tag.index')) ? 'admin-menu-selected' : '' }}">
                        <span class="pb-1 md:pb-0 text-sm">@lang('Tags')</span>
                        </a>
                    </li>
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a href="{{ route('admin.menu.edit') }}" class="admin-menu-link {{ is_current_url(route('admin.menu.edit')) ? 'admin-menu-selected' : '' }}">
                        <span class="pb-1 md:pb-0 text-sm">@lang('Menu')</span>
                        </a>
                    </li>
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a href="{{ route('admin.form.index') }}" class="admin-menu-link {{ is_current_url(route('admin.form.index')) ? 'admin-menu-selected' : '' }}">
                        <span class="pb-1 md:pb-0 text-sm">@lang('Form')</span>
                        </a>
                    </li>
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a href="{{ route('admin.media.index') }}" class="admin-menu-link {{ is_current_url(route('admin.media.index')) ? 'admin-menu-selected' : '' }}">
                        <span class="pb-1 md:pb-0 text-sm">@lang('Media')</span>
                        </a>
                    </li>
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a href="{{ route('admin.view.index') }}" class="admin-menu-link {{ is_current_url(route('admin.view.index')) ? 'admin-menu-selected' : '' }}">
                        <span class="pb-1 md:pb-0 text-sm">@lang('Views')</span>
                        </a>
                    </li>
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a href="{{ route('admin.user.index') }}" class="admin-menu-link {{ is_current_url(route('admin.user.index')) ? 'admin-menu-selected' : '' }}">
                        <span class="pb-1 md:pb-0 text-sm">@lang('Users')</span>
                        </a>
                    </li>
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a href="{{ route('admin.meta.index') }}" class="admin-menu-link {{ is_current_url(route('admin.meta.index')) ? 'admin-menu-selected' : '' }}">
                        <span class="pb-1 md:pb-0 text-sm">@lang('Meta')</span>
                        </a>
                    </li>
                    <li class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent">
                        <a class="admin-menu-link {{ is_current_url(route('feeds.main')) ? 'admin-menu-selected' : '' }}" href="{{ route('feeds.main') }}" target="_blank">
                            <span class="pb-1 md:pb-0 text-sm">@lang('RSS-feed')</span>
                        </a>
                    </li>
                </ul>
               
                </div>
            @endauth
            </div>
            
            <div class="w-full lg:w-4/5 text-gray-900 leading-normal ">
                <div class="font-sans">
                    <h1 class="font-sans break-normal text-purple-700 pt-2 mb-4  text-xl">@yield ('title')</h1>
                </div>

                <div class="mb-5">
                    @include ('core.layout.feedback')
                </div>
            
                <div class="bg-white border border-gray-400 border-rounded p-8 mt-6 lg:mt-0">
                
                    @yield ('main')
                
                            <!--Post Content-->
            <!--Lead Para-->
            <!-- <p class="py-6">
               👋 Welcome fellow <a class="text-purple-500 no-underline hover:underline" href="https://www.tailwindcss.com">Tailwind CSS</a> fan.  This starter template provides a starting point to create your own helpdesk / faq / knowledgebase articles using Tailwind CSS and vanilla Javascript.
            </p>
            <p class="py-6">The basic help article layout is available and all using the default Tailwind CSS classes (although there are a few hardcoded style tags). If you are going to use this in your project, you will want to convert the classes into components.</p>
            <h1 class="py-2 font-sans">Heading 1</h1>
            <h2 class="py-2 font-sans">Heading 2</h2>
            <h3 class="py-2 font-sans">Heading 3</h3>
            <h4 class="py-2 font-sans">Heading 4</h4>
            <h5 class="py-2 font-sans">Heading 5</h5>
            <h6 class="py-2 font-sans">Heading 6</h6>
            <p class="py-6">Sed dignissim lectus ut tincidunt vulputate. Fusce tincidunt lacus purus, in mattis tortor sollicitudin pretium. Phasellus at diam posuere, scelerisque nisl sit amet, tincidunt urna. Cras nisi diam, pulvinar ut molestie eget, eleifend ac magna. Sed at lorem condimentum, dignissim lorem eu, blandit massa. Phasellus eleifend turpis vel erat bibendum scelerisque. Maecenas id risus dictum, rhoncus odio vitae, maximus purus. Etiam efficitur dolor in dolor molestie ornare. Aenean pulvinar diam nec neque tincidunt, vitae molestie quam fermentum. Donec ac pretium diam. Suspendisse sed odio risus. Nunc nec luctus nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis nec nulla eget sem dictum elementum.</p>
            <ol>
               <li class="py-3">Maecenas accumsan lacus sit amet elementum porta. Aliquam eu libero lectus. Fusce vehicula dictum mi. In non dolor at sem ullamcorper venenatis ut sed dui. Ut ut est quam. Suspendisse quam quam, commodo sit amet placerat in, interdum a ipsum. Morbi sit amet tellus scelerisque tortor semper posuere.</li>
               <li class="py-3">Morbi varius posuere blandit. Praesent gravida bibendum neque eget commodo. Duis auctor ornare mauris, eu accumsan odio viverra in. Proin sagittis maximus pharetra. Nullam lorem mauris, faucibus ut odio tempus, ultrices aliquet ex. Nam id quam eget ipsum luctus hendrerit. Ut eros magna, eleifend ac ornare vulputate, pretium nec felis.</li>
               <li class="py-3">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc vitae pretium elit. Cras leo mauris, tristique in risus ac, tristique rutrum velit. Mauris accumsan tempor felis vitae gravida. Cras egestas convallis malesuada. Etiam ac ante id tortor vulputate pretium. Maecenas vel sapien suscipit, elementum odio et, consequat tellus.</li>
            </ol>
            <blockquote class="border-l-4 border-purple-500 italic my-8 pl-8 md:pl-12">Example of blockquote - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at ipsum eu nunc commodo posuere et sit amet ligula.</blockquote>
            <p class="py-6">Example code block:</p>
            <pre class="bg-gray-900 rounded text-white font-mono text-base p-2 md:p-4">
				<code class="break-words whitespace-pre-wrap">
&lt;header class="site-header outer"&gt;
&lt;div class="inner"&gt;
&lt;/div&gt;
&lt;/header&gt;
				</code>
			</pre> -->
            <!--/ Post Content-->
                </div>
            </div>
            <!--Back link -->
            <div class="w-full lg:w-4/5 lg:ml-auto text-base md:text-sm text-gray-500 px-4 py-6">
                <span class="text-base text-purple-500 font-bold">&lt;</span> <a href="/" class="text-base md:text-sm text-purple-500 font-bold no-underline hover:underline">Back to website</a>
            </div>
        </div>
        <!--/container-->

        @auth
        <footer class="bg-white border-t border-gray-400 shadow">
            <div class="container mx-auto flex py-8">
                <div class="w-full mx-auto flex flex-wrap">
                <div class="flex w-full lg:w-1/2 ">
                    <div class="px-8">
                        <h3 class="font-bold text-gray-900">About</h3>
                        <p class="py-4 text-gray-600 text-sm">
                            @lang('Current version'): 1.7.0 (2020-03-19)
                        </p>
                    </div>
                </div>
                <div class="flex w-full lg:w-1/2 lg:justify-end lg:text-right">
                    <div class="px-8">
                        <!-- <h3 class="font-bold text-gray-900">Social</h3>
                        <ul class="list-reset items-center text-sm pt-3">
                            <li>
                            <a class="inline-block text-gray-600 no-underline hover:text-gray-900 hover:underline py-1" href="#">Add social links</a>
                            </li>
                        </ul> -->
                    </div>
                </div>
                </div>
            </div>
        </footer>
        @endauth

        <!-- TinyMCE -->
        <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey={{ Setting::get('tinyMCE.license') }}"></script>
        <script>
            tinymce.init({
                selector: '#summary',
                mobile: {
                    menubar: true, 
                    statusbar: false,                 
                    toolbar: false
                }               
            });
        </script>
        <script>
            tinymce.init({
                selector: '.tinymce-full',
                autosave_interval: "15s",
                autosave_restore_when_empty: true,
                autosave_retention: "1440",
                // block_formats: 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Quote=blockquote;Preformatted=pre',
                browser_spellcheck: true,
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                ],
                document_base_url : '{{ config('app.url') }}',
                // extended_valid_elements: "a[href|title|target=_blank],img[class|src|border=0|alt|title|hspace|vspace|width|height|align],*[name|style|title|class],p[name]",
                valid_elements: "*[*]",
                image_advtab: true,
                language_url : '{{ config('app.url') }}/js/languages/{{ config('app.locale') }}.js',
                language: '{{ config('app.locale') }}',
                link_list: [
                    {title: '-- Pages --', value: '/'},
                @foreach (App\Post::getPages() as $page)
                    {title: '{{ $page->getTitle() }}', value: '{{ $page->path() }}'},
                @endforeach
                    {title: '-- Posts --', value: '/'},
                @foreach (App\Post::getPosts() as $post)
                    {title: '{{ $post->getTitle() }}', value: '{{ $post->path() }}'},
                @endforeach
                ],
                mobile: {
                    menubar: true, 
                    statusbar: false,                 
                    toolbar: false
                },
                plugins: 'advlist anchor autosave code fullscreen help hr image imagetools insertdatetime link lists media nonbreaking pagebreak preview print searchreplace table template textpattern toc visualblocks visualchars wordcount',
                relative_urls : false,
                style_formats: [
                    { title: 'Paragraph', format: 'p'},
                    { title: 'Heading 1', format: 'h1'},
                    { title: 'Heading 2', format: 'h2'},
                    { title: 'Heading 3', format: 'h3'},
                    { title: 'Heading 4', format: 'h4'},
                    { title: 'Quote', format: 'blockquote'},
                    { title: 'Code', format: 'pre'},
                    { title: 'Image formats' },
                    { title: 'Image Left', selector: 'img', styles: { 'float': 'left', 'margin': '0 10px 0 10px' } },
                    { title: 'Image Right', selector: 'img', styles: { 'float': 'right', 'margin': '0 0 10px 10px' } },
                    { title: 'Custom CSS rules' },
                    {!! App\Setting::get('tinyMCE.customClasses') !!}
                ],
                templates: [
                    { title: 'Quote', description: 'Default quote field', content: '<blockquote>This is a quote. Nice to display with a different background color or some padding on the left. Style it in your custom CSS file.</blockquote><p>&nbsp;</p>'},
                    { title: 'Highlight', description: 'Highlighted paragraph', content: '<p style="background-color: #456789; padding: 1rem;">This is a regular paragraph but with a different background color. Style as needed.</p><p>&nbsp;</p>' }
                ],
                toolbar1: 'styleselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
            });
        </script>
        <!-- End TinyMCE -->

        <!-- Feather Icons -->
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace()
        </script>
        <!-- End Feather Icons -->

        <!-- Toggle DropDown List -->
        <script>
            /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/
            
            var navMenuDiv = document.getElementById("nav-content");
            var navMenu = document.getElementById("nav-toggle");
            
            var helpMenuDiv = document.getElementById("menu-content");
            var helpMenu = document.getElementById("menu-toggle");
            
            document.onclick = check;
            
            function check(e) {
                var target = (e && e.target) || (event && event.srcElement);
                            
                //Nav Menu
                if (!checkParent(target, navMenuDiv)) {
                    // click NOT on the menu
                    if (checkParent(target, navMenu)) {
                    // click on the link
                    if (navMenuDiv.classList.contains("hidden")) {
                        navMenuDiv.classList.remove("hidden");
                    } else {navMenuDiv.classList.add("hidden");}
                    } else {
                    // click both outside link and outside menu, hide menu
                    navMenuDiv.classList.add("hidden");
                    }
                }
                
                //Help Menu
                if (!checkParent(target, helpMenuDiv)) {
                    // click NOT on the menu
                    if (checkParent(target, helpMenu)) {
                    // click on the link
                    if (helpMenuDiv.classList.contains("hidden")) {
                        helpMenuDiv.classList.remove("hidden");
                    } else {helpMenuDiv.classList.add("hidden");}
                    } else {
                    // click both outside link and outside menu, hide menu
                    helpMenuDiv.classList.add("hidden");
                    }
                }
            
            }
            
            function checkParent(t, elm) {
                while(t.parentNode) {
                    if( t == elm ) {return true;}
                    t = t.parentNode;
                }
                return false;
            }
        </script>
        <!-- End toggle DropDown List -->

        <!-- Custom JavaScript code - @section ('html.body.scripts') -->
        @yield ('html.body.scripts')
        <!-- End custom JavaScript code -->
    </body>
</html>