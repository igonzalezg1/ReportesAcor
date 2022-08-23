<aside id="sidebar-wrapper">
    <div class="sidebar-brand micolor">
        <img class="navbar-brand-full app-header-logo" src="https://1000marcas.net/wp-content/uploads/2021/06/Accor-logo.png" width="65"
             alt="Infyom Logo">
        <a href="{{ url('/') }}"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm micolor">
        <a href="{{ url('/') }}" class="small-sidebar-text">
            <img class="navbar-brand-full" src="https://1000marcas.net/wp-content/uploads/2021/06/Accor-logo.png" width="45px" alt=""/>
        </a>
    </div>
    <ul class="sidebar-menu colormenu">
        @include('layouts.menu')
    </ul>
</aside>
