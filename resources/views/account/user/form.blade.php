@extends('layouts.account')
@section('seo')
	<title>@lang('cabinet.settings.page_title')</title>
@endsection
@section('scripts')
@include('admin.components.tinymce_script')
@endsection

@section('styles')

@endsection

@section('main')
<div class="row">
	<div class="col s12">
		<h1 class="flow-text">
			@lang('cabinet.settings.user_info')
		</h1>
		<div class="card">
			<div class="card-content">
				<div class="row">
					@if(isset($user))
					<form class="col s12" method="post"
						action="{{ route('account-settings.update', ['id' => $user->id]) }}"
						enctype="multipart/form-data">
						@method('PATCH')
						@csrf
						<div class="row">
							<div class="col s12 right-align">
								<button class="btn waves-effect waves-light" type="submit">
									@lang('cabinet.settings.save')
									<i class="material-icons right">save</i>
								</button>
							</div>
						</div>
						@if ($errors->count() > 0)
						<div class="row">
							<ul class="col s-12">
								@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
						@endif
						<div class="row">
							<div class="col s12">
								<div class="row">
									{{-- GENERAL INFORMATION --}}
									<div class="col s12 m6">
										<div class="input-field col s12">
											<i class="material-icons prefix">account_circle</i>
											<input @if(isset($user)) value="{{$user->name}}" @endif id="name"
												name="name" type="text"
												class="validate  @error('name') invalid @enderror" required>
											<label class="active" for="name">@lang('cabinet.settings.name')</label>
										</div>
										<div class="input-field col s12">
											<i class="material-icons prefix">account_circle</i>
											<input @if(isset($user)) value="{{$user->surname}}" @endif id="surname"
												name="surname" type="text"
												class="validate  @error('surname') invalid @enderror" required>
											<label class="active" for="surname">@lang('cabinet.settings.surname')</label>
										</div>
										<div class="input-field col s12">
											<i class="material-icons prefix">email</i>
											<input @if(isset($user)) value="{{$user->email}}" @endif id="email"
												name="email" type="text"
												class="validate  @error('email') invalid @enderror" required>
											<label class="active" for="email">E-mail</label>
										</div>
										<div class="input-field col s12">
											<i class="material-icons prefix">local_phone</i>
											<input @if(isset($user)) value="{{$user->phone}}" @endif id="phone"
												name="phone" type="text"
												class="validate  @error('phone') invalid @enderror" required>
											<label class="active" for="phone">@lang('cabinet.settings.phone_1')</label>
										</div>
										<div class="input-field col s12">
											<i class="material-icons prefix">local_phone</i>
											<input @if(isset($user)) value="{{$user->second_phone}}" @endif
												id="second_phone" name="second_phone" type="text"
												class="validate  @error('second_phone') invalid @enderror">
											<label class="active" for="second_phone">@lang('cabinet.settings.phone_2')</label>
										</div>
										<div class="input-field col s12">
											{{-- <i class="material-icons prefix">fingerprint</i> --}}
											<label class="active">@lang('cabinet.settings.roles'):</label>
											<ul>
												@foreach($user->roles as $role)
												@foreach($role->languages as $language)
												@if($language->language==app()->getLocale())
												<li>{{$language->name}}</li>
												@endif
												@endforeach
												@endforeach
											</ul>
										</div>
									</div>
									{{-- AVATAR --}}
									<div class="col s12 m6">
										<div class="file-field input-field col s12">
											<div class="btn">
												<span>Фото</span>
												<input type="file" name="image">
											</div>
											<div class="file-path-wrapper">
												<input class="file-path validate" type="text" @if(isset($user->avatar))
													value="{{$user->avatar->filename}}" @endif
													placeholder="@lang('cabinet.settings.add_image')">
											</div>
										</div>
										@if(isset($user->avatar))
										<div class="col s12">
											<img src="/{{$user->avatar->filepath}}" alt="{{$user->avatar->filename}}"
												style="width: 100%; max-width: 300px;">
										</div>
										@endif
									</div>
								</div>
							</div>
						</div>
					</form>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
