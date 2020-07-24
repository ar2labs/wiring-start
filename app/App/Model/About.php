<?php

namespace App\Model;

use Carbon\Carbon;

class About extends FakeModel
{
    /** @var string $title */
    private $title;

    /** @var string $description */
    private $description;

    /** @var string $url */
    private $url;

    /** @var string $author */
    private $author;

    /** @var string $email */
    private $email;

    /** @var string $location */
    private $location;

    /**
     * About Me constructor.
     */
    public function __construct()
    {
        $this
            ->setTitle('Wiring Starter')
            ->setDescription('An PHP Microframework with Interoperability.')
            ->setUrl('https://github.com/ar2labs/wiring.git')
            ->setAuthor('AR2 Labs')
            ->setEmail('ar2labs@gmail.com')
            ->setLocation('Maringa / PR, Brazil')
            ->setCreated(Carbon::now())
            ->setUpdated(Carbon::now());
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return About
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return About
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return About
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return About
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return About
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return About
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Convert data to array.
     *
     * @return array<string, \DateTime|string>
     */
    public function toArray()
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'url' => $this->getUrl(),
            'author' => $this->getAuthor(),
            'email' => $this->getEmail(),
            'location' => $this->getLocation(),
            'created' => $this->getCreated(),
        ];
    }
}
