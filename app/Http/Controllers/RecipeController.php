<?php

namespace App\Http\Controllers;

use App\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    /**
     * Get all recipes.
     */
    public function all()
    {
        try {
            return Recipe::all();
            // return Recipe::all()->json();
            // return Response::json(Recipe::all());
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * show specify recipe.
     *
     * @param mixed $id
     */
    public function show($id)
    {
        try {
            return Recipe::findOrFail($id);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * create.
     *
     * @param mixed $request
     */
    public function create(Request $request)
    {
        try {
            //Validate
            $this->validate($request, ['title' => 'required', 'content' => 'required|min:8']);
            $recipe = new Recipe();
            $recipe->title = $request->title;
            $recipe->content = $request->content;
            $recipe->user_id = Auth::user()->id;
            $recipe->save();

            return $recipe->toJson();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * update.
     *
     * @param mixed $request
     * @param mixed $id
     */
    public function update(Request $request, $id)
    {
        try {
            $recipe = Recipe::findOrFail($id);
            $recipe->update($request->all());

            return $recipe;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * delete.
     *
     * @param mixed $id
     */
    public function delete($id)
    {
        try {
            $recipe = Recipe::findOrFail($id);
            $recipe->delete();

            return $recipe->toJson();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
