<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\BulkDestroyCourse;
use App\Http\Requests\Admin\Course\DestroyCourse;
use App\Http\Requests\Admin\Course\IndexCourse;
use App\Http\Requests\Admin\Course\StoreCourse;
use App\Http\Requests\Admin\Course\UpdateCourse;
use App\Models\Classs;
use App\Models\Course;
use App\Models\UserCourse;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CoursesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCourse $request
     * @return array|Factory|View
     */
    public function index(IndexCourse $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Course::class)->modifyQuery(function ($query) {
            $query->has('classs')->with('classs');
        })->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'class_id', 'name', 'strength', 'level'],

            // set columns to searchIn
            ['id', 'name', 'strength']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id'),
                ];
            }
            return ['data' => $data];
        }

        return view('admin.course.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.course.create');
        $classes = Classs::get();
        return view('admin.course.create')->with(array('classes' => $classes));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCourse $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCourse $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['class_id'] = $sanitized['class_id']['id'];
        // Store the Course
        $course = Course::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/courses'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/courses');
    }

    /**
     * Display the specified resource.
     *
     * @param Course $course
     * @throws AuthorizationException
     * @return void
     */
    public function show(Course $course)
    {
        $this->authorize('admin.course.show', $course);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Course $course
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Course $course)
    {
        $datapre = $course;
        $this->authorize('admin.course.edit', $course);

        // $classes_first = Classs::where('id', $course->class_id)->first();
        $classes = Classs::get();
        // $classes_first = ['season_name' => $classes_first->toArray()];
        // $datapre = json_encode(array_merge($classes_first, json_decode($datapre, true)));
        return view('admin.course.edit', [
            'course' => $course,
            // 'datapre' => $datapre,
            'classes' => $classes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCourse $request
     * @param Course $course
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCourse $request, Course $course)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['class_id'] = $sanitized['class_id']['id'];
        // Update changed values Course
        $course->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/courses'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/courses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCourse $request
     * @param Course $course
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCourse $request, Course $course)
    {
        $UserCourses = UserCourse::where('course_id', $course->id)->get();
        if ($UserCourses->count() > 0) {
            $UserCourses->each->delete();
        }

        $course->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCourse $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCourse $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('courses')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
