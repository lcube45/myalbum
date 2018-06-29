<?php

namespace Drupal\myalbum;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\myalbum\Entity\ArtistEntityInterface;

/**
 * Defines the storage handler class for Artist entities.
 *
 * This extends the base storage class, adding required special handling for
 * Artist entities.
 *
 * @ingroup myalbum
 */
interface ArtistEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Artist revision IDs for a specific Artist.
   *
   * @param \Drupal\myalbum\Entity\ArtistEntityInterface $entity
   *   The Artist entity.
   *
   * @return int[]
   *   Artist revision IDs (in ascending order).
   */
  public function revisionIds(ArtistEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Artist author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Artist revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\myalbum\Entity\ArtistEntityInterface $entity
   *   The Artist entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(ArtistEntityInterface $entity);

  /**
   * Unsets the language for all Artist with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
