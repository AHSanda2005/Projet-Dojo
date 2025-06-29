<?php

namespace app\controllers\UtilisateurControllers;

use app\models\utilisateurModels\Eleve;
use app\models\utilisateurModels\Prof;
use app\models\utilisateurModels\Superviseur;
use app\models\utilisateurModels\Parents;
use app\models\utilisateurModels\Genre;
use app\models\utilisateurModels\ParentEleve;
use Flight;
use Exception;

class UserController
{

    public function __construct()
    {
        
    }


    public function index()
    {
        try {
            $type = Flight::request()->query['type'] ?? 'all';
            $search = Flight::request()->query['search'] ?? '';

            $users = [];
            $totalUsers = 0;
            $message = null;

            switch ($type) {
                case 'eleve':
                    if (!empty($search)) {
                        $users = Eleve::search($search);
                        $message = "Résultats de recherche d'élèves pour : " . htmlspecialchars($search);
                    } else {
                        $users = Eleve::getAll();
                    }
                    $totalUsers = Eleve::countAll();
                    break;

                case 'prof':
                    if (!empty($search)) {
                        $users = Prof::search($search);
                        $message = "Résultats de recherche de professeurs pour : " . htmlspecialchars($search);
                    } else {
                        $users = Prof::getAll();
                    }
                    $totalUsers = Prof::countAll();
                    break;

                case 'superviseur':
                    if (!empty($search)) {
                        $users = Superviseur::search($search);
                        $message = "Résultats de recherche de superviseurs pour : " . htmlspecialchars($search);
                    } else {
                        $users = Superviseur::getAll();
                    }
                    $totalUsers = Superviseur::countAll();
                    break;

                case 'parent':
                    if (!empty($search)) {
                        $users = Parents::search($search);
                        $message = "Résultats de recherche de parents pour : " . htmlspecialchars($search);
                    } else {
                        $users = Parents::getAll();
                    }
                    $totalUsers = Parents::countAll();
                    break;

                default:
                    // Récupérer tous les utilisateurs
                    $eleves = Eleve::getAll();
                    $profs = Prof::getAll();
                    $superviseurs = Superviseur::getAll();
                    $parents = Parents::getAll();

                    $users = [
                        'eleves' => $eleves,
                        'profs' => $profs,
                        'superviseurs' => $superviseurs,
                        'parents' => $parents
                    ];

                    $totalUsers = Eleve::countAll() + Prof::countAll() + Superviseur::countAll() + Parents::countAll();
                    break;
            }

            $data = [
                'users' => $users,
                'totalUsers' => $totalUsers,
                'currentType' => $type,
                'search' => $search,
                'message' => $message,
                'success' => Flight::request()->query['success'] ?? null,
                'error' => Flight::request()->query['error'] ?? null,
                'page' => 'UtilisateurViews/User/index'
            ];

            Flight::render('template', $data);
        } catch (Exception $e) {
            $data = [
                'users' => [],
                'totalUsers' => 0,
                'currentType' => 'all',
                'search' => '',
                'message' => null,
                'error' => $e->getMessage(),
                'page' => 'UtilisateurViews/User/index'
            ];
            Flight::render('template', $data);
        }
    }

    public function create()
    {
        try {
            $genres = Genre::getAll();

            $data = [
                'page' => 'UtilisateurViews/User/create',
                'genres' => $genres,
                'error' => null,
                'old_data' => null
            ];
            Flight::render('template', $data);
        } catch (Exception $e) {
            Flight::redirect('/users?error=' . urlencode($e->getMessage()));
        }
    }

