<?php

namespace app\controllers\UtilisateurControllers;

use app\models\utilisateurModels\Genre;
use Flight;
use Exception;

class GenreController {
    private $genreModel;

    public function __construct() {
        $this->genreModel = new Genre();
    }


    public function index() {
        try {
            $search = Flight::request()->query['search'] ?? '';
            
            if (!empty($search)) {
                $genres = Genre::search($search);
                $message = "Résultats de recherche pour : " . htmlspecialchars($search);
            } else {
                $genres = Genre::getAll();
                $message = null;
            }
            
            $totalGenres = Genre::countAll();
            
            $data = [
                'genres' => $genres,
                'totalGenres' => $totalGenres,
                'search' => $search,
                'message' => $message,
                'success' => Flight::request()->query['success'] ?? null,
                'error' => Flight::request()->query['error'] ?? null,
                'page' => 'UtilisateurViews/Genre/index'
            ];

            Flight::render('template', $data);
        } catch (Exception $e) {
            $data = [
                'genres' => [],
                'totalGenres' => 0,
                'search' => '',
                'message' => null,
                'error' => $e->getMessage(),
                'page' => 'UtilisateurViews/Genre/index'
            ];
            Flight::render('template', $data);
        }
    }


    public function create() {
        $data = [
            'page' => 'UtilisateurViews/Genre/create',
            'error' => null,
            'old_data' => null
        ];
        Flight::render('template', $data);
    }


    public function store() {
        try {
            $label = trim(Flight::request()->data['label'] ?? '');
            
            if (empty($label)) {
                throw new Exception("Le nom du genre est obligatoire");
            }
            
            if (strlen($label) > 255) {
                throw new Exception("Le nom du genre ne peut pas dépasser 255 caractères");
            }
            
            $genre = new Genre(null, $label);
            $genre->save();
            
            Flight::redirect('/genres?success=' . urlencode("Genre créé avec succès (ID: " . $genre->getId() . ")"));
        } catch (Exception $e) {
            $data = [
                'page' => 'UtilisateurViews/Genre/create',
                'error' => $e->getMessage(),
                'old_data' => [
                    'label' => Flight::request()->data['label'] ?? ''
                ]
            ];
            Flight::render('template', $data);
        }
    }


    public function edit($id) {
        try {
            $genre = Genre::getById($id);
            
            if (!$genre) {
                Flight::redirect('/genres?error=' . urlencode("Genre introuvable"));
                return;
            }
            
            $data = [
                'page' => 'UtilisateurViews/Genre/edit',
                'genre' => $genre,
                'error' => null
            ];
            Flight::render('template', $data);
        } catch (Exception $e) {
            Flight::redirect('/genres?error=' . urlencode($e->getMessage()));
        }
    }


    public function update($id) {
        try {
            $label = trim(Flight::request()->data['label'] ?? '');
            
            if (empty($label)) {
                throw new Exception("Le nom du genre est obligatoire");
            }
            
            if (strlen($label) > 255) {
                throw new Exception("Le nom du genre ne peut pas dépasser 255 caractères");
            }
            
            $genre = Genre::getById($id);
            if (!$genre) {
                throw new Exception("Genre introuvable");
            }
            
            $genre->setLabel($label);
            $success = $genre->save();
            
            if ($success) {
                Flight::redirect('/genres?success=' . urlencode("Genre mis à jour avec succès"));
            } else {
                throw new Exception("Aucune modification n'a été effectuée");
            }
        } catch (Exception $e) {
            $genre = Genre::getById($id);
            $data = [
                'page' => 'UtilisateurViews/Genre/edit',
                'genre' => $genre,
                'error' => $e->getMessage(),
                'old_data' => [
                    'label' => Flight::request()->data['label'] ?? ''
                ]
            ];
            Flight::render('template', $data);
        }
    }

    public function delete($id) {
        try {
            $genre = Genre::getById($id);
            
            if (!$genre) {
                Flight::redirect('/genres?error=' . urlencode("Genre introuvable"));
                return;
            }
            
            $data = [
                'page' => 'UtilisateurViews/Genre/delete',
                'genre' => $genre
            ];
            Flight::render('template', $data);
        } catch (Exception $e) {
            Flight::redirect('/genres?error=' . urlencode($e->getMessage()));
        }
    }


    public function destroy($id) {
        try {
            $genre = Genre::getById($id);
            if (!$genre) {
                throw new Exception("Genre introuvable");
            }
            
            $success = $genre->delete();
            
            if ($success) {
                Flight::redirect('/genres?success=' . urlencode("Genre supprimé avec succès"));
            } else {
                throw new Exception("Impossible de supprimer le genre");
            }
        } catch (Exception $e) {
            Flight::redirect('/genres?error=' . urlencode($e->getMessage()));
        }
    }

    public function apiIndex() {
        try {
            $genres = Genre::getAll();
            $data = array_map(function($genre) {
                return [
                    'id' => $genre->getId(),
                    'label' => $genre->getLabel()
                ];
            }, $genres);
            
            Flight::json([
                'success' => true,
                'data' => $data,
                'count' => count($genres)
            ]);
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function apiShow($id) {
        try {
            $genre = Genre::getById($id);
            
            if (!$genre) {
                Flight::json([
                    'success' => false,
                    'error' => 'Genre introuvable'
                ], 404);
                return;
            }
            
            Flight::json([
                'success' => true,
                'data' => [
                    'id' => $genre->getId(),
                    'label' => $genre->getLabel()
                ]
            ]);
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}