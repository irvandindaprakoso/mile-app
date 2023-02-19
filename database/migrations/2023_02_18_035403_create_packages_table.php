<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint as MongoBlueprint;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('packages', function (MongoBlueprint $collection) {
            $collection->index('_id');
            // add your collection fields here
            $collection->string('transaction_id');
            $collection->string('customer_name');
            $collection->string('customer_code');
            $collection->string('transaction_amount');
            $collection->string('transaction_discount');
            $collection->string('transaction_additional_field');
            $collection->string('transaction_payment_type');
            $collection->string('transaction_state');
            $collection->string('transaction_code');
            $collection->integer('transaction_order');
            $collection->string('location_id');
            $collection->integer('organization_id');
            $collection->timestamp('created_at');
            $collection->timestamp('updated_at');
            $collection->string('transaction_payment_type_name');
            $collection->integer('transaction_cash_amount');
            $collection->integer('transaction_cash_change');
            $collection->string('connote_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mongodb')->dropIfExists('packages');
    }
}
