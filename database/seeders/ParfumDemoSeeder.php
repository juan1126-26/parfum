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
        $brand = Brand::query()->firstOrCreate(
            ['slug' => 'jean-paul-gaultier'],
            [
                'name' => 'Jean Paul Gaultier',
                'country' => 'Francia',
                'description' => 'Casa francesa reconocida por fragancias de caracter distintivo.',
                'is_active' => true,
                'sort_order' => 1,
            ],
        );

        $category = Category::query()->firstOrCreate(
            ['slug' => 'perfumeria-de-disenador'],
            [
                'name' => 'Perfumeria de Disenador',
                'description' => 'Iconos contemporaneos para cada momento.',
                'is_active' => true,
                'sort_order' => 1,
            ],
        );

        $accords = $this->seedTaxonomy(Accord::class, [
            ['name' => 'Aromatico', 'slug' => 'aromatico', 'description' => 'Hierbas y hojas de frescura limpia.', 'color' => '#75806F', 'sort_order' => 1],
            ['name' => 'Vainilla', 'slug' => 'vainilla', 'description' => 'Un acorde cremoso y envolvente.', 'color' => '#B28A43', 'sort_order' => 2],
            ['name' => 'Fresco especiado', 'slug' => 'fresco-especiado', 'description' => 'Especias luminosas con un efecto fresco.', 'color' => '#8AA1A2', 'sort_order' => 3],
            ['name' => 'Lavanda', 'slug' => 'lavanda', 'description' => 'Un matiz aromatico, limpio y floral.', 'color' => '#9C93B8', 'sort_order' => 4],
            ['name' => 'Calido especiado', 'slug' => 'calido-especiado', 'description' => 'Especias calidas y profundas.', 'color' => '#9B673C', 'sort_order' => 5],
            ['name' => 'Verde', 'slug' => 'verde', 'description' => 'Vegetacion humeda y luminosa.', 'color' => '#5F665E', 'sort_order' => 6],
            ['name' => 'Atalcado', 'slug' => 'atalcado', 'description' => 'Una textura delicada y aterciopelada.', 'color' => '#BBAEA1', 'sort_order' => 7],
            ['name' => 'Dulce', 'slug' => 'dulce', 'description' => 'Una sensacion suave y envolvente.', 'color' => '#B28A43', 'sort_order' => 8],
            ['name' => 'Ambar', 'slug' => 'ambar', 'description' => 'Un acorde calido, luminoso y persistente.', 'color' => '#C5AF82', 'sort_order' => 9],
            ['name' => 'Amaderado', 'slug' => 'amaderado', 'description' => 'Maderas que aportan estructura y calidez.', 'color' => '#8B6528', 'sort_order' => 10],
            ['name' => 'Frutal', 'slug' => 'frutal', 'description' => 'Frutas que aportan brillo y jugosidad.', 'color' => '#D5A66B', 'sort_order' => 11],
            ['name' => 'Canela', 'slug' => 'canela', 'description' => 'Una especia dulce, calida y vibrante.', 'color' => '#9C5B35', 'sort_order' => 12],
            ['name' => 'Iris', 'slug' => 'iris', 'description' => 'Un matiz floral suave y empolvado.', 'color' => '#9B8FA2', 'sort_order' => 13],
            ['name' => 'Miel', 'slug' => 'miel', 'description' => 'Una faceta dorada, dulce y envolvente.', 'color' => '#C6933E', 'sort_order' => 14],
            ['name' => 'Tabaco', 'slug' => 'tabaco', 'description' => 'Un acorde profundo, seco y calido.', 'color' => '#70452E', 'sort_order' => 15],
            ['name' => 'Haba Tonka', 'slug' => 'haba-tonka', 'description' => 'Una calidez cremosa con matices almendrados.', 'color' => '#8D6A4A', 'sort_order' => 16],
            ['name' => 'Anis', 'slug' => 'anis', 'description' => 'Una especia fresca de caracter anisado.', 'color' => '#7A8D71', 'sort_order' => 17],
            ['name' => 'Coco', 'slug' => 'coco', 'description' => 'Una faceta cremosa, solar y tropical.', 'color' => '#D9C5A0', 'sort_order' => 18],
            ['name' => 'Fresco', 'slug' => 'fresco', 'description' => 'Una sensacion limpia y luminosa.', 'color' => '#8BB5BD', 'sort_order' => 19],
            ['name' => 'Tropical', 'slug' => 'tropical', 'description' => 'Un perfil exotico y soleado.', 'color' => '#D5AE57', 'sort_order' => 20],
            ['name' => 'Acuatico', 'slug' => 'acuatico', 'description' => 'Un efecto fresco inspirado en el agua.', 'color' => '#609EAC', 'sort_order' => 21],
            ['name' => 'Caramelo', 'slug' => 'caramelo', 'description' => 'Una dulzura dorada y gourmand.', 'color' => '#A96B31', 'sort_order' => 22],
        ]);

        $notes = $this->seedTaxonomy(Note::class, [
            ['name' => 'Lavanda', 'slug' => 'lavanda', 'sort_order' => 1],
            ['name' => 'Menta', 'slug' => 'menta', 'sort_order' => 2],
            ['name' => 'Cardamomo', 'slug' => 'cardamomo', 'sort_order' => 3],
            ['name' => 'Bergamota', 'slug' => 'bergamota', 'sort_order' => 4],
            ['name' => 'Artemisia', 'slug' => 'artemisia', 'sort_order' => 5],
            ['name' => 'Canela', 'slug' => 'canela', 'sort_order' => 6],
            ['name' => 'Flor de Azahar', 'slug' => 'flor-de-azahar', 'sort_order' => 7],
            ['name' => 'Alcaravea', 'slug' => 'alcaravea', 'sort_order' => 8],
            ['name' => 'Vainilla', 'slug' => 'vainilla', 'sort_order' => 9],
            ['name' => 'Haba Tonka', 'slug' => 'haba-tonka', 'sort_order' => 10],
            ['name' => 'Ambar', 'slug' => 'ambar-nota', 'sort_order' => 11],
            ['name' => 'Sandalo', 'slug' => 'sandalo', 'sort_order' => 12],
            ['name' => 'Cedro', 'slug' => 'cedro', 'sort_order' => 13],
            ['name' => 'Pera', 'slug' => 'pera', 'sort_order' => 14],
            ['name' => 'Limon', 'slug' => 'limon', 'sort_order' => 15],
            ['name' => 'Salvia', 'slug' => 'salvia', 'sort_order' => 16],
            ['name' => 'Vainilla Negra', 'slug' => 'vainilla-negra', 'sort_order' => 17],
            ['name' => 'Pachuli', 'slug' => 'pachuli', 'sort_order' => 18],
            ['name' => 'Iris', 'slug' => 'iris', 'sort_order' => 19],
            ['name' => 'Notas orientales', 'slug' => 'notas-orientales', 'sort_order' => 20],
            ['name' => 'Notas amaderadas', 'slug' => 'notas-amaderadas', 'sort_order' => 21],
            ['name' => 'Benjui', 'slug' => 'benjui', 'sort_order' => 22],
            ['name' => 'Miel', 'slug' => 'miel', 'sort_order' => 23],
            ['name' => 'Tabaco', 'slug' => 'tabaco', 'sort_order' => 24],
            ['name' => 'Anis', 'slug' => 'anis', 'sort_order' => 25],
            ['name' => 'Coco', 'slug' => 'coco', 'sort_order' => 26],
            ['name' => 'Piña', 'slug' => 'pina', 'sort_order' => 27],
            ['name' => 'Jengibre', 'slug' => 'jengibre', 'sort_order' => 28],
            ['name' => 'Cipres', 'slug' => 'cipres', 'sort_order' => 29],
            ['name' => 'Ambar Gris', 'slug' => 'ambar-gris', 'sort_order' => 30],
            ['name' => 'Notas verdes', 'slug' => 'notas-verdes', 'sort_order' => 31],
            ['name' => 'Notas acuaticas', 'slug' => 'notas-acuaticas', 'sort_order' => 32],
            ['name' => 'Higo', 'slug' => 'higo', 'sort_order' => 33],
            ['name' => 'Sal', 'slug' => 'sal', 'sort_order' => 34],
            ['name' => 'Mandarina', 'slug' => 'mandarina', 'sort_order' => 35],
            ['name' => 'Esclarea', 'slug' => 'esclarea', 'sort_order' => 36],
            ['name' => 'Caramelo', 'slug' => 'caramelo', 'sort_order' => 37],
            ['name' => 'Vetiver', 'slug' => 'vetiver', 'sort_order' => 38],
        ]);

        $climates = $this->seedTaxonomy(Climate::class, [
            ['name' => 'Templado', 'slug' => 'templado', 'sort_order' => 1],
            ['name' => 'Frio', 'slug' => 'frio', 'sort_order' => 2],
            ['name' => 'Calido', 'slug' => 'calido', 'sort_order' => 3],
        ]);
        $seasons = $this->seedTaxonomy(Season::class, [
            ['name' => 'Otono', 'slug' => 'otono', 'sort_order' => 1],
            ['name' => 'Invierno', 'slug' => 'invierno', 'sort_order' => 2],
            ['name' => 'Primavera', 'slug' => 'primavera', 'sort_order' => 3],
            ['name' => 'Verano', 'slug' => 'verano', 'sort_order' => 4],
        ]);
        $occasions = $this->seedTaxonomy(Occasion::class, [
            ['name' => 'Diario', 'slug' => 'diario', 'sort_order' => 1],
            ['name' => 'Oficina', 'slug' => 'oficina', 'sort_order' => 2],
            ['name' => 'Citas', 'slug' => 'citas', 'sort_order' => 3],
            ['name' => 'Noche', 'slug' => 'noche', 'sort_order' => 4],
            ['name' => 'Fiesta', 'slug' => 'fiesta', 'sort_order' => 5],
            ['name' => 'Eventos', 'slug' => 'eventos', 'sort_order' => 6],
            ['name' => 'Vacaciones', 'slug' => 'vacaciones', 'sort_order' => 7],
            ['name' => 'Playa', 'slug' => 'playa', 'sort_order' => 8],
        ]);

        $leMale = $this->createPerfume($brand, $category, [
            'name' => 'Jean Paul Gaultier Le Male EDT',
            'slug' => 'jean-paul-gaultier-le-male-edt',
            'short_description' => 'Fragancia masculina iconica que combina frescura aromatica con una base calida de vainilla y haba tonka.',
            'description' => 'Le Male EDT revela un contraste entre lavanda, menta y especias, sobre una base calida de vainilla, haba tonka, ambar y maderas.',
            'editorial_story' => 'Lanzada en 1995 y creada por Francis Kurkdjian, Le Male EDT es una composicion Oriental Fougère que se ha convertido en un icono de la perfumeria masculina.',
            'longevity_level' => 'intense',
            'projection_level' => 'moderate',
            'intensity_level' => 'moderate',
            'sort_order' => 1,
        ]);
        if ($leMale->wasRecentlyCreated) {
            $leMale->accords()->sync($this->accords($accords, [
                'aromatico' => [100, 1, true], 'vainilla' => [94, 2, false], 'fresco-especiado' => [88, 3, false], 'lavanda' => [82, 4, false], 'calido-especiado' => [76, 5, false],
                'verde' => [70, 6, false], 'atalcado' => [64, 7, false], 'dulce' => [58, 8, false], 'ambar' => [52, 9, false], 'amaderado' => [46, 10, false],
            ]));
            $leMale->notes()->sync($this->notes($notes, [
                'lavanda' => ['top', 1], 'menta' => ['top', 2], 'cardamomo' => ['top', 3], 'bergamota' => ['top', 4], 'artemisia' => ['top', 5],
                'canela' => ['heart', 1], 'flor-de-azahar' => ['heart', 2], 'alcaravea' => ['heart', 3],
                'vainilla' => ['base', 1], 'haba-tonka' => ['base', 2], 'ambar-nota' => ['base', 3], 'sandalo' => ['base', 4], 'cedro' => ['base', 5],
            ]));
            $leMale->climates()->sync($this->ids($climates, ['templado', 'frio']));
            $leMale->seasons()->sync($this->ids($seasons, ['otono', 'invierno', 'primavera']));
            $leMale->occasions()->sync($this->ids($occasions, ['diario', 'oficina', 'citas', 'noche']));
        }

        $ultraMale = $this->createPerfume($brand, $category, [
            'name' => 'Jean Paul Gaultier Ultra Male',
            'slug' => 'jean-paul-gaultier-ultra-male',
            'short_description' => 'Version mas intensa, dulce y seductora del clasico Le Male.',
            'description' => 'Ultra Male combina una salida afrutada y aromatica con canela, salvia y una base profunda de vainilla negra, ambar, pachuli y cedro.',
            'editorial_story' => 'Lanzada en 2015 y creada por Francis Kurkdjian, Ultra Male es una composicion Oriental Fougère que intensifica el caracter seductor de Le Male.',
            'longevity_level' => 'intense',
            'projection_level' => 'intense',
            'intensity_level' => 'intense',
            'sort_order' => 2,
        ]);
        if ($ultraMale->wasRecentlyCreated) {
            $ultraMale->accords()->sync($this->accords($accords, [
                'vainilla' => [100, 1, true], 'frutal' => [94, 2, false], 'aromatico' => [88, 3, false], 'dulce' => [82, 4, false], 'canela' => [76, 5, false],
                'calido-especiado' => [70, 6, false], 'fresco-especiado' => [64, 7, false], 'lavanda' => [58, 8, false], 'atalcado' => [52, 9, false], 'verde' => [46, 10, false],
            ]));
            $ultraMale->notes()->sync($this->notes($notes, [
                'pera' => ['top', 1], 'lavanda' => ['top', 2], 'menta' => ['top', 3], 'bergamota' => ['top', 4], 'limon' => ['top', 5],
                'canela' => ['heart', 1], 'salvia' => ['heart', 2], 'alcaravea' => ['heart', 3],
                'vainilla-negra' => ['base', 1], 'ambar-nota' => ['base', 2], 'pachuli' => ['base', 3], 'cedro' => ['base', 4],
            ]));
            $ultraMale->climates()->sync($this->ids($climates, ['frio', 'templado']));
            $ultraMale->seasons()->sync($this->ids($seasons, ['otono', 'invierno']));
            $ultraMale->occasions()->sync($this->ids($occasions, ['citas', 'fiesta', 'noche']));
        }

        $leMaleLeParfum = $this->createPerfume($brand, $category, [
            'name' => 'Jean Paul Gaultier Le Male Le Parfum',
            'slug' => 'jean-paul-gaultier-le-male-le-parfum',
            'short_description' => 'Una interpretacion intensa y refinada de Le Male, con lavanda, iris y vainilla sobre maderas calidas.',
            'description' => 'Le Male Le Parfum combina cardamomo, lavanda e iris con una base de vainilla, notas orientales y maderas.',
            'editorial_story' => 'Lanzada en 2020 y creada por Quentin Bisch, Le Male Le Parfum es una composicion Amber Fougère de presencia elegante.',
            'longevity_level' => 'intense',
            'projection_level' => 'intense',
            'intensity_level' => 'intense',
            'sort_order' => 3,
        ]);
        if ($leMaleLeParfum->wasRecentlyCreated) {
            $leMaleLeParfum->accords()->sync($this->accords($accords, [
                'vainilla' => [100, 1, true], 'aromatico' => [93, 2, false], 'calido-especiado' => [86, 3, false], 'iris' => [79, 4, false],
                'ambar' => [72, 5, false], 'lavanda' => [65, 6, false], 'amaderado' => [58, 7, false], 'atalcado' => [51, 8, false],
            ]));
            $leMaleLeParfum->notes()->sync($this->notes($notes, [
                'cardamomo' => ['top', 1],
                'lavanda' => ['heart', 1], 'iris' => ['heart', 2],
                'vainilla' => ['base', 1], 'notas-orientales' => ['base', 2], 'notas-amaderadas' => ['base', 3],
            ]));
            $leMaleLeParfum->climates()->sync($this->ids($climates, ['templado', 'frio']));
            $leMaleLeParfum->seasons()->sync($this->ids($seasons, ['otono', 'invierno', 'primavera']));
            $leMaleLeParfum->occasions()->sync($this->ids($occasions, ['oficina', 'citas', 'noche', 'eventos']));
        }

        $leMaleElixir = $this->createPerfume($brand, $category, [
            'name' => 'Jean Paul Gaultier Le Male Elixir',
            'slug' => 'jean-paul-gaultier-le-male-elixir',
            'short_description' => 'Una version nocturna y envolvente de Le Male, con miel, vainilla y tabaco.',
            'description' => 'Le Male Elixir abre con lavanda y menta antes de revelar benjui, vainilla, haba tonka, miel y tabaco.',
            'editorial_story' => 'Lanzada en 2023 y creada por Quentin Bisch, Le Male Elixir es una composicion Amber Aromatic de caracter intenso.',
            'longevity_level' => 'intense',
            'projection_level' => 'intense',
            'intensity_level' => 'intense',
            'sort_order' => 4,
        ]);
        if ($leMaleElixir->wasRecentlyCreated) {
            $leMaleElixir->accords()->sync($this->accords($accords, [
                'miel' => [100, 1, true], 'vainilla' => [93, 2, false], 'tabaco' => [86, 3, false], 'calido-especiado' => [79, 4, false],
                'aromatico' => [72, 5, false], 'ambar' => [65, 6, false], 'dulce' => [58, 7, false], 'haba-tonka' => [51, 8, false],
            ]));
            $leMaleElixir->notes()->sync($this->notes($notes, [
                'lavanda' => ['top', 1], 'menta' => ['top', 2],
                'benjui' => ['heart', 1], 'vainilla' => ['heart', 2],
                'haba-tonka' => ['base', 1], 'miel' => ['base', 2], 'tabaco' => ['base', 3],
            ]));
            $leMaleElixir->climates()->sync($this->ids($climates, ['frio', 'templado']));
            $leMaleElixir->seasons()->sync($this->ids($seasons, ['otono', 'invierno']));
            $leMaleElixir->occasions()->sync($this->ids($occasions, ['noche', 'citas', 'fiesta']));
        }

        $leMaleInBlue = $this->createPerfume($brand, $category, [
            'name' => 'Jean Paul Gaultier Le Male In Blue',
            'slug' => 'jean-paul-gaultier-le-male-in-blue',
            'short_description' => 'Una interpretacion aromatica de Le Male, centrada en lavanda, anis y benjui.',
            'description' => 'Le Male In Blue presenta lavanda en la salida, anis en el corazon y benjui en el fondo.',
            'editorial_story' => 'Lanzada en 2026, Le Male In Blue es una composicion Aromatic de caracter fresco y luminoso.',
            'longevity_level' => 'intense',
            'projection_level' => 'moderate',
            'intensity_level' => 'moderate',
            'sort_order' => 5,
        ]);
        if ($leMaleInBlue->wasRecentlyCreated) {
            $leMaleInBlue->accords()->sync($this->accords($accords, [
                'anis' => [100, 1, true], 'lavanda' => [90, 2, false], 'aromatico' => [80, 3, false],
                'ambar' => [70, 4, false], 'calido-especiado' => [60, 5, false], 'dulce' => [50, 6, false],
            ]));
            $leMaleInBlue->notes()->sync($this->notes($notes, [
                'lavanda' => ['top', 1],
                'anis' => ['heart', 1],
                'benjui' => ['base', 1],
            ]));
            $leMaleInBlue->climates()->sync($this->ids($climates, ['calido', 'templado']));
            $leMaleInBlue->seasons()->sync($this->ids($seasons, ['primavera', 'verano']));
            $leMaleInBlue->occasions()->sync($this->ids($occasions, ['diario', 'oficina']));
        }

        $leBeauEdt = $this->createPerfume($brand, $category, [
            'name' => 'Jean Paul Gaultier Le Beau EDT',
            'slug' => 'jean-paul-gaultier-le-beau-edt',
            'short_description' => 'Una fragancia amaderada y aromatica con bergamota, coco y haba tonka.',
            'description' => 'Le Beau EDT combina una salida de bergamota con un corazon de coco y una base calida de haba tonka.',
            'editorial_story' => 'Lanzada en 2019 y creada por Quentin Bisch, Le Beau EDT es una composicion Woody Aromatic de caracter tropical.',
            'longevity_level' => 'intense',
            'projection_level' => 'moderate',
            'intensity_level' => 'moderate',
            'sort_order' => 6,
        ]);
        if ($leBeauEdt->wasRecentlyCreated) {
            $leBeauEdt->accords()->sync($this->accords($accords, [
                'coco' => [100, 1, true], 'dulce' => [91, 2, false], 'aromatico' => [82, 3, false], 'haba-tonka' => [73, 4, false],
                'amaderado' => [64, 5, false], 'fresco' => [55, 6, false], 'tropical' => [46, 7, false],
            ]));
            $leBeauEdt->notes()->sync($this->notes($notes, [
                'bergamota' => ['top', 1],
                'coco' => ['heart', 1],
                'haba-tonka' => ['base', 1],
            ]));
            $leBeauEdt->climates()->sync($this->ids($climates, ['calido', 'templado']));
            $leBeauEdt->seasons()->sync($this->ids($seasons, ['primavera', 'verano']));
            $leBeauEdt->occasions()->sync($this->ids($occasions, ['diario', 'vacaciones', 'citas']));
        }

        $leBeauLeParfum = $this->createPerfume($brand, $category, [
            'name' => 'Jean Paul Gaultier Le Beau Le Parfum',
            'slug' => 'jean-paul-gaultier-le-beau-le-parfum',
            'short_description' => 'Una version mas profunda de Le Beau, con coco, ambar y maderas calidas.',
            'description' => 'Le Beau Le Parfum une pina, iris, jengibre y cipres con coco, maderas, haba tonka, sandalo y ambar.',
            'editorial_story' => 'Lanzada en 2022 y creada por Quentin Bisch, Le Beau Le Parfum es una composicion Amber Woody de caracter seductor.',
            'longevity_level' => 'intense',
            'projection_level' => 'intense',
            'intensity_level' => 'intense',
            'sort_order' => 7,
        ]);
        if ($leBeauLeParfum->wasRecentlyCreated) {
            $leBeauLeParfum->accords()->sync($this->accords($accords, [
                'coco' => [100, 1, true], 'ambar' => [91, 2, false], 'dulce' => [82, 3, false], 'tropical' => [73, 4, false],
                'amaderado' => [64, 5, false], 'calido-especiado' => [55, 6, false], 'vainilla' => [46, 7, false],
            ]));
            $leBeauLeParfum->notes()->sync($this->notes($notes, [
                'pina' => ['top', 1], 'iris' => ['top', 2], 'jengibre' => ['top', 3], 'cipres' => ['top', 4],
                'coco' => ['heart', 1], 'notas-amaderadas' => ['heart', 2],
                'haba-tonka' => ['base', 1], 'sandalo' => ['base', 2], 'ambar-nota' => ['base', 3], 'ambar-gris' => ['base', 4],
            ]));
            $leBeauLeParfum->climates()->sync($this->ids($climates, ['templado', 'frio']));
            $leBeauLeParfum->seasons()->sync($this->ids($seasons, ['otono', 'invierno', 'primavera']));
            $leBeauLeParfum->occasions()->sync($this->ids($occasions, ['citas', 'noche', 'fiesta']));
        }

        $leBeauParadiseGarden = $this->createPerfume($brand, $category, [
            'name' => 'Jean Paul Gaultier Le Beau Paradise Garden',
            'slug' => 'jean-paul-gaultier-le-beau-paradise-garden',
            'short_description' => 'Una interpretacion verde y acuática de Le Beau, con coco, higo y maderas suaves.',
            'description' => 'Le Beau Paradise Garden combina notas verdes y acuaticas con menta, jengibre, coco, higo, sal, haba tonka y sandalo.',
            'editorial_story' => 'Lanzada en 2024 y creada por Quentin Bisch, Le Beau Paradise Garden es una composicion Green Aquatic Woody fresca y tropical.',
            'longevity_level' => 'intense',
            'projection_level' => 'moderate',
            'intensity_level' => 'moderate',
            'sort_order' => 8,
        ]);
        if ($leBeauParadiseGarden->wasRecentlyCreated) {
            $leBeauParadiseGarden->accords()->sync($this->accords($accords, [
                'verde' => [100, 1, true], 'coco' => [91, 2, false], 'acuatico' => [82, 3, false], 'dulce' => [73, 4, false],
                'amaderado' => [64, 5, false], 'aromatico' => [55, 6, false], 'fresco-especiado' => [46, 7, false],
            ]));
            $leBeauParadiseGarden->notes()->sync($this->notes($notes, [
                'notas-verdes' => ['top', 1], 'notas-acuaticas' => ['top', 2], 'menta' => ['top', 3], 'jengibre' => ['top', 4],
                'coco' => ['heart', 1], 'higo' => ['heart', 2], 'sal' => ['heart', 3],
                'haba-tonka' => ['base', 1], 'sandalo' => ['base', 2],
            ]));
            $leBeauParadiseGarden->climates()->sync($this->ids($climates, ['calido']));
            $leBeauParadiseGarden->seasons()->sync($this->ids($seasons, ['primavera', 'verano']));
            $leBeauParadiseGarden->occasions()->sync($this->ids($occasions, ['diario', 'vacaciones', 'playa']));
        }

        $scandalPourHomme = $this->createPerfume($brand, $category, [
            'name' => 'Jean Paul Gaultier Scandal Pour Homme',
            'slug' => 'jean-paul-gaultier-scandal-pour-homme',
            'short_description' => 'Una fragancia ambarada y amaderada, marcada por caramelo, haba tonka y vetiver.',
            'description' => 'Scandal Pour Homme abre con mandarina y esclarea, evoluciona con caramelo y haba tonka, y descansa sobre vetiver.',
            'editorial_story' => 'Lanzada en 2021 por Quentin Bisch, Christophe Raynaud y Nathalie Gracia-Cetto, Scandal Pour Homme es una composicion Amber Woody intensa.',
            'longevity_level' => 'intense',
            'projection_level' => 'intense',
            'intensity_level' => 'intense',
            'sort_order' => 9,
        ]);
        if ($scandalPourHomme->wasRecentlyCreated) {
            $scandalPourHomme->accords()->sync($this->accords($accords, [
                'caramelo' => [100, 1, true], 'dulce' => [91, 2, false], 'haba-tonka' => [82, 3, false],
                'amaderado' => [73, 4, false], 'aromatico' => [64, 5, false], 'ambar' => [55, 6, false],
            ]));
            $scandalPourHomme->notes()->sync($this->notes($notes, [
                'mandarina' => ['top', 1], 'esclarea' => ['top', 2],
                'caramelo' => ['heart', 1], 'haba-tonka' => ['heart', 2],
                'vetiver' => ['base', 1],
            ]));
            $scandalPourHomme->climates()->sync($this->ids($climates, ['templado', 'frio']));
            $scandalPourHomme->seasons()->sync($this->ids($seasons, ['otono', 'invierno']));
            $scandalPourHomme->occasions()->sync($this->ids($occasions, ['noche', 'fiesta', 'citas']));
        }
    }

    private function createPerfume(Brand $brand, Category $category, array $attributes): Perfume
    {
        return Perfume::query()->firstOrCreate(
            ['slug' => $attributes['slug']],
            [
                ...$attributes,
                'brand_id' => $brand->id,
                'category_id' => $category->id,
                'image' => null,
                'is_featured' => false,
                'is_best_seller' => false,
                'is_active' => true,
            ],
        );
    }

    private function accords(Collection $accords, array $intensities): array
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
            $item['slug'] => $model::query()->firstOrCreate(
                ['slug' => $item['slug']],
                [...$item, 'is_active' => true],
            ),
        ]);
    }

    private function notes(Collection $notes, array $stages): array
    {
        return collect($stages)->mapWithKeys(fn (array $pivot, string $slug) => [
            $notes[$slug]->id => ['stage' => $pivot[0], 'sort_order' => $pivot[1]],
        ])->all();
    }

    private function ids(Collection $items, array $slugs): array
    {
        return collect($slugs)->map(fn (string $slug) => $items[$slug]->id)->all();
    }
}
