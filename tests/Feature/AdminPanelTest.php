<?php

namespace Tests\Feature;

use App\Enums\RecommendationCriterion;
use App\Models\Accord;
use App\Models\AnswerOption;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Note;
use App\Models\Perfume;
use App\Models\Question;
use App\Models\RecommendationRule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_require_an_authenticated_administrator(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_administrator_can_log_in_and_log_out(): void
    {
        $administrator = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('secret-password'),
        ]);

        $this->post(route('admin.login.store'), [
            'email' => $administrator->email,
            'password' => 'secret-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($administrator);

        $this->post(route('admin.logout'))
            ->assertRedirect(route('admin.login'));

        $this->assertGuest();
    }

    public function test_non_administrators_cannot_access_the_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'viewer']);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_protected_admin_responses_disable_browser_caching(): void
    {
        $response = $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertHeader('Pragma', 'no-cache')
            ->assertHeader('Expires', '0');

        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('no-cache', $response->headers->get('Cache-Control'));
    }

    public function test_dashboard_uses_real_domain_counts(): void
    {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();
        Perfume::factory()->create(['brand_id' => $brand->id, 'category_id' => $category->id]);
        $accord = Accord::factory()->create();
        Note::factory()->create();

        $question = Question::query()->create([
            'text' => 'Que acordes prefieres?',
            'criterion' => RecommendationCriterion::Accord,
            'is_required' => true,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $option = AnswerOption::query()->create([
            'question_id' => $question->id,
            'label' => $accord->name,
            'value' => $accord->slug,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        RecommendationRule::query()->create([
            'answer_option_id' => $option->id,
            'criterion' => RecommendationCriterion::Accord,
            'target_id' => $accord->id,
            'weight' => 50,
            'is_active' => true,
        ]);

        $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewHas('metrics', function (array $metrics): bool {
                return collect($metrics)->pluck('value', 'label')->all() === [
                    'Perfumes' => 1,
                    'Marcas' => 1,
                    'Categorias' => 1,
                    'Acordes' => 1,
                    'Notas' => 1,
                    'Preguntas' => 1,
                    'Reglas' => 1,
                ];
            })
            ->assertSee('El universo Parfum, en orden.')
            ->assertSee('Perfumes')
            ->assertSee('Reglas');
    }
}
