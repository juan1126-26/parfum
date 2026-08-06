<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoAndErrorPagesTest extends TestCase
{
    public function test_public_layout_renders_centralized_social_metadata(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('<link rel="canonical" href="'.route('about').'">', false)
            ->assertSee('<meta property="og:site_name" content="Parfum">', false)
            ->assertSee('<meta name="twitter:card" content="summary">', false)
            ->assertSee('<link rel="manifest" href="'.asset('site.webmanifest').'">', false);
    }

    public function test_sitemap_lists_the_public_pages(): void
    {
        $this->get(route('sitemap'))
            ->assertOk()
            ->assertSee('<?xml version="1.0" encoding="UTF-8"?>', false)
            ->assertSee(route('about'), false)
            ->assertSee(route('catalog'), false)
            ->assertSee(route('perfect-aroma'), false)
            ->assertSee(route('contact'), false);
    }

    public function test_missing_public_page_uses_the_branded_not_found_view(): void
    {
        $this->get('/una-fragancia-que-no-existe')
            ->assertNotFound()
            ->assertSee('No encontramos esta fragancia.');
    }
}
