<div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block pt-6 lg:pt-0" id="nav-content">
    <ul class="list-reset lg:flex justify-end flex-1 items-center">
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.post.index') }}">Posts</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.comment.index') }}">Comments</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.subscription.index') }}">Subscriptions</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.category.index') }}">Categories</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.tag.index') }}">Tags</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.menu.edit') }}">Menu</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.form.index') }}">Form</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.user.index') }}">Users</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('admin.view.index') }}">Views</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('feeds.main') }}" target="_blank">RSS-feed</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link-active font-bold" href="{{ route('home') }}" target="_blank">Site</a>
        </li>
        <li class="mr-3">
            <a class="admin-nav-link" href="{{ route('logout') }}">Logout</a>
        </li>
    </ul>
</div>