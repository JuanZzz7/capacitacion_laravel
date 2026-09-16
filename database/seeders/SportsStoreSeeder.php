<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SportsStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Categorías
        $categoriesData = [
            [
                'name' => 'Running',
                'slug' => 'running',
                'description' => 'Calzado e indumentaria técnica para corredores de ruta y pista.',
                'icon' => 'directions_run',
            ],
            [
                'name' => 'Training & Gym',
                'slug' => 'training',
                'description' => 'Equipamiento de máxima resistencia para fuerza y cardio.',
                'icon' => 'fitness_center',
            ],
            [
                'name' => 'Trail Running',
                'slug' => 'trail',
                'description' => 'Protección extrema, agarre Vibram y membranas impermeables.',
                'icon' => 'terrain',
            ],
            [
                'name' => 'Accesorios',
                'slug' => 'accesorios',
                'description' => 'Dispositivos de telemetría, hidratación y transporte ergonómico.',
                'icon' => 'watch',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $data) {
            $categories[$data['slug']] = Category::firstOrCreate(['slug' => $data['slug']], $data);
        }

        // 2. Productos oficiales Kinetic Sports
        $products = [
            [
                'category_slug' => 'running',
                'name' => 'Kinetic Velocity Nitro Pro',
                'slug' => 'kinetic-velocity-nitro-pro',
                'reference' => 'KP-VEL-09',
                'description' => 'Placa propulsora de fibra de carbono reactiva y espuma de doble densidad amortiguada.',
                'details' => "Desarrollada con atletas de élite en el laboratorio de rendimiento Kinetic. Incorpora espuma NitroFoam infundida con nitrógeno presurizado para un retorno de energía del 87%, acoplada a la placa de carbono K-Wave 3K que reduce la fatiga muscular en distancias de maratón.\n\nSuela de caucho de alta fricción con microtacos direccionados para tracción en asfalto húmedo.",
                'price' => 139.99,
                'original_price' => 179.99,
                'badge' => 'Novedad',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCXktgrM3Xl75Yi_huFVb4dIFf-PDXMzVTHCc0PvWRkqYpAyfQ8w6gRrymecatK5ZTZKvkIgi9j9ioq0OnHz8zFSYzDNVhESOgtqO83n0QmWID8IBsl3ceg_YLpjJGfb9yRSe8hoJjezAyinTw0foO31Dk00pJWeV7pocTlIcJB3sM1fIp5kcxgZp-yT2lJAYEEZj6nrt6GfhK47CDDp4GT3-_kSN6z4IDEZCy8RI5p_QC59frGd_bjmw',
                'rating' => 4.9,
                'reviews_count' => 128,
                'weight' => '198 g',
                'drop' => '8 mm',
                'plate' => 'Full Carbon K-Wave 3K',
                'optimal_use' => 'Maratón / 10K',
                'in_stock' => true,
                'images' => [
                    ['url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBNICQuYRsq3yXuaBKniAIIuULX7E8B8HHWOWpyXpXFfDsi1kLgULf99O-SOJO0kanjkKJNlIvxzXa6ikMvdkM9KizAXHlTB63Eta0KKSVoR5M0uUwIllqvg0kDZfa3ZVT_3LakKzgJk3KIsf4xNIewODQVYI7G3jspc9RMcJ35BBT3F1BJtTiDVW2bm86_s576ZOt54DWPVIW6vOmACRGGhY5lLjQ3Xj2FDPS2f2X8-cHA-rKlAsfbvA', 'label' => 'Lateral Pro', 'order' => 1],
                    ['url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDRq_uZI-bDNtd53jA0-nYTmSFvaEUCcKUW7kGyzRPIba_nWl9HwtqwnF_JRjLdui4KRNINWHzdi1DnRVkBm9Dqv1IZr8l__buIXln7alGuuUKSM36zj-IA9aU86g7t-j3j_nL02uutqwYdrVbUUag9r3HxdFG87wJCWZ0iXV5slqw30cQsJvXrwsgw7pP7cqyVRMYoZZjiROAj_cqNtBZNHw53bMyV6HhYZRKnnaHGhp74ncfu1TDw_Q', 'label' => 'Suela Tracción', 'order' => 2],
                    ['url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC-EnZurnIP-jjOfHwZ7-38QCNPLV3c4NexkYPtImp83U_n8uJwchGeM63632G28XbLMwJidV_0u5d8yfynq2_6rUF7exvaLMmbOOOMq0Mx3Hqvb4v43NBtyG5gTI0OP56lO0nXS-XEkGqgHP169uIVZAKSRS8An5BZ3Iq-5_7qwC6ItTleKRXyWwfCCNvCi3PuO_HXGCvUSfbKnbt4Bar1i_pEgLpNw4KleL3g38O4tLrDcRmtxYs4Bg', 'label' => 'Vista Superior', 'order' => 3],
                    ['url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBCyGFfuFuBXBxlQEf_7YepRBdftheWKSJlUNLHCTR7cZBbBb2--ZRw9_bkm-ji3t66bpHxI__tbNaaXqETwmr9hwRKdf8U5agPcovyQ2Yell3l7nr9dYScnGY2g7PCferH-b03HUKAOK3nPQN1jq8GOai05xf951r2yLuiXRQm1PS65Ma-N1pviFqXXFtjn0InbaCATr7ZXySH3ihJo9hgbmMs48wo893Ku6ke6FG_g3tM5qRBZjoFbQ', 'label' => 'Nitro Foam Zoom', 'order' => 4],
                ],
                'variants' => [
                    ['color_name' => 'Negro / Naranja Lava', 'color_hex' => '#FF5722', 'size' => '40 EU', 'stock' => 12],
                    ['color_name' => 'Negro / Naranja Lava', 'color_hex' => '#FF5722', 'size' => '41 EU', 'stock' => 15],
                    ['color_name' => 'Negro / Naranja Lava', 'color_hex' => '#FF5722', 'size' => '42 EU', 'stock' => 20],
                    ['color_name' => 'Negro / Naranja Lava', 'color_hex' => '#FF5722', 'size' => '43 EU', 'stock' => 8],
                    ['color_name' => 'Negro / Naranja Lava', 'color_hex' => '#FF5722', 'size' => '44 EU', 'stock' => 14],
                    ['color_name' => 'Negro / Naranja Lava', 'color_hex' => '#FF5722', 'size' => '45 EU', 'stock' => 6],
                    ['color_name' => 'Blanco Glaciar / Lima', 'color_hex' => '#E2E8F0', 'size' => '42 EU', 'stock' => 10],
                    ['color_name' => 'Azul Marino / Cian', 'color_hex' => '#0A192F', 'size' => '42 EU', 'stock' => 9],
                ],
            ],
            [
                'category_slug' => 'training',
                'name' => 'Camiseta Técnica Aeroready Pro',
                'slug' => 'camiseta-tecnica-aeroready-pro',
                'reference' => 'KP-AERO-01',
                'description' => 'Tejido hidrófugo ultraligero con secado en 4 minutos y corte ergonómico atlético.',
                'details' => 'Confeccionada con microfibra elástica de 4 vías que repele la humedad hacia la capa exterior para una evaporación instantánea. Costuras planas termoselladas para cero fricción.',
                'price' => 34.99,
                'original_price' => null,
                'badge' => 'Aeroready',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBBMjfC5o0riwO1plVUCT2OGZZHQv91TeYZRQI2uHpAS98ot1OGt5mLtf5V9kS3GOcT8OQqeo78bqQcb9_x4Q9byp5BKFPVhlVdLOLBWjy34PdbswfJMwCwgRnEqBR13yArsCC7qD-nCAg5AoAtMXblZOiU2dGkbrzvK9906w6JZquLitfsVsR8E1u5PvvUH0CLEH2uBx-hm8wrmEe0hbHAESiZj4tlQGIniWv4btGPfPUBZXoEP9U3yA',
                'rating' => 4.8,
                'reviews_count' => 85,
                'weight' => '88 g',
                'drop' => null,
                'plate' => 'Tejido Micro-Vent',
                'optimal_use' => 'HIIT / Fuerza',
                'in_stock' => true,
                'variants' => [
                    ['color_name' => 'Azul Marino', 'color_hex' => '#0A192F', 'size' => 'S', 'stock' => 20],
                    ['color_name' => 'Azul Marino', 'color_hex' => '#0A192F', 'size' => 'M', 'stock' => 25],
                    ['color_name' => 'Azul Marino', 'color_hex' => '#0A192F', 'size' => 'L', 'stock' => 18],
                    ['color_name' => 'Naranja Lava', 'color_hex' => '#FF5722', 'size' => 'M', 'stock' => 15],
                ],
            ],
            [
                'category_slug' => 'accesorios',
                'name' => 'Smartwatch Kinetic Pulse GPS',
                'slug' => 'smartwatch-kinetic-pulse-gps',
                'reference' => 'KP-PULSE-GPS',
                'description' => 'Sensor biométrico óptico continuo, mapas offline y estimación de VO2 Máx de precisión.',
                'details' => 'Bisel de titanio aeroespacial de grado 5 con pantalla AMOLED de 1.4" protegida por cristal de zafiro. Antena GPS de doble frecuencia L1+L5 con recepción multiconstelación.',
                'price' => 199.99,
                'original_price' => null,
                'badge' => 'Top Ventas',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD4-Rm4lMxV83-7SD7-1fBA6rAfEuLI7ubUbf6XMiahQ5LVkqzf9lnXbBpk-v9Re6uiL6InOl7g6LQ25f4NzW7jQhRSU90NmVWYbnFCo80Y1XeQm5aLcDesm_Ces0ZLcvn4snlW1sGxSPg7v4Ke-tCxb0mRRZDinBzDlmAnEYenlYb09PKzlk8RccOpM8EzYHZFXI6pZ2YRw9ebvXRNUl3ZGzWRbF3dw5iUDqHsY4cysChEHbpduDTgbQ',
                'rating' => 4.9,
                'reviews_count' => 210,
                'weight' => '52 g',
                'drop' => null,
                'plate' => 'Batería 14 Días',
                'optimal_use' => 'Multideporte / GPS',
                'in_stock' => true,
                'variants' => [
                    ['color_name' => 'Titanio / Correa Negra', 'color_hex' => '#111C2D', 'size' => 'Única 46mm', 'stock' => 14],
                    ['color_name' => 'Titanio / Correa Naranja', 'color_hex' => '#FF5722', 'size' => 'Única 46mm', 'stock' => 8],
                ],
            ],
            [
                'category_slug' => 'training',
                'name' => 'Pantalón Corto 2 en 1 DryFit',
                'slug' => 'pantalon-corto-2-en-1-dryfit',
                'reference' => 'KP-SHORT-2IN1',
                'description' => 'Malla interior compresiva antirozaduras con bolsillo especial para móvil sin rebote.',
                'details' => 'Exterior transpirable de secado rápido con tiro de 5 pulgadas y perforaciones láser laterales. Malla interior con tecnología de compresión graduada para soporte muscular en cuádriceps.',
                'price' => 42.50,
                'original_price' => null,
                'badge' => 'DryFit',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBoUcT8GSuhuNbq1YNWmE6D3JpJZLs_KdA1FH2EsbE9-1bhUJKZGkW-Q5sEfKcK8AY72tNBI-OOn_UwqJrsNkxgsO5uXRx0zKv3m9kXE0FMRJazcIxKe-15kAfIFB7CYq1CnAc9-4gLIXYKztNyNfYMTVvNDbeFjRjoVM1d5l5n7LMPGt_ApCs3r5wpT7dHho7mHNiS8idOgHgpXOBg0zlegXQV1fg0uAxKJnHzYpdYxeyebw7oUnWe4g',
                'rating' => 4.7,
                'reviews_count' => 64,
                'weight' => '115 g',
                'drop' => null,
                'plate' => 'Liner Antirozaduras',
                'optimal_use' => 'Running / Crossfit',
                'in_stock' => true,
                'variants' => [
                    ['color_name' => 'Gris Carbón', 'color_hex' => '#283044', 'size' => 'S', 'stock' => 10],
                    ['color_name' => 'Gris Carbón', 'color_hex' => '#283044', 'size' => 'M', 'stock' => 18],
                    ['color_name' => 'Gris Carbón', 'color_hex' => '#283044', 'size' => 'L', 'stock' => 12],
                ],
            ],
            [
                'category_slug' => 'accesorios',
                'name' => 'Mochila Deportiva Impermeable 30L',
                'slug' => 'mochila-deportiva-impermeable-30l',
                'reference' => 'KP-BAG-30L',
                'description' => 'Compartimento ventilado para calzado sucio y funda protegida para ordenador portátil.',
                'details' => 'Fabricada en nylon ripstop balístico 600D con recubrimiento de poliuretano impermeable. Arnés ergonómico para el pecho con silbato de emergencia integrado y soporte para botellas.',
                'price' => 59.00,
                'original_price' => null,
                'badge' => 'Impermeable',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAfQw0yTEsfXNaWqafJ0x_2l8lVI3rL9EgU7YwfsHi0vBhCAuEa6Eh2xq6w1K1kDtq-fc8ZkhUYtqeOt46crZ3jL7RdE6xkMrAY4RJO1CQBaIYzPlvvqwPfleFR5wVAiO9xm16roR6s_LoSQi9HkCWMgh5hY4lsPdErfCE4uEYuglKZgJz___fD-rOE8heA0Ad_eIyL6j3iEw_SEzBuRdaUGsTf0oEOU57GBJ-DJ9Hdjmasnnpzuv4j1g',
                'rating' => 4.8,
                'reviews_count' => 92,
                'weight' => '480 g',
                'drop' => null,
                'plate' => 'Ripstop 600D',
                'optimal_use' => 'Gimnasio / Viaje',
                'in_stock' => true,
                'variants' => [
                    ['color_name' => 'Negro Táctico', 'color_hex' => '#131B2E', 'size' => '30 Litros', 'stock' => 16],
                ],
            ],
            [
                'category_slug' => 'trail',
                'name' => 'Kinetic Trail Storm GTX',
                'slug' => 'kinetic-trail-storm-gtx',
                'reference' => 'KP-TRAIL-GTX',
                'description' => 'Suela con tacos multidireccionales de 5mm con protección perimetral contra rocas.',
                'details' => 'Diseñada para desafiar terrenos técnicos de montaña, barro y roca húmeda. Membrana GORE-TEX® impermeable y transpirable garantizada. Entresuela reforzada con placa antirocas RockPlate TPU.',
                'price' => 169.99,
                'original_price' => 210.00,
                'badge' => '-20% OFF',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA1eeRkFzC7oJqrUjaUWSdQ9b9n06yRK_8uZU22wdICYmop120Rt2aIjAOlkKygC2DHDhQD76UOkl-ODGOp-_NdnrXCTV9Sw0xl6-WQa25IZn6O-aS6t26e5N-aomaUef2R7TUfS-yx0AdqeZF6d9l5LrQihYks41PeIjyDNw3WsXJ740ZChVhoRydubu0C0rf1WuKtIk8m7Q_9xutNcPSjeuA3ZIpYuGKw3IhhFmEO_Ap3ZIay9Yo-VA',
                'rating' => 4.9,
                'reviews_count' => 143,
                'weight' => '285 g',
                'drop' => '6 mm',
                'plate' => 'RockPlate TPU + GTX',
                'optimal_use' => 'Ultra Trail / Montaña',
                'in_stock' => true,
                'variants' => [
                    ['color_name' => 'Verde Oliva / Naranja', 'color_hex' => '#3C475A', 'size' => '41 EU', 'stock' => 7],
                    ['color_name' => 'Verde Oliva / Naranja', 'color_hex' => '#3C475A', 'size' => '42 EU', 'stock' => 12],
                    ['color_name' => 'Verde Oliva / Naranja', 'color_hex' => '#3C475A', 'size' => '43 EU', 'stock' => 10],
                    ['color_name' => 'Verde Oliva / Naranja', 'color_hex' => '#3C475A', 'size' => '44 EU', 'stock' => 5],
                ],
            ],
            [
                'category_slug' => 'training',
                'name' => 'Set Bandas Resistencia Pro',
                'slug' => 'set-bandas-resistencia-pro',
                'reference' => 'KP-BAND-5X',
                'description' => 'De 10 lbs a 50 lbs de tensión progresiva para calentamiento, fuerza y recuperación.',
                'details' => 'Set de 5 bandas elásticas en bucle 100% látex natural malasio de alta densidad. Incluye bolsa de transporte de malla transpirable y guía de ejercicios de activación glútea y movilidad articular.',
                'price' => 24.99,
                'original_price' => null,
                'badge' => '5 Niveles',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDZLa4SQ5Y6BS75tg2PYB66_V3WZ3XXf4S8h17WzGeGkTdUAw1W9qsfS51PKzEOjBLMieGqUOsQhBkqnZ7AcV0cbkKcjvCrjr323J3JtwQvfw5wrKalkhXSXjFBd-MICd1nyzd59wn6cC_pJye5TRGJNphX5ZSceKVOU1UHNic-8RGwzj-3xGKFDwsbfD1hKvgCZOorE8MMZdl6sD5KVfA6794m7frNyBUo60hFBt7WB9Wj6EA3WzzVPA',
                'rating' => 4.8,
                'reviews_count' => 115,
                'weight' => '180 g',
                'drop' => null,
                'plate' => 'Látex 100% Natural',
                'optimal_use' => 'Movilidad / Calentamiento',
                'in_stock' => true,
                'variants' => [
                    ['color_name' => 'Pack Multicolor', 'color_hex' => '#FF5722', 'size' => 'Kit 5 Niveles', 'stock' => 30],
                ],
            ],
            [
                'category_slug' => 'accesorios',
                'name' => 'Botella Térmica Inox 750ml',
                'slug' => 'botella-termica-inox-750ml',
                'reference' => 'KP-BOTTLE-750',
                'description' => 'Acero inoxidable de grado quirúrgico libre de BPA con tapón hermético antifugas.',
                'details' => 'Doble pared aislada al vacío con barrera de cobre TempLock. Mantiene bebidas frías hasta por 24 horas o calientes durante 12 horas sin condensación exterior.',
                'price' => 19.99,
                'original_price' => null,
                'badge' => 'Aislamiento Vacío',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBoIvofryN4IdLuDB8bTPqXkMIhHuQHVhDAORLUIX6-0JS0DydYsEGNWzN9Bq1i7pDLb_LeUQZEvl1uNBzhEX4A3VaAqAd1eSyXr4BsceYrZxe58dP2vUrgLwG-cY8WpaoabkLpdhmCRI5uCrmxS2klk-Zvr6djOKlL1oGo7YWvJ15W1kHLIhMKNSW-2r8aDbVBMQia2KzsernG5Wp7zQOTQUran6znDyr2FuKo_XFRYy0hldU05wntOw',
                'rating' => 4.9,
                'reviews_count' => 178,
                'weight' => '320 g',
                'drop' => null,
                'plate' => 'Acero Pro 18/8',
                'optimal_use' => 'Hidratación Todo el Día',
                'in_stock' => true,
                'variants' => [
                    ['color_name' => 'Negro Mate', 'color_hex' => '#131B2E', 'size' => '750 ml', 'stock' => 25],
                    ['color_name' => 'Naranja Kinetic', 'color_hex' => '#FF5722', 'size' => '750 ml', 'stock' => 15],
                ],
            ],
        ];

        foreach ($products as $pData) {
            $cat = $categories[$pData['category_slug']];
            $product = Product::updateOrCreate(
                ['slug' => $pData['slug']],
                [
                    'category_id' => $cat->id,
                    'name' => $pData['name'],
                    'reference' => $pData['reference'],
                    'description' => $pData['description'],
                    'details' => $pData['details'],
                    'price' => $pData['price'],
                    'original_price' => $pData['original_price'],
                    'badge' => $pData['badge'],
                    'image_url' => $pData['image_url'],
                    'rating' => $pData['rating'],
                    'reviews_count' => $pData['reviews_count'],
                    'weight' => $pData['weight'],
                    'drop' => $pData['drop'],
                    'plate' => $pData['plate'],
                    'optimal_use' => $pData['optimal_use'],
                    'in_stock' => $pData['in_stock'],
                ]
            );

            // Galería
            if (!empty($pData['images'])) {
                foreach ($pData['images'] as $img) {
                    ProductImage::updateOrCreate(
                        ['product_id' => $product->id, 'label' => $img['label']],
                        [
                            'image_url' => $img['url'],
                            'sort_order' => $img['order'],
                        ]
                    );
                }
            }

            // Variantes
            if (!empty($pData['variants'])) {
                foreach ($pData['variants'] as $v) {
                    ProductVariant::updateOrCreate(
                        ['product_id' => $product->id, 'color_name' => $v['color_name'], 'size' => $v['size']],
                        [
                            'color_hex' => $v['color_hex'],
                            'stock' => $v['stock'],
                        ]
                    );
                }
            }
        }
    }
}
