<?php

namespace Tests\Feature;

use Tests\TestCase;

class InstitutionalPagesTest extends TestCase
{
    public function test_about_page_renders_the_editorial_brand_experience(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Un aroma puede decir algo antes que las palabras.')
            ->assertSee('No queremos vender perfumes. Queremos revelar afinidades.')
            ->assertSee('Descubrir Mi Aroma Perfecto')
            ->assertDontSee('Estamos preparando el espacio');
    }

    public function test_contact_page_renders_contact_details_faq_and_instagram_placeholders(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('hola@parfum.co')
            ->assertSee('El universo Parfum, en imagenes.')
            ->assertSee('Como elijo mi primer perfume?')
            ->assertSee('Ir a Mi Aroma Perfecto')
            ->assertDontSee('Este espacio reunira las formas');
    }

    public function test_footer_links_to_public_pages_and_contact_channels(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('about'), false)
            ->assertSee(route('contact'), false)
            ->assertSee(route('perfect-aroma'), false)
            ->assertSee('hola@parfum.co');
    }
}
