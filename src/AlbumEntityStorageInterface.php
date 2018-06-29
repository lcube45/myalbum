<?php

namespace Drupal\myalbum;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\myalbum\Entity\AlbumEntityInterface;

/**
 * Defines the storage handler class for Album entities.
 *
 * This extends the base storage class, adding required special handling for
 * Album entities.
 *
 * @ingroup myalbum
 */
interface AlbumEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Album revision IDs for a specific Album.
   *
   * @param \Drupal\myalbum\Entity\AlbumEntityInterface $entity
   *   The Album entity.
   *
   * @return int[]
   *   Album revision IDs (in ascending order).
   */
  public function revisionIds(AlbumEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Album author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Album revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\myalbum\Entity\AlbumEntityInterface $entity
   *   The Album entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(AlbumEntityInterface $entity);

  /**
   * Unsets the language for all Album with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
