<div class="block xl:hidden">
    <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-grey border-grey-dark hover:text-white hover:border-white">
        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <title>Menu</title>
            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
        </svg>
    </button>
</div>

<div class="w-full flex-grow xl:flex xl:items-center xl:w-auto hidden xl:block pt-6 xl:pt-0" id="nav-content">
    <ul class=" xl:flex justify-end flex-1 items-center">
        

        @if (auth()->user()->canModerate())
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.post.index') }}">@lang('Posts')</a>
        </li>
        <li class="mr-3">
            <div class="relative group admin-nav-group">
                <div class="flex items-center cursor-pointer group-hover:border-grey-light text-grey">
                    @lang('Comments')
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
                <div class="items-center absolute border rounded-b-lg p-1 bg-white p-2 invisible group-hover:visible w-full" style="min-width: 10rem;">
                    <a class="admin-nav-group-link" href="{{ route('admin.comment.index') }}" >@lang('View')</a>
                    <a class="admin-nav-group-link" href="{{ route('admin.subscription.index') }}" >@lang('Subscriptions')</a>
                </div>
            </div>
        </li>
        <!-- <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.comment.index') }}">@lang('Comments')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.subscription.index') }}">@lang('Subscriptions')</a>
        </li> -->
        <li class="mr-3">
            <div class="relative group admin-nav-group">
                <div class="flex items-center cursor-pointer group-hover:border-grey-light text-grey">
                    @lang('General')
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
                <div class="items-center absolute border rounded-b-lg p-1 bg-white p-2 invisible group-hover:visible w-full" style="min-width: 10rem;">
                    <a class="admin-nav-group-link" href="{{ route('admin.setting.edit') }}">@lang('Settings')</a>
                    <a class="admin-nav-group-link" href="{{ route('admin.category.index') }}">@lang('Categories')</a>
                    <a class="admin-nav-group-link" href="{{ route('admin.tag.index') }}">@lang('Tags')</a>
                    <a class="admin-nav-group-link" href="{{ route('admin.menu.edit') }}">@lang('Menu')</a>
                    <a class="admin-nav-group-link" href="{{ route('admin.form.index') }}">@lang('Form')</a>
                    <a class="admin-nav-group-link" href="{{ route('admin.media.index') }}">@lang('Media')</a>

                </div>
            </div>
        </li>
        <!-- <li class="mr-3">
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
            <a class="admin-nav-link" href="{{ route('admin.media.index') }}">@lang('Media')</a>
        </li> -->
        <!-- <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.user.index') }}">@lang('Users')</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.view.index') }}">@lang('Views')</a>
        </li> -->
        <!-- <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.setting.edit') }}">@lang('Settings')</a>
        </li> -->
        @endif

        <li class="mr-3">
            <div class="relative group admin-nav-group">
                <div class="flex items-center cursor-pointer group-hover:border-grey-light text-grey">
                    @lang('Statistics')
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
                <div class="items-center absolute border border-t-0 rounded-b-lg p-1 bg-white p-2 invisible group-hover:visible w-full" style="min-width: 8rem;">
                    <a class="admin-nav-group-link" href="{{ route('admin.view.index') }}">@lang('Views')</a>
                    <a class="admin-nav-group-link" href="{{ route('admin.user.index') }}">@lang('Users')</a>
                    <a class="admin-nav-group-link" href="{{ route('feeds.main') }}" target="_blank">@lang('RSS-feed')</a>
                </div>
            </div>
        </li>

        <li class="mr-3">
            <div class="relative group admin-nav-group">
                <div class="flex items-center cursor-pointer group-hover:border-grey-light text-grey">
                    @lang('Profile')
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
                <div class="items-center absolute border border-t-0 rounded-b-lg p-1 bg-white p-2 invisible group-hover:visible w-full" style="min-width: 8rem;">
                    <a class="admin-nav-group-link" href="{{ route('profile.show', auth()->user()) }}" >@lang('View')</a>
                    <a class="admin-nav-group-link" href="{{ route('profile.edit', auth()->user()) }}" >@lang('Edit')</a>
                    <hr class="border-t mx-2 border-grey-light">
                    <a class="admin-nav-group-link" href="{{ route('logout') }}">@lang('Logout')</a>
                </div>
            </div>
        </li>

        <!-- <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('feeds.main') }}" target="_blank">@lang('RSS-feed')</a>
        </li> -->
        <li class="mr-3">
            <a class="admin-nav-link-active font-bold" href="{{ route('home') }}" target="_blank">@lang('Site')</a>
        </li>

        
    </ul>
</div>