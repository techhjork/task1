@extends('brackets/admin-ui::admin.layout.default')
<style>
    input.btn.btn-success {
        margin: 10px 0px 10px 0px;
        float: right;
    }

</style>
@section('title', 'user-details')
@section('body')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> User Class Enroll

                </div>
                <form action="show-courses" method="GET">
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <select name="class_id" id="options" class="form-control">
                                <option value="">Select Class</option>
                                @foreach ($data as $option)
                                    <option value="{{ $option->id }}"
                                        {{ collect(old('options'))->contains($option->id) ? 'selected' : '' }}>
                                        {{ $option->name }}</option>
                                @endforeach
                            </select>
                            <input class="btn btn-success" type="submit" value="Submit" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="base_url" value="{{ URL::to('/') }}" />
    </div>
@endsection
