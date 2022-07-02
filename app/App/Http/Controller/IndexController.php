<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\About;
use App\Model\Book;
use App\Model\Log;
use App\Model\User;
use Psr\Http\Message\ResponseInterface;
use Wiring\Http\Controller\AbstractJsonViewController;
use Wiring\Http\Helpers\Info;

class IndexController extends AbstractJsonViewController
{
    /**
     * Home page action.
     *
     * @return ResponseInterface
     */
    public function home(): ResponseInterface
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
     * @return ResponseInterface
     */
    public function user(): ResponseInterface
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
     * @return ResponseInterface
     */
    public function about(): ResponseInterface
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
     * @return ResponseInterface
     */
    public function book(): ResponseInterface
    {
        /** @var \App\Model\Book $book */
        $book = $this
            ->get(Book::class)
            ->setId(1)
            ->setAuthor('AR2 Labs')
            ->setTitle('Wiring Microframework')
            ->setPublisher('AR2 Labs')
            ->setEdition(APP_VERSION)
            ->setYear(2022);

        return $this
            ->json()
            ->render($book->toArray())
            ->to($this->response);
    }

    /**
     * Query builder logs example.
     *
     * @return ResponseInterface
     */
    public function logs(): ResponseInterface
    {
        $data = Log::all();

        return $this
            ->json()
            ->render($data)
            ->to($this->response);
    }

    /**
     * Custom PHP info example.
     *
     * @return ResponseInterface
     */
    public function info(): ResponseInterface
    {
        $info = new Info();

        return $this
            ->view()
            ->render('info.twig', [
                'phpinfo' => $info->phpinfo(),
            ])
            ->to($this->response);
    }

    /**
     * Test your api page.
     *
     * @return ResponseInterface
     */
    public function test(): ResponseInterface
    {
        return $this
            ->view()
            ->render('test.twig', [
                'pageTitle' => 'Test your API',
            ])
            ->to($this->response);
    }
}
