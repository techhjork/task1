@extends('brackets/admin-ui::admin.layout.default')
@section('title', 'user-details')
@section('body')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Courses
                </div>
                <div class="card-body" v-cloak>
                    <div class="card-block">
                        <table class="table table-striped table-primary">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Class Name</th>
                                    {{-- <th scope="col">Enroll</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data !== null)
                                    @foreach ($data as $key => $value)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $value->name }}</td>
                                            <?php
                                            $student_course_occuppied = \App\Models\UserCourse::where([
                                                'course_id' => $value->id,
                                                'class_id' => $value->class_id,
                                                'user_id' => $student_id,
                                            ])->first();
                                            ?>
                                            @if ($student_course_occuppied == null)
                                                <td><a class="btn btn-success btn-sm" href="#"
                                                        onclick="enroll({{ $value->id }})">Enable Course</a></td>
                                                <td><button class="btn btn-primary btn-sm" href="#" disabled>Disable
                                                        Course</button></td>

                                            @else
                                                <td><button class="btn btn-success btn-sm" href="#" disabled>Enable
                                                        Course</button>
                                                </td>
                                                <td><a class="btn btn-primary btn-sm" href="#"
                                                        onclick="cancel_enroll({{ $student_course_occuppied->id }})">Disable
                                                        Course</a></td>

                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <h2>No Data Found</h2>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="base_url" value="{{ URL::to('/') }}" />
    <input type="hidden" id="student_id" value="{{ $student_id }}" />
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script type="text/javascript">
    function enroll(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            url: $('#base_url').val() + "/admin/users/store-user-course",
            data: {
                id: id,
                student_id: $('#student_id').val()
            },
            success: function(data) {
                location.reload();
            }
        });

    }

    function cancel_enroll(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'get',
            url: $('#base_url').val() + "/admin/users/delete-user-course",
            data: {
                id: id,
            },
            success: function(data) {
                location.reload();
            }
        });

    }
</script>
