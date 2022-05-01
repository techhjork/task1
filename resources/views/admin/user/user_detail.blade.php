@extends('brackets/admin-ui::admin.layout.default')

@section('title', 'user-details')
@section('body')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> User Detail

                </div>
                <div class="card-body" v-cloak>
                    <div class="card-block">
                        @if ($data->count() != 0)
                            <table class="table table-striped table-primary">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Class Name</th>
                                        <th scope="col">Course Name</th>

                                        <th scope="col">Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $value)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $value->classs->name }}</td>
                                            <td>{{ $value->course->name ?? 'Not available' }}</td>
                                            <td>
                                                <select
                                                    style="width: 140px;border:aquamarinenone;font-family: inherit;font-size: inherit;border-color: #9DB6FB;background: #9db6fc;color: black;border-radius: 4px;">
                                                    <option value="{{ $value->id ?? 0 }},0"
                                                        {{ $value->grade == 0 ? 'selected' : '' }}>-</option>
                                                    <option value="{{ $value->id ?? 0 }},1"
                                                        {{ $value->grade == 1 ? 'selected' : '' }}>IG</option>
                                                    <option value="{{ $value->id ?? 0 }},2"
                                                        {{ $value->grade == 2 ? 'selected' : '' }}>G</option>
                                                    <option value="{{ $value->id ?? 0 }},3"
                                                        {{ $value->grade == 3 ? 'selected' : '' }}>VG</option>
                                                </select>
                                            </td>
                                            <td><a class="btn btn-danger btn-sm" href="#"
                                                    onclick="delete_user({{ $value->id }})">Delete</a></td>
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
        <input type="hidden" id="base_url" value="{{ URL::to('/') }}" />
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script type="text/javascript">
    $(function() {
        var base_url = $('#base_url').val();
        $('select').on('change', function() {
            var value = this.value.split(",");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (value[0] === 0) {
                alert("invalid operation");
            } else {
                $.ajax({
                    type: 'GET',
                    url: base_url + "/admin/users/status-change",
                    data: {
                        id: value[0],
                        status: value[1],
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            }
        });
    });

    function delete_user(id) {
        $.ajax({
            type: 'GET',
            url: "delete-user",
            data: {
                id: id
            },
            success: function(data) {
                location.reload();
            }
        });
    }
</script>
