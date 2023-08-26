<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @param User $user
     * @param JsonResponse $response
     */
    public function __construct(
        protected User $user,
        protected JsonResponse $response
    ) { }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->user->paginate(25);

        return $this->response->setData($users)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $userData = $this->user->findOrFail($id);

        return $this->response->setData($userData);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $userData = $this->user->create($this->validate($request, $this->user->rules()));

            return $this->response->setData($userData)->setStatusCode(Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->setData(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $userData = $this->user->findOrFail($id);
            $userData->update($this->validate($request, $this->user->updateRules()));

            return $this->response->setData($userData)->setStatusCode(Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->setData(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $this->user->findOrFail($id)->delete();

        return $this->response->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
