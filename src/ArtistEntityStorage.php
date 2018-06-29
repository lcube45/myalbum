<?php

namespace Drupal\myalbum;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class ArtistEntityStorage extends SqlContentEntityStorage implements ArtistEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(ArtistEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {artist_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {artist_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(ArtistEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {artist_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('artist_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
