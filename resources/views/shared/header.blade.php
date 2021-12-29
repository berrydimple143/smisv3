<div class="c-wrapper">
      <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button><a class="c-header-brand d-sm-none" href="#">SMIS</a>
        <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true"><span class="c-header-toggler-icon"></span></button>
        <?php
            use App\MenuBuilder\FreelyPositionedMenus;
            if(isset($appMenus['top menu'])){
                FreelyPositionedMenus::render( $appMenus['top menu'] , 'c-header-', 'd-md-down-none');
            }
        ?>
        <ul class="c-header-nav ml-auto mr-4">


          <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <small>{{ Auth::user()->email }}&nbsp; </small>
              <div class="c-avatar"><img class="c-avatar-img" src="{{config('app.url')}}images/Jad.jpg" alt="user@email.com"></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
              <!-- <a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-user"></use>
                </svg><form action="/logout" method="POST"> @csrf Super Admin</form>
              </a> -->
              <a class="dropdown-item" href="user/logout">
              <i class="c-icon cil-settings mr-2"></i>
                @csrf Settings

              </a>
              <a class="dropdown-item" href="{{ route('change.password') }}">
                  <i class="c-icon cil-account-logout mr-2"></i>
                @csrf Change Password
                <!-- <form action="user/logout" method="POST"> @csrf Logout</form> -->
              </a>
              <a class="dropdown-item" href="{{ route('app.logout') }}">
                  <i class="c-icon cil-media-step-backward mr-2"></i>
                @csrf Logout
                <!-- <form action="user/logout" method="POST"> @csrf Logout</form> -->
              </a>
            </div>
          </li>
        </ul>
        <div class="c-subheader px-3">
          <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <?php $segments = ''; ?>
            @for($i = 1; $i <= count(Request::segments()); $i++)
                <?php $segments .= '/'. Request::segment($i); ?>
                @if($i < count(Request::segments()))
                    <li class="breadcrumb-item">
                    @if (strpos(Request::segment($i), '-') !== false)
                        {{ ucwords(strtolower(explode("-", Request::segment($i))[0])) }} {{ ucwords(strtolower(explode("-", Request::segment($i))[1])) }}
                    @else
                        {{ ucwords(strtolower(Request::segment($i))) }}
                    @endif
                    </li>
                @else
                    <li class="breadcrumb-item active">
                    @if (strpos(Request::segment($i), '-') !== false)
                        {{ ucwords(strtolower(explode("-", Request::segment($i))[0])) }} {{ ucwords(strtolower(explode("-", Request::segment($i))[1])) }}
                    @else
                        {{ ucwords(strtolower(Request::segment($i))) }}
                    @endif
                    </li>
                @endif
            @endfor
          </ol>
        </div>
    </header>