    //Traite la création d'un nouvel utilisateur
    public function store()
    {
        try {
            $type = trim(Flight::request()->data['type'] ?? '');
            $nom = trim(Flight::request()->data['nom'] ?? '');
            $prenom = trim(Flight::request()->data['prenom'] ?? '');
            $dateNaissance = trim(Flight::request()->data['date_naissance'] ?? '');
            $adresse = trim(Flight::request()->data['adresse'] ?? '');
            $contact = trim(Flight::request()->data['contact'] ?? '');
            $idgenre = Flight::request()->data['id_genre'] ?? null;

            // Validation commune
            if (empty($type) || !in_array($type, ['eleve', 'prof', 'superviseur', 'parent'])) {
                throw new Exception("Type d'utilisateur invalide");
            }

            if (empty($nom) || empty($prenom)) {
                throw new Exception("Le nom et le prénom sont obligatoires");
            }

            if (empty($contact)) {
                throw new Exception("Le contact est obligatoire");
            }

            // Validation spécifique pour les types avec genre
            if (in_array($type, ['eleve', 'prof', 'superviseur'])) {
                if (empty($dateNaissance)) {
                    throw new Exception("La date de naissance est obligatoire");
                }

                if (empty($idgenre)) {
                    throw new Exception("Le genre est obligatoire");
                }
            }

            // Création selon le type
            switch ($type) {
                case 'eleve':
                    $user = new Eleve();
                    break;
                case 'prof':
                    $user = new Prof();
                    break;
                case 'superviseur':
                    $user = new Superviseur();
                    break;
                case 'parent':
                    $user = new Parents();
                    break;
            }

            // Assignation des valeurs communes
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setAdresse($adresse);
            $user->setContact($contact);

            // Assignation des valeurs spécifiques
            if (in_array($type, ['eleve', 'prof', 'superviseur'])) {
                $user->setDateNaissance($dateNaissance);
                $user->setIdGenre((int) $idgenre);
            }

            $success = $user->create();

            if ($success) {
                Flight::redirect('/users?success=' . urlencode(ucfirst($type) . " créé(e) avec succès"));
            } else {
                throw new Exception("Erreur lors de la création");
            }

        } catch (Exception $e) {
            $genres = Genre::getAll();
            $data = [
                'page' => 'UtilisateurViews/User/create',
                'genres' => $genres,
                'error' => $e->getMessage(),
                'old_data' => Flight::request()->data
            ];
            Flight::render('template', $data);
        }
    }


    public function edit($type, $id)
    {
        try {
            $user = null;

            switch ($type) {
                case 'eleve':
                    $user = Eleve::getById($id);
                    break;
                case 'prof':
                    $user = Prof::getById($id);
                    break;
                case 'superviseur':
                    $user = Superviseur::getById($id);
                    break;
                case 'parent':
                    $user = Parents::getById($id);
                    break;
                default:
                    throw new Exception("Type d'utilisateur invalide");
            }

            if (!$user) {
                Flight::redirect('/users?error=' . urlencode("Utilisateur introuvable"));
                return;
            }

            $genres = Genre::getAll();

            $data = [
                'page' => 'UtilisateurViews/User/edit',
                'user' => $user,
                'type' => $type,
                'genres' => $genres,
                'error' => null
            ];
            Flight::render('template', $data);
        } catch (Exception $e) {
            Flight::redirect('/users?error=' . urlencode($e->getMessage()));
        }
    }


    public function update($type, $id)
    {
        try {
            $user = null;

            switch ($type) {
                case 'eleve':
                    $user = Eleve::getById($id);
                    break;
                case 'prof':
                    $user = Prof::getById($id);
                    break;
                case 'superviseur':
                    $user = Superviseur::getById($id);
                    break;
                case 'parent':
                    $user = Parents::getById($id);
                    break;
                default:
                    throw new Exception("Type d'utilisateur invalide");
            }

            if (!$user) {
                throw new Exception("Utilisateur introuvable");
            }

            $nom = trim(Flight::request()->data['nom'] ?? '');
            $prenom = trim(Flight::request()->data['prenom'] ?? '');
            $dateNaissance = trim(Flight::request()->data['date_naissance'] ?? '');
            $adresse = trim(Flight::request()->data['adresse'] ?? '');
            $contact = trim(Flight::request()->data['contact'] ?? '');
            $idgenre = Flight::request()->data['id_genre'] ?? null;

            // Validation
            if (empty($nom) || empty($prenom)) {
                throw new Exception("Le nom et le prénom sont obligatoires");
            }

            if (empty($contact)) {
                throw new Exception("Le contact est obligatoire");
            }

            if (in_array($type, ['eleve', 'prof', 'superviseur'])) {
                if (empty($dateNaissance)) {
                    throw new Exception("La date de naissance est obligatoire");
                }

                if (empty($idgenre)) {
                    throw new Exception("Le genre est obligatoire");
                }
            }

            // Mise à jour
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setAdresse($adresse);
            $user->setContact($contact);

            if (in_array($type, ['eleve', 'prof', 'superviseur'])) {
                $user->setDateNaissance($dateNaissance);
                $user->setIdGenre((int) $idgenre);
            }

            $success = $user->update();

            if ($success) {
                Flight::redirect('/users?success=' . urlencode(ucfirst($type) . " mis(e) à jour avec succès"));
            } else {
                throw new Exception("Aucune modification n'a été effectuée");
            }

        } catch (Exception $e) {
            $genres = Genre::getAll();
            $data = [
                'page' => 'UtilisateurViews/User/edit',
                'user' => $user,
                'type' => $type,
                'genres' => $genres,
                'error' => $e->getMessage()
            ];
            Flight::render('template', $data);
        }
    }

