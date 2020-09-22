@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('messages.main')}} </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('admin.maincategories')}}"> {{__('admin/maincategories.maincategories')}} </a>
                                </li>
                                <li class="breadcrumb-item active">
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> {{__('admin/maincategories.addmaincategories')}} </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form"
                                              action="{{route('admin.maincategories.store')}} "
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf


                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-home"></i> {{__('admin/maincategories.maincategoriesinfo')}} </h4>
                                                <div class="form-group">
                                                    <label> {{__('admin/maincategories.photo')}} </label>
                                                    <label id="projectinput7" class="file center-block">
                                                        <input type="file" id="file" name="photo">
                                                        <span class="file-custom"></span>
                                                    </label>
                                                    @error('photo')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror                                        </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="projectinput1"> {{__('admin/maincategories.name')}}   </label>
                                                            <input type="text" id="name"
                                                                   class="form-control"
                                                                   value="{{old('name')}}"
                                                                   name="name">
                                                            @error("name")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 " >
                                                        <div class="form-group">
                                                            <label for="projectinput1"> {{__('admin/maincategories.slug')}}</label>
                                                            <input type="text" id="slug"
                                                                   class="form-control"
                                                                   value="{{old('slug')}}"
                                                                   name="slug">

                                                            @error("slug")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row hidden" id="cat_list">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="projectinput2"> {{__('admin/maincategories.choosemaincategories')}} </label>
                                                                <select name="parent_id" style="width:auto;" class=" form-control">
                                                                    <optgroup label=" ">
                                                                        @if($maincategories && $maincategories -> count() > 0)
{{--                                                                            @foreach($maincategories as $category)--}}
{{--                                                                                <option--}}
{{--                                                                                    value="{{$category -> id }}">{{$category -> name}}</option>--}}
{{--                                                                            @endforeach--}}
                                                                            @php
                                                                            if (App::getLocale() == "ar")
                                                                                subCatRecursion($maincategories, 0,'←');


                                                                            else
                                                                                subCatRecursion($maincategories, 0,'→');
                                                                                @endphp
                                                                        @endif
                                                                    </optgroup>
                                                                </select>
                                                                @error('parent_id')
                                                                <span class="text-danger"> {{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mt-1">
                                                            <input type="checkbox" value="1"
                                                                   name="is_active"
                                                                   id="switcheryColor4"
                                                                   class="switchery" data-color="success"
                                                                     checked />
                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">{{__('admin/maincategories.status')}}  </label>

                                                            @error("is_active")
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mt-1">
                                                            <input type="radio"
                                                                   name="type"
                                                                   value="1"
                                                                   checked
                                                                   class="switchery"
                                                                   data-color="success"
                                                            />

                                                            <label
                                                                class="card-title ml-1">
                                                                {{__('admin/maincategories.maincategory1')}}
                                                            </label>


                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group mt-1">
                                                            <input type="radio"
                                                                   name="type"
                                                                   value="2"
                                                                   class="switchery" data-color="success"
                                                            />

                                                            <label
                                                                class="card-title ml-1">
                                                                {{__('admin/maincategories.subcategory')}}
                                                            </label>

                                                        </div>
                                                        @error("type")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>

                                                </div>

                                            </div>


                                            </div>



                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> {{__('messages.cancel')}}
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> {{__('messages.save')}}
                                                </button>
                                            </div>
                                        </form>


                                        </div>
                                    </div>
                                </div>
                            </div>

                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>


@stop
@section('script')

    <script>
        $('input:radio[name="type"]').change(
            function(){
                if (this.checked && this.value == '2') {  // 1 if main cat - 2 if sub cat
                    $('#cat_list').removeClass('hidden');
                }else{
                    $('#cat_list').addClass('hidden');
                }
            });
    </script>
@stop
