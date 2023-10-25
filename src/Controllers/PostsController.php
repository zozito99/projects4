<?php

namespace BlogApiSlim\Controllers;

use Assert\AssertionFailedException;
//use BlogApiSlim\Models\actors;
//use BlogApiSlim\Models\country;
//use BlogApiSlim\Models\director;
//use BlogApiSlim\Models\genre;
//use BlogApiSlim\Models\imdp;
//use BlogApiSlim\Models\poster_url;
use BlogApiSlim\Models\Posts;
//use BlogApiSlim\Models\Relased;
//use BlogApiSlim\Models\runtime;
//use BlogApiSlim\Models\Title;
//use BlogApiSlim\Models\type;
//use BlogApiSlim\Models\Year;
use DI\DependencyException;
use DI\NotFoundException;
use Faker\Factory;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Message;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PostsController extends A_Controller
{
    /**
     * @OA\Get(
     *     path="/v1/movies",
     *     description="Returns all posts",
     *     @OA\Response(
     *          response=200,
     *          description="posts response",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *      ),
     *   )
     * )
     * @return \Laminas\Diactoros\Response
     */
public function indexAction(Request $request ,Response $response): ResponseInterface
{
    $posts=new Posts($this->container);
    $data=$posts->findall();
    return $this->render($data,$response);
}

    /**
     * @OA\Post(
     *     path="/v1/posts",
     *     description="Creates a post in blog",
     *     @OA\RequestBody(
     *          description="Input data format",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="title",
     *                      description="title of new movie",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="year",
     *                      description="year of the movie",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="released",
     *                      description="the year ir released",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="runtime",
     *                      description="how long is the movie",
     *                      type="string",
     *                  ),
     *                 @OA\Property(
     *                      property="genre",
     *                      description="what kind is the movie",
     *                      type="string",
     *                  ),
     *                 @OA\Property(
     *                      property="director",
     *                      description="who is the director of the movie",
     *                      type="string",
     *                  ),
     *                 @OA\Property(
     *                      property="country",
     *                      description="what is the country of the movie",
     *                      type="string",
     *                  ),
     *                 @OA\Property(
     *                      property="poster",
     *                      description="the url of the poster",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="imdp",
     *                      description="the rate of the movie",
     *                      type="integer",
     *                  ),
     *                 @OA\Property(
     *                      property="type",
     *                      description="movie or serial",
     *                      type="string",
     *                  ),
     *                 @OA\Property(
     *                      property="actors",
     *                      description="who were the actors ",
     *                      type="string",
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="post has been created successfully",
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="bad request",
     *      ),
     *      @OA\Response(
     *            response=500,
     *            description="Internal server error",
     *        ),
     *   ),
     * )
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */

    /**
     * @throws AssertionFailedException
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function createAction(Request $request , Response $response): ResponseInterface
    {

        $requestBody = $request->getParsedBody();
        $title = filter_var($requestBody['title'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
        $year = filter_var($requestBody['year'], FILTER_SANITIZE_NUMBER_INT);
        $relased = filter_var($requestBody['relased'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
        $runtime = filter_var($requestBody['runtime'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING );
        $genre = filter_var($requestBody['genre'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
        $director = filter_var($requestBody['director'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
        $country = filter_var($requestBody['country'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
        $poster = filter_var($requestBody['poster'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
        $imdp = filter_var($requestBody['imdp'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_NUMBER_INT);
        $type = filter_var($requestBody['type'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
        $actors = filter_var($requestBody['actors'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
        $posts= new Posts($this->container);
       try{
        $posts->insertwithdata([
            $title, $year, $relased, $runtime,$genre, $director, $country, $poster, $imdp, $type, $actors
        ]);
       } catch (AssertionFailedException $e) {
           $responseData = [
               'code' => StatusCodeInterface::STATUS_BAD_REQUEST,
               'message' => $e->getMessage()
           ];
           $response = new JsonResponse($responseData, StatusCodeInterface::STATUS_BAD_REQUEST);
           return $this->render($responseData, $response);
       }

        $requestData=[
            'code' => StatusCodeInterface::STATUS_OK,
            'message' => 'Post has been added.'
        ];
        return $this->render($requestData,$response);
    }
    /**
     * @OA\Put(
     *     path="/v1/posts/{id}",
     *     description="update a single post from blog based on post ID",
     *     @OA\Parameter(
     *          description="ID of post to update",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              format="int64",
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *           description="Input data format",
     *           @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(
     *                   type="object",
     *                   @OA\Property(
     *                      property="title",
     *                      description="title of new movie",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="year",
     *                      description="year of the movie",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="released",
     *                      description="the year ir released",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="runtime",
     *                      description="how long is the movie",
     *                      type="string",
     *                  ),
     *                 @OA\Property(
     *                      property="genre",
     *                      description="what kind is the movie",
     *                      type="string",
     *                  ),
     *                 @OA\Property(
     *                      property="director",
     *                      description="who is the director of the movie",
     *                      type="string",
     *                  ),
     *                 @OA\Property(
     *                      property="country",
     *                      description="what is the country of the movie",
     *                      type="string",
     *                  ),
     *                 @OA\Property(
     *                      property="poster",
     *                      description="the url of the poster",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="imdp",
     *                      description="the rate of the movie",
     *                      type="integer",
     *                  ),
     *                 @OA\Property(
     *                      property="type",
     *                      description="movie or serial",
     *                      type="string",
     *                  ),
     *                 @OA\Property(
     *                      property="actors",
     *                      description="who were the actors ",
     *                      type="string",
     *                  ),
     *               ),
     *           ),
     *       ),
     * @OA\Response(
     *           response=200,
     *           description="post has been created successfully",
     *       ),
     * @OA\Response(
     *           response=400,
     *           description="bad request",
     *       ),
     *     @OA\Response(
     *                response=404,
     *            description="Post not found",
     *        ),
     *     @OA\Response(
     *            response=500,
     *            description="Internal server error",
     *        ),
     *  )
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return ResponseInterface
     */
    /**
     * @throws AssertionFailedException
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function updateAction(Request $request , Response $response, $args=[]):ResponseInterface
{

    $requestBody = $this->getRequestBodyAsArray($request);
    $id=$args['id'];
    $title = filter_var($requestBody['title'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
    $year = filter_var($requestBody['year'], FILTER_SANITIZE_NUMBER_INT);
    $relased = filter_var($requestBody['relased'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
    $runtime = filter_var($requestBody['runtime'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING );
    $genre = filter_var($requestBody['genre'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
    $director = filter_var($requestBody['director'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
    $country = filter_var($requestBody['country'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
    $poster = filter_var($requestBody['poster'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
    $imdp = filter_var($requestBody['imdp'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_NUMBER_INT);
    $type = filter_var($requestBody['type'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
    $actors = filter_var($requestBody['actors'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
    try {
    $posts= new Posts($this->container);
    $posts->update([
        $title, $year, $relased, $runtime,$genre, $director, $country, $poster, $imdp, $type, $actors,$id
    ]);
    } catch (AssertionFailedException $e) {
        $responseData = [
            'code' => StatusCodeInterface::STATUS_BAD_REQUEST,
            'message' => $e->getMessage()
        ];
        $response = new JsonResponse($responseData, StatusCodeInterface::STATUS_BAD_REQUEST);
        return $this->render($responseData, $response);
    }

    $requestData=[
        'code' => StatusCodeInterface::STATUS_OK,
        'message' => 'Post has been updated.'
    ];
    return $this->render($requestData,$response);
}

    /**
     * @OA\Delete(
     *     path="/v1/posts/{id}",
     *     description="deletes a single post from blog based on pot ID",
     *     @OA\Parameter(
     *         description="ID of post to delete",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="post has been deleted"
     *     ),
     * @OA\Response(
     *            response=400,
     *            description="bad request",
     *        ),
     * @OA\Response(
     *                 response=404,
     *             description="Post not found",
     *         ),
     * @OA\Response(
     *             response=500,
     *             description="Internal server error",
     *         ),
     *   )
     */

public function deleteAction(Request $request ,Response $response, $args=[]):ResponseInterface
    {
        $id = $args['id'];
        $posts = new Posts($this->container);
        $posts->delete($id);
        $responseData = [
            'code' => StatusCodeInterface::STATUS_OK,
            'message' => 'Post has been deleted.'
        ];
        return $this->render($responseData, $response);

    }


    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function fakeAction(Request $request, Response $response, $args = []): ResponseInterface
    {
        $posts = new Posts($this->container);
        $posts->fakeData($this->container);

        $responseData = [
            'code' => StatusCodeInterface::STATUS_OK,
            'message' => 'fake data has been inserted'
        ];
        return $this->render($responseData, $response);
    }



public function getPdo(): PDO
{
    return $this->pdo;
}
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function updateMovie($data):bool
    {
        $sql = "UPDATE posts SET title=?, year=?, relased=?, runtime=?, genre=?, director=?, country=?, poster=?, imdp=?, type=?, actors=? WHERE id=?";
        try {
            $stm = $this->getPdo()->prepare($sql);
            $stm->execute([$data[0], $data[1], $data[2], $data[3],$data[4], $data[5], $data[6], $data[7],$data[8], $data[9], $data[10], $data[11]]);
        } catch (\PDOException $exception){
            return false;
        }

        return true;
    }
    public function patchAction(Request $request, Response $response, $args = []): ResponseInterface
    {
        // Get the movie ID from the route parameters
        $movieId = $args['id'];

        // Parse the request body to get the updated data
        $requestData = $request->getParsedBody();

        // Validate the request data (e.g., ensure required fields are present)

        // Check if the movie with $movieId exists (query your database)
        // If it doesn't exist, return a response indicating that the movie was not found

        // Perform the update logic here
        $updatedSuccessfully = $this->updateMovie($movieId, $requestData);

        // Return a response indicating success or failure
        return $this->render((array)$updatedSuccessfully, $response);
    }

}



