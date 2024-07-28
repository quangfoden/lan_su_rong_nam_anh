<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            'id' => 2,
            'name' => 'About',
            'data' => serialize($this->aboutData()),
            'status' => 1,
            'created_by' => 1
        ];

        DB::table('settings')->insert($data);
    }

    private function homeData(): array
    {
        $general = [
            'name' => 'General',
            'data' => [
                'site_title' => '[:vi]Nam Anh Shop[:vi][:en]Nam Anh Online[:en]',
                'logo' => '/uploads/settings/home/general/logo.jpg',
                'favicon' => '/uploads/settings/home/general/logo-sm.jpg',
                'privacy' => [
                    'name' => '[:vi]ĐOÀN LÂN SƯ RỒNG NAM ANH[:vi][:en]NAM ANH LION - DRAGON DANCE[:en]',
                    'address' => '[:vi]47 xóm 7 Lại Thế , Phú Thượng, Tỉnh Thừa Thiên Huế, Vietnam.[:vi][:en]47 Hamlet 7 Lai The, Phu Thuong, Thua Thien Hue Province, Vietnam.[:en]',
                    'phone' => '+84 77 442 6342'
                ],
                'footer_center' => [
                    'content' => '[:vi]Nội dung: Mr. Ben Đơ[:vi][:en]Content: Mr. Ben Đơ[:en]',
                    'products' => '[:vi]Chuyên cung cấp các sản phẩm lân sư rồng.[:vi][:en]Specializing in providing lion dance and dragon dance products.[:en]',
                    'service' => '[:vi]Nhận nhảy Show cưới hỏi, tân gia, động thổ...[:vi][:en]Accept dance performances for wedding parties, housewarming parties, groundbreaking parties...[:en]',
                    'email' => 'namanh@gmail.com'
                ],
                'contact' => [
                    'link_fb' => 'https://www.facebook.com/cao.dinhngoc',
                    'link_page_fb' => 'https://www.facebook.com/profile.php?id=100063458805238',
                    'link_tt' => 'https://www.tiktok.com/@bendo2684?is_from_webapp=1&sender_device=pc',
                    'hotline' => '+84 77 442 6342',
                ],
                'contact_modal' => [
                    'text' => '[:vi]Liên hệ[:vi][:en]Contact[:en]',
                    'question' => '[:vi]Bạn có câu hỏi gì?[:vi][:en]Do you have any questions?[:en]',
                    'answer' => '[:vi]Vui lòng điền vào biểu mẫu và cho chúng tôi biết về mối quan tâm của bạn. Chúng tôi sẽ cố gắng hết sức để cung cấp các giải đáp cho các bạn.[:vi][:en]Please fill out the form and let us know about your concerns. We will do our best to provide you with answers.[:en]'
                ]
            ]
        ];
        $slide = [
            'name' => 'Slide Sec.',
            'data' => [
                [
                    'img' => '/assets/images/slides-home/slide1.jpg',
                    'title' => '[:vi]Hình ảnh 1[:vi][:en]Image 1[:en]',
                    'img_small' => '/assets/images/slides-home/slide1-small.jpg'
                ],
                [
                    'img' => '/assets/images/slides-home/slide2.jpg',
                    'title' => '[:vi]Hình ảnh 2[:vi][:en]Image 2[:en]',
                    'img_small' => '/assets/images/slides-home/slide1-small.jpg'
                ],
                [
                    'img' => '/assets/images/slides-home/slide3.jpg',
                    'title' => '[:vi]Hình ảnh 3[:vi][:en]Image 3[:en]',
                    'img_small' => '/assets/images/slides-home/slide1-small.jpg'
                ]
            ],
        ];

        $products = [
            'name' => 'Products Sec.',
            'data' => [
                'main_title' => '[:vi]Sản phẩm nổi bật[:vi][:en]Featured products[:en]',
                'more_text' => '[:vi]Xem thêm[:vi][:en]View more[:en]',
                'products_page_text' => '[:vi]Xem tất cả[:vi][:en]View all[:en]',
            ]
        ];

        $news = [
            'name' => 'News Sec.',
            'data' => [
                'main_title' => '[:vi]Bài viết nổi bật[:vi][:en]Featured articles[:en]',
                'news_page_text' => '[:vi]Xem tất cả[:vi][:en]View all[:en]',
            ]
        ];
        $about = [
            'name' => 'About Sec.',
            'data' => [
                'main_title' => '[:vi]Lân Sư Rồng Nam Anh[:vi][:en]NAM ANH LION DRAGON [:en]',
                'overview' => [
                    'title' => '[:vi]Lân Sư Rồng Nam Anh[:vi][:en]Nam Anh Lion Dragon[:en]',
                    'content' => "[:vi]Xin chào và chào mừng bạn đến với Nam Anh! Chúng tôi tự hào là địa chỉ tin cậy trong lĩnh vực cung cấp các sản phẩm và dịch vụ nhảy show lân sư rồng chất lượng cao. Với cam kết mang đến những trải nghiệm đầy ấn tượng và sự chuyên nghiệp, đoàn lân sư rồng luôn lắng nghe và đồng hành cùng bạn trong mọi sự kiện đặc biệt. Hãy cùng chúng tôi tạo nên những khoảnh khắc đáng nhớ và mang đến sự may mắn, thịnh vượng cho mỗi chặng đường của bạn![:vi][:en]Hello and welcome to Nam Anh! We are proud to be a trusted address in the field of providing high quality lion dance products and services. With a commitment to bring impressive experiences and professionalism, the lion dance troupe always listens and accompanies you in every special event. Let's create memorable moments with us and bring luck and prosperity to every step of your journey![:en]"
                ],
                'products' => [
                    'title' => '[:vi]Cung Cấp Sản Phẩm [:vi][:en]Provide products[:en]',
                    'content' => "[:vi]Khám phá bộ sưu tập lân sư rồng tinh xảo, chất lượng hàng đầu tại shop của chúng tôi - nơi đam mê và truyền thống hội tụ! Từ những mẫu lân sư rồng sống động đến các phụ kiện biểu diễn hoàn hảo, chúng tôi cam kết mang đến cho bạn những sản phẩm xuất sắc để tỏa sáng trong mọi sự kiện. Hãy để chúng tôi đồng hành cùng bạn trong mỗi bước nhảy đầy nghệ thuật và ý nghĩa![:vi][:en]Discover our top quality, spirited lion and dragon collection at our store - where passion and tradition meet! From live lion and dragon models to perfect performance accessories, we are committed to bringing you sharp production products to shine in every event. Let us accompany you in every dance step full of art and meaning![:en]"
                ],
                'service' => [
                    'title' => '[:vi]Dịch Vụ Múa Lân[:vi][:en]Lion Dance Service[:en]',
                    'content' => '[:vi]Biến mỗi sự kiện của bạn thành một màn trình diễn đầy sắc màu và sôi động với dịch vụ nhảy lân sư rồng chuyên nghiệp của chúng tôi! Dù là lễ khai trương, tân gia hay các sự kiện đặc biệt, đội ngũ lân sư rồng giàu kinh nghiệm sẽ mang đến may mắn, thịnh vượng và niềm vui cho bạn cùng khách mời. Hãy để chúng tôi góp phần tạo nên những khoảnh khắc đáng nhớ và ấn tượng không thể quên![:vi][:en]Turn any event into a colorful and vibrant spectacle with our professional lion dance services! Whether it is a grand opening, housewarming or a special event, our experienced lion dance team will bring good luck, prosperity and joy to you and your guests. Let us advise you on creating something memorable and unforgettable![:en]',
                ],
            ]
        ];
        return [
            $general,
            $slide,
            $news,
            $products,
            $about,
        ];
    }

    private function aboutData(): array
    {
        $ourValue = [
            'name' => 'Life Our Value Sec.',
            'data' => [
                'main_bg' => '/uploads/settings/about/1920x898.png',
                'content' => [
                    [
                        'title' => '[:vi]TỔNG QUAN[:vi][:en]OVERVIEW[:en]',
                        'content' => "[:vi]<p>Tại Nam Anh Shop, chúng tôi tự hào là điểm đến hàng đầu cho những sản phẩm và dịch vụ liên quan đến lân sư rồng. Với kinh nghiệm nhiều năm trong ngành, chúng tôi cung cấp các bộ đồ lân sư rồng chất lượng cao, được chế tác tỉ mỉ và mang đậm bản sắc văn hóa truyền thống. Bên cạnh đó, chúng tôi còn nhận tổ chức các show nhảy lân sư rồng cho các sự kiện quan trọng như khai trương, đám cưới, và các lễ hội.</p> <p>Chúng tôi cam kết mang đến cho bạn những sản phẩm và dịch vụ tuyệt vời nhất, từ những bộ đồ lân sư rồng đầy màu sắc và tinh xảo, đến những màn biểu diễn ấn tượng và chuyên nghiệp. Đội ngũ nghệ nhân của chúng tôi luôn sẵn sàng đồng hành và làm hài lòng khách hàng bằng sự nhiệt huyết và tâm huyết trong từng sản phẩm và dịch vụ.</p>[:vi][:en]<p>At Nam Anh Shop, we pride ourselves on being a leading destination for products and services related to lion and dragon dance. With many years of experience in the industry, we offer high-quality lion and dragon dance costumes, meticulously crafted and rich in traditional cultural significance. In addition, we provide lion and dragon dance shows for important events such as grand openings, weddings, and festivals.</p> <p>We are committed to delivering the best products and services, from vibrant and exquisite lion and dragon dance costumes to impressive and professional performances. Our team of artisans is always ready to accompany and satisfy our customers with enthusiasm and dedication in every product and service.</p>[:en]",
                        'bg' => '/uploads/settings/about/1920x898.png'
                    ],
                    [
                        'title' => '[:vi]SẢN PHẨM[:vi][:en]OUR PRODUCTS[:en]',
                        'content' => "[:vi]<p>Khám phá bộ sưu tập đồ lân sư rồng độc đáo tại Nam Anh Shop! Chúng tôi cung cấp các bộ trang phục lân sư rồng được chế tác tinh xảo, mang đậm bản sắc văn hóa truyền thống. Mỗi sản phẩm của chúng tôi được thiết kế với sự chú trọng đến chi tiết và chất lượng, nhằm mang đến cho bạn trải nghiệm biểu diễn hoàn hảo và ấn tượng.</p>[:vi][:en]<p>Explore our unique collection of lion and dragon dance costumes at Nam Anh Shop! We offer intricately crafted lion and dragon dance outfits that embody traditional cultural significance. Each of our products is designed with attention to detail and quality, aiming to provide you with a perfect and impressive performance experience.</p>[:en]",
                        'bg' => '/uploads/settings/about/1920x898.png'
                    ],
                    [
                        'title' => '[:vi]DỊCH VỤ[:vi][:en]OUR SERVICES[:en]',
                        'content' => "[:vi]<p>Tại Nam Anh Shop, chúng tôi cung cấp dịch vụ biểu diễn lân sư rồng chuyên nghiệp cho các sự kiện đặc biệt. Chúng tôi nhận tổ chức các show nhảy lân sư rồng cho khai trương, đám cưới, và các lễ hội, mang đến không khí sôi động và đầy màu sắc cho mọi dịp. Đội ngũ nghệ nhân của chúng tôi có kinh nghiệm phong phú và sẵn sàng tùy chỉnh chương trình biểu diễn để phù hợp với nhu cầu và yêu cầu của bạn. Chúng tôi cam kết mang đến một trải nghiệm biểu diễn đáng nhớ, giúp sự kiện của bạn trở nên thật đặc biệt và ấn tượng.</p>[:vi][:en]<p>At Nam Anh Shop, we offer professional lion and dragon dance performance services for special events. We organize lion and dragon dance shows for grand openings, weddings, and festivals, bringing vibrant and dynamic energy to every occasion. Our team of skilled performers has extensive experience and is ready to customize the performance to meet your needs and preferences. We are committed to delivering a memorable performance experience that makes your event truly special and impressive.</p>[:en]",
                        'bg' => '/uploads/settings/about/1920x898.png'
                    ],
                    [
                        'title' => '[:vi]LỢI ÍCH[:vi][:en]BENEFIT[:en]',
                        'content' => "[:vi]<p>Khi chọn Nam Anh Shop, bạn sẽ trải nghiệm nhiều lợi ích nổi bật. Chúng tôi cung cấp các sản phẩm đồ lân sư rồng chất lượng cao, được chế tác với sự tinh xảo và chú trọng đến từng chi tiết. Đội ngũ nghệ nhân giàu kinh nghiệm của chúng tôi đảm bảo rằng mỗi sản phẩm đều đạt tiêu chuẩn xuất sắc, mang lại sự hài lòng tuyệt đối cho khách hàng.</p><p>Ngoài ra, dịch vụ biểu diễn của chúng tôi mang đến những màn trình diễn ấn tượng và chuyên nghiệp, góp phần làm cho sự kiện của bạn trở nên đặc biệt hơn. Chúng tôi cam kết đồng hành cùng bạn từ khâu chuẩn bị đến thực hiện, đảm bảo mọi yêu cầu và mong muốn của bạn được đáp ứng một cách tốt nhất. Chọn Nam Anh Shop để nhận được sự phục vụ tận tâm và sản phẩm chất lượng, giúp sự kiện của bạn trở thành một trải nghiệm đáng nhớ.</p>[:vi][:en]<p>When you choose Nam Anh Shop, you will experience several outstanding benefits. We offer high-quality lion and dragon dance costumes, crafted with precision and attention to detail. Our team of experienced artisans ensures that each product meets excellent standards, providing complete satisfaction to our customers.</p><p>Additionally, our performance services deliver impressive and professional shows that enhance the uniqueness of your event. We are committed to supporting you from preparation to execution, ensuring that all your requests and preferences are met to the highest standards. Choose Nam Anh Shop for dedicated service and top-quality products, making your event a memorable experience.</p>[:en]",
                        'bg' => '/uploads/settings/about/1920x898.png'
                    ],
                    [
                        'title' => '[:vi]VÀ HƠN THẾ NỮA[:vi][:en]AND MORE[:en]',
                        'content' => "[:vi]<p>Chúng tôi còn nhiều hơn nữa, vẫn còn nhiều điều thú vị để khám phá</p> <p>
Chúng tôi luôn sẵn sàng hỗ trợ và đáp ứng mọi yêu cầu của bạn. Để biết thêm thông tin về sản phẩm, dịch vụ, hoặc để đặt lịch cho một sự kiện, vui lòng liên hệ với chúng tôi. Đội ngũ nhân viên của Nam Anh Shop sẽ tận tình giúp đỡ bạn và đảm bảo bạn nhận được sự phục vụ tốt nhất.</p>[:vi][:en]<p>There is much more to discover, and plenty of exciting things to explore.</p> <p>We are always ready to assist and meet your needs. For more information about our products, services, or to schedule an event, please contact us. The team at Nam Anh Shop is dedicated to providing you with the best service and ensuring that your needs are met with utmost care.</p>[:en]",
                        'bg' => '/uploads/settings/about/1920x898.png'
                    ]
                ]
            ]
        ];

        $withYou = [
            'name' => 'Life With You Sec.',
            'data' => [
                'main_title' => '[:vi]GIỚI THIỆU[:vi][:en]ABOUT US[:en]',
                'video' =>  '/videos/video2.mp4'
            ]
        ];
        $howWeHire = [
            'name' => 'Life How We Hire Sec.',
            'data' => [
                'main_title' => '[:vi]CÂU HỎI THƯỜNG GẶP[:vi][:en]FREQUENTLY ASKED QUESTIONS[:en]',
                'data' => [
                    'question' => [
                        [
                            'title' => '[:vi]Bạn có nhận biểu diễn lân sư rồng cho đám cưới không?[:vi][:en]Do you perform lion and dragon dances for weddings?[:en]',
                            'answer' => '[:vi]Có, chúng tôi chuyên nhận biểu diễn lân sư rồng cho đám cưới.[:vi][:en]Yes, we specialize in performing lion and dragon dances for weddings.[:en]'
                        ],
                        [
                            'title' => '[:vi]Giá biểu diễn lân sư rồng là bao nhiêu?[:vi][:en]How much does a lion and dragon dance performance cost?[:en]',
                            'answer' => '[:vi]Giá biểu diễn phụ thuộc vào loại hình và thời gian biểu diễn. Vui lòng liên hệ để nhận báo giá chi tiết.[:vi][:en]The cost of a performance depends on the type and duration of the performance. Please contact us for a detailed quote.[:en]'
                        ],
                        [
                            'title' => '[:vi]Bạn có biểu diễn cho sự kiện tân gia không?[:vi][:en]Do you perform for housewarming events?[:en]',
                            'answer' => '[:vi]Có, chúng tôi nhận biểu diễn lân sư rồng cho các sự kiện tân gia.[:vi][:en]Yes, we perform lion and dragon dances for housewarming events.[:en]'
                        ],
                        [
                            'title' => '[:vi]Cần đặt lịch trước bao lâu để thuê biểu diễn lân sư rồng?[:vi][:en]How far in advance should I book a lion and dragon dance performance?[:en]',
                            'answer' => '[:vi]Chúng tôi khuyến khích đặt lịch trước ít nhất 2 tuần để đảm bảo có sẵn lịch.[:vi][:en]We recommend booking at least 2 weeks in advance to ensure availability.[:en]'
                        ]
                    ],
                    'images_kh' => [
                        '/images/khachhang/kh1.jpg',
                        '/images/khachhang/kh1.jpg',
                        '/images/khachhang/kh1.jpg',
                        '/images/khachhang/kh1.jpg'
                    ],
                    'info' => [
                        'title' => '[:vi]Nếu bạn có bất kì thắc mắc nào hãy liên hệ với chúng tôi[:vi][:en]If you have any questions, please contact us[:en]',
                        'title_small' => '[:vi]Thông tin hỗ trợ:[:vi][:en]Supporting Information:[:en]',
                        'note_title_small' => '[:vi]Bạn có thể nhấp vào các icon nằm phía góc phải dưới cùng màn hình để kết nối với chúng tôi[:vi][:en]You can click on the icons in the bottom right corner of the screen to connect with us[:en]',
                        'hotline_title' => '[:vi]Gọi tư vấn đặt hàng online:[:vi][:en]Call online ordering advice:[:en]',
                        'zalo_title' => '[:vi]Liên hệ qua zalo:[:vi][:en]Contact via zalo:[:en]',
                        'fb_title' => '[:vi]Liên hệ qua Facebook:[:vi][:en]Contact via Facebook:[:en]',
                        'fanpage_title' => '[:vi]Fanpage:[:vi][:en]Fanpage:[:en]',
                        'customer_title' => '[:vi]Khách hàng[:vi][:en]Customer[:en]',
                    ]
                ]
            ]
        ];

        return [
            $ourValue,
            $withYou,
            $howWeHire
        ];
    }

}
