<?php


use Illuminate\Database\Seeder;

class StatusOrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_orders')->truncate();
        factory(\CodeDelivery\Models\StatusOrders::class)->create([
            'name' => 'Pedido recebido'
        ]);
        factory(\CodeDelivery\Models\StatusOrders::class)->create([
            'name' => 'Pagamento aprovado'
        ]);
        factory(\CodeDelivery\Models\StatusOrders::class)->create([
            'name' => 'Transporte em andamento'
        ]);
        factory(\CodeDelivery\Models\StatusOrders::class)->create([
            'name' => 'Entrega realizada'
        ]);
        factory(\CodeDelivery\Models\StatusOrders::class)->create([
            'name' => 'Cancelado'
        ]);
    }
}