    //Affiche la confirmation de suppression
    public function delete($type, $id)
    {
        try {
            $user = null;

            switch ($type) {
                case 'eleve':
                    $user = Eleve::getById($id);
                    break;
                case 'prof':
                    $user = Prof::getById($id);
                    break;
                case 'superviseur':
                    $user = Superviseur::getById($id);
                    break;
                case 'parent':
                    $user = Parents::getById($id);
                    break;
                default:
                    throw new Exception("Type d'utilisateur invalide");
            }

            if (!$user) {
                Flight::redirect('/users?error=' . urlencode("Utilisateur introuvable"));
                return;
            }

            $data = [
                'page' => 'UtilisateurViews/User/delete',
                'user' => $user,
                'type' => $type
            ];
            Flight::render('template', $data);
        } catch (Exception $e) {
            Flight::redirect('/users?error=' . urlencode($e->getMessage()));
        }
    }

    //Traite la suppression d'un utilisateur
    public function destroy($type, $id)
    {
        try {
            $user = null;

            switch ($type) {
                case 'eleve':
                    $user = Eleve::getById($id);
                    break;
                case 'prof':
                    $user = Prof::getById($id);
                    break;
                case 'superviseur':
                    $user = Superviseur::getById($id);
                    break;
                case 'parent':
                    $user = Parents::getById($id);
                    break;
                default:
                    throw new Exception("Type d'utilisateur invalide");
            }

            if (!$user) {
                throw new Exception("Utilisateur introuvable");
            }

            $success = $user->delete();

            if ($success) {
                Flight::redirect('/users?success=' . urlencode(ucfirst($type) . " supprimé(e) avec succès"));
            } else {
                throw new Exception("Impossible de supprimer l'utilisateur");
            }
        } catch (Exception $e) {
            Flight::redirect('/users?error=' . urlencode($e->getMessage()));
        }
    }

