<?php

$localSquares = [
  new square(new coords(0, 1), new coords(3, 4)),
  new square(new coords(2, 0), new coords(4, 2)),
  new square(new coords(10, 1), new coords(14, 5)),
  new square(new coords(7, 1), new coords(9, 4)),
  new square(new coords(3, 1), new coords(11, 4)),
  new square(new coords(-5, -2), new coords(-1, 2)),
  new square(new coords(-2, 1), new coords(2, 5)),
  new square(new coords(-7, -4), new coords(0, 0)),
  new square(new coords(-7, -4), new coords(-4, 0)),
  new square(new coords(-20, -10), new coords(30, 10)),
  new square(new coords(5, -4), new coords(40, 1))
];


$indent = str_repeat(" ", 4);
for ($sq1Idx = 0; $sq1Idx < count($localSquares); $sq1Idx++) {

  $sqr1 = $localSquares[$sq1Idx];
  print PHP_EOL . "Square " . ($sq1Idx + 1) . " (" . $sqr1->print() . ")";
  for ($sq2Idx = 0; $sq2Idx < count($localSquares); $sq2Idx++) {
    if ($sq1Idx === $sq2Idx) {
      continue;
    }
    $sqr2 = $localSquares[$sq2Idx];
    print PHP_EOL . $indent . "Square " . ($sq2Idx + 1) . " (" . $sqr2->print() . ")";
    $squareIntersect = new squares($sqr1, $sqr2);
    print PHP_EOL . $indent . $indent . "Intersects?: " . $squareIntersect->intersectNice();
    print PHP_EOL . $indent . $indent . "Intersection: " . $squareIntersect->intersectArea()->print();
    print PHP_EOL . $indent . $indent . "Area: " . $squareIntersect->intersectArea()->area();

  }
}

print PHP_EOL;




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
/**
 * Class for evaluating 2 squares on a grid.
 *
 */
class squares {

  private $square1;
  private $square2;
  private $debug;

  public function __construct(square $sqr1, square $sqr2, bool $debug=false) {
    $this->square1 = $sqr1;
    $this->square2 = $sqr2;
    $this->debug = $debug;
  }

  /**
   * Do the squares have any intersection area on the grid
   * @return bool
   */
  public function intersect(): bool {

    /**
     * If both the X and the Y overlaps are positive, then the squares
     * share some area on the grid.
     */
    return ($this->overlapX() > 0) && ($this->overlapY() > 0);
  }

  /**
   * Return a simple YES/NO
   * @return string
   */
  public function intersectNice():string {
    return ($this->intersect() ? "YES" : "NO");
  }

  /**
   * Create a new square that is the defined intersected area.
   * If the two squares do not overlap, then return an square with 0 area.
   * @return square
   */
  public function intersectArea():square {
    if ($this->intersect()) {
      /*
       * Define coordinate one of the intersected area.
       * The lower right coordinate
       *
       * X value is the maximum X value for coordinate 1 of the two squares
       * Y value is the maximum Y value for coordinate 1 of the two squares
       *
       */
      $areaCoord1 = new coords(
        max(
          $this->square1->coord1()->x(),
          $this->square2->coord1()->x()
        ),
        max(
          $this->square1->coord1()->y(),
          $this->square2->coord1()->y()
        )
      );

      /**
       * The upper right coordinate
       *
       * X value is the minimum X value for the right defined coordinate
       * Y value is the minimum Y value for the right defined coordinate
       */
      $areaCoord2 = new coords(
        min(
          $this->square1->coord2()->x(),
          $this->square2->coord2()->x()
        ),
        min(
          $this->square1->coord2()->y(),
          $this->square2->coord2()->y()
        )
      );
      return new square($areaCoord1, $areaCoord2);
    }
    return new square(new coords(0, 0), new coords(0, 0));
  }

  private function lineOverlap(int $sqr1A, int $sqr1B, int $sqr2A, int $sqr2B): int {

    /**
     * The goal here is to evaluate the lines on the assumed plane and return
     * the distance they share.
     *
     */
    // * Find total line coverage
    $ttlWidth = max($sqr1B, $sqr2B) - min($sqr1A, $sqr2A);
    $this->printDebug("\nttlWidth: " . $ttlWidth);


    $overlapB = max($sqr2B, $sqr1B) - min($sqr2B, $sqr1B);
    $this->printDebug("\novB: " . $overlapB);

    $overlapA = max($sqr2A, $sqr1A) - min($sqr2A, $sqr1A);
    $this->printDebug("\novA: " . $overlapA);


    return $ttlWidth - $overlapB - $overlapA;
  }

  private function overlapX(): int {
    $this->printDebug("\nX");

    return $this->lineOverlap(
      $this->square1->coord1()->x(),
      $this->square1->coord2()->x(),
      $this->square2->coord1()->x(),
      $this->square2->coord2()->x()
    );
  }

  private function overlapY(): int {
    $this->printDebug("\nY");
    return $this->lineOverlap(
      $this->square1->coord1()->y(),
      $this->square1->coord2()->y(),
      $this->square2->coord1()->y(),
      $this->square2->coord2()->y()
    );

  }
  private function printDebug(string $str):void {
    if ($this->debug) {
      print $str;
    }
  }
}
