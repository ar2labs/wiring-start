<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Wiring\Http\Controller\AbstractRestfulController;
use Noodlehaus\Exception;

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
        $users = User::where('active', '=', true)->get();
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

        if (!isset($input['username'])) {
            throw new Exception('The username attribute is required.');
        }

        if (!isset($input['email'])) {
            throw new Exception('The email attribute is required.');
        }

        if (!isset($input['password'])) {
            throw new Exception('The password attribute is required.');
        }

        if (!isset($input['active'])) {
            throw new Exception('The active attribute is required.');
        }

        $user = User::create([
            'username' => $input['username'],
            'email' => $input['email'],
            'active' => $input['active'],
            'password' => $input['password'],
        ]);

        if (!$user) {
            $data = $this->error('User create error.', 500, $input);
        } else {
            $data = $this->success('User created', $user, 201);
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
            $data = $this->error('User not found.', 404, $user);
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
     * @param array $args
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
            $data = $this->error('User not found.', 404, $user);
        } else {
            // Set fields
            $user['username'] = $input['username'] ?? $user['username'];
            $user['email'] = $input['email'] ?? $user['email'];
            $user['active'] = $input['active'] ?? $user['active'];
            $user['password'] = $input['password'] ?? $user['password'];

            if ($user->save()) {
                $data = $this->success('Ok', $user);
            } else {
                $data = $this->error('User create error.', 304, $input);
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
            $data = $this->error('User not found.', 404, $user);
        } else {
            $user['username'] = $input['username'] ?? $user['username'];
            $user['email'] = $input['email'] ?? $user['email'];
            $user['active'] = $input['active'] ?? $user['active'];
            $user['password'] = $input['password'] ?? $user['password'];

            if ($user->save()) {
                $data = $this->success('Ok', $user);
            } else {
                $data = $this->error('User create error.', 304, $input);
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
            $data = $this->error('User not found.', 404, $user);
        } else {
            $user['active'] = false;
            if ($user->save()) {
                $data = $this->success('Ok', $user);
            } else {
                $data = $this->error('User delete error.', 304);
            }
        }

        return $this
            ->json()
            ->render($data)
            ->to($this->response);
    }
}
