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
            @if ($courses->count() != 0)
                @foreach ($courses as $course)
                    <div class="col-md-3 column">
                        <div class="card">
                            <div class="card-header">Cours Name : <span
                                    class="xxx">{{ $course->course->name ?? '' }}</span></div>
                            <div class="card-body">
                                <div>
                                    <?php
                                    $text = '-';
                                    if ($course->grade == 1) {
                                        $text = 'IG';
                                    } elseif ($course->grade == 2) {
                                        $text = 'G';
                                    } elseif ($course->grade == 3) {
                                        $text = 'VG';
                                    }
                                    ?>
                                    <span class="">Grade : <span
                                            class="xxx">{{ $text }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h2 class="mt-3">No Course Found</h2>
            @endif
        </div>
        {{-- <div class="d-flex justify-content-center">
            {!! $courses->links() !!}
        </div> --}}
        <input type="hidden" id="base_url" value="{{ URL::to('/') }}" />
    </div>
    <script type="text/javascript">
        var base_url = $('#base_url').val();

        function enrollment(id, class_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                url: base_url + "/user-detail",
                data: {
                    id: id,
                    class_id: class_id,
                },
                success: function(data) {
                    window.location.reload();
                }
            });

        }
    </script>

@endsection
