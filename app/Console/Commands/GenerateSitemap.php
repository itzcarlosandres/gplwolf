<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product;
use App\Models\Category;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create('/products')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create('/updates')->setPriority(0.8))
            ->add(Url::create('/login')->setPriority(0.5))
            ->add(Url::create('/register')->setPriority(0.5));

        // Categories (assuming route logic)
        // If route is /products?category=slug or /category/slug.
        // Based on previous code: route('products.index', ['category' => $category->slug])
        Category::all()->each(function (Category $category) use ($sitemap) {
            $sitemap->add(
                Url::create(route('products.index', ['category' => $category->slug]))
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });

        // Products
        Product::where('is_active', true)->each(function (Product $product) use ($sitemap) {
            $sitemap->add(
                Url::create(route('products.show', $product->slug))
                    ->setPriority(0.9)
                    ->setLastModificationDate($product->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');
    }
}
