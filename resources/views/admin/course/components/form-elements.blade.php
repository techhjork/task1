<div class="form-group row align-items-center" :class="{'has-danger': errors.has('class_id'), 'has-success': fields.class_id && fields.class_id.valid }">
    <label for="class_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.course.columns.class_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <!-- <input type="text" v-model="form.class_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('class_id'), 'form-control-success': fields.class_id && fields.class_id.valid}" id="class_id" name="class_id" placeholder="{{ trans('admin.course.columns.class_id') }}"> -->

        <!-- <multiselect v-model="form.class_id" :name="class_id" :options="{{ $classes->toJson() }}" v-validate="'required'"
            label="class_id" id="class_id" :multiple="false">
        </multiselect> -->

        
        <multiselect v-model="form.class_id" name="class_id" :options="{{ $classes->toJson() }}"
                 id="class_id" :multiple="false" label="name" :class="{'form-control-danger': errors.has('class_id'), 'form-control-success': fields.class_id && fields.class_id.valid}" track-by="id">
        </multiselect>


        <div v-if="errors.has('class_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('class_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.course.columns.name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.course.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('strength'), 'has-success': fields.strength && fields.strength.valid }">
    <label for="strength" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.course.columns.strength') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.strength" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('strength'), 'form-control-success': fields.strength && fields.strength.valid}" id="strength" name="strength" placeholder="{{ trans('admin.course.columns.strength') }}">
        <div v-if="errors.has('strength')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('strength') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('level'), 'has-success': fields.level && fields.level.valid }">
    <label for="level" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.course.columns.level') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select type="text" v-model="form.level" v-validate="'required|integer'" @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('level'), 'form-control-success': fields.level && fields.level.valid}"
            id="level" name="level"
            placeholder="{{ trans('admin.package.columns.level') }}">
            <option value=''>Select</option>
            <option value='0' selected='selected'>Beginner</opion>
            <option value='1' selected='selected'>Intermediate</option>
            <option value='2' selected='selected'>Advanced</opion>
            <option value='3' selected='selected'>Expert</option>
        </select>
        <div v-if="errors.has('level')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('level') }}</div>
    </div>
</div>


