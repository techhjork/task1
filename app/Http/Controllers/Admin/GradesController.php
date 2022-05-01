<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Grade\BulkDestroyGrade;
use App\Http\Requests\Admin\Grade\DestroyGrade;
use App\Http\Requests\Admin\Grade\IndexGrade;
use App\Http\Requests\Admin\Grade\StoreGrade;
use App\Http\Requests\Admin\Grade\UpdateGrade;
use App\Models\Grade;
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

class GradesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexGrade $request
     * @return array|Factory|View
     */
    public function index(IndexGrade $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Grade::class)->processRequestAndGet(
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
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.grade.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.grade.create');

        return view('admin.grade.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGrade $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreGrade $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Grade
        $grade = Grade::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/grades'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/grades');
    }

    /**
     * Display the specified resource.
     *
     * @param Grade $grade
     * @throws AuthorizationException
     * @return void
     */
    public function show(Grade $grade)
    {
        $this->authorize('admin.grade.show', $grade);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Grade $grade
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Grade $grade)
    {
        $this->authorize('admin.grade.edit', $grade);


        return view('admin.grade.edit', [
            'grade' => $grade,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGrade $request
     * @param Grade $grade
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateGrade $request, Grade $grade)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Grade
        $grade->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/grades'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/grades');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyGrade $request
     * @param Grade $grade
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyGrade $request, Grade $grade)
    {
        $grade->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyGrade $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyGrade $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('grades')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
