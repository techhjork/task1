<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Classs\BulkDestroyClass;
use App\Http\Requests\Admin\Classs\DestroyClass;
use App\Http\Requests\Admin\Classs\IndexClass;
use App\Http\Requests\Admin\Classs\StoreClass;
use App\Http\Requests\Admin\Classs\UpdateClass;
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

class ClassesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexClass $request
     * @return array|Factory|View
     */
    public function index(IndexClass $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Classs::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name'],

            // set columns to searchIn
            ['id', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id'),
                ];
            }
            return ['data' => $data];
        }

        return view('admin.class.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        // $this->authorize('admin.class.create');

        return view('admin.class.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClass $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreClass $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Class
        $class = Classs::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/classes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/classes');
    }

    /**
     * Display the specified resource.
     *
     * @param Class $class
     * @throws AuthorizationException
     * @return void
     */
    public function show(Classs $class)
    {
        if($class){
          $this->authorize('admin.class.show', $class);
        }else{
            //return redirect('admin/classes');
        }
        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Class $class
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Classs $class)
    {
        $this->authorize('admin.class.edit', $class);

        return view('admin.class.edit', [
            'class' => $class,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClass $request
     * @param Class $class
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateClass $request, Classs $class)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Class
        $class->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/classes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/classes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyClass $request
     * @param Class $class
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyClass $request, Classs $class)
    {
        $Courses = Course::where('class_id', $class->id)->get();
        if ($Courses->count() > 0) {
            $Courses->each;
        }
        $UserCourses = UserCourse::where('class_id', $class->id)->get();
        if ($UserCourses->count() > 0) {
            $UserCourses->each->delete();
        }

        $class->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyClass $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyClass $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('classes')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
