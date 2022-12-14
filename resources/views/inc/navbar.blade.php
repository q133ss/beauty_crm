<ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">Главная</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">Секундомер</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('orders.index')}}">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">Записи</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('clients.index')}}">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">База клиентов</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('salons.index')}}">
            <i class="icon-box menu-icon"></i>
            @if(Auth()->user()->is_salon)
            <span class="menu-title">Салоны</span>
            @else
            <span class="menu-title">Салон</span>
            @endif
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#service_menu" aria-expanded="false" aria-controls="ui-basic">
            <i class="icon-disc menu-icon"></i>
            <span class="menu-title">Услуги</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="service_menu">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Услуги</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Категории</a></li>
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">Спящие клиенты</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">Свободные окна</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('finances.index')}}">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">Финансы</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">События</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">Рекорды</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('settings.index')}}">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">Настройки</span>
        </a>
    </li>
</ul>
