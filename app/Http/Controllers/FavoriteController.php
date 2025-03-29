<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFavoriteRequest;
use App\Http\Requests\GetFavoriteListRequest;
use App\Models\Favorite;
use App\Services\FavoriteService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Throwable;

class FavoriteController extends Controller
{
    public function __construct(
        protected FavoriteService $favoriteService,
        protected TagService $tagService
    )
    {
        
    }

    /**
     * @OA\Get(
     *     path="/v1/favorites",
     *     summary="Get the favorite List",
     *     operationId="favoriteList",
     *     tags={"Favorite"},
     *     description="Favorite List",
     *
     *     @OA\Parameter(
    *         name="sort",
    *         in="query",
    *         description="Sort",
    *         required=false,
    *         example="-title",
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\Parameter(
    *         name="filter",
    *         in="query",
    *         description="Filter",
    *         required=false,
    *         example="Voluptas beatae ut.",
    *         @OA\Schema(type="string")
    *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Examples(example="response", value={"status": 200,"message":"", "data": { } }, summary="If success, returns favorite lists record"),
     *         )
     *     ),
     *
     * )
     */
    public function index(GetFavoriteListRequest $request)
    {
        $favorites = $this->favoriteService->list((string) $request->filter);
        $tags = $this->tagService->list();
        return Inertia::render('Home', [
            'favorites' => $favorites,
            'tags' => $tags
        ]);
    }

   /**
     * @OA\Post(
     *     path="/v1/favorites",
     *     summary="Create favorite record",
     *     operationId="createFavorite",
     *     tags={"Favorite"},
     *     description="Create favorite record",
     *
     *     @OA\RequestBody(
     *        required=true,
     *
     *        @OA\JsonContent(
     *           required={"title", "author", "type"},
     *
     *           @OA\Property(property="title", type="string", format="string", example="Fast and Furios"),
     *           @OA\Property(property="author", type="string", format="string", example="Chris Morgan"),
     *           @OA\Property(property="description", type="string", format="string", example="The first film, based on the 1998 Vibe magazine article 'Racer X' by Ken Li"),
     *           @OA\Property(property="release_year", type="integer", format="int64", example="2001"),
     *           @OA\Property(property="type", type="string", format="string", example="movie"),
     *           @OA\Property(
     *               property="tags",
     *               type="array",
     *               @OA\Items(type="string", example="action"),
     *           ),
     *        ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Examples(example="response", value={"status": 201,"message":"", "data": { } }, summary="If success, returns successful createed favorite record message."),
     *         )
     *     ),
     *
     * )
     */
    public function store(CreateFavoriteRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->favoriteService->create(
                $request->title,
                $request->author,
                (string) $request->description,
                (string) $request->release_year,
                $request->type,
                $request->tags
            );
            DB::commit();
            return redirect()->back();
        } catch(Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/v1/favorites/{id}",
     *     summary="Get the favorite recrd",
     *     operationId="getFavoriteRecord",
     *     tags={"Favorite"},
     *     description="Favorite record",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Favorite Id",
     *         required=true,
     *
     *         @OA\Schema(type="number")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Examples(example="response", value={"status": 200,"message":"", "data": { } }, summary="If success, returns favorite single record"),
     *         )
     *     ),
     *
     * )
     */
    public function show(int $id)
    {
        $favorites = $this->favoriteService->show($id);
        return response()->json($favorites);
    }

    /**
     * @OA\Put(
     *     path="/v1/favorites/{id}",
     *     summary="Update favorite record",
     *     operationId="updateFavorite",
     *     tags={"Favorite"},
     *     description="Update favorite record",
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Favorite Id",
     *         required=true,
     *
     *         @OA\Schema(type="number")
     *     ),
     *
     *     @OA\RequestBody(
     *        required=true,
     *
     *        @OA\JsonContent(
     *
     *           @OA\Property(property="title", type="string", format="string", example="Fast and Furios"),
     *           @OA\Property(property="author", type="string", format="string", example="Chris Morgan"),
     *           @OA\Property(property="description", type="string", format="string", example="The first film, based on the 1998 Vibe magazine article 'Racer X' by Ken Li"),
     *           @OA\Property(property="release_year", type="integer", format="int64", example="2001"),
     *           @OA\Property(property="type", type="string", format="string", example="movie"),
     *           @OA\Property(
     *               property="tags",
     *               type="array",
     *               @OA\Items(type="string", example="action"),
     *           ),
     *        ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Examples(example="response", value={"status": 201,"message":"", "data": { } }, summary="If success, returns successful updated favorite record."),
     *         )
     *     ),
     *
     * )
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            DB::beginTransaction();
            $this->favoriteService->update(
                $id,
                $request->title,
                $request->author,
                (string) $request->description,
                (string) $request->release_year,
                $request->type,
                $request->tags
            );
            DB::commit();
            return redirect()->back();
        } catch(Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *     path="/v1/favorites/{id}",
     *     summary="Delete the favorite record",
     *     operationId="deleteFavoriteRecord",
     *     tags={"Favorite"},
     *     description="Delete Favorite Record",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Favorite Id",
     *         required=true,
     *
     *         @OA\Schema(type="number")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Examples(example="response", value={"status": 200,"message":"", "data": { } }, summary="If success, returns favorite successfully deleted record message."),
     *         )
     *     ),
     *
     * )
     */
    public function destroy(Favorite $favorite)
    {
        $favorite->delete();
        return redirect()->back();
    }
}
