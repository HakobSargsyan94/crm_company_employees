<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = Company::all();
        return view('company.index', ['data' => $data]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Exception
     */
    public function getCompanies(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('company.show', $row->id).'" class="edit btn btn-info btn-sm">Show</a> <a href="'.route('company.edit', $row->id).'" class="edit btn btn-success btn-sm">Edit</a> <a href="/company/destroy/'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
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
        return view('company.create');
    }

    /**
     * @param CompanyRequest $request
     * @param Company $model
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function store(CompanyRequest $request, Company $model)
    {
        $validated = $request->validated();

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        try {
            $uploadRes = $this->uploadLogo($request);
            if ($uploadRes) {
                $model::create([
                    'name' => $request->name,
                    'address' => $request->address,
                    'logo' => $request->file('logo') ? $request->file('logo')->getClientOriginalName() : '',
                    'email' => $request->email
                ]);

                return redirect(route('company.index'));
            }

            throw new \Exception('Cant save the image');
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * @param $request
     * @return bool
     */
    private function uploadLogo ($request) {
        $file = $request->file('logo');
        if ($file) {
            $destinationPath = 'uploads';
            $res = $file->move($destinationPath,$file->getClientOriginalName());

            if ($res) {
                return true;
            }

            return false;
        } else {
            return true;
        }
    }

    /**
     * @param Company $company
     * @return void
     */
    public function show(Company $company)
    {
        $companyInfo = $company;
        $employees = $company->getEmployees ?? [];

        return view('company.show', ['companyInfo' => $companyInfo, 'employees' => $employees]);
    }

    /**
     * @param Company $company
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Company $company)
    {
        return view('company.edit', ['company' => $company]);
    }

    /**
     * @param CompanyRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function update(CompanyRequest $request)
    {
        $validated = $request->validated();

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        try {
            $uploadRes = $this->uploadLogo($request);
            if ($uploadRes) {
                $company = Company::find($request->id);
                $company->update([
                    'name' => $request->name,
                    'address' => $request->address,
                    'logo' => $request->file('logo') ? $request->file('logo')->getClientOriginalName() : $company->logo,
                    'email' => $request->email
                ]);

                return redirect(route('company.index'));
            }

            throw new \Exception('Cant save the image');
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
        Company::where('id', $id)->delete();
        return redirect(route('company.index'));
    }
}
