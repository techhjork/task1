<style>
    span.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5 {
        margin-right: -6px;
    }

    svg.w-5.h-5 {
        height: 31px;
        /* width: 64px; */
    }

    .flex.justify-between.flex-1.sm\:hidden {
        display: none;
    }

    p.text-sm.text-gray-700.leading-5 {
        display: none;
    }

    .d-flex.justify-content-center {
        margin-top: 2%;
        float: right;
    }

    .col-md-3.column {
        margin-top: 7%;
    }

    .float-right.fr {
        margin-top: 5%;
    }

    .alert.alert-success {
        margin-top: 2%;
    }

</style>

@extends('layout')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (session('success'))
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if ($classes->count() != 0)
                @foreach ($classes as $classs)
                    <div class="col-md-3 column">
                        <div class="card">
                            <div class="card-header">Class Name : <span
                                    class="xxx">{{ $classs->classs->name }}</span>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <span class="xxx"><a
                                            href="{{ url('show-courses/' . $classs->classs->id) }}">
                                            view</a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h2>No Class Found</h2>
            @endif

        </div>
    </div>



@endsection