    //API : Liste des utilisateurs
    public function apiIndex()
    {
        try {
            $type = Flight::request()->query['type'] ?? 'all';

            $data = [];

            switch ($type) {
                case 'eleve':
                    $users = Eleve::getAll();
                    $data = array_map(function ($user) {
                        return [
                            'id' => $user->getIdEleve(),
                            'nom' => $user->getNom(),
                            'prenom' => $user->getPrenom(),
                            'type' => 'eleve'
                        ];
                    }, $users);
                    break;

                case 'prof':
                    $users = Prof::getAll();
                    $data = array_map(function ($user) {
                        return [
                            'id' => $user->getIdProf(),
                            'nom' => $user->getNom(),
                            'prenom' => $user->getPrenom(),
                            'type' => 'prof'
                        ];
                    }, $users);
                    break;

                case 'superviseur':
                    $users = Superviseur::getAll();
                    $data = array_map(function ($user) {
                        return [
                            'id' => $user->getIdSuperviseur(),
                            'nom' => $user->getNom(),
                            'prenom' => $user->getPrenom(),
                            'type' => 'superviseur'
                        ];
                    }, $users);
                    break;

                case 'parent':
                    $users = Parents::getAll();
                    $data = array_map(function ($user) {
                        return [
                            'id' => $user->getIdParent(),
                            'nom' => $user->getNom(),
                            'prenom' => $user->getPrenom(),
                            'type' => 'parent'
                        ];
                    }, $users);
                    break;

                default:
                    // Tous les utilisateurs
                    $eleves = Eleve::getAll();
                    $profs = Prof::getAll();
                    $superviseurs = Superviseur::getAll();
                    $parents = Parents::getAll();

                    $data = [
                        'eleves' => array_map(function ($user) {
                            return [
                                'id' => $user->getIdEleve(),
                                'nom' => $user->getNom(),
                                'prenom' => $user->getPrenom(),
                                'type' => 'eleve'
                            ];
                        }, $eleves),
                        'profs' => array_map(function ($user) {
                            return [
                                'id' => $user->getIdProf(),
                                'nom' => $user->getNom(),
                                'prenom' => $user->getPrenom(),
                                'type' => 'prof'
                            ];
                        }, $profs),
                        'superviseurs' => array_map(function ($user) {
                            return [
                                'id' => $user->getIdSuperviseur(),
                                'nom' => $user->getNom(),
                                'prenom' => $user->getPrenom(),
                                'type' => 'superviseur'
                            ];
                        }, $superviseurs),
                        'parents' => array_map(function ($user) {
                            return [
                                'id' => $user->getIdParent(),
                                'nom' => $user->getNom(),
                                'prenom' => $user->getPrenom(),
                                'type' => 'parent'
                            ];
                        }, $parents)
                    ];
                    break;
            }

            Flight::json([
                'success' => true,
                'data' => $data,
                'type' => $type
            ]);
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function parentEleveIndex()
    {
        try {
            $search = Flight::request()->query['search'] ?? '';

            if (!empty($search)) {
                $relations = ParentEleve::searchRelations($search);
            } else {
                $relations = ParentEleve::getAllRelations();
            }

            $data = [
                'page' => 'UtilisateurViews/ParentEleve/index',
                'relations' => $relations,
                'search' => $search,
                'success' => Flight::request()->query['success'] ?? null,
                'error' => Flight::request()->query['error'] ?? null
            ];

            Flight::render('template', $data);
        } catch (Exception $e) {
            Flight::redirect('/parent-eleve?error=' . urlencode($e->getMessage()));
        }
    }

    //Affiche le formulaire pour lier un parent à un élève
    public function parentEleveLinkForm($id_eleve)
    {
        try {
            $eleve = Eleve::getById($id_eleve);
            if (!$eleve) {
                throw new Exception("Élève introuvable");
            }

            $parents = Parents::getAll();
            $existingParents = ParentEleve::getParentsForEleve($id_eleve);

            $data = [
                'page' => 'UtilisateurViews/ParentEleve/link',
                'eleve' => $eleve,
                'parents' => $parents,
                'existingParents' => $existingParents,
                'error' => null
            ];

            Flight::render('template', $data);
        } catch (Exception $e) {
            Flight::redirect('/parent-eleve?error=' . urlencode($e->getMessage()));
        }
    }

    //Traite la liaison d'un parent à un élève
    public function parentEleveLink($id_eleve)
    {
        try {
            $id_parent = Flight::request()->data['id_parent'] ?? null;

            if (empty($id_parent)) {
                throw new Exception("Veuillez sélectionner un parent");
            }

            if (ParentEleve::relationExists($id_parent, $id_eleve)) {
                throw new Exception("Ce parent est déjà lié à cet élève");
            }

            if (ParentEleve::createRelation($id_parent, $id_eleve)) {
                Flight::redirect('/parent-eleve?success=' . urlencode("Relation parent-élève créée avec succès"));
            } else {
                throw new Exception("Erreur lors de la création de la relation");
            }
        } catch (Exception $e) {
            Flight::redirect('/parent-eleve/link/' . $id_eleve . '?error=' . urlencode($e->getMessage()));
        }
    }

    //Supprime une relation parent-élève
    public function parentEleveUnlink($id)
    {
        try {
            if (ParentEleve::deleteRelation($id)) {
                Flight::redirect('/parent-eleve?success=' . urlencode("Relation parent-élève supprimée avec succès"));
            } else {
                throw new Exception("Erreur lors de la suppression de la relation");
            }
        } catch (Exception $e) {
            Flight::redirect('/parent-eleve?error=' . urlencode($e->getMessage()));
        }
    }

    //Affiche le formulaire de création d'une relation parent-élève
    public function parentEleveCreate()
    {
        try {
            $eleves = Eleve::getAll();
            $parents = Parents::getAll();

            $data = [
                'page' => 'UtilisateurViews/ParentEleve/create',
                'eleves' => $eleves,
                'parents' => $parents,
                'error' => null,
                'old_data' => null
            ];

            Flight::render('template', $data);
        } catch (Exception $e) {
            Flight::redirect('/parent-eleve?error=' . urlencode($e->getMessage()));
        }
    }

    //nouvelle relation parent-élève
    public function parentEleveStore()
    {
        try {
            $id_eleve = Flight::request()->data['id_eleve'] ?? null;
            $id_parent = Flight::request()->data['id_parent'] ?? null;

            if (empty($id_eleve) || empty($id_parent)) {
                throw new Exception("Veuillez sélectionner un élève et un parent");
            }

            // Vérifier que l'élève et le parent existent
            $eleve = Eleve::getById($id_eleve);
            $parent = Parents::getById($id_parent);

            if (!$eleve) {
                throw new Exception("Élève introuvable");
            }

            if (!$parent) {
                throw new Exception("Parent introuvable");
            }

            // Vérifier si la relation existe déjà
            if (ParentEleve::relationExists($id_parent, $id_eleve)) {
                throw new Exception("Cette relation parent-élève existe déjà");
            }

            // Créer la relation
            if (ParentEleve::createRelation($id_parent, $id_eleve)) {
                Flight::redirect('/parent-eleve?success=' . urlencode("Relation parent-élève créée avec succès"));
            } else {
                throw new Exception("Erreur lors de la création de la relation");
            }

        } catch (Exception $e) {
            $eleves = Eleve::getAll();
            $parents = Parents::getAll();

            $data = [
                'page' => 'UtilisateurViews/ParentEleve/create',
                'eleves' => $eleves,
                'parents' => $parents,
                'error' => $e->getMessage(),
                'old_data' => Flight::request()->data
            ];

            Flight::render('template', $data);
        }
    }

}