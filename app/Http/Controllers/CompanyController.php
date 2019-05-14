<?php

namespace App\Http\Controllers;

use App\Models\CompanyUser;
use Illuminate\Http\Request;
use App\Models\Company;
use Datatables;
use DB;
use Validator;
use Auth;

class CompanyController extends Controller
{
    public static function index()
    {
        return view('company.index');
    }

    public static function getlist(Request $request)
    {
        if (Auth::guard('web')->user()->type == 7) {
            $data = CompanyUser::join('companies', 'company_users.company_id', 'companies.id')
                ->select('companies.*')
                ->where('company_users.user_id', Auth::guard('web')->user()->id)
                ->orderBy('id', 'desc');
        } else {
            $data = Company::orderBy('id', 'desc');
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('expiration_date', function ($data) {
                $date = $data->created_at;
                $date = $date->addMonths($data->time_limit);
                return $date;
            })
            ->addColumn('action', function ($data) {
                $string = "";

                $string .= '<a data-tooltip="tooltip" title="Thêm vai trò" href="' . route('company.edit', $data->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';

                $string .= '<a data-tooltip="tooltip" title="Thêm vai trò" href="javascript:;" onclick="deleteCompany(' . $data->id . ')" class="btn btn-danger btn_delete btn-xs"><i class="fa fa-trash"></i></a>';
                return $string;
            })
            ->make(true);

    }

    public static function getFormCreate()
    {
        return view('company.AddCompany');
    }

    public static function create(Request $request)
    {
        $data = $request->all();
        $company = Company::create($data);
        CompanyUser::create([
            'user_id' => Auth::guard('web')->user()->id,
            'company_id' => $company->id,
        ]);
        $message = 'Thêm mới thành công !';
        return redirect()->route('company.index', ['message' => $message]);

    }

    public static function edit(Request $request)
    {
        $id = $request->id;
        $data = Company::find($id);
        return view('company.Edit', [
            'data' => $data,
        ]);
    }

    public static function update(Request $request)
    {
        $data = $request->all();
        if (!empty($data['add_time_limit'])) {
            $company = Company::find($data['id']);
            $data['time_limit'] = $data['add_time_limit'] + $company->time_limit;
        }
        Company::find($data['id'])->update($data);
        $company = Company::find($data['id']);
        $message = 'Cập nhật công ty ' . $company->name . ' thành công !';
        return view('company.index', ['messageSuccess' => $message]);
    }

    public static function delete(Request $request)
    {
        $id = $request->id;
        $company = Company::find($id);

        if (!empty($company)) {

            DB::beginTransaction();
            try {

                $company->delete();

                DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => 'Tài khoản ' . $company->email . ' đã bị xóa',
                ]);

            } catch (Exception $e) {

                DB::rollback();

                Log::info($e->getMessage());

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage()
                ]);
            }
        } else {

            return response()->json([
                'error' => true,
                'message' => 'Không tìm thấy người dùng, vui lòng thử lại sau',
            ]);
        }
    }

    public function getListCompanyUser(Request $request)
    {
        $data = DB::table('company_users')
            ->join('companies', 'companies.id', '=', 'company_users.company_id')
            ->select('company_users.*','companies.name as name')
            ->where('company_users.user_id', $request->user_id)
            ->orderBy('id', 'desc')
            ->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $string = "";
                $string .= '<a data-tooltip="tooltip" title="Thêm vai trò" href="javascript:;" onclick="deleteCompanyUser(' . $data->id . ')" class="btn btn-danger btn_delete btn-xs"><i class="fa fa-trash"></i></a>';
                return $string;
            })
            ->make(true);
    }

    public static function deleteCompanyUser(Request $request)
    {
        $id = $request->id;
        $company = CompanyUser::find($id);

        if (!empty($company)) {

            DB::beginTransaction();
            try {

                $company->delete();

                DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => 'Bản ghi đã bị xóa!',
                ]);

            } catch (Exception $e) {

                DB::rollback();

                Log::info($e->getMessage());

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage()
                ]);
            }
        } else {

            return response()->json([
                'error' => true,
                'message' => 'Không tìm thấy người dùng, vui lòng thử lại sau',
            ]);
        }
    }
}

