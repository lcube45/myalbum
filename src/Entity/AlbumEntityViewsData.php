<?php

namespace Drupal\myalbum\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Album entities.
 */
class AlbumEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
