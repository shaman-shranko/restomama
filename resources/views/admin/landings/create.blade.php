@extends ('layouts.account')

@section('scripts')
    @include('admin.components.tinymce_script')
@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                @if(isset($item->lang))
                    {{ $item->lang[app()->getLocale()]['title'] }}
                @else
                    Новая статья
                @endif
            </h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <form class="col s12" method="post" action="{{ route('articles.store') }}">
                            @include('admin.landings._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
