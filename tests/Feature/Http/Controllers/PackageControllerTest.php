<?php

namespace Tests\Feature;

use App\Http\Controllers\PackageController;
use App\Models\Package;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class PackageControllerTest extends TestCase
{

    use WithFaker;
    protected $requestData = [
        "transaction_id" => "d0090c40-539f-479a-8274-899b9970bddc",
        "customer_name" => "PT. AMARA PRIMATA",
        "customer_code" => "1678593",
        "transaction_amount" => "70700",
        "transaction_discount" => "0",
        "transaction_additional_field" => "",
        "transaction_payment_type" => "29",
        "transaction_state" => "PAID",
        "transaction_code" => "CGKFT20200715121",
        "transaction_order" => 121,
        "location_id" => "5cecb20b6c49615b174c3e74",
        "organization_id" => 6,
        "created_at" => "2020-07-15T04:11:12.000000Z",
        "updated_at" => "2020-07-15T04:11:22.000000Z",
        "transaction_payment_type_name" => "Invoice",
        "transaction_cash_amount" => 0,
        "transaction_cash_change" => 0,
        "customer_attribute" => [
            "Nama_Sales" => "Radit Fitrawikarsa",
            "TOP" => "14 Hari",
            "Jenis_Pelanggan" => "B2B"
        ],
        "connote" => [
            "connote_id" => "f70670b1-c3ef-4caf-bc4f-eefa702092ed",
            "connote_number" => 1,
            "connote_service" => "ECO",
            "connote_service_price" => 70700,
            "connote_amount" => 70700,
            "connote_code" => "AWB00100209082020",
            "connote_booking_code" => "",
            "connote_order" => 326931,
            "connote_state" => "PAID",
            "connote_state_id" => 2,
            "zone_code_from" => "CGKFT",
            "zone_code_to" => "SMG",
            "surcharge_amount" => null,
            "transaction_id" => "d0090c40-539f-479a-8274-899b9970bddc",
            "actual_weight" => 20,
            "volume_weight" => 0,
            "chargeable_weight" => 20,
            "created_at" => "2020-07-15T11:11:12+0700",
            "updated_at" => "2020-07-15T11:11:22+0700",
            "organization_id" => 6,
            "location_id" => "5cecb20b6c49615b174c3e74",
            "connote_total_package" => "3",
            "connote_surcharge_amount" => "0",
            "connote_sla_day" => "4",
            "location_name" => "Hub Jakarta Selatan",
            "location_type" => "HUB",
            "source_tariff_db" => "tariff_customers",
            "id_source_tariff" => "1576868",
            "pod" => null,
            "history" => []
        ],
        "connote_id" => "f70670b1-c3ef-4caf-bc4f-eefa702092ed",
        "origin_data" => [
            "customer_name" => "PT. NARA OKA PRAKARSA",
            "customer_address" => "JL. KH. AHMAD DAHLAN NO. 100, SEMARANG TENGAH 12420",
            "customer_email" => "info@naraoka.co.id",
            "customer_phone" => "024-1234567",
            "customer_address_detail" => null,
            "customer_zip_code" => "12420",
            "zone_code" => "CGKFT",
            "organization_id" => 6,
            "location_id" => "5cecb20b6c49615b174c3e74"
        ],
        "destination_data" => [
            "customer_name" => "PT AMARIS HOTEL SIMPANG LIMA",
            "customer_address" => "JL. KH. AHMAD DAHLAN NO. 01, SEMARANG TENGAH",
            "customer_email" => null,
            "customer_phone" => "0248453499",
            "customer_address_detail" => "KOTA SEMARANG SEMARANG TENGAH KARANGKIDUL",
            "customer_zip_code" => "50241",
            "zone_code" => "SMG",
            "organization_id" => 6,
            "location_id" => "5cecb20b6c49615b174c3e74"
        ],
        "koli_data" => [
            [
                "koli_length" => 0,
                "awb_url" => "https://tracking.mile.app/label/AWB00100209082020.1",
                "created_at" => "2020-07-15 11:11:13",
                "koli_chargeable_weight" => 9,
                "koli_width" => 0,
                "koli_surcharge" => [],
                "koli_height" => 0,
                "updated_at" => "2020-07-15 11:11:13",
                "koli_description" => "V WARP",
                "koli_formula_id" => null,
                "connote_id" => "f70670b1-c3ef-4caf-bc4f-eefa702092ed",
                "koli_volume" => 0,
                "koli_weight" => 9,
                "koli_id" => "e2cb6d86-0bb9-409b-a1f0-389ed4f2df2d",
                "koli_custom_field" => [
                    "awb_sicepat" => null,
                    "harga_barang" => null
                ],
                "koli_code" => "AWB00100209082020.1"
            ]
        ],
        "custom_field" => [
            "catatan_tambahan" => "JANGAN DI BANTING / DI TINDIH"
        ],
        "currentLocation" => [
            "name" => "Hub Jakarta Selatan",
            "code" => "JKTS01",
            "type" => "Agent"
        ]
    ];

    public function testBrowse()
    {
        $package = Mockery::mock(Package::class);

        $package->shouldReceive('all')->once()->andReturn($package);

        $package->shouldReceive('toJson')->andReturn('{"transaction_id":"d0090c40-539f-479a-8274-899b9970bddc"}');

        // Create an instance of the controller and call the method
        $controller = new PackageController($package);
        $response = $controller->browse();
        // Assert that the response is correct
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testReadReturnsPackageDetailsWhenPackageExists()
    {
        $id = "63ef25f04a4d43ee157238da";

        $package = Mockery::mock(Package::class);

        $package->shouldReceive('find')->once()->andReturn($package);

        $package->shouldReceive('toJson')->andReturn('{"transaction_id":"d0090c40-539f-479a-8274-899b9970bddc"}');

        // Create an instance of the controller and call the method
        $controller = new PackageController($package);
        $response = $controller->read($id);
        // Assert that the response is correct
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testReadReturns404WhenPackageDoesNotExist()
    {
        $id = "63ef25f04a4d43ee157238da";

        $package = Mockery::mock(Package::class);

        $package->shouldReceive('find')->once()->andReturnFalse();

        // Create an instance of the controller and call the method
        $controller = new PackageController($package);
        $response = $controller->read($id);
        // Assert that the response is correct
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testStoreCreatesPackageAndReturns200()
    {
        $mockPackage = Mockery::mock(Package::class);
        $mockPackage->shouldReceive('create')->once()->with($this->requestData);
        $this->app->instance(Package::class, $mockPackage);

        $response = $this->postJson('api/package', $this->requestData);
        $response->assertStatus(200);
    }

    public function testStoreReturns500WhenInputIsInvalid()
    {
        $requestData = [
            "transaction_id" => "d0090c40-539f-479a-8274-899b9970bddc",
            "customer_name" => null,
        ];
        $response = $this->postJson('api/package', $requestData);
        $response->assertStatus(500);
    }

    public function testPutMethodReturnsResponseWithDetail()
    {
        $id = "63ef25f04a4d43ee157238da";
        $requestData = new Request($this->requestData);

        // Create a mock of the Package model
        $package = Mockery::mock(Package::class);

        $package->shouldReceive('find')->once()->with($id)->andReturn($package);

        $package->shouldReceive('toJson')->andReturn('{"transaction_id":"d0090c40-539f-479a-8274-899b9970bddc"}');

        $package->shouldReceive('update')->once();

        // Create an instance of the controller and call the method
        $controller = new PackageController($package);
        $response = $controller->put($requestData, $id);
        // Assert that the response is correct
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPutMethodReturnsErrorWhenPackageNotFound()
    {
        $id = "63ef25f04a4d43ee157238da";
        $requestData = new Request($this->requestData);

        $package = Mockery::mock(Package::class);

        $package->shouldReceive('find')->once()->andReturnFalse();

        // Create an instance of the controller and call the method
        $controller = new PackageController($package);
        $response = $controller->put($requestData, $id);
        // Assert that the response is correct
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testPatchMethodReturnsResponseWithDetail()
    {
        $id = "63ef25f04a4d43ee157238da";
        $requestData = new Request($this->requestData);

        // Create a mock of the Package model
        $package = Mockery::mock(Package::class);

        $package->shouldReceive('find')->once()->with($id)->andReturn($package);

        $package->shouldReceive('toJson')->andReturn('{"transaction_id":"d0090c40-539f-479a-8274-899b9970bddc"}');

        $package->shouldReceive('fill')->once()->with($this->requestData);

        $package->shouldReceive('save')->once();

        // Create an instance of the controller and call the method
        $controller = new PackageController($package);
        $response = $controller->patch($requestData, $id);
        // Assert that the response is correct
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPatchMethodReturnsErrorWhenPackageNotFound()
    {
        $id = "63ef25f04a4d43ee157238da";
        $requestData = new Request($this->requestData);

        $package = Mockery::mock(Package::class);

        $package->shouldReceive('find')->once()->andReturnFalse();

        // Create an instance of the controller and call the method
        $controller = new PackageController($package);
        $response = $controller->patch($requestData, $id);
        // Assert that the response is correct
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDeletePackage()
    {
        $id = "63ef25f04a4d43ee157238da";

        // Create a mock of the Package model
        $package = Mockery::mock(Package::class);

        $package->shouldReceive('find')->once()->with($id)->andReturn($package);

        $package->shouldReceive('toJson')->andReturn('{"transaction_id":"d0090c40-539f-479a-8274-899b9970bddc"}');

        $package->shouldReceive('delete')->once();

        // Create an instance of the controller and call the method
        $controller = new PackageController($package);
        $response = $controller->delete($id);
        // Assert that the response is correct
        $this->assertEquals(200, $response->getStatusCode());
    }
}
