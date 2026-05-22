<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\User;
use InvalidArgumentException;
use JsonException;
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
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $users = (new User())->where('active', '=', true)->get();
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
     * @return ResponseInterface
     */
    public function create(ServerRequestInterface $request): ResponseInterface
    {
        $input = $this->input($request);

        $this->requireFields($input, ['username', 'email', 'password', 'active']);

        /** @var mixed $user */
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
            ->to($this->response, $data['code'] ?? 200);
    }

    /**
     * Get an existing resource.
     *
     * @param ServerRequestInterface $request
     * @param array<string> $args
     *
     * @return ResponseInterface
     */
    public function read(
        ServerRequestInterface $request,
        array $args
    ): ResponseInterface {
        /** @var mixed $user */
        $user = (new User())->find($args['id']);

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
     * @param array<string> $args
     *
     * @return ResponseInterface
     */
    public function update(
        ServerRequestInterface $request,
        array $args
    ): ResponseInterface {
        $input = $this->input($request);
        $this->requireFields($input, ['username', 'email', 'password', 'active']);

        $user = User::find($args['id']);

        if (!$user) {
            $data = $this->error('User not found.', 404, $user);
        } else {
            $user->fill($input);

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
     * @param array<string> $args
     *
     * @return ResponseInterface
     */
    public function modify(
        ServerRequestInterface $request,
        array $args
    ): ResponseInterface {
        $input = $this->input($request);

        $user = User::find($args['id']);

        if (!$user) {
            $data = $this->error('User not found.', 404, $user);
        } else {
            $user->fill(array_intersect_key($input, array_flip([
                'username',
                'email',
                'password',
                'active',
            ])));

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
     * @param array<string> $args
     *
     * @return ResponseInterface $response
     */
    public function delete(
        ServerRequestInterface $request,
        array $args
    ): ResponseInterface {
        /** @var mixed $user */
        $user = (new User())->find($args['id']);

        if (!$user) {
            $data = $this->error('User not found.', 404, $user);
        } else {
            // Inactive user
            $user->active = false;

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

    /**
     * @return array<string, mixed>
     */
    private function input(ServerRequestInterface $request): array
    {
        $contents = (string) $request->getBody();

        if ($contents === '') {
            return [];
        }

        try {
            $input = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new InvalidArgumentException('Invalid JSON request body.', 0, $exception);
        }

        if (!is_array($input)) {
            throw new InvalidArgumentException('JSON request body must be an object.');
        }

        return $input;
    }

    /**
     * @param array<string, mixed> $input
     * @param list<string> $fields
     */
    private function requireFields(array $input, array $fields): void
    {
        foreach ($fields as $field) {
            if (!array_key_exists($field, $input)) {
                throw new InvalidArgumentException(sprintf(
                    'The %s attribute is required.',
                    $field
                ));
            }
        }
    }
}
