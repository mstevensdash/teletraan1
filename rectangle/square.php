<?php


/**
 * Coordinate object
 * X, Y Coordinate on grid
 */
class coords {
  private $x;
  private $y;

  public function __construct(int $x, int $y) {
    $this->x = $x;
    $this->y = $y;
  }

  public function x():int {
    return $this->x;
  }
  public function y():int {
    return $this->y;
  }

  public function print():string {
    return "x: {$this->x()}, y: {$this->y()}";
  }
}


class square {

  private $coord1;
  private $coord2;

  public function __construct(coords $coord1, coords $coord2) {
    // ** There is no validate to ensure coord2 is to the right of coord1
    $this->coord1 = $coord1;
    $this->coord2 = $coord2;
  }

  public function coord1():coords {
    return $this->coord1;
  }
  public function coord2():coords {
    return $this->coord2;
  }
  public function print():string {
    return $this->coord1()->print() . "->" . $this->coord2->print();
  }

  /**
   * Return the area defined square takes up on the grid.
   * @return int
   */
  public function area():int {
    return ($this->coord2()->x() - $this->coord1()->x()) * ($this->coord2()->y() - $this->coord1()->y());
  }
}
