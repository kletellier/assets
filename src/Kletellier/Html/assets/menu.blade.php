  @use(GL\Core\Helpers\Utils)
<nav id="navmenu" class="navbar navbar-default ombre" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a href="{{ $menu->getUrl() }}" class="navbar-brand">{{ $menu->getTitle() }}</a>
        </div>

        <div class="collapse navbar-collapse" id="menu-collapse">
            <ul class="nav navbar-nav">
                @include('menuitems', ['items'=> $menu->getMenuItems() ])
            </ul>
        </div>
    </div>
</nav>