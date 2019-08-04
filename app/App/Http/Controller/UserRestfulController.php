<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Wiring\Http\Controller\AbstractRestfulController;

class UserRestfulController extends AbstractRestfulController
{
    /**
     * List an existing resource.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface $response
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $users = User::all();
        $data = $this->success('Ok', $users);

        return $this
            ->json()
            ->render($data)
            ->to($this->response);
    }

    /**
     * Create an existing resource.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface $response
     */
    public function create(ServerRequestInterface $request): ResponseInterface
    {

        $input = json_decode($request->getBody()->getContents(), true);

        try {
            $user = User::create([
                'username' => $input['username'],
                'email' => $input['email'],
                'active' => $input['active'],
                'password' => $input['password']
            ]);   
            $data = $this->success('Ok', $user);
        } catch (Exception $e) {
            $data = $this->error('Ocorreu um problema durante a criação.', 500, $input);
        }
        
        return $this
            ->json()
            ->render($data)
            ->to($this->response, $data['code']);
    }

    /**
     * Get an existing resource.
     *
     * @param ServerRequestInterface $request
     * @param array $args
     *
     * @return ResponseInterface $response
     */
    public function read(
        ServerRequestInterface $request,
        array $args
    ): ResponseInterface {

        $user = User::find($args['id']);

        if (!$user) {
            $data = $this->error('Usuário não encontrado.', 404, $user);
        } else {
            $data = $this->success('Ok', $user);
        }

        return $this
            ->json()
            ->render($data)
            ->to($this->response);
    }

    /**
     * Update\Replace an existing resource.
     *
     * @param ServerRequestInterface $request
     * @param array $args\
     *
     * @return ResponseInterface $response
     */
    public function update(
        ServerRequestInterface $request,
        array $args
    ): ResponseInterface {
        
        $input = json_decode($request->getBody()->getContents(), true);
        $user = User::find($args['id']);

        if (!$user) {
            $data = $this->error('Usuário não encontrado.', 404, $user);
        } else {
            try {
                $user['username'] = $input['username'] ?? $user['username'];
                $user['email'] = $input['email'] ?? $user['email'];
                $user['active'] = $input['active'] ?? $user['active'];
                $user['password'] = $input['password'] ?? $user['password'];
                $user->save();
                $data = $this->success('Ok', $user);
            } catch (Exception $e) {
                $data = $this->error('Ocorreu um problema durante a atualização.', 500, $input);
            }
        }

        return $this
            ->json()
            ->render($data)
            ->to($this->response);
    }

    /**
     * Update\Modify an existing resource.
     *
     * @param ServerRequestInterface $request
     * @param array $args
     *
     * @return ResponseInterface $response
     */
    public function modify(
        ServerRequestInterface $request,
        array $args
    ): ResponseInterface {
        $input = json_decode($request->getBody()->getContents(), true);
        $user = User::find($args['id']);

        if (!$user) {
            $data = $this->error('Usuário não encontrado.', 404, $user);
        } else {
            try {
                $user['username'] = $input['username'] ?? $user['username'];
                $user['email'] = $input['email'] ?? $user['email'];
                $user['active'] = $input['active'] ?? $user['active'];
                $user['password'] = $input['password'] ?? $user['password'];
                $user->save();
                $data = $this->success('Ok', $user);
            } catch (Exception $e) {
                $data = $this->error('Ocorreu um problema durante a modificação.', 500, $input);
            }
        }

        return $this
            ->json()
            ->render($data)
            ->to($this->response);
    }

    /**
     * Delete an existing resource.
     *
     * @param ServerRequestInterface $request
     * @param array $args
     *
     * @return ResponseInterface $response
     */
    public function delete(
        ServerRequestInterface $request,
        array $args
    ): ResponseInterface {

        $user = User::find($args['id']);

        if (!$user) {
            $data = $this->error('Usuário não encontrado.', 404, $user);
        } else {
            try {
                $user['active'] = false;
                $user->save();
                $data = $this->success('Ok', $user);
            } catch (Exception $e) {
                $data = $this->error('Ocorreu um problema durante a exclusão.', 500, $input);
            }
        }

        return $this
            ->json()
            ->render($data)
            ->to($this->response);
    }
}