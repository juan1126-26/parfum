<?php

namespace Database\Seeders;

use App\Models\Accord;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Climate;
use App\Models\Note;
use App\Models\Occasion;
use App\Models\Perfume;
use App\Models\Season;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ParfumDemoSeeder extends Seeder
{
    public function run(): void
    {
        $brands = collect([
            ['name' => 'Estudio Parfum', 'slug' => 'estudio-parfum', 'country' => 'Colombia', 'description' => 'Una casa imaginada para explorar composiciones con carácter.', 'sort_order' => 1],
            ['name' => 'Atelier Umbral', 'slug' => 'atelier-umbral', 'country' => 'Francia', 'description' => 'Creaciones de autor inspiradas en la luz y la sombra.', 'sort_order' => 2],
            ['name' => 'Casa Nativa', 'slug' => 'casa-nativa', 'country' => 'España', 'description' => 'Aromas de gestos serenos y materias cálidas.', 'sort_order' => 3],
            ['name' => 'Lumen Atelier', 'slug' => 'lumen-atelier', 'country' => 'Italia', 'description' => 'Una mirada contemporánea sobre la elegancia cotidiana.', 'sort_order' => 4],
            ['name' => 'Oriente Claro', 'slug' => 'oriente-claro', 'country' => 'Emiratos Árabes Unidos', 'description' => 'Resinas, maderas y contrastes de presencia profunda.', 'sort_order' => 5],
        ])->mapWithKeys(fn (array $brand) => [
            $brand['slug'] => Brand::query()->updateOrCreate(
                ['slug' => $brand['slug']],
                [...$brand, 'is_active' => true],
            ),
        ]);

        $categories = collect([
            ['name' => 'Perfumería Árabe', 'slug' => 'perfumeria-arabe', 'description' => 'Profundidad, resinas y una presencia que permanece.', 'sort_order' => 1],
            ['name' => 'Perfumería de Diseñador', 'slug' => 'perfumeria-de-disenador', 'description' => 'Iconos contemporáneos para cada momento.', 'sort_order' => 2],
            ['name' => 'Perfumería Nicho', 'slug' => 'perfumeria-nicho', 'description' => 'Composiciones singulares para descubrir con calma.', 'sort_order' => 3],
            ['name' => 'Ediciones Especiales', 'slug' => 'ediciones-especiales', 'description' => 'Piezas creadas para celebrar lo excepcional.', 'sort_order' => 4],
            ['name' => 'Selección Parfum', 'slug' => 'seleccion-parfum', 'description' => 'Una mirada curada a aromas con personalidad.', 'sort_order' => 5],
        ])->mapWithKeys(fn (array $category) => [
            $category['slug'] => Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [...$category, 'is_active' => true],
            ),
        ]);

        $accords = collect([
            ['name' => 'Dulce', 'slug' => 'dulce', 'description' => 'Una sensación suave y envolvente.', 'color' => '#B28A43', 'sort_order' => 1],
            ['name' => 'Amaderado', 'slug' => 'amaderado', 'description' => 'Maderas que aportan estructura y calidez.', 'color' => '#8B6528', 'sort_order' => 2],
            ['name' => 'Ámbar', 'slug' => 'ambar', 'description' => 'Un acorde cálido, luminoso y persistente.', 'color' => '#C5AF82', 'sort_order' => 3],
            ['name' => 'Cítrico', 'slug' => 'citrico', 'description' => 'Una salida fresca y brillante.', 'color' => '#D7BD86', 'sort_order' => 4],
            ['name' => 'Especiado', 'slug' => 'especiado', 'description' => 'Matices secos con presencia sutil.', 'color' => '#7C5D2C', 'sort_order' => 5],
            ['name' => 'Floral', 'slug' => 'floral', 'description' => 'Pétalos que suavizan la composición.', 'color' => '#C99E97', 'sort_order' => 6],
            ['name' => 'Aromático', 'slug' => 'aromatico', 'description' => 'Hierbas y hojas de frescura limpia.', 'color' => '#75806F', 'sort_order' => 7],
            ['name' => 'Atalcado', 'slug' => 'atalcado', 'description' => 'Una textura delicada y aterciopelada.', 'color' => '#BBAEA1', 'sort_order' => 8],
            ['name' => 'Cuero', 'slug' => 'cuero', 'description' => 'Un matiz oscuro y estructurado.', 'color' => '#4E3B2A', 'sort_order' => 9],
            ['name' => 'Verde', 'slug' => 'verde', 'description' => 'Vegetación húmeda y luminosa.', 'color' => '#5F665E', 'sort_order' => 10],
        ])->mapWithKeys(fn (array $accord) => [
            $accord['slug'] => Accord::query()->updateOrCreate(
                ['slug' => $accord['slug']],
                [...$accord, 'is_active' => true],
            ),
        ]);

        $notes = $this->seedTaxonomy(Note::class, [
            ['name' => 'Bergamota', 'slug' => 'bergamota', 'sort_order' => 1], ['name' => 'Pimienta rosa', 'slug' => 'pimienta-rosa', 'sort_order' => 2], ['name' => 'Lavanda', 'slug' => 'lavanda', 'sort_order' => 3], ['name' => 'Jazmín', 'slug' => 'jazmin', 'sort_order' => 4], ['name' => 'Rosa', 'slug' => 'rosa', 'sort_order' => 5], ['name' => 'Cedro', 'slug' => 'cedro', 'sort_order' => 6], ['name' => 'Sándalo', 'slug' => 'sandalo', 'sort_order' => 7], ['name' => 'Ámbar', 'slug' => 'ambar-nota', 'sort_order' => 8], ['name' => 'Vainilla', 'slug' => 'vainilla', 'sort_order' => 9], ['name' => 'Incienso', 'slug' => 'incienso', 'sort_order' => 10], ['name' => 'Cuero', 'slug' => 'cuero-nota', 'sort_order' => 11], ['name' => 'Almizcle', 'slug' => 'almizcle', 'sort_order' => 12],
        ]);
        $climates = $this->seedTaxonomy(Climate::class, [
            ['name' => 'Cálido', 'slug' => 'calido', 'sort_order' => 1], ['name' => 'Templado', 'slug' => 'templado', 'sort_order' => 2], ['name' => 'Frío', 'slug' => 'frio', 'sort_order' => 3],
        ]);
        $seasons = $this->seedTaxonomy(Season::class, [
            ['name' => 'Primavera', 'slug' => 'primavera', 'sort_order' => 1], ['name' => 'Verano', 'slug' => 'verano', 'sort_order' => 2], ['name' => 'Otoño', 'slug' => 'otono', 'sort_order' => 3], ['name' => 'Invierno', 'slug' => 'invierno', 'sort_order' => 4],
        ]);
        $occasions = $this->seedTaxonomy(Occasion::class, [
            ['name' => 'Uso diario', 'slug' => 'uso-diario', 'sort_order' => 1], ['name' => 'Oficina', 'slug' => 'oficina', 'sort_order' => 2], ['name' => 'Cena', 'slug' => 'cena', 'sort_order' => 3], ['name' => 'Evento formal', 'slug' => 'evento-formal', 'sort_order' => 4], ['name' => 'Cita', 'slug' => 'cita', 'sort_order' => 5],
        ]);

        $perfumes = collect([
            ['name' => 'Velo de Ámbar', 'slug' => 'velo-de-ambar', 'brand' => 'estudio-parfum', 'category' => 'perfumeria-arabe', 'short_description' => 'Resinas suaves y maderas que se perciben con calma.', 'is_featured' => true, 'is_best_seller' => true, 'sort_order' => 1],
            ['name' => 'Madera Serena', 'slug' => 'madera-serena', 'brand' => 'estudio-parfum', 'category' => 'perfumeria-de-disenador', 'short_description' => 'Maderas limpias para una presencia cotidiana.', 'is_featured' => true, 'is_best_seller' => true, 'sort_order' => 2],
            ['name' => 'Luz Mineral', 'slug' => 'luz-mineral', 'brand' => 'estudio-parfum', 'category' => 'perfumeria-nicho', 'short_description' => 'Brillo cítrico y profundidad mineral en equilibrio.', 'is_featured' => true, 'is_best_seller' => true, 'sort_order' => 3],
            ['name' => 'Noche de Seda', 'slug' => 'noche-de-seda', 'brand' => 'estudio-parfum', 'category' => 'seleccion-parfum', 'short_description' => 'Un contraste suave entre especias y ámbar.', 'is_featured' => true, 'is_best_seller' => true, 'sort_order' => 4],
            ['name' => 'Ritual de Cedro', 'slug' => 'ritual-de-cedro', 'brand' => 'atelier-umbral', 'category' => 'perfumeria-nicho', 'short_description' => 'Cedro seco, incienso y una salida verde.', 'is_featured' => false, 'is_best_seller' => false, 'sort_order' => 5],
            ['name' => 'Jardín Velado', 'slug' => 'jardin-velado', 'brand' => 'casa-nativa', 'category' => 'ediciones-especiales', 'short_description' => 'Flores suaves sobre una base de maderas claras.', 'is_featured' => false, 'is_best_seller' => false, 'sort_order' => 6],
            ['name' => 'Oro Silente', 'slug' => 'oro-silente', 'brand' => 'oriente-claro', 'category' => 'perfumeria-arabe', 'short_description' => 'Ámbar, cuero y una estela de especias secas.', 'is_featured' => false, 'is_best_seller' => true, 'sort_order' => 7],
            ['name' => 'Aire de Lino', 'slug' => 'aire-de-lino', 'brand' => 'lumen-atelier', 'category' => 'perfumeria-de-disenador', 'short_description' => 'Acordes aromáticos de una frescura serena.', 'is_featured' => false, 'is_best_seller' => false, 'sort_order' => 8],
        ])->mapWithKeys(function (array $perfume) use ($brands, $categories): array {
            $model = Perfume::query()->updateOrCreate(
                ['slug' => $perfume['slug']],
                [
                    'name' => $perfume['name'],
                    'brand_id' => $brands[$perfume['brand']]->id,
                    'category_id' => $categories[$perfume['category']]->id,
                    'short_description' => $perfume['short_description'],
                    'description' => "Una composición concebida para revelar {$perfume['name']} con matices precisos y una presencia equilibrada.",
                    'editorial_story' => "{$perfume['name']} nace de una observación pausada de los contrastes que definen su carácter. Su recorrido invita a descubrir la fragancia con calma, desde el primer gesto hasta la estela final.",
                    'longevity_level' => $perfume['is_best_seller'] ? 'intense' : 'moderate',
                    'projection_level' => $perfume['is_featured'] ? 'moderate' : 'soft',
                    'intensity_level' => $perfume['is_best_seller'] ? 'intense' : 'moderate',
                    'is_featured' => $perfume['is_featured'],
                    'is_best_seller' => $perfume['is_best_seller'],
                    'is_active' => true,
                    'sort_order' => $perfume['sort_order'],
                ],
            );

            return [$perfume['slug'] => $model];
        });

        $perfumes['velo-de-ambar']->accords()->sync($this->accords($accords, [
            'dulce' => [88, 1, true], 'amaderado' => [76, 2, false], 'ambar' => [62, 3, false], 'citrico' => [46, 4, false], 'especiado' => [30, 5, false],
        ]));
        $perfumes['madera-serena']->accords()->sync($this->accords($accords, [
            'amaderado' => [82, 1, true], 'aromatico' => [61, 2, false], 'verde' => [42, 3, false],
        ]));
        $perfumes['luz-mineral']->accords()->sync($this->accords($accords, [
            'citrico' => [78, 1, true], 'verde' => [58, 2, false], 'amaderado' => [35, 3, false],
        ]));
        $perfumes['noche-de-seda']->accords()->sync($this->accords($accords, [
            'ambar' => [81, 1, true], 'especiado' => [63, 2, false], 'atalcado' => [46, 3, false],
        ]));
        $perfumes['ritual-de-cedro']->accords()->sync($this->accords($accords, [
            'amaderado' => [84, 1, true], 'cuero' => [57, 2, false], 'verde' => [38, 3, false],
        ]));
        $perfumes['jardin-velado']->accords()->sync($this->accords($accords, [
            'floral' => [77, 1, true], 'atalcado' => [55, 2, false], 'verde' => [36, 3, false],
        ]));
        $perfumes['oro-silente']->accords()->sync($this->accords($accords, [
            'ambar' => [86, 1, true], 'cuero' => [65, 2, false], 'especiado' => [48, 3, false],
        ]));
        $perfumes['aire-de-lino']->accords()->sync($this->accords($accords, [
            'aromatico' => [72, 1, true], 'citrico' => [49, 2, false], 'amaderado' => [31, 3, false],
        ]));

        foreach ($perfumes as $slug => $perfume) {
            $perfume->notes()->sync($this->notes($notes, match ($slug) {
                'velo-de-ambar' => ['bergamota' => ['top', 1], 'jazmin' => ['heart', 1], 'ambar-nota' => ['base', 1], 'vainilla' => ['base', 2]],
                'madera-serena' => ['bergamota' => ['top', 1], 'lavanda' => ['heart', 1], 'cedro' => ['base', 1], 'almizcle' => ['base', 2]],
                'luz-mineral' => ['bergamota' => ['top', 1], 'pimienta-rosa' => ['top', 2], 'jazmin' => ['heart', 1], 'sandalo' => ['base', 1]],
                'noche-de-seda' => ['pimienta-rosa' => ['top', 1], 'rosa' => ['heart', 1], 'ambar-nota' => ['base', 1], 'vainilla' => ['base', 2]],
                'ritual-de-cedro' => ['bergamota' => ['top', 1], 'incienso' => ['heart', 1], 'cedro' => ['base', 1]],
                'jardin-velado' => ['bergamota' => ['top', 1], 'rosa' => ['heart', 1], 'jazmin' => ['heart', 2], 'almizcle' => ['base', 1]],
                'oro-silente' => ['pimienta-rosa' => ['top', 1], 'incienso' => ['heart', 1], 'cuero-nota' => ['base', 1], 'ambar-nota' => ['base', 2]],
                default => ['bergamota' => ['top', 1], 'lavanda' => ['heart', 1], 'cedro' => ['base', 1], 'almizcle' => ['base', 2]],
            }));
            $perfume->climates()->sync($this->ids($climates, $slug === 'oro-silente' ? ['templado', 'frio'] : ['calido', 'templado']));
            $perfume->seasons()->sync($this->ids($seasons, $slug === 'oro-silente' ? ['otono', 'invierno'] : ['primavera', 'verano']));
            $perfume->occasions()->sync($this->ids($occasions, $slug === 'oro-silente' ? ['cena', 'evento-formal', 'cita'] : ['uso-diario', 'oficina']));
            $perfume->images()->updateOrCreate(['path' => "perfumes/{$slug}/cover.jpg"], ['alt_text' => "{$perfume->name}, imagen de portada", 'is_cover' => true, 'sort_order' => 1]);
            $perfume->images()->updateOrCreate(['path' => "perfumes/{$slug}/detail.jpg"], ['alt_text' => "Detalle de {$perfume->name}", 'is_cover' => false, 'sort_order' => 2]);
        }
    }

    private function accords($accords, array $intensities): array
    {
        return collect($intensities)->mapWithKeys(fn (array $pivot, string $slug) => [
            $accords[$slug]->id => [
                'intensity' => $pivot[0],
                'sort_order' => $pivot[1],
                'is_primary' => $pivot[2],
            ],
        ])->all();
    }

    private function seedTaxonomy(string $model, array $items): Collection
    {
        return collect($items)->mapWithKeys(fn (array $item) => [
            $item['slug'] => $model::query()->updateOrCreate(['slug' => $item['slug']], [...$item, 'is_active' => true]),
        ]);
    }

    private function notes($notes, array $stages): array
    {
        return collect($stages)->mapWithKeys(fn (array $pivot, string $slug) => [
            $notes[$slug]->id => ['stage' => $pivot[0], 'sort_order' => $pivot[1]],
        ])->all();
    }

    private function ids($items, array $slugs): array
    {
        return collect($slugs)->map(fn (string $slug) => $items[$slug]->id)->all();
    }
}
