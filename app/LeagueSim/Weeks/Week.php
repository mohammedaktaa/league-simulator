<?php


namespace App\LeagueSim\Weeks;


use App\LeagueSim\Matches\Match;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Mixed_;

abstract class Week
{
    protected string $description;
    protected int $number;
    protected Collection $matches;
    protected $id, $played;

    public function run()
    {
        foreach ($this->matches as $match) {
            $match->play();
        }

        $this->played = 1;
    }

    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPlayed()
    {
        return $this->played;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }
}
