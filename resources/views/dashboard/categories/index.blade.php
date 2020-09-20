@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{__('admin/maincategories.maincategories')}}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">{{__('messages.main')}}</a>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('admin/maincategories.all')}} </h4>
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
                                    <div class="card-body card-dashboard">
                                        <table
                                            class="table display nowrap table-striped table-bordered scroll-horizontal">
                                            <thead>
                                            <tr>
                                                <th> {{__('admin/edit.name')}}</th>
                                                <th> {{__('admin/maincategories.maincategory')}}</th>
                                                <th>{{__('admin/maincategories.slug')}}</th>
                                                <th>{{__('admin/maincategories.status')}}</th>
                                                <th>{{__('admin/maincategories.photo')}}</th>
                                                <th>{{__('admin/maincategories.operations')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @isset($maincategories)
                                                @foreach($maincategories as $categorie)
                                                    <tr>
                                                        <td>{{$categorie -> name}}</td>
                                                        <td>{{$categorie -> mainparent -> name ?? __('admin/maincategories.maincategory1')}}</td>
                                                        <td>{{$categorie -> slug}}</td>
                                                        <td>{{$categorie -> getActive()}}</td>
                                                        <td><img style="height: 100px; width: 100px; "
                                                                 src="{{$categorie -> photo}}"></td>
                                                        <td>
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Basic example">
                                                                <a href="{{route('admin.maincategories.edit',$categorie -> id)}}"
                                                                   class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">{{__('admin/maincategories.edit')}}</a>
                                                                <a href="{{route('admin.maincategories.delete',$categorie -> id)}}"
                                                                   class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">{{__('admin/maincategories.delete')}}</a>
                                                                <a href="{{route('admin.maincategories.changestatus',$categorie -> id)}}"
                                                                   class="btn btn-outline-cyan btn-min-width box-shadow-3 mr-1 mb-1">@if($categorie->is_active==0) {{__('admin/maincategories.changestatus')}} @else {{__('admin/maincategories.changestatus1')}}@endif</a>


                                                            </div>
                                                        </td>
                                                    </tr>

                                                @endforeach
                                            @endisset


                                            </tbody>
                                        </table>
                                        <div class="justify-content-center d-flex">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>







@stop
