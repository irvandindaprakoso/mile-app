<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use \App\Models\Package;
use Illuminate\Support\Facades\Validator;

class PackageController extends BaseController
{
    /**
     * @var Package
     */
    protected $package;

    /**
     * PackageController constructor.
     * @param Package $package
     * @return void
     */
    public function __construct(Package $package)
    {
        $this->package = $package ?? new Package();
    }

    /**
     * @return Package[]|\Illuminate\Database\Eloquent\Collection
     */
    public function browse ()
    {
        return response()->json($this->package->all(), 200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function read ($id)
    {
        $detail = $this->package->find($id);
        if (!$detail) {
            return response()->json(['message' => 'Package not found'], 404);
        }
        return response()->json($detail, 200);
    }

    /**
     * @param Request $request
     */
    public function store (Request $request)
    {
        $validate = $this->validateInput($request);
        if ($validate) {
            return response()->json($validate->messages(), 500);
        }
        return response()->json($this->package->create($request->toArray()), 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return |null
     */
    public function put (Request $request, $id)
    {
        $validate = $this->validateInput($request);
        if ($validate) {
            return response()->json($validate->messages(), 500);
        }
        $detail = $this->package->find($id);
        if (!$detail instanceof Package) {
            return response()->json(['message' => 'Package not found'], 404);
        }

        $detail->update($request->toArray(), ["upsert" => true]);

        return response()->json($detail, 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return |null
     */
    public function patch (Request $request, $id)
    {
        $validate = $this->validateInput($request);
        if ($validate) {
            return response()->json($validate->messages(), 500);
        }
        $detail = $this->package->find($id);
        if (!$detail) {
            return response()->json(['message' => 'Package not found'], 404);
        }
        $patch = $request->all();
        $detail->fill($patch);
        $detail->save();

        return response()->json($detail, 200);
    }

    /**
     * @param $id
     */
    public function delete ($id)
    {
        $data = $this->package->find($id);
        $data->delete();

        return response()->json("Package has been successfully delete.", 200);
    }

    /**
     * @param Request $request
     */
    private function validateInput(Request $request)
    {
        $error = null;
        $rules = [
            "transaction_id" => "required|string",
            "customer_name" => "required|string",
            "customer_code" => "required|string",
            "transaction_amount" => "required|string",
            "transaction_discount" => "required|string",
            "transaction_additional_field" => "nullable|string",
            "transaction_payment_type" => "required|string",
            "transaction_state" => "required|string",
            "transaction_code" => "required|string",
            "transaction_order" => "required|integer", // default value 0
            "location_id" => "required|string",
            "organization_id" => 'required|integer',
            "created_at" => "required|date",
            "updated_at" => "required|date",
            "transaction_payment_type_name" => "required|string",
            "transaction_cash_amount" => "integer|min:0",
            "transaction_cash_change" => "integer|min:0",
            "customer_attribute.Nama_Sales" => "nullable|string|min:3|max:50",
            "customer_attribute.TOP" => "nullable|string",
            "customer_attribute.Jenis_Pelanggan" => "nullable|string",
            "connote.connote_id" => "required|string|max:36",
            "connote.connote_number" => "required|integer",
            "connote.connote_service" => "required|string|min:3",
            "connote.connote_service_price" => "required|integer",
            "connote.connote_amount" => "required|integer",
            "connote.connote_code" => "required|string|max:17",
            "connote.connote_booking_code" => "nullable|numeric",
            "connote.connote_order" => "required|integer",
            "connote.connote_state" => "required|string|min:3|max:10",
            "connote.connote_state_id" => "required|integer",
            "connote.zone_code_from" => "required|string",
            "connote.zone_code_to" => "required|string|min:3|max:10",
            "connote.surcharge_amount" => "nullable",
            "connote.transaction_id" => "required|string|max:36",
            "connote.actual_weight" => "required|integer",
            "connote.volume_weight" => "required|integer",
            "connote.chargeable_weight" => "required|integer",
            "connote.created_at" => "required|date",
            "connote.updated_at" => "required|date",
            "connote.organization_id" => "required|integer",
            "connote.location_id" => "required|string",
            "connote.connote_total_package" => "required|numeric",
            "connote.connote_surcharge_amount" => "required|numeric",
            "connote.connote_sla_day" => "required|numeric",
            "connote.location_name" => "required|string",
            "connote.location_type" => "required|string|min:3|max:10",
            "connote.source_tariff_db" => "required|string",
            "connote.id_source_tariff" => "required|numeric",
            "connote.pod" => "nullable",
            "connote.history" => "array",
            "origin_data.customer_name" => "required|string",
            "origin_data.customer_address" => "required|string",
            "origin_data.customer_email" => "required|email",
            "origin_data.customer_phone" => "required|string|min:6|max:16",
            "origin_data.customer_address_detail" => "nullable",
            "origin_data.customer_zip_code" => "required|numeric",
            "origin_data.zone_code" => "required|string",
            "origin_data.organization_id" => "required|integer",
            "origin_data.location_id" => "required|string",
            "destination_data.customer_name" => "required|string",
            "destination_data.customer_address" => "required|string",
            "destination_data.customer_email" => "nullable|email",
            "destination_data.customer_phone" => "nullable|string|min:6|max:16",
            "destination_data.customer_address_detail" => "required|string",
            "destination_data.customer_zip_code" => "required|numeric",
            "destination_data.zone_code" => "required|string|min:3|max:10",
            "destination_data.organization_id" => "required|integer",
            "destination_data.location_id" => "required|string",
            "koli_data.*.koli_length" => "required|integer",
            "koli_data.*.awb_url" => "required|url",
            "koli_data.*.created_at" => "required|date",
            "koli_data.*.koli_chargeable_weight" => "required|integer",
            "koli_data.*.koli_width" => "required|integer",
            "koli_data.*.koli_surcharge" => "array",
            "koli_data.*.koli_height" => "required|integer",
            "koli_data.*.updated_at" => "required|date",
            "koli_data.*.koli_description" => "required|string",
            "koli_data.*.koli_formula_id" => "nullable",
            "koli_data.*.connote_id" => "required|string|max:36",
            "koli_data.*.koli_volume" => "required|integer",
            "koli_data.*.koli_weight" => "required|integer",
            "koli_data.*.koli_id" => "required|string|max:36",
            "koli_data.*.koli_custom_field.awb_sicepat.harga_barang" => "nullable",
            "koli_data.*.koli_custom_field.harga_barang" => "nullable",
            "koli_data.*.koli_code" => "required|string|max:20",
            "custom_field.catatan_tambahan" => "required|string",
            "currentLocation.name" => "string",
            "currentLocation.code" => "string",
            "currentLocation.type" => "string",
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $error = $validator->errors();
        }
         return $error;
    }
}
