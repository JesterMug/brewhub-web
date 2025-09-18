<?php

declare(strict_types=1);

use Migrations\AbstractSeed;

class ContentBlocksSeed extends AbstractSeed
{
    public function run(): void
    {
        $table = $this->table('content_blocks');
        $table->truncate();   // clears existing rows
        $data = [
            // Hero Section
            [
                'parent' => 'home',
                'label' => 'Hero Title',
                'description' => 'Main heading in the hero section.',
                'slug' => 'home_hero_title',
                'type' => 'text',
                'value' => 'Experience Reliable Premium Coffee Now',
            ],
            [
                'parent' => 'home',
                'label' => 'Hero Subtitle',
                'description' => 'Subheading in the hero section.',
                'slug' => 'home_hero_subtitle',
                'type' => 'text',
                'value' => 'Premium Coffee Blends and Merchandise from the Eastern Suburbs of Melbourne.',
            ],
            [
                'parent' => 'home',
                'label' => 'Hero Call To Action',
                'description' => 'Call to action button in the hero section.',
                'slug' => 'home_hero_call_to_action',
                'type' => 'text',
                'value' => 'Shop now',
            ],
            //Promotional section
            [
                'parent' => 'home',
                'label' => 'Promotional Heading',
                'description' => 'A heading for the promotional message.',
                'slug' => 'home_promo_heading',
                'type' => 'text',
                'value' => 'Experience our Blend of the Month!',
            ],
            [
                'parent' => 'home',
                'label' => 'Promotional Description',
                'description' => 'A description for the promotional message.',
                'slug' => 'home_promo_desc',
                'type' => 'text',
                'value' => 'This month&#39;s premium coffee blend was developed by our special blend makers in South Jamaica. With unique notes of Cinnamon and Soursop, try out our new speciality blend of the month. Stocks are limited.',
            ],
            [
                'parent' => 'home',
                'label' => 'Promotional Call To Action',
                'description' => 'A call to action for the promotional message.',
                'slug' => 'home_promo_call_to_action',
                'type' => 'text',
                'value' => 'Buy now',
            ],
            [
                'parent' => 'home',
                'label' => 'Project One Heading',
                'description' => 'A heading for project one.',
                'slug' => 'home_p1_heading',
                'type' => 'text',
                'value' => 'Premium Blends',
            ],
            [
                'parent' => 'home',
                'label' => 'Project One Description',
                'description' => 'A description for project one.',
                'slug' => 'home_p1_desc',
                'type' => 'text',
                'value' => 'Browse from our collection of premium hand-crafted beans, speciality blends and many more',
            ],
            [
                'parent' => 'home',
                'label' => 'Project Two Heading',
                'description' => 'A heading for project two.',
                'slug' => 'home_p2_heading',
                'type' => 'text',
                'value' => 'Straight from the source',
            ],
            [
                'parent' => 'home',
                'label' => 'Project Two Description',
                'description' => 'A description for project two.',
                'slug' => 'home_p2_desc',
                'type' => 'text',
                'value' => 'Experience fresh premium blends supplied straight from local farmers around the globe',
            ],
            [
                'parent' => 'home',
                'label' => 'Project Three Heading',
                'description' => 'A heading for project three.',
                'slug' => 'home_p3_heading',
                'type' => 'text',
                'value' => 'Reliable Delivery',
            ],
            [
                'parent' => 'home',
                'label' => 'Project Three Description',
                'description' => 'A description for project three.',
                'slug' => 'home_p3_desc',
                'type' => 'text',
                'value' => 'Experience same-day-delivery for local customers or simply use our worldwide delivery service powered by StarTrack.',
            ],
        ];

        $table = $this->table('content_blocks');
        $table->insert($data)->save();
    }
}
