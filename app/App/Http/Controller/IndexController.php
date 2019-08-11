<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\User;
use App\Model\About;
use App\Model\Book;
use App\Model\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Wiring\Http\Controller\AbstractJsonViewController;
use Wiring\Http\Helpers\Info;
use Zend\Diactoros\Response;

class IndexController extends AbstractJsonViewController
{
    /**
     * Home page action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function home(ServerRequestInterface $request): ResponseInterface
    {
        return $this
            ->view()
            ->render('home.twig', [
                'pageTitle' => 'AR2 Labs :: Wiring',
            ])
            ->to($this->response);
    }

    /**
     * User model example.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function user(ServerRequestInterface $request): ResponseInterface
    {
        /** @var \App\Model\User $users */
        $users = (new user())->all();

        return $this
            ->json()
            ->render($users)
            ->to($this->response);
    }

    /**
     * About model example.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Reponse
     */
    public function about(ServerRequestInterface $request): ResponseInterface
    {
        /** @var \App\Model\About $about */
        $about = $this->get(About::class);
        $data = $about->toArray();

        return $this
            ->json()
            ->render($data)
            ->to($this->response);
    }

    /**
     * Book model example.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function book(ServerRequestInterface $request): ResponseInterface
    {
        /** @var \App\Model\Book $book */
        $book = $this
            ->get(Book::class)
            ->setId(1)
            ->setAuthor('AR2 Labs')
            ->setTitle('Wiring Microframework')
            ->setPublisher('AR2 Labs')
            ->setEdition('2.0')
            ->setYear(2019);

        return $this
            ->json()
            ->render($book->toArray())
            ->to($this->response);
    }

    /**
     * Query builder logs example.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function logs(ServerRequestInterface $request): ResponseInterface
    {
        // Get database connection
        if (env('DB_CONNECTION') === 'doctrine') {
            /** @var \Doctrine\DBAL\Connection $dbh */
            $dbh = $this->database();
            $id = 1;

            $query = $dbh->createQueryBuilder();
            $query
                ->select(
                    'u.id',
                    'u.username',
                    'u.email',
                    'l.feedback',
                    'l.created_at'
                )
                ->from('users', 'u')
                ->innerJoin('u', 'logs', 'l', 'u.id = l.user_id')
                ->where('u.id = :id')
                ->setParameter(':id', $id)
                ->orderBy('u.username', 'ASC');

            $sth = $query->execute();
            $data = $sth->fetchAll();
        } else {
            $data = Log::all();

            foreach ($data as $log) {
                $log->user;
            }
        }

        return $this
            ->json()
            ->render($data)
            ->to($this->response);
    }

    /**
     * Custom PHP info example.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function info(ServerRequestInterface $request): ResponseInterface
    {
        return $this
            ->view()
            ->render('info.twig', [
                'phpinfo' => Info::phpinfo(),
            ])
            ->to($this->response);
    }

    /**
     * Test you api page.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Reponse
     */
    public function test(ServerRequestInterface $request): ResponseInterface
    {       
        return $this
            ->view()
            ->render('test.twig', [
                'pageTitle' => 'Test your API',
            ])
            ->to($this->response);
    }
}
