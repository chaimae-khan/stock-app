<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles 
        $cuisinierRole = Role::create(['name' => 'cuisinier']);
        $administrateurRole = Role::create(['name' => 'administrateur']);
        $gestionnaireStockRole = Role::create(['name' => 'gestionnaire_stock']);
        $formateurRole = Role::create(['name' => 'formateur']);

        // Create permissions for each action 
        // Cuisinier permissions
        Permission::create(['name' => 'valider.quantite.consommee']);

        // Administrateur permissions
        Permission::create(['name' => 'gerer.utilisateurs']);
        Permission::create(['name' => 'gerer.droits.acces']);
        Permission::create(['name' => 'accepter.commande']);
        Permission::create(['name' => 'refuser.commande']);
        Permission::create(['name' => 'notifier.utilisateur']);
        Permission::create(['name' => 'generer.tableau.bord']);
        Permission::create(['name' => 'gerer.archives']);
        Permission::create(['name' => 'gerer.produits']);
        Permission::create(['name' => 'gerer.fournisseurs']);
        Permission::create(['name' => 'envoyer.commande.directeur']);

        // Gestionnaire Stock permissions
        Permission::create(['name' => 'deplacer.quantite.reservation']);
        Permission::create(['name' => 'supprimer.commande']);
        Permission::create(['name' => 'gerer.stocks']);
        Permission::create(['name' => 'exporter.donnees']);
        Permission::create(['name' => 'importer.donnees']);
        Permission::create(['name' => 'creer.commande']);

        // Formateur permissions
        Permission::create(['name' => 'consulter.stock']);
        Permission::create(['name' => 'receptionner.commande']);
        Permission::create(['name' => 'transferer.produit']);
        Permission::create(['name' => 'retourner.produit']);
        
        // Assign permissions to roles
        $cuisinierRole->givePermissionTo([
            'valider.quantite.consommee'
        ]);
        
        $administrateurRole->givePermissionTo([
            'gerer.utilisateurs',
            'gerer.droits.acces',
            'accepter.commande',
            'refuser.commande',
            'notifier.utilisateur',
            'generer.tableau.bord',
            'gerer.archives',
            'gerer.produits',
            'gerer.fournisseurs',
            'envoyer.commande.directeur'
        ]);
        
        $gestionnaireStockRole->givePermissionTo([
            'deplacer.quantite.reservation',
            'supprimer.commande',
            'gerer.stocks',
            'exporter.donnees',
            'importer.donnees',
            'creer.commande',
            'notifier.utilisateur'
        ]);
        
        $formateurRole->givePermissionTo([
            'consulter.stock',
            'receptionner.commande',
            'transferer.produit',
            'retourner.produit'
        ]);
    }
}