<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeesRequest;
use App\Models\Company;
use App\Models\Employees;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmployeesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = Employees::all();
        return view('employees.index', ['data' => $data]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Exception
     */
    public function getEmployees(Request $request)
    {
        if ($request->ajax()) {
            $data = Employees::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('employees.edit', $row->id).'" class="edit btn btn-success btn-sm">Edit</a> <a href="/employees/destroy/'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $companies = Company::all();
        return view('employees.create', ['companies' => $companies]);
    }

    /**
     * @param EmployeesRequest $request
     * @param Employees $model
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function store(EmployeesRequest $request, Employees $model)
    {
        $validated = $request->validated();

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        try {
            $model::create($validated);

            return redirect(route('employees.index'));
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $employees= Employees::find($id);
        $companies = Company::all();
        return view('employees.edit', ['companies' => $companies,'employees' => $employees]);
    }

    /**
     * @param EmployeesRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function update(EmployeesRequest $request)
    {
        $validated = $request->validated();

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        try {
            $employees = Employees::find($request->id);
            $employees->update($validated);

            return redirect(route('employees.index'));
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Employees::where('id', $id)->delete();
        return redirect(route('employees.index'));
    }
}
