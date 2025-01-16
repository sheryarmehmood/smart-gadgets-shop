<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceProductIdWithVariationIdInCartsAndOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update the 'carts' table
        Schema::table('carts', function (Blueprint $table) {
            // Drop the foreign key for 'product_id'
            $table->dropForeign(['product_id']);

            // Drop the 'product_id' column
            $table->dropColumn('product_id');

            // Add the 'variation_id' column after 'quantity'
            $table->foreignId('variation_id')
                ->after('quantity')
                ->constrained('variations') // Link to the 'variations' table
                ->cascadeOnDelete();
        });

        // Update the 'order_items' table
        Schema::table('order_items', function (Blueprint $table) {
            // Drop the foreign key for 'product_id'
            $table->dropForeign(['product_id']);

            // Drop the 'product_id' column
            $table->dropColumn('product_id');

            // Add the 'variation_id' column after 'quantity'
            $table->foreignId('variation_id')
                ->after('quantity')
                ->constrained('variations') // Link to the 'variations' table
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert the changes in the 'carts' table
        Schema::table('carts', function (Blueprint $table) {
            // Drop the foreign key for 'variation_id'
            $table->dropForeign(['variation_id']);

            // Drop the 'variation_id' column
            $table->dropColumn('variation_id');

            // Add the 'product_id' column after 'quantity'
            $table->foreignId('product_id')
                ->after('quantity')
                ->constrained()
                ->onDelete('cascade');
        });

        // Revert the changes in the 'order_items' table
        Schema::table('order_items', function (Blueprint $table) {
            // Drop the foreign key for 'variation_id'
            $table->dropForeign(['variation_id']);

            // Drop the 'variation_id' column
            $table->dropColumn('variation_id');

            // Add the 'product_id' column after 'quantity'
            $table->foreignId('product_id')
                ->after('quantity')
                ->constrained()
                ->onDelete('cascade');
        });
    }
}
