<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => '[:vi]Lân Sư Rồng Đỏ[:vi][:en]Red Lion Dragon[:en]',
                'des' => '[:vi]Sản phẩm lân sư rồng đỏ sang trọng, phù hợp cho các dịp lễ hội.[:vi][:en]A luxurious red lion dragon product, suitable for festive occasions.[:en]',
                'price' => 180.00,
                'bg_img' => '/images/lan-su-rong-do-bg.jpg',
                'details_img' => '/images/lan-su-rong-do-details.jpg',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '[:vi]Lân Sư Rồng Vàng[:vi][:en]Yellow Lion Dragon[:en]',
                'des' => '[:vi]Sản phẩm lân sư rồng vàng sang trọng, có tính nghệ thuật cao.[:vi][:en]A luxurious yellow lion dragon product with high artistic value.[:en]',
                'price' => 200.00,
                'bg_img' => '/images/lan-su-rong-vang-bg.jpg',
                'details_img' => '/images/lan-su-rong-vang-details.jpg',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '[:vi]Lân Sư Rồng Xanh[:vi][:en]Green Lion Dragon[:en]',
                'des' => '[:vi]Sản phẩm lân sư rồng xanh được làm từ chất liệu thân thiện với môi trường.[:vi][:en]A green lion dragon product made from environmentally friendly materials.[:en]',
                'price' => 160.00,
                'bg_img' => '/images/lan-su-rong-xanh-bg.jpg',
                'details_img' => '/images/lan-su-rong-xanh-details.jpg',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '[:vi]Lân Sư Rồng Bạc[:vi][:en]Silver Lion Dragon[:en]',
                'des' => '[:vi]Sản phẩm lân sư rồng bạc hiện đại, thích hợp cho không gian nội thất hiện đại.[:vi][:en]A modern silver lion dragon product, suitable for contemporary interiors.[:en]',
                'price' => 190.00,
                'bg_img' => '/images/lan-su-rong-bac-bg.jpg',
                'details_img' => '/images/lan-su-rong-bac-details.jpg',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '[:vi]Lân Sư Rồng Hồng[:vi][:en]Pink Lion Dragon[:en]',
                'des' => '[:vi]Sản phẩm lân sư rồng hồng nổi bật, phù hợp cho các sự kiện đặc biệt.[:vi][:en]A striking pink lion dragon product, ideal for special events.[:en]',
                'price' => 170.00,
                'bg_img' => '/images/lan-su-rong-hong-bg.jpg',
                'details_img' => '/images/lan-su-rong-hong-details.jpg',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '[:vi]Lân Sư Rồng Cam[:vi][:en]Orange Lion Dragon[:en]',
                'des' => '[:vi]Sản phẩm lân sư rồng cam tươi sáng, mang lại sự hài lòng cho người dùng.[:vi][:en]A bright orange lion dragon product, ensuring user satisfaction.[:en]',
                'price' => 175.00,
                'bg_img' => '/images/lan-su-rong-cam-bg.jpg',
                'details_img' => '/images/lan-su-rong-cam-details.jpg',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
