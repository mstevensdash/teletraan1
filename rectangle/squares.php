<?php

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

  private function lineOverlap(int $sqr1A, int $sqr1B, int $sqr2A, $sqr2B): int {

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
