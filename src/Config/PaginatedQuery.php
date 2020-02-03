<?php


namespace App\Config;


use http\QueryString;
use Pagerfanta\Adapter\AdapterInterface;

class PaginatedQuery implements AdapterInterface
{

    private $pdo;
    private $query;
    private $countQueries;

    /**
     * PaginatedQuery constructor.
     * @param \PDO $pdo
     * @param string $query : query that allows to get a number of results
     * @param QueryString $countQueries : number of results from the query
     */

    public function __construct($pdo, string $query, string $countQueries)
    {
        $this->pdo = $pdo;
        $this->query = $query;
        $this->countQueries = $countQueries;
    }

    /**
     * Returns the number of results.
     *
     * @return integer The number of results.
     */
    public function getNbResults(): int
    {
        // TODO: Implement getNbResults() method.

        return $this->pdo->query($this->countQueries)->fetchColumn();
    }

    /**
     * Returns an slice of the results.
     *
     * @param integer $offset The offset.
     * @param integer $length The length.
     *
     * @return array|\Traversable The slice.
     */
    public function getSlice($offset, $length)
    {
        $offset = (int) $offset;
        $length = (int) $length;
        $statement = $this->pdo->prepare($this->query . ' LIMIT ?,?;');
        $statement->execute([$offset, $length]);

        return $statement->fetchAll();
        // TODO: Implement getSlice() method.

    }
}