<?php

namespace App\Http\Controllers;

use App\Models\Admin_History;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Imageupload;
use App\Models\Node;
use App\Models\Product;
use Auth;
use Datatables;
use DB;
use Illuminate\Http\Request;
use QrCode;


class AdminProductController extends Controller
{
    public function getFormCreate()
    {
        $companies = Company::get();
        return view('admin.product.AddProduct', ['companies' => $companies]);
    }

    public function index()
    {
        return view('admin.product.index');
    }

    public function show($id)
    {
        $product = Product::find($id);
        $nodes = Node::where('product_id', $product->id)->get();

        return view('admin.product.showProduct', ['product' => $product, 'nodes' => $nodes]);
    }

    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getlist()
    {
        if (Auth::guard('web')->user()->type === 7) {
            $company_users = CompanyUser::where('user_id', Auth::guard('web')->user()->id)->get();
            $companyIdList = [];
            foreach ($company_users as $company_users) {
                array_push($companyIdList, $company_users->company_id);
            }

            $products = DB::table('products')
                ->join('companies', 'companies.id', '=', 'products.company_id')
                ->select('products.*', 'companies.name as company_name')
                ->whereIn('company_id', $companyIdList)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $products = DB::table('products')
                ->join('companies', 'companies.id', '=', 'products.company_id')
                ->select('products.*', 'companies.name as company_name')
                ->orderBy('id', 'desc')
                ->get();
        }

        return Datatables::of($products)
            ->editColumn('status', function ($products) {
                $string = "";
                if ($products->status == 1) {
                    $string = '<a data-tooltip="tooltip" title="Đã kích hoạt" href="javascript:;" onclick="activated(' . $products->id . ')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
                } else {
                    $string = '<a data-tooltip="tooltip" title="Chưa kích hoạt" href="javascript:;" onclick="activated(' . $products->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></a>';
                }
                return $string;
            })
            ->addIndexColumn()
            // ->addColumn()
            ->addColumn('action', function ($products) {
                $string = "";
                $string .= '<a data-tooltip="tooltip" title="Xem chi tiết" target="_blank" href="' . route('showBySlug', $products->slug) . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>';

                $string .= '<a data-tooltip="tooltip" title="Chỉnh sửa" href="' . route('product.edit', $products->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';

                $string .= '<a href="javascript:;" title="In mã QR-Code" class="btn btn-warning btn-xs" onclick="PrintImage(' . "'" .
                    base64_encode(QrCode::format('png')
                        ->size(200)
                        ->generate(url("/check/{$products->id}"))) . "'" . '); return false;"><i class="fa fa-print"></i></a></a>';

                $string .= '<a data-tooltip="tooltip" title="Xóa sản phẩm" href="javascript:;" onclick="deleteProduct(' . $products->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';

                return $string;
            })
            ->make(true);
    }

    public function edit($id)
    {
        $data = Product::find($id);
        $companies = Company::get();
        $url = url("/check/{$data->id}");
        $urlSlug = url("/show/{$data->slug}");
        $nodes = Node::where('product_id', $data['id'])->get();
        return view('admin.product.EditProduct', ['data' => $data, 'companies' => $companies, 'url' => $url, 'urlSlug' => $urlSlug, 'nodes' => $nodes]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('image');
            $data['image'] = $path;
        };

        $product = Product::create($data);

        $data['slug'] = str_slug($data['name']);

        $slug = Product::where('slug', $data['slug'])->first();
        if (!empty($slug['slug'])) {
            $data['slug'] = $data['slug'] . '-' . $product->id;
        }
        $check = Product::find($product->id)->update(['slug' => $data['slug']]);
        if ($check == true) {
            $user_history = new Admin_History();
            $user_history->user_id = Auth::guard('web')->user()->id;
            $user_history->content = 'Thêm mới sản phẩm: ' . $product->name;
            $user_history->save();
        }

        if ($request->hasFile('image')) {
            $image = new Imageupload();
            $image->content_id = $product->id;
            $image->path = $data['image'];
            $image->save();
        };

        if ($data['node'] == 0) {
            return redirect()->route('product.edit', ['id' => $product['id']]);
        } else {
            return redirect()->route('node.ShowFormCreate', ['node' => $data['node'], 'product_id' => $product['id'], 'company_id' => $product['company_id'],]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $product = Product::where('id', $data['id'])->first();
        $slug = Product::where('slug', $data['slug'])->first();
        if (!empty($slug['slug']) && $slug['id'] !== $product['id']) {
            $data['slug'] = $data['slug'] . '-' . $product->id;
        }
        Product::find($product->id)->update(['slug' => $data['slug']]);

        if ($request->hasFile('image_update')) {
            $path = $request->file('image_update')->store('image');
            $data['image'] = $path;
            $image = new Imageupload();
            $image->content_id = $product->id;
            $image->path = $data['image'];
            $image->save();
        };
        if (!empty($product)) {
            DB::beginTransaction();
            try {
                $product->update($data);

                DB::commit();

                return redirect()->route('product.edit', ['id' => $product['id']]);
            } catch (Exception $e) {
                DB::rollback();

                Log::info($e->getMessage());

                return redirect()->route('product.edit', ['id' => $product['id']]);
            }
        } else {

            return redirect()->route('product.edit', ['id' => $product['id']]);
        }
    }

    public function activated(Request $request)
    {
        $id = $request->id;
        $products = Product::find($id);
        if ($products->status == 1) {
            $data = Product::find($id)->update(['status' => 0]);
        } else {
            $data = Product::find($id)->update(['status' => 1]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Thay đổi trạng thái thành công !',
        ]);
    }


    public function destroy(Request $request)
    {
        $product = Product::find($request->id);

        if (!empty($product)) {
            DB::beginTransaction();
            try {
                $product->delete();

                DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => 'Sản phẩm ' . $product->name . ' đã bị xóa',
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
                'message' => 'Không tìm thấy sản phẩm, vui lòng thử lại sau',
            ]);
        }
    }

}
