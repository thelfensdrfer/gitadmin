@if (session()->has('flash_notification.message'))
    <div class="ui container">
        <div class="ui {{ session('flash_notification.level') }} message">
            <i class="fa fa-cancel"></i>

            {!! session('flash_notification.message') !!}
        </div>
    </div>
@endif
