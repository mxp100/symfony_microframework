<?php


namespace Framework;


use Dotenv\Dotenv;
use Dotenv\Repository\RepositoryBuilder;
use Framework\Contracts\EnvironmentContract;

class Environment implements EnvironmentContract
{

    protected $repository;

    public function __construct()
    {
        $this->repository = RepositoryBuilder::createWithDefaultAdapters()
            ->immutable()
            ->make();

        Dotenv::create(
            $this->repository,
            base_path(),
            '.env'
        )->load();
    }

    /**
     * @inheritDoc
     */
    public function get($key, $default = null)
    {
        $value = $this->repository->get($key);
        if (is_null($value)) {
            return $default;
        } else {
            return $this->sanitize($value);
        }
    }

    /**
     * Sanitize value
     * @param $value
     * @return bool|mixed|string|null
     */
    protected function sanitize($value)
    {
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
            return $matches[2];
        }

        return $value;
    }
}