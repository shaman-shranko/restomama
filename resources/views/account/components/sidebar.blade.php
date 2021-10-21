<div class="card sidenav sidenav-fixed open" style="">
    <div class="card-content">
        <div class="user-view " style="background: #F65050">
{{--            <a href="{{ route('start') }}" class="brand-logo"><img src="/images/logo.png" alt="" /></a>--}}
            <label style="display: flex">
                @if(isset(auth()->user()->avatar))
                    <img class="circle responsive-img" src="/{{ auth()->user()->avatar->filepath }}">
                    @else
                    <img class="circle responsive-img" src="/images/default-user.png">
                @endif

                <span class="white-text name" style="padding-left: 15px;">{{ auth()->user()->surname }} {{ auth()->user()->name }}
                    {{ auth()->user()->secondname }}</span>
            </label>
        </div>
        @include('account.components.account_nav')
</div>
</div>

<style>
    .card.sidenav {
        /*transform: translateX(0%);*/
        /*position: relative;*/
        /*top: auto;*/
        /*bottom: auto;*/
        /*left: auto;*/
        /*right: auto;*/
        /*z-index: 0;*/
        /*height: auto;*/
        /*margin: 0.5rem 0 1rem 0;*/
        /*padding-bottom: 0;*/
        /*width: 100%;*/
    }

    .card.sidenav .card-content {
        padding-left: 0;
        padding-right: 0;
        padding-top: 0;
    }

    .card.sidenav li>a {
        height: 32px;
        line-height: 32px;
        text-transform: uppercase;
    }

    .card.sidenav .user-view .email {
        padding-bottom: 0;
    }

    .card.sidenav .user-view {
        padding-bottom: 16px;
    }
</style>
