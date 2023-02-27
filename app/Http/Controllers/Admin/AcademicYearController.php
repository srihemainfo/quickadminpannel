<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAcademicYearRequest;
use App\Http\Requests\StoreAcademicYearRequest;
use App\Http\Requests\UpdateAcademicYearRequest;
use App\Models\AcademicYear;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcademicYearController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('academic_year_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $academicYears = AcademicYear::all();

        return view('admin.academicYears.index', compact('academicYears'));
    }

    public function create()
    {
        abort_if(Gate::denies('academic_year_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.academicYears.create');
    }

    public function store(StoreAcademicYearRequest $request)
    {
        $academicYear = AcademicYear::create($request->all());

        return redirect()->route('admin.academic-years.index');
    }

    public function edit(AcademicYear $academicYear)
    {
        abort_if(Gate::denies('academic_year_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.academicYears.edit', compact('academicYear'));
    }

    public function update(UpdateAcademicYearRequest $request, AcademicYear $academicYear)
    {
        $academicYear->update($request->all());

        return redirect()->route('admin.academic-years.index');
    }

    public function show(AcademicYear $academicYear)
    {
        abort_if(Gate::denies('academic_year_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $academicYear->load('academicCourseEnrollMasters');

        return view('admin.academicYears.show', compact('academicYear'));
    }

    public function destroy(AcademicYear $academicYear)
    {
        abort_if(Gate::denies('academic_year_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $academicYear->delete();

        return back();
    }

    public function massDestroy(MassDestroyAcademicYearRequest $request)
    {
        $academicYears = AcademicYear::find(request('ids'));

        foreach ($academicYears as $academicYear) {
            $academicYear->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
