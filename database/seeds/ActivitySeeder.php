<?php

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activities = [
            ['name'=>'Magasin prêt-à-porter', 'description'=>'Magasin prêt-à-porter homme et femme'],
            ['name'=>'Parapharmacie', 'description'=>'Ensemble des produits vendus en pharmacie qui ne sont pas des médicaments'],
            ['name'=>'Cigarette électronique', 'description'=>'Cigarettes électroniques et d\'e-liquides'],
            ['name'=>'Onglerie', 'description'=>'L\'Onglerie vous propose de nombreuses prestations telles que la beauté des mains.'],
            ['name'=>'Coiffure', 'description'=>'Coiffure'],
            ['name'=>'Scrubs', 'description'=>'Pour protéger les infirmières, vétérinaires et autres personnel soignant.'],
            ['name'=>'Animalerie', 'description'=>'Vente des produits pour animaux'],
            ['name'=>'Parfumerie', 'description'=>'parfums'],
            ['name'=>'Restauration & snack', 'description'=>'Restauration & snack'],

        ];
        foreach($activities as $activity)
            Activity::create($activity);
    }
}
