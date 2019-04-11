<div class="block xl:hidden">
    <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-grey border-grey-dark hover:text-white hover:border-white">
        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <title>Menu</title>
            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
        </svg>
    </button>
</div>

<div class="w-full flex-grow xl:flex xl:items-center xl:w-auto hidden xl:block pt-6 xl:pt-0" id="nav-content">
    <ul class="list-reset xl:flex justify-end flex-1 items-center">
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('profile.show', auth()->user()) }}">@lang('Profile')</a>
        </li>

        @if (auth()->user()->canModerate())
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.post.index') }}">@lang('Posts')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.comment.index') }}">@lang('Comments')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.subscription.index') }}">@lang('Subscriptions')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.category.index') }}">@lang('Categories')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.tag.index') }}">@lang('Tags')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.menu.edit') }}">@lang('Menu')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.form.index') }}">@lang('Form')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.user.index') }}">@lang('Users')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.view.index') }}">@lang('Views')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.setting.edit') }}">@lang('Settings')</a>
        </li>
        @endif

        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('feeds.main') }}" target="_blank">@lang('RSS-feed')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link-active font-bold" href="{{ route('home') }}" target="_blank">@lang('Site')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('logout') }}">@lang('Logout')</a>
        </li>
    </ul>
</div>